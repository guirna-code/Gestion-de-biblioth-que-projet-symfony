// JS for templates/book/edit.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('book-edit.js loaded');
    // warn when leaving with unsaved changes
    var form = document.querySelector('.book-edit form');
    if (!form) return;
    var initial = new FormData(form);
    window.addEventListener('beforeunload', function (e) {
        var current = new FormData(form);
        for (var key of current.keys()) {
            if (current.get(key) !== initial.get(key)) { e.preventDefault(); e.returnValue = ''; break; }
        }
    });
});
