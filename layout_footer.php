</div> <!-- fecha .content do header -->

<footer class="text-center text-white py-5 mt-5" style="background: linear-gradient(90deg, #27ae60, #1e8449);">
  <div class="container">
    <h5 class="fw-bold mb-3">🐾 Pet Shop Online</h5>
    <p class="mb-4">Cuidando com amor, respeito e dedicação 💚</p>

    <!-- Ícones sociais -->
    <div class="d-flex justify-content-center gap-4 mb-4">
      <a href="#" class="text-white" aria-label="Facebook">
        <i class="bi bi-facebook fs-4"></i>
      </a>
      <a href="#" class="text-white" aria-label="Instagram">
        <i class="bi bi-instagram fs-4"></i>
      </a>
      <a href="#" class="text-white" aria-label="WhatsApp">
        <i class="bi bi-whatsapp fs-4"></i>
      </a>
    </div>

    <!-- Direitos autorais -->
    <p class="small mb-0">
      © <?php echo date('Y'); ?> <strong>Pet Shop Online</strong>. Todos os direitos reservados.
    </p>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Animação suave ao rolar (opcional) -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('a[href^="#"]');
    for (let link of links) {
      link.addEventListener('click', e => {
        e.preventDefault();
        const target = document.querySelector(link.getAttribute('href'));
        if (target) target.scrollIntoView({ behavior: 'smooth' });
      });
    }
  });
</script>

</body>
</html>
