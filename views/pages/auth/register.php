<?php
//require_once __DIR__ . '/../../../app/core/DataBaseConecta.php';
//require_once __DIR__ . '/../../../app/models/User.php';


// 2. Inicialização de Variáveis (Inclui variáveis para pré-preenchimento do formulário)
// Variável para armazenar a mensagem de feedback (sucesso ou erro) ao usuário.
$mensagem = "";
// Variáveis para manter o estado do formulário em caso de erro
$nome = '';
$email = '';
$telefone = '';


// 3. Verificação do Método de Requisição
// Checa se a página foi acessada via submissão de um formulário (método POST).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // 4. Coleta e Limpeza dos Dados do Formulário
  // Coleta os dados enviados pelo formulário.
  // A função 'trim' remove espaços em branco no início e no fim dos campos.
  $nome = trim($_POST['nome']);
  $email = trim($_POST['email']);

  // Aplicar trim() na senha também, apenas para remover espaços laterais.
  $senha = trim($_POST['senha']);

  $telefone = trim($_POST['telefone']);

  // 5. Chamada da Função de Cadastro
  // Chama a função de cadastro, passando o objeto PDO e os dados coletados.
  $resultado = cadastrar_usuario($conexao, $nome, $email, $senha, $telefone);

  // 6. Tratamento do Resultado
  // A função retorna 'true' em caso de sucesso ou uma string com a mensagem de erro.
  if ($resultado === true) {
    // Redirecionamento em caso de sucesso.
    // Redireciona para login e adiciona um parâmetro para exibir a mensagem lá.
    header("Location: " . BASE_URL . "/public/index.php?page=login&register=sucesso");
    exit;
  } else {
    // Define a mensagem de erro, usando a string retornada pela função
    $mensagem = "<p class='mensagem erro'>$resultado</p>";

    // Se houver erro, os valores coletados ($nome, $email, $telefone) 
    // são mantidos para pré-preencher o formulário abaixo.
  }
}
?>

<div class="login-wrapper">
  
  <div class="login-container">
    
    <div class="topo">
      <a href="<?= BASE_URL ?>/public/index.php?page=login" class="bt-voltar">↩</a>
    </div>

    <h2>Cadastro de Usuário</h2>

    <?php if (!empty($mensagem)): ?>
        <?= $mensagem ?>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/public/index.php?page=registrar" method="post" class="form-login">
      
      <div class="grupo-input">
          <label for="nome">Nome:</label>
          <input type="text" name="nome" id="nome" class="input-login" required value="<?= htmlspecialchars($nome) ?>">
      </div>

      <div class="grupo-input">
          <label for="email">Email:</label>
          <input type="email" name="email" id="email" class="input-login" required value="<?= htmlspecialchars($email) ?>">
      </div>

      <div class="grupo-input">
          <label for="senha">Senha:</label>
          <input type="password" name="senha" id="senha" class="input-login" required>
      </div>

      <div class="grupo-input">
          <label for="telefone">Telefone:</label>
          <input type="text" name="telefone" id="telefone" class="input-login" value="<?= htmlspecialchars($telefone) ?>">
      </div>

      <div class="dosBotoes">
          <button type="submit" class="btn-entrar">Cadastrar</button>
          
          <a href="<?= BASE_URL ?>/public/index.php?page=login" class="bt-cadastrar">Login</a>
      </div>

    </form>
  </div>
</div>