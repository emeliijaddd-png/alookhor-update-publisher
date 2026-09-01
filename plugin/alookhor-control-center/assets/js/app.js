// Release query prevents stale ES Modules after a WordPress-native update.
import { initResponsive } from './core/responsive.js?v=3.10.203';
import { initUpdater, Updater } from './core/updateSystem.js?v=3.10.203';
import { Config } from './core/config.js?v=3.10.203';
import { dashboardModule } from './modules/dashboard.js?v=3.10.203';
import { inventoryModule } from './modules/inventory.js?v=3.10.203';
import { ordersModule } from './modules/orders.js?v=3.10.203';
import { usersModule } from './modules/users.js?v=3.10.203';
import { analyticsModule } from './modules/analytics.js?v=3.10.203';
import { settingsModule } from './modules/settings.js?v=3.10.203';

const modules = {
  dashboard: dashboardModule,
  inventory: inventoryModule,
  orders: ordersModule,
  users: usersModule,
  analytics: analyticsModule
};

function escapeHTML(value){
  return String(value ?? '').replace(/[&<>'"]/g, char => ({
    '&':'&amp;', '<':'&lt;', '>':'&gt;', "'":'&#039;', '"':'&quot;'
  })[char]);
}

// ——— placeholder ساز لوکس برای منوهای جدید بدون ماژول واقعی ———
function makePlaceholder(id, title, subtitle, icon='◐'){
  return {
    meta: { id, title },
    init(container){
      container.innerHTML = `
        <div class="page-head">
          <div>
            <h2>${title}</h2>
            <p>${subtitle}</p>
          </div>
          <div class="head-actions">
            <button class="btn-ghost" onclick="window.ALOOKHOR.toast('فیلتر لوکس در آپدیت بعدی','info')">فیلتر</button>
            <button class="btn-gold" onclick="window.ALOOKHOR.toast('این بخش به زودی فعال می‌شود','info')">+ افزودن</button>
          </div>
        </div>
        <div class="panel">
          <div class="panel-head"><h3>${title} — پیش‌نمایش لوکس</h3><span style="font-size:11px; color:var(--text-faint)">PRO • به‌زودی</span></div>
          <div style="padding:28px 18px; text-align:center">
            <div style="width:56px; height:56px; border-radius:16px; background:rgba(201,168,106,0.10); border:1px solid var(--gold-border); display:grid; place-items:center; margin:0 auto; color:var(--gold); font-size:22px">${icon}</div>
            <h3 style="margin:14px 0 6px 0; font-family:'Cormorant Garamond', serif; font-size:20px">این بخش در دست توسعه است</h3>
            <p style="margin:0; color:var(--text-muted); font-size:13px; line-height:1.7">طراحی لوکس و ساختار دیتابیس آماده است — اتصال به API و منطق نهایی در آپدیت بعدی (v3.8) بدون تغییر معماری اضافه می‌شود.</p>
            <div style="max-width:420px; margin:18px auto 0 auto; background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); border-radius:12px; padding:12px; text-align:right">
              <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:6px"><span style="color:var(--text-muted)">پیشرفت طراحی</span><b style="color:var(--gold-soft)">۸۵٪</b></div>
              <div style="height:7px; background:rgba(255,255,255,0.06); border-radius:999px; overflow:hidden"><div style="width:85%; height:100%; background:linear-gradient(90deg,#C9A86A,#E8D5B5)"></div></div>
              <div style="font-size:11px; color:var(--text-faint); margin-top:8px">✔ UI لوکس &nbsp; ✔ ریسپانسیو &nbsp; ⏳ اتصال API</div>
            </div>
            <div style="margin-top:16px; display:flex; gap:8px; justify-content:center; flex-wrap:wrap">
              <button class="btn-ghost" style="padding:8px 14px; font-size:12px" onclick="window.ALOOKHOR.switchModule('dashboard')">بازگشت به داشبورد</button>
              <button class="btn-gold" style="padding:8px 16px; font-size:12px" onclick="document.getElementById('btnUpdateCenter').click()">مشاهده Update Center</button>
            </div>
          </div>
        </div>
      `;
    },
    destroy(){}
  }
}

