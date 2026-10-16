<?php
require 'init.php';
$titulo = 'Catálogo';


$busca     = trim($_GET['q'] ?? '');
$categoria = $_GET['categoria'] ?? '';
$ordem     = $_GET['ordem'] ?? '';

$lista = [];
foreach ($_SESSION['produtos'] as $id => $livro) {
    $cat = $livro['categoria'] ?? 'Outros';

    if ($categoria !== '' && $cat !== $categoria) {
        continue;
    }
    if ($busca !== '' &&
        mb_stripos($livro['nome'], $busca) === false &&
        mb_stripos($livro['autor'], $busca) === false) {
        continue;
    }
    $lista[$id] = $livro;
}

if ($ordem === 'menor') {
    uasort($lista, function ($a, $b) { return $a['preco'] <=> $b['preco']; });
} elseif ($ordem === 'maior') {
    uasort($lista, function ($a, $b) { return $b['preco'] <=> $a['preco']; });
} elseif ($ordem === 'nome') {
    uasort($lista, function ($a, $b) { return strcasecmp($a['nome'], $b['nome']); });
}

include 'includes/cabecalho.php';
?>
<section>
    <h2>Nossos livros</h2>

    <form class="filtros" action="index.php" method="get">
        <input type="text" name="q" placeholder="Buscar por título ou autor" value="<?= h($busca) ?>">

        <select name="categoria">
            <option value="">Todas as categorias</option>
            <?php foreach (categorias() as $c): ?>
                <option value="<?= h($c) ?>" <?= $categoria === $c ? 'selected' : '' ?>><?= h($c) ?></option>
            <?php endforeach; ?>
        </select>

        <select name="ordem">
            <option value="">Ordenar por</option>
            <option value="nome"  <?= $ordem === 'nome'  ? 'selected' : '' ?>>Nome (A-Z)</option>
            <option value="menor" <?= $ordem === 'menor' ? 'selected' : '' ?>>Menor preço</option>
            <option value="maior" <?= $ordem === 'maior' ? 'selected' : '' ?>>Maior preço</option>
        </select>

        <button type="submit" class="botao">Filtrar</button>
        <a class="botao secundario" href="index.php">Limpar</a>
    </form>

    <p class="resultado"><?= count($lista) ?> livro(s) encontrado(s)</p>

    <?php if (count($lista) === 0): ?>
        <p class="vazio">Nenhum livro encontrado com esses filtros.</p>
    <?php endif; ?>

    <div class="cards">
        <?php foreach ($lista as $id => $livro): ?>
            <article class="card">
                <div class="capa" style="background: <?= cor_capa($livro['nome']) ?>;">
                    <span><?= h($livro['nome']) ?></span>
                </div>

                <div class="conteudo">
                    <span class="etiqueta"><?= h($livro['categoria'] ?? 'Outros') ?></span>
                    <h3><?= h($livro['nome']) ?></h3>
                    <p class="autor"><?= h($livro['autor']) ?></p>
                    <p class="descricao"><?= h($livro['descricao']) ?></p>
                    <p class="preco"><?= formatar_preco($livro['preco']) ?></p>

                    <?php if (eh_admin()): ?>
                        <div class="acoes">
                            <a class="botao" href="produto-form.php?id=<?= $id ?>">Editar</a>
                            <form action="produto-excluir.php" method="post"
                                  onsubmit="return confirm('Excluir este livro?');">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <button type="submit" class="botao perigo">Excluir</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php include 'includes/rodape.php'; ?>
