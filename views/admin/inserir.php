<?php
/*     require_once '../../app/core/Session.php';
    require_once '../../app/Controllers/Admin/ProductAdminController.php';
    require_once '../../app/core/DataBaseConecta.php'; */

// verificaAdmin();
$erro = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try {
        $nome = trim(filter_var($_POST['nome'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS));
        $descricao = trim(filter_var($_POST['descricao'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS));
        $valor = filter_input(INPUT_POST, 'valor', FILTER_VALIDATE_FLOAT);
        $estoque = filter_input(INPUT_POST, 'estoque', FILTER_VALIDATE_INT);

        // --- PARTE DO UPLOAD ---
        $caminhoImagem = ''; // Valor padrão caso não tenha imagem ou falhe

        if (isset($_FILES['imagem_url'])) {
            // Chama a função que criamos no controller
            // Ela vai retornar o texto (caminho) para salvar no banco
            $caminhoImagem = fazerUploadImagem($_FILES['imagem_url']);
        }
        // -----------------------

        // Agora passamos o $caminhoImagem (que é uma string) para a função
        $resultado = cadastrarProduto($conexao, $nome, $descricao, $valor, $estoque, $caminhoImagem);

        // Se a função cadastrarProduto retornar uma string, é erro (conforme sua lógica original)
        if (is_string($resultado)) {
            $erro = $resultado;
        } else {
            header("Location: " . BASE_URL . "/public/index.php?page=listar_produtos");
            exit();
        }
    } catch (Exception $e) {
        $erro = "Erro: " . $e->getMessage();
    }
}
?>

<div class="div_produtos_crud ">
    <?php if ($erro): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" required>
        </div>
        <div>
            <label for="descricao">Descrição</label>
            <textarea name="descricao" id="descricao" rows="5"></textarea>
        </div>
        <div>
            <label for="valor">Preço:</label>
            <input type="number" name="valor" id="valor" required min="0" step="0.01">
        </div>
        <div>
            <label for="estoque">Quantidade:</label>
            <input type="number" name="estoque" id="estoque" required min="0">
        </div>

        <div>
            <label for="imagem_url">Imagem do produto:</label>
            <input type="file" name="imagem_url" id="imagem_url">
        </div>

        <button type="submit">Salvar</button>
    </form>
</div>