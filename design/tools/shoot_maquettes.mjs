// usage: node shoot_maquettes.mjs <playwright module dir> <chrome binary> <design/maquettes dir>
// Full-page PNG next to each mockup: desktop at 1440 px, mobile at 390 px with 2x pixels.
import fs from 'node:fs'; import path from 'node:path'; import {createRequire} from 'node:module';
const [,, pw, bin, root] = process.argv;
const {chromium} = createRequire(import.meta.url)(pw);
const browser = await chromium.launch({executablePath: bin, args: ['--no-sandbox']});
for (const dir of fs.readdirSync(root)) {
  for (const f of fs.readdirSync(path.join(root, dir)).filter(f => f.endsWith('.html'))) {
    const mobile = f.endsWith('-mobile.html');
    const page = await browser.newPage({viewport: {width: mobile ? 390 : 1440, height: 900}, deviceScaleFactor: mobile ? 2 : 1});
    await page.goto('file://' + path.resolve(root, dir, f), {waitUntil: 'networkidle'});
    await page.evaluate(() => document.fonts.ready);
    await page.screenshot({path: path.join(root, dir, f.replace('.html', '.png')), fullPage: true});
    await page.close(); console.log(dir, f);
  }
}
await browser.close();
