<?php 
    require_once '../../config/config.php';
?>
    <h1>Administrador/Gestor</h1>
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/administracaoPainel.css">
    <div class="administracao">

        <a href="<?= BASE_URL ?>/views/admin/listarPedidos.php" class="blocos">
            <img src="https://cdn-icons-png.flaticon.com/512/3183/3183463.png" alt="Pedidos">
            <span>Pedidos</span>
        </a>

        <a href="<?= BASE_URL ?>/views/admin/listarProdutos.php" class="blocos">
            <img src="https://cdn-icons-png.flaticon.com/512/3514/3514491.png" alt="Produtos">
            <span>Produtos</span>
        </a>

    </div>

