<?php
require 'init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

foreach ($_SESSION['usuarios'] as $usuario) {
    if (strcasecmp($usuario['email'], $email) === 0 && $usuario['senha'] === $senha) {
        session_regenerate_id(true);
        $_SESSION['usuario_logado'] = $usuario['nome'];
        $_SESSION['perfil_logado']  = $usuario['perfil'] ?? 'cliente';
        $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Bem-vindo(a), ' . $usuario['nome'] . '!'];
        header('Location: index.php');
        exit;
    }
}

$_SESSION['email_anterior'] = $email;
$_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'E-mail ou senha incorretos.'];
header('Location: login.php');
exit;
