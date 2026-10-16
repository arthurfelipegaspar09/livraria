<?php
require 'init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastro.php');
    exit;
}

$nome      = trim($_POST['nome'] ?? '');
$email     = trim($_POST['email'] ?? '');
$senha     = $_POST['senha'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';

$erro = '';

if ($nome === '' || $email === '' || $senha === '') {
    $erro = 'Preencha todos os campos.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erro = 'E-mail inválido.';
} elseif (strlen($senha) < 6) {
    $erro = 'A senha deve ter pelo menos 6 caracteres.';
} elseif ($senha !== $confirmar) {
    $erro = 'As senhas não conferem.';
} else {
    foreach ($_SESSION['usuarios'] as $usuario) {
        if (strcasecmp($usuario['email'], $email) === 0) {
            $erro = 'Este e-mail já está cadastrado.';
            break;
        }
    }
}

if ($erro !== '') {
    $_SESSION['dados_cadastro'] = ['nome' => $nome, 'email' => $email];
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => $erro];
    header('Location: cadastro.php');
    exit;
}

$_SESSION['usuarios'][] = ['nome' => $nome, 'email' => $email, 'senha' => $senha, 'perfil' => 'cliente'];


session_regenerate_id(true);
$_SESSION['usuario_logado'] = $nome;
$_SESSION['perfil_logado']  = 'cliente';
$_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Conta criada com sucesso! Bem-vindo(a), ' . $nome . '!'];
header('Location: index.php');
exit;
