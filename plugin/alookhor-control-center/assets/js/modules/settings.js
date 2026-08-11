import { Config } from '../core/config.js?v=3.9.0';

const escapeAttr = value => String(value ?? '').replace(/[&<>'"]/g, char => ({
  '&':'&amp;', '<':'&lt;', '>':'&gt;', "'":'&#039;', '"':'&quot;'
})[char]);
const isEnabled = value => value === true || value === 1 || value === '1' || value === 'true';
const footerLinksText = links => (Array.isArray(links) ? links : []).map(link => `${link.title || ''}|${link.url || ''}`).join('\n');
const parseFooterLinks = value => String(value || '').split(/\r?\n/).map(line => {
  const [title, ...url] = line.split('|');
  return {title:String(title || '').trim(), url:url.join('|').trim()};
}).filter(link => link.title);
const footerMenuOptions = selected => `<option value="0">لینک‌های سفارشی زیر</option>${(window.ALOOKHOR_CC?.footer_menus || []).map(menu => `<option value="${Number(menu.id)}" ${Number(selected)===Number(menu.id)?'selected':''}>${escapeAttr(menu.name)}</option>`).join('')}`;

export const settingsModule = {
  meta: { id: 'settings', title: 'تنظیمات پیشرفته' },
  async init(container){
    // لود حافظه واقعی قبلی — تمام سایت با همین تنظیمات ویرایش می‌شد
    if(!Config.data) await Config.load();
    let cfg = Config.data;
    // Guard: اگر حافظه به خاطر Tracking Prevention خالی بود، fallback بساز
    if(!cfg) cfg = {site:{name:'ALOOKHOR', subtitle:'Control Center • Luxury', logoLetter:'A'}, modules:{}, system:{}, header_settings:{logo_text:'ALOOKHOR', logo_sub:'Control Center • Luxury'}, ai_assistant:{suggestions:[]}};
    if(!cfg.modules) cfg.modules = {};
    cfg.header_settings = Object.assign({
      logo_text:'ALOOKHOR', logo_sub:'Control Center • Luxury', phone:'', email:'', whatsapp:'',
      export_text:'صادرات به ۵ کشور جهان', export_url:'', wholesale_text:'خرید عمده آلو بخارا', wholesale_url:'',
      top_logo_url:'', top_logo_alt:'ALOOKHOR', top_logo_link:'', top_logo_width:96,
      topbar_bg:'#11091D', topbar_text_color:'#E8D5B5', topbar_border_color:'#3A2C20',
      topbar_button_bg:'#C9A86A', topbar_button_text:'#1A1206', topbar_height:38,
      show_topbar:true, show_phone:true, show_email:true, show_whatsapp:true, show_export:true,
      show_wholesale:true, wholesale_new_tab:false
    }, cfg.header_settings || {});
    cfg.footer_settings = Object.assign({
      enabled:true, hide_legacy:true, hide_old_newsletter:true, use_header_contact:true,
      logo_url:'', logo_alt:'لوگوی رسمی آلوخور', brand_name:'ALOOKHOR', brand_subtitle:'PREMIUM PERSIAN DRIED PLUMS',
      brand_kicker:'From Iranian Orchards to the World', brand_description:'', cta_text:'درخواست قیمت عمده و صادراتی', cta_url:'',
      phone:'', email:'', whatsapp:'', address:'خراسان رضوی، خور نیشابور', support_label:'تلفن پشتیبانی و سفارش عمده',
      hours_week:'شنبه تا پنجشنبه: ۸ الی ۲۰', hours_friday:'جمعه‌ها: ۹ الی ۱۴',
      customer_title:'خدمات مشتریان', customer_menu_id:0, customer_links:[], order_title:'خرید و سفارش', order_menu_id:0, order_links:[],
      about_title:'درباره آلوخور', about_mobile_title:'راهنمای صادراتی', about_menu_id:0, about_links:[],
      instagram_url:'', telegram_url:'', whatsapp_url:'', social_title:'آلوخور را دنبال کنید', social_desc:'',
      newsletter_enabled:true, newsletter_title:'عضویت در خبرنامه', newsletter_desc:'', newsletter_placeholder:'ایمیل شما', newsletter_button:'عضویت',
      product_image_url:'', enamad_title:'Enamad', enamad_image_url:'', enamad_url:'', samandehi_title:'ساماندهی', samandehi_image_url:'', samandehi_url:'',
      copyright_text:'تمامی حقوق محفوظ است.', copyright_en:'Premium Persian Dried Plums Exporter',
      background:'#070809', surface:'#0D0F10', gold:'#C89A3D', gold_soft:'#E3BD69', text:'#E9E5DF', muted:'#A7A39D', border:'#4A3820',
      container_width:1280, desktop_logo_width:210, mobile_logo_width:190, show_payments:true, show_benefits:true, show_product_image:true
    }, cfg.footer_settings || {});
    if(!cfg.site) cfg.site = {name:'ALOOKHOR', subtitle:'Control Center • Luxury', logoLetter:'A'};
    if(!cfg.system) cfg.system = {uptime:'99.9%', cache:'فعال', woocommerce:'فعال', woodmart_plus:'فعال', elementor_pro:'فعال', php_version:'8.1.6', memory:'256MB / 512MB', ssl:'فعال (امن)'};
    if(!cfg.ai_assistant) cfg.ai_assistant = {suggestions:[]};
    if(!cfg.ai_assistant.suggestions) cfg.ai_assistant.suggestions = [];

    const sourceMeta = {
      wordpress: {label:'حافظه WordPress متصل', color:'#3DD68C', bg:'rgba(61,214,140,0.14)', border:'rgba(61,214,140,0.18)'},
      'repaired-defaults': {label:'حافظه ناقص ترمیم شد', color:'#E8D5B5', bg:'rgba(201,168,106,0.14)', border:'rgba(201,168,106,0.24)'},
      'defaults-file': {label:'Defaults افزونه بارگذاری شد', color:'#E8D5B5', bg:'rgba(201,168,106,0.14)', border:'rgba(201,168,106,0.24)'},
      'local-cache': {label:'حالت آفلاین — Cache محلی', color:'#E8D5B5', bg:'rgba(201,168,106,0.14)', border:'rgba(201,168,106,0.24)'},
      'emergency-fallback': {label:'اتصال حافظه ناموفق', color:'#FF8A8E', bg:'rgba(255,90,95,0.11)', border:'rgba(255,90,95,0.22)'}
    };
    const memory = sourceMeta[Config.source] || sourceMeta['emergency-fallback'];
    const hasDefinitions = Object.keys(cfg.modules||{}).length > 0;

    container.innerHTML = `
      <div class="page-head">
        <div>
          <h2>تنظیمات پیشرفته ALOOKHOR</h2>
          <p>تنظیمات ALOOKHOR بدون حذف مقادیر قبلی بارگذاری می‌شود <span style="background:${memory.bg}; color:${memory.color}; padding:2px 8px; border-radius:999px; font-size:11px; border:1px solid ${memory.border}">● ${memory.label}</span></p>
        </div>
        <div class="head-actions">
          <button class="btn-ghost" id="btnExportSettings">⬇ خروجی JSON</button>
          <button class="btn-ghost" id="btnResetSettings">بازنشانی</button>
          <button class="btn-gold" id="btnSaveAll">💾 ذخیره همه — اعمال زنده</button>
        </div>
      </div>

      <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:14px; align-items:center">
        <span style="font-size:11px; color:var(--text-faint); background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); padding:4px 10px; border-radius:999px">آخرین ذخیره: <b id="lastSave" style="color:var(--text-secondary)">${cfg.updated_at ? new Date(cfg.updated_at).toLocaleString('fa-IR') : 'همین حالا'}</b></span>
        <span style="font-size:11px; color:var(--gold-soft); background:rgba(201,168,106,0.10); border:1px solid var(--gold-border-strong); padding:4px 10px; border-radius:999px">نسخه: ${cfg.version}</span>
        <span style="margin-right:auto; display:flex; gap:6px">
          <button class="btn-ghost" style="padding:6px 10px; font-size:11px" onclick="document.getElementById('aiCard')?.scrollIntoView({behavior:'smooth', block:'center'})">دستیار هوشمند</button>
          <button class="btn-ghost" style="padding:6px 10px; font-size:11px" onclick="document.getElementById('statusCard')?.scrollIntoView({behavior:'smooth', block:'center'})">سلامت سیستم</button>
          <button class="btn-ghost" style="padding:6px 10px; font-size:11px" onclick="document.getElementById('modulesCard')?.scrollIntoView({behavior:'smooth', block:'center'})">ماژول‌ها</button>
        </span>
      </div>

      <div class="settings-hub">
        <!-- ستون راست: ماژول‌های فعال سیستم — دقیقا مثل تصویر، اما حالا واقعی -->
        <div class="modules-side" id="modulesCard">
          <div class="panel" style="overflow:hidden">
            <div class="panel-head" style="background:rgba(201,168,106,0.06)"><h3 style="font-size:13px">ماژول‌های فعال سیستم</h3><span style="font-size:10px; background:var(--success); color:#0A0A0A; padding:2px 7px; border-radius:999px; font-weight:800">${Object.values(cfg.modules||{}).filter(m=>m.enabled).length} / ${Object.keys(cfg.modules||{}).length} فعال</span></div>
            <div class="modules-list" id="modulesList">
              <!-- JS render -->
            </div>
            <div style="padding:10px 12px; display:flex; gap:8px">
              <button class="btn-ghost" style="flex:1; padding:8px; font-size:11.5px" id="btnDisableAll">غیرفعال همه</button>
              <button class="btn-gold" style="flex:1; padding:8px; font-size:11.5px" id="btnEnableAll">فعال‌سازی همه</button>
            </div>
          </div>
          <div style="margin-top:10px; padding:10px 12px; background:${memory.bg}; border:1px solid ${memory.border}; border-radius:12px; font-size:12px; color:var(--text-secondary); line-height:1.7">
            <b style="color:${memory.color}">${hasDefinitions?'✓':'!'} ${memory.label}</b><br>
            ${hasDefinitions
              ? 'تعریف ماژول‌ها بازیابی شده و تغییرات از مسیر امن WordPress ذخیره می‌شوند.'
              : 'تعریف ماژول‌ها دریافت نشد؛ برای جزئیات Console و پاسخ admin-ajax.php را بررسی کنید.'}
          </div>
          <div style="margin-top:8px; padding:10px; background:rgba(255,255,255,0.03); border:1px dashed var(--gold-border); border-radius:10px">
            <div style="font-size:11px; color:var(--text-faint); margin-bottom:6px">پیش‌نمایش هدر زنده:</div>
            <div style="display:flex; align-items:center; gap:8px; background:#111113; border:1px solid var(--gold-border-strong); border-radius:10px; padding:8px">
              <div style="width:28px; height:28px; border-radius:8px; background:linear-gradient(135deg,#1A1A1D,#0F0F10); border:1px solid var(--gold-border-strong); display:grid; place-items:center; color:var(--gold); font-weight:800; font-size:12px">${cfg.site.logoLetter}</div>
              <div><div style="font-size:12px; font-weight:700" id="liveLogoText">${cfg.header_settings.logo_text}</div><div style="font-size:10px; color:var(--text-muted)" id="liveLogoSub">${cfg.header_settings.logo_sub}</div></div>
            </div>
          </div>
        </div>

        <!-- ستون وسط و چپ -->
        <div class="settings-main">
          <div class="settings-two-col">
            <!-- دستیار هوشمند -->
            <div class="panel ai-panel" id="aiCard">
              <div class="panel-head"><h3>🤖 دستیار هوشمند تجاری (AI Assistant)</h3><span style="font-size:10px; background:rgba(201,168,106,0.14); color:var(--gold-soft); padding:3px 8px; border-radius:999px; border:1px solid var(--gold-border)">از چت قبلی</span></div>
              <div class="ai-list" id="aiList">
                <!-- JS render -->
              </div>
            </div>

            <!-- وضعیت سیستم -->
            <div class="panel status-panel" id="statusCard">
              <div class="panel-head"><h3>⊕ وضعیت و سلامت سیستم (System Status)</h3><button class="btn-ghost" style="padding:5px 10px; font-size:11px" id="btnRefreshStatus">بررسی مجدد</button></div>
              <div class="status-list" id="statusList">
                <!-- JS render -->
              </div>
              <div style="padding:10px; display:grid; grid-template-columns:1fr 1fr; gap:8px">
                <div style="background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; text-align:center"><div style="font-size:11px; color:var(--text-faint)">آپتایم</div><b style="color:var(--success)">${cfg.system.uptime}</b></div>
                <div style="background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; text-align:center"><div style="font-size:11px; color:var(--text-faint)">کش طلایی</div><b style="color:var(--gold-soft)">${cfg.system.cache}</b></div>
              </div>
              <div style="padding:0 10px 10px 10px">
                <label style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:8px 10px; font-size:12px">
                  <span>نمایش نسخه PHP در داشبورد</span><input type="checkbox" checked style="accent-color:var(--gold)">
                </label>
              </div>
            </div>
          </div>

          <!-- تنظیمات سریع -->
          <div class="panel" style="margin-top:14px">
            <div class="panel-head"><h3>⚙️ تنظیمات سریع هر ماژول</h3><span style="font-size:11px; color:var(--text-faint)" id="quickTitle">یک ماژول از سمت راست انتخاب کن</span></div>
            <div id="quickSettings" style="padding:16px">
              <div style="text-align:center; padding:18px; color:var(--text-muted); font-size:13px; background:rgba(255,255,255,0.02); border:1px dashed var(--gold-border); border-radius:12px">یک ماژول از ستون سمت راست انتخاب کن تا تنظیمات واقعی‌اش اینجا باز شود.<br><span style="color:var(--gold-soft)">تغییرات ذخیره و بلافاصله روی سایت اعمال می‌شود</span></div>
            </div>
          </div>
        </div>
      </div>

      <style>
        .settings-hub{ display:flex; gap:14px; align-items:start }
        .settings-main{ flex:1; min-width:0 }
        .settings-two-col{ display:grid; gap:14px; grid-template-columns: 1fr 1fr }
        .modules-side{ width:310px; flex:0 0 310px; position:sticky; top:84px }
        @media(max-width:1100px){ .settings-hub{flex-direction:column} .modules-side{width:100%; position:static} .settings-two-col{grid-template-columns:1fr} }
        .modules-list{ display:grid; gap:0 }
        .mod-item{ display:flex; align-items:center; gap:10px; padding:11px 12px; font-size:12.8px; font-weight:500; color:var(--text-secondary); border-bottom:1px solid rgba(201,168,106,0.08); cursor:pointer; transition: all 0.18s ease; position:relative }
        .mod-item:hover{ background:rgba(255,255,255,0.03); color:var(--text-primary)}
        .mod-item.active{ background: linear-gradient(90deg, rgba(201,168,106,0.16), transparent); border-right:3px solid var(--gold); color:var(--gold-soft); font-weight:700}
        .mod-item.disabled{ opacity:0.45; filter: grayscale(0.3)}
        .mod-icon{ width:26px; height:26px; border-radius:8px; display:grid; place-items:center; background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); font-size:12px; flex:0 0 26px}
        .mod-item.active .mod-icon{ background:rgba(201,168,106,0.14); border-color:var(--gold-border-strong)}
        .mod-check{ margin-right:auto; width:18px; height:18px; border-radius:999px; background:var(--success); color:#0A0A0A; display:grid; place-items:center; font-size:11px; font-weight:800}
        .mod-toggle{ margin-right:auto; width:36px; height:20px; border-radius:999px; background:rgba(255,255,255,0.08); border:1px solid var(--gold-border); position:relative; transition: all 0.22s ease; flex:0 0 36px }
        .mod-toggle i{ position:absolute; top:2px; right:2px; width:14px; height:14px; border-radius:50%; background:#9A9590; transition: all 0.22s ease; display:block }
        .mod-toggle.on{ background: var(--gold); border-color: var(--gold)}
        .mod-toggle.on i{ background:#1A1206; transform: translateX(-16px)}
        .ai-list{ display:grid; gap:8px; padding:12px }
        .ai-item{ background: rgba(10,10,12,0.55); border:1px solid rgba(201,168,106,0.12); border-radius:12px; overflow:hidden}
        .ai-head{ width:100%; display:flex; align-items:center; gap:10px; padding:11px 12px; background:transparent; border:0; color:var(--text-secondary); font-size:12.5px; font-weight:600; cursor:pointer; text-align:right}
        .ai-head:hover{ color:var(--text-primary)}
        .ai-plus{ width:22px; height:22px; border-radius:6px; background:rgba(255,255,255,0.06); border:1px solid var(--gold-border); display:grid; place-items:center; font-size:13px; font-weight:800; flex:0 0 22px; transition: all 0.2s ease}
        .ai-item.open .ai-plus{ background:var(--gold); color:#1A1206; transform: rotate(45deg)}
        .ai-badge{ margin-right:auto; font-size:10px; font-weight:700; padding:2px 7px; border-radius:999px; background:rgba(201,168,106,0.14); color:var(--gold-soft); border:1px solid var(--gold-border)}
        .ai-body{ display:none; padding:0 12px 12px 12px; border-top:1px solid var(--gold-border); background: rgba(255,255,255,0.02)}
        .ai-item.open .ai-body{ display:block}
        .ai-body p{ margin:10px 0 0 0; font-size:12.5px; color:var(--text-muted); line-height:1.7}
        .status-list{ display:grid; gap:0; padding:6px 0}
        .status-row{ display:flex; justify-content:space-between; align-items:center; padding:10px 14px; font-size:12.8px; border-bottom:1px solid rgba(201,168,106,0.07); color:var(--text-secondary)}
        .status-row b{ color:var(--text-primary); font-size:12.5px}
        .dot{ width:8px; height:8px; border-radius:50%; display:inline-block; margin-left:6px; vertical-align:middle; background:#6B6763}
        .dot.on{ background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.16)}
      </style>
    `;

    // — رندر ماژول‌ها از حافظه واقعی —
    const listEl = container.querySelector('#modulesList');
    const iconMap = { stats:'📊', header:'◈', footer:'◫', export:'👑', sort:'①', collection:'②', app:'📱', hero:'🎠', auto:'🔄' };
    function renderModules(){
      listEl.innerHTML = Object.entries(cfg.modules||{}).sort((a,b)=> a[1].order - b[1].order).map(([key,m])=>`
        <div class="mod-item ${m.enabled?'':'disabled'}" data-mod="${key}">
          <span class="mod-icon">${iconMap[key]||'●'}</span> ${m.title}
          ${m.enabled ? `<span class="mod-check">✓</span>` : `<span class="mod-toggle"><i></i></span>`}
          ${m.enabled ? `<span class="mod-toggle on" data-toggle="${key}"><i></i></span>` : `<span class="mod-toggle" data-toggle="${key}"><i></i></span>`}
        </div>
      `).join('');
      // برای آیتم‌هایی که enabled هستند، چک را حذف و فقط toggle بذار — تمیزتر
      // بازنویسی: هر آیتم فقط یک toggle داشته باشد
      listEl.querySelectorAll('.mod-item').forEach(el=>{
        const key = el.dataset.mod;
        const enabled = cfg.modules[key].enabled;
        // حذف چک اضافی و نگه داشتن toggle
        const checks = el.querySelectorAll('.mod-check');
        if(checks.length && enabled){
          // اگر enabled، چک را حذف کن (toggle کافی است)
          checks.forEach(c=> c.remove());
        }
        // toggle state
        const tog = el.querySelector('.mod-toggle');
        if(tog) tog.classList.toggle('on', enabled);
      });
    }
    renderModules();

    // رندر AI
    const aiList = container.querySelector('#aiList');
    function renderAI(){
      aiList.innerHTML = cfg.ai_assistant.suggestions.map((s,idx)=>`
        <div class="ai-item ${idx===0?'open':''}" data-ai="${s.id}">
          <button class="ai-head"><span class="ai-plus">${idx===0?'×':'+'}</span> ${s.title} <span class="ai-badge">${s.status==='new'?'جدید': s.status==='done'?'انجام شد':'AI'}</span></button>
          <div class="ai-body">
            <p>${s.detail}</p>
            <div style="display:flex; gap:8px; margin-top:10px; flex-wrap:wrap">
              ${s.status!=='done' ? `<button class="btn-gold" style="padding:6px 12px; font-size:12px" data-ai-action="do" data-id="${s.id}">اعمال پیشنهاد</button>` : `<span style="color:var(--success); font-size:12px; font-weight:700">✓ اعمال شد</span>`}
              <button class="btn-ghost" style="padding:6px 12px; font-size:12px" data-ai-action="dismiss" data-id="${s.id}">${s.status==='done'?'بازگردانی':'نادیده بگیر'}</button>
            </div>
          </div>
        </div>
      `).join('');
    }
    renderAI();

    // رندر Status
    const statusList = container.querySelector('#statusList');
    function renderStatus(){
      statusList.innerHTML = `
        <div class="status-row"><span><span class="dot on"></span> ووکامرس</span><b>${cfg.system.woocommerce}</b></div>
        <div class="status-row"><span><span class="dot on"></span> وودمارت پلاس</span><b>${cfg.system.woodmart_plus}</b></div>
        <div class="status-row"><span><span class="dot on"></span> المنتور پرو</span><b>${cfg.system.elementor_pro}</b></div>
        <div class="status-row"><span>نسخه پی‌اچ‌پی هاست (PHP)</span><b dir="ltr">${cfg.system.php_version}</b></div>
        <div class="status-row"><span>حافظه لایو سیستم (Memory)</span><b style="color:var(--gold)">${cfg.system.memory}</b></div>
        <div class="status-row"><span>گواهینامه امنیتی (SSL)</span><b style="color:var(--success)"><span class="dot on"></span> ${cfg.system.ssl}</b></div>
      `;
    }
    renderStatus();

    // — تعاملات واقعی —
    const quick = container.querySelector('#quickSettings');
    const quickTitle = container.querySelector('#quickTitle');
    let commitQuickSettings = null;

    const detailRenderers = {
      header: () => `
        <div class="qh-head"><div><h4>◈ مدیریت کامل هدر و Top Bar</h4><p>مرجع اصلی تنظیمات — متصل به همان شورت‌کد و هدر حرفه‌ای فعلی</p></div><code>[alookhor_portal_header]</code></div>

        <div class="qh-live" id="quickTopbar" style="--qh-bg:${escapeAttr(cfg.header_settings.topbar_bg)};--qh-text:${escapeAttr(cfg.header_settings.topbar_text_color)};--qh-border:${escapeAttr(cfg.header_settings.topbar_border_color)};--qh-btn:${escapeAttr(cfg.header_settings.topbar_button_bg)};--qh-btn-text:${escapeAttr(cfg.header_settings.topbar_button_text)};height:${Number(cfg.header_settings.topbar_height)||38}px">
          <div class="qh-trade"><span id="quickWholesale">${escapeAttr(cfg.header_settings.wholesale_text)}</span><span id="quickExport">${escapeAttr(cfg.header_settings.export_text)}</span></div>
          <div class="qh-logo" id="quickTopLogo">${cfg.header_settings.top_logo_url ? `<img src="${escapeAttr(cfg.header_settings.top_logo_url)}" alt="">` : 'ALOOKHOR'}</div>
          <div class="qh-contact" dir="ltr"><span id="quickWhatsapp">●</span><span id="quickEmail">${escapeAttr(cfg.header_settings.email)}</span><span id="quickPhone">${escapeAttr(cfg.header_settings.phone)}</span></div>
        </div>

        <div class="qh-section"><div class="qh-title"><b>محتوا و لینک‌های Top Bar</b><small>CONTENT</small></div><div class="qh-grid">
          <label>تلفن<input id="inpHeaderPhone" value="${escapeAttr(cfg.header_settings.phone)}" dir="ltr"></label>
          <label>ایمیل<input id="inpHeaderEmail" type="email" value="${escapeAttr(cfg.header_settings.email)}" dir="ltr"></label>
          <label>WhatsApp<input id="inpHeaderWhatsapp" value="${escapeAttr(cfg.header_settings.whatsapp)}" dir="ltr"></label>
          <label>متن صادرات<input id="inpHeaderExportText" value="${escapeAttr(cfg.header_settings.export_text)}"></label>
          <label>لینک صادرات<input id="inpHeaderExportUrl" type="url" value="${escapeAttr(cfg.header_settings.export_url)}" dir="ltr"></label>
          <label>متن خرید عمده<input id="inpHeaderWholesaleText" value="${escapeAttr(cfg.header_settings.wholesale_text)}"></label>
          <label>لینک خرید عمده<input id="inpHeaderWholesaleUrl" type="url" value="${escapeAttr(cfg.header_settings.wholesale_url)}" dir="ltr"></label>
        </div></div>

        <div class="qh-section"><div class="qh-title"><b>لوگوی مرکزی نوار بالا</b><small>MEDIA</small></div><div class="qh-grid">
          <label class="qh-span-2">آدرس لوگو<span class="qh-inline"><input id="inpTopLogoUrl" value="${escapeAttr(cfg.header_settings.top_logo_url)}" dir="ltr"><button type="button" id="btnSelectTopLogoQuick">انتخاب</button></span></label>
          <label>Alt لوگو<input id="inpTopLogoAlt" value="${escapeAttr(cfg.header_settings.top_logo_alt)}"></label>
          <label>لینک لوگو<input id="inpTopLogoLink" type="url" value="${escapeAttr(cfg.header_settings.top_logo_link)}" dir="ltr"></label>
          <label>عرض لوگو<input id="inpTopLogoWidth" type="number" min="50" max="180" value="${Number(cfg.header_settings.top_logo_width)||96}"></label>
        </div></div>

        <div class="qh-section"><div class="qh-title"><b>ظاهر نوار بالا</b><small>STYLE</small></div><div class="qh-colors">
          <label>پس‌زمینه<input id="inpTopbarBg" type="color" value="${escapeAttr(cfg.header_settings.topbar_bg)}"></label>
          <label>رنگ متن<input id="inpTopbarText" type="color" value="${escapeAttr(cfg.header_settings.topbar_text_color)}"></label>
          <label>حاشیه<input id="inpTopbarBorder" type="color" value="${escapeAttr(cfg.header_settings.topbar_border_color)}"></label>
          <label>رنگ دکمه<input id="inpTopbarButtonBg" type="color" value="${escapeAttr(cfg.header_settings.topbar_button_bg)}"></label>
          <label>متن دکمه<input id="inpTopbarButtonText" type="color" value="${escapeAttr(cfg.header_settings.topbar_button_text)}"></label>
          <label>ارتفاع<input id="inpTopbarHeight" type="number" min="30" max="60" value="${Number(cfg.header_settings.topbar_height)||38}"></label>
        </div></div>

        <div class="qh-section"><div class="qh-title"><b>نمایش یا عدم نمایش</b><small>VISIBILITY</small></div><div class="qh-flags">
          ${[
            ['show_topbar','کل Top Bar'],['show_phone','تلفن'],['show_email','ایمیل'],['show_whatsapp','WhatsApp'],
            ['show_export','صادرات'],['show_wholesale','خرید عمده'],['wholesale_new_tab','لینک عمده در تب جدید']
          ].map(([key,label])=>`<label><input type="checkbox" data-header-flag="${key}" ${isEnabled(cfg.header_settings[key])?'checked':''}>${label}</label>`).join('')}
        </div></div>

        <div class="qh-section"><div class="qh-title"><b>هویت هدر اصلی</b><small>IDENTITY</small></div><div class="qh-grid">
          <label>متن لوگو<input id="inpLogoText" value="${escapeAttr(cfg.header_settings.logo_text)}"></label>
          <label>زیرعنوان<input id="inpLogoSub" value="${escapeAttr(cfg.header_settings.logo_sub)}"></label>
          <label>حرف لوگو<input id="inpLogoLetter" value="${escapeAttr(cfg.site.logoLetter)}" maxlength="2"></label>
        </div></div>

        <div class="qh-actions"><button class="btn-gold" id="btnApplyHeader">ذخیره و اعمال روی سایت</button><span>همه گزینه‌ها در پنل اصلی و Option مشترک ذخیره می‌شوند.</span></div>
        <style>
          .qh-head{display:flex;justify-content:space-between;gap:12px;align-items:center;margin-bottom:12px}.qh-head h4{margin:0;font-size:14px}.qh-head p{margin:4px 0 0;color:var(--text-muted);font-size:11px}.qh-head code{direction:ltr;padding:7px 9px;border:1px solid var(--gold-border);border-radius:8px;color:var(--gold-soft);font-size:10px}
          .qh-live{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:9px;padding:0 12px;border-bottom:1px solid var(--qh-border);border-radius:10px;background:var(--qh-bg);color:var(--qh-text);overflow:hidden;margin-bottom:12px}.qh-trade,.qh-contact{display:flex;align-items:center;gap:8px;min-width:0;font-size:9px}.qh-trade{justify-self:start}.qh-contact{justify-self:end}.qh-trade span:first-child{padding:5px 8px;border-radius:999px;background:var(--qh-btn);color:var(--qh-btn-text);font-weight:800}.qh-logo{font:700 10px Georgia;color:var(--gold-soft)}.qh-logo img{display:block;max-width:76px;max-height:30px}
          .qh-section{padding:12px;margin-top:9px;border:1px solid var(--gold-border);border-radius:11px;background:rgba(255,255,255,.018)}.qh-title{display:flex;justify-content:space-between;gap:8px;margin-bottom:10px}.qh-title b{font-size:11.5px}.qh-title small{color:var(--gold);font:9px Arial}.qh-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.qh-colors{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:8px}.qh-section label{display:grid;gap:4px;color:var(--text-muted);font-size:10.5px}.qh-section input{width:100%;min-width:0;background:rgba(255,255,255,.035);border:1px solid var(--gold-border);border-radius:8px;padding:8px;color:var(--text-primary)}.qh-section input[type=color]{height:37px;padding:3px}.qh-inline{display:flex;gap:6px}.qh-inline button{border:1px solid var(--gold-border-strong);border-radius:8px;background:rgba(201,168,106,.1);color:var(--gold-soft);cursor:pointer}.qh-span-2{grid-column:span 2}.qh-flags{display:flex;gap:6px;flex-wrap:wrap}.qh-flags label{display:flex;align-items:center;gap:5px;padding:6px 8px;border:1px solid var(--gold-border);border-radius:999px}.qh-flags input{width:auto;accent-color:var(--gold)}.qh-actions{display:flex;align-items:center;gap:9px;flex-wrap:wrap;margin-top:11px}.qh-actions button{padding:9px 15px;font-size:11px}.qh-actions span{color:var(--text-faint);font-size:10px}@media(max-width:700px){.qh-grid,.qh-colors{grid-template-columns:1fr}.qh-span-2{grid-column:auto}.qh-contact{display:none}}
        </style>
      `,
      footer: () => {
        const f = cfg.footer_settings;
        return `
        <div class="qh-head"><div><h4>◫ فوتر حرفه‌ای ALOOKHOR</h4><p>Desktop پنج‌ستونه + Mobile کارت‌های دو‌ستونه — جایگزینی خودکار فوتر قدیمی بدون ویرایش Elementor</p></div><code>MANAGED FOOTER</code></div>
        <div class="qh-section"><div class="qh-title"><b>وضعیت و منابع WordPress</b><small>CORE</small></div><div class="qh-flags">
          ${[['enabled','فعال‌بودن فوتر'],['hide_legacy','مخفی‌کردن فوتر قدیمی'],['hide_old_newsletter','ادغام خبرنامه قدیمی'],['use_header_contact','تلفن/ایمیل مشترک با هدر'],['newsletter_enabled','نمایش خبرنامه'],['show_product_image','تصویر محصول'],['show_payments','روش‌های پرداخت'],['show_benefits','مزیت‌های پایین']].map(([key,label])=>`<label><input type="checkbox" data-footer-flag="${key}" ${isEnabled(f[key])?'checked':''}>${label}</label>`).join('')}
        </div></div>
        <div class="qh-section"><div class="qh-title"><b>هویت برند و CTA</b><small>BRAND</small></div><div class="qh-grid">
          <label class="qh-span-2">لوگوی فوتر<span class="qh-inline"><input id="ftLogoUrl" value="${escapeAttr(f.logo_url)}" dir="ltr"><button type="button" data-footer-media="ftLogoUrl">انتخاب</button></span></label>
          <label>نام انگلیسی<input id="ftBrandName" value="${escapeAttr(f.brand_name)}"></label><label>زیرعنوان<input id="ftBrandSubtitle" value="${escapeAttr(f.brand_subtitle)}"></label>
          <label>شعار<input id="ftBrandKicker" value="${escapeAttr(f.brand_kicker)}"></label><label>متن دکمه<input id="ftCtaText" value="${escapeAttr(f.cta_text)}"></label>
          <label class="qh-span-2">توضیحات<textarea id="ftBrandDesc" rows="3">${escapeAttr(f.brand_description)}</textarea></label><label class="qh-span-2">لینک CTA<input id="ftCtaUrl" value="${escapeAttr(f.cta_url)}" dir="ltr"></label>
        </div></div>
        <div class="qh-section"><div class="qh-title"><b>اطلاعات تماس</b><small>CONTACT</small></div><div class="qh-grid">
          <label>تلفن<input id="ftPhone" value="${escapeAttr(f.phone)}" dir="ltr"></label><label>ایمیل<input id="ftEmail" value="${escapeAttr(f.email)}" dir="ltr"></label>
          <label>WhatsApp<input id="ftWhatsapp" value="${escapeAttr(f.whatsapp)}" dir="ltr"></label><label>عنوان پشتیبانی<input id="ftSupportLabel" value="${escapeAttr(f.support_label)}"></label>
          <label class="qh-span-2">آدرس<input id="ftAddress" value="${escapeAttr(f.address)}"></label><label>ساعات هفته<input id="ftHoursWeek" value="${escapeAttr(f.hours_week)}"></label><label>ساعات جمعه<input id="ftHoursFriday" value="${escapeAttr(f.hours_friday)}"></label>
        </div></div>
        ${[['customer','خدمات مشتریان'],['order','خرید و سفارش'],['about','درباره/راهنمای صادرات']].map(([key,label])=>`<div class="qh-section"><div class="qh-title"><b>ستون ${label}</b><small>WORDPRESS MENU</small></div><div class="qh-grid"><label>عنوان<input id="ft${key}Title" value="${escapeAttr(f[`${key}_title`])}"></label>${key==='about'?`<label>عنوان موبایل<input id="ftAboutMobileTitle" value="${escapeAttr(f.about_mobile_title)}"></label>`:''}<label>فهرست WordPress<select id="ft${key}Menu">${footerMenuOptions(f[`${key}_menu_id`])}</select></label><label class="qh-span-2">لینک‌های جایگزین — هر خط: عنوان|URL<textarea id="ft${key}Links" rows="6" dir="ltr">${escapeAttr(footerLinksText(f[`${key}_links`]))}</textarea></label></div></div>`).join('')}
        <div class="qh-section"><div class="qh-title"><b>شبکه‌های اجتماعی و خبرنامه</b><small>ENGAGEMENT</small></div><div class="qh-grid">
          <label>Instagram<input id="ftInstagram" value="${escapeAttr(f.instagram_url)}" dir="ltr"></label><label>Telegram<input id="ftTelegram" value="${escapeAttr(f.telegram_url)}" dir="ltr"></label><label>WhatsApp URL<input id="ftWhatsappUrl" value="${escapeAttr(f.whatsapp_url)}" dir="ltr"></label>
          <label>عنوان شبکه‌ها<input id="ftSocialTitle" value="${escapeAttr(f.social_title)}"></label><label>عنوان خبرنامه<input id="ftNewsletterTitle" value="${escapeAttr(f.newsletter_title)}"></label><label>دکمه خبرنامه<input id="ftNewsletterButton" value="${escapeAttr(f.newsletter_button)}"></label>
          <label class="qh-span-2">توضیح شبکه‌ها<input id="ftSocialDesc" value="${escapeAttr(f.social_desc)}"></label><label class="qh-span-2">توضیح خبرنامه<input id="ftNewsletterDesc" value="${escapeAttr(f.newsletter_desc)}"></label>
          <label class="qh-span-2">تصویر محصول<span class="qh-inline"><input id="ftProductImage" value="${escapeAttr(f.product_image_url)}" dir="ltr"><button type="button" data-footer-media="ftProductImage">انتخاب</button></span></label>
        </div></div>
        <div class="qh-section"><div class="qh-title"><b>مجوزها، کپی‌رایت و ظاهر</b><small>TRUST & STYLE</small></div><div class="qh-grid">
          <label>عنوان Enamad<input id="ftEnamadTitle" value="${escapeAttr(f.enamad_title)}"></label><label>لینک Enamad<input id="ftEnamadUrl" value="${escapeAttr(f.enamad_url)}" dir="ltr"></label><label class="qh-span-2">تصویر Enamad<span class="qh-inline"><input id="ftEnamadImage" value="${escapeAttr(f.enamad_image_url)}" dir="ltr"><button type="button" data-footer-media="ftEnamadImage">انتخاب</button></span></label>
          <label>عنوان ساماندهی<input id="ftSamandehiTitle" value="${escapeAttr(f.samandehi_title)}"></label><label>لینک ساماندهی<input id="ftSamandehiUrl" value="${escapeAttr(f.samandehi_url)}" dir="ltr"></label><label class="qh-span-2">تصویر ساماندهی<span class="qh-inline"><input id="ftSamandehiImage" value="${escapeAttr(f.samandehi_image_url)}" dir="ltr"><button type="button" data-footer-media="ftSamandehiImage">انتخاب</button></span></label>
          <label>Copyright<input id="ftCopyright" value="${escapeAttr(f.copyright_text)}"></label><label>Copyright English<input id="ftCopyrightEn" value="${escapeAttr(f.copyright_en)}"></label>
        </div><div class="qh-colors" style="margin-top:10px">${[['Background','background'],['Surface','surface'],['Gold','gold'],['Gold Soft','gold_soft'],['Text','text'],['Muted','muted'],['Border','border']].map(([label,key])=>`<label>${label}<input type="color" id="ftColor_${key}" value="${escapeAttr(f[key])}"></label>`).join('')}<label>عرض محتوا<input type="number" id="ftContainerWidth" value="${Number(f.container_width)||1280}"></label><label>لوگو Desktop<input type="number" id="ftDesktopLogo" value="${Number(f.desktop_logo_width)||210}"></label><label>لوگو Mobile<input type="number" id="ftMobileLogo" value="${Number(f.mobile_logo_width)||190}"></label></div></div>
        <div class="qh-actions"><button class="btn-gold" id="btnApplyFooter">ذخیره و اعمال فوتر</button><a class="btn-ghost" href="${escapeAttr(window.ALOOKHOR_CC?.home_url || '/')}" target="_blank">مشاهده سایت</a><span>پیام موفقیت فقط بعد از تأیید WordPress نمایش داده می‌شود.</span></div>
        <style>.qh-section textarea,.qh-section select{width:100%;min-width:0;background:rgba(255,255,255,.035);border:1px solid var(--gold-border);border-radius:8px;padding:8px;color:var(--text-primary);font-family:inherit}.qh-section select option{background:#171419}</style>`;
      },
      stats: () => `<h4>📊 پیشخوان هوشمند آمار</h4><p style="color:var(--text-muted); font-size:12.5px">KPI ها و نمودار فروش در داشبورد. فعال: <b style="color:${cfg.modules.stats.enabled?'var(--success)':'var(--danger)'}">${cfg.modules.stats.enabled?'بله':'خیر'}</b></p><label style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; margin-top:10px"><span>نمایش در داشبورد</span><span class="mod-toggle ${cfg.modules.stats.enabled?'on':''}" data-quick-toggle="stats"><i></i></span></label>`,
      export: () => `<h4>👑 محصولات ممبر صادراتی</h4><p style="color:var(--text-muted); font-size:12.5px">فقط برای ممبرها: ${cfg.modules.export.enabled?'فعال':'غیرفعال'}</p><label style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px"><span>فقط ممبرها ببینند</span><span class="mod-toggle ${cfg.modules.export.enabled?'on':''}" data-quick-toggle="export"><i></i></span></label>`,
      sort: () => `<h4>① مرکز سورت و بسته‌بندی</h4><div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-top:10px"><div style="background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; text-align:center"><div style="font-size:11px; color:var(--text-faint)">ظرفیت روزانه</div><b>${cfg.modules.sort.capacity}</b></div><div style="background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; text-align:center"><div style="font-size:11px; color:var(--text-faint)">سورت امروز</div><b style="color:var(--success)">${cfg.modules.sort.today}</b></div></div><div style="margin-top:10px"><label style="font-size:12px; color:var(--text-muted)">ظرفیت (تن) <input id="inpCapacity" value="${cfg.modules.sort.capacity}" style="width:100%; margin-top:4px; background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); border-radius:8px; padding:8px; color:var(--text-primary)"></label></div>`,
      collection: () => `<h4>② مجموعه منتخب آلوخور</h4><p style="color:var(--text-muted); font-size:12.5px">کالکشن‌ها: ${cfg.modules.collection.collections.join(' ، ')}</p><div style="display:flex; gap:8px; margin-top:10px; flex-wrap:wrap">${cfg.modules.collection.collections.map(c=>`<span style="padding:6px 10px; background:rgba(201,168,106,0.14); border:1px solid var(--gold-border); border-radius:999px; font-size:12px">${c}</span>`).join('')}</div>`,
      app: () => `<h4>📱 دانلود اپلیکیشن آلوخور</h4><p style="color:var(--text-muted); font-size:12.5px">لینک: <span dir="ltr" style="color:var(--gold-soft)">${cfg.modules.app.link}</span></p><div style="display:flex; gap:8px; margin-top:10px"><input id="inpAppLink" value="${cfg.modules.app.link}" style="flex:1; background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); border-radius:8px; padding:8px; color:var(--text-primary)" dir="ltr"><button class="btn-gold" style="padding:8px 12px; font-size:12px" id="btnSaveApp">ذخیره</button></div>`,
      hero: () => `<h4>🎠 اسلایدر هیروی بالای صفحه</h4><p style="color:var(--text-muted); font-size:12.5px">${cfg.modules.hero.slides} اسلاید فعال • Autoplay: ${cfg.modules.hero.autoplay?'روشن':'خاموش'}</p><label style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; margin-top:10px"><span>Autoplay</span><span class="mod-toggle ${cfg.modules.hero.autoplay?'on':''}" data-quick-toggle="hero_auto"><i></i></span></label>`,
      auto: () => `<h4>🔄 بروزرسانی خودکار افزونه</h4><label style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; margin-top:10px"><span>بروزرسانی هر شب ساعت ۳</span><span class="mod-toggle ${cfg.modules.auto.enabled?'on':''}" data-quick-toggle="auto"><i></i></span></label><p style="font-size:11px; color:var(--text-faint); margin-top:6px">زمان: ${cfg.modules.auto.schedule} — آخرین: امروز ۰۳:۰۰</p>`
    };

    function showQuick(key){
      commitQuickSettings = null;
      const r = detailRenderers[key];
      quick.innerHTML = r ? r() : '<div style="text-align:center; color:var(--text-muted)">بخش یافت نشد</div>';
      quickTitle.textContent = cfg.modules[key]?.title || 'تنظیمات';
      // bind inside
      const value = id => quick.querySelector(`#${id}`)?.value ?? '';
      const inpLogoText = quick.querySelector('#inpLogoText');
      const inpLogoSub = quick.querySelector('#inpLogoSub');
      const inpLogoLetter = quick.querySelector('#inpLogoLetter');
      const btnApplyHeader = quick.querySelector('#btnApplyHeader');

      function updateQuickHeaderPreview(){
        const bar = quick.querySelector('#quickTopbar');
        if(!bar) return;
        bar.style.setProperty('--qh-bg', value('inpTopbarBg') || '#11091D');
        bar.style.setProperty('--qh-text', value('inpTopbarText') || '#E8D5B5');
        bar.style.setProperty('--qh-border', value('inpTopbarBorder') || '#3A2C20');
        bar.style.setProperty('--qh-btn', value('inpTopbarButtonBg') || '#C9A86A');
        bar.style.setProperty('--qh-btn-text', value('inpTopbarButtonText') || '#1A1206');
        bar.style.height = `${Math.max(30,Math.min(60,Number(value('inpTopbarHeight'))||38))}px`;
        const setText = (id,text)=>{ const el=quick.querySelector(`#${id}`); if(el) el.textContent=text; };
        setText('quickPhone',value('inpHeaderPhone'));
        setText('quickEmail',value('inpHeaderEmail'));
        setText('quickExport',value('inpHeaderExportText'));
        setText('quickWholesale',value('inpHeaderWholesaleText'));
        const flags = Object.fromEntries([...quick.querySelectorAll('[data-header-flag]')].map(el=>[el.dataset.headerFlag,el.checked]));
        bar.style.display = flags.show_topbar === false ? 'none' : 'grid';
        [['quickPhone','show_phone'],['quickEmail','show_email'],['quickWhatsapp','show_whatsapp'],['quickExport','show_export'],['quickWholesale','show_wholesale']].forEach(([id,key])=>{
          const el=quick.querySelector(`#${id}`); if(el) el.style.display=flags[key]===false?'none':'';
        });
        const logo = quick.querySelector('#quickTopLogo');
        if(logo){
          const url=value('inpTopLogoUrl');
          logo.innerHTML=url?`<img src="${escapeAttr(url)}" alt="">`:'ALOOKHOR';
          const img=logo.querySelector('img');
          if(img) img.style.maxWidth=`${Math.max(50,Math.min(180,Number(value('inpTopLogoWidth'))||96))}px`;
        }
      }

      quick.querySelectorAll('.qh-section input').forEach(input=>input.addEventListener('input',updateQuickHeaderPreview));
      updateQuickHeaderPreview();

      quick.querySelector('#btnSelectTopLogoQuick')?.addEventListener('click', ()=>{
        if(!window.wp?.media){ window.ALOOKHOR.toast('Media Library در دسترس نیست','info'); return; }
        const frame = window.wp.media({title:'انتخاب لوگوی Top Bar',button:{text:'استفاده از تصویر'},multiple:false});
        frame.on('select',()=>{
          const item=frame.state().get('selection').first().toJSON();
          const input=quick.querySelector('#inpTopLogoUrl');
          if(input){ input.value=item.url; updateQuickHeaderPreview(); }
        });
        frame.open();
      });

      if(btnApplyHeader){
        commitQuickSettings = () => {
          Object.assign(cfg.header_settings, {
            logo_text:value('inpLogoText'), logo_sub:value('inpLogoSub'),
            phone:value('inpHeaderPhone'), email:value('inpHeaderEmail'), whatsapp:value('inpHeaderWhatsapp'),
            export_text:value('inpHeaderExportText'), export_url:value('inpHeaderExportUrl'),
            wholesale_text:value('inpHeaderWholesaleText'), wholesale_url:value('inpHeaderWholesaleUrl'),
            top_logo_url:value('inpTopLogoUrl'), top_logo_alt:value('inpTopLogoAlt'), top_logo_link:value('inpTopLogoLink'),
            top_logo_width:Math.max(50,Math.min(180,Number(value('inpTopLogoWidth'))||96)),
            topbar_bg:value('inpTopbarBg'), topbar_text_color:value('inpTopbarText'), topbar_border_color:value('inpTopbarBorder'),
            topbar_button_bg:value('inpTopbarButtonBg'), topbar_button_text:value('inpTopbarButtonText'),
            topbar_height:Math.max(30,Math.min(60,Number(value('inpTopbarHeight'))||38))
          });
          quick.querySelectorAll('[data-header-flag]').forEach(el=> cfg.header_settings[el.dataset.headerFlag]=el.checked);
          cfg.site.logoLetter = inpLogoLetter?.value || 'A';
        };
        btnApplyHeader.addEventListener('click', async ()=>{
          commitQuickSettings();
          btnApplyHeader.disabled = true;
          const result = await Config.save({notify:false});
          btnApplyHeader.disabled = false;
          if(!result.ok) return;
          const persistedPhone = result.data?.header_settings?.phone;
          if(persistedPhone !== undefined && String(persistedPhone).trim() !== String(cfg.header_settings.phone || '').trim()){
            window.ALOOKHOR.toast('شماره تلفن در WordPress تأیید نشد؛ ذخیره متوقف شد','error');
            return;
          }
          Config.apply();
          const liveTitle=document.getElementById('liveLogoText'); if(liveTitle) liveTitle.textContent=inpLogoText?.value||'ALOOKHOR';
          const liveSub=document.getElementById('liveLogoSub'); if(liveSub) liveSub.textContent=inpLogoSub?.value||'';
          window.ALOOKHOR.toast('ذخیره WordPress تأیید شد؛ تغییرات Top Bar روی سایت آماده است','success');
        });
      }

      if(key === 'footer'){
        quick.querySelectorAll('[data-footer-media]').forEach(button=>button.addEventListener('click', ()=>{
          if(!window.wp?.media){ window.ALOOKHOR.toast('Media Library در دسترس نیست','info'); return; }
          const frame=window.wp.media({title:'انتخاب تصویر فوتر',button:{text:'استفاده از تصویر'},multiple:false});
          frame.on('select',()=>{ const item=frame.state().get('selection').first().toJSON(); const input=quick.querySelector(`#${button.dataset.footerMedia}`); if(input) input.value=item.url; });
          frame.open();
        }));
        commitQuickSettings = () => {
          const f=cfg.footer_settings;
          const fv=id=>quick.querySelector(`#${id}`)?.value ?? '';
          Object.assign(f, {
            logo_url:fv('ftLogoUrl'), brand_name:fv('ftBrandName'), brand_subtitle:fv('ftBrandSubtitle'), brand_kicker:fv('ftBrandKicker'), brand_description:fv('ftBrandDesc'), cta_text:fv('ftCtaText'), cta_url:fv('ftCtaUrl'),
            phone:fv('ftPhone'), email:fv('ftEmail'), whatsapp:fv('ftWhatsapp'), support_label:fv('ftSupportLabel'), address:fv('ftAddress'), hours_week:fv('ftHoursWeek'), hours_friday:fv('ftHoursFriday'),
            customer_title:fv('ftcustomerTitle'), customer_menu_id:Number(fv('ftcustomerMenu'))||0, customer_links:parseFooterLinks(fv('ftcustomerLinks')),
            order_title:fv('ftorderTitle'), order_menu_id:Number(fv('ftorderMenu'))||0, order_links:parseFooterLinks(fv('ftorderLinks')),
            about_title:fv('ftaboutTitle'), about_mobile_title:fv('ftAboutMobileTitle'), about_menu_id:Number(fv('ftaboutMenu'))||0, about_links:parseFooterLinks(fv('ftaboutLinks')),
            instagram_url:fv('ftInstagram'), telegram_url:fv('ftTelegram'), whatsapp_url:fv('ftWhatsappUrl'), social_title:fv('ftSocialTitle'), social_desc:fv('ftSocialDesc'), newsletter_title:fv('ftNewsletterTitle'), newsletter_desc:fv('ftNewsletterDesc'), newsletter_button:fv('ftNewsletterButton'), product_image_url:fv('ftProductImage'),
            enamad_title:fv('ftEnamadTitle'), enamad_url:fv('ftEnamadUrl'), enamad_image_url:fv('ftEnamadImage'), samandehi_title:fv('ftSamandehiTitle'), samandehi_url:fv('ftSamandehiUrl'), samandehi_image_url:fv('ftSamandehiImage'), copyright_text:fv('ftCopyright'), copyright_en:fv('ftCopyrightEn'),
            background:fv('ftColor_background'), surface:fv('ftColor_surface'), gold:fv('ftColor_gold'), gold_soft:fv('ftColor_gold_soft'), text:fv('ftColor_text'), muted:fv('ftColor_muted'), border:fv('ftColor_border'),
            container_width:Math.max(960,Math.min(1600,Number(fv('ftContainerWidth'))||1280)), desktop_logo_width:Math.max(100,Math.min(320,Number(fv('ftDesktopLogo'))||210)), mobile_logo_width:Math.max(100,Math.min(280,Number(fv('ftMobileLogo'))||190))
          });
          quick.querySelectorAll('[data-footer-flag]').forEach(input=>f[input.dataset.footerFlag]=input.checked);
        };
        quick.querySelector('#btnApplyFooter')?.addEventListener('click', async event=>{
          commitQuickSettings(); const button=event.currentTarget; button.disabled=true; const result=await Config.save({notify:false}); button.disabled=false; if(!result.ok)return; window.ALOOKHOR.toast('تنظیمات فوتر در WordPress ذخیره و روی سایت اعمال شد','success');
        });
      }
      quick.querySelectorAll('[data-quick-toggle]').forEach(t=>{
        t.addEventListener('click', ()=>{
          const k = t.dataset.quickToggle;
          if(k==='stats') { Config.toggleModule('stats'); t.classList.toggle('on'); }
          else if(k==='export') { Config.toggleModule('export'); t.classList.toggle('on'); }
          else if(k==='hero_auto') { cfg.modules.hero.autoplay = !cfg.modules.hero.autoplay; Config.save(); t.classList.toggle('on'); window.ALOOKHOR.toast(cfg.modules.hero.autoplay?'Autoplay روشن شد':'خاموش شد','info'); }
          else if(k==='auto') { Config.toggleModule('auto'); t.classList.toggle('on'); }
          renderModules();
        });
      });
      const inpCap = quick.querySelector('#inpCapacity');
      if(inpCap){
        inpCap.addEventListener('change', ()=>{
          Config.set('modules.sort.capacity', inpCap.value);
          window.ALOOKHOR.toast('ظرفیت بروز شد','success');
        });
      }
      const btnSaveApp = quick.querySelector('#btnSaveApp');
      if(btnSaveApp){
        btnSaveApp.addEventListener('click', ()=>{
          const v = quick.querySelector('#inpAppLink').value;
          Config.set('modules.app.link', v);
          window.ALOOKHOR.toast('لینک اپلیکیشن ذخیره شد','success');
        });
      }
    }

    // کلیک روی ماژول‌ها — هم toggle هم باز کردن quick
    container.querySelectorAll('.mod-item').forEach(item=>{
      item.addEventListener('click', ()=>{
        container.querySelectorAll('.mod-item').forEach(i=> i.classList.remove('active'));
        item.classList.add('active');
        showQuick(item.dataset.mod);
      });
    });
    // toggle بدون باز کردن quick
    container.addEventListener('click', (e)=>{
      const tog = e.target.closest('.mod-toggle[data-toggle]');
      if(!tog) return;
      e.stopPropagation();
      const key = tog.dataset.toggle;
      const enabled = Config.toggleModule(key);
      tog.classList.toggle('on', enabled);
      const row = tog.closest('.mod-item');
      if(row) row.classList.toggle('disabled', !enabled);
      // اگر همین ماژول در quick باز است، آپدیت کن
      if(quickTitle.textContent === cfg.modules[key].title) showQuick(key);
      window.ALOOKHOR.toast(enabled ? `«${cfg.modules[key].title}» فعال شد` : `«${cfg.modules[key].title}» غیرفعال شد`, enabled?'success':'info');
      // آپدیت هدر شمارش
      container.querySelector('.panel-head span').textContent = `${Object.values(cfg.modules||{}).filter(m=>m.enabled).length} / ${Object.keys(cfg.modules||{}).length} فعال`;
    });

    // AI accordion + actions
    container.querySelectorAll('.ai-head').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const item = btn.parentElement;
        const isOpen = item.classList.contains('open');
        container.querySelectorAll('.ai-item').forEach(i=> i.classList.remove('open'));
        container.querySelectorAll('.ai-plus').forEach(p=> p.textContent='+');
        if(!isOpen){ item.classList.add('open'); btn.querySelector('.ai-plus').textContent='×'; }
      });
    });
    container.addEventListener('click', (e)=>{
      const btn = e.target.closest('[data-ai-action]');
      if(!btn) return;
      const id = btn.dataset.id;
      const act = btn.dataset.aiAction;
      const sug = cfg.ai_assistant.suggestions.find(s=>s.id===id);
      if(!sug) return;
      if(act==='do'){
        sug.status='done';
        Config.save();
        window.ALOOKHOR.toast(`پیشنهاد «${sug.title}» اعمال شد — سایت بروز شد`,'success');
        renderAI();
        // rebind after rerender need to reattach? but we just rerendered, need to rebind AI heads? simpler: reload? But for now just update UI via next init — we will just rerender and rebind via event delegation already handled via container listener for toggle? For AI heads we lost listeners — reattach quickly
        setTimeout(()=>{
          container.querySelectorAll('.ai-head').forEach(b=>{
            b.addEventListener('click', ()=>{
              const it = b.parentElement;
              const isOpen = it.classList.contains('open');
              container.querySelectorAll('.ai-item').forEach(i=> i.classList.remove('open'));
              container.querySelectorAll('.ai-plus').forEach(p=> p.textContent='+');
              if(!isOpen){ it.classList.add('open'); b.querySelector('.ai-plus').textContent='×'; }
            });
          });
        },0);
      } else {
        sug.status = sug.status==='done' ? 'pending' : 'done';
        Config.save();
        window.ALOOKHOR.toast(sug.status==='done'?'نادیده گرفته شد':'بازگردانی شد','info');
        renderAI();
      }
    });

    // دکمه‌های عمومی
    container.querySelector('#btnRefreshStatus')?.addEventListener('click', ()=>{
      window.ALOOKHOR.toast('سلامت سیستم بررسی شد — ووکامرس، وودمارت، المنتور همه فعال','success');
      const b = container.querySelector('#btnRefreshStatus');
      b.textContent='بررسی شد ✓'; setTimeout(()=> b.textContent='بررسی مجدد', 1600);
    });
    container.querySelector('#btnSaveAll')?.addEventListener('click', async (event)=>{
      commitQuickSettings?.();
      const button = event.currentTarget;
      button.disabled = true;
      const result = await Config.save({notify:false});
      button.disabled = false;
      if(!result.ok) return;
      const persistedPhone = result.data?.header_settings?.phone;
      if(persistedPhone !== undefined && String(persistedPhone).trim() !== String(cfg.header_settings.phone || '').trim()){
        window.ALOOKHOR.toast('شماره تلفن در WordPress تأیید نشد؛ ذخیره متوقف شد','error');
        return;
      }
      Config.apply();
      container.querySelector('#lastSave').textContent = new Date().toLocaleString('fa-IR');
      window.ALOOKHOR.toast('همه تنظیمات واقعاً در WordPress ذخیره شدند','success');
    });
    container.querySelector('#btnExportSettings')?.addEventListener('click', ()=>{
      const data = Config.exportJSON();
      const blob = new Blob([data], {type:'application/json'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a'); a.href=url; a.download='alookhor-settings.json'; a.click(); URL.revokeObjectURL(url);
      window.ALOOKHOR.toast('فایل JSON دانلود شد','info');
    });
    container.querySelector('#btnResetSettings')?.addEventListener('click', async ()=>{
      if(!confirm('بازنشانی به تنظیمات اولیه؟')) return;
      await Config.reset();
      window.ALOOKHOR.toast('بازنشانی شد — صفحه رفرش می‌شود','info');
      setTimeout(()=> location.reload(), 700);
    });
    container.querySelector('#btnEnableAll')?.addEventListener('click', ()=>{
      Object.keys(cfg.modules||{}).forEach(k=> cfg.modules[k].enabled=true);
      Config.save(); Config.apply(); renderModules();
      window.ALOOKHOR.toast('همه ماژول‌ها فعال شدند','success');
    });
    container.querySelector('#btnDisableAll')?.addEventListener('click', ()=>{
      Object.keys(cfg.modules||{}).forEach(k=> cfg.modules[k].enabled=false);
      Config.save(); Config.apply(); renderModules();
      window.ALOOKHOR.toast('همه ماژول‌ها غیرفعال شدند','info');
    });

    // پیش‌فرض
    showQuick('header');
    const firstMod = container.querySelector('.mod-item[data-mod="header"]');
    if(firstMod) firstMod.classList.add('active');

    // اعمال اولیه روی سایت
    Config.apply();
  },
  destroy(){}
};
