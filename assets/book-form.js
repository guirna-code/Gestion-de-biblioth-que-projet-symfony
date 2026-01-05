// JS for templates/book/_form.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('book-form.js loaded');
    // example client-side isbn formatting (very light)
    var isbn = document.querySelector('input[name="book[isbn]"]');
    if (isbn) {
        isbn.addEventListener('blur', function () { isbn.value = isbn.value.replace(/[^0-9Xx-]/g, ''); });
    }
});