// نگاشت نام‌های جدید به placeholder
const placeholderMap = {
  invoices: makePlaceholder('invoices','فاکتورها','مدیریت فاکتورهای رسمی و طلایی','◨'),
  quotes: makePlaceholder('quotes','پیش‌فاکتورها','پیش‌فاکتورهای VIP قبل از تایید نهایی','✦'),
  returns: makePlaceholder('returns','مرجوعی‌ها','مرجوعی و بازگشت با تایید مدیریت','↩'),
  products: makePlaceholder('products','محصولات','ویترین محصولات لوکس ALOOKHOR','◆'),
  categories: makePlaceholder('categories','دسته‌بندی‌ها','دسته‌بندی طلایی محصولات','▦'),
  collections: makePlaceholder('collections','کالکشن‌های لوکس','کالکشن‌های فصلی و اختصاصی','♛'),
  club: makePlaceholder('club','باشگاه طلایی','باشگاه مشتریان وفادار','★'),
  tickets: makePlaceholder('tickets','تیکت و پشتیبانی','پشتیبانی VIP — ۶ تیکت باز','☎'),
  reviews: makePlaceholder('reviews','نظرات و امتیاز','نظرات مشتریان بوتیک','☆'),
  transactions: makePlaceholder('transactions','تراکنش‌ها','تراکنش‌های مالی و درگاه‌ها','₮'),
  'gold-price': makePlaceholder('gold-price','قیمت لحظه‌ای طلا','قیمت آنلاین ۱۸ و ۲۴ عیار','◐'),
  accounting: makePlaceholder('accounting','حسابداری','حسابداری دوبل لوکس','≡'),
  'sales-report': makePlaceholder('sales-report','گزارش فروش','گزارش فروش روزانه / ماهانه','▭'),
  'stock-report': makePlaceholder('stock-report','گزارش انبار','گزارش موجودی و هشدارها','▤'),
  roles: makePlaceholder('roles','کاربران و دسترسی','مدیریت نقش‌ها و دسترسی‌ها','◈'),
  logs: makePlaceholder('logs','لاگ‌ها','لاگ سیستمی و امنیتی','≡'),
};

window.ALOOKHOR = {
  version: Updater.current,
  modules: { ...modules, ...placeholderMap, settings: settingsModule },
  active: 'settings',
  toast(msg, type='success'){
    const stack = document.getElementById('toastStack');
    if(!stack) return;
    const el = document.createElement('div');
    el.className = 'toast';
    const icon = type==='update' ? '✦' : type==='info' ? '◐' : '✓';
    el.innerHTML = `<div class="toast-icon">${icon}</div><div style="flex:1"><div style="font-weight:700; font-size:13px">${msg}</div><div style="font-size:12px; color:var(--text-muted); margin-top:2px">${new Date().toLocaleTimeString('fa-IR')}</div></div><button onclick="this.parentElement.remove()" style="background:none; border:0; color:var(--text-faint); cursor:pointer; font-size:16px">×</button>`;
    stack.appendChild(el);
    setTimeout(()=> { el.style.opacity='0'; el.style.transform='translateY(8px)'; setTimeout(()=>el.remove(),300)}, 4200);
  },
  switchModule(name){
    if(name==='update'){
      document.getElementById('btnUpdateCenter')?.click();
      return;
    }
    const target = this.modules[name];
    if(!target){
      this.toast('این بخش به زودی فعال می‌شود','info');
      return;
    }
    // active کلاس‌ها — هم nav-item تکی و هم nav-sub-item
    document.querySelectorAll('.nav-item, .nav-sub-item').forEach(n=> n.classList.toggle('active', n.dataset.module===name));
    // اگر آیتم داخل گروه بسته بود، گروه را باز کن
    const activeSub = document.querySelector(`.nav-sub-item[data-module="${name}"]`);
    if(activeSub){
      const group = activeSub.closest('.nav-group');
      if(group && !group.classList.contains('open')){
        group.classList.add('open');
      }
    }
    const container = document.getElementById('moduleContainer');
    this.modules[this.active]?.destroy?.();
    this.active = name;
    document.dispatchEvent(new CustomEvent('alookhor:module-switched', {detail:{name}}));
    container.style.opacity='0';
    container.style.transform='translateY(6px)';
    setTimeout(()=>{
      container.innerHTML='';
      target.init(container);
      container.style.transition='all 0.28s ease';
      container.style.opacity='1';
      container.style.transform='none';
      document.getElementById('pageTitle').textContent = target.meta.title;
      // در موبایل، بعد از انتخاب ببند
      if(window.innerWidth < 1024){
        document.getElementById('sidebar')?.classList.remove('open');
        document.getElementById('backdrop')?.classList.remove('show');
        document.body.style.overflow='';
      }
    }, 140);
    history.replaceState(null,'','#'+name);
  }
};

