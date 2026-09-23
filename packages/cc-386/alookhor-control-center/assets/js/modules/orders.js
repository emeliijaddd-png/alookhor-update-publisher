export const ordersModule = {
  meta:{id:'orders', title:'سفارشات'},
  init(container){
    container.innerHTML = `
      <div class="page-head"><div><h2>سفارشات</h2><p>مدیریت سفارشات VIP با تایم‌لاین لوکس</p></div><div class="head-actions"><button class="btn-gold">+ سفارش VIP</button></div></div>
      <div class="panel"><div class="panel-head"><h3>همه سفارشات</h3><span style="font-size:12px;color:var(--text-faint)">۱۴۷ فعال</span></div>
        <div class="table-wrap"><table><thead><tr><th>کد</th><th>مشتری</th><th>قطعه</th><th>مبلغ</th><th>وضعیت</th></tr></thead>
        <tbody>
          <tr><td>#AL-9841</td><td>سارا احمدی</td><td>گردنبند الماس ۱۸عیار</td><td>۱۸۴M</td><td><span class="status status-ok"><span class="status-dot"></span> تحویل</span></td></tr>
          <tr><td>#AL-9840</td><td>امیر حسینی</td><td>انگشتر فیروزه</td><td>۹۲.۵M</td><td><span class="status status-warn"><span class="status-dot"></span> در ساخت</span></td></tr>
          <tr><td>#AL-9839</td><td>نگار کریمی</td><td>دستبند طلا ۲۴عیار</td><td>۲۱۰M</td><td><span class="status status-warn"><span class="status-dot"></span> انتظار</span></td></tr>
        </tbody></table></div>
        <div class="card-list">
          <div class="mini-card"><div class="mini-card-top"><div><h4>#AL-9841</h4><p>سارا احمدی — گردنبند الماس</p></div><span class="status status-ok"><span class="status-dot"></span> تحویل</span></div><div class="mini-meta"><span>۱۸۴M</span></div></div>
          <div class="mini-card"><div class="mini-card-top"><div><h4>#AL-9840</h4><p>امیر حسینی — انگشتر فیروزه</p></div><span class="status status-warn"><span class="status-dot"></span> در ساخت</span></div><div class="mini-meta"><span>۹۲.۵M</span></div></div>
        </div>
      </div>`;
  }, destroy(){}
};
