// ALOOKHOR Config Core — حافظه پایدار واقعی سایت
// تمام تنظیمات قبلی که با همین پنل ویرایش می‌شد، اینجا ذخیره و به سایت اعمال می‌شود

const CONFIG_URL = './config/site.json';
const STORAGE_KEY = 'alookhor_real_config_v38';

function isObject(value){
  return value && typeof value === 'object' && !Array.isArray(value);
}

function mergeConfig(defaults, saved){
  if(Array.isArray(defaults)){
    if(!Array.isArray(saved) || saved.length === 0) return defaults;
    return defaults.map((item, index)=> index in saved ? mergeConfig(item, saved[index]) : item)
      .concat(saved.slice(defaults.length));
  }
  if(isObject(defaults)){
    const output = {...defaults};
    if(isObject(saved)){
      Object.entries(saved).forEach(([key, value])=>{
        output[key] = key in defaults ? mergeConfig(defaults[key], value) : value;
      });
    }
    return output;
  }
  return saved === undefined || saved === null ? defaults : saved;
}

function hasRequiredConfig(data){
  return isObject(data)
    && isObject(data.site)
    && isObject(data.modules)
    && Object.keys(data.modules).length > 0
    && isObject(data.system)
    && isObject(data.header_settings);
}

export const Config = {
  data: null,
  source: 'none',
  lastError: '',
  async load(){
    let partial = null;
    this.lastError = '';

    // WP MODE: منبع اصلی همیشه wp_options است.
    if(window.ALOOKHOR_CC && window.ALOOKHOR_CC.ajax_url){
      try{
        const form = new FormData();
        form.append('action','alookhor_get_settings');
        form.append('nonce', window.ALOOKHOR_CC.nonce);
        const res = await fetch(window.ALOOKHOR_CC.ajax_url, {method:'POST', body:form, credentials:'same-origin'});
        const json = await res.json();
        if(json && json.success && json.data){
          if(hasRequiredConfig(json.data)){
            this.data = json.data;
            this.source = 'wordpress';
            try{ localStorage.setItem(STORAGE_KEY, JSON.stringify(this.data)); }catch(e){ console.warn('localStorage blocked', e); }
            return this.data;
          }
          // حافظه قدیمی ناقص است؛ مقادیر موجود حفظ و با Defaults ترمیم می‌شوند.
          partial = json.data;
          this.lastError = 'wordpress_config_incomplete';
        }else{
          this.lastError = 'wordpress_ajax_rejected';
        }
      }catch(e){
        this.lastError = `wordpress_ajax_failed: ${e.message}`;
        console.warn('WP config load failed, fallback to file', e);
      }
    }

    // Cache ناقص نباید مسیر فایل Defaults را مسدود کند.
    try{
      const cached = localStorage.getItem(STORAGE_KEY);
      if(cached){
        try {
          const parsed = JSON.parse(cached);
          if(hasRequiredConfig(parsed) && !partial){
            this.data = parsed;
            this.source = 'local-cache';
            return this.data;
          }
          if(!partial && isObject(parsed)) partial = parsed;
        } catch(e){}
      }
    }catch(e){ console.warn('localStorage access blocked by Tracking Prevention', e); }

    // Defaults واقعی افزونه؛ داده ناقص کاربر روی آن Override می‌شود.
    const cfgUrl = (window.ALOOKHOR_CC && window.ALOOKHOR_CC.site_json_url) ? window.ALOOKHOR_CC.site_json_url : CONFIG_URL;
    try{
      const res = await fetch(cfgUrl, {cache:'no-store'});
      if(res.ok){
        const defaults = await res.json();
        this.data = mergeConfig(defaults, partial || {});
        this.source = partial ? 'repaired-defaults' : 'defaults-file';
        this.save(); // نسخه ترمیم‌شده در WordPress و Cache ذخیره می‌شود.
        return this.data;
      }
      this.lastError += `${this.lastError ? '; ' : ''}defaults_http_${res.status}`;
    }catch(e){
      this.lastError += `${this.lastError ? '; ' : ''}defaults_failed: ${e.message}`;
      console.warn('config fetch failed', e);
    }

    // Fallback اضطراری فقط UI را زنده نگه می‌دارد و «حافظه متصل» محسوب نمی‌شود.
    this.source = 'emergency-fallback';
    this.data = { site:{name:'ALOOKHOR', subtitle:'Control Center • Luxury', logoLetter:'A'}, modules:{}, system:{}, ai_assistant:{suggestions:[]}, header_settings:{logo_text:'ALOOKHOR', logo_sub:'Control Center • Luxury'} };
    return this.data;
  },
  save(){
    if(!this.data) return;
    this.data.updated_at = new Date().toISOString();
    try{ localStorage.setItem(STORAGE_KEY, JSON.stringify(this.data)); }catch(e){ console.warn('localStorage blocked', e); }
    // همچنین برای دانلود / بکاپ
    try{ localStorage.setItem('alookhor_config_last_save', new Date().toLocaleString('fa-IR')); }catch(e){}
    // WP MODE: ذخیره آنی روی وردپرس بدون رفرش
    if(window.ALOOKHOR_CC && window.ALOOKHOR_CC.ajax_url){
        const form = new FormData();
        form.append('action','alookhor_save_settings');
        form.append('nonce', window.ALOOKHOR_CC.nonce);
        form.append('payload', JSON.stringify(this.data));
        fetch(window.ALOOKHOR_CC.ajax_url, {method:'POST', body:form, credentials:'same-origin'})
        .then(r=>r.json()).then(json=>{
            if(json && json.success){
                if(window.ALOOKHOR && window.ALOOKHOR.toast){
                    window.ALOOKHOR.toast('ذخیره شد — بدون رفرش روی وردپرس اعمال شد','success');
                }
            }
        }).catch(err=> console.warn('WP save failed', err));
    }
    window.dispatchEvent(new CustomEvent('alookhor:config:changed', {detail: this.data}));
  },
  get(path){
    return path.split('.').reduce((o,k)=> o?.[k], this.data);
  },
  set(path, value){
    const keys = path.split('.');
    let o = this.data;
    for(let i=0;i<keys.length-1;i++){ if(!o[keys[i]]) o[keys[i]]={}; o=o[keys[i]]; }
    o[keys[keys.length-1]] = value;
    this.save();
    this.apply();
  },
  toggleModule(key){
    if(!this.data.modules[key]) return;
    this.data.modules[key].enabled = !this.data.modules[key].enabled;
    this.save();
    this.apply();
    return this.data.modules[key].enabled;
  },
  // اعمال زنده روی DOM سایت — با guard کامل برای خطای TypeError
  apply(){
    try{
        if(!this.data) return;
        const d = this.data;
        // هدر و لوگو — با fallback
        const logoTitle = document.querySelector('.brand-text h1');
        const logoSub = document.querySelector('.brand-text p');
        const logoMark = document.querySelector('.brand-mark span');
        if(logoTitle) logoTitle.textContent = d.header_settings?.logo_text || d.site?.name || 'ALOOKHOR';
        if(logoSub) logoSub.textContent = d.header_settings?.logo_sub || d.site?.subtitle || 'Control Center • Luxury';
        if(logoMark) logoMark.textContent = d.site?.logoLetter || d.header_settings?.logo_letter || 'A';
        // ماژول‌ها — اگر غیرفعال شدند، در سایدبار کم‌رنگ کن — با guard
        if(d.modules && typeof d.modules === 'object'){
            Object.entries(d.modules).forEach(([k, m])=>{
              try{
                  const el = document.querySelector(`.mod-item[data-mod="${k}"]`);
                  if(el){
                    const tog = el.querySelector('.mod-toggle');
                    if(tog) tog.classList.toggle('on', !!m.enabled);
                    el.style.opacity = m.enabled ? '1' : '0.55';
                  }
              }catch(e){}
            });
        }
        // AI badge count
        const pending = d.ai_assistant?.suggestions?.filter(s=> s.status!=='done').length || 0;
    }catch(e){ console.warn('Config.apply failed', e); }
  },
  exportJSON(){
    return JSON.stringify(this.data, null, 2);
  },
  async reset(){
    try{ localStorage.removeItem(STORAGE_KEY); }catch(e){ console.warn('localStorage blocked', e); }
    // Force a fresh source read instead of immediately returning the current in-memory object.
    this.data = null;
    await this.load();
    this.apply();
  }
};
