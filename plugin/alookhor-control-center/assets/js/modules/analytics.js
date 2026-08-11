export const analyticsModule = {
  meta:{id:'analytics', title:'آنالیتیکس'},
  init(container){
    container.innerHTML = `
      <div class="page-head"><div><h2>آنالیتیکس طلایی</h2><p>تحلیل فروش و رفتار VIP</p></div><div class="head-actions"><button class="btn-ghost">بازه: ۳۰ روز</button></div></div>
      <div class="two-col">
        <div class="panel"><div class="panel-head"><h3>نمودار درآمد</h3></div><div class="chart-box"><div class="chart-canvas"><div class="chart-bars" id="aBars"></div></div></div></div>
        <div class="panel"><div class="panel-head"><h3>کانال فروش</h3></div><div style="padding:18px; display:grid; gap:12px">
          <div><div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:6px"><span>حضوری بوتیک</span><b>۶۲٪</b></div><div style="height:8px; background:rgba(255,255,255,0.06); border-radius:999px; overflow:hidden"><div style="width:62%; height:100%; background:linear-gradient(90deg,#C9A86A,#E8D5B5)"></div></div></div>
          <div><div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:6px"><span>آنلاین VIP</span><b>۲۸٪</b></div><div style="height:8px; background:rgba(255,255,255,0.06); border-radius:999px; overflow:hidden"><div style="width:28%; height:100%; background:rgba(201,168,106,0.5)"></div></div></div>
          <div><div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:6px"><span>معرف</span><b>۱۰٪</b></div><div style="height:8px; background:rgba(255,255,255,0.06); border-radius:999px; overflow:hidden"><div style="width:10%; height:100%; background:rgba(255,255,255,0.18)"></div></div></div>
        </div></div>
      </div>
    `;
    const bars = container.querySelector('#aBars');
    if(bars){
      const vals=[50,78,62,95,70,108,84];
      bars.innerHTML = vals.map(v=>`<div class="bar" style="height:${v}px"></div>`).join('');
    }
  }, destroy(){}
};
