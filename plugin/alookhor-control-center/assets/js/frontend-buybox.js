/* ==========================================================================
   ALOOKHOR Luxury Buy Box — Frontend controller
   - Pills فقط روی Selectهای بومی WooCommerce سوار می‌شوند؛ موتور رسمی
     wc-add-to-cart-variation بدون تغییر پادشاه است (موجودی/قیمت/AX).
   - قیمت کارت با رویداد found_variation به‌صورت زنده و با ارقام فارسی جایگذاری می‌شود.
   ========================================================================== */
(function ($) {
    'use strict';

    if (typeof $ !== 'function') return;

    var CFG = window.ALOOKHOR_BUYBOX || {};
    var FA_DIGITS = '۰۱۲۳۴۵۶۷۸۹';

    function faDigits(value) {
        return String(value).replace(/[0-9]/g, function (d) { return FA_DIGITS[+d]; });
    }

    function formatPrice(amount) {
        var decimals = parseInt(CFG.decimals, 10);
        if (isNaN(decimals) || decimals < 0) decimals = 0;
        var sep = CFG.thousand_sep || '٬';
        var currency = $('<span/>').text(CFG.currency || '').html();
        var num = Number(amount || 0);
        if (isNaN(num)) num = 0;
        var fixed = num.toFixed(decimals);
        var parts = fixed.split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, sep);
        var human = faDigits(decimals ? parts.join('٫') : parts[0]);
        return '<span class="alk-bb-amount alk-bb-amount--now">' +
               '<bdi class="alk-bb-amount__num">' + human + '</bdi>' +
               ' <span class="alk-bb-amount__cur">' + currency + '</span></span>';
    }

    function formatOldPrice(amount) {
        var html = formatPrice(amount).replace('alk-bb-amount--now', 'alk-bb-amount--old');
        return '<del>' + html + '</del>';
    }

    function saleBadgeText(percent) {
        var tpl = CFG.sale_badge || '%d٪ تخفیف';
        return tpl.replace(/%d|%s/, faDigits(percent));
    }

    /* ——— Toast سبک داخلی ——— */
    var toastTimer = null;
    function toast(message) {
        var $t = $('.alk-bb-toast');
        if (!$t.length) {
            $t = $('<div/>', { 'class': 'alk-bb-toast', role: 'status', 'aria-live': 'polite' }).appendTo('body');
        }
        $t.text(message).addClass('is-visible');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { $t.removeClass('is-visible'); }, 2200);
    }

    /* ——— علاقه‌مندی/مقایسه سبک‌وزن (localStorage) ——— */
    function readSet(key) {
        try { return JSON.parse(window.localStorage.getItem(key) || '[]'); } catch (e) { return []; }
    }
    function writeSet(key, arr) {
        try { window.localStorage.setItem(key, JSON.stringify(arr)); } catch (e) { /* private mode */ }
    }
    function toggleSet(key, id) {
        var arr = readSet(key);
        var idx = arr.indexOf(id);
        var on = idx === -1;
        if (on) { arr.push(id); } else { arr.splice(idx, 1); }
        writeSet(key, arr);
        return on;
    }

    function buyboxInit() {
        var $box = $('.alk-bb');
        if (!$box.length) return;
        if ($box.data('alk-init')) return; // جلوگیری از بایند دوباره روی AJAX re-init
        $box.data('alk-init', 1);

        var $form = $box.find('form.variations_form').first();
        var $priceNow = $box.find('.alk-bb-price-now').first();
        var $priceOld = $box.find('.alk-bb-price-old').first();
        var $badge = $box.find('.alk-bb-sale-badge').first();
        var $stock = $box.find('.alk-bb-stock').first();
        var $stockText = $stock.find('.alk-bb-stock__text').first();

        // اسنپ‌شات وضعیت اولیه برای reset_data
        var initial = {
            priceNow: $priceNow.html(),
            oldHtml: $priceOld.html(),
            oldHidden: $priceOld.prop('hidden'),
            badgeHtml: $badge.html(),
            badgeHidden: $badge.prop('hidden'),
            stockClass: $stock.attr('class'),
            stockText: $stockText.text()
        };

        /* ——— Selectهای بومی: قابل‌دسترس برای موتور، خارج از Tab order ظاهری ——— */
        $box.find('.variations select').attr('tabindex', '-1');
        $box.find('.variations').attr('aria-hidden', 'true');

        /* ——— همگام‌سازی Pills از روی Selectها ——— */
        function syncPills() {
            $box.find('.alk-bb-attr').each(function () {
                var name = $(this).data('attribute-name');
                var $sel = $form.find('select[name="' + name + '"]');
                var current = $sel.length ? $sel.val() : '';
                $(this).find('.alk-bb-pill').each(function () {
                    var $p = $(this);
                    var isOn = String($p.data('value')) === String(current) && current !== '';
                    $p.toggleClass('is-active', isOn).attr('aria-pressed', isOn ? 'true' : 'false');
                });
            });
        }

        // «آپدیت دسترس‌پذیری گزینه‌ها» توسط خودِ WooCommerce روی optionهای select اعمال می‌شود؛
        // state غیرفعال هر Pill از روی option متناظرش خوانده می‌شود.
        function syncPillsAvailability() {
            $box.find('.alk-bb-attr').each(function () {
                var name = $(this).data('attribute-name');
                var $opts = $form.find('select[name="' + name + '"] option');
                var map = {};
                $opts.each(function () {
                    var o = $(this);
                    map[String(o.attr('value'))] = !o.prop('disabled') && !o.hasClass('disabled');
                });
                $(this).find('.alk-bb-pill').each(function () {
                    var $p = $(this);
                    var val = String($p.data('value'));
                    var available = map.hasOwnProperty(val) ? map[val] : true;
                    $p.prop('disabled', !available);
                });
            });
        }

        /* ——— کلیک Pill → تنظیم Select بومی + رویداد رسمی ——— */
        $box.on('click', '.alk-bb-pill', function () {
            var $p = $(this);
            if ($p.prop('disabled')) return;
            var name = $p.data('attribute');
            var value = String($p.data('value'));
            var $sel = $form.find('select[name="' + name + '"]');
            if (!$sel.length) return;
            var next = ($p.hasClass('is-active')) ? '' : value; // کلیک مجدد = لغو انتخاب
            $sel.val(next).trigger('change');
        });

        $form.on('change', '.variations select', syncPills);

        $form.on('update_variation_values', function () {
            syncPills();
            syncPillsAvailability();
        });

        /* ——— قیمت زنده با یافتن متغیر ——— */
        $form.on('found_variation', function (e, variation) {
            if (!variation) return;
            var price = parseFloat(variation.display_price);
            var regular = parseFloat(variation.display_regular_price);
            var pct = 0;
            if (!isNaN(price) && !isNaN(regular) && regular > price && price >= 0) {
                pct = Math.round(((regular - price) / regular) * 100);
            }

            $priceNow.html(formatPrice(isNaN(price) ? 0 : price));
            $box.attr('data-alk-state', 'ready');

            if (pct > 0 && !isNaN(regular)) {
                $priceOld.html(formatOldPrice(regular)).prop('hidden', false);
                $badge.html(saleBadgeText(pct)).prop('hidden', false);
            } else {
                $priceOld.prop('hidden', true);
                $badge.prop('hidden', true);
            }

            var inStock = !!variation.is_in_stock;
            var backorder = /backorder/i.test(String(variation.availability_html || ''));
            var cls = inStock ? (backorder ? 'backorder' : 'in') : 'out';
            var map = CFG.i18n || {};
            $stock.attr('class', 'alk-bb-stock alk-bb-stock--' + cls);
            $stockText.text(
                cls === 'in' ? (map.in_stock || '') :
                cls === 'backorder' ? (map.on_backorder || '') : (map.out_of_stock || '')
            );
        });

        // بازگشت به حالت اولیه وقتی انتخاب کنسلی/ناقص شد
        $form.on('reset_data hide_variation', function () {
            $priceNow.html(initial.priceNow);
            $priceOld.html(initial.oldHtml).prop('hidden', initial.oldHidden);
            $badge.html(initial.badgeHtml).prop('hidden', initial.badgeHidden);
            $stock.attr('class', initial.stockClass);
            $stockText.text(initial.stockText);
            $box.attr('data-alk-state', 'pending');
            syncPills();
            syncPillsAvailability();
        });

        /* ——— استپر تعداد (اتصال به input.qty بومی) ——— */
        $box.on('click', '.alk-bb-qbtn', function () {
            var $btn = $(this);
            var $qty = $btn.siblings('.quantity').find('input.qty');
            if (!$qty.length) {
                $qty = $btn.closest('form').find('input.qty');
            }
            if (!$qty.length) return;

            var step = parseFloat($qty.attr('step')) || 1;
            var min = parseFloat($qty.attr('min'));
            if (isNaN(min)) min = 1;
            var max = parseFloat($qty.attr('max'));
            var val = parseFloat($qty.val());
            if (isNaN(val)) val = min;

            val += $btn.hasClass('alk-bb-qbtn--plus') ? step : -step;
            if (!isNaN(max) && max > 0) val = Math.min(val, max);
            val = Math.max(val, min);

            $qty.val(val).trigger('change');
        });

        /* ——— علاقه‌مندی / مقایسه ——— */
        var WKEY = 'alkBbWishlist', CKEY = 'alkBbCompare';

        function paintToggle($btn, on) {
            $btn.toggleClass('is-on', on).attr('aria-pressed', on ? 'true' : 'false');
        }

        $box.find('.alk-bb-iconbtn--wishlist').each(function () {
            var $b = $(this);
            paintToggle($b, readSet(WKEY).indexOf(String($b.data('product-id'))) !== -1);
        });
        $box.find('.alk-bb-iconbtn--compare').each(function () {
            var $b = $(this);
            paintToggle($b, readSet(CKEY).indexOf(String($b.data('product-id'))) !== -1);
        });

        $box.on('click', '.alk-bb-iconbtn--wishlist', function () {
            var on = toggleSet(WKEY, String($(this).data('product-id')));
            paintToggle($(this), on);
            toast(on ? (CFG.i18n.wishlist_on || '') : (CFG.i18n.wishlist_off || ''));
        });
        $box.on('click', '.alk-bb-iconbtn--compare', function () {
            var on = toggleSet(CKEY, String($(this).data('product-id')));
            paintToggle($(this), on);
            toast(on ? (CFG.i18n.compare_on || '') : (CFG.i18n.compare_off || ''));
        });

        /* ——— اشتراک‌گذاری: Web Share API ← Clipboard ——— */
        $box.on('click', '.alk-bb-iconbtn--share', function () {
            var data = { title: document.title, url: window.location.href };
            if (navigator.share) {
                navigator.share(data).catch(function () { /* کاربر لغو کرد */ });
                return;
            }
            var done = function () { toast(CFG.i18n.link_copied || ''); };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(data.url).then(done).catch(function () { legacyCopy(data.url, done); });
            } else {
                legacyCopy(data.url, done);
            }
        });

        function legacyCopy(text, done) {
            var tmp = document.createElement('textarea');
            tmp.value = text;
            tmp.style.position = 'fixed';
            tmp.style.opacity = '0';
            document.body.appendChild(tmp);
            tmp.select();
            try { document.execCommand('copy'); done(); } catch (e) { /* silent */ }
            document.body.removeChild(tmp);
        }

        // وضع اولیه Pills از روی Selectها (پشتیبانی از Default Attribute وردپرس)
        syncPills();
        syncPillsAvailability();
    }

    $(function () {
        buyboxInit();
        // صفحات AJAXی/Country-generated: اگر قاب دیر تزریق شد دوباره init شود
        $(document.body).on('woocommerce_variations_loaded', buyboxInit);
    });
})(jQuery);
