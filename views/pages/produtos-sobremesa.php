<?php

require_once __DIR__ . "/../partials/exibir-produtos.php";

require_once __DIR__ . "/../partials/todos-produtos.php";
?>

<h2 class="titulo">Sobremesas</h2>

<main class="product-grid">
    <?php exibirProdutos($conexao, $template_card, $baseUrl, "sobremesa"); ?>
</main>

