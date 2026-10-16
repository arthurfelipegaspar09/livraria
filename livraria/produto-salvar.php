<?php
require 'init.php';
exigir_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id        = $_POST['id'] ?? '';
$nome      = trim($_POST['nome'] ?? '');
$autor     = trim($_POST['autor'] ?? '');
$categoria = $_POST['categoria'] ?? '';
$preco     = (float) ($_POST['preco'] ?? 0);
$descricao = trim($_POST['descricao'] ?? '');

if ($nome === '' || $autor === '' || $descricao === '' || $preco < 0 || !in_array($categoria, categorias())) {
    $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Preencha todos os campos corretamente.'];
    header('Location: produto-form.php' . ($id !== '' ? '?id=' . urlencode($id) : ''));
    exit;
}

$dados = ['nome' => $nome, 'autor' => $autor, 'categoria' => $categoria, 'preco' => $preco, 'descricao' => $descricao];

if ($id !== '' && isset($_SESSION['produtos'][$id])) {
    $_SESSION['produtos'][$id] = $dados;
    $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Livro atualizado!'];
} else {
    $novo = $_SESSION['proximo_id']++;
    $_SESSION['produtos'][$novo] = $dados;
    $_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Livro cadastrado!'];
}

header('Location: index.php');
exit;
