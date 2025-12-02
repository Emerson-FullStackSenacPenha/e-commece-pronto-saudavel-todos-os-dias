<?php
session_start();

require_once __DIR__ . '/PagSeguroController.php';

// 1. Verifica se o carrinho existe
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    die("Carrinho vazio!");
}

// 2. Monta o array que será enviado
$order = [
    'reference' => 'PEDIDO_' . time(),
    'sender' => [
        'name' => $_POST['nome'],
        'email' => $_POST['email'],
        'areaCode' => substr($_POST['telefone'], 0, 2),
        'phone' => substr($_POST['telefone'], 2)
    ],
    'items' => []
];

// 3. Adiciona os produtos do carrinho
foreach ($_SESSION['carrinho'] as $produto) {
    $order['items'][] = [
        'id' => $produto['id'],
        'description' => $produto['nome'],
        'amount' => $produto['preco'],
        'quantity' => $produto['quantidade']
    ];
}

// 4. Envia para o PagSeguro
$pagseguro = new PagSeguroController();
$urlPagamento = $pagseguro->createCheckout($order);

// 5. Redireciona o cliente
header("Location: " . $urlPagamento);
exit;
