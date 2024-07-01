<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php');
    exit();
}

include_once './config/config.php';
include_once './classes/Usuario.php';
include_once './classes/Noticia.php';

$usuario = new Usuario($db);
$noticia = new Noticia($db);

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    $usuario->deletar($id_usuario);
    header('Location: portal.php'); // Redirecionar para a página principal após a exclusão
    exit();
} elseif (isset($_GET['id_noticia'])) {
    $id_noticia = $_GET['id_noticia'];
    $noticia->deletar($id_noticia);
    header('Location: noticias.php'); // Redirecionar para a página de notícias após a exclusão
    exit();
} else {
    // Tratar outros casos, se necessário
    header('Location: portal.php'); // Redirecionar para a página principal por padrão
    exit();
}
?>
