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
                'resources/js/voiceControl.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: 'true', // Allow access from all network interfaces
        hmr: {
            host: 'https://skripsikevin-production.up.railway.app',
            // port: 5173,      // Default Vite port
            //  // Replace with your custom host or IP
        },
    }, 
});