function initProNav(){
  // آکاردئون گروه‌ها
  document.querySelectorAll('.nav-group-head').forEach(head=>{
    head.addEventListener('click', ()=>{
      const group = head.parentElement;
      const isOpen = group.classList.contains('open');
      // حرفه‌ای: فقط یکی باز بماند در موبایل، در دسکتاپ چندتا باز می‌ماند — اینجا هوشمند: اگر با Ctrl کلیک شد، بقیه بسته نشوند
      if(!isOpen){
        // باز کردن
        group.classList.add('open');
      } else {
        group.classList.remove('open');
      }
    });
  });

  // کلیک روی آیتم‌های منو (تکی + زیرمنو)
  document.querySelectorAll('[data-module]').forEach(el=>{
    el.addEventListener('click', (e)=>{
      e.stopPropagation();
      const mod = el.dataset.module;
      window.ALOOKHOR.switchModule(mod);
    });
  });

  // جستجوی منو — فیلتر زنده
  const search = document.getElementById('menuSearch');
  if(search){
    search.addEventListener('input', ()=>{
      const q = search.value.trim().toLowerCase();
      const groups = document.querySelectorAll('.nav-group');
      const singles = document.querySelectorAll('.nav-item.single');

      // فیلتر تمام آیتم‌های اصلی (مدیریت بوتیک + داشبورد)
      singles.forEach(single=>{
        const txt = single.textContent.toLowerCase();
        single.style.display = (!q || txt.includes(q)) ? 'flex' : 'none';
      });

      groups.forEach(g=>{
        const headText = g.querySelector('.nav-group-title')?.textContent.toLowerCase() || '';
        const subs = g.querySelectorAll('.nav-sub-item');
        let hasVisible = false;
        subs.forEach(sub=>{
          const t = sub.textContent.toLowerCase();
          const show = !q || t.includes(q) || headText.includes(q);
          sub.style.display = show ? 'flex' : 'none';
          if(show) hasVisible = true;
        });
        // اگر سرچ خالی: حالت عادی (فقط openها نمایش)، اگر سرچ دارد: گروه‌های دارای نتیجه را باز کن
        if(q){
          g.style.display = hasVisible || headText.includes(q) ? 'block' : 'none';
          if(hasVisible) g.classList.add('open');
        } else {
          g.style.display = 'block';
          // به حالت قبل برگرد — دو گروه اول باز بماند
        }
      });
    });

    // کلید / برای فوکوس سرچ
    document.addEventListener('keydown', (e)=>{
      if(e.key === '/' && document.activeElement.tagName !== 'INPUT'){
        e.preventDefault();
        search.focus();
      }
    });
  }
}

