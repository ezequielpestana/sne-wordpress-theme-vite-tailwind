import { defineConfig } from 'vite';
import { resolve } from 'path';
import fullReload from 'vite-plugin-full-reload';

export default defineConfig({
  plugins: [
    fullReload(['**/*.php']),
  ],
  build: {
    manifest: true,
    outDir: 'assets/dist',
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'assets/src/main.js'),
      },
    },
  },
  server: {
    host: 'localhost',
    port: 3000,
    strictPort: true,
    origin: 'http://localhost:3000',
    allowedHosts: true,
    cors: {
      origin: '*',
    },
    hmr: {
      host: 'localhost',
      protocol: 'ws',
      port: 3000,
      clientPort: 3000,
    },
    watch: {
      usePolling: true,
      interval: 50,
    },
  },
  // Adicionar arquivos PHP para observação
  optimizeDeps: {
    exclude: [],
  },
});
