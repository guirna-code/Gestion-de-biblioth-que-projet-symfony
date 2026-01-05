// JS for templates/emprunt/_form.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('emprunt-form.js loaded');
    // enhance date inputs: focus selects
    document.querySelectorAll('.emprunt-form input[type=date]').forEach(function (d) { d.placeholder = d.placeholder || 'YYYY-MM-DD'; });
});
