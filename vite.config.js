import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    // server: {
    //     host: '0.0.0.0', // Escucha todas las interfaces
    //     port: 5174,
    //     strictPort: true,
    //     hmr: {
    //         host: '192.168.18.47', // ← IP de tu servidor en red local
    //     },
    // },
    server: {
        host: true
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app-back.js',
                'resources/js/app-front.js',
                'resources/js/bootstrap.js',
                'resources/js/app-back.js',],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
