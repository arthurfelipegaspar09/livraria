<?php
require 'init.php';
exigir_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? '';

if (isset($_SESSION['produtos'][$id])) {
    unset($_SESSION['produtos'][$id]);
    $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Livro excluído!'];
} else {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Livro não encontrado.'];
}

header('Location: index.php');
exit;
