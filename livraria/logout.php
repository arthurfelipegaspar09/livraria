<?php
require 'init.php';

unset($_SESSION['usuario_logado'], $_SESSION['perfil_logado']);
$_SESSION['mensagem'] = ['tipo' => 'sucesso', 'texto' => 'Você saiu da conta.'];
header('Location: index.php');
exit;
