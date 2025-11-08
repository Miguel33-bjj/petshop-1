<?php
require_once __DIR__ . '/db/conexao.php';
include 'layout_header.php';

try {
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar produtos: " . $e->getMessage());
}
?>

<div class="container py-5">
  <h2 class="text-center text-success mb-4">🛍️ Nossos Produtos</h2>

  <?php if (count($produtos) === 0): ?>
    <p class="text-center">Nenhum produto cadastrado ainda.</p>
  <?php else: ?>
    <div class="row">
      <?php foreach ($produtos as $p): ?>
        <div class="col-md-4 col-sm-6 mb-4">
          <div class="card shadow-sm border-0">
            <img 
              src="<?php echo !empty($p['imagem']) ? htmlspecialchars($p['imagem']) : 'https://via.placeholder.com/400x250?text=Sem+Imagem'; ?>" 
              class="card-img-top" 
              alt="<?php echo htmlspecialchars($p['nome']); ?>"
              style="height: 220px; object-fit: cover;"
            >
            <div class="card-body text-center">
              <h5 class="card-title text-success"><?php echo htmlspecialchars($p['nome']); ?></h5>
              <p class="card-text" style="min-height: 60px;">
                <?php echo htmlspecialchars($p['descricao']); ?>
              </p>
              <p class="fw-bold fs-5 text-success">
                R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?>
              </p>
              <button class="btn btn-outline-success w-100">Comprar</button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include 'layout_footer.php'; ?>
