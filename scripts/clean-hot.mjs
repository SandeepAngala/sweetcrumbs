import { unlinkSync } from 'node:fs';

try {
    unlinkSync('public/hot');
} catch {
    // no stale hot file
}
