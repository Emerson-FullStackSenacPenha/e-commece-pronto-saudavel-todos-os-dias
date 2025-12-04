<?php
//Usado para proteger a página, caso o usuário tente entrar direto, ele vai ser redirecionado para a página de login.
require_once '../../../app/core/Session.php';
// Verifica se o usuário está logado
verificaLogin();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Área Logada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #12602c;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        body::before {
            content: "";
            position: absolute;
            width: 100%;
            /* um pouco maior pra cobrir bordas após girar */
            height: 100%;
            background-image: url(../../../public/images/header_images/fundo_legumes.png);
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
</head>

<body>
    <div class="card">
        <h1>Seja bem-vindo, <?= htmlspecialchars($_SESSION["user_nome"], ENT_QUOTES, 'UTF-8'); ?>!</h1>
        <p>E ótimas compras</p>

        <div id="options">
            
            <a href="/e-commece-pronto-saudavel-todos-os-dias/public/index.php?page=home" class="btn1">Inicio</a>
            <a href="/e-commece-pronto-saudavel-todos-os-dias/public/index.php?page=produtos" class="btn1">Marmitas</a>
        </div>
    </div>
</body>

</html>