/**
 * ALOOKHOR Control Center — WP Admin Bridge
 * آپدیت آنی بدون رفرش — هر تغییری مستقیماً روی وردپرس اعمال می‌شود
 */
(function($){
    'use strict';

    // ——— Helper: Toast (همان لوکس) ———
    function toast(msg, type='success'){
        const stack = document.getElementById('toastStack');
        if(!stack){
            console.log(msg);
            return;
        }
        const el = document.createElement('div');
        el.className = 'toast';
        const icon = type==='update' ? '✦' : type==='info' ? '◐' : '✓';
        el.innerHTML = `<div class="toast-icon">${icon}</div><div style="flex:1"><div style="font-weight:700; font-size:13px">${msg}</div><div style="font-size:12px; color:var(--text-muted); margin-top:2px">${new Date().toLocaleTimeString('fa-IR')}</div></div><button onclick="this.parentElement.remove()" style="background:none; border:0; color:var(--text-faint); cursor:pointer; font-size:16px">×</button>`;
        stack.appendChild(el);
        setTimeout(()=> { el.style.opacity='0'; el.style.transform='translateY(8px)'; setTimeout(()=>el.remove(),300)}, 4200);
    }

    // ——— Override Config for WP: save via AJAX ———
    if(window.Config && window.ALOOKHOR_CC){
        const originalSave = window.Config.save;
        window.Config.save = function(){
            if(!this.data) return;
            this.data.updated_at = new Date().toISOString();
            // local backup
            try{ localStorage.setItem('alookhor_real_config_v38', JSON.stringify(this.data)); }catch(e){}
            // WP AJAX save — آپدیت آنی
            $.post(ALOOKHOR_CC.ajax_url, {
                action: 'alookhor_save_settings',
                nonce: ALOOKHOR_CC.nonce,
                payload: JSON.stringify(this.data)
            }, function(res){
                if(res && res.success){
                    toast('ذخیره شد — بدون رفرش روی وردپرس اعمال شد','success');
                    // همچنین هدر شورت‌کد را بروز کن
                    if(window.Config.data?.header_settings){
                        // trigger live header update if on front
                    }
                } else {
                    toast('خطا در ذخیره: ' + (res.data||'نامشخص'),'info');
                }
            }).fail(function(){
                toast('ذخیره محلی انجام شد (آفلاین)','info');
            });
            window.dispatchEvent(new CustomEvent('alookhor:config:changed', {detail: this.data}));
        };

        // Toggle module via dedicated AJAX (سریع‌تر)
        const originalToggle = window.Config.toggleModule;
        window.Config.toggleModule = function(key){
            if(!this.data.modules[key]) return false;
            const enabled = !this.data.modules[key].enabled;
            this.data.modules[key].enabled = enabled;
            // local
            try{ localStorage.setItem('alookhor_real_config_v38', JSON.stringify(this.data)); }catch(e){}
            // WP
            $.post(ALOOKHOR_CC.ajax_url, {
                action: 'alookhor_toggle_module',
                nonce: ALOOKHOR_CC.nonce,
                module: key,
                enabled: enabled ? '1' : '0'
            }, function(res){
                if(res && res.success) toast(res.data?.message || (enabled?'فعال شد':'غیرفعال شد'), enabled?'success':'info');
            });
            window.dispatchEvent(new CustomEvent('alookhor:config:changed', {detail: this.data}));
            return enabled;
        };
    }

    // ——— Global: هر دکمه ذخیره در کنترل سنتر، WP AJAX را صدا بزند ———
    $(document).on('click', '#btnSaveAll', function(){
        // Config.save قبلاً override شده، فقط toast اضافه
        // این دکمه در settings.js هم هندل می‌شود، اینجا فقط اطمینان
    });

    // ——— نمایش نسخه و شورت‌کد در کنسول ———
    console.log('%cALOOKHOR Control Center v'+ (window.ALOOKHOR_CC?.version || '3.8.0') +' — WP Plugin Active — آپدیت آنی فعال',"color:#C9A86A; font-size:13px; font-weight:700");
    console.log('Shortcode: ' + (window.ALOOKHOR_CC?.header_shortcode || '[alookhor_portal_header]'));

})(jQuery);
