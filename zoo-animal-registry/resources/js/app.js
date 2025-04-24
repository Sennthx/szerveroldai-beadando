import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    new TomSelect('#caretakers', {
        plugins: ['remove_button'],
        create: false,
        placeholder: 'Select caretakers...',
    });
});

document.addEventListener('DOMContentLoaded', function () {
    new TomSelect('#enclosure_id', {
        create: false,
        dropdownDirection: 'down',
        placeholder: 'Select an enclosure...',
    });
});

