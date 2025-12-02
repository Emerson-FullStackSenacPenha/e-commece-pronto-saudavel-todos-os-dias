<?php
// /app/config/pagseguro.php

return [
    // TRUE para ambiente de testes (sandbox), FALSE para produção
    'sandbox' => true,

    // Email da conta do PagSeguro (vendedor)
    'email' => 'guilhermeamorimrochalima@gmail.com',

    // Cole seu token aqui (gerado no PagSeguro). NÃO comite isso em repositórios públicos.
    'token' => 'eb7594c4-8465-4b32-9ad3-ff23e0d844430a41b8ac4b4e90e0d9c51339629ec1deb155-9b74-4e2f-acfb-7efa9eadf0a0',

    // URLs
    'endpoints' => [
        'sandbox' => [
            'create_checkout' => 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout',
            'payment_page'    => 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code='
        ],
        'production' => [
            'create_checkout' => 'https://ws.pagseguro.uol.com.br/v2/checkout',
            'payment_page'    => 'https://pagseguro.uol.com.br/v2/checkout/payment.html?code='
        ],
    ],
];
