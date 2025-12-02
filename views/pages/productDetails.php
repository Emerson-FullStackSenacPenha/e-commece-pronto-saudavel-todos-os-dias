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
 <div class="info produto-contexto">

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

    <div class="preco preco-display">R$ <?= number_format($produto['valor'] * 5, 2, ',', '.') ?></div>

    <div class="comprar">
        <form action="<?= $baseUrl ?>/public/index.php" method="POST" 
              style="display: flex; gap: 10px; align-items: center;"
              data-preco-unitario="<?= $produto['valor'] ?>">

            <input type="hidden" name="action" value="gerenciar_carrinho">
            <input type="hidden" name="acao_carrinho" value="adicionar">
            <input type="hidden" name="id_produto" value="<?= $produto['id'] ?>">

            <div class="quantity-selector" style="display: flex; align-items: center;">
                <button class="quantity-selector__button" type="button" onclick="atualizarPreco(this, -5)">-</button>
                
                <input 
                    type="number" 
                    name="quantidade" 
                    min="5" 
                    value="5" 
                    step="5"
                    class="input-quantidade quantity-selector__input"
                    style="width: 60px; padding: 5px; text-align: center;"
                    readonly
                >
                
                <button class="quantity-selector__button" type="button" onclick="atualizarPreco(this, 5)">+</button>
            </div>
            
            <button type="submit" class="botao-comprar">Adicionar ao Carrinho</button>

        </form>
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

  <script>
        function atualizarPreco(botao, delta) {
          // 1. Encontra o Formulário (onde está o dado do preço unitário)
          const form = botao.closest('form');
          
          // 2. Encontra o "Contexto Maior" (pode ser o Card OU a div principal da página de detalhes)
          // O comando 'closest' procura o pai mais próximo que tenha QUALQUER uma dessas classes.
          const contexto = botao.closest('.product-card, .produto-contexto'); 

          const input = form.querySelector('.input-quantidade');
          
          // 3. Encontra onde exibir o preço (procura dentro do contexto que achamos no passo 2)
          // Procura por .product-card__price (card) OU .preco-display (detalhes)
          const displayPreco = contexto.querySelector('.product-card__price, .preco-display');

          // --- Lógica de Cálculo (Igual a antes) ---
          let quantidade = parseInt(input.value);
          let precoUnitario = parseFloat(form.getAttribute('data-preco-unitario'));

          let novaQuantidade = quantidade + delta;

          if (novaQuantidade < 5) {
              novaQuantidade = 5;
          }

          input.value = novaQuantidade;

            if (novaQuantidade >= 10) {

                precoUnitario -= 2.00
            }

          let novoTotal = precoUnitario * novaQuantidade;

          displayPreco.innerText = novoTotal.toLocaleString('pt-BR', {
              style: 'currency',
              currency: 'BRL'
          });
      }
    </script>
    
 


