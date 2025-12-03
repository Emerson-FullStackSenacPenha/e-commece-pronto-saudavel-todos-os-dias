<?php

    require_once __DIR__ . '/../../app/core/DataBaseConecta.php'; 
    require_once __DIR__ . '/../../app/Controllers/Admin/ProductAdminController.php';

    $erro = null;

    $termo = $GET['busca'];
    $dados = [];
    try {
        $dados = buscarProdutos($conexao, $termo);
    } catch(Throwable $e) {
        $erro = "Erro ao fazer busca no sistema .<br>".$e->getMessage();
    }

?>

<section class="produtos_buscados">


    <?php foreach($dados as $produto): ?>

     <article class="product-card--horizontal">

      
       <h4><?= $produto['nome'] ?></h4>
       <p><?= $produto['descricao'] ?></p>
       <p><?= $produto['valor'] ?></p>
         
     </article>

    <?php endforeach; ?>
</section>