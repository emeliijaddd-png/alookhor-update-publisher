export const dashboardModule = {
  meta: { id: 'dashboard', title: 'داشبورد', icon: 'dashboard' },
  init(container) {
    container.innerHTML = `
      <div class="page-head">
        <div>
          <h2>داشبورد لوکس — نمای کلی</h2>
          <p>آخرین به‌روزرسانی: همین حالا • مانیتورینگ زنده بوتیک ALOOKHOR</p>
        </div>
        <div class="head-actions">
          <button class="btn-ghost" data-action="export">خروجی Excel</button>
          <button class="btn-gold" data-action="new-order">+ سفارش جدید</button>
        </div>
      </div>

      <div class="kpi-grid">
        <div class="kpi-card">
          <div class="kpi-top">
            <div class="kpi-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4Z"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="M4.93 4.93l1.41 1.41"/><path d="M17.66 17.66l1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="M6.34 17.66l-1.41 1.41"/><path d="M19.07 4.93l-1.41 1.41"/></svg></div>
            <span class="kpi-trend trend-up">▲ 12.4%</span>
          </div>
          <div class="kpi-value">۲.۴B <span style="font-size:14px; color:var(--text-muted); font-family:Inter">تومان</span></div>
          <div class="kpi-label">فروش امروز</div>
          <div class="kpi-foot">نسبت به دیروز +۱۲.۴٪ — ۳ سفارش VIP</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-top">
            <div class="kpi-icon" style="color:#E8D5B5"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 2h9l5 5v15H6z"/><path d="M15 2v6h6"/></svg></div>
            <span class="kpi-trend trend-up">▲ 8.1%</span>
          </div>
          <div class="kpi-value">۱۴۷</div>
          <div class="kpi-label">سفارشات فعال</div>
          <div class="kpi-foot">۳۲ در انتظار تایید طلا</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-top">
            <div class="kpi-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M20 12V8H6"/><path d="M20 12v4H6"/><path d="M4 8v8"/></svg></div>
            <span class="kpi-trend trend-down">▼ 2.3%</span>
          </div>
          <div class="kpi-value">۱,۲۸۴</div>
          <div class="kpi-label">موجودی انبار</div>
          <div class="kpi-foot">۱۸ قلم کمتر از حد لوکس</div>
        </div>
        <div class="kpi-card">
          <div class="kpi-top">
            <div class="kpi-icon"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <span class="kpi-trend trend-up">▲ 4.7%</span>
          </div>
          <div class="kpi-value">۸۹۲</div>
          <div class="kpi-label">مشتریان VIP</div>
          <div class="kpi-foot">۱۴ مشتری جدید این هفته</div>
        </div>
      </div>

      <div class="two-col">
        <div class="panel">
          <div class="panel-head">
            <h3>سفارشات اخیر</h3>
            <button class="btn-ghost" style="padding:6px 12px; font-size:12px">مشاهده همه</button>
          </div>
          <div class="panel-body">
            <div class="table-wrap">
              <table>
                <thead><tr><th>سفارش</th><th>مشتری</th><th>مبلغ</th><th>وضعیت</th><th>تاریخ</th></tr></thead>
                <tbody>
                  <tr><td><b>#AL-9841</b></td><td>سارا احمدی — VIP Gold</td><td>۱۸۴,۰۰۰,۰۰۰ ت</td><td><span class="status status-ok"><span class="status-dot"></span> تحویل شده</span></td><td>۱۰ اوت</td></tr>
                  <tr><td><b>#AL-9840</b></td><td>امیر حسینی</td><td>۹۲,۵۰۰,۰۰۰ ت</td><td><span class="status status-warn"><span class="status-dot"></span> در ساخت</span></td><td>۱۰ اوت</td></tr>
                  <tr><td><b>#AL-9839</b></td><td>نگار کریمی — VIP</td><td>۲۱۰,۰۰۰,۰۰۰ ت</td><td><span class="status status-warn"><span class="status-dot"></span> در انتظار طلا</span></td><td>۹ اوت</td></tr>
                  <tr><td><b>#AL-9838</b></td><td>محمد رضایی</td><td>۴۵,۰۰۰,۰۰۰ ت</td><td><span class="status status-bad"><span class="status-dot"></span> لغو شده</span></td><td>۹ اوت</td></tr>
                </tbody>
              </table>
            </div>
            <div class="card-list">
              <div class="mini-card"><div class="mini-card-top"><div><h4>#AL-9841 — سارا احمدی</h4><p>VIP Gold • ۱۸۴M تومان</p></div><span class="status status-ok"><span class="status-dot"></span> تحویل</span></div><div class="mini-meta"><span>تاریخ: <b>۱۰ اوت</b></span></div></div>
              <div class="mini-card"><div class="mini-card-top"><div><h4>#AL-9840 — امیر حسینی</h4><p>۹۲.۵M تومان</p></div><span class="status status-warn"><span class="status-dot"></span> در ساخت</span></div><div class="mini-meta"><span>تاریخ: <b>۱۰ اوت</b></span></div></div>
              <div class="mini-card"><div class="mini-card-top"><div><h4>#AL-9839 — نگار کریمی</h4><p>VIP • ۲۱۰M تومان</p></div><span class="status status-warn"><span class="status-dot"></span> انتظار طلا</span></div><div class="mini-meta"><span>تاریخ: <b>۹ اوت</b></span></div></div>
            </div>
          </div>
        </div>

        <div class="panel">
          <div class="panel-head"><h3>فروش ۷ روز اخیر</h3><span style="font-size:11px; color:var(--text-faint); letter-spacing:0.08em; text-transform:uppercase">Gold Chart</span></div>
          <div class="chart-box">
            <div class="chart-canvas" id="chartCanvas">
              <div class="chart-bars" id="chartBars"></div>
            </div>
            <div style="display:flex; justify-content:space-between; margin-top:10px; font-size:11px; color:var(--text-faint)">
              <span>شنبه</span><span>یک‌شنبه</span><span>دوشنبه</span><span>سه‌شنبه</span><span>چهارشنبه</span><span>پنج‌شنبه</span><span>جمعه</span>
            </div>
          </div>
        </div>
      </div>
    `;
    // animate bars
    const bars = container.querySelector('#chartBars');
    if (bars) {
      const vals = [68, 92, 74, 110, 88, 124, 96];
      bars.innerHTML = vals.map(v => `<div class="bar" style="height:${v}px"></div>`).join('');
      requestAnimationFrame(() => {
        bars.querySelectorAll('.bar').forEach((b,i) => {
          b.style.height = '20px';
          setTimeout(()=> b.style.height = vals[i]+'px', 80 + i*70);
        });
      });
    }
    container.querySelectorAll('[data-action]').forEach(btn=>{
      btn.addEventListener('click', ()=> window.ALOOKHOR.toast('این اکشن در نسخه بعدی به API وصل می‌شود','info'));
    });
  },
  destroy(){}
};
