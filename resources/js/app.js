import './bootstrap';

document.addEventListener('submit', function (event) {
    const form = event.target;

    if (form.matches('form[data-confirm]')) {
        const pesan = form.dataset.confirm || 'Yakin ingin melanjutkan?';

        if (!window.confirm(pesan)) {
            event.preventDefault(); 
        }
    }
});
