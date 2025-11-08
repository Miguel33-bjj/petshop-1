<?php
require_once __DIR__ . '/db/conexao.php';
session_start();

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $preco = floatval($_POST['preco']);
    $descricao = trim($_POST['descricao']);
    $imagem = trim($_POST['imagem']);

    try {
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, descricao, imagem) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $preco, $descricao, $imagem]);
        $mensagem = "✅ Produto cadastrado com sucesso!";
    } catch (PDOException $e) {
        $mensagem = "Erro ao cadastrar produto: " . $e->getMessage();
    }
}

include 'layout_header.php';
?>

<div class="container py-5">
  <div class="card mx-auto p-4 shadow-sm" style="max-width: 600px;">
    <h3 class="text-center text-success mb-4">🐾 Cadastrar Produto</h3>

    <?php if ($mensagem): ?>
      <div class="alert alert-info text-center"><?= htmlspecialchars($mensagem) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Nome do Produto</label>
        <input type="text" class="form-control" name="nome" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Preço (R$)</label>
        <input type="number" step="0.01" class="form-control" name="preco" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea class="form-control" name="descricao" rows="3"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">URL da Imagem (opcional)</label>
        <input type="text" class="form-control" name="imagem" placeholder="https://exemplo.com/imagem.jpg">
      </div>
      <button class="btn btn-success w-100">Salvar Produto</button>
    </form>
  </div>
</div>

<?php include 'layout_footer.php'; ?>
