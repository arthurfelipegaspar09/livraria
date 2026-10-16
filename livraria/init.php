<?php
session_start();


if (!isset($_SESSION['iniciado'])) {

    $_SESSION['infoSite'] = [
        'nome'     => 'Livraria Página Viva',
        'slogan'   => 'Boas histórias para todos os leitores',
        'email'    => 'contato@paginaviva.com',
        'telefone' => '(11) 4002-8922',
        'endereco' => 'Rua das Letras, 100 - São Paulo/SP'
    ];

    $_SESSION['usuarios'] = [
        ['nome' => 'Administrador', 'email' => 'admin@livraria.com', 'senha' => '123456', 'perfil' => 'admin'],
        ['nome' => 'Maria Leitora', 'email' => 'maria@livraria.com', 'senha' => 'abc123', 'perfil' => 'cliente']
    ];

    $_SESSION['produtos'] = [
        1 => ['nome' => 'Dom Casmurro',       'autor' => 'Machado de Assis',         'categoria' => 'Clássicos',         'preco' => 29.90, 'descricao' => 'Clássico da literatura brasileira sobre ciúme e dúvida.'],
        2 => ['nome' => 'O Pequeno Príncipe', 'autor' => 'Antoine de Saint-Exupéry', 'categoria' => 'Infantil',          'preco' => 24.50, 'descricao' => 'Uma fábula poética sobre amizade e o essencial.'],
        3 => ['nome' => '1984',               'autor' => 'George Orwell',            'categoria' => 'Ficção científica', 'preco' => 39.90, 'descricao' => 'Distopia sobre vigilância e controle do pensamento.'],
        4 => ['nome' => 'A Hora da Estrela',  'autor' => 'Clarice Lispector',        'categoria' => 'Romance',           'preco' => 27.00, 'descricao' => 'A história de Macabéa, uma jovem nordestina no Rio de Janeiro.'],
        5 => ['nome' => 'O Hobbit',           'autor' => 'J. R. R. Tolkien',         'categoria' => 'Fantasia',          'preco' => 44.90, 'descricao' => 'A aventura de Bilbo Bolseiro e uma companhia de anões.'],
        6 => ['nome' => 'Código Limpo',       'autor' => 'Robert C. Martin',         'categoria' => 'Técnicos',          'preco' => 89.90, 'descricao' => 'Boas práticas para escrever software legível e fácil de manter.']
    ];

    $_SESSION['proximo_id'] = 7;
    $_SESSION['iniciado']   = true;
}

// ---------- Funções auxiliares ----------

function categorias() {
    return ['Romance', 'Clássicos', 'Fantasia', 'Ficção científica', 'Infantil', 'Técnicos'];
}

function cor_capa($nome) {
    $cores = ['#8d3b2f', '#2f5d8d', '#3b7a57', '#7a4b8d', '#b07a2a', '#2f7a7a'];
    return $cores[crc32($nome) % count($cores)];
}

function logado() {
    return isset($_SESSION['usuario_logado']);
}

function eh_admin() {
    return logado() && ($_SESSION['perfil_logado'] ?? '') === 'admin';
}

function exigir_admin() {
    exigir_login();
    if (!eh_admin()) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Apenas o administrador pode fazer isso.'];
        header('Location: index.php');
        exit;
    }
}

function exigir_login() {
    if (!logado()) {
        $_SESSION['mensagem'] = ['tipo' => 'erro', 'texto' => 'Faça login para acessar esta página.'];
        header('Location: login.php');
        exit;
    }
}

function formatar_preco($valor) {
    return 'R$ ' . number_format($valor, 2, ',', '.');
}

function h($texto) {
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

function mostrar_mensagem() {
    if (isset($_SESSION['mensagem'])) {
        $m = $_SESSION['mensagem'];
        echo '<p class="mensagem ' . h($m['tipo']) . '">' . h($m['texto']) . '</p>';
        unset($_SESSION['mensagem']);
    }
}
