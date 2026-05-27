import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/alert.js',
                'resources/js/collection.js',
                'resources/js/dashboard.js',
                'resources/js/deleteModal.js',
                'resources/js/modal.js',
                'resources/js/password-check.js',
                'resources/js/rating.js',
                'resources/js/sort.js',
            ],
            refresh: true,
        }),
    ],
});