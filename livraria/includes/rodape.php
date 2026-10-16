</main>
<footer>
    <p><strong><?= h($_SESSION['infoSite']['nome']) ?></strong> - <?= h($_SESSION['infoSite']['slogan']) ?></p>
    <p><?= h($_SESSION['infoSite']['endereco']) ?></p>
    <p><?= h($_SESSION['infoSite']['email']) ?> | <?= h($_SESSION['infoSite']['telefone']) ?></p>
</footer>
</body>
</html>
