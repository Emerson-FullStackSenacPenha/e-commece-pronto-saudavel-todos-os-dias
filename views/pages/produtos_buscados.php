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

<section class="produtos_buscados">

    <h2>Você procurou por <?= $termo ?> e obteve <?php count($dados)?>resultados</h2>
    

    <?php foreach($dados as $produto): 

        exibirCardProdutosBuscados($produto['id'], 
        $produto['nome'], 
        $produto['valor'], // ou 'preco'
        $produto['imagem_url'], 
        $baseUrl);

    endforeach; ?>
</section>