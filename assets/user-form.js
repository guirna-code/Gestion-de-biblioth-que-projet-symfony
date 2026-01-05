// JS for templates/user/_form.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('user-form.js loaded');

    // basic client-side form helper: focus first invalid field after server render
    var firstInvalid = document.querySelector('.is-invalid, .has-error');
    if (firstInvalid) firstInvalid.focus && firstInvalid.focus();
});
