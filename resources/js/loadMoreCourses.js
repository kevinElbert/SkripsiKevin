document.addEventListener('DOMContentLoaded', function() {
    let trendingPage = 2;
    let deafPage = 2;
    let disabilityPage = 2;
    
    const loadMoreTrendingBtn = document.getElementById('show-more-trending');
    const loadMoreDeafBtn = document.getElementById('show-more-deaf');
    const loadMoreDisabilityBtn = document.getElementById('show-more-disability');

    // Event listener untuk tombol "Show More" Trending Courses
    loadMoreTrendingBtn.addEventListener('click', function() {
        loadMoreCourses(trendingPage, 1, 'trending-courses-container', loadMoreTrendingBtn);
        trendingPage++;
    });

    // Event listener untuk tombol "Show More" Best Courses Deaf
    loadMoreDeafBtn.addEventListener('click', function() {
        loadMoreCourses(deafPage, 2, 'deaf-courses-container', loadMoreDeafBtn);
        deafPage++;
    });

    // Event listener untuk tombol "Show More" Disability Courses
    loadMoreDisabilityBtn.addEventListener('click', function() {
        loadMoreCourses(disabilityPage, 3, 'disability-courses-container', loadMoreDisabilityBtn);
        disabilityPage++;
    });

    // Fungsi untuk memuat lebih banyak kursus
    function loadMoreCourses(page, categoryId, containerId, button) {
        button.textContent = 'Loading...';
        
        fetch(`/courses/load-more?page=${page}&category_id=${categoryId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                document.getElementById(containerId).insertAdjacentHTML('beforeend', data.html);
                
                if (!data.hasMorePages) {
                    button.style.display = 'none';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.textContent = 'Error loading';
        })
        .finally(() => {
            button.textContent = 'Show More';
        });
    }
});
