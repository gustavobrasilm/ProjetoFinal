<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once './config/config.php';
include_once './classes/Noticia.php';

$noticia = new Noticia($db);

// Obter as últimas notícias
$ultimas_noticias = $noticia->ler('', 'data DESC'); 

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Notícias</title>
    <link rel="stylesheet" href="./css/index1.css">
</head>
<body>
    
    <header>
        <div class="cabecalho">
            <h1>Portal Notícias</h1>
            <?php if (isset($_SESSION['usuario_id'])) : ?>
                <div class="buttons">
                <a href="portal.php">Portal</a>
                <a href="logout.php">Logout</a>
                </div>
            <?php else : ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <h2 class="titulo-noticias">Últimas Notícias</h2>

    <div class="noticias-container">
        <ul class="noticias-list">
            <?php while ($noticia = $ultimas_noticias->fetch(PDO::FETCH_ASSOC)) : ?>
                <li>
                    <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($noticia['noticia']); ?></p>
                    <span><?php echo htmlspecialchars($noticia['data']); ?></span>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
