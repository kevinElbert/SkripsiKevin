import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/loadMoreCourses.js', 
                'resources/js/coursesFilter.js',
                'resources/js/modalHandler.js',
                'resources/js/likeHandler.js',
                'resources/js/tts.js',
                'resources/js/highContrast.js',
            ],
            refresh: true,
        }),
    ],
});
