// Menghandle modal untuk Create Thread
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.querySelector('#create-thread-modal');
    const openModalButtons = document.querySelectorAll('[data-open-modal]');
    const closeModalButtons = document.querySelectorAll('[data-close-modal]');

    // Show modal
    openModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
    });

    // Hide modal
    closeModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    });
});
