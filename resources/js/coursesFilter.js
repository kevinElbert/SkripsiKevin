// document.addEventListener('DOMContentLoaded', function() {
//     const searchInput = document.querySelector('input[type="text"]');
//     const filterButtons = document.querySelectorAll('.filter-button');
//     let activeFilters = new Set();

//     // Add class to filter buttons for easier selection
//     document.querySelectorAll('.bg-blue-500').forEach(button => {
//         button.classList.add('filter-button');
//     });

//     // Handle search input
//     searchInput.addEventListener('input', debounce(function() {
//         fetchFilteredCourses();
//     }, 300));

//     // Handle filter button clicks
//     filterButtons.forEach(button => {
//         button.addEventListener('click', function() {
//             const filter = this.textContent.toLowerCase();
            
//             if (activeFilters.has(filter)) {
//                 activeFilters.delete(filter);
//                 this.classList.remove('bg-blue-700');
//                 this.classList.add('bg-blue-500');
//             } else {
//                 activeFilters.add(filter);
//                 this.classList.remove('bg-blue-500');
//                 this.classList.add('bg-blue-700');
//             }

//             fetchFilteredCourses();
//         });
//     });

//     // Fetch filtered courses from the server
//     function fetchFilteredCourses() {
//         const searchQuery = searchInput.value;
//         const filters = Array.from(activeFilters);

//         fetch(`/api/filter-courses`, {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
//             },
//             body: JSON.stringify({
//                 search: searchQuery,
//                 filters: filters
//             })
//         })
//         .then(response => response.json())
//         .then(data => {
//             updateCourseGrid(data.courses);
//         })
//         .catch(error => console.error('Error:', error));
//     }

//     // Update the course grid with filtered results
//     function updateCourseGrid(courses) {
//         const courseGrid = document.querySelector('.grid');
//         courseGrid.innerHTML = '';

//         courses.forEach(course => {
//             const courseCard = `
//                 <div class="bg-white shadow-md rounded-md p-4">
//                     <img src="${course.image}" alt="${course.title}" class="w-full rounded-t-md">
//                     <h4 class="text-xl font-bold my-2">${course.title}</h4>
//                     <p class="text-gray-600">${course.description}</p>
//                     ${course.isLoggedIn 
//                         ? `<a href="/courses/${course.slug}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md block text-center">Click me</a>`
//                         : `<a href="/login" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded-md block text-center">Login to access</a>`
//                     }
//                 </div>
//             `;
//             courseGrid.insertAdjacentHTML('beforeend', courseCard);
//         });
//     }

//     // Debounce function to limit API calls
//     function debounce(func, wait) {
//         let timeout;
//         return function executedFunction(...args) {
//             const later = () => {
//                 clearTimeout(timeout);
//                 func(...args);
//             };
//             clearTimeout(timeout);
//             timeout = setTimeout(later, wait);
//         };
//     }
// });