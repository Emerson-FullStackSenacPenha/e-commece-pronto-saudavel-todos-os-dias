<?php

require_once __DIR__ . "/../partials/exibir-produtos.php";

require_once __DIR__ . "/../partials/todos-produtos.php";
?>



<section class="produtos_pronto_saudavel">

    <h2 class="titulo">Tortas</h2>

    <div class="product-grid">
        <?php exibirProdutos($conexao, $template_card, $baseUrl, "torta"); ?>
    </div>

</section>

