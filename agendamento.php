<?php
require_once __DIR__ . '/db/conexao.php';
session_start();

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pet_nome = trim($_POST['pet_nome']);
    $servico = trim($_POST['servico']);
    $data_agendada = trim($_POST['data_agendada']);
    $telefone = trim($_POST['telefone']);
    $usuario_id = $_SESSION['usuario']['id'] ?? null;

    if (!$usuario_id) {
        $mensagem = "⚠️ É necessário estar logado para agendar um serviço.";
    } else {
        try {
            // Cria tabela se ainda não existir
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS agendamentos (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    usuario_id INTEGER,
                    pet_nome TEXT,
                    servico TEXT,
                    telefone TEXT,
                    data_agendada TEXT,
                    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
                )
            ");

            // Insere o agendamento
            $stmt = $pdo->prepare("
                INSERT INTO agendamentos (usuario_id, pet_nome, servico, telefone, data_agendada)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$usuario_id, $pet_nome, $servico, $telefone, $data_agendada]);

            $mensagem = "✅ Agendamento realizado com sucesso!";
        } catch (PDOException $e) {
            $mensagem = "Erro ao agendar: " . $e->getMessage();
        }
    }
}

include 'layout_header.php';
?>

<div class="container py-5">
  <div class="card mx-auto p-4 shadow-sm" style="max-width: 600px;">
    <h3 class="text-center text-success mb-4">🐶 Agendar Serviço</h3>

    <?php if ($mensagem): ?>
      <div class="alert alert-info text-center"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nome do Pet</label>
        <input type="text" class="form-control" name="pet_nome" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Serviço</label>
        <select class="form-select" name="servico" required>
          <option value="">Selecione</option>
          <option>Banho</option>
          <option>Tosa</option>
          <option>Consulta Veterinária</option>
          <option>Vacinação</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Telefone de Contato</label>
        <input type="tel" class="form-control" name="telefone" placeholder="(XX) XXXXX-XXXX" required pattern="\(\d{2}\)\s?\d{4,5}-\d{4}">
      </div>

      <div class="mb-3">
        <label class="form-label">Data e Hora</label>
        <input type="datetime-local" class="form-control" name="data_agendada" required>
      </div>

      <button class="btn btn-success w-100">Confirmar Agendamento</button>
    </form>
  </div>
</div>

<?php include 'layout_footer.php'; ?>
