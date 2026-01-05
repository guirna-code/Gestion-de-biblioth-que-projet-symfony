// JS for templates/book/_delete_form.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('book-delete-form.js loaded');
    // unobtrusive confirm helper: attach to buttons with data-confirm
    document.querySelectorAll('button[data-confirm]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            var message = btn.getAttribute('data-confirm') || 'Are you sure?';
            if (!confirm(message)) e.preventDefault();
        });
    });
});
