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

// Processar exclusão de notícia
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $noticia->deletar($id);
    header('Location: crud_noticia.php');
    exit();
}

// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// Obter dados das notícias com filtros
$dados = $noticia->ler($search, $order_by);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Notícias</title>
    <link rel="stylesheet" href="./css/crud_noticia.css">
</head>
<body>
    <header>
        <h1>Bem-vindo ao Portal de Notícias</h1>
        <nav>
            <a href="portal.php">Portal</a>
            <a href="index.php">Página de Noticias</a>
            <a href="adicionar_noticia.php">Adicionar Notícia</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">
        <h1>Lista de Notícias</h1>
        
        <form method="GET">
            <input type="text" name="search" placeholder="Pesquisar por título ou conteúdo" value="<?php echo htmlspecialchars($search); ?>">
            
            <div class="filters">
                <label>
                    <input type="radio" name="order_by" value="" <?php if ($order_by == '') echo 'checked'; ?>> Normal
                </label>
                <label>
                    <input type="radio" name="order_by" value="titulo" <?php if ($order_by == 'titulo') echo 'checked'; ?>> Ordem Alfabética
                </label>
                <button type="submit">Pesquisar</button>
            </div>
        </form>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Data</th>
                <th>Notícia</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['idnot']); ?></td>
                <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                <td><?php echo htmlspecialchars($row['data']); ?></td>
                <td><?php echo htmlspecialchars($row['noticia']); ?></td>
                <td>
                    <a href="editar_noticia.php?id=<?php echo $row['idnot']; ?>"><img src="./imagens/editar.png" alt=""></a>
                    <a href="crud_noticia.php?deletar=<?php echo $row['idnot']; ?>" onclick="return confirm('Tem certeza que deseja deletar esta notícia?')"><img src="./imagens/delte.png" alt=""></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
