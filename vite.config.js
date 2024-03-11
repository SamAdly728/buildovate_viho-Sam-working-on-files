import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'; // Import path for alias resolution

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                // 'resources/assets/plugins/global/plugins.bundle.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            'vuetify/lib': path.resolve(__dirname, 'node_modules/vuetify/lib')
        }
    }
});
