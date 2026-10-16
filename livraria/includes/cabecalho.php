<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($titulo ?? 'Livraria') ?> - <?= h($_SESSION['infoSite']['nome']) ?></title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/catalogo.css">
    <link rel="stylesheet" href="css/formularios.css">
    <link rel="stylesheet" href="css/mensagens.css">
</head>
<body>
<header>
    <h1><?= h($_SESSION['infoSite']['nome']) ?></h1>
    <p><?= h($_SESSION['infoSite']['slogan']) ?></p>
    <nav>
        <a href="index.php">Catálogo</a>
        <?php if (logado()): ?>
            <?php if (eh_admin()): ?>
                <a href="produto-form.php">Novo livro</a>
            <?php endif; ?>
            <span class="usuario">Olá, <?= h($_SESSION['usuario_logado']) ?><?= eh_admin() ? ' (admin)' : '' ?></span>
            <a href="logout.php">Sair</a>
        <?php else: ?>
            <a href="login.php">Entrar</a>
            <a href="cadastro.php">Criar conta</a>
        <?php endif; ?>
    </nav>
</header>
<main>
<?php mostrar_mensagem(); ?>
