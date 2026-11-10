// @ts-check
import { defineConfig } from 'astro/config';
import cloudflare from '@astrojs/cloudflare';
import edgeFiles from './integrations/edge-files.mjs';

// Every route is prerendered (AD-1). Code that runs per request will live only
// under src/pages/api/ and opt out of prerendering there.
export default defineConfig({
  site: 'https://tonegliseavalenciennes.fr',
  output: 'static',
  trailingSlash: 'always',
  build: {
    format: 'directory',
  },
  // No server-side sessions: the adapter would otherwise bind a KV namespace,
  // and the site keeps no visitor state (AD-1).
  session: false,
  adapter: cloudflare({
    // Images are optimised at build time only, never on demand (AD-1).
    imageService: 'compile',
  }),
  integrations: [edgeFiles()],
});
