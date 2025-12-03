<?php

require_once __DIR__ . "/../partials/exibirOutrosProdutos.php"; // <- arquivo da função
require_once __DIR__ . "/../partials/todos-produtos.php";

?>

<section class="produtos_pronto_saudavel">
    <h2 class="titulo">Todos os Produtos (Exceto Marmitas)</h2>

    <main class="product-grid">
        <?php exibirProdutosExcetoMarmitas($conexao, $template_card, $baseUrl); ?>
    </main>
    
</section>

