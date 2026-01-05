// JS for templates/book/index.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('book-index.js loaded');
    // attach delegated delete confirmation for buttons inside index if data-confirm used
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('button[data-confirm]');
        if (!btn) return;
        var message = btn.getAttribute('data-confirm') || 'Are you sure?';
        if (!confirm(message)) e.preventDefault();
    });
});
