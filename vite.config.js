import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    // server: {
    //     host: '0.0.0.0', // Escucha todas las interfaces
    //     port: 5173,
    //     strictPort: true,
    //     hmr: {
    //         //host: '192.168.18.47', // ← IP de tu servidor en red local
    //         host: '192.168.0.162',
    //     },
    // },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
