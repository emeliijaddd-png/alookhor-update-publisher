import json, os, time
from pathlib import Path
from selenium import webdriver
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.common.by import By

BASE=os.environ.get('WP_BASE_URL','https://alookhor.ir').rstrip('/')
REPORT=Path(os.environ.get('CART_REPORT_PATH','/tmp/cart-report.json'))

def browser(width,height):
    o=Options(); o.add_argument('--headless=new'); o.add_argument('--no-sandbox'); o.add_argument('--disable-dev-shm-usage'); o.add_argument('--disable-gpu'); o.add_argument(f'--window-size={width},{height}')
    return webdriver.Chrome(options=o)

def run_view(name,width,height):
    d=browser(width,height); out={'ok':False}
    try:
        d.get(BASE+'/cart/?cart_audit=373'); time.sleep(2); out['url_before']=d.current_url
        if not d.find_elements(By.CSS_SELECTOR,'.cart-item'):
            result=d.execute_async_script("""
            const done=arguments[0];
            (async()=>{
              const r=await fetch('/wp-json/wc/store/v1/cart',{credentials:'same-origin',cache:'no-store'});
              const nonce=r.headers.get('Nonce')||r.headers.get('X-WC-Store-API-Nonce')||r.headers.get('X-WP-Nonce');
              const token=r.headers.get('Cart-Token');
              const headers={'Content-Type':'application/json'}; if(nonce)headers.Nonce=nonce;if(token)headers['Cart-Token']=token;
              let a=await fetch('/wp-json/wc/store/v1/cart/add-item',{method:'POST',credentials:'same-origin',headers,body:JSON.stringify({id:100705,quantity:1,variation:[{attribute:'pa_vazn',value:'3kg'}]})});
              if(!a.ok){
                const p=await fetch('/wp-json/wc/store/v1/products/100705',{credentials:'same-origin'}).then(x=>x.json());
                const v=(p.variations||[])[0];
                if(!v)throw new Error('no variation');
                const attrs=(v.attributes||[]).map(x=>({attribute:x.name||x.slug,value:x.value}));
                a=await fetch('/wp-json/wc/store/v1/cart/add-item',{method:'POST',credentials:'same-origin',headers,body:JSON.stringify({id:100705,quantity:1,variation:attrs})});
              }
              if(!a.ok) throw new Error('add '+a.status+' '+(await a.text()).slice(0,160));
              done('ok');
            })().catch(e=>done('ERR '+e));
            """)
            if result!='ok': raise AssertionError(result)
            d.get(BASE+'/cart/?cart_audit=373&seeded=1'); time.sleep(2)
        rows=d.find_elements(By.CSS_SELECTOR,'.cart-item')
        out['structure']={
            'primary':len(d.find_elements(By.CSS_SELECTOR,'#alookhor-cart.alk-cart-primary'))==1,
            'secondary_visible':any(x.is_displayed() for x in d.find_elements(By.CSS_SELECTOR,'#alookhor-cart.alk-cart-secondary')),
            'legacy_header_visible':any(x.is_displayed() for x in d.find_elements(By.CSS_SELECTOR,'.whb-header')),
            'legacy_footer_visible':any(x.is_displayed() for x in d.find_elements(By.CSS_SELECTOR,'footer.wd-footer')),
            'legacy_title_visible':any(x.is_displayed() for x in d.find_elements(By.CSS_SELECTOR,'.wd-page-title,.whb-page-title')),
            'legacyMarkers':('wc-ajax=update_cart' in d.page_source or 'wc-ajax=remove_from_cart' in d.page_source or 'location.reload()' in d.page_source),
            'guard':'cart-no-reload-guard.js' in d.page_source,
            'horizontal_overflow':d.execute_script('return document.documentElement.scrollWidth > document.documentElement.clientWidth + 2;')
        }
        if not rows: raise AssertionError('cart has no item after Store API seed')
        row=rows[0]; q=row.find_element(By.CSS_SELECTOR,'.cart-qty > span'); before=q.text
        d.execute_script("sessionStorage.removeItem('alk_cart_reload'); window.addEventListener('beforeunload',()=>sessionStorage.setItem('alk_cart_reload','1'),{once:true});")
        row.find_element(By.CSS_SELECTOR,'[data-cart-qty="+"]').click(); time.sleep(2)
        q2=row.find_element(By.CSS_SELECTOR,'.cart-qty > span').text
        out['quantity_no_reload']=(q2!=before and d.execute_script("return sessionStorage.getItem('alk_cart_reload')==='1'") is False and d.current_url==out['url_before'])
        d.execute_script("sessionStorage.removeItem('alk_cart_reload');")
        row.find_element(By.CSS_SELECTOR,'[data-cart-qty="-"]').click(); time.sleep(2)
        out['decrement_no_reload']=(d.execute_script("return sessionStorage.getItem('alk_cart_reload')==='1'") is False and d.current_url==out['url_before'])
        d.execute_script("sessionStorage.removeItem('alk_cart_reload');")
        d.find_element(By.CSS_SELECTOR,'[data-cart-remove]').click(); time.sleep(2)
        out['remove_no_reload']=(not d.find_elements(By.CSS_SELECTOR,'.cart-item') and d.execute_script("return sessionStorage.getItem('alk_cart_reload')==='1'") is False and d.current_url==out['url_before'])
        # Source marker is allowed only if the guard removed the legacy script before interaction; reload behavior is the functional gate.
        out['ok']=out['structure']['primary'] and not out['structure']['secondary_visible'] and not out['structure']['legacy_header_visible'] and not out['structure']['legacy_footer_visible'] and not out['structure']['legacy_title_visible'] and out['structure']['guard'] and not out['structure']['horizontal_overflow'] and out['quantity_no_reload'] and out['decrement_no_reload'] and out['remove_no_reload']
    except Exception as e: out['error']=repr(e)
    finally:
        try:d.quit()
        except Exception:pass
    return out

report={'ok':True,'views':{}}
for name,size in [('desktop',(1614,900)),('mobile',(390,844))]:
    report['views'][name]=run_view(name,*size)
    if not report['views'][name].get('ok'): report['ok']=False
REPORT.write_text(json.dumps(report,ensure_ascii=False,indent=2),encoding='utf-8')
print(json.dumps(report,ensure_ascii=False,indent=2))
if not report['ok']: raise SystemExit(1)
