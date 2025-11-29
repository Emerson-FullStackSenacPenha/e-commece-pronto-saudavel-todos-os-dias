<?php
    require_once __DIR__ . '/../../app/core/DataBaseConecta.php'; 
    require_once __DIR__ . '/../../app/Controllers/Admin/ProductAdminController.php';
    global $baseUrl;

    $id = $_GET['id'] ?? null; 
    $produto = null;
    if ($id) {
         $produto = buscarProdutoPorId($conexao, $id);
    }


    if (!$produto) {
        echo "<div style='text-align: center; padding: 50px;'>";
        echo "<h2>Ops! Produto não encontrado.</h2>";
        echo "<p>Verifique se o link está correto.</p>";
        echo "<a href='$baseUrl/public/index.php?page=produtos' style='color: blue; text-decoration: underline;'>Voltar para produtos</a>";
        echo "</div>";
        return; 
    }

// 5. SE CHEGOU AQUI, O PRODUTO EXISTE. PREPARA A IMAGEM.
    $imagemUrl = (!empty($produto['imagem_url'])) 
    ? $baseUrl . $produto['imagem_url'] 
    : $baseUrl . '/public/images/sem-imagem.png';
    
?>

 
  <div class="caixa">
 
    <div class="lado-esquerdo">
 
      <img src="<?= $imagemUrl ?>" alt="foto <?= $produto['nome']; ?>" class="foto">
 
      <div class="descricao">
        <span class="subtitulo">Descrição:</span>
 
        <p>
          O salmão é servido sobre uma colorida cama de Legumes Mediterrâneos,
          preparados no azeite de oliva extra virgem e levemente temperados
          com ervas finas. Você encontrará cubos de abobrinha, berinjela,
          pimentões frescos e brócolis al dente.
        </p>
 
        <span class="subtitulo">Temperos e Ingredientes:</span>
 
        <p>
          O Segredo dessa marmita LowCarb está na combinação de ingredientes
          frescos e temperos aromáticos. O Salmão é cuidadosamente grelhado
          após ser marinado com limão siciliano e pimenta do reino. Para o
          acompanhamento, selecionamos abobrinha, berinjela, pimentões e
          brócolis, salteados na cebola e alho com azeite extra virgem.
        </p>
 
      </div>
 
    </div>
 
    <div class="info">
 
      <div class="titulo"><?= $produto['nome'] ?></div>
 
      <div class="bloco-opcao">
 
        <span class="titulo-opcao">Tamanho:</span>
 
        <div class="area-botoes" data-grupo="tamanho">
 
          <?php
          $tamanhos = ["200g", "300g", "400g", "500g", "600g"];
          foreach ($tamanhos as $t) {
              echo '<div class="botao"><b>' . $t . '</b></div>';
          }
          ?>
 
        </div>
 
      </div>
 
      <div class="bloco-opcao">
 
        <span class="titulo-opcao">Adicionais:</span>
 
        <div class="area-botoes" data-grupo="adicionais">
 
          <?php
          $extras = ["Suco", "Salada", "Farofa", "Molho", "Cebola", "Batata"];
          foreach ($extras as $extra) {
            echo '<div class="botao"><b>'. $extra .'</b></div>';
          }
          ?>
 
        </div>
 
      </div>
 
      <div class="frete">
 
        <button>Calcular Frete</button>
        <input type="text" placeholder="digite seu CEP">
 
      </div>
 
      <div class="preco"><?= $produto['valor']; ?></div>
 
      <div class="comprar">
 
        <input type="number" min="1" value="10">
        <button>Comprar</button>
 
      </div>
 
    </div>
 
  </div>
 
  <script>
    document.querySelectorAll('.area-botoes').forEach(grupo => {
      const botoes = grupo.querySelectorAll('.botao');
 
      botoes.forEach(botao => {
        botao.addEventListener('click', () => {
          botoes.forEach(b => b.classList.remove('ativo'));
          botao.classList.add('ativo');
        });
      });
    });
  </script>
 


