document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('[id^="show-more"]');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const categoryId = this.getAttribute('data-category-id');
            const page = this.getAttribute('data-page');
            
            // Perbaikan di sini
            const buttonId = this.id;
            let containerId;
            
            if (buttonId === 'show-more-trending') {
                containerId = 'trending-courses-container';
            } else if (buttonId === 'show-more-deaf') {
                containerId = 'deaf-courses-container';
            } else if (buttonId === 'show-more-visited') {
                containerId = 'visited-courses-container';
            }

            const container = document.getElementById(containerId);
            if (!container) {
                console.error(`Container with id ${containerId} not found`);
                return;
            }

            fetch(`/courses/load-more?page=${page}&category_id=${categoryId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        container.insertAdjacentHTML('beforeend', data.html);
                        if (!data.hasMorePages) {
                            this.style.display = 'none';
                        } else {
                            this.setAttribute('data-page', parseInt(page) + 1);
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
