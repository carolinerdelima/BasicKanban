import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
        server: {
        host: '0.0.0.0',
        port: 5175,
        strictPort: true,
        hmr: { host: 'localhost' },
    },
});
