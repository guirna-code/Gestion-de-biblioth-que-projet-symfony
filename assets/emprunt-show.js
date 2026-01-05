// JS for templates/emprunt/show.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('emprunt-show.js loaded');
    // collapse/expand details if present
    document.querySelectorAll('.emprunt-show .toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = document.querySelector(btn.dataset.target);
            if (!target) return;
            target.hidden = !target.hidden;
        });
    });
});
