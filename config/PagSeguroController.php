<?php
// /app/controllers/PagSeguroController.php


class PagSeguroController
{
    private $config;

    public function __construct()
    {
        $this->config = require_once __DIR__ . '/pagseguro.php';

    }

    private function isSandbox()
    {
        return !empty($this->config['sandbox']);
    }

    private function getEndpointCreate()
    {
        return $this->isSandbox()
            ? $this->config['endpoints']['sandbox']['create_checkout']
            : $this->config['endpoints']['production']['create_checkout'];
    }

    private function getPaymentPageUrl($code)
    {
        return ($this->isSandbox()
            ? $this->config['endpoints']['sandbox']['payment_page']
            : $this->config['endpoints']['production']['payment_page']) . urlencode($code);
    }

    /**
     * Monta dados do POST no formato de formulário do PagSeguro (v2).
     * $order = [
     *   'reference' => 'ORDER123',
     *   'sender' => ['name'=>'Ana', 'email'=>'ana@ex.com', 'areaCode'=>'11','phone'=>'999999999'],
     *   'items' => [
     *       ['id'=>'1','description'=>'Produto A','amount'=>'100.00','quantity'=>1],
     *       ...
     *   ]
     * ]
     */
    public function createCheckout(array $order)
    {
        $email = $this->config['email'] ?? null;
        $token = $this->config['token'] ?? null;
        if (empty($email) || empty($token)) {
            throw new Exception("Configuração do PagSeguro incompleta (email/token).");
        }

        if (empty($order['items']) || !is_array($order['items'])) {
            throw new Exception("Pedido inválido: sem itens.");
        }

        // Monta campos do body para o endpoint v2 (itemId1, itemDescription1, itemAmount1, itemQuantity1, etc)
        $postFields = [];
        $i = 1;
        foreach ($order['items'] as $item) {
            // validações mínimas por item
            $id = isset($item['id']) ? (string)$item['id'] : (string)$i;
            $description = isset($item['description']) ? (string)$item['description'] : 'Item ' . $i;
            $amount = isset($item['amount']) ? (float)$item['amount'] : 0.0;
            $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 1;

            if ($amount <= 0) {
                throw new Exception("Valor inválido para o item {$i}.");
            }

            $postFields["itemId{$i}"] = $id;
            $postFields["itemDescription{$i}"] = $description;
            // O PagSeguro espera amount com 2 decimais e ponto decimal (ex: 100.00)
            $postFields["itemAmount{$i}"] = number_format($amount, 2, '.', '');
            $postFields["itemQuantity{$i}"] = $quantity;
            $i++;
        }

        // Dados do comprador (opcional, mas recomendado)
        if (!empty($order['sender'])) {
            $sender = $order['sender'];
            if (!empty($sender['name'])) {
                $postFields['senderName'] = (string)$sender['name'];
            }
            if (!empty($sender['email'])) {
                $postFields['senderEmail'] = (string)$sender['email'];
            }
            if (!empty($sender['areaCode'])) {
                $postFields['senderAreaCode'] = preg_replace('/\D/', '', (string)$sender['areaCode']);
            }
            if (!empty($sender['phone'])) {
                $postFields['senderPhone'] = preg_replace('/\D/', '', (string)$sender['phone']);
            }
        }

        // Referência própria para identificar a venda no seu sistema
        if (!empty($order['reference'])) {
            $postFields['reference'] = (string)$order['reference'];
        }

        // Currency
        $postFields['currency'] = 'BRL';

        // Credenciais via querystring (email + token)
        $endpoint = $this->getEndpointCreate() . '?email=' . urlencode($email) . '&token=' . urlencode($token);

        // cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Obs: API v2 aceita application/x-www-form-urlencoded
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded; charset=UTF-8']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        // Forçar verificação SSL (mantenha true em produção)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false || $httpCode >= 400) {
            throw new Exception("Erro ao comunicar com PagSeguro: HTTP {$httpCode} - {$err}");
        }

        // A resposta do v2 é XML contendo <code>...codigo...</code>
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($response);
        if ($xml === false) {
            throw new Exception("Resposta inválida do PagSeguro: {$response}");
        }

        // Verifica se existe tag <error>
        if (isset($xml->error)) {
            // Pode conter vários erros
            $errMsg = [];
            foreach ($xml->error as $e) {
                // Em v2 o erro pode ter <message>
                $msg = isset($e->message) ? (string)$e->message : (string)$e;
                $errMsg[] = trim($msg);
            }
            throw new Exception("PagSeguro retornou erro(s): " . implode('; ', $errMsg));
        }

        $code = (string)$xml->code;
        if (empty($code)) {
            throw new Exception("Não foi possível obter o código de checkout. Resposta: {$response}");
        }

        // Retorna URL de redirecionamento
        return $this->getPaymentPageUrl($code);
    }
}
