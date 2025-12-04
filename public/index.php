<?php 
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('VIEWS_PATH', __DIR__ . '/../views');
$baseUrl = 'http://localhost/e-commece-pronto-saudavel-todos-os-dias';


$action = $_POST['action'] ?? null;

if ($action === 'gerenciar_carrinho') {
    
    require_once VIEWS_PATH . '/partials/gerenciar-carrinho.php';
    exit; 

} else {
    // Decidir qual página carregar
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

     $allowedPages = [
        'home' => VIEWS_PATH . '/pages/home.php',
        'marmitas' => VIEWS_PATH . '/pages/produtos-marmitas.php',
        'caldo' => VIEWS_PATH . '/pages/produtos-caldo.php',
        'fitness' => VIEWS_PATH . '/pages/produtos-fitness.php',
        'lowcarb' => VIEWS_PATH . '/pages/produtos-lowcarb.php',
        'outros' => VIEWS_PATH . '/pages/produtos-outros.php',
        'sobremesa' => VIEWS_PATH . '/pages/produtos-sobremesa.php',
        'sopa' => VIEWS_PATH . '/pages/produtos-sopa.php',
        'suco' => VIEWS_PATH . '/pages/produtos-suco.php',
        'tempero' => VIEWS_PATH . '/pages/produtos-tempero.php',
        'torta' => VIEWS_PATH . '/pages/produtos-torta.php',
        'vegana' => VIEWS_PATH . '/pages/produtos-vegana.php',
        'carrinho_de_compras' => VIEWS_PATH . '/pages/carrinho_de_compras.php',
        'productDetails' => VIEWS_PATH . '/pages/productDetails.php',
        'personalChefe' => VIEWS_PATH . '/pages/personal_chefe.php',
        'about' => VIEWS_PATH . '/pages/about.php'
        // Adicione as outras páginas aqui
   
    ];

   
    // Verificamos se a página pedida está na nossa lista.
    if (array_key_exists($page, $allowedPages)) {
        // Se estiver, definimos $viewFile como o caminho do arquivo.
        $viewFile = $allowedPages[$page];
    } else {
        
        $viewFile = $allowedPages['home']; 
    }

    // Carregar o "Molde" Principal
    require_once VIEWS_PATH . '/layouts/main.php';
}
?>