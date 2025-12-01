<?php
// Certifique-se de que a sessão está iniciada em todas as páginas
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
// Variável para verificar se o usuário está logado
$usuario_logado = isset($_SESSION["user_nome"]);

// Se estiver logado, armazene o nome para uso mais fácil
$nome_usuario = $usuario_logado ? $_SESSION["user_nome"] : '';
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap">

<!-- Desktop -->
<header id="desktop">

    <!-- Começo do menu -->
    <div id="menu">

        <div id="logo_busca">

            <!-- Logo -->
            <a id="logo" href="<?= $baseUrl ?>/public/index.php?page=home"></a>


            <!-- Barra de pesquisa -->
            <div id="busca">
                <input type="text" placeholder="🔍">
            </div>

        </div>

        <!-- Icones -->
        <nav id="icons">

            <ul id="lista_icons">

                <li>
                    <a href="<?= $baseUrl ?>/public/index.php?page=personalChefe">
                        <div id="chefinho"></div>
                    </a>
                </li>

                <li>
                    <a href="">
                        <div id="entrega"></div>
                    </a>
                </li>

                <li>
                    <a href="<?= $baseUrl ?>/public/index.php?page=carrinho_de_compras">
                        <div id="compras"></div>
                    </a>
                </li>

                <li>

                    <?php if ($usuario_logado): ?>

                        <a id="nome_logado" href="/e-commece-pronto-saudavel-todos-os-dias/views/pages/auth/logado.php">Olá, <?= htmlspecialchars($nome_usuario) ?></a>
                        <a id="sair" href="/e-commece-pronto-saudavel-todos-os-dias/views/pages/auth/logout.php">Sair</a>

                    <?php else: ?>
                        <a href="/e-commece-pronto-saudavel-todos-os-dias/views/pages/auth/login.php">
                            <div id="usuario"></div>
                        </a>
                    <?php endif; ?>

                </li>

            </ul>

        </nav>

        <!-- Fim do menu -->
    </div>

    <!-- Navegador -->
    <nav id="nav">

        <ul id="lista_nav">

            <li><a href="<?= $baseUrl ?>/public/index.php?page=home">Inicio</a></li>
            <li><a href="<?= $baseUrl ?>/public/index.php?page=personalChefe">Personal Chefe</a></li>
            <li class="marmitaSubmenu">
                <a href="<?= $baseUrl ?>/public/index.php?page=produtos">Marmitas</a>

                <ul class="submenuMarmita">
                    <li><a href="#marmita-fit">Fitness</a></li>
                    <li><a href="#marmita-vegan">Low Carb</a></li>
                    <li><a href="#kits">Vegana</a></li>
                </ul>

            </li>
            <li class="produtosSubmenu">
                <a href="">Outros Produtos</a>

                <ul class="submenuProdutos">
                    <li><a href="">Caldo</a></li>
                    <li><a href="">Temperos</a></li>
                    <li><a href="">Torta</a></li>
                    <li><a href="">Sopa</a></li>
                    <li><a href="">Sobremesa</a></li>
                    <li><a href="">Sucos</a></li>
                </ul>

            </li>
            <li>Quem Somos</li>

        </ul>

    </nav>

</header>


<!-- Mobile -->
<header id="mobile">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <div id="menu">

        <div id="logo_busca">

            <!-- Logo -->
            <a id="logo" href="<?= $baseUrl ?>/public/index.php?page=home"></a>

            <!-- Barra de pesquisa -->
            <div id="busca">
                <input type="text" placeholder="🔍">
            </div>

        </div>

        <div id="hamburguer">

            <button class="hamburger-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" aria-label="Abrir menu">

                <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 -960 960 960">
                    <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                </svg>

            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">

                <div class="offcanvas-header">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <!-- Itens do menu -->
                <div class="offcanvas-body">

                    <ul class="lista_hamburguer">



                        <?php if ($usuario_logado): ?>
                            <a href="#"> <span id="nome_usuario_logado">Olá, <?= htmlspecialchars($nome_usuario) ?></span> </a>
                            <a href="/e-commece-pronto-saudavel-todos-os-dias/views/pages/auth/logout.php" class="btn">Sair</a>
                        <?php else: ?>
                            <li><a href="/e-commece-pronto-saudavel-todos-os-dias/views/pages/auth/login.php">Entrar</a></li>
                            <li><a href="/e-commece-pronto-saudavel-todos-os-dias/views/pages/auth/register.php">Cadastrar</a></li>
                        <?php endif; ?>

                    </ul>
                    <hr>
                    <ul class="lista_hamburguer">

                        <li><a href="<?= $baseUrl ?>/public/index.php?page=home">Inicio</a></li>
                        <li><a href="<?= $baseUrl ?>/public/index.php?page=personalChefe">Personal Chefe</a></li>
                        <li><a href="">Entregas</a></li>
                        <li><a href="<?= $baseUrl ?>/public/index.php?page=carrinho_de_compras">Carrinho de Compras</a></li>
                        <li><a href="<?= $baseUrl ?>/public/index.php?page=produtos">Marmitas</a></li>
                        <li><a href="">Outros Produtos</a></li>
                        <li><a href="">Quem Somos</a></li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</header>

<main>