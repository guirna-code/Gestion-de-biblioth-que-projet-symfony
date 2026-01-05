// JS for templates/library/confirmation.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('library-confirmation.js loaded');
    // optional: auto-redirect after 3 seconds if data-redirect attribute present
    var el = document.querySelector('.library-confirmation');
    if (el && el.dataset.redirect) {
        setTimeout(function () { window.location = el.dataset.redirect; }, 3000);
    }
});
