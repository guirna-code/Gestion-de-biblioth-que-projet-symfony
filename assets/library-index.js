// JS for templates/library/index.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('library-index.js loaded');
    // make catalog cards keyboard focusable
    document.querySelectorAll('.library-index .card').forEach(function (c) {
        c.setAttribute('tabindex', '0');
    });
});
