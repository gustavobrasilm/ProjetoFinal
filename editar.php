<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Usuario.php';

$usuario = new Usuario($db);

// Verificar se o ID foi passado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $row = $usuario->lerPorId($id);
} else {
    // Se o ID não foi passado, redirecionar ou lidar com o erro conforme necessário
    header('Location: portal.php');
    exit();
}

// Processar o formulário de atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $usuario->atualizar($id, $nome, $sexo, $fone, $email);
    header('Location: portal.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/editar.css">
    <title>Editar Usuário</title>
</head>
<body>

<header>
        <h1>Editar Usuario</h1>
        <nav>
            <a href="noticias.php">Home</a>
            <a href="portal.php">Portal</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    
    <h1>Editar Usuário</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : ''; ?>">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo isset($row['nome']) ? $row['nome'] : ''; ?>" required>
        <br><br>
        <label>Sexo:</label>
        <label for="masculino">
            <input type="radio" id="masculino" name="sexo" value="M" <?php echo isset($row['sexo']) && $row['sexo'] === 'M' ? 'checked' : ''; ?> required> Masculino
        </label>
        <label for="feminino">
            <input type="radio" id="feminino" name="sexo" value="F" <?php echo isset($row['sexo']) && $row['sexo'] === 'F' ? 'checked' : ''; ?> required> Feminino
        </label>
        <br><br>
        <label for="fone">Fone:</label>
        <input type="text" id="fone" name="fone" value="<?php echo isset($row['fone']) ? $row['fone'] : ''; ?>" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>" required>
        <br><br>
        <input type="submit" value="Atualizar">
    </form>
</body>
</html>
