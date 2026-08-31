<?php
/** مدیریت برگه‌ها — ALOOKHOR Center submenu: edit texts & images of managed pages. */
if(!defined('ABSPATH'))exit;

add_action('admin_menu',function(){
 add_submenu_page('alookhor-control-center','مدیریت برگه‌ها','مدیریت برگه‌ها','manage_options','alookhor-cc-pages',function(){alookhor_cc_render_pages_admin();});
});

add_action('admin_enqueue_scripts',function($hook){
 if($hook!=='alookhor-control-center_page_alookhor-cc-pages')return;
 wp_enqueue_style('alookhor-cc-luxury',ALOOKHOR_CC_URL.'assets/css/luxury.css',[],ALOOKHOR_CC_BUILD);
 wp_enqueue_media();
 $css='#apg-wrap{direction:rtl;margin:18px 0;font-family:Vazirmatn,Tahoma,sans-serif;color:#F5F3F0;max-width:1180px}
#apg-wrap .apg-card{border:1px solid rgba(212,175,55,.28);border-radius:18px;background:linear-gradient(150deg,rgba(38,33,61,.75),rgba(29,17,38,.92));padding:20px;margin-bottom:18px;box-shadow:0 16px 38px rgba(13,5,16,.35)}
#apg-wrap .apg-h{display:flex;justify-content:space-between;align-items:center;gap:10px;margin:0 0 14px;padding-bottom:12px;border-bottom:1px solid rgba(212,175,55,.18)}
#apg-wrap .apg-h h3{margin:0;color:#F5D76E;font-size:17px}
#apg-wrap .apg-h small{color:#C8BDCC;font-size:11px}
#apg-wrap .apg-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
#apg-wrap label{display:grid;gap:6px;font-size:11.5px;color:#C8BDCC}
#apg-wrap input[type=text],#apg-wrap input[type=url],#apg-wrap textarea{width:100%;min-width:0;border:1px solid rgba(212,175,55,.22);border-radius:10px;background:rgba(13,5,16,.6);color:#fff;padding:10px 12px;font-family:inherit;font-size:13px;outline:0}
#apg-wrap textarea{min-height:74px;line-height:1.9;resize:vertical}
#apg-wrap input:focus,#apg-wrap textarea:focus{border-color:#D4AF37;box-shadow:0 0 0 3px rgba(212,175,55,.14)}
#apg-wrap .apg-full{grid-column:1/-1}
#apg-wrap .apg-sub{margin:16px 0 10px;color:#F5D76E;font-size:13px;font-weight:800;border-right:3px solid #D4AF37;padding-right:9px}
#apg-wrap .apg-img{display:grid;grid-template-columns:74px 1fr auto auto;gap:9px;align-items:center;border:1px dashed rgba(212,175,55,.3);border-radius:12px;padding:9px;margin-bottom:8px}
#apg-wrap .apg-img img{width:74px;height:52px;object-fit:cover;border-radius:8px;border:1px solid rgba(212,175,55,.3);background:#1C1025}
#apg-wrap .apg-btn{min-height:40px;padding:9px 15px;border-radius:11px;border:1px solid rgba(212,175,55,.5);background:#26213D;color:#F5D76E;font-family:inherit;font-size:12px;font-weight:800;cursor:pointer}
#apg-wrap .apg-btn:hover{box-shadow:0 6px 16px rgba(212,175,55,.25)}
#apg-wrap .apg-save{position:sticky;bottom:14px;display:flex;justify-content:flex-end;gap:10px;margin-top:6px}
#apg-wrap .apg-save .apg-btn{min-width:190px;font-size:14px;background:linear-gradient(135deg,#F5D76E,#D4AF37);color:#1C1025}
#apg-wrap .apg-msg{position:fixed;bottom:22px;left:22px;z-index:99999;padding:13px 20px;border-radius:13px;background:#1C1025;border:1px solid rgba(212,175,55,.55);color:#F5D76E;font-weight:800;box-shadow:0 14px 34px rgba(13,5,16,.6);display:none}
#apg-wrap .apg-note{font-size:11px;color:#C8BDCC;line-height:1.9}
@media(max-width:900px){#apg-wrap .apg-grid{grid-template-columns:1fr}#apg-wrap .apg-img{grid-template-columns:64px 1fr;grid-auto-rows:auto}}';
 wp_register_style('alookhor-cc-pages-admin',false,[],ALOOKHOR_CC_BUILD);wp_enqueue_style('alookhor-cc-pages-admin');wp_add_inline_style('alookhor-cc-pages-admin',$css);
},20);

function alookhor_cc_pages_field($label,$id,$value,$full=false,$type='text'){
 $cls=$full?'apg-full':'';
 return '<label class="'.$cls.'">'.$label.'<input type="'.$type.'" id="'.esc_attr($id).'" value="'.esc_attr((string)$value).'"></label>';
}
function alookhor_cc_pages_area($label,$id,$value,$full=true){
 return '<label class="'.($full?'apg-full':'').'">'.$label.'<textarea id="'.esc_attr($id).'" rows="3">'.esc_textarea((string)$value).'</textarea></label>';
}
function alookhor_cc_pages_picker($label,$id,$url,$default){
 ob_start();?>
 <div class="apg-img" data-default="<?php echo esc_attr($default);?>">
  <img src="<?php echo esc_url($url);?>" alt="">
  <label><?php echo esc_html($label);?><input type="url" id="<?php echo esc_attr($id);?>" value="<?php echo esc_attr($url);?>"></label>
  <button type="button" class="apg-btn apg-pick" data-input="<?php echo esc_attr($id);?>">انتخاب از رسانه</button>
  <button type="button" class="apg-btn apg-reset">پیش‌فرض</button>
 </div>
 <?php return ob_get_clean();
}

function alookhor_cc_render_pages_admin(){
 if(!current_user_can('manage_options'))return;
 $p=alookhor_cc_get_pages_settings();$c=$p['contact'];$a=$p['about'];?>
 <div id="apg-wrap" class="wrap">
  <h1 style="color:#F5D76E">مدیریت برگه‌ها</h1>
  <p class="apg-note">متن‌ها و تصاویر برگه‌های مدیریت‌شده آلوخور از این بخش ویرایش می‌شوند؛ تغییرات بی‌درنگ روی سایت اعمال می‌شود. اطلاعات تماس (تلفن/ایمیل/واتساپ/نشانی/ساعت کاری) از بخش «تنظیمات» هدر و فوتر خوانده می‌شود. هر برگه مدیریت‌شده‌ی جدید هم در آینده به همین بخش اضافه می‌شود.</p>

  <div class="apg-card">
   <div class="apg-h"><h3>📞 برگه تماس با ما</h3><small>CONTACT PAGE</small></div>
   <div class="apg-grid">
    <?php echo alookhor_cc_pages_field('عنوان کوچک (Kicker)','pcKicker',$c['kicker']);
    echo alookhor_cc_pages_field('عنوان اصلی صفحه','pcTitle',$c['title']);
    echo alookhor_cc_pages_area('متن معرفی (زیر عنوان)','pcIntro',$c['intro']);?>
   </div>
   <div class="apg-sub">پرسش‌های پرتکرار (۵ مورد)</div>
   <div class="apg-grid">
    <?php foreach($c['faqs'] as $i=>$f){echo alookhor_cc_pages_field('سؤال '.($i+1),'pcFaqQ'.$i,$f['q']);echo alookhor_cc_pages_area('پاسخ '.($i+1),'pcFaqA'.$i,$f['a']);}?>
   </div>
  </div>

  <div class="apg-card">
   <div class="apg-h"><h3>📖 برگه درباره ما</h3><small>ABOUT PAGE</small></div>
   <div class="apg-grid">
    <?php echo alookhor_cc_pages_field('عنوان کوچک (Kicker)','paKicker',$a['kicker']);
    echo alookhor_cc_pages_field('عنوان اصلی صفحه','paTitle',$a['title']);
    echo alookhor_cc_pages_area('متن معرفی (زیر عنوان)','paIntro',$a['intro']);?>
   </div>
   <div class="apg-sub">داستان برند</div>
   <div class="apg-grid">
    <?php echo alookhor_cc_pages_field('عنوان کوچک','paStoryKicker',$a['story_kicker']);
    echo alookhor_cc_pages_field('عنوان بخش داستان','paStoryTitle',$a['story_title']);
    echo alookhor_cc_pages_area('پاراگراف اول','paStoryP1',$a['story_p1']);
    echo alookhor_cc_pages_area('پاراگراف دوم','paStoryP2',$a['story_p2']);?>
   </div>
   <?php echo alookhor_cc_pages_picker('تصویر داستان','paStoryImage',$a['story_image'],ALOOKHOR_CC_URL.'assets/images/category-plums.jpg');?>

   <div class="apg-sub">آمار برند (۴ کارت)</div>
   <div class="apg-grid">
    <?php foreach($a['stats'] as $i=>$s){echo alookhor_cc_pages_field('عنوان '.($i+1),'paStatB'.$i,$s['b']);echo alookhor_cc_pages_field('توضیح '.($i+1),'paStatS'.$i,$s['small']);}?>
   </div>

   <div class="apg-sub">سفر محصول (۴ مرحله)</div>
   <div class="apg-grid">
    <?php echo alookhor_cc_pages_field('عنوان کوچک','paJourneyKicker',$a['journey_kicker']);echo alookhor_cc_pages_field('عنوان بخش','paJourneyTitle',$a['journey_title']);
    foreach($a['steps'] as $i=>$s){echo alookhor_cc_pages_field('مرحله '.($i+1).' — عنوان','paStepB'.$i,$s['b']);echo alookhor_cc_pages_field('مرحله '.($i+1).' — توضیح','paStepS'.$i,$s['span']);}?>
   </div>
   <?php foreach($a['step_images'] as $i=>$img){echo alookhor_cc_pages_picker('تصویر پس‌زمینه مرحله '.($i+1),'paStepImg'.$i,$img,ALOOKHOR_CC_URL.'assets/images/'.['category-plums.jpg','category-nuts.jpg','category-fruit-sheets.jpg','export-banner-bg.jpg'][$i]);}?>

   <div class="apg-sub">ارزش‌ها (۴ کارت)</div>
   <div class="apg-grid">
    <?php echo alookhor_cc_pages_field('عنوان کوچک','paValuesKicker',$a['values_kicker']);echo alookhor_cc_pages_field('عنوان بخش','paValuesTitle',$a['values_title']);
    foreach($a['values'] as $i=>$v){echo alookhor_cc_pages_field('ارزش '.($i+1).' — عنوان','paValH'.$i,$v['h']);echo alookhor_cc_pages_area('ارزش '.($i+1).' — توضیح','paValP'.$i,$v['p']);}?>
   </div>

   <div class="apg-sub">بخش همکاری و امضا</div>
   <div class="apg-grid">
    <?php echo alookhor_cc_pages_field('عنوان کوچک همکاری','paExportKicker',$a['export_kicker']);
    echo alookhor_cc_pages_field('عنوان همکاری','paExportTitle',$a['export_title']);
    echo alookhor_cc_pages_area('متن همکاری','paExportText',$a['export_text']);
    echo alookhor_cc_pages_field('دکمه اول','paExportCta',$a['export_cta']);
    echo alookhor_cc_pages_field('دکمه دوم','paExportCta2',$a['export_cta2']);
    echo alookhor_cc_pages_field('شعار کنار امضا','paSignSmall',$a['sign_small']);?>
   </div>
  </div>

  <div class="apg-save"><button type="button" class="apg-btn" id="apgSaveBtn">💾 ذخیره همه تغییرات</button></div>
  <div class="apg-msg" id="apgMsg"></div>
  <script>
  (function(){
   var cfg=window.ALOOKHOR_CC||{};var ajaxUrl='<?php echo esc_url(admin_url('admin-ajax.php'));?>';var nonce='<?php echo esc_js(wp_create_nonce('alookhor_cc_nonce'));?>';
   function v(id){var el=document.getElementById(id);return el?el.value.trim():''}
   document.querySelectorAll('.apg-pick').forEach(function(btn){
    btn.addEventListener('click',function(){
     var frame=wp.media({title:'انتخاب تصویر',multiple:false,library:{type:'image'}});
     frame.on('select',function(){
      var att=frame.state().get('selection').first().toJSON();
      var input=document.getElementById(btn.dataset.input);
      var box=btn.closest('.apg-img');
      if(input&&att.url){input.value=att.url;if(box)box.querySelector('img').src=att.url}
     });
     frame.open();
    });
   });
   document.querySelectorAll('.apg-reset').forEach(function(btn){
    btn.addEventListener('click',function(){
     var box=btn.closest('.apg-img');if(!box)return;
     var input=box.querySelector('input[type=url]');
     if(input&&box.dataset.default){input.value=box.dataset.default;box.querySelector('img').src=box.dataset.default}
    });
   });
   function collect(){
    var faqs=[],stats=[],steps=[],values=[];
    for(var i=0;i<5;i++)faqs.push({q:v('pcFaqQ'+i),a:v('pcFaqA'+i)});
    for(var j=0;j<4;j++){stats.push({b:v('paStatB'+j),small:v('paStatS'+j)});steps.push({b:v('paStepB'+j),span:v('paStepS'+j)});values.push({h:v('paValH'+j),p:v('paValP'+j)})}
    return {contact:{kicker:v('pcKicker'),title:v('pcTitle'),intro:v('pcIntro'),faqs:faqs},
      about:{kicker:v('paKicker'),title:v('paTitle'),intro:v('paIntro'),story_kicker:v('paStoryKicker'),story_title:v('paStoryTitle'),story_p1:v('paStoryP1'),story_p2:v('paStoryP2'),story_image:v('paStoryImage'),stats:stats,journey_kicker:v('paJourneyKicker'),journey_title:v('paJourneyTitle'),steps:steps,step_images:[v('paStepImg0'),v('paStepImg1'),v('paStepImg2'),v('paStepImg3')],values_kicker:v('paValuesKicker'),values_title:v('paValuesTitle'),values:values,export_kicker:v('paExportKicker'),export_title:v('paExportTitle'),export_text:v('paExportText'),export_cta:v('paExportCta'),export_cta2:v('paExportCta2'),sign_small:v('paSignSmall')}};
   }
   var btn=document.getElementById('apgSaveBtn'),msg=document.getElementById('apgMsg');
   btn.addEventListener('click',function(){
    btn.disabled=true;btn.textContent='در حال ذخیره…';
    var body=new FormData();body.append('action','alookhor_cc_save_pages');body.append('nonce',nonce);body.append('pages',JSON.stringify(collect()));
    fetch(ajaxUrl,{method:'POST',body:body,credentials:'same-origin'}).then(function(r){return r.json()}).then(function(res){
     msg.textContent=res&&res.success?'✅ ذخیره شد — تغییرات روی سایت اعمال شد.':'❌ '+(res&&res.data?res.data:'ذخیره نشد؛ دوباره تلاش کنید.');
     msg.style.display='block';setTimeout(function(){msg.style.display='none'},4200);
    }).catch(function(){msg.textContent='❌ خطای شبکه؛ دوباره تلاش کنید.';msg.style.display='block'}).finally(function(){btn.disabled=false;btn.textContent='💾 ذخیره همه تغییرات'});
   });
  })();
  </script>
 </div>
 <?php
}

add_action('wp_ajax_alookhor_cc_save_pages',function(){
 check_ajax_referer('alookhor_cc_nonce','nonce');
 if(!current_user_can('manage_options'))wp_send_json_error('دسترسی ندارید');
 $raw=json_decode((string)wp_unslash($_POST['pages']??''),true);
 if(!is_array($raw))wp_send_json_error('payload نامعتبر');
 $txt=function($value){return sanitize_text_field((string)$value)};
 $url=function($value){return esc_url_raw((string)$value)};
 $d=alookhor_cc_pages_defaults();
 $c=$raw['contact']??[];$a=$raw['about']??[];
 $out=['contact'=>[
  'kicker'=>$txt($c['kicker']??$d['contact']['kicker']),
  'title'=>$txt($c['title']??$d['contact']['title']),
  'intro'=>$txt($c['intro']??$d['contact']['intro']),
  'faqs'=>[],
 ],'about'=>[
  'kicker'=>$txt($a['kicker']??$d['about']['kicker']),
  'title'=>$txt($a['title']??$d['about']['title']),
  'intro'=>$txt($a['intro']??$d['about']['intro']),
  'story_kicker'=>$txt($a['story_kicker']??$d['about']['story_kicker']),
  'story_title'=>$txt($a['story_title']??$d['about']['story_title']),
  'story_p1'=>$txt($a['story_p1']??$d['about']['story_p1']),
  'story_p2'=>$txt($a['story_p2']??$d['about']['story_p2']),
  'story_image'=>$url($a['story_image']??$d['about']['story_image'])?:$d['about']['story_image'],
  'stats'=>[],'journey_kicker'=>$txt($a['journey_kicker']??$d['about']['journey_kicker']),
  'journey_title'=>$txt($a['journey_title']??$d['about']['journey_title']),
  'steps'=>[],'step_images'=>[],'values_kicker'=>$txt($a['values_kicker']??$d['about']['values_kicker']),
  'values_title'=>$txt($a['values_title']??$d['about']['values_title']),'values'=>[],
  'export_kicker'=>$txt($a['export_kicker']??$d['about']['export_kicker']),
  'export_title'=>$txt($a['export_title']??$d['about']['export_title']),
  'export_text'=>$txt($a['export_text']??$d['about']['export_text']),
  'export_cta'=>$txt($a['export_cta']??$d['about']['export_cta']),
  'export_cta2'=>$txt($a['export_cta2']??$d['about']['export_cta2']),
  'sign_small'=>$txt($a['sign_small']??$d['about']['sign_small']),
 ]];
 for($i=0;$i<5;$i++){$out['contact']['faqs'][$i]=['q'=>$txt($c['faqs'][$i]['q']??$d['contact']['faqs'][$i]['q']),'a'=>$txt($c['faqs'][$i]['a']??$d['contact']['faqs'][$i]['a'])];}
 for($i=0;$i<4;$i++){
  $out['about']['stats'][$i]=['b'=>$txt($a['stats'][$i]['b']??''),'small'=>$txt($a['stats'][$i]['small']??'')];
  $out['about']['steps'][$i]=['b'=>$txt($a['steps'][$i]['b']??''),'span'=>$txt($a['steps'][$i]['span']??'')];
  $out['about']['values'][$i]=['h'=>$txt($a['values'][$i]['h']??''),'p'=>$txt($a['values'][$i]['p']??'')];
  $img=$url($a['step_images'][$i]??'');$out['about']['step_images'][$i]=$img?:$d['about']['step_images'][$i];
 }
 update_option('alookhor_pages_settings',$out,false);
 wp_send_json_success(['message'=>'ذخیره شد']);
});
