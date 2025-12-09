<?php
// views/pages/auth/recuperar_senha.php

$mensagemFeedback = ""; // Variável para mostrar erros de envio na tela, se houver

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    // Chama sua função do User.php
    $codigoGerado = solicitarRecuperacaoSenha($conexao, $email);
    
    if ($codigoGerado) {
        
        // --- CONFIGURAÇÃO DO E-MAIL ---
        $para = $email;
        $assunto = "Recuperação de Senha - Pronto Saudável";
        
        // Corpo da mensagem
        $mensagem = "Olá!\n\n";
        $mensagem .= "Recebemos uma solicitação para redefinir sua senha.\n";
        $mensagem .= "Seu código de verificação é: " . $codigoGerado . "\n\n";
        $mensagem .= "Este código é válido por 15 minutos.";

        // Cabeçalhos (Headers) - Importante para acentuação e remetente
        // Dica: No XAMPP, o 'From' as vezes precisa ser igual ao email configurado no sendmail.ini
        $headers = "From: prontoesaudavel18@gmail.com" . "\r\n" .
                   "Reply-To: contato@prontosaudavel.com.br" . "\r\n" .
                   "Content-Type: text/plain; charset=UTF-8" . "\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        // --- TENTATIVA DE ENVIO ---
        // O @ na frente do mail() serve para suprimir avisos técnicos na tela se falhar
        if (@mail($para, $assunto, $mensagem, $headers)) {
            
            // SUCESSO: Redireciona para a página de digitar o código
            echo "<script>
                    alert('E-mail enviado com sucesso! Verifique sua caixa de entrada (e o Spam).');
                    window.location.href = '" . BASE_URL . "/public/index.php?page=nova_senha&email=$email';
                  </script>";
            exit;
            
        } else {
            // ERRO NO ENVIO: Geralmente erro de configuração do XAMPP
            $mensagemFeedback = "<div class='mensagem erro'>Erro ao enviar e-mail. Verifique sua conexão ou tente mais tarde.</div>";
        }
        
    } else {
        // E-MAIL NÃO ENCONTRADO NO BANCO
        // Por segurança, fingimos que deu certo para não revelar quem é cliente
        echo "<script>
                alert('Se este e-mail estiver cadastrado, você receberá um código em instantes.');
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







