// JS for templates/user/edit.html.twig
document.addEventListener('DOMContentLoaded', function () {
    console.log('user-edit.js loaded');
    // confirm before navigating away if form is dirty
    var form = document.querySelector('.user-edit form');
    if (!form) return;
    var initial = new FormData(form);
    window.addEventListener('beforeunload', function (e) {
        var current = new FormData(form);
        for (var key of current.keys()) {
            if (current.get(key) !== initial.get(key)) {
                e.preventDefault(); e.returnValue = ''; break;
            }
        }
    });
});
