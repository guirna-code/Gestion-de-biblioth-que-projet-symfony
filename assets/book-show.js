// JS for templates/book/show.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('book-show.js loaded');
    // optional: add keyboard shortcut 'e' to go to edit when on focus
    document.addEventListener('keydown', function (ev) {
        if (ev.key.toLowerCase() === 'e') {
            var edit = document.querySelector('a[href*="/edit"]');
            if (edit) window.location = edit.href;
        }
    });
});
