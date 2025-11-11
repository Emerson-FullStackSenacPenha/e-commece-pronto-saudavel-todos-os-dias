<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Marmita LowCarb</title>
  <link rel="stylesheet" href="../../public/css/marmita-compra.css">
</head>
<body>

  <div class="caixa">
    <div>
      <img src="marmita.png" alt="Marmita LowCarb" class="foto">
      
      <div class="descricao">
        <span class="subtitulo">Descrição:</span>
        <p>O salmão é servido sobre uma colorida cama de Legumes Mediterrâneos, preparados no azeite de oliva extra virgem e levemente temperados com ervas finas. Você encontrará cubos de abobrinha, berinjela, pimentões frescos e brócolis al dente.</p>

        <span class="subtitulo">Temperos e Ingredientes:</span>
        <p>O segredo dessa marmita Low Carb está na combinação de ingredientes frescos e temperos aromáticos. O Salmão é cuidadosamente grelhado após ser marinado com um toque de limão siciliano e pimenta do reino. Para o acompanhamento, selecionamos abobrinha, berinjela, pimentões (vermelho e amarelo) e brócolis, todos cortados em cubos e salteados na cebola e no alho com um generoso fio de Azeite de Oliva Extra Virgem. O sabor final é realçado com sal marinho e uma mistura especial de ervas finas (alecrim, orégano e manjericão), e finalizado com um toque de salsa fresca. Esta é a união perfeita entre sabor mediterrâneo e praticidade!</p>
      </div>
    </div>

    <div class="info">
      <div class="titulo">Marmita LowCarb</div>

      <div class="bloco-opcao">
        <span class="titulo-opcao">Tamanho:</span>
        <div class="area-botoes">
          <div class="botao"><b>200g</b></div>
          <div class="botao"><b>300g</b></div>
          <div class="botao"><b>400g</b></div>
          <div class="botao"><b>500g</b></div>
          <div class="botao"><b>600g</b></div>
        </div>
      </div>

      <div class="bloco-opcao">
        <span class="titulo-opcao">Adicionais:</span>
        <div class="area-botoes">
          <div class="botao"><b>Suco</b></div>
          <div class="botao"><b>Salada</b></div>
          <div class="botao"><b>Farofa</b></div>
          <div class="botao"><b>Molho</b></div>
          <div class="botao"><b>Cebola</b></div>
          <div class="botao"><b>Batata</b></div>
        </div>
      </div>

      <div class="frete">
        <button>Calcular Frete</button>
        <input type="text" placeholder="digite seu CEP">
      </div>

      <div class="preco">R$ 205,00</div>

      <div class="comprar">
        <input type="number" min="1" value="10">
        <button>Comprar</button>
      </div>
    </div>
  </div>

  <script>
    document.querySelectorAll('.botao').forEach(botao => {
      botao.addEventListener('click', function() {
        const grupo = this.parentElement;
        grupo.querySelectorAll('.botao').forEach(b => b.classList.remove('ativo'));
        this.classList.add('ativo');
      });
    });
  </script>

</body>
</html>
