import './styles/emprunt-edit.css';

// Emprunt edit page behavior
(function(){
    const form = document.querySelector('form');
    if(!form) return;

    // Simple client-side validation: ensure required fields are filled
    form.addEventListener('submit', (e) => {
        const required = form.querySelectorAll('[required]');
        let valid = true;
        required.forEach(field => {
            field.classList.remove('input-error');
            const err = field.closest('.form-group')?.querySelector('.error-message');
            if(err) err.remove();
            if(!field.value || field.value.trim() === ''){
                valid = false;
                field.classList.add('input-error');
                const msg = document.createElement('div');
                msg.className = 'error-message';
                msg.textContent = 'Ce champ est requis';
                if(field.closest('.form-group')) field.closest('.form-group').appendChild(msg);
            }
        });
        if(!valid){
            e.preventDefault();
            const first = form.querySelector('.input-error');
            if(first) first.focus();
        }
    });

    // If a "dateRetourReelle" field exists, show/hide penalites input based on its value
    const dateReal = form.querySelector('[name="dateRetourReelle"]') || form.querySelector('[name="dateretourreel"]');
    const penalInput = form.querySelector('[name="penalites"]');
    if(dateReal && penalInput){
        function togglePenal(){
            const val = dateReal.value;
            if(!val || val.trim() === ''){
                penalInput.closest('.form-group').style.display = 'none';
                penalInput.value = '';
            } else {
                penalInput.closest('.form-group').style.display = '';
            }
        }
        togglePenal();
        dateReal.addEventListener('change', togglePenal);
    }

    // Add a small keyboard shortcut: Ctrl+S to submit
    window.addEventListener('keydown', (ev) => {
        if((ev.ctrlKey || ev.metaKey) && ev.key.toLowerCase() === 's'){
            ev.preventDefault();
            const submit = form.querySelector('[type="submit"]');
            if(submit) submit.click();
        }
    });

})();
