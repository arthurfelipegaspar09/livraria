<?php
require 'init.php';

if (logado()) {
    header('Location: index.php');
    exit;
}

$antigo = $_SESSION['dados_cadastro'] ?? ['nome' => '', 'email' => ''];
unset($_SESSION['dados_cadastro']);

$titulo = 'Criar conta';
include 'includes/cabecalho.php';
?>
<section class="caixa-formulario">
    <h2>Criar conta</h2>
    <form class="formulario" action="cadastrar.php" method="post">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" value="<?= h($antigo['nome']) ?>" required>

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="<?= h($antigo['email']) ?>" required>

        <label for="senha">Senha (mínimo 6 caracteres)</label>
        <input type="password" id="senha" name="senha" minlength="6" required>

        <label for="confirmar">Confirmar senha</label>
        <input type="password" id="confirmar" name="confirmar" minlength="6" required>

        <button type="submit" class="botao">Cadastrar</button>
        <p class="link-extra">Já tem conta? <a href="login.php">Entrar</a></p>
    </form>
</section>
<?php include 'includes/rodape.php'; ?>
