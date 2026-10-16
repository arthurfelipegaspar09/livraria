<?php
require 'init.php';
exigir_admin();

$id = $_GET['id'] ?? null;
$livro = ['nome' => '', 'autor' => '', 'categoria' => '', 'preco' => '', 'descricao' => ''];

if ($id !== null) {
    if (!isset($_SESSION['produtos'][$id])) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Livro não encontrado.'];
        header('Location: index.php');
        exit;
    }
    $livro = $_SESSION['produtos'][$id] + ['categoria' => ''];
}

$titulo = $id !== null ? 'Editar livro' : 'Novo livro';
include 'includes/cabecalho.php';
?>
<section class="caixa-formulario">
    <h2><?= h($titulo) ?></h2>
    <form class="formulario" action="produto-salvar.php" method="post">
        <input type="hidden" name="id" value="<?= h($id) ?>">

        <label for="nome">Título</label>
        <input type="text" id="nome" name="nome" value="<?= h($livro['nome']) ?>" required>

        <label for="autor">Autor</label>
        <input type="text" id="autor" name="autor" value="<?= h($livro['autor']) ?>" required>

        <label for="categoria">Categoria</label>
        <select id="categoria" name="categoria" required>
            <option value="">Selecione</option>
            <?php foreach (categorias() as $c): ?>
                <option value="<?= h($c) ?>" <?= $livro['categoria'] === $c ? 'selected' : '' ?>><?= h($c) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="preco">Preço (R$)</label>
        <input type="number" id="preco" name="preco" step="0.01" min="0" value="<?= h($livro['preco']) ?>" required>

        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" rows="4" required><?= h($livro['descricao']) ?></textarea>

        <button type="submit" class="botao">Salvar</button>
        <a class="botao secundario" href="index.php">Cancelar</a>
    </form>
</section>
<?php include 'includes/rodape.php'; ?>
