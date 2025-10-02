// Funcionalidad de búsqueda en FAQ
document.getElementById('faq-search').addEventListener('input', function () {
    const searchValue = this.value.toLowerCase();
    document.querySelectorAll('.faq-item').forEach(function (item) {
        const text = item.innerText.toLowerCase();
        item.style.display = text.includes(searchValue) ? 'block' : 'none';
    });
});

// Funcionalidad de filtros por categoría
document.querySelectorAll('.filter-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        const category = this.getAttribute('data-category');
        document.querySelectorAll('.faq-item').forEach(function (item) {
            item.style.display = item.getAttribute('data-category') === category || category === 'all' ? 'block' : 'none';
        });

        // Marcar el botón activo
        document.querySelectorAll('.filter-btn').forEach(function (btn) {
            btn.classList.remove('active');
        });
        this.classList.add('active');
    });
});