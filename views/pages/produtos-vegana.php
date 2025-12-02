<?php

require_once __DIR__ . "/../partials/exibir-produtos.php";

require_once __DIR__ . "/../partials/todos-produtos.php";
?>

<h2 class="titulo">Produtos Veganos</h2>

<section>


    <div class="product-grid">
        <?php exibirProdutos($conexao, $template_card, $baseUrl, "veg"); ?>
    </div>
</section>

