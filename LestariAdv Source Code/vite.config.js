import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    // server: {
    //     host: 'localhost', // atau '127.0.0.1'
    //     port: 8000,
    //     cors: {
    //         origin: ['http://localhost:8000', 'http://127.0.0.1:8000'],
    //         credentials: true,
    //     },
    // },
});
