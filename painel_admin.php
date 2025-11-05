<?php
session_start();
include 'layout_header.php';
include 'conexao.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['email'])) {
  header("Location: login.php");
  exit;
}

// Busca os agendamentos com nome do usuário (JOIN com tabela usuarios)
try {
  $stmt = $pdo->query("
    SELECT 
      a.id,
      u.nome AS cliente,
      a.pet_nome,
      a.servico,
      a.data_agendada
    FROM agendamentos a
    LEFT JOIN usuarios u ON a.usuario_id = u.id
    ORDER BY a.data_agendada DESC
  ");
  $agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Erro ao carregar agendamentos: " . $e->getMessage());
}
?>

<div class="container py-5">
  <h3 class="text-center text-success fw-bold mb-4">📋 Agendamentos Realizados</h3>

  <?php if (empty($agendamentos)): ?>
    <p class="text-center text-muted">Nenhum agendamento encontrado.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-hover table-bordered shadow-sm">
        <thead class="text-white" style="background-color: #1e8449;">
          <tr>
            <th>Cliente</th>
            <th>Pet</th>
            <th>Serviço</th>
            <th>Data</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($agendamentos as $ag): ?>
            <tr style="background-color: #e9f9f1;">
              <td><?= htmlspecialchars($ag['cliente'] ?? '—') ?></td>
              <td><?= htmlspecialchars($ag['pet_nome']) ?></td>
              <td><?= htmlspecialchars($ag['servico']) ?></td>
              <td><?= htmlspecialchars(date('d/m/Y', strtotime($ag['data_agendada']))) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php include 'layout_footer.php'; ?>
