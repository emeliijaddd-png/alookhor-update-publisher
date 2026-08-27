<?php if (!defined('ABSPATH')) exit; ?>
<div id="alookhor-cc-root" style="background:#070708; min-height:calc(100vh - 60px); padding:0; margin:0">
<!-- Header — Luxury Glass | Rendered by Shortcode [alookhor_portal_header] — المنتور -->
  <header class="lux-header" title="Shortcode: [alookhor_portal_header]">
    <div class="lux-header-inner">
      <button class="icon-btn hamburger" id="hamburger" aria-label="منو">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 7h16"/><path d="M4 12h16"/><path d="M4 17h16"/></svg>
      </button>

      <a class="brand" href="#settings" data-module="settings">
        <div class="brand-mark"><span>A</span></div>
        <div class="brand-text">
          <h1>ALOOKHOR</h1>
          <p>Control Center • Luxury</p>
        </div>
      </a>

      <div class="header-center">
        <label class="search-pill">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9A9590" stroke-width="1.7"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
          <input placeholder="جستجو در سفارشات، مشتریان، قطعات..." />
          <span style="font-size:11px; color:var(--text-faint); background:rgba(255,255,255,0.06); padding:3px 7px; border-radius:999px; border:1px solid var(--gold-border)">⌘ K</span>
        </label>
      </div>

      <div class="header-actions">
        <div class="version-badge" title="نسخه فعلی">
          <span style="width:6px; height:6px; border-radius:50%; background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.15); display:inline-block"></span>
          <span id="headerVersion">v3.10.133</span>
          <span style="opacity:0.5">•</span>
          <span id="bpIndicator" style="font-family:monospace; font-size:11px">—</span>
        </div>

        <button class="icon-btn" id="btnUpdateCenter" title="Update Center — سیستم آپدیت داخلی" style="width:auto; padding:0 12px; gap:8px; border-radius:999px">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M21 12a9 9 0 1 1-9-9"/><path d="M21 12v-6h-6"/><path d="M12 7v5l4 2"/></svg>
          <span style="font-size:12px; font-weight:700; letter-spacing:0.04em">Update</span>
          <span id="updateBadge" style="display:none; background:var(--gold); color:#1A1206; font-size:10px; font-weight:800; padding:2px 7px; border-radius:999px; letter-spacing:0.06em">جدید</span>
          <span class="pulse-dot" style="top:4px; right:4px; width:7px; height:7px; display:none" id="pulseDot"></span>
        </button>

        <button class="icon-btn" title="اعلان‌ها">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 8a6 6 0 0 1 12 0c0 7-6 9-6 9s-6-2-6-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
        </button>
        <button class="icon-btn gold" title="پروفایل">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        </button>
      </div>
    </div>
  </header>

  <div class="backdrop" id="backdrop"></div>
  <div class="backdrop" id="modalBackdrop" style="z-index:55"></div>

  <!-- Shell -->
  <div class="shell">
    <!-- Sidebar — PRO Luxury Modular Navigation (حرفه‌ای، دسته‌بندی شده، بدون لیست طولانی) -->
    <aside class="sidebar" id="sidebar">
      <!-- جستجوی داخل منو -->
      <label class="sidebar-search">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#9A9590" stroke-width="1.8"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
        <input id="menuSearch" placeholder="جستجو در منو..." />
        <kbd>/</kbd>
      </label>

      <!-- مدیریت بوتیک — فضای اصلی و اولویت اول -->
      <div class="nav-item single nav-item-primary" data-module="settings">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 10h16v10H4z"/><path d="M3 10l2-6h14l2 6"/><path d="M8 20v-6h4v6"/><path d="M3 10c0 1.7 2.2 2.6 3.5 1.4C7.7 12.6 10 11.7 10 10c0 1.7 2.3 2.6 3.5 1.4C14.8 12.6 17 11.7 17 10c0 1.7 2.2 2.6 3.5 1.4"/></svg>
        مدیریت بوتیک
        <span class="badge">اصلی</span>
      </div>

      <!-- داشبورد — پایش و سلامت سیستم -->
      <div class="nav-item single active" data-module="dashboard">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/></svg>
        داشبورد
        <span class="badge">زنده</span>
      </div>

      <nav id="proNav" style="display:grid; gap:4px; margin-top:4px">

        <!-- گروه: فروش — بخش کم‌اولویت/آزمایشی -->
        <div class="nav-group" data-group="sales">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M6 2h9l5 5v15H6z"/><path d="M15 2v6h6"/><path d="M9 13h6"/><path d="M9 17h6"/></svg>
            </div>
            <span class="nav-group-title">مدیریت فروش</span>
            <span class="nav-group-count">4</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item active" data-module="orders"><span class="sub-dot"></span> سفارشات <span class="sub-badge">۱۴۷</span></div>
              <div class="nav-sub-item" data-module="invoices"><span class="sub-dot"></span> فاکتورها</div>
              <div class="nav-sub-item" data-module="quotes"><span class="sub-dot"></span> پیش‌فاکتورها <span class="sub-badge" style="background:rgba(61,214,140,0.14); color:#3DD68C">جدید</span></div>
              <div class="nav-sub-item" data-module="returns"><span class="sub-dot"></span> مرجوعی‌ها</div>
            </div>
          </div></div>
        </div>

        <!-- گروه: ویترین و انبار -->
        <div class="nav-group" data-group="catalog">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 2l9 4.5v9L12 20 3 15.5v-9L12 2z"/><path d="M12 12l9-4.5"/><path d="M12 12v8"/><path d="M3 7.5l9 4.5"/></svg>
            </div>
            <span class="nav-group-title">ویترین و انبار</span>
            <span class="nav-group-count">4</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item" data-module="products"><span class="sub-dot"></span> محصولات</div>
              <div class="nav-sub-item" data-module="categories"><span class="sub-dot"></span> دسته‌بندی‌ها</div>
              <div class="nav-sub-item" data-module="inventory"><span class="sub-dot"></span> موجودی و انبار <span class="sub-badge">۱,۲۸۴</span></div>
              <div class="nav-sub-item" data-module="collections"><span class="sub-dot"></span> کالکشن‌های لوکس</div>
            </div>
          </div></div>
        </div>

        <!-- گروه: مشتریان -->
        <div class="nav-group" data-group="customers">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <span class="nav-group-title">مشتریان و باشگاه</span>
            <span class="nav-group-count">4</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item" data-module="users"><span class="sub-dot"></span> مشتریان VIP <span class="sub-badge">۸۹۲</span></div>
              <div class="nav-sub-item" data-module="club"><span class="sub-dot"></span> باشگاه طلایی</div>
              <div class="nav-sub-item" data-module="tickets"><span class="sub-dot"></span> تیکت و پشتیبانی <span class="sub-badge">۶</span></div>
              <div class="nav-sub-item" data-module="reviews"><span class="sub-dot"></span> نظرات و امتیاز</div>
            </div>
          </div></div>
        </div>

        <!-- گروه: مالی -->
        <div class="nav-group" data-group="finance">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="12" cy="8" r="6"/><path d="M15.5 12.5l-3 3-3-3"/><path d="M12 12.5V20"/><path d="M5 20h14"/></svg>
            </div>
            <span class="nav-group-title">مالی و طلا</span>
            <span class="nav-group-count">3</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item" data-module="transactions"><span class="sub-dot"></span> تراکنش‌ها</div>
              <div class="nav-sub-item" data-module="gold-price"><span class="sub-dot"></span> قیمت لحظه‌ای طلا <span class="sub-badge" style="background:rgba(61,214,140,0.14); color:#3DD68C">Live</span></div>
              <div class="nav-sub-item" data-module="accounting"><span class="sub-dot"></span> حسابداری</div>
            </div>
          </div></div>
        </div>

        <!-- گروه: تحلیل -->
        <div class="nav-group" data-group="analytics">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 3v18h18"/><path d="M7 16l4-4 4 4 4-6"/></svg>
            </div>
            <span class="nav-group-title">تحلیل و گزارش</span>
            <span class="nav-group-count">3</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item" data-module="analytics"><span class="sub-dot"></span> آنالیتیکس</div>
              <div class="nav-sub-item" data-module="sales-report"><span class="sub-dot"></span> گزارش فروش</div>
              <div class="nav-sub-item" data-module="stock-report"><span class="sub-dot"></span> گزارش انبار</div>
            </div>
          </div></div>
        </div>

        <!-- گروه: سیستم -->
        <div class="nav-group" data-group="system">
          <div class="nav-group-head">
            <div class="nav-group-icon">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/></svg>
            </div>
            <span class="nav-group-title">سیستم</span>
            <span class="nav-group-count">3</span>
            <span class="nav-chevron"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 9l6 6 6-6"/></svg></span>
          </div>
          <div class="nav-group-body"><div class="nav-group-inner">
            <div class="nav-sub-list">
              <div class="nav-sub-item" data-module="roles"><span class="sub-dot"></span> کاربران و دسترسی</div>
              <div class="nav-sub-item" data-module="update"><span class="sub-dot"></span> Update Center <span style="width:7px; height:7px; border-radius:50%; background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.18); margin-right:auto"></span></div>
              <div class="nav-sub-item" data-module="logs"><span class="sub-dot"></span> لاگ‌ها</div>
            </div>
          </div></div>
        </div>

      </nav>

      <div class="nav-divider"></div>

      <div style="padding:12px; background: linear-gradient(135deg, rgba(201,168,106,0.13), rgba(201,168,106,0.04)); border:1px solid var(--gold-border-strong); border-radius:16px">
        <div style="display:flex; align-items:center; gap:8px">
          <div style="width:8px; height:8px; border-radius:50%; background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.15)"></div>
          <div style="font-size:12px; font-weight:700; letter-spacing:0.05em; color:var(--gold-soft)">وضعیت کنترل سنتر</div>
          <span style="margin-right:auto; font-size:10px; background:var(--gold); color:#1A1206; font-weight:800; padding:2px 7px; border-radius:999px">PRO</span>
        </div>
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-top:10px">
          <div style="background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); border-radius:10px; padding:8px; text-align:center"><div style="font-size:11px; color:var(--text-faint)">نسخه</div><b id="versionBadgeText" style="font-family:monospace; font-size:12px; color:var(--text-primary)">v3.10.133</b></div>
          <div style="background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); border-radius:10px; padding:8px; text-align:center"><div style="font-size:11px; color:var(--text-faint)">ماژول</div><b style="font-size:12px; color:var(--gold-soft)">۱۹ فعال</b></div>
        </div>
        <div style="height:6px; background:rgba(255,255,255,0.06); border-radius:999px; overflow:hidden; margin-top:10px"><div style="width:100%; height:100%; background:linear-gradient(90deg,#C9A86A,#E8D5B5)"></div></div>
        <div style="font-size:10.5px; color:var(--text-faint); margin-top:6px; text-align:center; line-height:1.5">منو فشرده و حرفه‌ای — بدون اسکرول طولانی</div>
      </div>

      <div style="margin-top:10px; padding:10px 11px; background:rgba(255,255,255,0.02); border:1px solid var(--gold-border); border-radius:12px; display:flex; gap:10px; align-items:center">
        <div style="width:30px; height:30px; border-radius:999px; background:linear-gradient(135deg,#C9A86A,#E8D5B5); display:grid; place-items:center; color:#1A1206; font-weight:800; font-size:12px">A</div>
        <div style="line-height:1.2"><div style="font-size:12.5px; font-weight:700">بوتیک ALOOKHOR</div><div style="font-size:11px; color:var(--text-muted)">ادمین ارشد • آنلاین</div></div>
        <div style="margin-right:auto; width:8px; height:8px; border-radius:50%; background:#3DD68C"></div>
      </div>
    </aside>

    <!-- Main — Module Container -->
    <main class="main">

      <div id="moduleContainer" style="min-height:420px; transition: all 0.28s ease">
        <!-- Fallback PHP Rendered Dashboard — اگر JS لود نشد، این نمایش داده می‌شود -->
        <div class="page-head">
          <div>
            <h2>داشبورد لوکس — نمای کلی</h2>
            <p>آخرین به‌روزرسانی: همین حالا • مانیتورینگ زنده بوتیک ALOOKHOR — <span style="background:rgba(61,214,140,0.12); color:#3DD68C; padding:2px 8px; border-radius:999px; font-size:11px; border:1px solid rgba(61,214,140,0.18)">● JS Fallback Active</span></p>
          </div>
          <div class="head-actions">
            <button class="btn-ghost" onclick="alert('خروجی Excel در آپدیت بعدی')">خروجی Excel</button>
            <button class="btn-gold" onclick="alert('سفارش جدید — به زودی')">+ سفارش جدید</button>
          </div>
        </div>
        <div class="kpi-grid">
          <div class="kpi-card">
            <div class="kpi-top"><div class="kpi-icon" style="color:#C9A86A">●</div><span class="kpi-trend trend-up">▲ 12.4%</span></div>
            <div class="kpi-value">۲.۴B <span style="font-size:14px; color:#9A9590; font-family:Inter">تومان</span></div>
            <div class="kpi-label">فروش امروز</div>
            <div class="kpi-foot">نسبت به دیروز +۱۲.۴٪ — ۳ سفارش VIP</div>
          </div>
          <div class="kpi-card">
            <div class="kpi-top"><div class="kpi-icon">◆</div><span class="kpi-trend trend-up">▲ 8.1%</span></div>
            <div class="kpi-value">۱۴۷</div>
            <div class="kpi-label">سفارشات فعال</div>
            <div class="kpi-foot">۳۲ در انتظار تایید طلا</div>
          </div>
          <div class="kpi-card">
            <div class="kpi-top"><div class="kpi-icon">▦</div><span class="kpi-trend trend-down">▼ 2.3%</span></div>
            <div class="kpi-value">۱,۲۸۴</div>
            <div class="kpi-label">موجودی انبار</div>
            <div class="kpi-foot">۱۸ قلم کمتر از حد لوکس</div>
          </div>
          <div class="kpi-card">
            <div class="kpi-top"><div class="kpi-icon">👑</div><span class="kpi-trend trend-up">▲ 4.7%</span></div>
            <div class="kpi-value">۸۹۲</div>
            <div class="kpi-label">مشتریان VIP</div>
            <div class="kpi-foot">۱۴ مشتری جدید این هفته</div>
          </div>
        </div>
        <div style="margin-top:14px; background:rgba(201,168,106,0.08); border:1px solid rgba(201,168,106,0.14); border-radius:12px; padding:12px; font-size:12.5px; color:#E8D5B5; line-height:1.7">
          <b>✓ افزونه نصب شد</b> — اگر این داشبورد را می‌بینی، یعنی هسته لود شده. از بالای سایدبار روی <b>مدیریت بوتیک</b> بزن تا فضای وسیع تنظیمات ماژول‌ها باز شود؛ دستیار هوشمند و سلامت سیستم فقط در داشبورد نمایش داده می‌شوند. اگر باز هم خالی بود، کش مرورگر را با <b>Ctrl+Shift+R</b> پاک کن.
        </div>
        <div class="two-col">
          <div class="panel">
            <div class="panel-head"><h3>سفارشات اخیر</h3><span style="font-size:11px; color:#6B6763">زنده</span></div>
            <div style="padding:12px">
              <div style="display:grid; gap:8px">
                <div style="display:flex; justify-content:space-between; background:rgba(255,255,255,0.03); border:1px solid rgba(201,168,106,0.08); padding:10px; border-radius:10px; font-size:12px"><span>#AL-9841 — سارا احمدی — VIP Gold — ۱۸۴M</span><span style="color:#3DD68C; font-weight:700">● تحویل</span></div>
                <div style="display:flex; justify-content:space-between; background:rgba(255,255,255,0.03); border:1px solid rgba(201,168,106,0.08); padding:10px; border-radius:10px; font-size:12px"><span>#AL-9840 — امیر حسینی — ۹۲.۵M</span><span style="color:#C9A86A">● در ساخت</span></div>
              </div>
            </div>
          </div>
          <div class="panel"><div class="panel-head"><h3>فروش ۷ روز اخیر</h3></div><div style="padding:18px"><div style="height:120px; background:linear-gradient(180deg, rgba(201,168,106,0.06), transparent); border:1px solid rgba(201,168,106,0.14); border-radius:12px; display:flex; align-items:end; gap:8px; padding:12px; justify-content:center"><div style="width:18px; height:60px; background:linear-gradient(180deg,#E8D5B5,#C9A86A); border-radius:6px"></div><div style="width:18px; height:85px; background:linear-gradient(180deg,#E8D5B5,#C9A86A); border-radius:6px"></div><div style="width:18px; height:70px; background:linear-gradient(180deg,#E8D5B5,#C9A86A); border-radius:6px"></div><div style="width:18px; height:105px; background:linear-gradient(180deg,#E8D5B5,#C9A86A); border-radius:6px"></div></div></div></div>
        </div>
      </div>


      <!-- Footer luxury -->
      <div style="margin-top:18px; padding:14px 16px; display:flex; flex-wrap:wrap; gap:10px; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.02); border:1px solid var(--gold-border); border-radius:14px; font-size:12px; color:var(--text-muted)">
        <span>© 2026 ALOOKHOR — Control Center v3.10.133 • <span id="pageTitle" style="color:var(--gold-soft); font-weight:700">داشبورد</span> • معماری ماژولار حفظ شد</span>
        <span style="display:flex; gap:8px; align-items:center">
          <span style="width:7px; height:7px; border-radius:50%; background:#3DD68C; display:inline-block"></span> سیستم پایدار
          <span style="opacity:0.4">|</span> <a href="<?php echo esc_url(ALOOKHOR_CC_URL . 'docs/PROJECT_MEMORY.md'); ?>" target="_blank" rel="noopener" style="color:var(--gold-soft); text-decoration:underline; text-underline-offset:3px">حافظه پروژه</a>
        </span>
      </div>
    </main>
  </div>

  <!-- Update Center Modal — Luxury -->
  <div class="modal" id="updateModal" aria-hidden="true">
    <div class="modal-card">
      <div class="modal-head">
        <div style="display:flex; align-items:center; gap:12px">
          <div style="width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,#C9A86A,#E8D5B5); display:grid; place-items:center; color:#1A1206">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 12a9 9 0 1 1-9-9"/><path d="M21 12v-6h-6"/></svg>
          </div>
          <div>
            <h3>Update Center</h3>
            <div style="font-size:12px; color:var(--text-muted); margin-top:2px" id="modalVersion">v3.10.133 — به‌روز</div>
          </div>
        </div>
        <button class="icon-btn" id="btnCloseModal" style="width:34px; height:34px">✕</button>
      </div>
      <div class="modal-body">
        <div id="updateStatusBox" style="display:flex; gap:10px; align-items:center; padding:10px 12px; background:rgba(61,214,140,0.08); border:1px solid rgba(61,214,140,0.18); border-radius:12px; margin-bottom:14px">
          <span style="width:8px; height:8px; border-radius:50%; background:#3DD68C; box-shadow:0 0 0 6px rgba(61,214,140,0.12)"></span>
          <span id="updateStatusText" style="font-size:13px; font-weight:600">در حال بررسی سیستم آپدیت داخلی...</span>
          <span id="updateStatusMode" style="margin-left:auto; font-size:11px; color:var(--text-faint); font-family:monospace">WP Native</span>
        </div>
        <div class="timeline" id="changelog">
          <!-- injected by JS -->
        </div>
        <div style="display:flex; gap:10px; margin-top:18px">
          <button class="btn-gold" id="btnInstall" style="flex:1">نصب آنی — بدون رفرش</button>
          <button class="btn-ghost" id="btnDismiss">بعداً</button>
        </div>
        <div style="text-align:center; margin-top:10px; font-size:11px; color:var(--text-faint)">نسخه‌ها SemVer هستند • Rollback خودکار در صورت خطا</div>
      </div>
    </div>
  </div>

  <div class="toast-stack" id="toastStack"></div>

  <script>window.ALOOKHOR_CC = window.ALOOKHOR_CC || {
    ajax_url: "<?php echo esc_js(admin_url('admin-ajax.php')); ?>",
    nonce: "<?php echo esc_js(wp_create_nonce('alookhor_cc_nonce')); ?>",
    site_json_url: "<?php echo esc_js(ALOOKHOR_CC_URL . 'config/site.json'); ?>",
    version: "<?php echo esc_js(ALOOKHOR_CC_VERSION); ?>",
    plugin_file: "<?php echo esc_js(ALOOKHOR_CC_PLUGIN_BASENAME); ?>",
    plugin_slug: "alookhor-control-center",
    native_update_url: "<?php echo esc_js(wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=' . rawurlencode(ALOOKHOR_CC_PLUGIN_BASENAME)), 'upgrade-plugin_' . ALOOKHOR_CC_PLUGIN_BASENAME)); ?>",
    updater_configured: <?php echo alookhor_cc_update_manifest_url() ? 'true' : 'false'; ?>,
    header_shortcode: "[alookhor_portal_header]"
  };</script>
  
