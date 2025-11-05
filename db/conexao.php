<?php
// Inicializa a variável de conexão
$pdo = null;

try {
    // Caminho absoluto para o banco de dados SQLite
    $dbDir = __DIR__ . '/data';
    $dbPath = $dbDir . '/petshop.db';

    // Garante que a pasta 'data' exista (útil no GitHub Codespaces)
    if (!is_dir($dbDir)) {
        mkdir($dbDir, 0777, true);
    }

    // Cria o arquivo do banco, se não existir
    if (!file_exists($dbPath)) {
        touch($dbPath);
        chmod($dbPath, 0666); // Dá permissão de leitura e escrita
    }

    // Conecta ao banco de dados SQLite
    $pdo = new PDO('sqlite:' . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria tabelas automaticamente, se não existirem
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            senha TEXT NOT NULL
        );

        CREATE TABLE IF NOT EXISTS produtos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            preco REAL NOT NULL,
            descricao TEXT,
            imagem TEXT
        );

        CREATE TABLE IF NOT EXISTS agendamentos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            usuario_id INTEGER,
            pet_nome TEXT,
            servico TEXT,
            data_agendada TEXT,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        );
    ");
} catch (PDOException $e) {
    die("❌ Erro na conexão com o banco: " . $e->getMessage());
}
?>
