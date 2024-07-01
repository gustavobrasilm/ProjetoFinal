<?php

session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';
$usuario = new Usuario($db);

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: portal.php');
    exit();
}

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];

// Função para determinar a saudação
function saudacao() {
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } else if ($hora >= 12 && $hora < 18) {
        return "Boa tarde";
    } else {
        return "Boa noite";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa Usuários</title>
    <link rel="stylesheet" href="./css/portal.css">
</head>
<body>
    <header>
        <h1><?php echo saudacao() . ", " . $nome_usuario; ?>!</h1>
        <div class="header-buttons">
            <a class="button" href="index.php">Página de Notícias</a>
            <a class="logout-button" href="logout.php">Logout</a>
        </div>
    </header>
    <main>
        <div class="porta-container">
            <div class="porta">
                <a class="button add-button" href="crud_usuario.php">Gerenciar Usuários</a>
                <a class="button add-button" href="crud_noticia.php">Gerenciar Notícias</a>
            </div>
        </div>
    </main>
</body>
</html>
