document.addEventListener('DOMContentLoaded', () => {
    const toggleHighContrast = document.getElementById('toggle-high-contrast');
    const toggleColorBlind = document.getElementById('toggle-color-blind');
    const body = document.body;

    // Check existing modes from localStorage
    if (localStorage.getItem('highContrastMode') === 'enabled') {
        body.classList.add('high-contrast');
        toggleHighContrast.innerText = 'Disable High Contrast';
    }

    if (localStorage.getItem('colorBlindMode') === 'enabled') {
        body.classList.add('color-blind-mode');
        toggleColorBlind.innerText = 'Disable Color Blind Mode';
    }

    // Toggle High Contrast Mode
    toggleHighContrast.addEventListener('click', () => {
        if (body.classList.contains('high-contrast')) {
            body.classList.remove('high-contrast');
            localStorage.setItem('highContrastMode', 'disabled');
            toggleHighContrast.innerText = 'Enable High Contrast';
        } else {
            // Turn off Color Blind Mode if active
            if (body.classList.contains('color-blind-mode')) {
                body.classList.remove('color-blind-mode');
                localStorage.setItem('colorBlindMode', 'disabled');
                toggleColorBlind.innerText = 'Enable Color Blind Mode';
            }
            body.classList.add('high-contrast');
            localStorage.setItem('highContrastMode', 'enabled');
            toggleHighContrast.innerText = 'Disable High Contrast';
        }
    });

    // Toggle Color Blind Mode
    toggleColorBlind.addEventListener('click', () => {
        if (body.classList.contains('color-blind-mode')) {
            body.classList.remove('color-blind-mode');
            localStorage.setItem('colorBlindMode', 'disabled');
            toggleColorBlind.innerText = 'Enable Color Blind Mode';
        } else {
            // Turn off High Contrast Mode if active
            if (body.classList.contains('high-contrast')) {
                body.classList.remove('high-contrast');
                localStorage.setItem('highContrastMode', 'disabled');
                toggleHighContrast.innerText = 'Enable High Contrast';
            }
            body.classList.add('color-blind-mode');
            localStorage.setItem('colorBlindMode', 'enabled');
            toggleColorBlind.innerText = 'Disable Color Blind Mode';
        }
    });
});
