document.addEventListener('DOMContentLoaded', () => {
    const btnClear = document.getElementById('btn-clear-filters');
    if (btnClear) {
        btnClear.addEventListener('click', () => {
            // Redireciona para a rota base sem parâmetros
            const baseUrl = btnClear.closest('form').getAttribute('action');
            window.location.href = baseUrl;
        });
    }
});