document.addEventListener('DOMContentLoaded', function () {
    let trendingPage = 2;
    let deafPage = 2;
    let disabilityPage = 2;

    const loadMoreTrendingBtn = document.getElementById('show-more-trending');
    const loadMoreDeafBtn = document.getElementById('show-more-deaf');
    const loadMoreDisabilityBtn = document.getElementById('show-more-disability');

    // Debug: Cek apakah tombol terdeteksi
    console.log('Load more buttons initialized:', loadMoreTrendingBtn, loadMoreDeafBtn, loadMoreDisabilityBtn);

    // Validasi apakah tombol "Show More" Trending Courses ada
    if (loadMoreTrendingBtn) {
        loadMoreTrendingBtn.addEventListener('click', function () {
            console.log('Trending Show More clicked'); // Debug: Cek saat tombol diklik
            loadMoreCourses(trendingPage, 1, 'trending-courses-container', loadMoreTrendingBtn);
            trendingPage++;
        });
    }

    // Validasi apakah tombol "Show More" Best Courses Deaf ada
    if (loadMoreDeafBtn) {
        loadMoreDeafBtn.addEventListener('click', function () {
            console.log('Deaf Show More clicked'); // Debug: Cek saat tombol diklik
            loadMoreCourses(deafPage, 2, 'deaf-courses-container', loadMoreDeafBtn);
            deafPage++;
        });
    }

    // Validasi apakah tombol "Show More" Disability Courses ada
    if (loadMoreDisabilityBtn) {
        loadMoreDisabilityBtn.addEventListener('click', function () {
            console.log('Disability Show More clicked'); // Debug: Cek saat tombol diklik
            loadMoreCourses(disabilityPage, 3, 'disability-courses-container', loadMoreDisabilityBtn);
            disabilityPage++;
        });
    }

    // Fungsi untuk memuat lebih banyak kursus
    function loadMoreCourses(page, categoryId, containerId, button) {
        console.log(`Loading more courses for category ${categoryId} on page ${page}`); // Debug
        button.textContent = 'Loading...';

        fetch(`/courses/load-more?page=${page}&category_id=${categoryId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.json())
            .then(data => {
                console.log('Response data:', data); // Debug: Lihat data dari server
                if (data.html) {
                    document.getElementById(containerId).insertAdjacentHTML('beforeend', data.html);

                    if (!data.hasMorePages) {
                        button.style.display = 'none';
                    }
                } else {
                    console.log('No HTML data found'); // Debug: Jika tidak ada data HTML
                }
            })
            .catch(error => {
                console.error('Error:', error); // Debug: Tangani error
                button.textContent = 'Error loading';
            })
            .finally(() => {
                button.textContent = 'Show More';
            });
    }
});
