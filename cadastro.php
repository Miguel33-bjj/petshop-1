<?php
session_start();
require_once __DIR__ . '/conexao.php';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome  = trim($_POST['nome']);
  $email = trim($_POST['email']);
  $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

  try {
    // Cadastra novo usuário
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:n, :e, :s)");
    $stmt->execute([':n' => $nome, ':e' => $email, ':s' => $senha]);

    // Login automático
    $_SESSION['usuario'] = [
      'nome' => $nome,
      'email' => $email
    ];

    header('Location: index.php');
    exit;
  } catch (PDOException $e) {
    if (str_contains($e->getMessage(), 'UNIQUE')) {
      $mensagem = "❌ Este e-mail já está cadastrado.";
    } else {
      $mensagem = "Erro no cadastro: " . $e->getMessage();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro - Pet Shop</title>
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
    .btn-warning {
      background-color: #ffb300;
      border: none;
      color: #222;
      font-weight: 600;
    }
    .btn-warning:hover {
      background-color: #ffa000;
      color: #fff;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4" style="max-width: 400px; width: 100%;">
      <h3 class="text-center text-warning fw-bold mb-3">🐾 Criar Conta</h3>

      <?php if ($mensagem): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($mensagem) ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="mb-3">
          <input type="text" class="form-control" name="nome" placeholder="Nome completo" required>
        </div>
        <div class="mb-3">
          <input type="email" class="form-control" name="email" placeholder="E-mail" required>
        </div>
        <div class="mb-3">
          <input type="password" class="form-control" name="senha" placeholder="Senha" required>
        </div>
        <button class="btn btn-warning w-100">Cadastrar e Continuar</button>
      </form>

      <p class="text-center mt-3">
        Já tem conta? <a href="login.php" class="text-warning fw-semibold">Entrar</a>
      </p>
    </div>
  </div>
</body>
</html>