<script>
// Fallback JS — اگر ES Modules لود نشد، سایدبار و تنظیمات همچنان کار کند (بدون نیاز به import)
(function(){
  // اگر بعد از 1.5 ثانیه هنوز ALOOKHOR.switchModule تعریف نشده، fallback را فعال کن
  setTimeout(function(){
    if(window.ALOOKHOR && window.ALOOKHOR.switchModule) return;
    console.warn('ALOOKHOR modules not loaded — activating fallback');
    // ساده: کلیک روی هر آیتم منو، پیام بده
    document.querySelectorAll('[data-module]').forEach(function(el){
      el.addEventListener('click', function(){
        var mod = el.getAttribute('data-module');
        if(mod==='settings'){
          // ماژول settings در assets/js/modules/settings.js پیاده‌سازی شده است.
          // (اگر روزی المان Fallback نیاز شد، id یکتا تعریف و dispatch کن.)
          alert('تنظیمات بوتیک — لطفاً کش را پاک کنید (Ctrl+Shift+R) یا افزونه را دوباره فعال کنید.');
        } else if(mod==='update'){
          var m = document.getElementById('updateModal');
          if(m) m.classList.add('show');
          document.getElementById('modalBackdrop')?.classList.add('show');
        } else {
          // برای سایر ماژول‌ها، فقط Toast ساده
          var stack = document.getElementById('toastStack');
          if(stack){
            var t=document.createElement('div'); t.className='toast'; t.innerHTML='<div class="toast-icon">◐</div><div style="flex:1"><div style="font-weight:700; font-size:13px">ماژول '+mod+' — در حال لود Fallback</div><div style="font-size:12px; color:#9A9590">ES Modules لود نشد، از نسخه PHP استفاده شد</div></div>';
            stack.appendChild(t); setTimeout(()=>t.remove(),3000);
          }
        }
        // active کلاس
        document.querySelectorAll('.nav-item, .nav-sub-item').forEach(n=>n.classList.remove('active'));
        el.classList.add('active');
      });
    });
    // آکاردئون سایدبار بدون JS ماژولار
    document.querySelectorAll('.nav-group-head').forEach(function(head){
      head.addEventListener('click', function(){
        var g=head.parentElement; g.classList.toggle('open');
      });
    });
    // نمایش پیام
    var c=document.getElementById('moduleContainer');
    if(c && !c.innerHTML.trim()){
      c.innerHTML='<div style="padding:40px; text-align:center; color:#9A9590">در حال لود Fallback...</div>';
    }
  }, 1500);
})();
</script>
  <script type="module" src="<?php echo esc_url(add_query_arg('ver', ALOOKHOR_CC_BUILD, ALOOKHOR_CC_URL . 'assets/js/app.js')); ?>"></script>
</div>
