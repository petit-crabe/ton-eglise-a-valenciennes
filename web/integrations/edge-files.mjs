// Writes the edge files that depend on the deployment environment:
// robots.txt and _headers. Static assets are served before any Worker code
// runs, so these files, not the request host, decide what search engines see.
// The environment comes from the branch Workers Builds is building (AD-10):
// only `main` is production; any other branch, or no branch at all, is not.
//
// Later stories extend `headersFile` (security headers, Content-Security-Policy).

import { readFile, writeFile } from 'node:fs/promises';
import { fileURLToPath } from 'node:url';
import path from 'node:path';

const PRODUCTION_BRANCH = 'main';
const WORKERS_DEV_HOSTS = 'https://:version.:account.workers.dev/*';

/** @param {string | undefined} branch */
export function siteEnvFromBranch(branch) {
  return branch === PRODUCTION_BRANCH ? 'production' : 'non-production';
}

/** @param {string} siteEnv */
export function robotsFile(siteEnv) {
  if (siteEnv === 'production') {
    return ['User-agent: *', 'Allow: /', ''].join('\n');
  }
  return ['User-agent: *', 'Disallow: /', ''].join('\n');
}

/** @param {string} siteEnv */
export function headersFile(siteEnv) {
  /** @type {string[]} */
  const lines = ['# Generated at build by integrations/edge-files.mjs; do not edit.'];
  if (siteEnv !== 'production') {
    lines.push('/*', '  X-Robots-Tag: noindex');
  } else {
    // preview_urls gives every production version its own workers.dev link;
    // keep those copies out of search results too (AD-10). A host placeholder
    // matches one DNS label, and a rule may hold only one splat.
    lines.push(WORKERS_DEV_HOSTS, '  X-Robots-Tag: noindex');
  }
  lines.push('');
  return lines.join('\n');
}

/** @returns {import('astro').AstroIntegration} */
export default function edgeFiles() {
  return {
    name: 'edge-files',
    hooks: {
      'astro:build:done': async ({ dir, logger }) => {
        const branch = process.env.WORKERS_CI_BRANCH;
        const siteEnv = siteEnvFromBranch(branch);
        const outDir = fileURLToPath(dir);
        await writeFile(path.join(outDir, 'robots.txt'), robotsFile(siteEnv));
        // The Cloudflare adapter's own build:done hook may already have written
        // rules here (immutable caching of /_astro/*); keep them after ours.
        const headersPath = path.join(outDir, '_headers');
        const existing = await readFile(headersPath, 'utf-8').catch(() => '');
        await writeFile(headersPath, headersFile(siteEnv) + existing);
        logger.info(
          `SITE_ENV=${siteEnv} (WORKERS_CI_BRANCH=${branch ?? 'unset'}); wrote robots.txt and _headers to ${outDir}`,
        );
      },
    },
  };
}
