<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Noticia.php';

$noticia = new Noticia($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['noticia'];
    $noticia->atualizar($id, $titulo, $conteudo);
    header('Location: crud_noticia.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $noticia->lerPorId($id);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/editar_noticia.css">
    <title>Editar Notícia</title>
</head>
<body>
    <header>
        <h1>Editar Notícia</h1>
        <nav>
            <a href="index.php">Página de Noticias</a>
            <a href="portal.php">Portal</a>
            <a href="crud_noticia.php">Voltar</a>
            <a href="logout.php">Logout</a>

        </nav>
    </header>
    <div class="container">
        <form method="POST" class="form-noticia">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['idnot']); ?>">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($row['titulo']); ?>" required>
            </div>
            <div class="form-group">
                <label for="noticia">Conteúdo:</label>
                <textarea id="noticia" name="noticia" rows="10" required><?php echo htmlspecialchars($row['noticia']); ?></textarea>
            </div>
            <button type="submit">Atualizar</button>
        </form>
    </div>
</body>
</html>
