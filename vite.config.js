import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //     host: '10.10.10.154', // Ganti dengan host yang diinginkan, misalnya 'localhost' atau '127.0.0.1'
    //     port: 5713,
    //     hmr: {
    //         host: '10.10.10.154', // Sesuaikan dengan host di atas, misalnya 'localhost'
    //     },
    // }
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    base: process.env.VITE_BASE_URL || '/',
    build: {
        manifest: true,
        outDir: 'public/build',
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                style: 'resources/css/app.css',
            },
            output: {
                manualChunks: undefined,
            },
        },
    },
});
