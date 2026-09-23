/* ALOOKHOR CART v4 - Store API Single Source of Truth - Luxury - Production */
(function(){
  const NS = '#alookhor-cart';
  const API_BASE = '/wp-json/wc/store/v1';
  let state = {
    cart: null,
    items: [],
    totals: null,
    coupons: [],
    shipping_rates: [],
    loading: true,
    updating: null,
    error: null,
    nonce: null,
  };

  function log(...a){ console.log('[ALOOKHOR Cart]', ...a); }

  function getNonce(){
    // WooCommerce Store API nonce from wpApiSettings or meta
    if(window.wcStoreApiNonce) return window.wcStoreApiNonce;
    const el = document.querySelector('meta[name="wc-store-api-nonce"]');
    if(el) return el.content;
    // Try from wpApiSettings
    if(window.wpApiSettings && window.wpApiSettings.nonce) return window.wpApiSettings.nonce;
    return '';
  }

  async function apiFetch(path, opts={}){
    const url = API_BASE + path;
    const headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };
    const nonce = getNonce() || state.nonce;
    if(nonce) headers['Nonce'] = nonce;
    // Also try X-WC-Store-API-Nonce
    if(nonce) headers['X-WC-Store-API-Nonce'] = nonce;
    const res = await fetch(url, {
      method: opts.method || 'GET',
      headers,
      credentials: 'include',
      body: opts.body ? JSON.stringify(opts.body) : undefined,
    });
    // Update nonce from response header
    const newNonce = res.headers.get('Nonce') || res.headers.get('X-WC-Store-API-Nonce');
    if(newNonce) state.nonce = newNonce;
    if(!res.ok){
      const txt = await res.text();
      let data;
      try{ data = JSON.parse(txt); }catch(e){ data = {message: txt}; }
      throw new Error(data.message || data.code || 'API Error '+res.status);
    }
    const data = await res.json();
    // Update nonce if in body
    if(data.nonce) state.nonce = data.nonce;
    return data;
  }

  async function fetchCart(){
    try{
      state.loading = true;
      renderLoading();
      const data = await apiFetch('/cart');
      state.cart = data;
      state.items = data.items || [];
      state.totals = data.totals || {};
      state.coupons = data.coupons || [];
      state.shipping_rates = (data.shipping_rates && data.shipping_rates[0] && data.shipping_rates[0].shipping_rates) ? data.shipping_rates[0].shipping_rates : [];
      state.loading = false;
      state.error = null;
      renderCart();
      renderSummary();
      syncHeaderCount();
    }catch(e){
      state.loading = false;
      state.error = e.message;
      renderError();
      console.error(e);
    }
  }

  function renderLoading(){
    const root = document.querySelector(NS);
    if(!root) return;
    // Keep existing HTML but add loading class
    root.classList.add('is-loading');
  }

  function renderError(){
    const root = document.querySelector(NS);
    if(!root) return;
    root.classList.remove('is-loading');
    const errEl = root.querySelector('.cart-error');
    if(errEl){
      errEl.textContent = state.error;
      errEl.style.display = 'block';
    }
  }

  function renderCart(){
    const root = document.querySelector(NS);
    if(!root) return;
    root.classList.remove('is-loading');
    const container = root.querySelector('.cart-products .cart-items');
    if(!container) return;
    // If no items, show empty
    if(!state.items.length){
      container.innerHTML = '<div style="padding:28px;text-align:center;color:#a48db8">سبد خرید شما خالی است — <a href="/shop/" style="color:#f7b32b">رفتن به فروشگاه</a></div>';
      return;
    }
    // Render items from Store API
    container.innerHTML = state.items.map(item => {
      const prod = item;
      const name = prod.name || 'محصول';
      const img = (prod.images && prod.images[0] && prod.images[0].thumbnail) || prod.images?.[0]?.src || '';
      const qty = prod.quantity || 1;
      const price = prod.prices ? (prod.prices.price/100) : 0; // Store API prices in minor units?
      // Actually Store API v1 returns price as string in minor units? Check: prices.price is string like "100000"
      // We'll use prod.totals.line_total / qty or prod.prices.price
      const lineTotal = prod.totals ? (parseInt(prod.totals.line_total)/100) : price*qty;
      const key = prod.key;
      const permalink = prod.permalink || '#';
      // Variation weight
      let weight = '';
      if(prod.variation){
        const v = prod.variation.find(v=>v.attribute && v.attribute.includes('vazn'));
        if(v) weight = v.value;
        else if(prod.variation.length) weight = prod.variation.map(v=>v.value).join(' / ');
      }
      return `
      <div class="cart-item" data-key="${key}">
        <div class="cart-item-prod">
          <img src="${img}" alt="${name}" loading="lazy">
          <div>
            <a href="${permalink}">${name}</a>
            <span class="badge">بیشتر</span>
          </div>
        </div>
        <div><select data-weight="${key}"><option>${weight||'بسته استاندارد'}</option></select></div>
        <div class="price">${formatPrice(price)} تومان</div>
        <div><div class="cart-qty"><button type="button" data-cart-qty="-" data-key="${key}">−</button><span>${toPersian(qty)}</span><button type="button" data-cart-qty="+" data-key="${key}">+</button></div></div>
        <div class="price-total">${formatPrice(lineTotal)} تومان</div>
        <div class="cart-actions"><button type="button" aria-label="علاقه‌مندی"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg></button><button type="button" data-cart-remove="${key}" aria-label="حذف"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg></button></div>
      </div>`;
    }).join('');
    bindEvents();
  }

  function formatPrice(n){
    n = parseFloat(n)||0;
    return n.toLocaleString('fa-IR');
  }
  function toPersian(n){
    const map = {'0':'۰','1':'۱','2':'۲','3':'۳','4':'۴','5':'۵','6':'۶','7':'۷','8':'۸','9':'۹'};
    return String(n).replace(/[0-9]/g, m=>map[m]);
  }

  function renderSummary(){
    const root = document.querySelector(NS);
    if(!root) return;
    const totals = state.totals;
    if(!totals) return;
    // totals from Store API: total_items, total_discount, total_shipping, total_price etc in minor units
    const subtotal = totals.total_items ? parseInt(totals.total_items)/100 : 0;
    const discount = totals.total_discount ? parseInt(totals.total_discount)/100 : 0;
    const shipping = totals.total_shipping ? parseInt(totals.total_shipping)/100 : 0;
    const total = totals.total_price ? parseInt(totals.total_price)/100 : 0;
    const subEl = root.querySelector('.summary-rows .summary-row:nth-child(1) .value');
    const discEl = root.querySelector('.summary-rows .summary-row:nth-child(2) .value');
    const shipEl = root.querySelector('.summary-rows .summary-row:nth-child(3) .value');
    const totalEl = root.querySelector('.summary-total .value');
    if(subEl) subEl.textContent = formatPrice(subtotal) + ' تومان';
    if(discEl) discEl.textContent = formatPrice(discount) + ' تومان';
    if(shipEl) shipEl.textContent = shipping===0 ? 'رایگان' : formatPrice(shipping)+' تومان';
    if(totalEl) totalEl.textContent = formatPrice(total) + ' تومان';
  }

  function syncHeaderCount(){
    const count = state.items.reduce((a,b)=>a+(b.quantity||0),0);
    document.querySelectorAll('.wd-cart-number, .ak-cart-badge, .alookhor-header-cart-count, .cart-count, [data-cart-count]').forEach(el=>{
      el.textContent = toPersian(count);
      el.style.display = count>0 ? '' : 'none';
    });
    // Update document title? No
  }

  function bindEvents(){
    const root = document.querySelector(NS);
    if(!root) return;
    root.querySelectorAll('[data-cart-qty]').forEach(btn=>{
      btn.onclick = async function(){
        const key = this.dataset.key;
        const dir = this.dataset.cartQty || this.getAttribute('data-cart-qty');
        const item = state.items.find(i=>i.key===key);
        if(!item) return;
        let qty = item.quantity;
        if(dir==='+'||dir==='plus') qty++;
        else qty = Math.max(1, qty-1);
        await updateQuantity(key, qty);
      };
    });
    root.querySelectorAll('[data-cart-remove]').forEach(btn=>{
      btn.onclick = async function(){
        const key = this.dataset.cartRemove || this.getAttribute('data-cart-remove');
        await removeItem(key);
      };
    });
  }

  async function updateQuantity(key, quantity){
    try{
      state.updating = key;
      const itemEl = document.querySelector(`.cart-item[data-key="${key}"]`);
      if(itemEl) itemEl.classList.add('is-updating');
      await apiFetch('/cart/update-item', {
        method: 'POST',
        body: { key, quantity }
      });
      await fetchCart();
    }catch(e){
      console.error('update qty failed', e);
      alert(e.message);
      const itemEl = document.querySelector(`.cart-item[data-key="${key}"]`);
      if(itemEl) itemEl.classList.remove('is-updating');
    }
  }

  async function removeItem(key){
    try{
      state.updating = key;
      await apiFetch('/cart/remove-item', {
        method: 'POST',
        body: { key }
      });
      await fetchCart();
      // Refresh recommendations
      fetchRecommendations();
    }catch(e){
      console.error('remove failed', e);
      alert(e.message);
    }
  }

  async function applyCoupon(code){
    try{
      await apiFetch('/cart/apply-coupon', { method: 'POST', body: { code } });
      await fetchCart();
    }catch(e){ alert(e.message); }
  }

  async function fetchRecommendations(){
    try{
      const res = await fetch('/wp-json/alookhor-cart/v3/recommendations', { credentials: 'include' });
      if(!res.ok) return;
      const data = await res.json();
      renderRecommendations(data);
    }catch(e){ console.log('recs failed', e); }
  }

  function renderRecommendations(data){
    const root = document.querySelector(NS);
    if(!root) return;
    const grid = root.querySelector('.suggested-grid');
    if(!grid || !data || !data.length) return;
    grid.innerHTML = data.slice(0,4).map(p=>{
      const img = p.image || '';
      const name = p.name || '';
      const price = p.price || 0;
      return `<div class="suggested-card">
        <div class="img-wrap"><img src="${img}" alt="${name}" loading="lazy"><span class="heart">♡</span>${p.on_sale?'<span class="discount">۱۰٪ تخفیف</span>':''}</div>
        <div class="info"><span class="name">${name}</span><span class="price">${formatPrice(price)} تومان</span><button class="add-btn" data-add-id="${p.id}">افزودن</button></div>
      </div>`;
    }).join('');
    grid.querySelectorAll('[data-add-id]').forEach(btn=>{
      btn.onclick = async function(){
        const id = this.dataset.addId;
        this.textContent = 'در حال افزودن...';
        try{
          await apiFetch('/cart/add-item', { method: 'POST', body: { id: parseInt(id), quantity: 1 } });
          await fetchCart();
          fetchRecommendations();
        }catch(e){ alert(e.message); }
        this.textContent = 'افزودن';
      };
    });
  }

  // Init
  document.addEventListener('DOMContentLoaded', function(){
    log('v4 Store API init');
    // Hide white pill etc (legacy)
    try{
      document.querySelectorAll('.wd-page-title,.whb-page-title,.page-title,.entry-header,.wd-page-heading,.wd-checkout-steps').forEach(el=>{
        if(el.closest('#alookhor-cart')||el.closest('header')||el.closest('footer')) return;
        el.style.display='none';
      });
      const cart = document.getElementById('alookhor-cart');
      if(cart){ cart.style.display='block'; cart.style.visibility='visible'; cart.style.opacity='1'; }
      document.body.style.background='#0d0510';
    }catch(e){}
    // Try to get nonce from localized script
    const nonceEl = document.getElementById('alookhor-cart-nonce');
    if(nonceEl) state.nonce = nonceEl.textContent.trim();
    fetchCart();
    fetchRecommendations();
    // Coupon
    const couponBtn = document.querySelector('#alookhor-cart .coupon-box button');
    const couponInput = document.querySelector('#alookhor-cart .coupon-box input');
    if(couponBtn && couponInput){
      couponBtn.onclick = function(){ if(couponInput.value.trim()) applyCoupon(couponInput.value.trim()); };
    }
  });
})();
// Additional white fix for cart left white area
document.addEventListener('DOMContentLoaded', function(){
  function hideCartWhite(){
    const lux = document.getElementById('alookhor-cart');
    if(!lux) return;
    // Hide any element with white background outside luxury
    document.querySelectorAll('.woocommerce-cart-form, .cart-collaterals, .shop_table, .wd-cart, .wd-empty-cart, .return-to-shop, .cross-sells, .wd-cross-sells, .elementor-widget-woocommerce-cart, .elementor-widget-wd_products, .wd-products-element').forEach(el=>{
      if(el.closest('#alookhor-cart') || el.closest('header') || el.closest('footer') || el.closest('.whb-header')) return;
      el.style.setProperty('display','none','important');
    });
    // Hide any large white container with width > 200px and white bg
    document.querySelectorAll('div, section, aside').forEach(el=>{
      if(el.closest('#alookhor-cart') || el.closest('header') || el.closest('footer') || el.closest('.whb-header') || el.id==='alookhor-cart') return;
      try{
        const style = getComputedStyle(el);
        const bg = style.backgroundColor;
        const isWhite = bg==='rgb(255, 255, 255)' || bg==='rgba(255, 255, 255, 1)' || bg.includes('255, 255, 255');
        if(isWhite && el.offsetWidth>200 && el.offsetHeight>100){
          // Check if it's sibling of luxury or parent of luxury? If it contains luxury, don't hide
          if(el.contains(lux)) return;
          el.style.setProperty('display','none','important');
        }
      }catch(e){}
    });
    lux.style.setProperty('display','block','important');
    lux.style.setProperty('visibility','visible','important');
    lux.style.setProperty('opacity','1','important');
    document.body.style.background='#0d0510';
  }
  hideCartWhite();
  setTimeout(hideCartWhite, 300);
  setTimeout(hideCartWhite, 1000);
  setTimeout(hideCartWhite, 2000);
});
