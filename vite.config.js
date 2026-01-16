import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  server: {
    host: 'omahsehatbanyuwangi.test',
    port: 5173,
    strictPort: true,
    cors: true,
    origin: 'http://omahsehatbanyuwangi.test:5173',
  },
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
      refresh: true,
    }),
    tailwindcss(),
  ]
})