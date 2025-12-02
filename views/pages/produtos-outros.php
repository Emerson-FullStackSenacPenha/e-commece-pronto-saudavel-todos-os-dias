<?php

require_once __DIR__ . "/../partials/exibirOutrosProdutos.php"; // <- arquivo da função
require_once __DIR__ . "/../partials/todos-produtos.php";

?>

<h2 class="titulo">Todos os Produtos (Exceto Marmitas)</h2>

<main class="product-grid">
    <?php exibirProdutosExcetoMarmitas($conexao, $template_card, $baseUrl); ?>
</main>
