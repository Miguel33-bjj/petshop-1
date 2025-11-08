<?php
$pdo = null;

try {
    // Caminho absoluto do banco dentro da pasta db
    $caminhoBanco = __DIR__ . '/petshop.db';

    // Cria a conexão
    $pdo = new PDO('sqlite:' . $caminhoBanco);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criação das tabelas, se não existirem
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            senha TEXT NOT NULL,
            tipo TEXT DEFAULT 'cliente' -- 'admin' ou 'cliente'
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
            pet_nome TEXT NOT NULL,
            servico TEXT NOT NULL,
            telefone TEXT NOT NULL,
            data_agendada TEXT NOT NULL,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        );
    ");
} catch (PDOException $e) {
    die('❌ Erro na conexão com o banco de dados: ' . $e->getMessage());
}
?>
