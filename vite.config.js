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
            host: 'https://1l8s70v1-5173.asse.devtunnels.ms',
            // port: 5173,      // Default Vite port
            //  // Replace with your custom host or IP
        },
    },  
});
