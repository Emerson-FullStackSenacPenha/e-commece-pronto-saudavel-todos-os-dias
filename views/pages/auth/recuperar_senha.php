<?php
// views/pages/auth/recuperar_senha.php

// AQUI ESTÁ O TRUQUE DA SIMULAÇÃO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    $codigoGerado = solicitarRecuperacaoSenha($conexao, $email);
    
    if ($codigoGerado) {
        // SIMULAÇÃO: Em vez de enviar e-mail, mostramos um alert com o código
        // e redirecionamos para a tela de nova senha levando o email na URL
        echo "<script>
                alert('SIMULAÇÃO DE EMAIL: Seu código é $codigoGerado');
                window.location.href = '" . BASE_URL . "/public/index.php?page=nova_senha&email=$email';
              </script>";
        exit;
    } else {
        // Mesmo que o email não exista, fingimos que enviamos para não revelar usuários cadastrados
        echo "<script>
                alert('Se o e-mail existir, um código foi enviado.');
                window.location.href = '" . BASE_URL . "/public/index.php?page=login';
              </script>";
        exit;
    }
}
?>

<div id="login-wrapper">
    <div class="login-container">
        <div class="topo">
            <a href="<?= BASE_URL ?>/public/index.php?page=login" class="bt-voltar">↩</a>
        </div>
        <h2>Recuperar Senha</h2>
        <p style="text-align:center; font-size:0.9em; margin-bottom:15px;">
            Digite seu e-mail para receber o código de verificação.
        </p>
        
        <form method="post" class="form-login">
            <div class="grupo-input">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" class="input-login" required>
            </div>
            
            <div class="dosBotoes">
                <button type="submit" class="btn-entrar">Enviar Código</button>
            </div>
        </form>
    </div>
</div>