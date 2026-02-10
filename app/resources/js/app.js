import './bootstrap';

/**** Script para abrir/fechar o dropdown ****/
const dropdownButton = document.getElementById('userDropdownButton');
const dropdownContent = document.getElementById('dropdownContent');

dropdownButton.addEventListener('click', function () {
    const isOpen = dropdownContent.classList.contains('hidden');
    if (isOpen) {
        dropdownContent.classList.remove('hidden');
    } else {
        dropdownContent.classList.add('hidden');
    }
});

// Fechar o dropdown se clicar fora dele
window.addEventListener('click', function (event) {
    if (!dropdownButton.contains(event.target) && !dropdownContent.contains(event.target)) {
        dropdownContent.classList.add('hidden');
    }
});

/**** Apresentar e ocultar sidebar ****/
document.getElementById('toggleSidebar').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('sidebar-open');
});

document.getElementById('closeSidebar').addEventListener('click', function () {
    document.getElementById('sidebar').classList.remove('sidebar-open');
});

/**** Alterna entre tema claro e escuro ****/
document.addEventListener("DOMContentLoaded", function () {

    // Obter o elemento <html> para manipular a classe dark
    const htmlElement = document.documentElement;

    // Obter o id do botão tema claro e escuro
    const themeToggle = document.getElementById("themeToggle");

    // Obter o id do ícone escuro
    const iconMoon = document.getElementById("iconMoon");

    // Obter o id do ícone claro
    const iconSun = document.getElementById("iconSun");

    // Função para alternar os ícones claro e escuro
    function updateIcons() {
        if (htmlElement.classList.contains("dark")) {
            iconMoon.classList.remove("hidden");
            iconSun.classList.add("hidden");
        } else {
            iconMoon.classList.add("hidden");
            iconSun.classList.remove("hidden");
        }
    }

    // Aplicar o tema salvo no localStorage ou a preferência do sistema
    const isDarkMode = localStorage.theme === "dark" || // Se o localStorage.theme for "dark", ativa o modo escuro
        (!("theme" in localStorage) && window.matchMedia("(prefers-color-scheme: dark)").matches);
    // Se NÃO houver um tema salvo no localStorage, verifica se o sistema está em dark mode

    htmlElement.classList.toggle("dark", isDarkMode);
    updateIcons(); // Atualiza os ícones na inicialização

    // Evento de clique para alternar o tema e os ícones
    themeToggle.addEventListener("click", function () {
        htmlElement.classList.toggle("dark");
        localStorage.theme = htmlElement.classList.contains("dark") ? "dark" : "light";
        updateIcons(); // Atualiza os ícones após alterar o tema
    });
});

// SweetAlert2 para mensagens de confirmação de exclusão
window.confirmDelete = function (id) {
    Swal.fire({
  title: "Você tem certeza?",
  text: "Essa ação não pode ser desfeita!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#d33",
  cancelButtonColor: "#028529",
  confirmButtonText: "Sim, pode excluir!",
  cancelButtonText: "Não, cancelar!"
}).then((result) => {
  if (result.isConfirmed) {
    document.getElementById(`delete-form-${id}`).submit();
  }
});
}