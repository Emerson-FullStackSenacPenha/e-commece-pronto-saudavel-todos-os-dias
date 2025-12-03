<?php

require_once __DIR__ . "/../partials/exibir-produtos.php";

require_once __DIR__ . "/../partials/todos-produtos.php";
?>



<section class="produtos_pronto_saudavel">

    <h2 class="titulo">Produtos Veganos</h2>

    <div class="product-grid">
        <?php exibirProdutos($conexao, $template_card, $baseUrl, "veg"); ?>
    </div>
    
</section>

