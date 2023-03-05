import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/sass/admin/app.scss',
                'resources/assets/sass/frontend/app.scss',
                'resources/assets/sass/panel/app.scss',
                'resources/assets/js/frontend/frontend.js',
                'resources/assets/js/panel/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
