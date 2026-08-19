#!/usr/bin/env python3
from pathlib import Path
import re

ROOT = Path(__file__).resolve().parents[1]
HEADER = ROOT / 'plugin/alookhor-control-center/includes/shortcode-header.php'
CSS = ROOT / 'plugin/alookhor-control-center/assets/css/frontend-header.css'

MARKER = 'ALOOKHOR-LUXURY-PURPLE-V1'

header = HEADER.read_text(encoding='utf-8')
css = CSS.read_text(encoding='utf-8')

if MARKER in header and MARKER in css:
    print('Header luxury patch already applied.')
    raise SystemExit(0)

# 1) Keep the existing shortcode and Elementor placement, but make the managed
#    capsule palette deep-purple/glass by default and migrate the current saved
#    capsule values once. Existing topbar/sticky navigation settings remain intact.
old_defaults = """        'capsule_background' => '#0D0510',
        'capsule_card' => '#1C1024',
        'capsule_glass' => 'rgba(33,20,38,.75)',
        'capsule_gold' => '#D49A2E',
        'capsule_gold_light' => '#E8B84A',
        'capsule_text' => '#F5F3F0',
        'capsule_muted' => '#C8C2C9',
        'capsule_blur' => 24,
"""
new_defaults = """        'capsule_background' => '#12051F',
        'capsule_card' => '#24102F',
        'capsule_glass' => 'rgba(47,20,66,.78)',
        'capsule_gold' => '#D4AF37',
        'capsule_gold_light' => '#F0C75E',
        'capsule_text' => '#FAF7FF',
        'capsule_muted' => '#C9BDD3',
        'capsule_blur' => 24,
"""
if old_defaults not in header:
    raise SystemExit('Expected header capsule defaults were not found.')
header = header.replace(old_defaults, new_defaults, 1)

old_settings = """    $settings = wp_parse_args($saved, $defaults);
    return apply_filters('alookhor_cc_front_header_settings', $settings);
}"""
new_settings = """    // ALOOKHOR-LUXURY-PURPLE-V1
    // One-time migration for the requested deep-purple glass capsule. This only
    // changes the capsule palette; topbar, sticky rail, logo, cart/account and
    // all existing WordPress/Elementor placement contracts remain untouched.
    if (!get_option('alookhor_header_luxury_purple_v1')) {
        $luxury_palette = [
            'capsule_background' => '#12051F',
            'capsule_card' => '#24102F',
            'capsule_glass' => 'rgba(47,20,66,.78)',
            'capsule_gold' => '#D4AF37',
            'capsule_gold_light' => '#F0C75E',
            'capsule_text' => '#FAF7FF',
            'capsule_muted' => '#C9BDD3',
            'capsule_blur' => 24,
        ];
        $saved = array_merge($saved, $luxury_palette);
        update_option(ALOOKHOR_CC_HEADER_OPTION, $saved, false);
        update_option('alookhor_header_luxury_purple_v1', '1', false);
    }

    $settings = wp_parse_args($saved, $defaults);
    return apply_filters('alookhor_cc_front_header_settings', $settings);
}"""
if old_settings not in header:
    raise SystemExit('Expected header settings block was not found.')
header = header.replace(old_settings, new_settings, 1)

