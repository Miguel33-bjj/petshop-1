<?php
require_once __DIR__ . '/db/conexao.php';

$nome = "Administrador";
$email = "admin@petshop.com";
$senha = password_hash("123456", PASSWORD_DEFAULT);
$tipo = "admin";

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $email, $senha, $tipo]);
    echo "✅ Usuário administrador criado com sucesso!<br>";
    echo "Login: <b>$email</b><br>Senha: <b>123456</b>";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
