<?php

//require_once __DIR__ . '../../../app/core/DataBaseConecta.php'; 
//require_once __DIR__ .'../../../app/Controllers/Admin/ProductAdminController.php'; 

$produtos = listarProdutos($conexao);

?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
        vertical-align: middle;
    }

    th {
        background-color: #f2f2f2;
    }

    .miniatura {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .btn-acao {
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 14px;
        margin-right: 5px;
    }

    .btn-editar {
        background-color: #ffc107;
        color: #000;
    }

    .btn-excluir {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-novo {
        display: inline-block;
        background-color: #12602c;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 20px;
    }
</style>

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
                        $caminhoPasta = BASE_URL . '/public/images/products/';
                        $urlImagem = $caminhoPasta . $nomeArquivo;

                        if ($nomeArquivo && file_exists($urlImagem)) {
                            // Se tem nome no banco e o arquivo existe na pasta
                            echo "<img src='{$urlImagem}' alt='Foto' class='miniatura'>";
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
                    
                    <a href="<?= BASE_URL ?>/public/index.php?page=atualizar_produto&id=<?= $produto['id']; ?>" class="btn-acao btn-editar">Editar</a> | 
                    <a href="<?= BASE_URL ?>/public/index.php?page=excluir_produto&id=<?= $produto['id']; ?>" class="btn-acao btn-excluir excluir">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="<?= BASE_URL ?>/public/index.php?page=inserir_produto" class="btn-novo">➕ Novo Produto</a>

<script src="../admin/js/confirmar_exclusao.js"></script>