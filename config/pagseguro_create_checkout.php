<?php
// config/pagseguro_create_checkout.php
require_once __DIR__ . '../../app/core/Session.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
};


$config = require __DIR__ . '/pagseguro.php';
require_once __DIR__ . '/pagseguro_helpers.php';

header("Content-Type: application/json; charset=utf-8");

// ----------------------
// Ambiente
// ----------------------
$env = $config['environment'] ?? 'sandbox';

$baseUrl = ($env === "production")
    ? "https://api.pagseguro.com"
    : "https://sandbox.api.pagseguro.com";

$endpoint = $baseUrl . "/checkouts";

// ----------------------
// POST
// ----------------------
$nome     = $_POST['nome']  ?? null;
$email    = $_POST['email'] ?? null;
$valor    = $_POST['valor'] ?? null;
$itemsRaw = $_POST['items'] ?? null;

if (!$nome || !$email) {
    http_response_code(400);
    echo json_encode(["error" => "nome e email são obrigatórios"]);
    exit;
}

// ----------------------
// Itens
// ----------------------
$items = [];

if ($itemsRaw) {
    $decoded = json_decode($itemsRaw, true);

    if (is_array($decoded)) {
        foreach ($decoded as $it) {
            $items[] = [
                "name"        => $it["name"] ?? "Item",
                "quantity"    => intval($it["quantity"] ?? 1),
                "unit_amount" => intval($it["unit_amount"] ?? 0)
            ];
        }
    }
}

if (empty($items)) {

    $valorFinal = intval(round(floatval($valor) * 100));

    if ($valorFinal <= 0) {
        http_response_code(400);
        echo json_encode(["error" => "Valor inválido"]);
        exit;
    }

    $items[] = [
        "name"        => "Compra",
        "quantity"    => 1,
        "unit_amount" => $valorFinal
    ];
}

// ----------------------
// Reference
// ----------------------
$reference_id = "pedido-" . time() . "-" . rand(100, 999);

// ----------------------
// Payload
// ----------------------
$payload = [
    "reference_id" => $reference_id,
    "customer" => [
        "name"  => $nome,
        "email" => $email
    ],
    "items" => $items
];

// ----------------------
// API
// ----------------------
$result = ps_api_request("POST", $endpoint, $config["token"], $payload);

$status = $result["status"] ?? 500;
$body   = $result["body"] ?? [];

// ----------------------
// Captura segura do link PAY
// ----------------------
$paymentUrl = null;

if (!empty($body["links"]) && is_array($body["links"])) {
    foreach ($body["links"] as $link) {
        if (($link["rel"] ?? "") === "PAY") {
            $paymentUrl = $link["href"];
            break;
        }
    }
}

// ----------------------
// Sucesso
// ----------------------
if (in_array($status, [200,201]) && $paymentUrl) {

    $_SESSION["last_checkout"] = [
        "reference_id" => $reference_id,
        "payload"      => $payload,
        "response"     => $body
    ];

    echo json_encode([
        "ok"           => true,
        "payment_url"  => $paymentUrl,
        "reference_id" => $reference_id
    ]);
    exit;
}

// ----------------------
// Erro
// ----------------------
ps_log("❌ ERRO AO CRIAR CHECKOUT: " . json_encode($result));

http_response_code($status);

echo json_encode([
    "ok"    => false,
    "error" => $body
]);
exit;
