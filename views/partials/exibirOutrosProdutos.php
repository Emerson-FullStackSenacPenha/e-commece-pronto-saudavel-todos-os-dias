<?php

/**
 * Exibe produtos que NÃO contenham "marmita" no nome
 * e NÃO pertençam à categoria de Marmitas (id 7).
 */
function exibirProdutosExcetoMarmitas($conexao, $templatePath, $baseUrl)
{
    try {

        // ID da categoria "Marmitas"
        $idCategoriaMarmitas = 7;

        $sql = "SELECT * FROM produtos
                WHERE ativo = 1
                AND categoria_id != :categoria_marmitas
                AND nome NOT LIKE '%marmita%'
                ORDER BY nome ASC";

        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':categoria_marmitas', $idCategoriaMarmitas, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            echo "<p>Nenhum produto encontrado.</p>";
            return;
        }

        while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $produto['preco'] = $produto['valor'] ?? 0;

            if (!empty($produto['imagem_url'])) {
                $produto['imagem_url'] = $baseUrl . $produto['imagem_url'];
            } else {
                $produto['imagem_url'] = $baseUrl . "/public/images/sem-imagem.png";
            }

            include $templatePath;
        }

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao buscar produtos: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
