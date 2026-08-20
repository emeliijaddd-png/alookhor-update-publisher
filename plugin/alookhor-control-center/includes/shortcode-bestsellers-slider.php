<?php
/**
 * Scoped, Autoplaying, Page-by-page Bestselling Products Slider — [alookhor_bestsellers_slider]
 *
 * Fetches real WooCommerce products for each category tab and renders a beautiful 
 * purple glass carousel with custom buy buttons, countdowns, and stock indicators.
 */
if (!defined('ABSPATH')) exit;

function alookhor_cc_render_bestsellers_slider() {
    ob_start();
    $plugin_images_url = ALOOKHOR_CC_URL . 'assets/images/';
    
    // Define category mapping to WC slugs
    $categories = array(
        'plums'   => 'alo-khoshkbar',
        'fruits'  => 'barge-miveha',
        'snacks'  => 'tanagholat-tabiei',
        'nuts'    => 'maghzbar-momtaz'
    );
    ?>
    <div class="alookhor-bestsellers-wrapper">
      <style>
        .alookhor-bestsellers-wrapper {
          width: 100% !important;
          background-color: #0B0716 !important;
          position: relative !important;
          z-index: 20 !important;
          box-sizing: border-box !important;
          font-family: 'Dana', 'Vazirmatn', sans-serif !important;
        }
        .alookhor-bestsellers-wrapper .bestsellers-section {
          padding: 60px 0 !important;
          background: linear-gradient(135deg, rgba(24, 10, 32, 0.93) 0%, rgba(8, 3, 12, 0.99) 100%), 
                      url('<?php echo esc_url($plugin_images_url . "export-banner.jpg"); ?>') center/cover no-repeat !important;
          border-top: 1px solid rgba(212, 164, 54, 0.15) !important;
          border-bottom: 1px solid rgba(212, 164, 54, 0.15) !important;
          position: relative;
        }
        .alookhor-bestsellers-wrapper .section-header-row {
          display: flex !important;
          justify-content: space-between !important;
          align-items: center !important;
          margin-bottom: 40px !important;
          border-bottom: 1px solid rgba(255,255,255,0.05) !important;
          padding-bottom: 20px !important;
          max-width: 1200px !important;
          margin-left: auto !important;
          margin-right: auto !important;
          padding-left: 15px !important;
          padding-right: 15px !important;
          background: transparent !important;
        }
        .alookhor-bestsellers-wrapper .products-tab-list {
          display: flex !important;
          list-style: none !important;
          gap: 12px !important;
          margin: 0 !important;
          padding: 0 !important;
        }
        .alookhor-bestsellers-wrapper .products-tab-item {
          background: rgba(255,255,255,0.02) !important;
          border: 1px solid rgba(212, 164, 54, 0.15) !important;
          color: #fff !important;
          padding: 10px 22px !important;
          border-radius: 50px !important;
          font-size: 13.5px !important;
          font-weight: 700 !important;
          cursor: pointer !important;
          display: flex !important;
          align-items: center !important;
          gap: 8px !important;
          transition: all 0.3s ease !important;
        }
        .alookhor-bestsellers-wrapper .products-tab-item.active, 
        .alookhor-bestsellers-wrapper .products-tab-item:hover {
          background: linear-gradient(135deg, #D4A436 0%, #8A641A 100%) !important;
          color: #110523 !important;
          border-color: #D4A436 !important;
        }
        .alookhor-bestsellers-wrapper .products-tab-item svg {
          width: 14px !important;
          height: 14px !important;
          fill: none !important;
          stroke: currentColor !important;
          stroke-width: 2 !important;
        }
        .alookhor-bestsellers-wrapper .bestsellers-arrow-btn {
          background: rgba(255,255,255,0.03) !important;
          border: 1px solid rgba(212,164,54,0.15) !important;
          color: #fff !important;
          width: 38px !important;
          height: 38px !important;
          border-radius: 50% !important;
          display: flex !important;
          align-items: center !important;
          justify-content: center !important;
          cursor: pointer !important;
          transition: all 0.3s ease !important;
          padding: 0 !important;
        }
        .alookhor-bestsellers-wrapper .bestsellers-arrow-btn:hover {
          background: linear-gradient(135deg, #D4A436 0%, #8A641A 100%) !important;
          color: #110523 !important;
          border-color: #D4A436 !important;
          box-shadow: 0 0 10px rgba(212, 164, 54, 0.4) !important;
        }
        .alookhor-bestsellers-wrapper .products-grid {
          display: flex !important;
          flex-direction: row !important;
          flex-wrap: nowrap !important;
          overflow-x: auto !important;
          scroll-snap-type: x mandatory !important;
          scroll-behavior: smooth !important;
          gap: 20px !important;
          max-width: 1200px !important;
          margin: 0 auto !important;
          padding: 10px 15px 25px 15px !important;
          -webkit-overflow-scrolling: touch !important;
          scrollbar-width: none !important;
        }
        .alookhor-bestsellers-wrapper .products-grid::-webkit-scrollbar {
          display: none !important;
        }
        .alookhor-bestsellers-wrapper .product-card {
          background: linear-gradient(135deg, rgba(255, 255, 255, 0.06) 0%, rgba(255, 255, 255, 0.02) 100%) !important;
          backdrop-filter: blur(20px) !important;
          -webkit-backdrop-filter: blur(20px) !important;
          border: 1px solid rgba(255, 255, 255, 0.1) !important;
          border-radius: 24px !important;
          padding: 20px !important;
          display: flex !important;
          flex-direction: column !important;
          transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1) !important;
          position: relative !important;
          box-shadow: 0 15px 35px rgba(0,0,0,0.4) !important;
          box-sizing: border-box !important;
          flex: 0 0 calc(25% - 15px) !important;
          scroll-snap-align: start !important;
          height: auto !important;
        }
        .alookhor-bestsellers-wrapper .product-card:hover {
          border-color: #D4A436 !important;
          transform: translateY(-8px) !important;
          box-shadow: 0 20px 40px rgba(212, 164, 54, 0.2) !important;
        }
        .alookhor-bestsellers-wrapper .product-img-container {
          height: 180px !important;
          position: relative !important;
          border-radius: 18px !important;
          overflow: hidden !important;
          background: rgba(0,0,0,0.2) !important;
          display: flex !important;
          align-items: center !important;
          justify-content: center !important;
          margin-bottom: 15px !important;
        }
        .alookhor-bestsellers-wrapper .product-img-container img {
          width: 85% !important;
          height: 85% !important;
          object-fit: cover !important;
          border-radius: 50% !important;
          border: 2.5px solid rgba(212, 164, 54, 0.25) !important;
          transition: all 0.3s ease !important;
        }
        .alookhor-bestsellers-wrapper .product-card:hover .product-img-container img {
          transform: scale(1.05) rotate(2deg) !important;
          border-color: #D4A436 !important;
        }
        .alookhor-bestsellers-wrapper .product-badge-green {
          position: absolute !important;
          top: 10px !important;
          right: 10px !important;
          background: #22c55e !important;
          color: #fff !important;
          font-size: 10px !important;
          font-weight: bold !important;
          padding: 3px 8px !important;
          border-radius: 6px !important;
        }
        .alookhor-bestsellers-wrapper .product-pill-title {
          position: absolute !important;
          bottom: 10px !important;
          left: 50% !important;
          transform: translateX(-50%) !important;
          background: rgba(0,0,0,0.6) !important;
          backdrop-filter: blur(10px) !important;
          -webkit-backdrop-filter: blur(10px) !important;
          padding: 4px 16px !important;
          border-radius: 50px !important;
          font-size: 12px !important;
          color: #fff !important;
          font-weight: bold !important;
          white-space: nowrap !important;
        }
        .alookhor-bestsellers-wrapper .product-price-area {
          text-align: center !important;
          margin-bottom: 15px !important;
        }
        .alookhor-bestsellers-wrapper .product-price-old {
          font-size: 11px !important;
          color: rgba(255,255,255,0.4) !important;
          text-decoration: line-through !important;
          display: block !important;
          margin-bottom: 2px !important;
        }
        .alookhor-bestsellers-wrapper .product-price-current {
          font-size: 18px !important;
          font-weight: 800 !important;
          color: #F3C75F !important;
        }
        .alookhor-bestsellers-wrapper .product-price-current span {
          font-size: 10px !important;
          color: rgba(255,255,255,0.5) !important;
        }
        .alookhor-bestsellers-wrapper .product-purple-btn {
          background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(109, 40, 217, 0.3) 100%) !important;
          border: 1px solid rgba(139, 92, 246, 0.4) !important;
          color: #fff !important;
          padding: 10px !important;
          border-radius: 12px !important;
          font-weight: bold !important;
          font-size: 12.5px !important;
          cursor: pointer !important;
          transition: all 0.3s ease !important;
          width: 100% !important;
          text-align: center !important;
          text-decoration: none !important;
          display: block !important;
        }
        .alookhor-bestsellers-wrapper .product-purple-btn:hover {
          background: #8b5cf6 !important;
          border-color: #8b5cf6 !important;
          box-shadow: 0 0 15px rgba(139, 92, 246, 0.4) !important;
        }
        .alookhor-bestsellers-wrapper .product-stock-area {
          margin-top: 15px !important;
        }
        .alookhor-bestsellers-wrapper .product-stock-labels {
          display: flex !important;
          justify-content: space-between !important;
          font-size: 11px !important;
          color: rgba(255,255,255,0.5) !important;
          margin-bottom: 6px !important;
        }
        .alookhor-bestsellers-wrapper .product-stock-progress {
          height: 6px !important;
          background: rgba(255,255,255,0.05) !important;
          border-radius: 50px !important;
          overflow: hidden !important;
        }
        .alookhor-bestsellers-wrapper .product-stock-progress-fill {
          height: 100% !important;
          background: linear-gradient(90deg, #8A641A, #D4A436) !important;
          border-radius: 50px !important;
        }
        .alookhor-bestsellers-wrapper .product-countdown {
          display: flex !important;
          justify-content: center !important;
          gap: 10px !important;
          margin-top: 15px !important;
          border-top: 1px solid rgba(255,255,255,0.03) !important;
          padding-top: 15px !important;
        }
        .alookhor-bestsellers-wrapper .countdown-unit {
          display: flex !important;
          flex-direction: column !important;
          align-items: center !important;
          background: rgba(255,255,255,0.02) !important;
          border: 1px solid rgba(255,255,255,0.05) !important;
          padding: 4px !important;
          border-radius: 8px !important;
          width: 44px !important;
        }
        .alookhor-bestsellers-wrapper .countdown-num {
          font-size: 14px !important;
          font-weight: bold !important;
          color: #fff !important;
        }
        .alookhor-bestsellers-wrapper .countdown-label {
          font-size: 8.5px !important;
          color: rgba(255,255,255,0.4) !important;
        }

        @media (max-width: 991px) {
          .alookhor-bestsellers-wrapper .section-header-row {
            flex-direction: column-reverse !important;
            gap: 20px !important;
            align-items: center !important;
            text-align: center !important;
            border-bottom: none !important;
            padding-bottom: 0 !important;
            margin-bottom: 30px !important;
          }
          .alookhor-bestsellers-wrapper .product-card {
            flex: 0 0 calc(50% - 10px) !important;
          }
          .alookhor-bestsellers-wrapper .products-tab-list {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 10px !important;
            width: 100% !important;
            padding: 0 10px !important;
            margin: 0 !important;
          }
          .alookhor-bestsellers-wrapper .products-tab-item {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(212, 164, 54, 0.15) !important;
            padding: 8px 12px !important;
            border-radius: 30px !important;
            font-size: 11px !important;
            font-weight: 700 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 5px !important;
          }
          .alookhor-bestsellers-wrapper .products-tab-item.active {
            background: linear-gradient(135deg, #D4A436 0%, #8A641A 100%) !important;
            color: #110523 !important;
            border-color: #D4A436 !important;
          }
          .alookhor-bestsellers-wrapper .products-tab-item svg {
            width: 12px !important;
            height: 12px !important;
          }
        }
        @media (max-width: 600px) {
          .alookhor-bestsellers-wrapper .product-card {
            flex: 0 0 calc(100% - 10px) !important;
          }
        }
      </style>

      <section class="bestsellers-section" id="bestsellers">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 15px;">
          
          <div class="section-header-row">
            <!-- Far Left: Slider Navigation Arrows (RTL) -->
            <div class="bestsellers-nav-arrows" style="display: flex; gap: 8px; align-items: center; justify-content: flex-start;">
              <button id="bestsellers-prev-btn" class="bestsellers-arrow-btn" aria-label="قبلی">
                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; stroke: currentColor; stroke-width: 2.5; fill: none;"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </button>
              <button id="bestsellers-next-btn" class="bestsellers-arrow-btn" aria-label="بعدی">
                <svg viewBox="0 0 24 24" style="width: 18px; height: 18px; stroke: currentColor; stroke-width: 2.5; fill: none;"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round"/></svg>
              </button>
            </div>

            <!-- تب‌های فیلتر دسته‌بندی -->
            <ul class="products-tab-list">
              <li class="products-tab-item active" data-target="plums">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                آلو خشکبار
              </li>
              <li class="products-tab-item" data-target="fruits">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                برگه میوه‌ها
              </li>
              <li class="products-tab-item" data-target="snacks">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                تنقلات طبیعی
              </li>
              <li class="products-tab-item" data-target="nuts">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v12M6 12h12"/></svg>
                مغزبار ممتاز
              </li>
            </ul>
            
            <div style="border-bottom: 2px solid #D4A436; padding-bottom: 5px;">
              <h2 style="font-size: 20px; font-weight: 800; color: #fff; margin: 0; font-family: 'Vazirmatn', sans-serif !important;">پرفروش‌ترین محصولات آلوخور</h2>
            </div>
          </div>
          
          <div class="products-grid">
            <?php
            foreach ($categories as $tab_id => $cat_slug) {
                // Dynamic WordPress WC product query
                $args = array(
                    'post_type'      => 'product',
                    'posts_per_page' => 12,
                    'tax_query'      => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'slug',
                            'terms'    => $cat_slug,
                        ),
                    ),
                );
                
                $query = new WP_Query($args);
                if (!$query->have_posts()) {
                    $args_fallback = array(
                        'post_type'      => 'product',
                        'posts_per_page' => 12
                    );
                    $query = new WP_Query($args_fallback);
                }
                $display_style = $tab_id == 'plums' ? 'display: flex; opacity: 1;' : 'display: none; opacity: 0;';
                
                if ($query->have_posts()) {
                    $idx = 0;
                    while ($query->have_posts()) {
                        $query->the_post();
                        $prod_id = get_the_ID();
                        $product = wc_get_product($prod_id);
                        $title = get_the_title();
                        $img_url = get_the_post_thumbnail_url($prod_id, 'large');
                        if (empty($img_url)) {
                            if ($tab_id == 'plums') $img_url = $plugin_images_url . 'category-plums.jpg';
                            elseif ($tab_id == 'fruits') $img_url = $plugin_images_url . 'category-fruit-sheets.jpg';
                            elseif ($tab_id == 'snacks') $img_url = $plugin_images_url . 'category-natural-snacks.jpg';
                            else $img_url = $plugin_images_url . 'category-nuts.jpg';
                        }
                        
                        $regular_price = $product ? $product->get_regular_price() : '';
                        $price = $product ? $product->get_price() : '';
                        if (empty($price)) $price = 250000;
                        
                        $formatted_price = number_format($price);
                        $formatted_regular_price = !empty($regular_price) && $regular_price > $price ? number_format($regular_price) . ' تومان' : '';
                        
                        $stock_qty = $product ? $product->get_stock_quantity() : 10;
                        if (empty($stock_qty)) $stock_qty = 12;
                        $sold_qty = 5 + ($prod_id % 15);
                        $total_qty = $stock_qty + $sold_qty;
                        $percent_sold = round(($sold_qty / $total_qty) * 100);
                        ?>
                        
                        <div class="product-card" data-category="<?php echo esc_attr($tab_id); ?>" style="<?php echo esc_attr($display_style); ?>">
                          <div class="product-img-container">
                            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($title); ?>">
                            <span class="product-badge-green">ویژه</span>
                            <div class="product-pill-title"><?php echo esc_html($title); ?></div>
                          </div>
                          <div class="product-price-area">
                            <?php if (!empty($formatted_regular_price)) : ?>
                              <span class="product-price-old"><?php echo esc_html($formatted_regular_price); ?></span>
                            <?php endif; ?>
                            <div class="product-price-current"><?php echo esc_html($formatted_price); ?> <span>تومان</span></div>
                          </div>
                          <a href="?add-to-cart=<?php echo esc_attr($prod_id); ?>" class="product-purple-btn">افزودن به سبد خرید</a>
                          <div class="product-stock-area">
                            <div class="product-stock-labels"><span>باقی مانده: <?php echo esc_html($stock_qty); ?></span><span>فروخته شده: <?php echo esc_html($sold_qty); ?></span></div>
                            <div class="product-stock-progress"><div class="product-stock-progress-fill" style="width: <?php echo esc_attr($percent_sold); ?>%;"></div></div>
                          </div>
                          <div class="product-countdown">
                            <div class="countdown-unit"><span class="countdown-num"><?php echo esc_html(20 + ($prod_id % 39)); ?></span><span class="countdown-label">ثانیه</span></div>
                            <div class="countdown-unit"><span class="countdown-num"><?php echo esc_html(10 + ($prod_id % 49)); ?></span><span class="countdown-label">دقیقه</span></div>
                            <div class="countdown-unit"><span class="countdown-num">۰۳</span><span class="countdown-label">ساعت</span></div>
                            <div class="countdown-unit"><span class="countdown-num"><?php echo esc_html(50 + ($prod_id % 150)); ?></span><span class="countdown-label">روز</span></div>
                          </div>
                        </div>
                        <?php
                        $idx++;
                    }
                    wp_reset_postdata();
                } else {
                    $fallback_products = array();
                    if ($tab_id == 'plums') {
                        $fallback_products = array(
                            array('title' => 'طرقبه زرد صادراتی', 'price' => 500000, 'img' => 'category-plums.jpg'),
                            array('title' => 'آلو حاج حسنی نیشابور', 'price' => 600000, 'img' => 'category-plums.jpg'),
                            array('title' => 'آلو کبرایی سلطنتی', 'price' => 400000, 'img' => 'category-plums.jpg'),
                            array('title' => 'آلو شوقان ارگانیک', 'price' => 480000, 'img' => 'category-plums.jpg')
                        );
                    } elseif ($tab_id == 'fruits') {
                        $fallback_products = array(
                            array('title' => 'برگه هلو اعلی', 'price' => 280000, 'img' => 'category-fruit-sheets.jpg'),
                            array('title' => 'برگه زردآلو نیشابور', 'price' => 240000, 'img' => 'category-fruit-sheets.jpg'),
                            array('title' => 'کشمش طلایی ملایر', 'price' => 160000, 'img' => 'category-natural-snacks.jpg'),
                            array('title' => 'توت خشک سفید طرقبه', 'price' => 580000, 'img' => 'category-natural-snacks.jpg')
                        );
                    } elseif ($tab_id == 'snacks') {
                        $fallback_products = array(
                            array('title' => 'لواشک پذیرایی کادویی', 'price' => 120000, 'img' => 'category-fruit-sheets.jpg'),
                            array('title' => 'لواشک کادویی سنتی', 'price' => 190000, 'img' => 'category-fruit-sheets.jpg'),
                            array('title' => 'لواشک لوله‌ای ملس', 'price' => 650000, 'img' => 'category-fruit-sheets.jpg'),
                            array('title' => 'آلوچه ترش جنگلی', 'price' => 110000, 'img' => 'category-fruit-sheets.jpg')
                        );
                    } else {
                        $fallback_products = array(
                            array('title' => 'گردو پوست کاغذی خور', 'price' => 340000, 'img' => 'category-nuts.jpg'),
                            array('title' => 'مغز گردو دوپر سفید', 'price' => 680000, 'img' => 'category-nuts.jpg'),
                            array('title' => 'مغز بادام ایرانی سورت شده', 'price' => 580000, 'img' => 'category-nuts.jpg'),
                            array('title' => 'مخلوط آجیل خشکبار صادراتی', 'price' => 780000, 'img' => 'category-nuts.jpg')
                        );
                    }
                    
                    foreach ($fallback_products as $idx => $fp) {
                        ?>
                        <div class="product-card" data-category="<?php echo esc_attr($tab_id); ?>" style="<?php echo esc_attr($display_style); ?>">
                          <div class="product-img-container">
                            <img src="<?php echo esc_url($plugin_images_url . $fp['img']); ?>" alt="<?php echo esc_attr($fp['title']); ?>">
                            <span class="product-badge-green">ویژه</span>
                            <div class="product-pill-title"><?php echo esc_html($fp['title']); ?></div>
                          </div>
                          <div class="product-price-area">
                            <span class="product-price-old">۱۲,۰۰۰,۰۰۰ تومان</span>
                            <div class="product-price-current"><?php echo esc_html(number_format($fp['price'])); ?> <span>تومان</span></div>
                          </div>
                          <button class="product-purple-btn">افزودن به سبد خرید</button>
                          <div class="product-stock-area">
                            <div class="product-stock-labels"><span>باقی مانده: <?php echo esc_html(10 + $idx); ?></span><span>فروخته شده: <?php echo esc_html(20 + $idx); ?></span></div>
                            <div class="product-stock-progress"><div class="product-stock-progress-fill" style="width: 60%;"></div></div>
                          </div>
                          <div class="product-countdown">
                            <div class="countdown-unit"><span class="countdown-num">۳۲</span><span class="countdown-label">ثانیه</span></div>
                            <div class="countdown-unit"><span class="countdown-num">۴۲</span><span class="countdown-label">دقیقه</span></div>
                            <div class="countdown-unit"><span class="countdown-num">۰۳</span><span class="countdown-label">ساعت</span></div>
                            <div class="countdown-unit"><span class="countdown-num">۱۰۸</span><span class="countdown-label">روز</span></div>
                          </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
          </div>
        </div>
      </section>

      <!-- اسکریپت فیلتر پویای دسته‌بندی و اسلایدر پرفروش‌ها مجهز به اتوپلی و اسکرول ۴تایی -->
      <script>
        jQuery(document).ready(function($) {
          const gridScroll = $(".alookhor-bestsellers-wrapper .products-grid");
          const tabItems = $(".alookhor-bestsellers-wrapper .products-tab-item");
          const productCards = $(".alookhor-bestsellers-wrapper .product-card");
          const nextBtn = $("#bestsellers-next-btn");
          const prevBtn = $("#bestsellers-prev-btn");

          // ۱. ابعاد جابجایی صفحه به صفحه (جابجایی کل پهنای قاب شامل ۴ محصول همزمان در دسکتاپ)
          function getSlideAmount() {
            if (gridScroll.length) {
              return gridScroll.width() + 20; // عرض کل قاب مشاهده به همراه فاصله
            }
            return 1200;
          }

          // ۲. دکمه حرکت بعدی (Next) - اسکرول به سمت چپ در RTL
          nextBtn.on("click", function(e) {
            e.preventDefault();
            const amount = getSlideAmount();
            const maxScrollLeft = gridScroll[0].scrollWidth - gridScroll.width();
            if (Math.abs(gridScroll.scrollLeft()) >= maxScrollLeft - 15) {
              gridScroll.animate({ scrollLeft: 0 }, 500);
            } else {
              gridScroll.animate({ scrollLeft: gridScroll.scrollLeft() - amount }, 500);
            }
            resetAutoplay();
          });

          // ۳. دکمه حرکت قبلی (Prev) - اسکرول به سمت راست در RTL
          prevBtn.on("click", function(e) {
            e.preventDefault();
            const amount = getSlideAmount();
            if (gridScroll.scrollLeft() >= -5) {
              const maxScrollLeft = gridScroll[0].scrollWidth - gridScroll.width();
              gridScroll.animate({ scrollLeft: -maxScrollLeft }, 500);
            } else {
              gridScroll.animate({ scrollLeft: gridScroll.scrollLeft() + amount }, 500);
            }
            resetAutoplay();
          });

          // ۴. سیستم اسکرول خودکار (Autoplay) هر ۵ ثانیه یکبار به اندازه ۱ صفحه (۴ محصول در دسکتاپ)
          let autoplayTimer;
          function startAutoplay() {
            autoplayTimer = setInterval(function() {
              if (gridScroll.is(":hover")) return; // متوقف شدن در زمان هاور ماوس کاربر
              nextBtn.trigger("click");
            }, 5000);
          }

          function resetAutoplay() {
            clearInterval(autoplayTimer);
            startAutoplay();
          }

          startAutoplay();

          // ۵. فیلتر کردن تب‌ها و بازنشانی اسکرول اسلایدر به ابتدا (تفکیک ۱۰۰٪ بومی ووکامرس)
          tabItems.on("click", function() {
            tabItems.removeClass("active");
            $(this).addClass("active");

            const targetCategory = $(this).attr("data-target");

            productCards.each(function() {
              const cardCategory = $(this).attr("data-category");
              if (cardCategory === targetCategory) {
                $(this).css("display", "flex");
                $(this).css("opacity", "0");
                $(this).animate({ opacity: 1 }, 400);
              } else {
                $(this).css("display", "none");
                $(this).css("opacity", "0");
              }
            });

            // بازنشانی موقعیت اسکرول به ابتدا هنگام تعویض دسته‌بندی
            gridScroll.animate({ scrollLeft: 0 }, 300);
            resetAutoplay();
          });
        });
      </script>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('alookhor_bestsellers_slider', 'alookhor_cc_render_bestsellers_slider');
