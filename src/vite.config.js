import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vuetify from 'vite-plugin-vuetify';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ]
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false
                }
            }
        }),
        vuetify({ autoImport: true }),
    ],
    resolve: {
        alias: {
            // For Vue 3, use the ES module build that includes the compiler
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        // watch: {
        //     usePolling: true,
        // },
        hmr: {
            // If you're running Vite on a different host than your frontend, you may need to set the client URL explicitly
            clientPort: 5173,
            // Use the public hostname of your Docker service for HMR to work properly
            host: process.env.HMR_HOST || 'localhost',
        },
    },
});

