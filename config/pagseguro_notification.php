<?php
// config/pagseguro_notification.php

require_once __DIR__ . '/pagseguro_helpers.php';
require_once __DIR__ . '/../app/core/DataBaseConecta.php';

$raw = file_get_contents("php://input");
ps_log("🔔 NOTIFICAÇÃO: ".$raw);

$data = json_decode($raw, true);

if (!$data) {
    parse_str($raw, $data);
}

$reference =
       $data["reference_id"]
    ?? $data["reference"]
    ?? null;

$status_pagamento =
       $data["payment_statuses"][0]["status"]
    ?? $data["status"]
    ?? null;

if (!$reference) {
    ps_log("❌ Sem reference_id");
    http_response_code(400);
    exit;
}

// Normaliza status
$status_pagamento = strtolower((string)$status_pagamento);

// Mapeamento
$status_final = "pendente";

switch ($status_pagamento) {
    case "paid":
    case "approved":
        $status_final = "pago";
        break;

    case "declined":
    case "canceled":
        $status_final = "cancelado";
        break;

    case "analysis":
    case "in_analysis":
        $status_final = "analise";
        break;
}

// Garante que temos uma conexão PDO em $conexao (ou $conn)
if (!isset($conexao) && isset($conn) && is_object($conn)) {
    // se DataBaseConecta definir $conn apenas, usamos como compat
    $conexao = $conn;
}

if (!isset($conexao) || !is_object($conexao)) {
    ps_log("❌ Conexão com DB inexistente");
    http_response_code(500);
    exit;
}

try {
    $stmt = $conexao->prepare("
       UPDATE pedido
       SET status = ?
       WHERE reference_id = ?
    ");

    if (!$stmt) {
        ps_log("❌ Prepare falhou ao atualizar pedido: " . json_encode($conexao->errorInfo()));
        http_response_code(500);
        exit;
    }

    $stmt->execute([$status_final, $reference]);

    if ($stmt->rowCount() === 0) {
        ps_log("⚠️ Pedido não encontrado ou já estava com mesmo status: {$reference}");
    } else {
        ps_log("💾 Pedido atualizado {$reference} → {$status_final}");
    }

    http_response_code(200);
    echo "OK";
    exit;

} catch (PDOException $e) {
    ps_log("❌ Erro PDO ao atualizar pedido: " . $e->getMessage());
    http_response_code(500);
    exit;
}
