<?php

/**
 * Busca produtos ativos e permite filtrar por nome ou categoria_id.
 *
 * @param PDO $conexao
 * @param string $templatePath
 * @param string $baseUrl
 * @param string|null $filtroNomeOuCategoria  Ex: "marmita", "7", "sobremesa"
 */
function exibirProdutos($conexao, $templatePath, $baseUrl, $filtroNomeOuCategoria = null)
{
    try {

        // 1. Se houver filtro, verificar se corresponde a categoria_id
        if ($filtroNomeOuCategoria) {

            // Se for número -> filtrar por categoria_id
            if (is_numeric($filtroNomeOuCategoria)) {

                $sql = "SELECT * FROM produtos 
                        WHERE ativo = 1 
                        AND categoria_id = :categoria
                        ORDER BY nome ASC";

                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(":categoria", $filtroNomeOuCategoria, PDO::PARAM_INT);

            } else {

                // Filtrar pelo nome
                $sql = "SELECT * FROM produtos 
                        WHERE ativo = 1 
                        AND nome LIKE :nome
                        ORDER BY nome ASC";

                $stmt = $conexao->prepare($sql);
                $like = "%" . $filtroNomeOuCategoria . "%";
                $stmt->bindParam(":nome", $like);
            }

        } else {

            // 2. Sem filtro → lista tudo
            $sql = "SELECT * FROM produtos 
                    WHERE ativo = 1 
                    ORDER BY nome ASC";

            $stmt = $conexao->prepare($sql);
        }

        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            echo "<p>Nenhum produto encontrado.</p>";
            return;
        }

        // 3. Exibição
        while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $produto['preco'] = $produto['valor'] ?? 0;

            if (!empty($produto['imagem_url'])) {
                $produto['imagem_url'] = $baseUrl . $produto['imagem_url'];
            } else {
                $produto['imagem_url'] = $baseUrl . '/public/images/sem-imagem.png';
            }

            include $templatePath;
        }

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erro ao buscar produtos: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
