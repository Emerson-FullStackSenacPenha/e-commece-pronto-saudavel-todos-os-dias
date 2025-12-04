<?php

    require_once __DIR__ . '/../../app/core/DataBaseConecta.php'; 
    require_once __DIR__ . '/../../app/Controllers/Admin/ProductAdminController.php';

    require_once __DIR__ . "/../partials/exibir_produtos_buscados.php";
    
    
    $erro = null;

    $termo = $_GET['busca'];
    $dados = [];

    try {

        $dados = buscarProdutos($conexao, $termo);

    } catch(Throwable $e) {
        $erro = "Erro ao fazer busca no sistema .<br>".$e->getMessage();
    }

?>

<section class="produtos_pronto_saudavel">

    <h2 class="titulo">Você procurou por <?= $termo ?> e obteve <?= count($dados)?> resultados</h2>
    

    <main class="product-grid">
        <?php foreach($dados as $produto): 

            exibirCardProdutosBuscados($produto['id'], 
            $produto['nome'], 
            $produto['valor'], // ou 'preco'
            $produto['imagem_url'], 
            $baseUrl);

        endforeach; ?>
    </main>
</section>