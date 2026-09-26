export const usersModule = {
  meta:{id:'users', title:'کاربران VIP'},
  init(container){
    container.innerHTML = `
      <div class="page-head"><div><h2>مشتریان VIP</h2><p>۸۹۲ مشتری — باشگاه طلایی ALOOKHOR</p></div><div class="head-actions"><button class="btn-ghost">خروجی</button><button class="btn-gold">+ مشتری جدید</button></div></div>
      <div class="kpi-grid">
        <div class="kpi-card"><div class="kpi-value" style="font-size:22px">۱۴</div><div class="kpi-label">VIP جدید هفته</div></div>
        <div class="kpi-card"><div class="kpi-value" style="font-size:22px">۳۲</div><div class="kpi-label">سفارش در انتظار</div></div>
        <div class="kpi-card"><div class="kpi-value" style="font-size:22px">۹۸.۲٪</div><div class="kpi-label">رضایت</div></div>
        <div class="kpi-card"><div class="kpi-value" style="font-size:22px">۴.۹/۵</div><div class="kpi-label">امتیاز بوتیک</div></div>
      </div>
      <div class="panel" style="margin-top:14px"><div class="panel-head"><h3>VIP های برتر</h3></div>
        <div class="table-wrap"><table><thead><tr><th>مشتری</th><th>سطح</th><th>خرید کل</th><th>آخرین سفارش</th></tr></thead>
        <tbody>
          <tr><td><b>سارا احمدی</b></td><td><span class="status status-ok"><span class="status-dot"></span> Gold</span></td><td>۱.۲B</td><td>۱۰ اوت</td></tr>
          <tr><td><b>نگار کریمی</b></td><td><span class="status status-warn"><span class="status-dot"></span> Platinum</span></td><td>۲.۸B</td><td>۹ اوت</td></tr>
        </tbody></table></div>
      </div>`;
  }, destroy(){}
};
