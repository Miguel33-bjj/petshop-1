<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/db/conexao.php'; // Caminho corrigido

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario'] = $usuario;
            header("Location: index.php");
            exit;
        } else {
            $erro = "❌ E-mail ou senha inválidos.";
        }
    } catch (PDOException $e) {
        $erro = "Erro ao acessar o banco de dados: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - Pet Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fffdf8;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .btn-success {
      background-color: #1e8449;
      border: none;
      color: #fff;
      font-weight: 600;
    }
    .btn-success:hover {
      background-color: #166d3b;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4" style="max-width: 400px; width: 100%;">
      <h3 class="text-center text-success fw-bold mb-3">🐾 Entrar</h3>

      <?php if (!empty($erro)): ?>
        <div class="alert alert-danger text-center"><?= $erro ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <input type="email" class="form-control" name="email" placeholder="E-mail" required>
        </div>
        <div class="mb-3">
          <input type="password" class="form-control" name="senha" placeholder="Senha" required>
        </div>
        <button class="btn btn-success w-100">Entrar</button>
      </form>

      <p class="text-center mt-3">
        Não tem conta? <a href="cadastro.php" class="text-success fw-semibold">Cadastre-se</a>
      </p>
    </div>
  </div>
</body>
</html>
