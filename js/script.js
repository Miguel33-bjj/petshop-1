document.addEventListener("DOMContentLoaded", function() {
  const form = document.querySelector("form");

  // Se o formulário de cadastro de produto tiver um id ou classe específica
  if (form && form.classList.contains("cadastro_produto")) {

    form.addEventListener("submit", function(e) {
      const ok = confirm("Deseja realmente cadastrar este produto?");
      if (!ok) {
        e.preventDefault(); // impede o envio do formulário se cancelar
      }
    });
  }
});
