// JS for templates/book/new.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('book-new.js loaded');
    var first = document.querySelector('form input, form select, form textarea');
    if (first) first.focus();
});
