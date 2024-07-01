<?php
session_start();
include_once './config/config.php';
include_once './classes/Usuario.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = new Usuario($db);
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $fone = $_POST['fone'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($usuario->criar($nome, $sexo, $fone, $email, $senha)) {
        // Redireciona para o portal após o registro bem-sucedido
        header('Location: login.php');
        exit();
    } else {
        $mensagem = 'Erro ao criar usuário. Verifique os dados e tente novamente.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/registrar.css">
    <title>Adicionar Usuário</title>
</head>

<body>
    <div class="box">
        <h1>Cadastro de Usuário</h1>
        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" placeholder="Insira seu nome" required><br><br>

            <label for="sexo">Sexo:</label>
            <input type="radio" name="sexo" value="M" required> Masculino
            <input type="radio" name="sexo" value="F" required> Feminino<br><br>

            <label for="fone">Telefone:</label>
            <input type="text" name="fone" placeholder="Insira seu telefone" required><br><br>

            <label for="email">E-mail:</label>
            <input type="email" name="email" placeholder="Insira seu e-mail" required><br><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" placeholder="Insira sua senha" required><br><br>

            <input type="submit" value="Salvar">
        </form>

        <p class="mensagem"><?php echo $mensagem; ?></p>
        <a href="crud_usuario.php">Voltar</a>
    </div>
</body>

</html>