// Update Center Modal
function initUpdateModal(updaterState){
  const modal = document.getElementById('updateModal');
  const backdrop = document.getElementById('modalBackdrop');
  const btnOpen = document.getElementById('btnUpdateCenter');
  const btnClose = document.getElementById('btnCloseModal');
  const btnInstall = document.getElementById('btnInstall');
  const btnDismiss = document.getElementById('btnDismiss');
  const changelogEl = document.getElementById('changelog');
  const verEl = document.getElementById('modalVersion');
  const statusBox = document.getElementById('updateStatusBox');
  const statusText = document.getElementById('updateStatusText');
  const statusMode = document.getElementById('updateStatusMode');

  function open(){
    const hasUpdate = updaterState.hasUpdate;
    const installable = updaterState.installable;
    const ver = updaterState.pending || Updater.current;
    verEl.textContent = hasUpdate ? `v${ver} آماده نصب است` : `v${Updater.current} — نسخه نصب‌شده`;
    btnInstall.style.display = hasUpdate ? 'inline-flex' : 'none';
    btnInstall.disabled = hasUpdate && !installable;
    btnInstall.textContent = installable ? 'نصب امن با WordPress' : 'بسته نصب در دسترس نیست';
    btnDismiss.textContent = hasUpdate ? 'بعداً' : 'بستن';

    if(statusText && statusMode && statusBox){
      if(!updaterState.configured){
        statusText.textContent = 'هسته آپدیت داخلی آماده است؛ آدرس Manifest هنوز تنظیم نشده';
        statusMode.textContent = 'Setup required';
        statusBox.style.background = 'rgba(201,168,106,0.08)';
        statusBox.style.borderColor = 'rgba(201,168,106,0.22)';
      } else if(hasUpdate){
        statusText.textContent = installable ? 'نسخه خصوصی تأیید شد — نصب توسط هسته WordPress' : 'نسخه جدید پیدا شد اما بسته دانلود ندارد';
        statusMode.textContent = installable ? 'WP Native' : 'Manifest warning';
      } else {
        statusText.textContent = updaterState.message || 'سیستم آپدیت داخلی فعال — نسخه جدیدی یافت نشد';
        statusMode.textContent = 'WP Native';
      }
    }

    const list = Updater.changelog.length ? Updater.changelog : [{tag:'INFO', title:`نسخه ${ver}`, desc:updaterState.message || 'جزئیات نسخه در دسترس نیست.'}];
    changelogEl.innerHTML = list.map(i=> `<div class="tl-item"><span class="tl-tag">${escapeHTML(i.tag)}</span><h4>${escapeHTML(i.title)}</h4><p>${escapeHTML(i.desc)}</p></div>`).join('');
    modal.classList.add('show');
    backdrop.classList.add('show');
    document.body.style.overflow='hidden';
  }
  function close(){
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    document.body.style.overflow='';
  }
  btnOpen?.addEventListener('click', open);
  btnClose?.addEventListener('click', close);
  btnDismiss?.addEventListener('click', ()=>{
    if(updaterState.hasUpdate){
      try{ localStorage.setItem('alookhor_update_dismissed','1'); }catch(e){}
    }
    close();
  });
  backdrop?.addEventListener('click', close);
  document.addEventListener('keydown', e=>{ if(e.key==='Escape') close(); });

  btnInstall?.addEventListener('click', async ()=>{
    const pending = updaterState.pending;
    if(!pending || !updaterState.installable) return;
    btnInstall.disabled=true;
    btnInstall.textContent='WordPress در حال نصب...';
    try{
      const result = await Updater.install(pending);
      window.ALOOKHOR.toast(`با موفقیت به v${result.version} آپدیت شد`,'success');
      document.getElementById('versionBadgeText').textContent = `v${Updater.current}`;
      document.getElementById('headerVersion').textContent = `v${Updater.current}`;
      document.getElementById('updateBadge').style.display='none';
      btnInstall.textContent='نصب شد ✓';
      setTimeout(close, 1100);
    }catch(error){
      window.ALOOKHOR.toast(`نصب انجام نشد: ${error.message}`,'info');
      btnInstall.disabled=false;
      btnInstall.textContent='تلاش دوباره با WordPress';
    }
  });

  document.addEventListener('alookhor:update-available', open);
}

document.addEventListener('DOMContentLoaded', async ()=>{
  initResponsive();
  initProNav();
  await Config.load();
  Config.apply();
  const updaterState = initUpdater({
    onAvailable(res){
      document.dispatchEvent(new CustomEvent('alookhor:update-available', {detail:res}));
    }
  });
  initUpdateModal(updaterState);

  document.getElementById('versionBadgeText').textContent = `v${Updater.current}`;
  document.getElementById('headerVersion').textContent = `v${Updater.current}`;
  document.getElementById('bpIndicator').textContent = `${window.innerWidth}px`;

  const hash = location.hash.replace('#','');
  const allMods = window.ALOOKHOR.modules;
  const initial = allMods[hash] ? hash : 'settings';
  // ست اولیه active
  document.querySelectorAll('.nav-item, .nav-sub-item').forEach(n=> n.classList.toggle('active', n.dataset.module===initial));
  // اگر initial داخل گروه بسته بود باز کن
  const initSub = document.querySelector(`.nav-sub-item[data-module="${initial}"]`);
  if(initSub) initSub.closest('.nav-group')?.classList.add('open');

  window.ALOOKHOR.switchModule(initial);

  console.log('%cALOOKHOR Control Center v'+Updater.current+' — PRO Sidebar Ready',"color:#C9A86A; font-size:14px; font-weight:700");
});
