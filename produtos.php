<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/db/conexao.php'; // Caminho corrigido

if (!isset($pdo)) {
    die("Erro: conexão com o banco não foi estabelecida.");
}


// Busca produtos do banco
try {
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar produtos: " . $e->getMessage());
}

include 'layout_header.php';
?>

<div class="container my-5">
  <h2 class="text-center mb-4 text-success">🛍️ Nossos Produtos</h2>

  <?php if (count($produtos) === 0): ?>
    <p class="text-center text-muted">Nenhum produto cadastrado ainda.</p>
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
              <h5 class="card-title text-success fw-bold"><?php echo htmlspecialchars($p['nome']); ?></h5>
              <p class="card-text text-muted" style="min-height: 60px;">
                <?php echo htmlspecialchars($p['descricao']); ?>
              </p>
              <p class="fw-bold fs-5 text-success">
                R$ <?php echo number_format($p['preco'], 2, ',', '.'); ?>
              </p>
              <button class="btn btn-success px-4">Comprar</button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php include 'layout_footer.php'; ?>
