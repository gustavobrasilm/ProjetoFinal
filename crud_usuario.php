<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once './config/config.php';
include_once './classes/Usuario.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

$usuario = new Usuario($db);


// Processar exclusão de usuário
if (isset($_GET['deletar'])) {
    $id = $_GET['deletar'];
    $usuario->deletar($id);
    header('Location: portal.php');
    exit();
}


// Obter parâmetros de pesquisa e filtros
$search = isset($_GET['search']) ? $_GET['search'] : '';
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// Obter dados dos usuários com filtros
$dados = $usuario->ler($search, $order_by);

// Obter dados do usuário logado
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$nome_usuario = $dados_usuario['nome'];

// Função para determinar a saudação
function saudacao() {
    $hora = date('H');
    if ($hora >= 6 && $hora < 12) {
        return "Bom dia";
    } elseif ($hora >= 12 && $hora < 18) {
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
    <title>Portal</title>
    <link rel="stylesheet" href="./css/crudusu.css">
</head>
<body>    
    <header>
        <h1>Bem-vindo ao Portal de Usuários</h1>
        <nav>
        <a href="portal.php">Portal</a>
            <a href="index.php">Página de Noticias</a>
            <a href="registrar.php">Adicionar Usuario</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">
        <h1><?php echo saudacao() . ", " . htmlspecialchars($nome_usuario); ?>!</h1>
        
        <form method="GET">
            <input type="text" name="search" placeholder="Pesquisar por nome ou email" value="<?php echo htmlspecialchars($search); ?>">
            
            
            <div class="filters">
                <label>
                    <input type="radio" name="order_by" value="" <?php if ($order_by == '') echo 'checked'; ?>> Normal
                </label>
                <label>
                    <input type="radio" name="order_by" value="nome" <?php if ($order_by == 'nome') echo 'checked'; ?>> Ordem Alfabética
                </label>
                <label>
                    <input type="radio" name="order_by" value="sexo" <?php if ($order_by == 'sexo') echo 'checked'; ?>> Sexo
                </label>
            </div>
            
            <button type="submit">Pesquisar</button>
        </form>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sexo</th>
                <th>Fone</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $dados->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['nome']); ?></td>
                <td><?php echo ($row['sexo'] === 'M') ? 'Masculino' : 'Feminino'; ?></td>
                <td><?php echo htmlspecialchars($row['fone']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td>
                <a href="editar.php?id=<?php echo $row['id']; ?>"><img src="./imagens/editar.png" alt="Editar"></a>
                <a href="deletar.php?id_usuario=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja deletar este usuário?')"><img src="./imagens/delte.png" alt="Deletar"></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
