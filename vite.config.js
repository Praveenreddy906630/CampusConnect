import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        {
            name: 'redirect-to-laravel',
            configureServer(server) {
                server.middlewares.use((req, res, next) => {
                    if (req.url === '/' || req.url === '/index.html') {
                        res.statusCode = 302;
                        res.setHeader('Location', 'http://localhost:8000');
                        res.end();
                        return;
                    }
                    next();
                });
            }
        },
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
