// JS for templates/security/login.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('security-login.js loaded');
    // focus login username field
    var u = document.querySelector('input[name="_username"]');
    if (u) u.focus();
});
