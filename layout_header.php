<?php
// Inicia a sessão apenas se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Pet Shop Online 🐾</title>
  
  <!-- Ícone do site -->
  <link rel="icon" type="image/png" href="logo.png">
  
  <!-- Bootstrap e Ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Estilos -->
  <style>
    body {
      background-color: #e9f9f1;
      font-family: 'Poppins', sans-serif;
      color: #145a32;
    }

    .navbar {
      background: linear-gradient(90deg, #1e8449, #27ae60);
    }

    .navbar-brand {
      font-weight: 700;
      color: white !important;
    }

    .nav-link {
      color: #e9f9f1 !important;
      font-weight: 500;
      transition: 0.3s;
    }

    .nav-link:hover {
      color: #c3f3d1 !important;
    }

    .btn-login {
      background-color: #e9f9f1;
      color: #1e8449;
      border-radius: 25px;
      padding: 5px 20px;
      font-weight: 600;
      transition: 0.3s;
      border: none;
    }

    .btn-login:hover {
      background-color: #d4f5e3;
      color: #145a32;
    }
  </style>
</head>

<body>

  <!-- 🌿 Navbar -->
  <nav class="navbar navbar-expand-lg shadow-sm">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="logo.png" alt="Pet Shop Online" width="45" height="45" class="me-2">
        <span>Pet Shop Online</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuNav">
        <span class="navbar-toggler-icon text-light"></span>
      </button>

      <div class="collapse navbar-collapse" id="menuNav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
          <li class="nav-item"><a class="nav-link" href="produtos.php">Produtos</a></li>
          <li class="nav-item"><a class="nav-link" href="agendamento.php">Agendamento</a></li>

          <?php if (isset($_SESSION['usuario'])): ?>
            <li class="nav-item"><a class="nav-link" href="perfil.php">Meu Perfil</a></li>

            <?php if ($_SESSION['usuario']['tipo'] === 'admin'): ?>
              <li class="nav-item"><a class="nav-link" href="admin_agendamentos.php">Painel Admin</a></li>
            <?php endif; ?>

            <li class="nav-item"><a class="btn btn-login ms-2" href="logout.php">Sair</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="btn btn-login ms-2" href="login.php">Entrar</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="content">
