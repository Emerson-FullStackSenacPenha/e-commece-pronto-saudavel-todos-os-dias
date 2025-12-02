<?php

require_once '../../app/core/Session.php'; 
require_once '../../app/core/DataBaseConecta.php'; 
require_once '../../app/Controllers/Admin/ProductAdminController.php'; 

$produtos = listarProdutos($conexao);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos - Admin</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: middle; }
        th { background-color: #f2f2f2; }
        
        /* Estilo para a miniatura da imagem */
        .miniatura {
            width: 80px;       /* Largura fixa */
            height: 80px;      /* Altura fixa */
            object-fit: cover; /* Corta a imagem para caber no quadrado sem esticar */
            border-radius: 5px; /* Bordas arredondadas (opcional) */
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h1>📋 Produtos</h1>
    <br><br>

    <table>
        <thead>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
            <tr>
                <td style="text-align: center;">
                    <?php 
                        $nomeArquivo = $produto['imagem_url'] ?? null;
                        
                        // Caminho relativo da pasta onde salvamos as fotos
                        // Ajuste se necessário, mas baseado no seu 'require', deve ser este:
                        $caminhoPasta = "../../public/images/products/";

                        if ($nomeArquivo && file_exists($caminhoPasta . $nomeArquivo)) {
                            // Se tem nome no banco e o arquivo existe na pasta
                            echo "<img src='{$caminhoPasta}{$nomeArquivo}' alt='Foto' class='miniatura'>";
                        } elseif ($nomeArquivo) {
                            // Se tem nome no banco, mas o arquivo não foi achado (exibe caminho quebrado ou ícone)
                            echo "<img src='{$caminhoPasta}{$nomeArquivo}' alt='Erro img' class='miniatura'>";
                        } else {
                            // Se não tem nada no banco
                            echo "<span style='color: #999; font-size: 12px;'>Sem foto</span>";
                        }
                    ?>
                </td>
                <td><?= htmlspecialchars($produto['nome'] ?? 'N/A'); ?></td>
                <td>R$ <?= number_format($produto['valor'] ?? 0, 2, ',', '.'); ?></td>
                <td><?= htmlspecialchars($produto['estoque'] ?? 0); ?></td>
                
                
                <td>
                    <a href="atualizarProdutos.php?id=<?= $produto['id']; ?>">Editar</a> | 
                    <a href="excluirProdutos.php?id=<?= $produto['id']; ?>" class="excluir">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

       <a href="inserir.php">➕ Novo Produto</a> 
    
    <script src="../admin/js/confirmar_exclusao.js"></script>
</body>
</html>