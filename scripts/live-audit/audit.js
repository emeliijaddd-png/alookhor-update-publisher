/* Live PDP browser audit — loads the real product page and measures
   header/content geometry, served CSS version, and overlap. */
const fs = require('fs');
const puppeteer = require('puppeteer');

const URL = process.env.AUDIT_URL || 'https://alookhor.ir/product/%d8%a7%d9%84%d8%a8%d8%a7%d9%84%d9%88-%d8%ae%d8%b4%da%a9/';

const VIEWPORTS = [
  { name: 'desktop', width: 1614, height: 900 },
  { name: 'mobile', width: 390, height: 844 },
];

(async () => {
  const browser = await puppeteer.launch({
    headless: 'new',
    args: ['--no-sandbox', '--disable-dev-shm-usage', '--lang=fa-IR'],
  });
  const results = { url: URL, at: new Date().toISOString(), viewports: [] };

  for (const vp of VIEWPORTS) {
    const page = await browser.newPage();
    await page.setViewport({ width: vp.width, height: vp.height });
    const out = { name: vp.name, width: vp.width, height: vp.height };
    try {
      await page.goto(URL, { waitUntil: 'networkidle2', timeout: 90000 });
      await page.waitForSelector('.alookhor-alp', { timeout: 30000 });
    } catch (e) {
      out.navError = e.message.slice(0, 300);
    }
    try {
      await new Promise((r) => setTimeout(r, 3000));
      out.load = await page.evaluate(async () => {
        const q = (s) => document.querySelector(s);
        const R = (el) => {
          if (!el) return null;
          const b = el.getBoundingClientRect();
          return { t: +b.top.toFixed(1), b: +b.bottom.toFixed(1), l: +b.left.toFixed(1), h: +b.height.toFixed(1), w: +b.width.toFixed(1) };
        };
        // PDP marker comment
        let pdpVersion = null;
        const walker = document.createTreeWalker(document.documentElement, NodeFilter.SHOW_COMMENT);
        let n;
        while ((n = walker.nextNode())) {
          const m = /ALOOKHOR-PDP\s+v([\d.]+)/.exec(n.nodeValue || '');
          if (m) { pdpVersion = m[1]; break; }
        }
        // header candidates
        const akx = q('#akx-header');
        const mainbar = q('#akx-header .akx-mainbar');
        const topbar = q('#akx-header .akx-topbar') || q('#akx-header .akx-top-bar');
        const cs = mainbar ? getComputedStyle(mainbar) : null;
        const alp = q('.alookhor-alp');
        const band = q('.alp-hero-band');
        const gal = q('.alp-gallery');
        const info = q('.alp-info');
        const stage = q('.alp-stage');
        // served PDP css href + freshness
        let cssHref = null, cssHas206 = null, cssHas205 = null, cssHas204 = null;
        for (const sh of document.styleSheets) {
          if (sh.href && sh.href.includes('frontend-product')) {
            cssHref = sh.href;
            try {
              const txt = await (await fetch(sh.href, { cache: 'no-store' })).text();
              cssHas206 = txt.includes('BREATHING ROOM');
              cssHas205 = txt.includes('RENDER-TESTED FIXES');
              cssHas204 = txt.includes('FLUSH TO MENU');
            } catch (e) { cssHas206 = 'fetch-failed:' + e.message.slice(0, 80); }
            break;
          }
        }
        const mainbarR = R(mainbar);
        const galR = R(gal);
        const infoR = R(info);
        const bandR = R(band);
        const overlapWithMenu = mainbarR && galR
          ? { gallery: +(galR.t - mainbarR.b).toFixed(1), info: infoR ? +(infoR.t - mainbarR.b).toFixed(1) : null }
          : null;
        // what element is on top at the gallery stage center?
        let topElAtStage = null;
        if (stage) {
          const b = stage.getBoundingClientRect();
          const el = document.elementFromPoint(b.left + b.width / 2, Math.max(b.top + 40, 0));
          if (el) topElAtStage = (el.className && typeof el.className === 'string' ? el.className.slice(0, 60) : el.tagName);
        }
        return {
          title: document.title.slice(0, 60),
          pdpVersion,
          header: {
            akx: R(akx), topbar: R(topbar), mainbar: mainbarR,
            mainbarPosition: cs ? cs.position : null,
            mainbarZ: cs ? cs.zIndex : null,
            mainbarClasses: mainbar ? mainbar.className : null,
            isStuck: mainbar ? mainbar.classList.contains('is-stuck') : null,
            hasStuckBarClass: akx ? akx.classList.contains('akx-has-stuck-bar') : null,
            spacer: R(q('#akx-header .akx-mainbar-spacer')),
            bodyPaddingTop: getComputedStyle(document.body).paddingTop,
          },
          alp: {
            rect: R(alp),
            paddingTop: alp ? getComputedStyle(alp).paddingTop : null,
            band: bandR, gallery: galR, info: infoR,
          },
          overlapWithMenu,
          topElAtStage,
          scrollY: window.scrollY,
          scrollW: document.documentElement.scrollWidth,
          cssHref, cssHas206, cssHas205, cssHas204,
        };
      });
      await page.screenshot({ path: `shot-${vp.name}-top.png` });
    } catch (e) {
      out.measureError = e.message.slice(0, 300);
    }
    // scrolled state: scroll 600px, wait, re-measure mainbar overlap
    try {
      await page.evaluate(() => window.scrollTo(0, 600));
      await new Promise((r) => setTimeout(r, 1200));
      out.scrolled = await page.evaluate(() => {
        const q = (s) => document.querySelector(s);
        const R = (el) => { if (!el) return null; const b = el.getBoundingClientRect(); return { t: +b.top.toFixed(1), b: +b.bottom.toFixed(1) }; };
        const mainbar = q('#akx-header .akx-mainbar');
        const stage = q('.alp-stage');
        return {
          scrollY: window.scrollY,
          mainbar: R(mainbar),
          isStuck: mainbar ? mainbar.classList.contains('is-stuck') : null,
          stage: R(stage),
        };
      });
      await page.screenshot({ path: `shot-${vp.name}-scrolled.png` });
    } catch (e) {
      out.scrollError = e.message.slice(0, 200);
    }
    results.viewports.push(out);
    await page.close();
  }
  await browser.close();
  fs.writeFileSync('results.json', JSON.stringify(results, null, 1));
  console.log('AUDIT-RESULT ' + JSON.stringify(results));
})().catch((e) => {
  fs.writeFileSync('results.json', JSON.stringify({ fatal: e.message }, null, 1));
  console.error('FATAL', e.message);
  process.exit(0); // still publish results
});
