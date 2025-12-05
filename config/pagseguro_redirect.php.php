<?php
// config/checkout_return.php  (arquivo 5/8 — adaptar se tiver nome diferente)
require_once __DIR__ . '../../app/core/Session.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
};

$config = require __DIR__ . '/pagseguro.php';
require_once __DIR__ . '/pagseguro_helpers.php';

$checkoutId = $_GET['checkout_id'] ?? null;
$reference  = $_GET['reference_id'] ?? null;

$status = null;

if ($checkoutId) {

    $baseUrl = ($config['environment'] === "production")
        ? "https://api.pagseguro.com"
        : "https://sandbox.api.pagseguro.com";

    $url = $baseUrl . "/checkouts/" . urlencode($checkoutId);

    $response = ps_api_request("GET", $url, $config['token']);

    if (in_array($response["status"] ?? 500, [200,201])) {

        $data = $response["body"] ?? [];

        $status =
            $data["status"]
            ?? ($data["payment"]["status"] ?? null);

        ps_log("✅ Checkout: " . json_encode([
            "checkout_id"=>$checkoutId,
            "reference"=>$reference,
            "status"=>$status
        ]));
    }
}

$redirect = "https://prontoesaudavel.infinityfree.me/".
            "?reference=".urlencode($reference).
            "&checkout=".urlencode($checkoutId).
            "&status=".urlencode($status);

header("Location: {$redirect}");
exit;
