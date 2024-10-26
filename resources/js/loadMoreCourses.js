// let page = 2; // Mulai dari halaman 2, karena halaman 1 sudah ditampilkan

// document.getElementById('show-more').addEventListener('click', function() {
//     fetch(`/courses/load-more?page=${page}`, {
//         headers: {
//             'X-Requested-With': 'XMLHttpRequest' // Penting untuk menandai request sebagai AJAX
//         }
//     })
//     .then(response => response.text()) // Mengambil response sebagai text (HTML)
//     .then(data => {
//         if (data) {
//             // Menambahkan HTML yang di-load ke container kursus
//             document.getElementById('courses-container').insertAdjacentHTML('beforeend', data);
//             page++; // Increment halaman setiap kali data berhasil dimuat
//         } else {
//             // Sembunyikan tombol jika tidak ada kursus lagi
//             document.getElementById('show-more').style.display = 'none';
//         }
//     })
//     .catch(error => console.error('Error:', error));
// });

// resources/js/loadMoreCourses.js
// document.addEventListener('DOMContentLoaded', function() {
//     let page = 2;
//     const loadMoreBtn = document.getElementById('show-more');
//     const coursesContainer = document.querySelector('.grid');

//     if (loadMoreBtn) {
//         loadMoreBtn.addEventListener('click', function() {
//             page++;
//             loadMoreCourses(page);
//         });
//     }

//     function loadMoreCourses(page) {
//         fetch(`/courses/load-more?page=${page}`, {
//             headers: {
//                 'X-Requested-With': 'XMLHttpRequest'
//             }
//         })
//         .then(response => response.text())
//         .then(data => {
//             if (data.trim().length === 0) {
//                 loadMoreBtn.style.display = 'none';
//                 return;
//             }
//             // Append new content to the existing grid
//             coursesContainer.insertAdjacentHTML('beforeend', data);
//         })
//         .catch(error => console.error('Error:', error));
//     }
// });

// document.addEventListener('DOMContentLoaded', function() {
//     let page = 1;
//     const loadMoreBtn = document.getElementById('show-more');
//     const coursesContainer = document.querySelector('.grid');
//     let isLoading = false;

//     if (loadMoreBtn) {
//         loadMoreBtn.addEventListener('click', function() {
//             if (!isLoading) {
//                 isLoading = true;
//                 loadMoreBtn.textContent = 'Loading...';
//                 page++;
//                 loadMoreCourses(page);
//             }
//         });
//     }

//     function loadMoreCourses(page) {
//         fetch(`/courses/load-more?page=${page}`, {
//             headers: {
//                 'X-Requested-With': 'XMLHttpRequest'
//             }
//         })
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error('Network response was not ok');
//             }
//             return response.text();
//         })
//         .then(data => {
//             if (data.trim().length === 0) {
//                 loadMoreBtn.style.display = 'none';
//                 return;
//             }
//             // Append new content to the existing grid
//             coursesContainer.insertAdjacentHTML('beforeend', data);
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             loadMoreBtn.style.display = 'none';
//         })
//         .finally(() => {
//             isLoading = false;
//             loadMoreBtn.textContent = 'Show More';
//         });
//     }
// });

document.addEventListener('DOMContentLoaded', function() {
    let page = 1;
    const loadMoreBtn = document.getElementById('show-more');
    const coursesContainer = document.querySelector('.grid');
    let isLoading = false;

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            if (!isLoading) {
                isLoading = true;
                loadMoreBtn.textContent = 'Loading...';
                page++;
                loadMoreCourses(page);
            }
        });
    }

    function loadMoreCourses(page) {
        fetch(`/courses/load-more?page=${page}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.html) {
                coursesContainer.insertAdjacentHTML('beforeend', data.html);
                
                // Only hide button if there are no more pages
                if (!data.hasMorePages) {
                    loadMoreBtn.style.display = 'none';
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loadMoreBtn.textContent = 'Error loading more courses';
        })
        .finally(() => {
            isLoading = false;
            loadMoreBtn.textContent = 'Show More';
        });
    }
});