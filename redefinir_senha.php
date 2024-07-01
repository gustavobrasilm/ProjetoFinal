<?php
include_once './config/config.php';
include_once './classes/Usuario.php';
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $nova_senha = $_POST['nova_senha'];
    $usuario = new Usuario($db);
    if ($usuario->redefinirSenha($codigo, $nova_senha)) {
        $mensagem = 'Senha redefinida com sucesso. Você pode <a
href="login.php">entrar</a> agora. ';
    } else {
        $mensagem = 'Código de verificação inválido.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/redsenha.css">
    <title>Redefinir</title>

</head>

<body>
    <div class="box"> 
        <h1>Redefinir Senha</h1>
        <form method="POST">
            <label for="codigo">Código de Verificação:</label>
            <input type="text" name="codigo" required><br><br>
            <label for="nova_senha">Nova Senha:</label>
            <input type="password" name="nova_senha" required><br><br>
            <input type="submit" value="Redefinir Senha">
        </form>
        <p><?php echo $mensagem; ?></p>
        <a href="index.php">Voltar</a>
    </div>
</body>

</html>