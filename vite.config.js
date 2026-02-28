import { resolve } from 'path';
import { nodePolyfills } from 'vite-plugin-node-polyfills';

export default {
  define: {
    'process.env.NODE_ENV': JSON.stringify('production'),
    'process.env': JSON.stringify({ NODE_ENV: 'production' }),
  },
  resolve: {
    alias: {
      process: 'process/browser',
      react: resolve(__dirname, 'node_modules/react'),
      'react-dom': resolve(__dirname, 'node_modules/react-dom'),
      'react/jsx-runtime': resolve(__dirname, 'node_modules/react/jsx-runtime.js'),
    },
    dedupe: ['react', 'react-dom', 'react/jsx-runtime'],
  },
  plugins: [
    nodePolyfills({
      include: ['process'],
      globals: { process: true },
    }),
    {
      name: 'process-polyfill-first',
      generateBundle(_, bundle) {
        const polyfill = `(function(){var p={env:{NODE_ENV:"production"}};var g=typeof window!=="undefined"?window:typeof self!=="undefined"?self:typeof globalThis!=="undefined"?globalThis:this;if(g)g.process=p})();`;
        for (const file of Object.values(bundle)) {
          if (file.type === 'chunk' && file.fileName.endsWith('.js')) {
            file.code = polyfill + file.code;
          }
        }
      },
    },
  ],
  build: {
    lib: {
      entry: resolve(__dirname, 'assets/entry.js'),
      name: 'GravityUIMarkdownEditor',
      fileName: () => 'gravity-editor.js',
      formats: ['iife'],
    },
    outDir: 'src/Resources/public/build',
    emptyOutDir: true,
    commonjsOptions: {
      transformMixedEsModules: true,
    },
    rollupOptions: {
      output: {
        inlineDynamicImports: true,
        assetFileNames: 'gravity-editor.[ext]',
      },
    },
  },
};
