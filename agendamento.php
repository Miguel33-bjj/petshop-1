<?php
session_start();

// Exibe erros (ótimo pra debug)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/db/conexao.php'; // Caminho certo da conexão

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Quando o formulário for enviado:
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pet = trim($_POST['pet']);
    $servico = trim($_POST['servico']);
    $data = $_POST['data'];

    if ($pet && $servico && $data) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO agendamentos (usuario_id, pet, servico, data)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->execute([$_SESSION['usuario']['id'], $pet, $servico, $data]);
            $msg = "✅ Agendamento realizado com sucesso!";
        } catch (PDOException $e) {
            $msg = "❌ Erro ao agendar: " . $e->getMessage();
        }
    } else {
        $msg = "⚠️ Preencha todos os campos!";
    }
}

include 'layout_header.php';
?>

<div class="container my-5">
  <h2 class="text-center text-success fw-bold mb-4">📅 Agende um Serviço</h2>

  <?php if (!empty($msg)): ?>
    <div class="alert alert-info text-center"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <form method="POST" class="mx-auto" style="max-width: 500px;">
    <div class="mb-3">
      <label for="pet" class="form-label fw-bold">Nome do Pet:</label>
      <input type="text" name="pet" id="pet" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="servico" class="form-label fw-bold">Serviço:</label>
      <select name="servico" id="servico" class="form-select" required>
        <option value="">Selecione...</option>
        <option value="Banho e Tosa">Banho e Tosa</option>
        <option value="Consulta Veterinária">Consulta Veterinária</option>
        <option value="Vacinação">Vacinação</option>
        <option value="Hospedagem">Hospedagem</option>
        <option value="Tosa Higiênica">Tosa Higiênica</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="data" class="form-label fw-bold">Data do Agendamento:</label>
      <input type="date" name="data" id="data" class="form-control" required>
    </div>

    <div class="text-center">
      <button type="submit" class="btn btn-success px-4">Agendar</button>
    </div>
  </form>
</div>

<?php include 'layout_footer.php'; ?>
