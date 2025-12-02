<?php

require_once __DIR__ . "/../partials/exibir-produtos.php";

require_once __DIR__ . "/../partials/todos-produtos.php";
?>

<section class="produtos_pronto_saudavel">

    <h2 class="titulo">Sopas</h2>

    <main class="product-grid">
        <?php exibirProdutos($conexao, $template_card, $baseUrl, "sopa"); ?>
    </main>

</section>

