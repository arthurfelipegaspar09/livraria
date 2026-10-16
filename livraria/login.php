<?php
require 'init.php';

if (logado()) {
    header('Location: index.php');
    exit;
}

$emailAnterior = $_SESSION['email_anterior'] ?? '';
unset($_SESSION['email_anterior']);

$titulo = 'Login';
include 'includes/cabecalho.php';
?>
<section class="caixa-formulario">
    <h2>Entrar</h2>
    <form class="formulario" action="autenticar.php" method="post">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="<?= h($emailAnterior) ?>" required>

        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required>

        <label class="mostrar-senha">
            <input type="checkbox" onclick="document.getElementById('senha').type = this.checked ? 'text' : 'password'">
            Mostrar senha
        </label>

        <button type="submit" class="botao">Entrar</button>
        <p class="link-extra">Ainda não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
    </form>
</section>
<?php include 'includes/rodape.php'; ?>
