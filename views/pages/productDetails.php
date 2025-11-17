<?php
$nomeProduto = "Marmita LowCarb";
$preco = "R$ 205,00";
$imagem = "<?= $baseUrl ?>/public/images/products/marmita_carne.jpg";
?>

 
  <div class="caixa">
 
    <div class="lado-esquerdo">
 
      <img src="<?php echo $imagem; ?>" alt="<?php echo $nomeProduto; ?>" class="foto">
 
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
 
      <div class="titulo"><?php echo $nomeProduto; ?></div>
 
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
 
      <div class="preco"><?php echo $preco; ?></div>
 
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
 


