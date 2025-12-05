<?php
// config/PagSeguroController.php

require_once __DIR__ . '/pagseguro_helpers.php';

class PagSeguroController {

    private $token;
    private $environment;
    private $baseUrl;

    public function __construct($config) {

        if (!is_array($config)) {
            throw new Exception("Config inválido para PagSeguroController");
        }

        $this->token       = $config["token"] ?? null;
        $this->environment = $config["environment"] ?? 'sandbox';

        if (!$this->token) {
            throw new Exception("Token do PagSeguro não configurado");
        }

        $this->baseUrl = ($this->environment === "production")
            ? "https://api.pagseguro.com"
            : "https://sandbox.api.pagseguro.com";
    }

    public function criarCheckout($pedido) {

        $url = $this->baseUrl . "/checkouts";

        ps_log("📤 Enviando checkout: " . json_encode($pedido));

        $result = ps_api_request("POST", $url, $this->token, $pedido);

        if (!in_array($result["status"] ?? 500, [200,201])) {
            ps_log("❌ ERRO API: " . json_encode($result));
        }

        return $result;
    }
}
