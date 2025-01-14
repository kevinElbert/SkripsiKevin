document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('[id^="show-more-category-"]');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const categoryId = this.getAttribute('data-category-id');
            const page = this.getAttribute('data-page');
            
            // Menggunakan ID container yang sesuai dengan kategori
            const containerId = `category-${categoryId}-container`;
            const container = document.getElementById(containerId);
            
            if (!container) {
                console.error(`Container with id ${containerId} not found`);
                return;
            }

            fetch(`/courses/load-more?page=${page}&category_id=${categoryId}`, {
                headers: { 
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
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