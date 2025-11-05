<?php
session_start();
require_once __DIR__ . '/conexao.php';

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
  header('Location: login.php');
  exit;
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = trim($_POST['nome']);
  $descricao = trim($_POST['descricao']);
  $preco = floatval($_POST['preco']);
  $imagem = trim($_POST['imagem']);

  if (empty($nome) || empty($preco)) {
    $mensagem = "⚠️ Preencha os campos obrigatórios (Nome e Preço).";
  } else {
    try {
      $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (:n, :d, :p, :i)");
      $stmt->execute([
        ':n' => $nome,
        ':d' => $descricao,
        ':p' => $preco,
        ':i' => $imagem
      ]);
      $mensagem = "✅ Produto cadastrado com sucesso!";
    } catch (PDOException $e) {
      $mensagem = "❌ Erro ao cadastrar produto: " . $e->getMessage();
    }
  }
}

include 'layout_header.php';
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
      <div class="card shadow p-4 border-0 rounded-4">
        <h3 class="text-center fw-bold text-success mb-4">🛒 Cadastro de Produto</h3>

        <?php if ($mensagem): ?>
          <div class="alert alert-info text-center"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>

        <form method="POST">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nome do Produto *</label>
            <input type="text" name="nome" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Descrição</label>
            <textarea name="descricao" class="form-control" rows="3"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Preço (R$) *</label>
            <input type="number" name="preco" class="form-control" step="0.01" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">URL da Imagem</label>
            <input type="text" name="imagem" class="form-control" placeholder="https://exemplo.com/imagem.jpg">
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-success btn-lg">Cadastrar Produto</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include 'layout_footer.php'; ?>
