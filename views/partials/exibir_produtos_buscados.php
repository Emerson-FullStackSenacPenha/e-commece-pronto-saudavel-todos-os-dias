<?php 
// Adicionei $baseUrl nos parâmetros para o link funcionar
function exibirCardProdutosBuscados($id, $nome, $preco, $imagem, $baseUrl){ 
?>

    <article class="product-card">

        <a href="<?= $baseUrl ?>/public/index.php?page=productDetails&id=<?= $id ?>" style="text-decoration: none; color: inherit; display: flex; flex-grow: 1;">
            
            <figure class="product-card__figure">
                <img 
                    class="product-card__image"
                    src="<?= htmlspecialchars($baseUrl . $imagem) ?>" 
                    alt="<?= htmlspecialchars($nome) ?>">
            </figure>

            <div class="product-card__content">

                <div class="product-card__tags">
                    <span class="tag-item">CONTÉM GLÚTEN</span>
                    <span class="tag-item">CONTÉM LACTOSE</span>
                </div>

                <div class="product-card__nutrition">
                    <div class="nutrition-item"><strong>444</strong><span>KCAL</span></div>
                    <div class="nutrition-item"><strong>56</strong><span>PROT.</span></div>
                    <div class="nutrition-item"><strong>120</strong><span>CARB.</span></div>
                    <div class="nutrition-item"><strong>17</strong><span>GORD.</span></div>
                </div>
                
                <h3 class="product-card__title">
                    <?= htmlspecialchars($nome) ?>
                </h3>

                <p class="product-card__price preco-display">
                    R$ <?= number_format($preco * 5, 2, ',', '.') ?>
                </p>

            </div>

        </a>

        <div class="product-card__actions" data-preco-unitario="<?= $preco ?>">
            
            <form action="<?= $baseUrl ?>/public/index.php" method="POST">

                <input type="hidden" name="action" value="gerenciar_carrinho">
                <input type="hidden" name="acao_carrinho" value="adicionar">
                
                <input type="hidden" name="id_produto" value="<?= $id ?>">

                <div class="quantity-selector">
                    <button class="quantity-selector__button" type="button" onclick="atualizarPrecoCard(this, -5)">-</button>
                    
                    <input 
                        class="quantity-selector__input input-quantidade"
                        type="number"
                        name="quantidade"
                        value="5"
                        min="5"
                        step="5"
                        readonly>
                    
                    <button class="quantity-selector__button" type="button" onclick="atualizarPrecoCard(this, 5)">+</button>
                </div>

                <button type="submit" class="button button--primary">Adicionar</button>

            </form>

        </div>

    </article>
<?php } ?>