# 2) Mark first-level WordPress menu items with children as Mega Menu roots.
#    The menu contents themselves still come from wp_nav_menu, so no static
#    navigation data is introduced.
old_menu = """function alookhor_cc_menu_markup($menu, $class, $depth = 3){
    if (!$menu || is_wp_error($menu)) return '';
    return wp_nav_menu([
        'menu'        => $menu->term_id,
        'container'   => false,
        'menu_class'  => $class,
        'depth'       => $depth,
        'fallback_cb' => false,
        'echo'        => false,
    ]);
}
"""
new_menu = """function alookhor_cc_menu_markup($menu, $class, $depth = 3){
    if (!$menu || is_wp_error($menu)) return '';

    $mega_class_filter = static function($classes, $item, $args, $item_depth) {
        if ((int) $item_depth === 0 && !empty($item->classes) && in_array('menu-item-has-children', $item->classes, true)) {
            $classes[] = 'alookhor-mega-item';
        }
        return $classes;
    };

    add_filter('nav_menu_css_class', $mega_class_filter, 10, 4);
    $markup = wp_nav_menu([
        'menu'        => $menu->term_id,
        'container'   => false,
        'menu_class'  => $class,
        'depth'       => $depth,
        'fallback_cb' => false,
        'echo'        => false,
    ]);
    remove_filter('nav_menu_css_class', $mega_class_filter, 10);

    return $markup;
}
"""
if old_menu not in header:
    raise SystemExit('Expected WordPress menu renderer was not found.')
header = header.replace(old_menu, new_menu, 1)
HEADER.write_text(header, encoding='utf-8')

