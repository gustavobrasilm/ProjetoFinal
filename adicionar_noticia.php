<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once './config/config.php';
include_once './classes/Noticia.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$noticia = new Noticia($db);

// Inicializar variáveis para armazenar mensagens de erro e dados do formulário
$titulo = '';
$noticia_texto = '';
$erro = '';

// Processar envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar os campos recebidos
    $titulo = trim($_POST['titulo']);
    $noticia_texto = trim($_POST['noticia']);

    // Exemplo básico de validação
    if (empty($titulo) || empty($noticia_texto)) {
        $erro = 'Por favor, preencha todos os campos.';
    } else {
        
        $data = date('Y-m-d'); 
        $idusu = $_SESSION['usuario_id']; 

        $resultado = $noticia->criar($idusu, $data, $titulo, $noticia_texto);

        if ($resultado) {
            // Sucesso ao inserir a notícia, redirecionar para a página de notícias
            header('Location: crud_noticia.php');
            exit();
        } else {
            $erro = 'Ocorreu um erro ao adicionar a notícia. Por favor, tente novamente.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Notícia</title>
    <link rel="stylesheet" href="./css/add_noticia.css">
</head>
<body>
    <header>
        <h1>Adicionar Notícia</h1>
        <nav>
            <a href="noticias.php">Home</a>
            <a href="portal.php">Portal</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">
        <form method="POST" class="form-noticia">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>" required>
            </div>
            <div class="form-group">
                <label for="noticia">Notícia:</label>
                <textarea id="noticia" name="noticia" rows="5" required><?php echo htmlspecialchars($noticia_texto); ?></textarea>
            </div>
            <?php if (!empty($erro)) : ?>
                <div class="error"><?php echo $erro; ?></div>
            <?php endif; ?>
            <button type="submit">Adicionar Notícia</button>
        </form>
    </div>
</body>
</html>