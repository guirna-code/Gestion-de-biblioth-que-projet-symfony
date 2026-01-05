// JS for templates/user/new.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('user-new.js loaded');
    // simple enhancement: focus first text input on page load
    var firstText = document.querySelector('form input[type=text], form input[type=email], form textarea');
    if (firstText) firstText.focus();
});
