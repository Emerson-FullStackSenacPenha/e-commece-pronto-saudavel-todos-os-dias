<?php
// /public/pagseguro_redirect.php
session_start();

// Ajuste o caminho de require conforme sua estrutura:
require_once __DIR__ . '/PagSeguroController.php';

// Proteção mínima: verifique se método POST (o botão de finalizar deve enviar POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Método não permitido.');
}

// Verifique se existe carrinho
if (empty($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
    die('Carrinho vazio.');
}

// Valide os dados do cliente — aqui assumimos que o front enviou nome, email e telefone via POST
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$telefone = preg_replace('/\D/', '', $_POST['telefone'] ?? '');

// Se os dados forem enviados por outra página, adapte (ex.: cliente já logado, etc.)
if (empty($nome) || empty($email) || strlen($telefone) < 8) {
    // Em projetos reais, redirecione de volta para o formulário com erro
    die('Dados do comprador incompletos. Preencha nome, email e telefone corretamente.');
}

// Monta o pedido
$order = [
    'reference' => 'PEDIDO_' . time(),
    'sender' => [
        'name' => $nome,
        'email' => $email,
        'areaCode' => substr($telefone, 0, 2),
        'phone' => substr($telefone, 2)
    ],
    'items' => []
];

foreach ($_SESSION['carrinho'] as $produto) {
    // assegure-se que cada produto contém id, nome, preco e quantidade
    $id = isset($produto['id']) ? (string)$produto['id'] : null;
    $nomeProduto = isset($produto['nome']) ? (string)$produto['nome'] : 'Produto';
    $preco = isset($produto['preco']) ? (float)$produto['preco'] : 0.0;
    $quant = isset($produto['quantidade']) ? (int)$produto['quantidade'] : 1;

    if ($preco <= 0) {
        die('Preço inválido em um dos produtos.');
    }

    $order['items'][] = [
        'id' => $id,
        'description' => $nomeProduto,
        'amount' => number_format($preco, 2, '.', ''),
        'quantity' => $quant
    ];
}

try {
    $pagseguro = new PagSeguroController();
    $redirectUrl = $pagseguro->createCheckout($order);

    // Opcional: salvar no banco um registro do pedido com reference e checkout url
    // TODO: coloque aqui sua lógica de persistência (pedidos, status, uuid, etc.)

    header("Location: " . $redirectUrl);
    exit;
} catch (Exception $e) {
    error_log("Erro PagSeguro: " . $e->getMessage());
    // Em produção, mostre uma mensagem amigável e não exponha detalhes
    die("Erro ao processar pagamento: " . htmlspecialchars($e->getMessage()));
}
