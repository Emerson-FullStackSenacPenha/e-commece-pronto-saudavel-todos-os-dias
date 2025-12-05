<?php
// config/FinalizarCompraController.php

require_once __DIR__ . '../../app/core/Session.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
};

$config = require __DIR__ . '/pagseguro.php';
require_once __DIR__ . '/PagSeguroController.php';
require_once __DIR__ . '/pagseguro_helpers.php';

header("Content-Type: application/json; charset=utf-8");

$nome  = $_POST["nome"]  ?? null;
$email = $_POST["email"] ?? null;
$items = $_POST["items"] ?? null;

if (!$nome || !$email) {
    http_response_code(400);
    echo json_encode(["error"=>"Nome e email obrigatórios"]);
    exit;
}

$items = json_decode($items,true);

if (!is_array($items)) {
    http_response_code(400);
    echo json_encode(["error"=>"Itens inválidos"]);
    exit;
}

// Garantir tipagem correta e valores default
foreach ($items as &$item) {
    $item["quantity"]    = intval($item["quantity"] ?? 1);
    $item["unit_amount"] = intval($item["unit_amount"] ?? 0);
}

// referência do pedido
$reference_id = "pedido-" . time();

// payload
$payload = [
    "reference_id" => $reference_id,
    "customer" => [
        "name"  => $nome,
        "email" => $email
    ],
    "items" => $items,
    "notification_urls" => [
        // manter URL original
        "https://prontoesaudavel.infinityfree.me/config/pagseguro_notification.php"
    ]
];

$pg = new PagSeguroController($config);
$response = $pg->criarCheckout($payload);

// Buscar link PAY
$link = null;

$body = $response["body"] ?? [];

if (!empty($body["links"]) && is_array($body["links"])) {
    foreach ($body["links"] as $l) {
        if (($l["rel"] ?? "") === "PAY") {
            $link = $l["href"];
            break;
        }
    }
}

$status = $response["status"] ?? 500;

if ($link && in_array($status, [200,201])) {

    $_SESSION["pedido_temp"]["reference_id"] = $reference_id;

    echo json_encode([
        "ok"           => true,
        "payment_url"  => $link,
        "reference_id" => $reference_id
    ]);
    exit;
}

http_response_code(500);
echo json_encode($body);
exit;
