import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    // server: {
    //     watch: {
    //         usePolling: true,
    //     },
    //     host: '0.0.0.0',
    //     hmr: {
    //         host: 'localhost',
    //         clientPort: 8080
	//
    //     },
    // },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            // refresh: true,
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
