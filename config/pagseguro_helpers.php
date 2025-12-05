<?php
// config/pagseguro_helper.php

function ps_log($msg) {
    $file = __DIR__ . "/pagseguro.log";
    // tenta escrever no arquivo de log, mas não trava se der erro
    @file_put_contents($file, "[".date("Y-m-d H:i:s")."] ".$msg."\n", FILE_APPEND);
}

function ps_api_request($method, $url, $token, $data = null) {

    $headers = [
        "Authorization: Bearer {$token}",
        "Content-Type: application/json; charset=utf-8",
        "Accept: application/json"
    ];

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_CUSTOMREQUEST  => strtoupper($method),
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 15,
        CURLOPT_TIMEOUT        => 30
    ]);

    // SSL local (somente se precisar)
    if (strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    }

    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    $status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return [
            "status" => 500,
            "body"   => ["error" => $error]
        ];
    }

    curl_close($ch);

    $decoded = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return [
            "status" => 500,
            "body" => [
                "error" => "JSON inválido",
                "raw"   => $response
            ]
        ];
    }

    return [
        "status" => $status,
        "body"   => $decoded
    ];
}
