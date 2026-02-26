import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
  plugins: [
    laravel({
      input: ["resources/css/site.css", "resources/js/site.js"],
      refresh: [
        'resources/**',
        '**/*.php',
        'tailwind.config.js'
      ],
      buildDirectory: 'public/build',
    }),
    tailwindcss(),
  ],
  base: "./",
  server: {
    host: 'localhost',
    port: 5173,
    hmr: {
      host: 'localhost',
      port: 5173,
    },
    watch: {
      usePolling: true,
      interval: 100,
      include: [
        'resources/**/*',
        '**/*.php',
        'tailwind.config.js'
      ]
    },
    cors: true,
  },
});