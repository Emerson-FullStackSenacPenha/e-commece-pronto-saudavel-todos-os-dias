<?php 
    session_start();
    require_once __DIR__ . '/../app/core/Session.php';
    ob_start();

        // Certifique-se de que a sessão está iniciada em todas as páginas
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    // Variável para verificar se o usuário está logado
    $usuario_logado = isset($_SESSION["user_nome"]);
    
    // Se estiver logado, armazene o nome para uso mais fácil
    $nome_usuario = $usuario_logado ? $_SESSION["user_nome"] : '';

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    define('VIEWS_PATH', __DIR__ . '/../views');
    $baseUrl = 'http://localhost/e-commece-pronto-saudavel-todos-os-dias';

    require_once '../config/config.php';


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
            'about' => VIEWS_PATH . '/pages/about.php',
            'dashboard_cliente' => VIEWS_PATH . '/pages/auth/logado.php',
            'login' => VIEWS_PATH . '/pages/auth/login.php',
            'registrar' => VIEWS_PATH . '/pages/auth/register.php'
            // Adicione as outras páginas aqui
        ];
        $paginasProtegidas = [
            'dashboard_cliente'
        ];

        // 3. Lista de páginas exclusivas para VISITANTES (Quem já logou não deve ver)
        $paginasGuest = [
            'login',
            'registrar',
            'recuperar_senha'
        ];

        if (in_array($page, $paginasProtegidas) && !$usuario_logado) {
            // Redireciona para o login
            header("Location: " . BASE_URL . "/public/index.php?page=login");
            exit;
        }

        // --- REGRA 2: UX (Redireciona quem JÁ está logado para o painel) ---
        if (in_array($page, $paginasGuest) && $usuario_logado) {
            // Se ele tentar ir pro login mas já tá logado, manda pro dashboard
            header("Location: " . BASE_URL . "/public/index.php?page=dashboard_cliente");
            exit;
        }



    
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