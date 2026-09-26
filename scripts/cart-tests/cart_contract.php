<?php
/**
 * Offline contract test: the real cart PHP files against minimal Woo/WordPress doubles.
 * Does not connect to production, place an order, or change a WordPress installation.
 * Run: php scripts/cart-tests/cart_contract.php
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
define('ABSPATH', __DIR__ . '/fixtures/wordpress/');
define('ALOOKHOR_CC_URL', 'https://alookhor.ir/wp-content/plugins/alookhor-control-center/');
define('ALOOKHOR_CC_BUILD', '3.10.412');
define('ALOOKHOR_CC_VERSION', '3.10.412');
define('ALOOKHOR_CC_PLUGIN_BASENAME', 'alookhor-control-center/alookhor-control-center.php');
define('MINUTE_IN_SECONDS', 60);
define('DAY_IN_SECONDS', 86400);
$GLOBALS['actions'] = $GLOBALS['filters'] = $GLOBALS['routes'] = $GLOBALS['transients'] = array();
$GLOBALS['saved_cart'] = array();
$GLOBALS['cookie_sent'] = 0;
$GLOBALS['cart_session_loaded'] = true; // the first page was populated at wp_loaded

function check($condition, $message) {
    if (!$condition) throw new RuntimeException('FAIL: ' . $message);
    echo 'PASS: ' . $message . "\n";
}
class WP_Error {
    private $code; private $message; public $data;
    public function __construct($code, $message = '', $data = null) { $this->code=$code; $this->message=$message; $this->data=$data; }
    public function get_error_code() { return $this->code; }
    public function get_error_message() { return $this->message; }
}
class RedirectSimulation extends RuntimeException {}
class WP_REST_Request {
    private $headers; private $params;
    public function __construct($params = array(), $headers = array()) { $this->params=$params;$this->headers=array_change_key_case($headers, CASE_LOWER); }
    public function get_header($name) { return $this->headers[strtolower($name)] ?? ''; }
    public function get_param($name) { return $this->params[$name] ?? null; }
}
class WP_REST_Response {
    public $data; public $headers=array();
    public function __construct($data) { $this->data=$data; }
    public function header($name,$value) { $this->headers[$name]=$value; }
    public function get_data() { return $this->data; }
}
function add_action($hook,$fn,$priority=10,$args=1) { $GLOBALS['actions'][$hook][]=$fn; }
function add_filter($hook,$fn,$priority=10,$args=1) { $GLOBALS['filters'][$hook][]=$fn; }
function apply_filters($hook,$value) { return $value; }
function register_rest_route($namespace,$route,$options) { $GLOBALS['routes'][$namespace . $route]=$options; }
function rest_ensure_response($data) { return new WP_REST_Response($data); }
function is_wp_error($data) { return $data instanceof WP_Error; }
function __return_true() { return true; }
function is_cart() { return true; }
function is_admin() { return false; }
function get_option($name) { return null; }
function wp_get_referer() { return ''; }
function __($text,$domain) { return $text; }
function wc_add_notice($text,$type) {}
function wp_safe_redirect($url) { throw new RedirectSimulation($url); }
function did_action($hook) {
    if ($hook === 'wp_loaded') return 1;
    if ($hook === 'woocommerce_load_cart_from_session') return (int) $GLOBALS['cart_session_loaded'];
    return 0;
}
function shortcode_exists($x) { return false; }
function remove_shortcode($x) {}
function add_shortcode($x,$fn) {}
function remove_action(...$args) {}
function wp_enqueue_style(...$args) {}
function wp_enqueue_script(...$args) {}
function wp_localize_script(...$args) {}
function wp_create_nonce($action) { return $action==='alookhor_cart'?'cart-nonce':'wrong'; }
function wp_verify_nonce($value,$action) { return $value==='cart-nonce' && $action==='alookhor_cart'; }
function esc_attr($s) { return htmlspecialchars((string)$s, ENT_QUOTES|ENT_SUBSTITUTE, 'UTF-8'); }
function esc_html($s) { return esc_attr($s); }
function esc_url($s) { return esc_attr($s); }
function esc_url_raw($s) { return (string)$s; }
function wp_json_encode($s,$flags=0) { return json_encode($s,$flags|JSON_THROW_ON_ERROR); }
function home_url($s='/') { return 'https://alookhor.ir' . $s; }
function rest_url($s) { return 'https://alookhor.ir/wp-json/' . $s; }
function wc_get_cart_url() { return 'https://alookhor.ir/cart/'; }
function wc_get_checkout_url() { return 'https://alookhor.ir/checkout/'; }
function wc_get_shop_page_permalink() { return 'https://alookhor.ir/shop/'; }
function wc_get_price_to_display($product, $args=array()) { return $product->get_price() * (int)($args['qty'] ?? 1); }
function wc_attribute_label($key,$product=null) { return $key==='pa_weight'?'وزن':$key; }
function get_term_by($what,$value,$taxonomy) { return false; }
function wc_placeholder_img_src() { return 'https://alookhor.ir/placeholder.png'; }
function wp_get_attachment_image_url($id,$size) { return false; }
function wp_trim_words($text,$words=16,$more='…') { return $text; }
function wp_strip_all_tags($s) { return strip_tags($s); }
function wc_clean($value) { return (string)$value; }
function sanitize_text_field($s) { return (string)$s; }
function sanitize_textarea_field($s) { return (string)$s; }
function wp_kses_post($s) { return (string)$s; }
function absint($v) { return abs((int)$v); }
function wc_format_coupon_code($code) { return trim($code); }
function wc_get_notices($type) { return array(); }
function wc_clear_notices() {}
function get_woocommerce_currency() { return 'IRT'; }
function wp_parse_url($url,$part) { return parse_url($url,$part); }
function wp_basename($url) { return basename((string)parse_url($url, PHP_URL_PATH)); }
function get_site_transient($key) { return $GLOBALS['transients'][$key] ?? false; }
function set_site_transient($key,$value,$ttl) { $GLOBALS['transients'][$key]=$value; }
function wp_safe_remote_get($url,$args=array()) { return array('status'=>200,'body'=>json_encode($GLOBALS['manifest_data'])); }
function wp_remote_retrieve_response_code($r) { return $r['status']; }
function wp_remote_retrieve_body($r) { return $r['body']; }
function download_url($url,$timeout=300,$verify=false) { return $GLOBALS['downloaded']; }
function wp_delete_file($path) { @unlink($path); }

class WC_Product {
    private $id, $type, $price, $children, $name;
    public function __construct($id,$type='simple',$price=1000,$children=array(),$name=null) { $this->id=$id;$this->type=$type;$this->price=$price;$this->children=$children;$this->name=$name??'محصول '.$id; }
    public function get_id() { return $this->id; }
    public function is_type($type) { return $this->type===$type; }
    public function is_in_stock() { return $this->id!==151; }
    public function is_purchasable() { return true; }
    public function get_children() { return $this->children; }
    public function get_image_id() { return 0; }
    public function get_regular_price() { return $this->price; }
    public function get_sale_price() { return ''; }
    public function get_price() { return $this->price; }
    public function is_on_sale() { return false; }
    public function is_featured() { return false; }
    public function get_name() { return $this->name; }
    public function get_short_description() { return ''; }
    public function get_permalink($args=array()) { return 'https://alookhor.ir/product/'.$this->id.'/'; }
    public function is_visible() { return true; }
}
class WC_Product_Variation extends WC_Product {
    private $parent;
    public function __construct($id,$parent,$price) { parent::__construct($id,'variation',$price);$this->parent=$parent; }
    public function get_parent_id() { return $this->parent; }
    public function get_variation_attributes() { return array('attribute_pa_weight'=>'500g'); }
}
class WC_Session {
    public function set_customer_session_cookie($send) { if ($send) $GLOBALS['cookie_sent']++; }
}
class WC_Cart {
    private $items;
    public function __construct($items=array()) { $this->items=$items; }
    public function get_cart() { return $this->items; }
    public function get_cart_from_session() { $this->items=$GLOBALS['saved_cart']; $GLOBALS['cart_session_loaded']=true; }
    public function get_cart_item($key) { return $this->items[$key] ?? null; }
    public function is_empty() { return !$this->items; }
    public function get_cart_contents_count() { return array_sum(array_column($this->items,'quantity')); }
    public function get_totals() {
        $sum=array_sum(array_column($this->items,'line_total'));
        return array('subtotal'=>$sum,'discount_total'=>0,'shipping_total'=>0,'fee_total'=>0,'total'=>$sum);
    }
    public function add_to_cart($product_id,$quantity=1,$variation_id=0,$variation=array()) {
        $parent=wc_get_product($product_id);
        if ($parent->is_type('variable') && (!$variation_id || ($variation['attribute_pa_weight'] ?? '') !== '500g')) return false;
        $key='item-'.$product_id.'-'.$variation_id;
        $product=wc_get_product($variation_id ?: $product_id);
        if (isset($this->items[$key])) $quantity+=$this->items[$key]['quantity'];
        $this->items[$key]=array('data'=>$product,'quantity'=>$quantity,'line_total'=>$product->get_price()*$quantity,
            'variation_id'=>$variation_id,'variation'=>$variation);
        return $key;
    }
    public function set_quantity($key,$qty,$refresh=true) {
        if (!isset($this->items[$key])) return false;
        $this->items[$key]['quantity']=$qty;
        $this->items[$key]['line_total']=$this->items[$key]['data']->get_price()*$qty;
        return true;
    }
    public function remove_cart_item($key) { unset($this->items[$key]);return true; }
    public function apply_coupon($code) { return $code==='SAVE10'; }
    public function calculate_totals() {}
    public function set_session() { $GLOBALS['saved_cart']=$this->items; }
}
function wc_get_product($id) { return $GLOBALS['products'][$id] ?? null; }
function wc_get_products($query) {
    return array_values(array_filter($GLOBALS['products'], fn($p)=>$p->is_type('simple')||$p->is_type('variable')));
}
function WC() { return $GLOBALS['woo']; }
$GLOBALS['products']=array(
    11=>new WC_Product(11),22=>new WC_Product(22),33=>new WC_Product(33),
    148=>new WC_Product(148,'variable',1635000,array(150,151),'آلو متغیر'),
    150=>new WC_Product_Variation(150,148,1635000),151=>new WC_Product_Variation(151,148,1800000),
    200=>new WC_Product(200,'variable',2000000,array(),'بدون گزینه'),
);
$GLOBALS['woo']=(object)array('cart'=>new WC_Cart(), 'session'=>new WC_Session());

$plugin=dirname(__DIR__,2).'/plugin/alookhor-control-center/';
require $plugin.'includes/cart-page.php';
require $plugin.'includes/cart-rest.php';
foreach ($GLOBALS['actions']['rest_api_init'] as $register) $register();
function route($path,$params=array(),$nonce='cart-nonce') {
    $def=$GLOBALS['routes']['alookhor-cart/v4/'.$path];
    $r=new WP_REST_Request($params,array('X-ALOOKHOR-CART-NONCE'=>$nonce));
    $permission=call_user_func($def['permission_callback'],$r);
    return is_wp_error($permission)?$permission:call_user_func($def['callback'],$r);
}

// Reproduce three distinct lines and 5 units. No two-item limit exists.
WC()->cart->add_to_cart(11,1);
WC()->cart->add_to_cart(22,1);
WC()->cart->add_to_cart(33,3);
$cart=route('cart')->get_data();
check($cart['lines']===3 && $cart['count']===5 && count($cart['items'])===3, 'three lines and five units are returned, not capped at two');
check($cart['items'][2]['line_total']===3000.0, 'cart row uses the actual Woo discounted line total');
$html=alookhor_cc_cart_markup();
check(substr_count($html,'class="cart-row"')===3 && strpos($html,'۳ نوع، ۵ عدد')!==false, 'SSR renders every line and clearly separates lines from units');

$recs=alookhor_cc_cart_recommendations(6);
$variable=array_values(array_filter($recs,fn($r)=>$r['id']===148))[0];
check($variable['type']==='variable' && count($variable['options'])===1 && $variable['options'][0]['variation_id']===150, 'only purchasable in-stock variation is offered');
check(strpos($html,'data-attributes="{&quot;attribute_pa_weight&quot;:&quot;500g&quot;}"')!==false, 'SSR variant select includes the real attribute');
$no_options=alookhor_cc_cart_suggestions_html(array(array('id'=>200,'type'=>'variable','options'=>array(),'permalink'=>'https://alookhor.ir/product/200/','name'=>'گزینه ناموجود')));
check(strpos($no_options,'data-add-id=')===false && strpos($no_options,'href="https://alookhor.ir/product/200/"')!==false, 'variable without a valid option links to the product rather than claiming to add');

$invalid=route('cart/add',array('product_id'=>148,'quantity'=>1));
check(is_wp_error($invalid) && $invalid->get_error_code()==='variation_required', 'variable parent cannot be silently added without a variant');
$invalid=route('cart/add',array('product_id'=>148,'variation_id'=>150,'variation'=>array('attribute_pa_weight'=>'999g')));
check(is_wp_error($invalid) && $invalid->get_error_code()==='invalid_variation', 'mismatched variant attributes are rejected');
$invalid=route('cart/add',array('product_id'=>11,'variation_id'=>150));
check(is_wp_error($invalid) && $invalid->get_error_code()==='invalid_variation', 'variation cannot be attached to a different parent');
$forged=route('cart/add',array('product_id'=>11),'invalid');
check(is_wp_error($forged) && $forged->get_error_code()==='invalid_cart_nonce', 'cart mutation rejects a bad nonce');
// In real Woo, REST bypasses frontend wc_load_cart() at init. wc_load_cart() inside
// the callback runs after wp_loaded and its session hook never fires automatically.
WC()->cart->set_session(); // persist the previous page's three products
WC()->cart=new WC_Cart(); // new REST request, cart object starts empty
$GLOBALS['cart_session_loaded']=false;
$added=route('cart/add',array('product_id'=>148,'variation_id'=>150,'quantity'=>2,'variation'=>array('attribute_pa_weight'=>'500g')));
check($GLOBALS['cart_session_loaded']===true, 'REST POST explicitly loads the saved Woo cart before adding');
check($added instanceof WP_REST_Response && $added->get_data()['lines']===4 && $added->get_data()['count']===7, 'chosen variable product adds two units as a fourth line');
check($GLOBALS['cookie_sent']>0 && count($GLOBALS['saved_cart'])===4, 'mutation saves the cart and explicitly sends a guest session cookie');
WC()->cart=new WC_Cart();
$GLOBALS['cart_session_loaded']=false;
check(route('cart')->get_data()['count']===7 && $GLOBALS['cart_session_loaded']===true, 'fresh REST GET with the same session sees all items');
WC()->cart=new WC_Cart();
$GLOBALS['cart_session_loaded']=false;
$updated=route('cart/update',array('key'=>'item-33-0','quantity'=>4));
check($GLOBALS['cart_session_loaded'] && $updated instanceof WP_REST_Response && $updated->get_data()['count']===8, 'fresh REST update loads all previous rows and changes quantity above two');
WC()->cart=new WC_Cart();
$GLOBALS['cart_session_loaded']=false;
$removed=route('cart/remove',array('key'=>'item-22-0'));
check($GLOBALS['cart_session_loaded'] && $removed instanceof WP_REST_Response && $removed->get_data()['lines']===3 && $removed->get_data()['count']===7, 'fresh REST remove leaves the other lines intact');
WC()->cart=new WC_Cart();
$GLOBALS['cart_session_loaded']=false;
$coupon=route('cart/coupon',array('code'=>'SAVE10'));
check($GLOBALS['cart_session_loaded'] && $coupon instanceof WP_REST_Response && $coupon->get_data()['count']===7, 'fresh REST coupon retains the same cart session');

// Product-page GET with quantity > 1 runs at wp_loaded priority 9, before Woo's
// priority-10 session hook. Simulate the redirect without exiting this test.
WC()->cart=new WC_Cart();
$GLOBALS['cart_session_loaded']=false;
$_GET=array('add-to-cart'=>11, 'quantity'=>3);
$_REQUEST=$_GET;
$redirected=false;
try { $GLOBALS['actions']['wp_loaded'][0](); }
catch (RedirectSimulation $e) { $redirected=true; }
check($redirected && $GLOBALS['cart_session_loaded'] && count($GLOBALS['saved_cart'])===3
    && $GLOBALS['saved_cart']['item-11-0']['quantity']===4
    && $GLOBALS['saved_cart']['item-33-0']['quantity']===4,
    'product-page GET quantity loads the previous cart before Woo session hook and redirect');
$_GET=$_REQUEST=array();

// JSON embedded inside an HTML <script> must not be able to terminate that script.
$GLOBALS['products'][33]=new WC_Product(33,'simple',1000,array(),'</script><img src=x onerror=alert(1)>');
$saved=$GLOBALS['saved_cart'];
$saved['item-33-0']['data']=$GLOBALS['products'][33];
WC()->cart=new WC_Cart($saved);
$html=alookhor_cc_cart_markup();
preg_match('~<script id="alookhor-cart-initial"[^>]*>(.*?)</script>~s',$html,$match);
check(!empty($match) && strpos($match[1],'</script>')===false && strpos($match[1],'\\u003C\\/script\\u003E')!==false, 'SSR JSON hex-escapes HTML script terminators');

// Pre-download SHA gate must intercept raw GitHub ZIPs too; a mismatched file cannot install.
require $plugin.'includes/updater.php';
$hook=$GLOBALS['filters']['upgrader_pre_download'][0];
$url='https://raw.githubusercontent.com/emeliijaddd-png/alookhor-update-publisher/main/packages/cc-release/alookhor-control-center.zip';
$GLOBALS['manifest_data']=array('version'=>'3.10.412','download_url'=>$url,'sha256'=>hash('sha256','trusted ZIP bytes'));
$GLOBALS['downloaded']=tempnam(sys_get_temp_dir(),'cart-zip-');
file_put_contents($GLOBALS['downloaded'],'tampered ZIP');
$blocked=$hook(false,$url,null,array('plugin'=>ALOOKHOR_CC_PLUGIN_BASENAME));
check(is_wp_error($blocked) && $blocked->get_error_code()==='alookhor_sha256_mismatch' && !file_exists($GLOBALS['downloaded']), 'bad SHA-256 from GitHub raw is rejected and the temp file deleted');
$blocked=$hook(false,'https://bad.example/alookhor-control-center.zip',null,array('plugin'=>ALOOKHOR_CC_PLUGIN_BASENAME));
check(is_wp_error($blocked) && $blocked->get_error_code()==='alookhor_untrusted_package_host', 'a self-update from an unapproved host fails closed');
check($hook(false,'https://bad.example/unrelated.zip',null,array('plugin'=>'unrelated/plugin.php'))===false, 'another plugin remains unaffected');
$GLOBALS['downloaded']=tempnam(sys_get_temp_dir(),'cart-zip-');
file_put_contents($GLOBALS['downloaded'],'trusted ZIP bytes');
$accepted=$hook(false,$url,null,array('plugin'=>ALOOKHOR_CC_PLUGIN_BASENAME));
check($accepted===$GLOBALS['downloaded'] && $GLOBALS['transients']['alookhor_cc_last_verified_package']['sha256']===hash('sha256','trusted ZIP bytes'), 'correct SHA-256 permits only the matching package');
@unlink($GLOBALS['downloaded']);
echo "CART PHP CONTRACT: GREEN\n";
