// JS for templates/user/index.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('user-index.js loaded');
    // small helper: row click to follow first link (if any)
    document.querySelectorAll('.user-index tbody tr').forEach(function (tr) {
        tr.addEventListener('click', function (e) {
            if (e.target.tagName.toLowerCase() === 'a' || e.target.closest('a')) return;
            var a = tr.querySelector('a');
            if (a) window.location = a.href;
        });
    });
});
