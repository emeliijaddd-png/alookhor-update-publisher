/**
 * ALOOKHOR Control Center — WP Admin Bridge
 * آپدیت آنی بدون رفرش — هر تغییری مستقیماً روی وردپرس اعمال می‌شود
 */
(function($){
    'use strict';

    function toast(msg, type='success'){
        const stack = document.getElementById('toastStack');
        if(!stack){ console.log(msg); return; }
        const el = document.createElement('div');
        el.className = 'toast';
        const icon = type==='update' ? '✦' : type==='info' ? '◐' : '✓';
        el.innerHTML = `<div class="toast-icon">${icon}</div><div style="flex:1"><div style="font-weight:700; font-size:13px">${msg}</div><div style="font-size:12px; color:var(--text-muted); margin-top:2px">${new Date().toLocaleTimeString('fa-IR')}</div></div><button onclick="this.parentElement.remove()" style="background:none;border:0;color:var(--text-faint);cursor:pointer;font-size:16px">×</button>`;
        stack.appendChild(el);
        setTimeout(()=>{el.style.opacity='0';el.style.transform='translateY(8px)';setTimeout(()=>el.remove(),300)},4200);
    }

    // مواردی که خود WordPress/WooCommerce در منوی اصلی ارائه می‌کند، نباید در مدیریت بوتیک تکرار شوند.
    const duplicateModules = ['orders','products','categories','users','reviews'];

    function removeNativeDuplicateModules(){
        duplicateModules.forEach(function(module){
            document.querySelectorAll('[data-module="'+module+'"].nav-sub-item').forEach(function(item){
                const group = item.closest('.nav-group');
                item.remove();
                if(group){
                    const list = group.querySelector('.nav-sub-list');
                    if(list && !list.querySelector('.nav-sub-item')) group.remove();
                }
            });
        });
        document.querySelectorAll('.nav-group').forEach(function(group){
            const count = group.querySelectorAll('.nav-sub-item').length;
            const badge = group.querySelector('.nav-group-count');
            if(badge) badge.textContent = String(count);
        });
    }

    // اجرای اولیه + MutationObserver برای جلوگیری از برگشت آیتم‌های تکراری هنگام رندر ماژول‌ها.
    function protectNativeDuplicateRemoval(){
        removeNativeDuplicateModules();
        if(window.MutationObserver){
            const root = document.getElementById('alookhor-cc-root') || document.body;
            if(root && !root.__alookhorDuplicateObserver){
                const observer = new MutationObserver(function(){ removeNativeDuplicateModules(); });
                observer.observe(root,{childList:true,subtree:true});
                root.__alookhorDuplicateObserver = observer;
            }
        }
    }

    if(window.Config && window.ALOOKHOR_CC){
        const originalSave = window.Config.save;
        window.Config.save = function(){
            if(!this.data) return;
            this.data.updated_at = new Date().toISOString();
            try{ localStorage.setItem('alookhor_real_config_v38', JSON.stringify(this.data)); }catch(e){}
            $.post(ALOOKHOR_CC.ajax_url,{action:'alookhor_save_settings',nonce:ALOOKHOR_CC.nonce,payload:JSON.stringify(this.data)},function(res){
                if(res && res.success) toast('ذخیره شد — بدون رفرش روی وردپرس اعمال شد','success');
                else toast('خطا در ذخیره: '+(res.data||'نامشخص'),'info');
            }).fail(function(){ toast('ذخیره محلی انجام شد (آفلاین)','info'); });
            window.dispatchEvent(new CustomEvent('alookhor:config:changed',{detail:this.data}));
        };

        const originalToggle = window.Config.toggleModule;
        window.Config.toggleModule = function(key){
            if(!this.data.modules[key]) return false;
            const enabled = !this.data.modules[key].enabled;
            this.data.modules[key].enabled = enabled;
            try{ localStorage.setItem('alookhor_real_config_v38', JSON.stringify(this.data)); }catch(e){}
            $.post(ALOOKHOR_CC.ajax_url,{action:'alookhor_toggle_module',nonce:ALOOKHOR_CC.nonce,module:key,enabled:enabled?'1':'0'},function(res){
                if(res && res.success) toast(res.data?.message || (enabled?'فعال شد':'غیرفعال شد'),enabled?'success':'info');
            });
            window.dispatchEvent(new CustomEvent('alookhor:config:changed',{detail:this.data}));
            return enabled;
        };
    }

    $(document).on('click','#btnSaveAll',function(){});

    $(function(){
        protectNativeDuplicateRemoval();
        setTimeout(protectNativeDuplicateRemoval,100);
        setTimeout(protectNativeDuplicateRemoval,500);
        setTimeout(protectNativeDuplicateRemoval,1500);
    });

    console.log('%cALOOKHOR Control Center v'+(window.ALOOKHOR_CC?.version||'3.8.0')+' — WP Plugin Active — آپدیت آنی فعال','color:#C9A86A;font-size:13px;font-weight:700');
    console.log('Shortcode: '+(window.ALOOKHOR_CC?.header_shortcode||'[alookhor_portal_header]'));

})(jQuery);
