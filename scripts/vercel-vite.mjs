/**
 * Vercel / CI frontend build — Node only (no PHP).
 * Invoked directly: node scripts/vercel-vite.mjs
 */
import { execSync } from 'node:child_process';
import { existsSync } from 'node:fs';
import { dirname, join } from 'node:path';
import { fileURLToPath } from 'node:url';

const root = join(dirname(fileURLToPath(import.meta.url)), '..');
const viteBin = join(root, 'node_modules', 'vite', 'bin', 'vite.js');

if (!existsSync(viteBin)) {
    console.error('Vite not found. Run npm ci before building.');
    process.exit(1);
}

execSync(`node "${viteBin}" build`, { stdio: 'inherit', cwd: root, env: process.env });