# 3) Append a tightly scoped luxury/mega-menu layer. It intentionally does not
#    alter existing IDs/classes, sticky logic, mobile drawer structure, or search.
luxury_css = r'''

/* ALOOKHOR-LUXURY-PURPLE-V1
 * Deep-purple glass capsule + real WordPress-driven Mega Menu.
 * Scoped exclusively to the managed ALOOKHOR header.
 */
.alookhor-portal-header{
  --alookhor-plum:#12051F;
  --alookhor-panel:#24102F;
  --alookhor-glass:rgba(47,20,66,.78);
  --alookhor-luxury-gold:#D4AF37;
  --alookhor-luxury-gold-light:#F0C75E;
  --alookhor-luxury-text:#FAF7FF;
  --alookhor-luxury-muted:#C9BDD3;
}

.alookhor-portal-header .alookhor-nav-stage{
  background:
    radial-gradient(900px 150px at 50% -20%,rgba(118,54,151,.22),transparent 68%),
    linear-gradient(180deg,rgba(18,5,31,.97),rgba(18,5,31,.88) 66%,rgba(18,5,31,0));
}

.alookhor-portal-header .alookhor-nav-shell{
  position:relative;
  border-color:rgba(212,175,55,.34);
  border-top-color:rgba(240,199,94,.55);
  background:
    radial-gradient(650px 120px at 50% 0,rgba(155,83,192,.20),transparent 72%),
    linear-gradient(135deg,rgba(50,19,68,.86),rgba(29,10,42,.78) 55%,rgba(39,14,57,.82));
  -webkit-backdrop-filter:blur(24px) saturate(155%);
  backdrop-filter:blur(24px) saturate(155%);
  box-shadow:
    0 18px 48px rgba(8,2,14,.58),
    0 0 34px rgba(116,49,151,.12),
    inset 0 1px 0 rgba(255,255,255,.07),
    inset 0 -1px 0 rgba(212,175,55,.08);
}

.alookhor-portal-header .alookhor-nav-logo img,
.alookhor-portal-header .alookhor-nav-logo-mark{
  filter:drop-shadow(0 5px 15px rgba(212,175,55,.22));
}
.alookhor-portal-header .alookhor-nav-logo-mark{
  background:linear-gradient(145deg,#2C123C,#160622);
  border-color:rgba(212,175,55,.42);
  color:var(--alookhor-luxury-gold-light);
}
.alookhor-portal-header .alookhor-primary-menu>li>a{
  color:var(--alookhor-luxury-text)!important;
  text-shadow:0 1px 8px rgba(0,0,0,.18);
}
.alookhor-portal-header .alookhor-primary-menu>li:hover>a,
.alookhor-portal-header .alookhor-primary-menu>li.current-menu-item>a,
.alookhor-portal-header .alookhor-primary-menu>li.current-menu-ancestor>a{
  color:var(--alookhor-luxury-gold-light)!important;
}

/* First-level WordPress items with children become wide Mega Menu panels. */
@media(min-width:1024px){
  .alookhor-portal-header .alookhor-primary-menu>li.alookhor-mega-item>.sub-menu{
    right:50%;
    width:min(920px,calc(100vw - 64px));
    max-height:min(70vh,560px);
    overflow:auto;
    padding:18px!important;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:8px 10px;
    border:1px solid rgba(212,175,55,.28);
    border-top-color:rgba(240,199,94,.52);
    border-radius:20px;
    background:
      radial-gradient(620px 180px at 50% 0,rgba(130,61,165,.22),transparent 72%),
      linear-gradient(145deg,rgba(39,14,57,.97),rgba(18,5,31,.97));
    -webkit-backdrop-filter:blur(24px) saturate(150%);
    backdrop-filter:blur(24px) saturate(150%);
    box-shadow:0 24px 70px rgba(5,1,10,.68),0 0 35px rgba(115,47,150,.16),inset 0 1px 0 rgba(255,255,255,.06);
    transform:translate(50%,8px);
  }
  .alookhor-portal-header .alookhor-primary-menu>li.alookhor-mega-item:hover>.sub-menu,
  .alookhor-portal-header .alookhor-primary-menu>li.alookhor-mega-item:focus-within>.sub-menu{
    transform:translate(50%,0);
  }
  .alookhor-portal-header .alookhor-primary-menu>li.alookhor-mega-item>.sub-menu>li{
    min-width:0;
    padding:8px!important;
    border:1px solid rgba(212,175,55,.10);
    border-radius:14px;
    background:rgba(255,255,255,.025);
  }
  .alookhor-portal-header .alookhor-primary-menu>li.alookhor-mega-item>.sub-menu>li>a{
    padding:9px 10px;
    border-radius:10px;
    color:#F7F0FA!important;
    font-size:12px;
    font-weight:800;
    background:linear-gradient(180deg,rgba(212,175,55,.055),transparent);
  }
  .alookhor-portal-header .alookhor-primary-menu>li.alookhor-mega-item>.sub-menu>li>a:hover{
    color:var(--alookhor-luxury-gold-light)!important;
    background:rgba(212,175,55,.09);
  }
  .alookhor-portal-header .alookhor-primary-menu>li.alookhor-mega-item>.sub-menu>li>.sub-menu{
    position:static;
    width:auto;
    margin:4px 0 0!important;
    padding:4px 0 0!important;
    display:block;
    opacity:1;
    visibility:visible;
    transform:none;
    border:0;
    border-top:1px solid rgba(212,175,55,.10);
    border-radius:0;
    background:transparent;
    box-shadow:none;
    -webkit-backdrop-filter:none;
    backdrop-filter:none;
  }
  .alookhor-portal-header .alookhor-primary-menu>li.alookhor-mega-item>.sub-menu>li>.sub-menu>li>a{
    padding:7px 8px;
    color:var(--alookhor-luxury-muted)!important;
    font-size:11px;
  }
  .alookhor-portal-header .alookhor-primary-menu>li.alookhor-mega-item>.sub-menu>li>.sub-menu>li>a:hover{
    color:var(--alookhor-luxury-gold-light)!important;
    background:rgba(212,175,55,.07);
  }
}

@media(max-width:1023px){
  .alookhor-portal-header .alookhor-nav-shell{
    background:
      radial-gradient(380px 100px at 50% 0,rgba(132,61,168,.18),transparent 72%),
      linear-gradient(145deg,rgba(50,19,68,.88),rgba(25,8,36,.82));
    -webkit-backdrop-filter:blur(22px) saturate(150%);
    backdrop-filter:blur(22px) saturate(150%);
  }
}
'''
if MARKER not in css:
    CSS.write_text(css.rstrip() + luxury_css + '\n', encoding='utf-8')
else:
    raise SystemExit('CSS marker exists while PHP marker did not; refusing partial patch.')

print('Applied ALOOKHOR luxury purple glass header + WordPress Mega Menu patch.')
