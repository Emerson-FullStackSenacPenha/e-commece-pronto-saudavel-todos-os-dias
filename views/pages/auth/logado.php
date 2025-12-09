<?php
    //Usado para proteger a página, caso o usuário tente entrar direto, ele vai ser redirecionado para a página de login.
    //require_once '../../../app/core/Session.php';

    // Verifica se o usuário está logado
    //verificaLogin();


?>

<div class="container-conteudo-padrao">
    
    <div class="card-login">
        <h1>Seja bem-vindo, <?= htmlspecialchars($_SESSION["user_nome"], ENT_QUOTES, 'UTF-8'); ?>!</h1>
        <p>E ótimas compras</p>

<<<<<<< Updated upstream
        body::before {
            content: "";
            position: absolute;
            width: 100%;
            /* um pouco maior pra cobrir bordas após girar */
            height: 100%;
            background-image: url(<?= BASE_URL ?>../public/images/header_images/fundo_legumes.png);
            z-index: -1;
            /* mantém a imagem atrás do conteúdo */
            opacity: 0.4;
            /* opcional, se quiser suavizar */
        }

        .card {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        #options {

            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;

        }

        .btn {
            background-color: #e63946;
            color: white;
            font-weight: 600;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: white;
            box-shadow: 0 0 0 2px #c82e3a;
            color: #c82e3a;
        }

        .btn1 {
            background-color: #12602c;
            color: white;
            font-weight: 600;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn1:hover {
            background-color: white;
            box-shadow: 0 0 0 2px #12602c;
            color: #12602c;
        }
    </style>
<div id="login-wrapper">
    <div id="login-wrapper">
        <div class="card">
            <h1>Seja bem-vindo, <?= htmlspecialchars($_SESSION["user_nome"], ENT_QUOTES, 'UTF-8'); ?>!</h1>
            <p>E ótimas compras</p>

            <div id="options">
                
                <a href="<?= BASE_URL ?>/public/index.php?page=home" class="btn1">Inicio</a>
                <?php if($ehAdmin): ?>
                    <a href="<?= BASE_URL ?>/public/index.php?page=painel_adm" class="btn1">Painel ADM</a>
                <?php else: ?>
                    <a href="<?= BASE_URL ?>/public/index.php?page=listar_produtos" class="btn1">Marmitas</a>
                <?php endif ?>
            </div>
=======
        <div class="opcoes-botoes">
            <a href="<?= BASE_URL ?>/public/index.php?page=home" class="btn-verde">Inicio</a>
            <a href="<?= BASE_URL ?>/public/index.php?page=painel_adm" class="btn-verde">Marmitas</a>
>>>>>>> Stashed changes
        </div>
    </div>

</div>