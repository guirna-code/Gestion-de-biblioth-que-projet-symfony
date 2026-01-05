// JS for templates/emprunt/index.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('emprunt-index.js loaded');
    // simple table enhancements: highlight row on hover
    document.querySelectorAll('.emprunt-index tbody tr').forEach(function (tr) {
        tr.addEventListener('mouseenter', function () { tr.classList.add('hover'); });
        tr.addEventListener('mouseleave', function () { tr.classList.remove('hover'); });
    });
});
