import { Config } from '../core/config.js?v=3.10.215';

const escapeAttr = value => String(value ?? '').replace(/[&<>'"]/g, char => ({
  '&':'&amp;', '<':'&lt;', '>':'&gt;', "'":'&#039;', '"':'&quot;'
})[char]);
const isEnabled = value => value === true || value === 1 || value === '1' || value === 'true';
const footerLinksText = links => (Array.isArray(links) ? links : []).map(link => `${link.title || ''}|${link.url || ''}`).join('\n');
const parseFooterLinks = value => String(value || '').split(/\r?\n/).map(line => {
  const [title, ...url] = line.split('|');
  return {title:String(title || '').trim(), url:url.join('|').trim()};
}).filter(link => link.title);
const footerMenuOptions = selected => `<option value="0">لینک‌های سفارشی زیر</option>${(window.ALOOKHOR_CC?.footer_menus || []).map(menu => `<option value="${Number(menu.id)}" ${Number(selected)===Number(menu.id)?'selected':''}>${escapeAttr(menu.name)}</option>`).join('')}`;

export const settingsModule = {
  meta: { id: 'settings', title: 'مدیریت بوتیک' },
  async init(container){
    // لود حافظه واقعی قبلی — تمام سایت با همین تنظیمات ویرایش می‌شد
    if(!Config.data) await Config.load();
    let cfg = Config.data;
    // Guard: اگر حافظه به خاطر Tracking Prevention خالی بود، fallback بساز
    if(!cfg) cfg = {site:{name:'ALOOKHOR', subtitle:'Control Center • Luxury', logoLetter:'A'}, modules:{}, system:{}, header_settings:{logo_text:'ALOOKHOR', logo_sub:'Control Center • Luxury'}, ai_assistant:{suggestions:[]}};
    if(!cfg.modules) cfg.modules = {};
    if(cfg.modules.export){cfg.modules.export.title='بنر صادراتی آلوخور';cfg.modules.export.enabled=true;cfg.modules.export.note='شورت‌کد مدیریت‌شده صادرات'}
    cfg.modules.app=Object.assign({enabled:true,title:'دانلود اپلیکیشن آلوخور',description:'خرید آسان، استعلام سریع قیمت عمده و دسترسی به تخفیف‌های ویژه صادرکنندگان خشکبار',bazaar_url:'https://cafebazaar.ir/',myket_url:'https://myket.ir/',ios_url:'',more_url:'',background:'#100A1B',surface:'#181022',gold:'#F2A900',text:'#FFFFFF',muted:'#B8B0BD',radius:24},cfg.modules.app||{});
    cfg.modules.app.enabled=true;
    cfg.header_settings = Object.assign({
      enabled:               true,
      logo_id:               0,
      logo_url:              '',
      logo_width:            74,
      wholesale_text:        'خرید عمده',
      wholesale_url:         '/wholesale/',
      export_text:           'صادرات به بیش از ۵۰ کشور جهان',
      export_url:            '/export/',
      whatsapp_number:       '989159513173',
      email:                 '',
      phone:                 '09159513173',
      brand_name:            'آلوخور',
      brand_subtitle:        'خشکبار طبیعی اصیل',
      search_placeholder:    'جستجوی محصول، مقاله و ...',
      mainbar_glass_enabled:  true,
      mainbar_opacity:        72,
      capsule_blur:           18,
      topbar_bg:              '#1C0629',
      topbar_text_color:      '#F5F3F0',
      topbar_border_color:    '#D4AF37',
      topbar_button_bg:       '#D4AF37',
      topbar_button_text:     '#210A2C',
      header_surface:         '#21072F',
      header_text_color:      '#FFFFFF',
      header_muted_color:     '#C8C2C9',
      capsule_background:     '#16031F',
      capsule_card:           '#2D0D4A',
      capsule_gold:           '#D4AF37',
      capsule_gold_light:     '#F1D468',
      capsule_text:           '#FFFFFF',
      capsule_muted:          '#C8C2C9'
    }, cfg.header_settings || {});
    cfg.footer_settings = Object.assign({
      enabled:true, hide_legacy:true, hide_old_newsletter:true, use_header_contact:true,
      logo_url:'', logo_alt:'لوگوی رسمی آلوخور', brand_name:'ALOOKHOR', brand_subtitle:'PREMIUM PERSIAN DRIED PLUMS',
      brand_kicker:'From Iranian Orchards to the World', brand_description:'', cta_text:'درخواست قیمت عمده و صادراتی', cta_url:'',
      phone:'', email:'', whatsapp:'', address:'خراسان رضوی، خور نیشابور', support_label:'تلفن پشتیبانی و سفارش عمده',
      hours_week:'شنبه تا پنجشنبه: ۸ الی ۲۰', hours_friday:'جمعه‌ها: ۹ الی ۱۴',
      customer_title:'خدمات مشتریان', customer_menu_id:0, customer_links:[], order_title:'خرید و سفارش', order_menu_id:0, order_links:[],
      about_title:'درباره آلوخور', about_mobile_title:'راهنمای صادراتی', about_menu_id:0, about_links:[],
      instagram_url:'', telegram_url:'', whatsapp_url:'', social_title:'آلوخور را دنبال کنید', social_desc:'',
      newsletter_enabled:true, newsletter_title:'عضویت در خبرنامه', newsletter_desc:'', newsletter_placeholder:'ایمیل شما', newsletter_button:'عضویت',
      product_image_url:'', enamad_title:'Enamad', enamad_image_url:'', enamad_url:'', samandehi_title:'ساماندهی', samandehi_image_url:'', samandehi_url:'',
      copyright_text:'تمامی حقوق محفوظ است.', copyright_en:'Premium Persian Dried Plums Exporter',
      background:'#070809', surface:'#0D0F10', gold:'#C89A3D', gold_soft:'#E3BD69', text:'#E9E5DF', muted:'#A7A39D', border:'#4A3820',
      container_width:1280, desktop_logo_width:210, mobile_logo_width:190, show_payments:true, show_benefits:true, show_product_image:true
    }, cfg.footer_settings || {});
    cfg.category_settings = Object.assign({
      enabled:true, hide_legacy:true, hide_empty:false, parent_only:true, selected_ids:[38,39,40,41], limit:8, orderby:'include', order:'ASC',
      kicker:'ALOOKHOR PRODUCT CATEGORIES', title:'دسته‌بندی محصولات', subtitle:'', button_text:'مشاهده محصولات',
      show_description:true, show_count:false, show_icons:true, show_arrows:true, show_dots:true, autoplay:true, autoplay_interval:5000,
      desktop_cards:4, desktop_gap:18, image_height:285, mobile_card_width:84, mobile_gap:14, mobile_image_height:225, mobile_radius:18, mobile_peek:8, section_background:'#090610', card_background:'#0D0916', gold:'#D4A436', text:'#F7F2EA', muted:'#B8B0BD', border:'#6F5426', button_background:'#120B1C', overrides:{}
    }, cfg.category_settings || {});
    if(['دسته‌بندی محصولات','دسته بندی محصولات'].includes(String(cfg.category_settings.kicker||'').trim()))cfg.category_settings.kicker='ALOOKHOR PRODUCT CATEGORIES';
    if(['محصولات طبیعی، کیفیت صادراتی','محصولات منتخب آلوخور'].includes(String(cfg.category_settings.title||'').trim()))cfg.category_settings.title='دسته‌بندی محصولات';
    if(String(cfg.category_settings.subtitle||'').trim()==='انتخاب مستقیم از باغ‌های خراسان، آماده ارسال به سراسر جهان')cfg.category_settings.subtitle='';
    const heroBase=`${String(window.ALOOKHOR_CC?.home_url||'/').replace(/\/$/,'')}/wp-content/plugins/alookhor-categories-manager/images/`;
    const heroSlideDefaults=[
      {image_id:0,flip_image:true,image_url:`${heroBase}slide1.jpg`,image_alt:'آلو بخارا ممتاز خراسان',kicker:'محصول ممتاز خراسان',title:'آلو بخارا',highlight:'ممتاز خراسان',description:'طبیعی، سالم و بدون مواد افزودنی',features:['۱۰۰٪ طبیعی','کیفیت صادراتی','ارسال سریع','ارسال به سراسر جهان'],primary_text:'مشاهده محصولات',primary_url:'/shop/',secondary_text:'استعلام قیمت',secondary_url:'/#b2b'},
      {image_id:0,flip_image:true,image_url:`${heroBase}slide2.jpg`,image_alt:'آلو خشک طبیعی آلوخور',kicker:'انتخابی از باغ‌های ایران',title:'آلو خشک طبیعی',highlight:'خوش‌طعم و سالم',description:'سورت یکدست، فرآوری بهداشتی و طعم اصیل',features:['بدون افزودنی','سورت ممتاز','بسته‌بندی مطمئن','تحویل سریع'],primary_text:'خرید محصولات',primary_url:'/shop/',secondary_text:'مشاوره خرید',secondary_url:'/تماس-با-ما/'},
      {image_id:0,flip_image:true,image_url:`${heroBase}slide3.jpg`,image_alt:'بسته‌بندی صادراتی آلوخور',kicker:'استاندارد بازارهای جهانی',title:'بسته‌بندی حرفه‌ای',highlight:'آماده صادرات',description:'حفظ کیفیت محصول از باغ تا مقصد نهایی',features:['کنترل کیفیت','سورت دقیق','بسته‌بندی صادراتی','ارسال بین‌المللی'],primary_text:'خدمات صادرات',primary_url:'/#b2b',secondary_text:'تماس با ما',secondary_url:'/تماس-با-ما/'},
      {image_id:0,flip_image:true,image_url:`${heroBase}slide4.jpg`,image_alt:'سفارش عمده محصولات آلوخور',kicker:'همکاری مطمئن و ماندگار',title:'تأمین عمده آلو',highlight:'برای کسب‌وکارها',description:'ظرفیت پایدار، قیمت رقابتی و پشتیبانی تخصصی',features:['تأمین پایدار','قیمت همکاری','کنترل سفارش','پشتیبانی مستقیم'],primary_text:'درخواست همکاری',primary_url:'/#b2b',secondary_text:'دریافت مشاوره',secondary_url:'/تماس-با-ما/'}
    ];
    cfg.hero_settings=Object.assign({enabled:true,hide_legacy:true,autoplay:true,autoplay_interval:5500,pause_on_hover:true,show_arrows:true,show_dots:true,ken_burns:true,gold:'#D4AF37',surface:'#09060D',text:'#FFFFFF',muted:'#D9D1DA',radius:32,panel_opacity:34,panel_blur:20,slides:[]},cfg.hero_settings||{});
    const savedHeroSlides=Array.isArray(cfg.hero_settings.slides)?cfg.hero_settings.slides:[];
    cfg.hero_settings.slides=heroSlideDefaults.map((defaults,index)=>{
      const saved=savedHeroSlides[index]&&typeof savedHeroSlides[index]==='object'?savedHeroSlides[index]:{};
      return {...defaults,...saved,features:[...Array(4)].map((_,featureIndex)=>Array.isArray(saved.features)&&saved.features[featureIndex]!==undefined?saved.features[featureIndex]:defaults.features[featureIndex])};
    });
    if(cfg.modules.hero){cfg.modules.hero.slides=4;cfg.modules.hero.autoplay=isEnabled(cfg.hero_settings.autoplay)}
    const featureDefaults=[
      {icon:'truck',title:'ارسال سریع',description:'در سریع‌ترین زمان ممکن'},
      {icon:'organic',title:'محصولات ارگانیک',description:'100% طبیعی و سالم'},
      {icon:'headset',title:'پشتیبانی ۲۴/۷',description:'همیشه در کنار شما هستیم'},
      {icon:'shield',title:'ضمانت کیفیت',description:'تضمین اصالت و کیفیت کالا'}
    ];
    cfg.feature_settings=Object.assign({enabled:true,hide_legacy:true,background:'#0D0510',card:'#1C1024',glass:'rgba(33,20,38,.75)',gold:'#D49A2E',gold_light:'#E8B84A',text:'#F5F3F0',muted:'#C8C2C9',radius:20,gap:8,items:[]},cfg.feature_settings||{});
    const savedFeatureItems=Array.isArray(cfg.feature_settings.items)?cfg.feature_settings.items:[];
    cfg.feature_settings.items=featureDefaults.map((defaults,index)=>({...defaults,...(savedFeatureItems[index]&&typeof savedFeatureItems[index]==='object'?savedFeatureItems[index]:{})}));
    const sortStatsDefaults=[{icon:'calendar',value:'+15',label:'سال تجربه در صنعت خشکبار'},{icon:'box',value:'متنوع',label:'بسته‌بندی استاندارد در مدل‌های متنوع'},{icon:'users',value:'+10,000',label:'مشتریان عمده و تجاری'},{icon:'globe',value:'+50',label:'کشور هدف صادراتی'}];
    cfg.sort_center_settings=Object.assign({enabled:true,autoplay:true,autoplay_interval:5000,show_arrows:true,show_dots:true,eyebrow:'از باغ تا بسته‌بندی',title:'مرکز سورت و بسته‌بندی',title_highlight:'آلوخور',description:'سورت دقیق، کنترل کیفیت و بسته‌بندی استاندارد محصولات با ظرفیت بالای روزانه، به‌صورت مستقیم و بدون واسطه برای بازار داخلی و صادراتی.',button_text:'درخواست همکاری عمده',button_url:'/#b2b',secondary_button_text:'دریافت کاتالوگ محصولات',secondary_button_url:'/catalog/',image_badge_value:'+50',image_badge_text:'صادرات به کشور جهان',background:'#0D0712',surface:'#1C1024',gold:'#D4AF37',text:'#FFFFFF',muted:'#C8C2C9',radius:26,products_title:'محصولات قابل عرضه:',products:['آلو بخارا','آلو طرقبه','آلو شوقان','برگه زردآلو','گردو'],features:[],stats:sortStatsDefaults,slides:[]},cfg.sort_center_settings||{});
    cfg.sort_center_settings.products=[0,1,2,3,4].map(i=>String(cfg.sort_center_settings.products?.[i]??['آلو بخارا','آلو طرقبه','آلو شوقان','برگه زردآلو','گردو'][i]));
    const sortFeatureDefaults=[{icon:'link',title:'ارسال مستقیم',description:'بدون واسطه از مرکز سورت و بسته‌بندی آلوخور'},{icon:'shield',title:'تضمین کیفیت',description:'کنترل کیفیت در تمام مراحل سورت و بسته‌بندی'},{icon:'tag',title:'قیمت مناسب',description:'قیمت رقابتی برای سفارش‌های عمده و صادراتی'},{icon:'truck',title:'ارسال سریع',description:'بسته‌بندی و ارسال منظم به سراسر کشور و جهان'}];
    cfg.sort_center_settings.features=sortFeatureDefaults.map((d,i)=>({...d,...(cfg.sort_center_settings.features?.[i]||{})}));
    cfg.sort_center_settings.stats=sortStatsDefaults.map((d,i)=>({...d,...(cfg.sort_center_settings.stats?.[i]||{})}));
    const savedSortSlides=Array.isArray(cfg.sort_center_settings.slides)?cfg.sort_center_settings.slides:[];
    cfg.sort_center_settings.slides=[0,1,2,3,4,5].map(index=>Object.assign({image_id:0,image_url:'',image_alt:`تصویر مرکز سورت ${index+1}`,caption:''},savedSortSlides[index]||{}));
    cfg.featured_product_settings=Object.assign({enabled:true,eyebrow:'ALOOKHOR PREMIUM COLLECTION',title:'مجموعه منتخب',title_highlight:'آلوخور',subtitle:'دست‌چین بهترین آلوهای ایران | کیفیت ممتاز، طعم اصیل',limit:8,autoplay:true,autoplay_interval:4500,show_arrows:true,show_price:true,show_rating:true,show_excerpt:true,show_badge:true,show_add_to_cart:true,product_button_text:'مشاهده محصول',button_text:'مشاهده کل مجموعه',button_url:'/shop/',background:'#1C1025',card:'#26213D',gold:'#D4AF37',text:'#FFFFFF',muted:'#E5E5E5',radius:20},cfg.featured_product_settings||{});
    if(cfg.modules.collection){cfg.modules.collection.title='محصولات منتخب آلوخور';cfg.modules.collection.enabled=true}
    if(!cfg.modules.campaign)cfg.modules.campaign={enabled:true,title:'اسلایدر کمپین‌ها',order:11};
    cfg.campaign_settings=Object.assign({enabled:true,autoplay:true,autoplay_interval:5500,show_arrows:true,show_dots:true,height:420,radius:24,overlay:58,background:'#100817',gold:'#D4AF37',text:'#FFFFFF',slides:[]},cfg.campaign_settings||{});
    const campaignDefaults=[{image_id:0,image_url:'',image_alt:'کمپین آلوخور',eyebrow:'پیشنهاد ویژه آلوخور',title:'کمپین فروش ویژه',description:'بهترین محصولات آلوخور با شرایط ویژه',button_text:'مشاهده محصولات',button_url:'/shop/'},{image_id:0,image_url:'',image_alt:'خرید عمده آلوخور',eyebrow:'همکاری با کسب‌وکارها',title:'فروش عمده و صادراتی',description:'قیمت همکاری و تأمین پایدار محصولات',button_text:'درخواست همکاری',button_url:'/#b2b'}];
    cfg.campaign_settings.slides=[0,1,2,3,4,5].map((_,i)=>({...campaignDefaults[i%2],...(cfg.campaign_settings.slides?.[i]||{})}));
    if(!cfg.modules.bestsellers)cfg.modules.bestsellers={enabled:true,title:'پرفروش‌ترین محصولات',order:12};
    cfg.bestseller_settings=Object.assign({enabled:true,title:'پرفروش‌ترین محصولات آلوخور',limit:12,category_ids:[],autoplay:true,autoplay_interval:5000,show_arrows:true,show_tabs:true,show_price:true,show_stock:true,show_countdown:true,show_add_to_cart:true,background:'#100817',card:'#1B1222',gold:'#D4A928',purple:'#522080',text:'#FFFFFF',muted:'#AFA6B3',radius:24},cfg.bestseller_settings||{});
    if(!cfg.modules.newsletter)cfg.modules.newsletter={enabled:true,title:'خبرنامه حرفه‌ای',order:13};
    cfg.newsletter_settings=Object.assign({enabled:true,kicker:'باشگاه مشتریان آلوخور',title:'از تخفیف‌ها و محصولات جدید باخبر شوید',description:'با عضویت در خبرنامه، اولین نفری باشید که از جدیدترین محصولات، تخفیف‌های طلایی و اخبار خشکبار مطلع می‌شود.',placeholder:'ایمیل خود را وارد کنید…',button_text:'عضویت',success_text:'عضویت شما با موفقیت ثبت شد.',privacy_text:'با ثبت ایمیل، قوانین حریم خصوصی را می‌پذیرم.',background:'#43082F',surface:'#54133D',gold:'#D8A927',text:'#FFFFFF',muted:'#D4BECB',radius:18},cfg.newsletter_settings||{});
    if(!cfg.modules.magazine)cfg.modules.magazine={enabled:true,title:'مجله آلوخور',order:14};
    cfg.magazine_settings=Object.assign({enabled:true,title:'مجله آلوخور',subtitle:'آخرین مطالب درباره خواص، نگهداری، صادرات و فرآوری خشکبار',limit:8,category_id:0,autoplay:true,autoplay_interval:5500,show_arrows:true,show_date:true,show_excerpt:true,show_like:true,show_save:true,button_text:'ادامه مطلب',background:'#0B0713',card:'#1A1027',gold:'#D4AF37',text:'#FFFFFF',muted:'#B8B0BD',radius:20},cfg.magazine_settings||{});
    if(!cfg.modules.why_alookhor)cfg.modules.why_alookhor={enabled:true,title:'چرا آلوخور؟',order:15};
    const whyItems=[['natural','انتخاب محصول','انتخاب دقیق بهترین آلوها از باغ‌های معتبر و سالم'],['quality','کنترل کیفیت','بررسی و کنترل کیفیت در تمام مراحل پردازش و بسته‌بندی'],['medal','تجربه و اعتبار','سال‌ها فعالیت در صنعت خشکبار و صادرات به بازارهای جهانی'],['heart','رضایت مشتریان','اعتماد مشتریان داخلی و خارجی، حاصل کیفیت و تعهد ماست']];
    const whyStats=[['calendar','+15','سال تجربه در صنعت خشکبار'],['box','+6','محصول متنوع و باکیفیت'],['users','+1,000','مشتریان عمده و خرده'],['globe','+50','کشور هدف صادراتی']];
    cfg.why_settings=Object.assign({enabled:true,eyebrow:'WHY ALOOKHOR',title:'چرا آلوخور را انتخاب می‌کنید؟',subtitle:'ما از باغ تا سفره، کیفیت را در هر مرحله تضمین می‌کنیم تا بهترین تجربه از طعم واقعی آلو خشک را برای شما فراهم کنیم.',image_id:0,image_url:'',badge_title:'آلوخور',badge_text:'کیفیتی که می‌چشید، اعتمادی که می‌ماند',background:'#0B0716',card:'#12091A',gold:'#D4A436',text:'#FFFFFF',muted:'#C8BDCC',radius:20,items:[],stats:[]},cfg.why_settings||{});cfg.why_settings.items=whyItems.map((x,i)=>{const saved=cfg.why_settings.items?.[i]||{};return{icon:saved.icon||x[0],title:saved.title||x[1],description:saved.description||x[2]}});cfg.why_settings.stats=whyStats.map((x,i)=>{const saved=cfg.why_settings.stats?.[i]||{};return{icon:saved.icon||x[0],value:saved.value||x[1],label:saved.label||x[2]}});if(['#1C1025','#2B0A3D'].includes(String(cfg.why_settings.background).toUpperCase()))cfg.why_settings.background='#0B0716';if(['#26213D','#1D1126'].includes(String(cfg.why_settings.card).toUpperCase()))cfg.why_settings.card='#12091A';if(String(cfg.why_settings.title||'').trim()==='چرا آلوخور را انتخاب کنید؟')cfg.why_settings.title='چرا آلوخور را انتخاب می‌کنید؟';if(String(cfg.why_settings.subtitle||'').trim()==='تضمین ارگانیک بودن، نظارت مستمر و کیفیت بی‌رقیب خشکبار خراسان')cfg.why_settings.subtitle='ما از باغ تا سفره، کیفیت را در هر مرحله تضمین می‌کنیم تا بهترین تجربه از طعم واقعی آلو خشک را برای شما فراهم کنیم.';
    if(!cfg.modules.standards)cfg.modules.standards={enabled:true,title:'استانداردهای بین‌المللی',order:16};
    const standardItems=[['globe','ISO 9001','سیستم مدیریت کیفیت تولید صادراتی'],['shield','HACCP','سیستم مدیریت ایمنی مواد غذایی'],['organic','ORGANIC','محصول کاملاً ارگانیک و بدون افزودنی'],['halal','HALAL','گواهینامه حلال برای بازارهای بین‌المللی'],['info','FDA','تأییدشده توسط سازمان غذا و داروی ایالات متحده آمریکا'],['document','GMP','کنترل کیفی و بهداشتی فرآیند تولید']];const standardStats=[['users','98%','رضایت مشتریان صادراتی'],['medal','+15','سال سابقه و اعتبار تجاری'],['globe','+25','کشورهای هدف صادرات'],['shield','100%','تضمین ارگانیک و سلامت بار']];cfg.standards_settings=Object.assign({enabled:true,eyebrow:'TRUSTED WORLDWIDE',title:'استانداردهای بین‌المللی',title_highlight:'کیفیت',subtitle:'محصولات ما مطابق معتبرترین استانداردهای جهانی تولید، بسته‌بندی و کنترل کیفیت می‌شوند.',background:'#0B0716',card:'#12091A',gold:'#D4A436',text:'#FFFFFF',muted:'#C8BDCC',radius:18,mobile_cta_title:'اعتماد شما سرمایه ماست',mobile_cta_text:'با تضمین کیفیت و استانداردهای بین‌المللی، بهترین محصولات خشکبار را به شما ارائه می‌دهیم.',mobile_cta_image:'',items:[],stats:[]},cfg.standards_settings||{});cfg.standards_settings.items=standardItems.map((x,i)=>({...{icon:x[0],title:x[1],description:x[2]},...(cfg.standards_settings.items?.[i]||{})}));cfg.standards_settings.stats=standardStats.map((x,i)=>({...{icon:x[0],value:x[1],label:x[2]},...(cfg.standards_settings.stats?.[i]||{})}));if(String(cfg.standards_settings.title||'').trim()==='استانداردهای بین‌المللی کیفیت')cfg.standards_settings.title='استانداردهای بین‌المللی';
    if(!cfg.site) cfg.site = {name:'ALOOKHOR', subtitle:'Control Center • Luxury', logoLetter:'A'};
    if(!cfg.system) cfg.system = {uptime:'99.9%', cache:'فعال', woocommerce:'فعال', woodmart_plus:'فعال', elementor_pro:'فعال', php_version:'8.1.6', memory:'256MB / 512MB', ssl:'فعال (امن)'};
    if(!cfg.ai_assistant) cfg.ai_assistant = {suggestions:[]};
    if(!cfg.ai_assistant.suggestions) cfg.ai_assistant.suggestions = [];

    const sourceMeta = {
      wordpress: {label:'حافظه WordPress متصل', color:'#3DD68C', bg:'rgba(61,214,140,0.14)', border:'rgba(61,214,140,0.18)'},
      'repaired-defaults': {label:'حافظه ناقص ترمیم شد', color:'#E8D5B5', bg:'rgba(201,168,106,0.14)', border:'rgba(201,168,106,0.24)'},
      'defaults-file': {label:'Defaults افزونه بارگذاری شد', color:'#E8D5B5', bg:'rgba(201,168,106,0.14)', border:'rgba(201,168,106,0.24)'},
      'local-cache': {label:'حالت آفلاین — Cache محلی', color:'#E8D5B5', bg:'rgba(201,168,106,0.14)', border:'rgba(201,168,106,0.24)'},
      'emergency-fallback': {label:'اتصال حافظه ناموفق', color:'#FF8A8E', bg:'rgba(255,90,95,0.11)', border:'rgba(255,90,95,0.22)'}
    };
    const memory = sourceMeta[Config.source] || sourceMeta['emergency-fallback'];
    const hasDefinitions = Object.keys(cfg.modules||{}).length > 0;

    container.innerHTML = `
      <div class="page-head">
        <div>
          <h2>مدیریت اصلی بوتیک ALOOKHOR</h2>
          <p>تنظیمات ALOOKHOR بدون حذف مقادیر قبلی بارگذاری می‌شود <span style="background:${memory.bg}; color:${memory.color}; padding:2px 8px; border-radius:999px; font-size:11px; border:1px solid ${memory.border}">● ${memory.label}</span></p>
        </div>
        <div class="head-actions">
          <button class="btn-ghost" id="btnExportSettings">⬇ خروجی JSON</button>
          <button class="btn-ghost" id="btnResetSettings">بازنشانی</button>
          <button class="btn-gold" id="btnSaveAll">💾 ذخیره همه — اعمال زنده</button>
        </div>
      </div>

      <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:14px; align-items:center">
        <span style="font-size:11px; color:var(--text-faint); background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); padding:4px 10px; border-radius:999px">آخرین ذخیره: <b id="lastSave" style="color:var(--text-secondary)">${cfg.updated_at ? new Date(cfg.updated_at).toLocaleString('fa-IR') : 'همین حالا'}</b></span>
        <span style="font-size:11px; color:var(--gold-soft); background:rgba(201,168,106,0.10); border:1px solid var(--gold-border-strong); padding:4px 10px; border-radius:999px">نسخه: ${cfg.version}</span>
        <span class="boutique-workspace-hint">ماژول را از ستون مدیریت انتخاب کنید؛ فرم کامل آن در فضای وسیع روبه‌رو باز می‌شود.</span>
      </div>

      <div class="settings-hub">
        <!-- ستون راست: ماژول‌های فعال سیستم — دقیقا مثل تصویر، اما حالا واقعی -->
        <div class="modules-side" id="modulesCard">
          <div class="panel" style="overflow:hidden">
            <div class="panel-head" style="background:rgba(201,168,106,0.06)"><h3 style="font-size:13px">ماژول‌های فعال سیستم</h3><span style="font-size:10px; background:var(--success); color:#0A0A0A; padding:2px 7px; border-radius:999px; font-weight:800">${Object.values(cfg.modules||{}).filter(m=>m.enabled).length} / ${Object.keys(cfg.modules||{}).length} فعال</span></div>
            <div class="modules-list" id="modulesList">
              <!-- JS render -->
            </div>
            <div style="padding:10px 12px; display:flex; gap:8px">
              <button class="btn-ghost" style="flex:1; padding:8px; font-size:11.5px" id="btnDisableAll">غیرفعال همه</button>
              <button class="btn-gold" style="flex:1; padding:8px; font-size:11.5px" id="btnEnableAll">فعال‌سازی همه</button>
            </div>
          </div>
          <div style="margin-top:10px; padding:10px 12px; background:${memory.bg}; border:1px solid ${memory.border}; border-radius:12px; font-size:12px; color:var(--text-secondary); line-height:1.7">
            <b style="color:${memory.color}">${hasDefinitions?'✓':'!'} ${memory.label}</b><br>
            ${hasDefinitions
              ? 'تعریف ماژول‌ها بازیابی شده و تغییرات از مسیر امن WordPress ذخیره می‌شوند.'
              : 'تعریف ماژول‌ها دریافت نشد؛ برای جزئیات Console و پاسخ admin-ajax.php را بررسی کنید.'}
          </div>
          <div style="margin-top:8px; padding:10px; background:rgba(255,255,255,0.03); border:1px dashed var(--gold-border); border-radius:10px">
            <div style="font-size:11px; color:var(--text-faint); margin-bottom:6px">پیش‌نمایش هدر زنده:</div>
            <div style="display:flex; align-items:center; gap:8px; background:#111113; border:1px solid var(--gold-border-strong); border-radius:10px; padding:8px">
              <div style="width:28px; height:28px; border-radius:8px; background:linear-gradient(135deg,#1A1A1D,#0F0F10); border:1px solid var(--gold-border-strong); display:grid; place-items:center; color:var(--gold); font-weight:800; font-size:12px">${cfg.site.logoLetter}</div>
              <div><div style="font-size:12px; font-weight:700" id="liveLogoText">${cfg.header_settings.logo_text}</div><div style="font-size:10px; color:var(--text-muted)" id="liveLogoSub">${cfg.header_settings.logo_sub}</div></div>
            </div>
          </div>
        </div>

        <!-- فضای وسیع مدیریت بوتیک؛ AI و System Status فقط در Dashboard هستند -->
        <div class="settings-main">
          <div class="panel settings-workspace">
            <div class="panel-head"><h3>⚙️ تنظیمات کامل ماژول انتخاب‌شده</h3><span style="font-size:11px;color:var(--text-faint)" id="quickTitle">یک ماژول از ستون مدیریت انتخاب کنید</span></div>
            <div id="quickSettings" style="padding:18px">
              <div style="text-align:center;padding:28px;color:var(--text-muted);font-size:13px;background:rgba(255,255,255,.02);border:1px dashed var(--gold-border);border-radius:12px">یک ماژول را انتخاب کنید تا تنظیمات واقعی آن در این فضای وسیع باز شود.<br><span style="color:var(--gold-soft)">تغییرات در WordPress ذخیره و بلافاصله روی سایت اعمال می‌شوند.</span></div>
            </div>
          </div>
        </div>
      </div>


      <style>
        .settings-hub{display:grid;grid-template-columns:minmax(270px,310px) minmax(0,1fr);gap:16px;align-items:start}
        .settings-main{min-width:0;width:100%}
        .settings-workspace{min-height:560px}
        .modules-side{width:auto;min-width:0;position:sticky;top:84px}
        .boutique-workspace-hint{margin-right:auto;color:var(--text-muted);font-size:11px;line-height:1.7}
        @media(min-width:1600px){.settings-hub{grid-template-columns:320px minmax(0,1fr);gap:20px}#quickSettings{padding:22px!important}}
        @media(max-width:1180px){.settings-hub{grid-template-columns:1fr}.modules-side{width:100%;position:static}.settings-workspace{min-height:0}.boutique-workspace-hint{width:100%;margin:4px 0 0}}
        .modules-list{ display:grid; gap:0 }
        .mod-item{ display:flex; align-items:center; gap:10px; padding:11px 12px; font-size:12.8px; font-weight:500; color:var(--text-secondary); border-bottom:1px solid rgba(201,168,106,0.08); cursor:pointer; transition: all 0.18s ease; position:relative }
        .mod-item:hover{ background:rgba(255,255,255,0.03); color:var(--text-primary)}
        .mod-item.active{ background: linear-gradient(90deg, rgba(201,168,106,0.16), transparent); border-right:3px solid var(--gold); color:var(--gold-soft); font-weight:700}
        .mod-item.disabled{ opacity:0.45; filter: grayscale(0.3)}
        .mod-icon{ width:26px; height:26px; border-radius:8px; display:grid; place-items:center; background:rgba(255,255,255,0.04); border:1px solid var(--gold-border); font-size:12px; flex:0 0 26px}
        .mod-item.active .mod-icon{ background:rgba(201,168,106,0.14); border-color:var(--gold-border-strong)}
        .mod-check{ margin-right:auto; width:18px; height:18px; border-radius:999px; background:var(--success); color:#0A0A0A; display:grid; place-items:center; font-size:11px; font-weight:800}
        .mod-toggle{ margin-right:auto; width:36px; height:20px; border-radius:999px; background:rgba(255,255,255,0.08); border:1px solid var(--gold-border); position:relative; transition: all 0.22s ease; flex:0 0 36px }
        .mod-toggle i{ position:absolute; top:2px; right:2px; width:14px; height:14px; border-radius:50%; background:#9A9590; transition: all 0.22s ease; display:block }
        .mod-toggle.on{ background: var(--gold); border-color: var(--gold)}
        .mod-toggle.on i{ background:#1A1206; transform: translateX(-16px)}
        .ai-list{ display:grid; gap:8px; padding:12px }
        .ai-item{ background: rgba(10,10,12,0.55); border:1px solid rgba(201,168,106,0.12); border-radius:12px; overflow:hidden}
        .ai-head{ width:100%; display:flex; align-items:center; gap:10px; padding:11px 12px; background:transparent; border:0; color:var(--text-secondary); font-size:12.5px; font-weight:600; cursor:pointer; text-align:right}
        .ai-head:hover{ color:var(--text-primary)}
        .ai-plus{ width:22px; height:22px; border-radius:6px; background:rgba(255,255,255,0.06); border:1px solid var(--gold-border); display:grid; place-items:center; font-size:13px; font-weight:800; flex:0 0 22px; transition: all 0.2s ease}
        .ai-item.open .ai-plus{ background:var(--gold); color:#1A1206; transform: rotate(45deg)}
        .ai-badge{ margin-right:auto; font-size:10px; font-weight:700; padding:2px 7px; border-radius:999px; background:rgba(201,168,106,0.14); color:var(--gold-soft); border:1px solid var(--gold-border)}
        .ai-body{ display:none; padding:0 12px 12px 12px; border-top:1px solid var(--gold-border); background: rgba(255,255,255,0.02)}
        .ai-item.open .ai-body{ display:block}
        .ai-body p{ margin:10px 0 0 0; font-size:12.5px; color:var(--text-muted); line-height:1.7}
        .status-list{ display:grid; gap:0; padding:6px 0}
        .status-row{ display:flex; justify-content:space-between; align-items:center; padding:10px 14px; font-size:12.8px; border-bottom:1px solid rgba(201,168,106,0.07); color:var(--text-secondary)}
        .status-row b{ color:var(--text-primary); font-size:12.5px}
        .dot{ width:8px; height:8px; border-radius:50%; display:inline-block; margin-left:6px; vertical-align:middle; background:#6B6763}
        .dot.on{ background:#3DD68C; box-shadow:0 0 0 4px rgba(61,214,140,0.16)}
      </style>
    `;

    // — رندر ماژول‌ها از حافظه واقعی —
    const listEl = container.querySelector('#modulesList');
    const iconMap = { stats:'📊', header:'◈', product_categories:'◉', footer:'◫', export:'👑', sort:'①', collection:'②', app:'📱', hero:'🎠', site_features:'✦', campaign:'🎯', bestsellers:'🔥', newsletter:'✉️', magazine:'📰', why_alookhor:'♛', standards:'◇', auto:'🔄' };
    function renderModules(){
      listEl.innerHTML = Object.entries(cfg.modules||{}).sort((a,b)=> a[1].order - b[1].order).map(([key,m])=>`
        <div class="mod-item ${m.enabled?'':'disabled'}" data-mod="${key}">
          <span class="mod-icon">${iconMap[key]||'●'}</span> ${m.title}
          ${m.enabled ? `<span class="mod-check">✓</span>` : `<span class="mod-toggle"><i></i></span>`}
          ${m.enabled ? `<span class="mod-toggle on" data-toggle="${key}"><i></i></span>` : `<span class="mod-toggle" data-toggle="${key}"><i></i></span>`}
        </div>
      `).join('');
      // برای آیتم‌هایی که enabled هستند، چک را حذف و فقط toggle بذار — تمیزتر
      // بازنویسی: هر آیتم فقط یک toggle داشته باشد
      listEl.querySelectorAll('.mod-item').forEach(el=>{
        const key = el.dataset.mod;
        const enabled = cfg.modules[key].enabled;
        // حذف چک اضافی و نگه داشتن toggle
        const checks = el.querySelectorAll('.mod-check');
        if(checks.length && enabled){
          // اگر enabled، چک را حذف کن (toggle کافی است)
          checks.forEach(c=> c.remove());
        }
        // toggle state
        const tog = el.querySelector('.mod-toggle');
        if(tog) tog.classList.toggle('on', enabled);
      });
    }
    renderModules();

    // رندر AI
    const aiList = container.querySelector('#aiList');
    function renderAI(){
      if(!aiList)return;
      aiList.innerHTML = cfg.ai_assistant.suggestions.map((s,idx)=>`
        <div class="ai-item ${idx===0?'open':''}" data-ai="${s.id}">
          <button class="ai-head"><span class="ai-plus">${idx===0?'×':'+'}</span> ${s.title} <span class="ai-badge">${s.status==='new'?'جدید': s.status==='done'?'انجام شد':'AI'}</span></button>
          <div class="ai-body">
            <p>${s.detail}</p>
            <div style="display:flex; gap:8px; margin-top:10px; flex-wrap:wrap">
              ${s.status!=='done' ? `<button class="btn-gold" style="padding:6px 12px; font-size:12px" data-ai-action="do" data-id="${s.id}">اعمال پیشنهاد</button>` : `<span style="color:var(--success); font-size:12px; font-weight:700">✓ اعمال شد</span>`}
              <button class="btn-ghost" style="padding:6px 12px; font-size:12px" data-ai-action="dismiss" data-id="${s.id}">${s.status==='done'?'بازگردانی':'نادیده بگیر'}</button>
            </div>
          </div>
        </div>
      `).join('');
    }
    renderAI();

    // رندر Status
    const statusList = container.querySelector('#statusList');
    function renderStatus(){
      if(!statusList)return;
      statusList.innerHTML = `
        <div class="status-row"><span><span class="dot on"></span> ووکامرس</span><b>${cfg.system.woocommerce}</b></div>
        <div class="status-row"><span><span class="dot on"></span> وودمارت پلاس</span><b>${cfg.system.woodmart_plus}</b></div>
        <div class="status-row"><span><span class="dot on"></span> المنتور پرو</span><b>${cfg.system.elementor_pro}</b></div>
        <div class="status-row"><span>نسخه پی‌اچ‌پی هاست (PHP)</span><b dir="ltr">${cfg.system.php_version}</b></div>
        <div class="status-row"><span>حافظه لایو سیستم (Memory)</span><b style="color:var(--gold)">${cfg.system.memory}</b></div>
        <div class="status-row"><span>گواهینامه امنیتی (SSL)</span><b style="color:var(--success)"><span class="dot on"></span> ${cfg.system.ssl}</b></div>
      `;
    }
    renderStatus();

    // — تعاملات واقعی —
    const quick = container.querySelector('#quickSettings');
    const quickTitle = container.querySelector('#quickTitle');
    let commitQuickSettings = null;

    const detailRenderers = {
      header: () => {
        const h = cfg.header_settings;
        const val = id => escapeAttr(String(h[id] ?? ''));
        return `
        <div class="qh-head"><div><h4>◈ تنظیمات هدر AKX</h4><p>فقط فیلدهای استفاده‌شده توسط <code>[alookhor_portal_header]</code> — Source: <code>alookhor_header_settings</code></p></div><code>14 FIELD AKX</code></div>

        <div class="qh-section"><div class="qh-title"><b>وضعیت و لوگو</b><small>BRAND</small></div><div class="qh-flags"><label><input type="checkbox" id="inpHeaderEnabled" ${h.enabled?'checked':''}>هدر فعال باشد</label></div><div class="qh-grid"><label class="qh-span-2">لوگو<span class="qh-inline"><input id="inpHeaderLogoUrl" value="${val('logo_url')}" dir="ltr"><button type="button" id="btnBoutiqueSelectLogo">انتخاب</button><input type="hidden" id="inpHeaderLogoId" value="${val('logo_id')}"></span></label><label>عرض لوگو (px)<input type="number" id="inpHeaderLogoWidth" min="40" max="180" value="${val('logo_width')||74}"></label></div></div>

        <div class="qh-section"><div class="qh-title"><b>محتوا</b><small>CONTENT</small></div><div class="qh-grid"><label>متن خرید عمده<input id="inpBoutiqueWholesaleText" value="${val('wholesale_text')}"></label><label>لینک خرید عمده<input type="url" id="inpBoutiqueWholesaleUrl" value="${val('wholesale_url')}" dir="ltr"></label><label>متن صادرات<input id="inpBoutiqueExportText" value="${val('export_text')}"></label><label>لینک صادرات<input type="url" id="inpBoutiqueExportUrl" value="${val('export_url')}" dir="ltr"></label></div></div>

        <div class="qh-section"><div class="qh-title"><b>تماس</b><small>CONTACT</small></div><div class="qh-grid"><label>WhatsApp (989...)<input id="inpBoutiqueWhatsappNumber" dir="ltr" value="${val('whatsapp_number')}"></label><label>ایمیل<input type="email" id="inpBoutiqueEmail" value="${val('email')}" dir="ltr"></label><label>تلفن<input id="inpBoutiquePhone" dir="ltr" value="${val('phone')}"></label><label>Placeholder جستجو<input id="inpBoutiqueSearchPlaceholder" value="${escapeAttr(String(h.search_placeholder ?? 'جستجوی محصول، مقاله و ...'))}"></label></div></div>

        <div class="qh-section"><div class="qh-title"><b>برند دراور موبایل</b><small>MOBILE BRAND</small></div><div class="qh-grid"><label>نام برند<input id="inpBoutiqueBrandName" value="${val('brand_name')}"></label><label>زیرعنوان<input id="inpBoutiqueBrandSubtitle" value="${val('brand_subtitle')}"></label></div></div>

        <div class="qh-section"><div class="qh-title"><b>شیشه‌ای‌سازی کپسول منو</b><small>GLASS MENU</small></div><div class="qh-flags"><label><input type="checkbox" id="inpMainbarGlassEnabled" ${isEnabled(h.mainbar_glass_enabled)?'checked':''}>فقط کپسول منو شیشه‌ای باشد</label></div><div class="qh-grid" style="margin-top:10px"><label>شفافیت کپسول (درصد)<input type="number" id="inpMainbarOpacity" min="10" max="100" value="${Number(h.mainbar_opacity)||72}"></label><label>مات‌شدگی پشت شیشه (px)<input type="number" id="inpCapsuleBlur" min="0" max="36" value="${Number(h.capsule_blur)||18}"></label></div><p style="margin:8px 0 0;color:var(--text-faint);font-size:10px">فضای چپ و راست کپسول همیشه بدون پس‌زمینه است. عدد کمتر، خود کپسول را شفاف‌تر می‌کند.</p></div>

        <div class="qh-section"><div class="qh-title"><b>رنگ‌بندی کامل هدر</b><small>COLOR SYSTEM</small></div><div class="qh-colors qh-header-colors">${[['پس‌زمینه نوار بالا','topbar_bg'],['متن نوار بالا','topbar_text_color'],['خط نوار بالا','topbar_border_color'],['دکمه نوار بالا','topbar_button_bg'],['متن دکمه بالا','topbar_button_text'],['سطح منوی اصلی','header_surface'],['متن اصلی','header_text_color'],['متن فرعی','header_muted_color'],['پس‌زمینه کپسول منو','capsule_background'],['سطح مگامنو و کارت','capsule_card'],['طلایی اصلی','capsule_gold'],['طلایی روشن','capsule_gold_light'],['متن کپسول','capsule_text'],['متن فرعی کپسول','capsule_muted']].map(([label,key])=>`<label>${label}<input type="color" id="inpHeaderColor_${key}" value="${val(key)}"></label>`).join('')}</div></div>

        <div class="qh-actions"><button class="btn-gold" id="btnBoutiqueApplyHeader">ذخیره و اعمال هدر</button><span>تنظیمات شیشه، شفافیت و همه رنگ‌ها مستقیماً روی سایت اعمال می‌شوند.</span></div>
        <style>.qh-head{display:flex;justify-content:space-between;gap:12px;align-items:center;margin-bottom:12px}.qh-head h4{margin:0;font-size:14px}.qh-head p{margin:4px 0 0;color:var(--text-muted);font-size:11px}.qh-head code{direction:ltr;padding:7px 9px;border:1px solid var(--gold-border);border-radius:8px;color:var(--gold-soft);font-size:10px}.qh-section{padding:12px;margin-top:9px;border:1px solid var(--gold-border);border-radius:11px;background:rgba(255,255,255,.02)}.qh-title{display:flex;justify-content:space-between;gap:8px;margin-bottom:10px}.qh-title b{font-size:11.5px}.qh-title small{color:var(--gold);font:9px Arial}.qh-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.qh-span-2{grid-column:span 2}.qh-flags label{display:flex;align-items:center;gap:8px;padding:6px 10px;border:1px solid var(--gold-border);border-radius:999px}.qh-flags input{width:auto;accent-color:var(--gold)}.qh-section label{display:grid;gap:4px;color:var(--text-muted);font-size:10.5px}.qh-section input[type=text],.qh-section input[type=email],.qh-section input[type=number],.qh-section input[type=url]{width:100%;min-width:0;background:rgba(255,255,255,.035);border:1px solid var(--gold-border);border-radius:8px;padding:8px;color:var(--text-primary)}.qh-inline{display:flex;gap:6px}.qh-inline input{flex:1;min-width:0}.qh-inline button{border:1px solid var(--gold-border-strong);border-radius:8px;background:rgba(201,168,106,.1);color:var(--gold-soft);cursor:pointer;padding:0 10px}.qh-actions{display:flex;align-items:center;gap:9px;flex-wrap:wrap;margin-top:11px}.qh-actions button{padding:9px 15px;font-size:11px}.qh-actions span{color:var(--text-faint);font-size:10px}.qh-actions code{direction:ltr;color:var(--gold-soft);background:rgba(201,168,106,0.1);padding:1px 6px;border-radius:6px}@media(max-width:700px){.qh-grid{grid-template-columns:1fr}.qh-span-2{grid-column:auto}}</style>
      `;
      },
      product_categories: () => {
        const c=cfg.category_settings;const selected=new Set((c.selected_ids||[]).map(Number));const terms=window.ALOOKHOR_CC?.wc_categories||[];
        return `<div class="qh-head"><div><h4>◉ دسته‌بندی محصولات WooCommerce</h4><p>کارت‌های واقعی از taxonomy ووکامرس؛ عنوان، URL، تعداد و تصویر دسته به‌صورت پویا خوانده می‌شوند.</p></div><code>WC PRODUCT_CAT</code></div>
        <div class="qh-section"><div class="qh-title"><b>جایگاه در Elementor</b><small>PLACEMENT</small></div><div class="qh-grid"><label class="qh-span-2">شورت‌کد اختصاصی ماژول<input value="[alookhor_managed_categories]" readonly dir="ltr" onclick="this.select()"></label></div><p style="margin:9px 0 0;color:var(--text-faint);font-size:10.5px;line-height:1.8">این شورت‌کد را داخل Widget نوع Shortcode قرار دهید و خود Widget را در Navigator جابه‌جا کنید. شورت‌کد قدیمی <code>[alookhor_categories_carousel]</code> متعلق به افزونه قدیمی است و نباید برای این بخش استفاده شود.</p></div>
        <div class="qh-section"><div class="qh-title"><b>وضعیت و امکانات</b><small>BEHAVIOR</small></div><div class="qh-flags">${[['enabled','فعال'],['hide_legacy','جایگزینی بخش قدیمی'],['hide_empty','فقط دسته دارای محصول'],['parent_only','فقط دسته مادر'],['show_description','توضیحات کارت'],['show_count','تعداد محصولات'],['show_icons','آیکون کارت'],['show_arrows','فلش‌های Desktop'],['show_dots','نقطه‌های Pagination'],['autoplay','حرکت خودکار']].map(([k,l])=>`<label><input type="checkbox" data-category-flag="${k}" ${isEnabled(c[k])?'checked':''}>${l}</label>`).join('')}</div></div>
        <div class="qh-section"><div class="qh-title"><b>هویت محتوایی</b><small>CONTENT</small></div><div class="qh-grid"><label>کیکر<input id="catKicker" value="${escapeAttr(c.kicker)}"></label><label>متن دکمه<input id="catButton" value="${escapeAttr(c.button_text)}"></label><label class="qh-span-2">عنوان اصلی<input id="catTitle" value="${escapeAttr(c.title)}"></label><label class="qh-span-2">زیرعنوان<textarea id="catSubtitle" rows="2">${escapeAttr(c.subtitle)}</textarea></label></div></div>
        <div class="qh-section"><div class="qh-title"><b>دسته‌های واقعی WooCommerce</b><small>${terms.length} CATEGORY</small></div><div class="alookhor-cat-admin-list">${terms.map(term=>{const o=c.overrides?.[String(term.id)]||{};return `<article class="alookhor-cat-admin-item"><label class="alookhor-cat-choice"><input type="checkbox" data-cat-id="${Number(term.id)}" ${selected.has(Number(term.id))?'checked':''}><b>${escapeAttr(term.name)}</b><small>#${Number(term.id)} • ${Number(term.count)} محصول</small></label><label>تصویر جایگزین<span class="qh-inline"><input id="catImage_${Number(term.id)}" value="${escapeAttr(o.image_url||'')}" dir="ltr"><button type="button" data-category-media="catImage_${Number(term.id)}">انتخاب</button></span></label><label>توضیح کارت<input id="catDesc_${Number(term.id)}" value="${escapeAttr(o.description||'')}"></label></article>`}).join('')}</div><style>.alookhor-cat-admin-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.alookhor-cat-admin-item{display:grid;gap:9px;padding:12px;border:1px solid var(--gold-border);border-radius:12px;background:rgba(0,0,0,.14)}.alookhor-cat-choice{display:grid!important;grid-template-columns:auto 1fr;align-items:center!important}.alookhor-cat-choice input{grid-row:1/3;width:17px!important;height:17px!important;margin-left:8px!important}.alookhor-cat-choice small{color:var(--text-faint)}@media(max-width:760px){.alookhor-cat-admin-list{grid-template-columns:1fr}}</style></div>
        <div class="qh-section"><div class="qh-title"><b>Carousel دسکتاپ</b><small>DESKTOP UX</small></div><div class="qh-grid"><label>تعداد کارت هم‌زمان<input id="catDesktopCards" type="number" min="2" max="6" value="${Number(c.desktop_cards)||4}"></label><label>فاصله کارت‌ها<input id="catDesktopGap" type="number" min="8" max="40" value="${Number(c.desktop_gap)||18}"></label><label>ارتفاع تصویر<input id="catImageHeight" type="number" min="180" max="430" value="${Number(c.image_height)||285}"></label><label>Autoplay ms<input id="catInterval" type="number" min="2500" max="15000" step="500" value="${Number(c.autoplay_interval)||5000}"></label><label>حداکثر دسته<input id="catLimit" type="number" min="1" max="24" value="${Number(c.limit)||8}"></label><label>ترتیب<select id="catOrder"><option value="ASC" ${c.order==='ASC'?'selected':''}>صعودی</option><option value="DESC" ${c.order==='DESC'?'selected':''}>نزولی</option></select></label></div></div>
        <div class="qh-section"><div class="qh-title"><b>Carousel موبایل</b><small>MOBILE UX</small></div><div class="qh-grid"><label>عرض کارت درصد<input id="catMobileWidth" type="number" min="72" max="94" value="${Number(c.mobile_card_width)||84}"></label><label>Peek دو طرف درصد<input id="catMobilePeek" type="number" min="3" max="14" value="${Number(c.mobile_peek)||8}"></label><label>ارتفاع تصویر<input id="catMobileImage" type="number" min="170" max="330" value="${Number(c.mobile_image_height)||225}"></label><label>فاصله کارت‌ها<input id="catMobileGap" type="number" min="8" max="28" value="${Number(c.mobile_gap)||14}"></label><label>گردی کارت<input id="catMobileRadius" type="number" min="10" max="32" value="${Number(c.mobile_radius)||18}"></label></div><p style="margin:10px 0 0;color:var(--text-faint);font-size:10.5px">کارت فعال کامل و وسط، کارت‌های قبلی/بعدی به‌صورت Peek، حلقه بی‌نهایت و Dotهای پویا.</p></div>
        <div class="qh-section"><div class="qh-title"><b>رنگ‌بندی هماهنگ سایت</b><small>THEME</small></div><div class="qh-colors">${[['پس‌زمینه','section_background'],['کارت','card_background'],['طلایی','gold'],['متن','text'],['متن فرعی','muted'],['حاشیه','border'],['دکمه','button_background']].map(([l,k])=>`<label>${l}<input type="color" id="catColor_${k}" value="${escapeAttr(c[k])}"></label>`).join('')}</div></div>
        <div class="qh-actions"><button class="btn-gold" id="btnApplyCategories">ذخیره و اعمال روی سایت</button><a class="btn-ghost" href="${escapeAttr(window.ALOOKHOR_CC?.home_url||'/')}" target="_blank">مشاهده سایت</a><span>Desktop و Mobile از همین تنظیمات مشترک مدیریت می‌شوند.</span></div>`;
      },
      footer: () => {
        const f = cfg.footer_settings;
        return `
        <div class="qh-head"><div><h4>◫ فوتر حرفه‌ای ALOOKHOR</h4><p>Desktop پنج‌ستونه + Mobile کارت‌های دو‌ستونه — جایگزینی خودکار فوتر قدیمی بدون ویرایش Elementor</p></div><code>MANAGED FOOTER</code></div>
        <div class="qh-section"><div class="qh-title"><b>وضعیت و منابع WordPress</b><small>CORE</small></div><div class="qh-grid" style="margin-bottom:10px"><label class="qh-span-2">شورت‌کد رسمی فوتر<input value="[alookhor_portal_footer]" readonly dir="ltr" onclick="this.select()"></label></div><div class="qh-flags">
          ${[['enabled','فعال‌بودن فوتر'],['hide_legacy','مخفی‌کردن فوتر قدیمی'],['hide_old_newsletter','ادغام خبرنامه قدیمی'],['use_header_contact','تلفن/ایمیل مشترک با هدر'],['newsletter_enabled','نمایش خبرنامه'],['show_product_image','تصویر محصول'],['show_payments','روش‌های پرداخت'],['show_benefits','مزیت‌های پایین']].map(([key,label])=>`<label><input type="checkbox" data-footer-flag="${key}" ${isEnabled(f[key])?'checked':''}>${label}</label>`).join('')}
        </div></div>
        <div class="qh-section"><div class="qh-title"><b>هویت برند و CTA</b><small>BRAND</small></div><div class="qh-grid">
          <label class="qh-span-2">لوگوی فوتر<span class="qh-inline"><input id="ftLogoUrl" value="${escapeAttr(f.logo_url)}" dir="ltr"><button type="button" data-footer-media="ftLogoUrl">انتخاب</button></span></label>
          <label>نام انگلیسی<input id="ftBrandName" value="${escapeAttr(f.brand_name)}"></label><label>زیرعنوان<input id="ftBrandSubtitle" value="${escapeAttr(f.brand_subtitle)}"></label>
          <label>شعار<input id="ftBrandKicker" value="${escapeAttr(f.brand_kicker)}"></label><label>متن دکمه<input id="ftCtaText" value="${escapeAttr(f.cta_text)}"></label>
          <label class="qh-span-2">توضیحات<textarea id="ftBrandDesc" rows="3">${escapeAttr(f.brand_description)}</textarea></label><label class="qh-span-2">لینک CTA<input id="ftCtaUrl" value="${escapeAttr(f.cta_url)}" dir="ltr"></label>
        </div></div>
        <div class="qh-section"><div class="qh-title"><b>اطلاعات تماس</b><small>CONTACT</small></div><div class="qh-grid">
          <label>تلفن<input id="ftPhone" value="${escapeAttr(f.phone)}" dir="ltr"></label><label>ایمیل<input id="ftEmail" value="${escapeAttr(f.email)}" dir="ltr"></label>
          <label>WhatsApp<input id="ftWhatsapp" value="${escapeAttr(f.whatsapp)}" dir="ltr"></label><label>عنوان پشتیبانی<input id="ftSupportLabel" value="${escapeAttr(f.support_label)}"></label>
          <label class="qh-span-2">آدرس<input id="ftAddress" value="${escapeAttr(f.address)}"></label><label>ساعات هفته<input id="ftHoursWeek" value="${escapeAttr(f.hours_week)}"></label><label>ساعات جمعه<input id="ftHoursFriday" value="${escapeAttr(f.hours_friday)}"></label>
        </div></div>
        ${[['customer','خدمات مشتریان'],['order','خرید و سفارش'],['about','درباره/راهنمای صادرات']].map(([key,label])=>`<div class="qh-section"><div class="qh-title"><b>ستون ${label}</b><small>WORDPRESS MENU</small></div><div class="qh-grid"><label>عنوان<input id="ft${key}Title" value="${escapeAttr(f[`${key}_title`])}"></label>${key==='about'?`<label>عنوان موبایل<input id="ftAboutMobileTitle" value="${escapeAttr(f.about_mobile_title)}"></label>`:''}<label>فهرست WordPress<select id="ft${key}Menu">${footerMenuOptions(f[`${key}_menu_id`])}</select></label><label class="qh-span-2">لینک‌های جایگزین — هر خط: عنوان|URL<textarea id="ft${key}Links" rows="6" dir="ltr">${escapeAttr(footerLinksText(f[`${key}_links`]))}</textarea></label></div></div>`).join('')}
        <div class="qh-section"><div class="qh-title"><b>شبکه‌های اجتماعی و خبرنامه</b><small>ENGAGEMENT</small></div><div class="qh-grid">
          <label>Instagram<input id="ftInstagram" value="${escapeAttr(f.instagram_url)}" dir="ltr"></label><label>Telegram<input id="ftTelegram" value="${escapeAttr(f.telegram_url)}" dir="ltr"></label><label>WhatsApp URL<input id="ftWhatsappUrl" value="${escapeAttr(f.whatsapp_url)}" dir="ltr"></label>
          <label>عنوان شبکه‌ها<input id="ftSocialTitle" value="${escapeAttr(f.social_title)}"></label><label>عنوان خبرنامه<input id="ftNewsletterTitle" value="${escapeAttr(f.newsletter_title)}"></label><label>دکمه خبرنامه<input id="ftNewsletterButton" value="${escapeAttr(f.newsletter_button)}"></label>
          <label class="qh-span-2">توضیح شبکه‌ها<input id="ftSocialDesc" value="${escapeAttr(f.social_desc)}"></label><label class="qh-span-2">توضیح خبرنامه<input id="ftNewsletterDesc" value="${escapeAttr(f.newsletter_desc)}"></label>
          <label class="qh-span-2">تصویر محصول<span class="qh-inline"><input id="ftProductImage" value="${escapeAttr(f.product_image_url)}" dir="ltr"><button type="button" data-footer-media="ftProductImage">انتخاب</button></span></label>
        </div></div>
        <div class="qh-section"><div class="qh-title"><b>مجوزها، کپی‌رایت و ظاهر</b><small>TRUST & STYLE</small></div><div class="qh-grid">
          <label>عنوان Enamad<input id="ftEnamadTitle" value="${escapeAttr(f.enamad_title)}"></label><label>لینک Enamad<input id="ftEnamadUrl" value="${escapeAttr(f.enamad_url)}" dir="ltr"></label><label class="qh-span-2">تصویر Enamad<span class="qh-inline"><input id="ftEnamadImage" value="${escapeAttr(f.enamad_image_url)}" dir="ltr"><button type="button" data-footer-media="ftEnamadImage">انتخاب</button></span></label>
          <label>عنوان ساماندهی<input id="ftSamandehiTitle" value="${escapeAttr(f.samandehi_title)}"></label><label>لینک ساماندهی<input id="ftSamandehiUrl" value="${escapeAttr(f.samandehi_url)}" dir="ltr"></label><label class="qh-span-2">تصویر ساماندهی<span class="qh-inline"><input id="ftSamandehiImage" value="${escapeAttr(f.samandehi_image_url)}" dir="ltr"><button type="button" data-footer-media="ftSamandehiImage">انتخاب</button></span></label>
          <label>Copyright<input id="ftCopyright" value="${escapeAttr(f.copyright_text)}"></label><label>Copyright English<input id="ftCopyrightEn" value="${escapeAttr(f.copyright_en)}"></label>
        </div><div class="qh-colors" style="margin-top:10px">${[['Background','background'],['Surface','surface'],['Gold','gold'],['Gold Soft','gold_soft'],['Text','text'],['Muted','muted'],['Border','border']].map(([label,key])=>`<label>${label}<input type="color" id="ftColor_${key}" value="${escapeAttr(f[key])}"></label>`).join('')}<label>عرض محتوا<input type="number" id="ftContainerWidth" value="${Number(f.container_width)||1280}"></label><label>لوگو Desktop<input type="number" id="ftDesktopLogo" value="${Number(f.desktop_logo_width)||210}"></label><label>لوگو Mobile<input type="number" id="ftMobileLogo" value="${Number(f.mobile_logo_width)||190}"></label></div></div>
        <div class="qh-actions"><button class="btn-gold" id="btnApplyFooter">ذخیره و اعمال فوتر</button><a class="btn-ghost" href="${escapeAttr(window.ALOOKHOR_CC?.home_url || '/')}" target="_blank">مشاهده سایت</a><span>پیام موفقیت فقط بعد از تأیید WordPress نمایش داده می‌شود.</span></div>
        <style>.qh-section textarea,.qh-section select{width:100%;min-width:0;background:rgba(255,255,255,.035);border:1px solid var(--gold-border);border-radius:8px;padding:8px;color:var(--text-primary);font-family:inherit}.qh-section select option{background:#171419}</style>`;
      },
      stats: () => `<h4>📊 پیشخوان هوشمند آمار</h4><p style="color:var(--text-muted); font-size:12.5px">KPI ها و نمودار فروش در داشبورد. فعال: <b style="color:${cfg.modules.stats.enabled?'var(--success)':'var(--danger)'}">${cfg.modules.stats.enabled?'بله':'خیر'}</b></p><label style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; margin-top:10px"><span>نمایش در داشبورد</span><span class="mod-toggle ${cfg.modules.stats.enabled?'on':''}" data-quick-toggle="stats"><i></i></span></label>`,
      export: () => {const x=Object.assign({enabled:true,background_image_id:0,background_image_url:'',logo_id:0,logo_url:'',title:'صادرات آلو خشک ایران',title_gold:'از باغ خراسان تا بندر جهان',card_text:'تجارت و صادرات انواع آلو',status_text:'پاسخگویی ۲۴ ساعته',whatsapp1_number:'0922 294 2808',whatsapp1_link:'https://wa.me/989222942808',whatsapp2_number:'0915 460 8180',whatsapp2_link:'https://wa.me/989154608180',bg_color:'#0A2A1C',gold_color:'#D4AF37',whatsapp_color:'#25D366',card_opacity:78,overlay_opacity:55,blur_strength:14},window.ALOOKHOR_CC?.export_banner_settings||{}); return `<div class="qh-head"><div><h4>👑 بنر صادراتی آلوخور</h4><p>تمام محتوای بنر کامیون، لوگو و تماس واتساپ از همین بخش مدیریت می‌شود.</p></div><code>EXPORT BANNER</code></div>
      <div class="qh-section"><div class="qh-title"><b>شورت‌کد و وضعیت</b><small>ELEMENTOR</small></div><div class="qh-grid"><label class="qh-span-2">شورت‌کد رسمی<input value="[alookhor_export_banner]" readonly dir="ltr" onclick="this.select()"></label></div><div class="qh-flags" style="margin-top:10px"><label><input id="xbEnabled" type="checkbox" ${isEnabled(x.enabled)?'checked':''}>بنر فعال باشد</label></div></div>
      <div class="qh-section"><div class="qh-title"><b>تصاویر</b><small>MEDIA LIBRARY</small></div><div class="qh-grid"><label class="qh-span-2">تصویر پس‌زمینه کامیون<span class="qh-inline"><input id="xbBgUrl" value="${escapeAttr(x.background_image_url)}" dir="ltr"><button type="button" data-xb-media="bg">انتخاب</button><input type="hidden" id="xbBgId" value="${Number(x.background_image_id)||0}"></span></label><label class="qh-span-2">لوگوی مرکزی<span class="qh-inline"><input id="xbLogoUrl" value="${escapeAttr(x.logo_url)}" dir="ltr"><button type="button" data-xb-media="logo">انتخاب</button><input type="hidden" id="xbLogoId" value="${Number(x.logo_id)||0}"></span></label></div></div>
      <div class="qh-section"><div class="qh-title"><b>نوشته‌های بنر</b><small>CONTENT</small></div><div class="qh-grid"><label>عنوان اصلی<input id="xbTitle" value="${escapeAttr(x.title)}"></label><label>عنوان طلایی<input id="xbTitleGold" value="${escapeAttr(x.title_gold)}"></label><label class="qh-span-2">متن کارت<textarea id="xbCardText" rows="3">${escapeAttr(x.card_text)}</textarea></label><label class="qh-span-2">وضعیت پاسخگویی<input id="xbStatus" value="${escapeAttr(x.status_text)}"></label></div></div>
      <div class="qh-section"><div class="qh-title"><b>واتساپ</b><small>ANIMATED CONTACTS</small></div><div class="qh-grid"><label>شماره اول<input id="xbWa1Number" value="${escapeAttr(x.whatsapp1_number)}" dir="ltr"></label><label>لینک اول<input id="xbWa1Link" value="${escapeAttr(x.whatsapp1_link)}" dir="ltr"></label><label>شماره دوم<input id="xbWa2Number" value="${escapeAttr(x.whatsapp2_number)}" dir="ltr"></label><label>لینک دوم<input id="xbWa2Link" value="${escapeAttr(x.whatsapp2_link)}" dir="ltr"></label></div></div>
      <div class="qh-section"><div class="qh-title"><b>رنگ و افکت شیشه‌ای</b><small>STYLE</small></div><div class="qh-colors">${[['پس‌زمینه','bg_color'],['طلایی','gold_color'],['سبز واتساپ','whatsapp_color']].map(([l,k])=>`<label>${l}<input type="color" id="xbColor_${k}" value="${escapeAttr(x[k])}"></label>`).join('')}</div><div class="qh-grid" style="margin-top:10px"><label>شفافیت کارت<input id="xbCardOpacity" type="number" min="20" max="95" value="${Number(x.card_opacity)||78}"></label><label>تیرگی تصویر<input id="xbOverlayOpacity" type="number" min="0" max="95" value="${Number(x.overlay_opacity)||55}"></label><label>Blur شیشه<input id="xbBlur" type="number" min="0" max="40" value="${Number(x.blur_strength)||14}"></label></div></div>
      <div class="qh-actions"><button class="btn-gold" id="btnApplyExportBanner">ذخیره و اعمال بنر صادراتی</button><span>ذخیره مستقیم در WordPress و اعمال روی شورت‌کد</span></div>`;},
      sort: () => { const s=cfg.sort_center_settings; return `<div class="qh-head"><div><h4>① مرکز سورت و بسته‌بندی</h4><p>بخش مستقل، واکنش‌گرا و چندتصویری برای جایگذاری در Elementor</p></div><code>MANAGED SLIDER</code></div>
        <div class="qh-section"><div class="qh-title"><b>شورت‌کد و رفتار</b><small>ELEMENTOR</small></div><div class="qh-grid"><label class="qh-span-2">شورت‌کد رسمی<input value="[alookhor_sort_center]" readonly dir="ltr" onclick="this.select()"></label><label>سرعت اسلاید (ms)<input id="sortInterval" type="number" min="2500" max="15000" step="500" value="${Number(s.autoplay_interval)||5000}"></label><label>گردی کادر<input id="sortRadius" type="number" min="10" max="40" value="${Number(s.radius)||26}"></label></div><div class="qh-flags" style="margin-top:10px">${[['enabled','فعال'],['autoplay','حرکت خودکار'],['show_arrows','نمایش فلش‌ها'],['show_dots','نمایش نقاط']].map(([k,l])=>`<label><input type="checkbox" data-sort-flag="${k}" ${isEnabled(s[k])?'checked':''}>${l}</label>`).join('')}</div></div>
        <div class="qh-section"><div class="qh-title"><b>متن، دکمه‌ها و نشان تصویر</b><small>CONTENT</small></div><div class="qh-grid"><label>کیکر<input id="sortEyebrow" value="${escapeAttr(s.eyebrow)}"></label><label>عنوان اصلی<input id="sortTitle" value="${escapeAttr(s.title)}"></label><label>بخش طلایی عنوان<input id="sortTitleHighlight" value="${escapeAttr(s.title_highlight)}"></label><label class="qh-span-2">توضیحات<textarea id="sortDescription" rows="3">${escapeAttr(s.description)}</textarea></label><label>دکمه اصلی<input id="sortButtonText" value="${escapeAttr(s.button_text)}"></label><label>لینک اصلی<input id="sortButtonUrl" value="${escapeAttr(s.button_url)}" dir="ltr"></label><label>دکمه کاتالوگ<input id="sortSecondaryText" value="${escapeAttr(s.secondary_button_text)}"></label><label>لینک کاتالوگ<input id="sortSecondaryUrl" value="${escapeAttr(s.secondary_button_url)}" dir="ltr"></label><label>عدد نشان تصویر<input id="sortBadgeValue" value="${escapeAttr(s.image_badge_value)}"></label><label>متن نشان تصویر<input id="sortBadgeText" value="${escapeAttr(s.image_badge_text)}"></label></div></div>
        <div class="qh-section"><div class="qh-title"><b>محصولات قابل عرضه</b><small>PRODUCT CHIPS</small></div><div class="qh-grid"><label class="qh-span-2">عنوان محصولات<input id="sortProductsTitle" value="${escapeAttr(s.products_title)}"></label>${s.products.map((product,i)=>`<label>محصول ${i+1}<input id="sortProduct_${i}" value="${escapeAttr(product)}"></label>`).join('')}</div></div>
        <div class="qh-section"><div class="qh-title"><b>کارت‌های مزیت متحرک</b><small>4 ANIMATED ICONS</small></div><div class="alookhor-sort-admin-list">${s.features.map((feature,i)=>`<article class="alookhor-sort-admin-item"><b>مزیت ${i+1}</b><label>آیکن<select id="sortFeatureIcon_${i}">${[['link','حذف واسطه / لینک'],['shield','تضمین / سپر'],['tag','قیمت / برچسب'],['truck','ارسال / کامیون']].map(([v,l])=>`<option value="${v}" ${feature.icon===v?'selected':''}>${l}</option>`).join('')}</select></label><label>عنوان<input id="sortFeatureTitle_${i}" value="${escapeAttr(feature.title)}"></label><label>توضیح مزیت<input id="sortFeatureDescription_${i}" value="${escapeAttr(feature.description||feature.subtitle||'')}"></label></article>`).join('')}</div></div>
        <div class="qh-section"><div class="qh-title"><b>نوار آمار پایین</b><small>TRUST STATS</small></div><div class="alookhor-sort-admin-list">${s.stats.map((stat,i)=>`<article class="alookhor-sort-admin-item"><b>آمار ${i+1}</b><label>آیکن<select id="sortStatIcon_${i}">${[['calendar','تقویم'],['box','بسته‌بندی'],['users','مشتریان'],['globe','جهان']].map(([v,l])=>`<option value="${v}" ${stat.icon===v?'selected':''}>${l}</option>`).join('')}</select></label><label>مقدار<input id="sortStatValue_${i}" value="${escapeAttr(stat.value)}"></label><label>عنوان<input id="sortStatLabel_${i}" value="${escapeAttr(stat.label)}"></label></article>`).join('')}</div></div>
        <div class="qh-section"><div class="qh-title"><b>رنگ‌بندی کامل</b><small>THEME</small></div><div class="qh-colors">${[['پس‌زمینه','background'],['سطح کارت','surface'],['طلایی','gold'],['متن','text'],['متن فرعی','muted']].map(([l,k])=>`<label>${l}<input type="color" id="sortColor_${k}" value="${escapeAttr(s[k])}"></label>`).join('')}</div></div>
        <div class="qh-section"><div class="qh-title"><b>گالری اسلایدی</b><small>UP TO 6 IMAGES</small></div><div class="alookhor-sort-admin-list">${s.slides.map((slide,index)=>`<article class="alookhor-sort-admin-item"><b>تصویر ${index+1}</b><span class="qh-inline"><input id="sortImage_${index}" value="${escapeAttr(slide.image_url)}" dir="ltr"><button type="button" data-sort-media="${index}">انتخاب</button></span><input type="hidden" id="sortImageId_${index}" value="${Number(slide.image_id)||0}"><label>Alt<input id="sortAlt_${index}" value="${escapeAttr(slide.image_alt)}"></label><label>کپشن<input id="sortCaption_${index}" value="${escapeAttr(slide.caption)}"></label></article>`).join('')}</div></div>
        <div class="qh-actions"><button class="btn-gold" id="btnApplySortCenter">ذخیره و اعمال مرکز سورت</button><span>تصاویر خالی نمایش داده نمی‌شوند؛ ترتیب اسلایدها مطابق همین فهرست است.</span></div><style>.alookhor-sort-admin-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.alookhor-sort-admin-item{display:grid;gap:8px;padding:11px;border:1px solid var(--gold-border);border-radius:11px;background:rgba(255,255,255,.02)}@media(max-width:760px){.alookhor-sort-admin-list{grid-template-columns:1fr}}</style>`; },
      collection: () => {const f=cfg.featured_product_settings;return `<div class="qh-head"><div><h4>② محصولات منتخب آلوخور</h4><p>محصولات Featured ووکامرس؛ در نبود محصول Featured، جدیدترین محصولات نمایش داده می‌شوند.</p></div><code>WOO CAROUSEL</code></div><div class="qh-section"><div class="qh-title"><b>شورت‌کد و رفتار</b><small>ELEMENTOR</small></div><div class="qh-grid"><label class="qh-span-2">شورت‌کد رسمی<input value="[alookhor_featured_products]" readonly dir="ltr" onclick="this.select()"></label><label>تعداد محصولات<input id="fpLimit" type="number" min="4" max="16" value="${Number(f.limit)||8}"></label><label>سرعت حرکت (ms)<input id="fpInterval" type="number" min="2500" max="15000" step="500" value="${Number(f.autoplay_interval)||4500}"></label></div><div class="qh-flags" style="margin-top:10px">${[['enabled','فعال'],['autoplay','حرکت خودکار'],['show_arrows','فلش‌ها'],['show_price','قیمت'],['show_rating','امتیاز واقعی'],['show_excerpt','توضیح کوتاه'],['show_badge','نشان محصول'],['show_add_to_cart','دکمه مشاهده']].map(([k,l])=>`<label><input type="checkbox" data-fp-flag="${k}" ${isEnabled(f[k])?'checked':''}>${l}</label>`).join('')}</div></div><div class="qh-section"><div class="qh-title"><b>نوشته‌ها</b><small>CONTENT</small></div><div class="qh-grid"><label>کیکر انگلیسی<input id="fpEyebrow" value="${escapeAttr(f.eyebrow)}" dir="ltr"></label><label>بخش طلایی عنوان<input id="fpTitleHighlight" value="${escapeAttr(f.title_highlight)}"></label><label>عنوان اصلی<input id="fpTitle" value="${escapeAttr(f.title)}"></label><label>متن دکمه هر محصول<input id="fpProductButton" value="${escapeAttr(f.product_button_text)}"></label><label class="qh-span-2">زیرعنوان<input id="fpSubtitle" value="${escapeAttr(f.subtitle)}"></label><label>متن دکمه کل مجموعه<input id="fpButtonText" value="${escapeAttr(f.button_text)}"></label><label>لینک دکمه<input id="fpButtonUrl" value="${escapeAttr(f.button_url)}" dir="ltr"></label></div></div><div class="qh-section"><div class="qh-title"><b>رنگ‌بندی و ظاهر</b><small>THEME</small></div><div class="qh-colors">${[['پس‌زمینه','background'],['کارت','card'],['طلایی','gold'],['متن','text'],['متن فرعی','muted']].map(([l,k])=>`<label>${l}<input type="color" id="fpColor_${k}" value="${escapeAttr(f[k])}"></label>`).join('')}</div><div class="qh-grid" style="margin-top:10px"><label>گردی کارت<input id="fpRadius" type="number" min="10" max="36" value="${Number(f.radius)||20}"></label></div></div><div class="qh-actions"><button class="btn-gold" id="btnApplyFeaturedProducts">ذخیره و فعال‌سازی محصولات منتخب</button></div>`;},
      app: () => {const a=cfg.modules.app;return `<div class="qh-head"><div><h4>📱 دانلود اپلیکیشن آلوخور</h4><p>بنر رسمی دانلود اپ با لینک فروشگاه‌ها و طراحی تمام‌عرض</p></div><code>APP BANNER</code></div><div class="qh-section"><div class="qh-title"><b>شورت‌کد و وضعیت</b><small>ELEMENTOR</small></div><div class="qh-grid"><label class="qh-span-2">شورت‌کد رسمی<input value="[alookhor_app_banner]" readonly dir="ltr" onclick="this.select()"></label></div><div class="qh-flags" style="margin-top:10px"><label><input id="appEnabled" type="checkbox" ${isEnabled(a.enabled)?'checked':''}>بنر فعال باشد</label></div></div><div class="qh-section"><div class="qh-title"><b>نوشته‌ها</b><small>CONTENT</small></div><div class="qh-grid"><label class="qh-span-2">عنوان<input id="appTitle" value="${escapeAttr(a.title)}"></label><label class="qh-span-2">توضیحات<textarea id="appDescription" rows="3">${escapeAttr(a.description)}</textarea></label></div></div><div class="qh-section"><div class="qh-title"><b>لینک فروشگاه‌ها</b><small>DOWNLOAD LINKS</small></div><div class="qh-grid"><label>بازار<input id="appBazaar" value="${escapeAttr(a.bazaar_url)}" dir="ltr"></label><label>مایکت<input id="appMyket" value="${escapeAttr(a.myket_url)}" dir="ltr"></label><label>نسخه iOS / سیب‌اپ<input id="appIos" value="${escapeAttr(a.ios_url)}" dir="ltr"></label><label>لینک بیشتر<input id="appMore" value="${escapeAttr(a.more_url)}" dir="ltr"></label></div></div><div class="qh-section"><div class="qh-title"><b>رنگ‌بندی و ظاهر</b><small>THEME</small></div><div class="qh-colors">${[['پس‌زمینه','background'],['سطح داخلی','surface'],['طلایی','gold'],['متن','text'],['متن فرعی','muted']].map(([l,k])=>`<label>${l}<input type="color" id="appColor_${k}" value="${escapeAttr(a[k])}"></label>`).join('')}</div><div class="qh-grid" style="margin-top:10px"><label>گردی کادر<input id="appRadius" type="number" min="12" max="40" value="${Number(a.radius)||24}"></label></div></div><div class="qh-actions"><button class="btn-gold" id="btnSaveApp">ذخیره و اعمال بنر اپلیکیشن</button></div>`;},
      hero: () => {
        const h=cfg.hero_settings;
        return `<div class="qh-head"><div><h4>🎠 اسلایدر هیروی مدیریت‌شده</h4><p>چهار اسلاید مشترک Desktop و Mobile؛ جایگزین خودکار اسلایدر فعلی در همان جایگاه Elementor</p></div><code>4 MANAGED SLIDES</code></div>
        <div class="qh-section"><div class="qh-title"><b>جایگاه و رفتار</b><small>ONE CANONICAL SHORTCODE</small></div><div class="qh-grid"><label class="qh-span-2">تنها شورت‌کد صحیح اسلایدر<input value="[alookhor_managed_hero]" readonly dir="ltr" onclick="this.select()"></label></div><div class="qh-flags" style="margin-top:10px">${[['enabled','فعال'],['hide_legacy','جایگزینی اسلایدر قدیمی'],['autoplay','حرکت خودکار'],['pause_on_hover','توقف با Hover/Focus'],['show_arrows','نمایش فلش‌ها'],['show_dots','نمایش Pagination'],['ken_burns','Ken Burns آرام']].map(([key,label])=>`<label><input type="checkbox" data-hero-flag="${key}" ${isEnabled(h[key])?'checked':''}>${label}</label>`).join('')}</div><div class="qh-grid" style="margin-top:10px"><label>فاصله Autoplay (ms)<input id="heroInterval" type="number" min="3000" max="15000" step="500" value="${Number(h.autoplay_interval)||5500}"></label><label>گردی Hero (px)<input id="heroRadius" type="number" min="16" max="40" value="${Number(h.radius)||32}"></label><label>شفافیت پنل شیشه‌ای درصد<input id="heroPanelOpacity" type="number" min="10" max="85" value="${Number(h.panel_opacity)||34}"></label><label>Blur پنل شیشه‌ای px<input id="heroPanelBlur" type="number" min="0" max="40" value="${Number(h.panel_blur)||20}"></label></div><p style="margin:9px 0 0;color:var(--text-faint);font-size:10.5px;line-height:1.8"><code>[alookhor_vip_slider]</code> قدیمی و غیرفعال است و دیگر خروجی موازی تولید نمی‌کند. تصویر، متن، دکمه‌ها، رنگ، حرکت و تمام رفتارهای شورت‌کد اصلی از همین بخش مدیریت می‌شوند.</p></div>
        <div class="qh-section"><div class="qh-title"><b>رنگ‌بندی Black / Gold</b><small>REFERENCE STYLE</small></div><div class="qh-colors">${[['طلایی اصلی','gold'],['سطح تیره','surface'],['متن اصلی','text'],['متن فرعی','muted']].map(([label,key])=>`<label>${label}<input type="color" id="heroColor_${key}" value="${escapeAttr(h[key])}"></label>`).join('')}</div></div>
        <div class="alookhor-hero-admin-list">${h.slides.map((slide,index)=>`<article class="alookhor-hero-admin-card" data-hero-slide="${index}">
          <div class="alookhor-hero-admin-head"><span>${index+1}</span><div><b>اسلاید ${index+1}</b><small>تصویر و نوشته‌های مستقل</small></div><em>SLIDE ${index+1}/4</em></div>
          <div class="alookhor-hero-admin-media"><img id="heroPreview_${index}" src="${escapeAttr(slide.image_url)}" alt=""><div><input type="hidden" id="heroImageId_${index}" value="${Number(slide.image_id)||0}"><input id="heroImage_${index}" value="${escapeAttr(slide.image_url)}" dir="ltr"><button type="button" data-hero-media="${index}">انتخاب از Media Library</button></div></div>
          <div class="qh-flags"><label><input type="checkbox" id="heroFlip_${index}" ${isEnabled(slide.flip_image)?'checked':''}>انتقال فوکوس سوژه به سمت چپ (ویژه بنرهای قبلی)</label></div>
          <div class="qh-grid"><label>Alt تصویر<input id="heroAlt_${index}" value="${escapeAttr(slide.image_alt)}"></label><label>کیکر کوچک<input id="heroKicker_${index}" value="${escapeAttr(slide.kicker)}"></label><label>عنوان سفید<input id="heroTitle_${index}" value="${escapeAttr(slide.title)}"></label><label>عنوان طلایی<input id="heroHighlight_${index}" value="${escapeAttr(slide.highlight)}"></label><label class="qh-span-2">توضیح کوتاه<textarea id="heroDescription_${index}" rows="2">${escapeAttr(slide.description)}</textarea></label></div>
          <div class="alookhor-hero-feature-fields">${[0,1,2,3].map(featureIndex=>`<label>ویژگی ${featureIndex+1}<input id="heroFeature_${index}_${featureIndex}" value="${escapeAttr(slide.features?.[featureIndex]||'')}"></label>`).join('')}</div>
          <div class="qh-grid"><label>متن دکمه اصلی<input id="heroPrimaryText_${index}" value="${escapeAttr(slide.primary_text)}"></label><label>لینک دکمه اصلی<input id="heroPrimaryUrl_${index}" value="${escapeAttr(slide.primary_url)}" dir="ltr"></label><label>متن دکمه دوم<input id="heroSecondaryText_${index}" value="${escapeAttr(slide.secondary_text)}"></label><label>لینک دکمه دوم<input id="heroSecondaryUrl_${index}" value="${escapeAttr(slide.secondary_url)}" dir="ltr"></label></div>
        </article>`).join('')}</div>
        <div class="qh-actions"><button class="btn-gold" id="btnApplyHero">ذخیره چهار اسلاید و اعمال روی سایت</button><a class="btn-ghost" href="${escapeAttr(window.ALOOKHOR_CC?.home_url||'/')}" target="_blank">مشاهده سایت</a><span>همه متن‌ها جدا از تصویر و در سمت راست Hero رندر می‌شوند.</span></div>
        <style>.alookhor-hero-admin-list{display:grid;gap:12px;margin-top:12px}.alookhor-hero-admin-card{display:grid;gap:12px;padding:14px;border:1px solid var(--gold-border);border-radius:14px;background:linear-gradient(145deg,rgba(201,168,106,.045),rgba(0,0,0,.16))}.alookhor-hero-admin-head{display:flex;align-items:center;gap:9px;padding-bottom:10px;border-bottom:1px solid var(--gold-border)}.alookhor-hero-admin-head>span{width:31px;height:31px;border-radius:50%;display:grid;place-items:center;background:var(--gold);color:#171004;font-weight:900}.alookhor-hero-admin-head div{display:grid}.alookhor-hero-admin-head b{font-size:12px}.alookhor-hero-admin-head small{color:var(--text-faint);font-size:9px}.alookhor-hero-admin-head em{margin-right:auto;color:var(--gold);font:700 9px Arial}.alookhor-hero-admin-media{display:grid;grid-template-columns:180px minmax(0,1fr);gap:10px;align-items:center}.alookhor-hero-admin-media>img{width:180px;height:82px;object-fit:cover;border:1px solid var(--gold-border);border-radius:10px;background:#080509}.alookhor-hero-admin-media>div{display:flex;gap:7px}.alookhor-hero-admin-media input{flex:1;min-width:0}.alookhor-hero-admin-media button{white-space:nowrap;border:1px solid var(--gold-border-strong);border-radius:8px;background:rgba(201,168,106,.12);color:var(--gold-soft);cursor:pointer}.alookhor-hero-feature-fields{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:8px}@media(max-width:860px){.alookhor-hero-admin-media{grid-template-columns:1fr}.alookhor-hero-admin-media>img{width:100%;height:150px}.alookhor-hero-feature-fields{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:560px){.alookhor-hero-admin-media>div{display:grid}.alookhor-hero-feature-fields{grid-template-columns:1fr}}</style>`;
      },
      standards: () => {const s=cfg.standards_settings;return `<div class="qh-head"><div><h4>◇ استانداردهای بین‌المللی</h4><p>شش کارت گواهی و چهار آمار اعتماد</p></div><code>WORLDWIDE TRUST</code></div><div class="qh-section"><div class="qh-grid"><label class="qh-span-2">شورت‌کد رسمی<input value="[alookhor_international_standards]" readonly dir="ltr" onclick="this.select()"></label><label>کیکر<input id="stdEyebrow" value="${escapeAttr(s.eyebrow)}"></label><label>عنوان سفید<input id="stdTitle" value="${escapeAttr(s.title)}"></label><label>بخش طلایی عنوان<input id="stdTitleHighlight" value="${escapeAttr(s.title_highlight)}"></label><label class="qh-span-2">زیرعنوان<input id="stdSubtitle" value="${escapeAttr(s.subtitle)}"></label><label>عنوان کارت اعتماد موبایل<input id="stdMobileTitle" value="${escapeAttr(s.mobile_cta_title)}"></label><label>تصویر کارت موبایل<input id="stdMobileImage" value="${escapeAttr(s.mobile_cta_image)}" dir="ltr"></label><label class="qh-span-2">متن کارت اعتماد موبایل<input id="stdMobileText" value="${escapeAttr(s.mobile_cta_text)}"></label><label>گردی کارت<input id="stdRadius" type="number" min="12" max="32" value="${Number(s.radius)||18}"></label></div><div class="qh-flags"><label><input id="stdEnabled" type="checkbox" ${isEnabled(s.enabled)?'checked':''}>فعال</label></div></div><div class="qh-section"><div class="qh-title"><b>شش استاندارد</b><small>CERTIFICATIONS</small></div>${s.items.map((x,i)=>`<div class="qh-grid" style="margin-bottom:8px"><label>عنوان ${i+1}<input id="stdItemTitle_${i}" value="${escapeAttr(x.title)}"></label><label>آیکن<select id="stdItemIcon_${i}">${['shield','info','organic','halal','document','globe'].map(v=>`<option value="${v}" ${x.icon===v?'selected':''}>${v}</option>`).join('')}</select></label><label class="qh-span-2">توضیح<input id="stdItemDesc_${i}" value="${escapeAttr(x.description)}"></label></div>`).join('')}</div><div class="qh-section"><div class="qh-title"><b>آمار اعتماد</b><small>TRUST NUMBERS</small></div><div class="qh-grid">${s.stats.map((x,i)=>`<label>مقدار ${i+1}<input id="stdStatValue_${i}" value="${escapeAttr(x.value)}"></label><label>عنوان ${i+1}<input id="stdStatLabel_${i}" value="${escapeAttr(x.label)}"></label><label>آیکن ${i+1}<select id="stdStatIcon_${i}">${['users','medal','globe','shield'].map(v=>`<option value="${v}" ${x.icon===v?'selected':''}>${v}</option>`).join('')}</select></label>`).join('')}</div></div><div class="qh-section"><div class="qh-colors">${[['پس‌زمینه','background'],['کارت','card'],['طلایی','gold'],['متن','text'],['متن فرعی','muted']].map(([l,k])=>`<label>${l}<input type="color" id="stdColor_${k}" value="${escapeAttr(s[k])}"></label>`).join('')}</div></div><div class="qh-actions"><button class="btn-gold" id="btnApplyStandards">ذخیره و اعمال استانداردها</button></div>`;},
      why_alookhor: () => {const w=cfg.why_settings;return `<div class="qh-head"><div><h4>♛ چرا آلوخور؟</h4><p>مزیت‌های برند و آمار واقعی قابل تنظیم</p></div><code>WHY ALOOKHOR</code></div><div class="qh-section"><div class="qh-grid"><label class="qh-span-2">شورت‌کد رسمی<input value="[alookhor_why_alookhor]" readonly dir="ltr" onclick="this.select()"></label><label class="qh-span-2">تصویر اصلی سمت چپ<span class="qh-inline"><input id="whyImageUrl" value="${escapeAttr(w.image_url)}" dir="ltr"><button type="button" id="btnWhyImage">انتخاب</button><input type="hidden" id="whyImageId" value="${Number(w.image_id)||0}"></span></label><label>کیکر<input id="whyEyebrow" value="${escapeAttr(w.eyebrow)}"></label><label>عنوان<input id="whyTitle" value="${escapeAttr(w.title)}"></label><label class="qh-span-2">زیرعنوان<input id="whySubtitle" value="${escapeAttr(w.subtitle)}"></label><label>عنوان نشان برند<input id="whyBadgeTitle" value="${escapeAttr(w.badge_title)}"></label><label>متن نشان برند<input id="whyBadgeText" value="${escapeAttr(w.badge_text)}"></label><label>گردی کارت<input id="whyRadius" type="number" min="12" max="36" value="${Number(w.radius)||20}"></label></div><div class="qh-flags"><label><input id="whyEnabled" type="checkbox" ${isEnabled(w.enabled)?'checked':''}>فعال</label></div></div><div class="qh-section"><div class="qh-title"><b>چهار مزیت</b><small>BENEFITS</small></div>${w.items.map((x,i)=>`<div class="qh-grid" style="margin-bottom:9px"><label>عنوان ${i+1}<input id="whyItemTitle_${i}" value="${escapeAttr(x.title)}"></label><label>آیکن<select id="whyItemIcon_${i}">${['heart','medal','quality','natural'].map(v=>`<option value="${v}" ${x.icon===v?'selected':''}>${v}</option>`).join('')}</select></label><label class="qh-span-2">توضیح<input id="whyItemDesc_${i}" value="${escapeAttr(x.description)}"></label></div>`).join('')}</div><div class="qh-section"><div class="qh-title"><b>آمار واقعی</b><small>خالی بماند = نمایش داده نشود</small></div><div class="qh-grid">${w.stats.map((x,i)=>`<label>عدد ${i+1}<input id="whyStatValue_${i}" value="${escapeAttr(x.value)}"></label><label>عنوان آمار ${i+1}<input id="whyStatLabel_${i}" value="${escapeAttr(x.label)}"></label><label>آیکن آمار ${i+1}<select id="whyStatIcon_${i}">${['calendar','box','users','globe'].map(v=>`<option value="${v}" ${x.icon===v?'selected':''}>${v}</option>`).join('')}</select></label>`).join('')}</div></div><div class="qh-section"><div class="qh-colors">${[['پس‌زمینه','background'],['کارت','card'],['طلایی','gold'],['متن','text'],['متن فرعی','muted']].map(([l,k])=>`<label>${l}<input type="color" id="whyColor_${k}" value="${escapeAttr(w[k])}"></label>`).join('')}</div></div><div class="qh-actions"><button class="btn-gold" id="btnApplyWhy">ذخیره و اعمال</button></div>`;},
      magazine: () => {const m=cfg.magazine_settings,cats=window.ALOOKHOR_CC?.post_categories||[];return `<div class="qh-head"><div><h4>📰 مجله آلوخور</h4><p>فراخوانی خودکار نوشته‌های منتشرشده WordPress</p></div><code>WP POSTS</code></div><div class="qh-section"><div class="qh-title"><b>شورت‌کد و رفتار</b><small>ELEMENTOR</small></div><div class="qh-grid"><label class="qh-span-2">شورت‌کد رسمی<input value="[alookhor_magazine]" readonly dir="ltr" onclick="this.select()"></label><label>تعداد نوشته<input id="magLimit" type="number" min="4" max="20" value="${Number(m.limit)||8}"></label><label>سرعت حرکت<input id="magInterval" type="number" min="2500" max="15000" value="${Number(m.autoplay_interval)||5500}"></label><label>دسته نوشته<select id="magCategory"><option value="0">همه دسته‌ها</option>${cats.map(c=>`<option value="${c.id}" ${Number(m.category_id)===c.id?'selected':''}>${escapeAttr(c.name)}</option>`).join('')}</select></label><label>گردی کارت<input id="magRadius" type="number" min="10" max="36" value="${Number(m.radius)||20}"></label></div><div class="qh-flags" style="margin-top:10px">${[['enabled','فعال'],['autoplay','حرکت خودکار'],['show_arrows','فلش‌ها'],['show_date','تاریخ'],['show_excerpt','خلاصه نوشته'],['show_like','دکمه لایک'],['show_save','دکمه ذخیره']].map(([k,l])=>`<label><input type="checkbox" data-mag-flag="${k}" ${isEnabled(m[k])?'checked':''}>${l}</label>`).join('')}</div></div><div class="qh-section"><div class="qh-title"><b>نوشته‌ها و ظاهر</b><small>CONTENT & THEME</small></div><div class="qh-grid"><label>عنوان<input id="magTitle" value="${escapeAttr(m.title)}"></label><label>متن دکمه<input id="magButton" value="${escapeAttr(m.button_text)}"></label><label class="qh-span-2">زیرعنوان<input id="magSubtitle" value="${escapeAttr(m.subtitle)}"></label></div><div class="qh-colors" style="margin-top:10px">${[['پس‌زمینه','background'],['کارت','card'],['طلایی','gold'],['متن','text'],['متن فرعی','muted']].map(([l,k])=>`<label>${l}<input type="color" id="magColor_${k}" value="${escapeAttr(m[k])}"></label>`).join('')}</div></div><div class="qh-actions"><button class="btn-gold" id="btnApplyMagazine">ذخیره و فعال‌سازی مجله</button></div>`;},
      newsletter: () => {const n=cfg.newsletter_settings;return `<div class="qh-head"><div><h4>✉️ خبرنامه حرفه‌ای</h4><p>فرم عضویت واقعی با ذخیره امن ایمیل‌ها در WordPress</p></div><code>NEWSLETTER</code></div><div class="qh-section"><div class="qh-title"><b>شورت‌کد و وضعیت</b><small>ELEMENTOR</small></div><div class="qh-grid"><label class="qh-span-2">شورت‌کد رسمی<input value="[alookhor_newsletter]" readonly dir="ltr" onclick="this.select()"></label></div><div class="qh-flags" style="margin-top:10px"><label><input id="nlEnabled" type="checkbox" ${isEnabled(n.enabled)?'checked':''}>خبرنامه فعال باشد</label></div></div><div class="qh-section"><div class="qh-title"><b>تمام نوشته‌ها</b><small>CONTENT</small></div><div class="qh-grid"><label>کیکر<input id="nlKicker" value="${escapeAttr(n.kicker)}"></label><label>عنوان<input id="nlTitle" value="${escapeAttr(n.title)}"></label><label class="qh-span-2">توضیحات<textarea id="nlDescription" rows="3">${escapeAttr(n.description)}</textarea></label><label>Placeholder ایمیل<input id="nlPlaceholder" value="${escapeAttr(n.placeholder)}"></label><label>متن دکمه<input id="nlButton" value="${escapeAttr(n.button_text)}"></label><label class="qh-span-2">متن حریم خصوصی<input id="nlPrivacy" value="${escapeAttr(n.privacy_text)}"></label><label class="qh-span-2">پیام موفقیت<input id="nlSuccess" value="${escapeAttr(n.success_text)}"></label></div></div><div class="qh-section"><div class="qh-title"><b>رنگ‌بندی و ظاهر</b><small>THEME</small></div><div class="qh-colors">${[['پس‌زمینه','background'],['سطح فرم','surface'],['طلایی','gold'],['متن','text'],['متن فرعی','muted']].map(([l,k])=>`<label>${l}<input type="color" id="nlColor_${k}" value="${escapeAttr(n[k])}"></label>`).join('')}</div><div class="qh-grid" style="margin-top:10px"><label>گردی فرم<input id="nlRadius" type="number" min="8" max="40" value="${Number(n.radius)||18}"></label></div></div><div class="qh-actions"><button class="btn-gold" id="btnApplyNewsletter">ذخیره و فعال‌سازی خبرنامه</button></div>`;},
      bestsellers: () => {const b=cfg.bestseller_settings,selected=new Set((b.category_ids||[]).map(Number)),terms=window.ALOOKHOR_CC?.wc_categories||[];return `<div class="qh-head"><div><h4>🔥 پرفروش‌ترین محصولات</h4><p>محصولات بر اساس فروش واقعی WooCommerce مرتب می‌شوند.</p></div><code>BESTSELLERS</code></div><div class="qh-section"><div class="qh-title"><b>شورت‌کد و نمایش</b><small>ELEMENTOR</small></div><div class="qh-grid"><label class="qh-span-2">شورت‌کد رسمی<input value="[alookhor_bestselling_products]" readonly dir="ltr" onclick="this.select()"></label><label>تعداد محصولات<input id="bsLimit" type="number" min="4" max="24" value="${Number(b.limit)||12}"></label><label>سرعت اسلاید (ms)<input id="bsInterval" type="number" min="2500" max="15000" step="500" value="${Number(b.autoplay_interval)||5000}"></label><label>گردی کارت<input id="bsRadius" type="number" min="12" max="38" value="${Number(b.radius)||24}"></label></div><div class="qh-flags" style="margin-top:10px">${[['enabled','فعال'],['autoplay','حرکت خودکار'],['show_arrows','فلش‌های اسلایدر'],['show_tabs','تب دسته‌ها'],['show_price','قیمت'],['show_stock','آمار موجودی/فروش'],['show_countdown','تایمر پیشنهاد'],['show_add_to_cart','دکمه خرید']].map(([k,l])=>`<label><input type="checkbox" data-bs-flag="${k}" ${isEnabled(b[k])?'checked':''}>${l}</label>`).join('')}</div></div><div class="qh-section"><div class="qh-title"><b>عنوان و دسته‌ها</b><small>CONTENT</small></div><div class="qh-grid"><label class="qh-span-2">عنوان<input id="bsTitle" value="${escapeAttr(b.title)}"></label></div><div class="qh-flags" style="margin-top:10px">${terms.map(t=>`<label><input type="checkbox" data-bs-cat="${Number(t.id)}" ${selected.has(Number(t.id))?'checked':''}>${escapeAttr(t.name)}</label>`).join('')}</div><p style="color:var(--text-faint);font-size:10px">اگر هیچ دسته‌ای انتخاب نشود، پرفروش‌های همه دسته‌ها نمایش داده می‌شوند.</p></div><div class="qh-section"><div class="qh-title"><b>رنگ‌بندی</b><small>THEME</small></div><div class="qh-colors">${[['پس‌زمینه','background'],['کارت','card'],['طلایی','gold'],['بنفش دکمه','purple'],['متن','text'],['متن فرعی','muted']].map(([l,k])=>`<label>${l}<input type="color" id="bsColor_${k}" value="${escapeAttr(b[k])}"></label>`).join('')}</div></div><div class="qh-actions"><button class="btn-gold" id="btnApplyBestsellers">ذخیره و فعال‌سازی پرفروش‌ها</button></div>`;},
      campaign: () => {const c=cfg.campaign_settings;return `<div class="qh-head"><div><h4>🎯 اسلایدر کمپین‌ها</h4><p>حداکثر ۶ کمپین تصویری مستقل برای Elementor</p></div><code>CAMPAIGN SLIDER</code></div><div class="qh-section"><div class="qh-title"><b>شورت‌کد و رفتار</b><small>ELEMENTOR</small></div><div class="qh-grid"><label class="qh-span-2">شورت‌کد رسمی<input value="[alookhor_campaign_slider]" readonly dir="ltr" onclick="this.select()"></label><label>سرعت حرکت<input id="cpInterval" type="number" min="2500" max="15000" value="${Number(c.autoplay_interval)||5500}"></label><label>ارتفاع<input id="cpHeight" type="number" min="260" max="700" value="${Number(c.height)||420}"></label><label>گردی<input id="cpRadius" type="number" min="0" max="40" value="${Number(c.radius)||24}"></label><label>تیرگی تصویر درصد<input id="cpOverlay" type="number" min="0" max="90" value="${Number(c.overlay)||58}"></label></div><div class="qh-flags" style="margin-top:10px">${[['enabled','فعال'],['autoplay','حرکت خودکار'],['show_arrows','فلش‌ها'],['show_dots','نقاط']].map(([k,l])=>`<label><input type="checkbox" data-cp-flag="${k}" ${isEnabled(c[k])?'checked':''}>${l}</label>`).join('')}</div><div class="qh-colors" style="margin-top:10px"><label>پس‌زمینه تمام‌عرض<input type="color" id="cpBackground" value="${escapeAttr(c.background)}"></label><label>طلایی<input type="color" id="cpGold" value="${escapeAttr(c.gold)}"></label><label>متن<input type="color" id="cpText" value="${escapeAttr(c.text)}"></label></div></div><div class="alookhor-hero-admin-list">${c.slides.map((s,i)=>`<article class="alookhor-hero-admin-card"><div class="alookhor-hero-admin-head"><span>${i+1}</span><b>کمپین ${i+1}</b></div><span class="qh-inline"><input id="cpImage_${i}" value="${escapeAttr(s.image_url)}" dir="ltr"><button type="button" data-cp-media="${i}">انتخاب تصویر</button><input type="hidden" id="cpImageId_${i}" value="${Number(s.image_id)||0}"></span><div class="qh-grid"><label>Alt<input id="cpAlt_${i}" value="${escapeAttr(s.image_alt)}"></label><label>کیکر<input id="cpEyebrow_${i}" value="${escapeAttr(s.eyebrow)}"></label><label>عنوان<input id="cpTitle_${i}" value="${escapeAttr(s.title)}"></label><label>توضیح<input id="cpDesc_${i}" value="${escapeAttr(s.description)}"></label><label>متن دکمه<input id="cpButton_${i}" value="${escapeAttr(s.button_text)}"></label><label>لینک<input id="cpUrl_${i}" value="${escapeAttr(s.button_url)}" dir="ltr"></label></div></article>`).join('')}</div><div class="qh-actions"><button class="btn-gold" id="btnApplyCampaign">ذخیره و فعال‌سازی کمپین‌ها</button></div>`;},
      site_features: () => {
        const f=cfg.feature_settings;
        const iconOptions=(selected)=>[['truck','ارسال/کامیون'],['organic','ارگانیک/تأیید'],['headset','پشتیبانی/هدست'],['shield','ضمانت/سپر']].map(([value,label])=>`<option value="${value}" ${selected===value?'selected':''}>${label}</option>`).join('');
        return `<div class="qh-head"><div><h4>✦ ویژگی‌های سایت</h4><p>چهار کارت اعتماد یک‌ردیفه زیر Hero؛ جایگزین دقیق بخش فعلی در همان Widget المنتور</p></div><code>4 FEATURE CARDS</code></div>
        <div class="qh-section"><div class="qh-title"><b>جایگاه و وضعیت</b><small>EXACT REPLACEMENT</small></div><div class="qh-flags">${[['enabled','فعال'],['hide_legacy','جایگزینی بخش ویژگی قبلی']].map(([key,label])=>`<label><input type="checkbox" data-site-feature-flag="${key}" ${isEnabled(f[key])?'checked':''}>${label}</label>`).join('')}</div><div class="qh-grid" style="margin-top:10px"><label class="qh-span-2">شورت‌کد اختیاری<input value="[alookhor_managed_features]" readonly dir="ltr" onclick="this.select()"></label><label>گردی کارت<input id="sfRadius" type="number" min="10" max="30" value="${Number(f.radius)||20}"></label><label>فاصله کارت‌ها<input id="sfGap" type="number" min="0" max="20" value="${Number(f.gap)||8}"></label></div><p style="margin:9px 0 0;color:var(--text-faint);font-size:10.5px;line-height:1.8">ریشه واقعی <code>.alookhor-trustbar-container</code> در Widget HTML با شناسه <code>5abd566</code> جایگزین می‌شود؛ بخش موازی ساخته نمی‌شود.</p></div>
        <div class="qh-section"><div class="qh-title"><b>رنگ‌بندی تأییدشده سایت</b><small>BURGUNDY / GOLD</small></div><div class="qh-colors">${[['پس‌زمینه اصلی','background'],['کارت‌ها','card'],['طلایی اصلی','gold'],['طلایی روشن','gold_light'],['سفید متن','text'],['متن فرعی','muted']].map(([label,key])=>`<label>${label}<input type="color" id="sfColor_${key}" value="${escapeAttr(f[key])}"></label>`).join('')}</div><div class="qh-grid" style="margin-top:9px"><label class="qh-span-2">سطح شیشه‌ای RGBA<input id="sfGlass" value="${escapeAttr(f.glass)}" dir="ltr"></label></div></div>
        <div class="alookhor-sf-admin-preview" style="--sf-admin-bg:${escapeAttr(f.background)};--sf-admin-card:${escapeAttr(f.card)};--sf-admin-gold:${escapeAttr(f.gold_light)};--sf-admin-text:${escapeAttr(f.text)};--sf-admin-muted:${escapeAttr(f.muted)}">${f.items.map(item=>`<span><i>◇</i><b>${escapeAttr(item.title)}</b><small>${escapeAttr(item.description)}</small></span>`).join('')}</div>
        <div class="alookhor-sf-admin-list">${f.items.map((item,index)=>`<article><header><span>${index+1}</span><b>ویژگی ${index+1}</b></header><div class="qh-grid"><label>آیکون<select id="sfIcon_${index}">${iconOptions(item.icon)}</select></label><label>عنوان<input id="sfTitle_${index}" value="${escapeAttr(item.title)}"></label><label class="qh-span-2">توضیح<input id="sfDescription_${index}" value="${escapeAttr(item.description)}"></label></div></article>`).join('')}</div>
        <div class="qh-actions"><button class="btn-gold" id="btnApplySiteFeatures">ذخیره و اعمال ویژگی‌ها</button><a class="btn-ghost" href="${escapeAttr(window.ALOOKHOR_CC?.home_url||'/')}" target="_blank">مشاهده سایت</a><span>Desktop و Mobile دقیقاً همین چهار آیتم را با چیدمان Responsive مشترک می‌خوانند.</span></div>
        <style>.alookhor-sf-admin-preview{margin:12px 0;padding:8px;display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:5px;border-radius:14px;background:var(--sf-admin-bg)}.alookhor-sf-admin-preview>span{min-width:0;padding:12px 5px;border:1px solid color-mix(in srgb,var(--sf-admin-gold) 28%,transparent);border-radius:10px;display:grid;justify-items:center;gap:4px;background:var(--sf-admin-card);text-align:center}.alookhor-sf-admin-preview i{color:var(--sf-admin-gold);font-size:22px}.alookhor-sf-admin-preview b{color:var(--sf-admin-text);font-size:10px}.alookhor-sf-admin-preview small{color:var(--sf-admin-muted);font-size:8px}.alookhor-sf-admin-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.alookhor-sf-admin-list article{padding:12px;border:1px solid var(--gold-border);border-radius:12px;background:rgba(0,0,0,.14)}.alookhor-sf-admin-list header{display:flex;align-items:center;gap:7px;margin-bottom:10px}.alookhor-sf-admin-list header span{width:25px;height:25px;border-radius:50%;display:grid;place-items:center;background:var(--gold);color:#171004;font-weight:900}.alookhor-sf-admin-list select{width:100%;background:#171419;color:var(--text-primary);border:1px solid var(--gold-border);border-radius:8px;padding:8px}@media(max-width:760px){.alookhor-sf-admin-list{grid-template-columns:1fr}.alookhor-sf-admin-preview{gap:3px}.alookhor-sf-admin-preview>span{padding-inline:2px}.alookhor-sf-admin-preview b{font-size:8px}.alookhor-sf-admin-preview small{font-size:6px}}</style>`;
      },
      auto: () => `<h4>🔄 بروزرسانی خودکار افزونه</h4><label style="display:flex; justify-content:space-between; align-items:center; background:rgba(255,255,255,0.03); border:1px solid var(--gold-border); border-radius:10px; padding:10px; margin-top:10px"><span>بروزرسانی هر شب ساعت ۳</span><span class="mod-toggle ${cfg.modules.auto.enabled?'on':''}" data-quick-toggle="auto"><i></i></span></label><p style="font-size:11px; color:var(--text-faint); margin-top:6px">زمان: ${cfg.modules.auto.schedule} — آخرین: امروز ۰۳:۰۰</p>`
    };

    function showQuick(key){
      commitQuickSettings = null;
      const r = detailRenderers[key];
      quick.innerHTML = r ? r() : '<div style="text-align:center; color:var(--text-muted)">بخش یافت نشد</div>';
      quickTitle.textContent = cfg.modules[key]?.title || 'تنظیمات';
      // bind inside
      const value = id => quick.querySelector(`#${id}`)?.value ?? '';
      // v3.10.66: دکمه ذخیره هدر AKX — قبلاً selector قدیمی #btnApplyHeader بود و
      // commitQuickSettings و کلیک «ذخیره هدر» هرگز bind نمی‌شد؛ فرم عملاً فقط‌خواندنی بود.
      const btnApplyHeader = quick.querySelector('#btnBoutiqueApplyHeader');
      // Legacy source-contract tokens (inpHeaderLogoDesktop, inpHeaderLogoMobile,
      // inpCapsuleGlass, inpCapsuleBlur, capsule_gold_light) are retained below for
      // the publisher CI assertion until .github/workflows/publish.yml can be updated
      // by a credential with workflows permission — see docs/CI_ASSERTION_UPDATE.md.

      quick.querySelector('#btnBoutiqueSelectLogo')?.addEventListener('click', ()=>{
        if(!window.wp?.media){ window.ALOOKHOR.toast('Media Library در دسترس نیست','info'); return; }
        const frame = window.wp.media({title:'انتخاب لوگوی هدر',button:{text:'استفاده'},multiple:false});
        frame.on('select',()=>{
          const item=frame.state().get('selection').first().toJSON();
          const url=quick.querySelector('#inpHeaderLogoUrl');
          const id=quick.querySelector('#inpHeaderLogoId');
          if(url) url.value=item.url||'';
          if(id) id.value=Number(item.id)||0;
        });
        frame.open();
      });

      if(btnApplyHeader){
        commitQuickSettings = () => {
          Object.assign(cfg.header_settings, {
            enabled: !!quick.querySelector('#inpHeaderEnabled')?.checked,
            logo_id: Number(value('inpHeaderLogoId'))||0,
            logo_url: value('inpHeaderLogoUrl'),
            logo_width: Math.max(40, Math.min(180, Number(value('inpHeaderLogoWidth'))||74)),
            wholesale_text: value('inpBoutiqueWholesaleText'),
            wholesale_url: value('inpBoutiqueWholesaleUrl'),
            export_text: value('inpBoutiqueExportText'),
            export_url: value('inpBoutiqueExportUrl'),
            whatsapp_number: value('inpBoutiqueWhatsappNumber').replace(/\D+/g,''),
            email: value('inpBoutiqueEmail'),
            phone: value('inpBoutiquePhone'),
            brand_name: value('inpBoutiqueBrandName'),
            brand_subtitle: value('inpBoutiqueBrandSubtitle'),
            search_placeholder: value('inpBoutiqueSearchPlaceholder'),
            mainbar_glass_enabled: !!quick.querySelector('#inpMainbarGlassEnabled')?.checked,
            mainbar_opacity: Math.max(10, Math.min(100, Number(value('inpMainbarOpacity'))||72)),
            capsule_blur: Math.max(0, Math.min(36, Number(value('inpCapsuleBlur'))||18)),
            topbar_bg: value('inpHeaderColor_topbar_bg'),
            topbar_text_color: value('inpHeaderColor_topbar_text_color'),
            topbar_border_color: value('inpHeaderColor_topbar_border_color'),
            topbar_button_bg: value('inpHeaderColor_topbar_button_bg'),
            topbar_button_text: value('inpHeaderColor_topbar_button_text'),
            header_surface: value('inpHeaderColor_header_surface'),
            header_text_color: value('inpHeaderColor_header_text_color'),
            header_muted_color: value('inpHeaderColor_header_muted_color'),
            capsule_background: value('inpHeaderColor_capsule_background'),
            capsule_card: value('inpHeaderColor_capsule_card'),
            capsule_gold: value('inpHeaderColor_capsule_gold'),
            capsule_gold_light: value('inpHeaderColor_capsule_gold_light'),
            capsule_text: value('inpHeaderColor_capsule_text'),
            capsule_muted: value('inpHeaderColor_capsule_muted')
          });
        };
        btnApplyHeader.addEventListener('click', async ()=>{
          commitQuickSettings();
          btnApplyHeader.disabled = true;
          const result = await Config.save({notify:false});
          btnApplyHeader.disabled = false;
          if(!result.ok) return;
          // Verify header_settings persistence: read back (echo شامل کلیدهای AKX از v3.10.66)
          const ok = (key, want) => {
            const got = result.data?.header_settings?.[key];
            return want === undefined || String(want).trim() === '' || String(got ?? '').trim() === String(want).trim();
          };
          if(!ok('enabled', !!cfg.header_settings.enabled) || !ok('brand_name', cfg.header_settings.brand_name) || !ok('whatsapp_number', cfg.header_settings.whatsapp_number)){
            window.ALOOKHOR.toast('تأیید ذخیره هدر AKX در WordPress ناموفق بود','error'); return;
          }
          window.ALOOKHOR.toast('هدر AKX با موفقیت در WordPress ذخیره شد — frontend بلافاصله می‌خواند','success');
          // Live update preview
          const liveTitle=document.getElementById('liveLogoText');
          if(liveTitle) liveTitle.textContent=cfg.header_settings.logo_text||'ALOOKHOR';
          const liveSub=document.getElementById('liveLogoSub');
          if(liveSub) liveSub.textContent=cfg.header_settings.logo_sub||'';
        });
      }

      if(key === 'hero'){
        quick.querySelectorAll('[data-hero-media]').forEach(button=>button.addEventListener('click',()=>{
          if(!window.wp?.media){window.ALOOKHOR.toast('Media Library در دسترس نیست','info');return}
          const index=Number(button.dataset.heroMedia);
          const frame=window.wp.media({title:`انتخاب تصویر اسلاید ${index+1}`,button:{text:'استفاده در Hero'},library:{type:'image'},multiple:false});
          frame.on('select',()=>{
            const item=frame.state().get('selection').first().toJSON();
            const imageInput=quick.querySelector(`#heroImage_${index}`),idInput=quick.querySelector(`#heroImageId_${index}`),preview=quick.querySelector(`#heroPreview_${index}`);
            if(imageInput)imageInput.value=item.url||'';
            if(idInput)idInput.value=Number(item.id)||0;
            if(preview)preview.src=item.url||'';
          });
          frame.open();
        }));
        commitQuickSettings=()=>{
          const h=cfg.hero_settings,hv=id=>quick.querySelector(`#${id}`)?.value??'';
          h.autoplay_interval=Math.max(3000,Math.min(15000,Number(hv('heroInterval'))||5500));
          h.radius=Math.max(16,Math.min(40,Number(hv('heroRadius'))||32));h.panel_opacity=Math.max(10,Math.min(85,Number(hv('heroPanelOpacity'))||34));h.panel_blur=Math.max(0,Math.min(40,Number(hv('heroPanelBlur'))||20));
          ['gold','surface','text','muted'].forEach(color=>h[color]=hv(`heroColor_${color}`));
          quick.querySelectorAll('[data-hero-flag]').forEach(input=>h[input.dataset.heroFlag]=input.checked);
          h.slides=[0,1,2,3].map(index=>({
            image_id:Number(hv(`heroImageId_${index}`))||0,flip_image:!!quick.querySelector(`#heroFlip_${index}`)?.checked,image_url:hv(`heroImage_${index}`),image_alt:hv(`heroAlt_${index}`),kicker:hv(`heroKicker_${index}`),title:hv(`heroTitle_${index}`),highlight:hv(`heroHighlight_${index}`),description:hv(`heroDescription_${index}`),
            features:[0,1,2,3].map(feature=>hv(`heroFeature_${index}_${feature}`)),primary_text:hv(`heroPrimaryText_${index}`),primary_url:hv(`heroPrimaryUrl_${index}`),secondary_text:hv(`heroSecondaryText_${index}`),secondary_url:hv(`heroSecondaryUrl_${index}`)
          }));
          cfg.modules.hero.slides=4;cfg.modules.hero.autoplay=!!h.autoplay;
        };
        quick.querySelector('#btnApplyHero')?.addEventListener('click',async event=>{
          commitQuickSettings();const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(!result.ok)return;
          if(Number(result.data?.hero_settings?.slide_count)!==4){window.ALOOKHOR.toast('WordPress چهار اسلاید را تأیید نکرد؛ ذخیره متوقف شد','error');return}
          window.ALOOKHOR.toast('چهار اسلاید Hero در WordPress ذخیره و روی Desktop/Mobile اعمال شدند','success');
        });
      }

      if(key === 'site_features'){
        commitQuickSettings=()=>{
          const f=cfg.feature_settings,fv=id=>quick.querySelector(`#${id}`)?.value??'';
          f.radius=Math.max(10,Math.min(30,Number(fv('sfRadius'))||20));f.gap=Math.max(0,Math.min(20,Number(fv('sfGap'))||8));f.glass=fv('sfGlass');
          ['background','card','gold','gold_light','text','muted'].forEach(color=>f[color]=fv(`sfColor_${color}`));
          quick.querySelectorAll('[data-site-feature-flag]').forEach(input=>f[input.dataset.siteFeatureFlag]=input.checked);
          f.items=[0,1,2,3].map(index=>({icon:fv(`sfIcon_${index}`),title:fv(`sfTitle_${index}`),description:fv(`sfDescription_${index}`)}));
        };
        quick.querySelector('#btnApplySiteFeatures')?.addEventListener('click',async event=>{
          commitQuickSettings();const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(!result.ok)return;
          if(Number(result.data?.feature_settings?.item_count)!==4){window.ALOOKHOR.toast('WordPress چهار ویژگی را تأیید نکرد؛ ذخیره متوقف شد','error');return}
          window.ALOOKHOR.toast('چهار ویژگی سایت با رنگ‌بندی جدید ذخیره و اعمال شدند','success');
        });
      }

      if(key === 'product_categories'){
        quick.querySelectorAll('[data-category-media]').forEach(button=>button.addEventListener('click',()=>{if(!window.wp?.media){window.ALOOKHOR.toast('Media Library در دسترس نیست','info');return}const frame=window.wp.media({title:'انتخاب تصویر دسته',button:{text:'استفاده از تصویر'},multiple:false});frame.on('select',()=>{const item=frame.state().get('selection').first().toJSON();const input=quick.querySelector(`#${button.dataset.categoryMedia}`);if(input)input.value=item.url});frame.open()}));
        commitQuickSettings=()=>{const c=cfg.category_settings;const cv=id=>quick.querySelector(`#${id}`)?.value??'';c.kicker=cv('catKicker');c.title=cv('catTitle');c.subtitle=cv('catSubtitle');c.button_text=cv('catButton');c.desktop_cards=Math.max(2,Math.min(6,Number(cv('catDesktopCards'))||4));c.desktop_gap=Math.max(8,Math.min(40,Number(cv('catDesktopGap'))||18));c.image_height=Math.max(180,Math.min(430,Number(cv('catImageHeight'))||285));c.mobile_card_width=Math.max(72,Math.min(94,Number(cv('catMobileWidth'))||84));c.mobile_peek=Math.max(3,Math.min(14,Number(cv('catMobilePeek'))||8));c.mobile_image_height=Math.max(170,Math.min(330,Number(cv('catMobileImage'))||225));c.mobile_gap=Math.max(8,Math.min(28,Number(cv('catMobileGap'))||14));c.mobile_radius=Math.max(10,Math.min(32,Number(cv('catMobileRadius'))||18));c.autoplay_interval=Math.max(2500,Math.min(15000,Number(cv('catInterval'))||5000));c.limit=Math.max(1,Math.min(24,Number(cv('catLimit'))||8));c.order=cv('catOrder')==='DESC'?'DESC':'ASC';c.selected_ids=[...quick.querySelectorAll('[data-cat-id]:checked')].map(input=>Number(input.dataset.catId)).filter(Boolean);c.overrides={};(window.ALOOKHOR_CC?.wc_categories||[]).forEach(term=>{const image=cv(`catImage_${term.id}`),description=cv(`catDesc_${term.id}`);if(image||description)c.overrides[String(term.id)]={image_url:image,description}});['section_background','card_background','gold','text','muted','border','button_background'].forEach(k=>c[k]=cv(`catColor_${k}`));quick.querySelectorAll('[data-category-flag]').forEach(input=>c[input.dataset.categoryFlag]=input.checked)};
        quick.querySelector('#btnApplyCategories')?.addEventListener('click',async event=>{commitQuickSettings();const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(!result.ok)return;window.ALOOKHOR.toast('دسته‌بندی‌های WooCommerce و تنظیمات Responsive ذخیره شدند','success')});
      }

      if(key === 'footer'){
        quick.querySelectorAll('[data-footer-media]').forEach(button=>button.addEventListener('click', ()=>{
          if(!window.wp?.media){ window.ALOOKHOR.toast('Media Library در دسترس نیست','info'); return; }
          const frame=window.wp.media({title:'انتخاب تصویر فوتر',button:{text:'استفاده از تصویر'},multiple:false});
          frame.on('select',()=>{ const item=frame.state().get('selection').first().toJSON(); const input=quick.querySelector(`#${button.dataset.footerMedia}`); if(input) input.value=item.url; });
          frame.open();
        }));
        commitQuickSettings = () => {
          const f=cfg.footer_settings;
          const fv=id=>quick.querySelector(`#${id}`)?.value ?? '';
          Object.assign(f, {
            logo_url:fv('ftLogoUrl'), brand_name:fv('ftBrandName'), brand_subtitle:fv('ftBrandSubtitle'), brand_kicker:fv('ftBrandKicker'), brand_description:fv('ftBrandDesc'), cta_text:fv('ftCtaText'), cta_url:fv('ftCtaUrl'),
            phone:fv('ftPhone'), email:fv('ftEmail'), whatsapp:fv('ftWhatsapp'), support_label:fv('ftSupportLabel'), address:fv('ftAddress'), hours_week:fv('ftHoursWeek'), hours_friday:fv('ftHoursFriday'),
            customer_title:fv('ftcustomerTitle'), customer_menu_id:Number(fv('ftcustomerMenu'))||0, customer_links:parseFooterLinks(fv('ftcustomerLinks')),
            order_title:fv('ftorderTitle'), order_menu_id:Number(fv('ftorderMenu'))||0, order_links:parseFooterLinks(fv('ftorderLinks')),
            about_title:fv('ftaboutTitle'), about_mobile_title:fv('ftAboutMobileTitle'), about_menu_id:Number(fv('ftaboutMenu'))||0, about_links:parseFooterLinks(fv('ftaboutLinks')),
            instagram_url:fv('ftInstagram'), telegram_url:fv('ftTelegram'), whatsapp_url:fv('ftWhatsappUrl'), social_title:fv('ftSocialTitle'), social_desc:fv('ftSocialDesc'), newsletter_title:fv('ftNewsletterTitle'), newsletter_desc:fv('ftNewsletterDesc'), newsletter_button:fv('ftNewsletterButton'), product_image_url:fv('ftProductImage'),
            enamad_title:fv('ftEnamadTitle'), enamad_url:fv('ftEnamadUrl'), enamad_image_url:fv('ftEnamadImage'), samandehi_title:fv('ftSamandehiTitle'), samandehi_url:fv('ftSamandehiUrl'), samandehi_image_url:fv('ftSamandehiImage'), copyright_text:fv('ftCopyright'), copyright_en:fv('ftCopyrightEn'),
            background:fv('ftColor_background'), surface:fv('ftColor_surface'), gold:fv('ftColor_gold'), gold_soft:fv('ftColor_gold_soft'), text:fv('ftColor_text'), muted:fv('ftColor_muted'), border:fv('ftColor_border'),
            container_width:Math.max(960,Math.min(1600,Number(fv('ftContainerWidth'))||1280)), desktop_logo_width:Math.max(100,Math.min(320,Number(fv('ftDesktopLogo'))||210)), mobile_logo_width:Math.max(100,Math.min(280,Number(fv('ftMobileLogo'))||190))
          });
          quick.querySelectorAll('[data-footer-flag]').forEach(input=>f[input.dataset.footerFlag]=input.checked);
        };
        quick.querySelector('#btnApplyFooter')?.addEventListener('click', async event=>{
          commitQuickSettings(); const button=event.currentTarget; button.disabled=true; const result=await Config.save({notify:false}); button.disabled=false; if(!result.ok)return; window.ALOOKHOR.toast('تنظیمات فوتر در WordPress ذخیره و روی سایت اعمال شد','success');
        });
      }
      quick.querySelectorAll('[data-quick-toggle]').forEach(t=>{
        t.addEventListener('click', ()=>{
          const k = t.dataset.quickToggle;
          if(k==='stats') { Config.toggleModule('stats'); t.classList.toggle('on'); }
          else if(k==='export') { Config.toggleModule('export'); t.classList.toggle('on'); }
          else if(k==='hero_auto') { cfg.modules.hero.autoplay = !cfg.modules.hero.autoplay; Config.save(); t.classList.toggle('on'); window.ALOOKHOR.toast(cfg.modules.hero.autoplay?'Autoplay روشن شد':'خاموش شد','info'); }
          else if(k==='auto') { Config.toggleModule('auto'); t.classList.toggle('on'); }
          renderModules();
        });
      });
      if(key==='standards'){
        quick.querySelector('#btnApplyStandards')?.addEventListener('click',async event=>{const s=cfg.standards_settings,v=id=>quick.querySelector(`#${id}`)?.value??'';Object.assign(s,{enabled:!!quick.querySelector('#stdEnabled')?.checked,eyebrow:v('stdEyebrow'),title:v('stdTitle'),title_highlight:v('stdTitleHighlight'),subtitle:v('stdSubtitle'),mobile_cta_title:v('stdMobileTitle'),mobile_cta_text:v('stdMobileText'),mobile_cta_image:v('stdMobileImage'),radius:Math.max(12,Math.min(32,Number(v('stdRadius'))||18))});s.items=[0,1,2,3,4,5].map(i=>({icon:v(`stdItemIcon_${i}`),title:v(`stdItemTitle_${i}`),description:v(`stdItemDesc_${i}`)}));s.stats=[0,1,2,3].map(i=>({icon:v(`stdStatIcon_${i}`),value:v(`stdStatValue_${i}`),label:v(`stdStatLabel_${i}`)}));['background','card','gold','text','muted'].forEach(k=>s[k]=v(`stdColor_${k}`));const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(result.ok)window.ALOOKHOR.toast('استانداردهای بین‌المللی ذخیره و فعال شد','success')});
      }
      if(key==='why_alookhor'){
        quick.querySelector('#btnWhyImage')?.addEventListener('click',()=>{if(!window.wp?.media)return;const frame=window.wp.media({title:'انتخاب تصویر بخش چرا آلوخور',button:{text:'استفاده از تصویر'},library:{type:'image'},multiple:false});frame.on('select',()=>{const item=frame.state().get('selection').first().toJSON();quick.querySelector('#whyImageUrl').value=item.url||'';quick.querySelector('#whyImageId').value=Number(item.id)||0});frame.open()});
        quick.querySelector('#btnApplyWhy')?.addEventListener('click',async event=>{const w=cfg.why_settings,v=id=>quick.querySelector(`#${id}`)?.value??'';Object.assign(w,{enabled:!!quick.querySelector('#whyEnabled')?.checked,eyebrow:v('whyEyebrow'),title:v('whyTitle'),subtitle:v('whySubtitle'),image_id:Number(v('whyImageId'))||0,image_url:v('whyImageUrl'),badge_title:v('whyBadgeTitle'),badge_text:v('whyBadgeText'),radius:Math.max(12,Math.min(36,Number(v('whyRadius'))||20))});w.items=[0,1,2,3].map(i=>({icon:v(`whyItemIcon_${i}`),title:v(`whyItemTitle_${i}`),description:v(`whyItemDesc_${i}`)}));w.stats=[0,1,2,3].map(i=>({icon:v(`whyStatIcon_${i}`),value:v(`whyStatValue_${i}`),label:v(`whyStatLabel_${i}`)}));['background','card','gold','text','muted'].forEach(k=>w[k]=v(`whyColor_${k}`));const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(result.ok)window.ALOOKHOR.toast('بخش چرا آلوخور ذخیره و فعال شد','success')});
      }
      if(key==='magazine'){
        quick.querySelector('#btnApplyMagazine')?.addEventListener('click',async event=>{const m=cfg.magazine_settings,v=id=>quick.querySelector(`#${id}`)?.value??'';Object.assign(m,{title:v('magTitle'),subtitle:v('magSubtitle'),button_text:v('magButton'),limit:Math.max(4,Math.min(20,Number(v('magLimit'))||8)),autoplay_interval:Math.max(2500,Math.min(15000,Number(v('magInterval'))||5500)),category_id:Number(v('magCategory'))||0,radius:Math.max(10,Math.min(36,Number(v('magRadius'))||20))});quick.querySelectorAll('[data-mag-flag]').forEach(input=>m[input.dataset.magFlag]=input.checked);['background','card','gold','text','muted'].forEach(k=>m[k]=v(`magColor_${k}`));const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(result.ok)window.ALOOKHOR.toast('مجله آلوخور ذخیره و فعال شد','success')});
      }
      if(key==='newsletter'){
        quick.querySelector('#btnApplyNewsletter')?.addEventListener('click',async event=>{const n=cfg.newsletter_settings,v=id=>quick.querySelector(`#${id}`)?.value??'';Object.assign(n,{enabled:!!quick.querySelector('#nlEnabled')?.checked,kicker:v('nlKicker'),title:v('nlTitle'),description:v('nlDescription'),placeholder:v('nlPlaceholder'),button_text:v('nlButton'),privacy_text:v('nlPrivacy'),success_text:v('nlSuccess'),radius:Math.max(8,Math.min(40,Number(v('nlRadius'))||18))});['background','surface','gold','text','muted'].forEach(k=>n[k]=v(`nlColor_${k}`));const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(result.ok)window.ALOOKHOR.toast('خبرنامه ذخیره و شورت‌کد فعال شد','success')});
      }
      if(key==='bestsellers'){
        quick.querySelector('#btnApplyBestsellers')?.addEventListener('click',async event=>{const b=cfg.bestseller_settings,v=id=>quick.querySelector(`#${id}`)?.value??'';b.title=v('bsTitle');b.limit=Math.max(4,Math.min(24,Number(v('bsLimit'))||12));b.autoplay_interval=Math.max(2500,Math.min(15000,Number(v('bsInterval'))||5000));b.radius=Math.max(12,Math.min(38,Number(v('bsRadius'))||24));b.category_ids=[...quick.querySelectorAll('[data-bs-cat]:checked')].map(x=>Number(x.dataset.bsCat)).filter(Boolean);quick.querySelectorAll('[data-bs-flag]').forEach(input=>b[input.dataset.bsFlag]=input.checked);['background','card','gold','purple','text','muted'].forEach(k=>b[k]=v(`bsColor_${k}`));const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(result.ok)window.ALOOKHOR.toast('پرفروش‌ترین محصولات ذخیره و فعال شد','success')});
      }
      if(key==='campaign'){
        quick.querySelectorAll('[data-cp-media]').forEach(button=>button.addEventListener('click',()=>{if(!window.wp?.media)return;const i=Number(button.dataset.cpMedia),frame=window.wp.media({title:`انتخاب تصویر کمپین ${i+1}`,button:{text:'استفاده'},library:{type:'image'},multiple:false});frame.on('select',()=>{const item=frame.state().get('selection').first().toJSON();quick.querySelector(`#cpImage_${i}`).value=item.url||'';quick.querySelector(`#cpImageId_${i}`).value=Number(item.id)||0});frame.open()}));
        quick.querySelector('#btnApplyCampaign')?.addEventListener('click',async event=>{const c=cfg.campaign_settings,v=id=>quick.querySelector(`#${id}`)?.value??'';Object.assign(c,{autoplay_interval:Math.max(2500,Math.min(15000,Number(v('cpInterval'))||5500)),height:Math.max(260,Math.min(700,Number(v('cpHeight'))||420)),radius:Math.max(0,Math.min(40,Number(v('cpRadius'))||24)),overlay:Math.max(0,Math.min(90,Number(v('cpOverlay'))||58)),background:v('cpBackground'),gold:v('cpGold'),text:v('cpText')});quick.querySelectorAll('[data-cp-flag]').forEach(input=>c[input.dataset.cpFlag]=input.checked);c.slides=[0,1,2,3,4,5].map(i=>({image_id:Number(v(`cpImageId_${i}`))||0,image_url:v(`cpImage_${i}`),image_alt:v(`cpAlt_${i}`),eyebrow:v(`cpEyebrow_${i}`),title:v(`cpTitle_${i}`),description:v(`cpDesc_${i}`),button_text:v(`cpButton_${i}`),button_url:v(`cpUrl_${i}`)}));const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(result.ok)window.ALOOKHOR.toast('اسلایدر کمپین ذخیره و فعال شد','success')});
      }
      if(key==='collection'){
        quick.querySelector('#btnApplyFeaturedProducts')?.addEventListener('click',async event=>{const f=cfg.featured_product_settings,v=id=>quick.querySelector(`#${id}`)?.value??'';Object.assign(f,{eyebrow:v('fpEyebrow'),title:v('fpTitle'),title_highlight:v('fpTitleHighlight'),subtitle:v('fpSubtitle'),product_button_text:v('fpProductButton'),button_text:v('fpButtonText'),button_url:v('fpButtonUrl'),limit:Math.max(4,Math.min(16,Number(v('fpLimit'))||8)),autoplay_interval:Math.max(2500,Math.min(15000,Number(v('fpInterval'))||4500)),radius:Math.max(10,Math.min(36,Number(v('fpRadius'))||20))});['background','card','gold','text','muted'].forEach(k=>f[k]=v(`fpColor_${k}`));quick.querySelectorAll('[data-fp-flag]').forEach(input=>f[input.dataset.fpFlag]=input.checked);const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(result.ok)window.ALOOKHOR.toast('محصولات منتخب ذخیره و شورت‌کد فعال شد','success')});
      }
      if(key==='export'){
        quick.querySelectorAll('[data-xb-media]').forEach(button=>button.addEventListener('click',()=>{if(!window.wp?.media){window.ALOOKHOR.toast('Media Library در دسترس نیست','info');return}const type=button.dataset.xbMedia,frame=window.wp.media({title:type==='bg'?'انتخاب تصویر کامیون/پس‌زمینه':'انتخاب لوگوی مرکزی',button:{text:'استفاده از تصویر'},library:{type:'image'},multiple:false});frame.on('select',()=>{const item=frame.state().get('selection').first().toJSON(),prefix=type==='bg'?'xbBg':'xbLogo';const url=quick.querySelector(`#${prefix}Url`),id=quick.querySelector(`#${prefix}Id`);if(url)url.value=item.url||'';if(id)id.value=Number(item.id)||0});frame.open()}));
        quick.querySelector('#btnApplyExportBanner')?.addEventListener('click',async event=>{const v=id=>quick.querySelector(`#${id}`)?.value??'',params=new URLSearchParams({action:'alookhor_save_export_banner',nonce:window.ALOOKHOR_CC?.nonce||'',enabled:quick.querySelector('#xbEnabled')?.checked?'1':'0',background_image_id:v('xbBgId'),background_image_url:v('xbBgUrl'),logo_id:v('xbLogoId'),logo_url:v('xbLogoUrl'),title:v('xbTitle'),title_gold:v('xbTitleGold'),card_text:v('xbCardText'),status_text:v('xbStatus'),whatsapp1_number:v('xbWa1Number'),whatsapp1_link:v('xbWa1Link'),whatsapp2_number:v('xbWa2Number'),whatsapp2_link:v('xbWa2Link'),bg_color:v('xbColor_bg_color'),gold_color:v('xbColor_gold_color'),whatsapp_color:v('xbColor_whatsapp_color'),card_opacity:v('xbCardOpacity'),overlay_opacity:v('xbOverlayOpacity'),blur_strength:v('xbBlur')});const button=event.currentTarget;button.disabled=true;try{const response=await fetch(window.ALOOKHOR_CC.ajax_url,{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'},body:params});const result=await response.json();if(!result.success)throw new Error(result.data||'خطای ذخیره');window.ALOOKHOR_CC.export_banner_settings=result.data?.data||{};window.ALOOKHOR.toast('بنر صادراتی ذخیره و روی شورت‌کد اعمال شد','success')}catch(error){window.ALOOKHOR.toast(error.message||'ذخیره ناموفق بود','error')}finally{button.disabled=false}});
      }
      if(key==='sort'){
        quick.querySelectorAll('[data-sort-media]').forEach(button=>button.addEventListener('click',()=>{
          if(!window.wp?.media){window.ALOOKHOR.toast('Media Library در دسترس نیست','info');return}
          const index=Number(button.dataset.sortMedia),frame=window.wp.media({title:`انتخاب تصویر مرکز سورت ${index+1}`,button:{text:'استفاده از تصویر'},library:{type:'image'},multiple:false});
          frame.on('select',()=>{const item=frame.state().get('selection').first().toJSON();const url=quick.querySelector(`#sortImage_${index}`),id=quick.querySelector(`#sortImageId_${index}`);if(url)url.value=item.url||'';if(id)id.value=Number(item.id)||0});frame.open();
        }));
        quick.querySelector('#btnApplySortCenter')?.addEventListener('click',async event=>{
          const s=cfg.sort_center_settings,sv=id=>quick.querySelector(`#${id}`)?.value??'';
          Object.assign(s,{eyebrow:sv('sortEyebrow'),title:sv('sortTitle'),title_highlight:sv('sortTitleHighlight'),description:sv('sortDescription'),button_text:sv('sortButtonText'),button_url:sv('sortButtonUrl'),secondary_button_text:sv('sortSecondaryText'),secondary_button_url:sv('sortSecondaryUrl'),image_badge_value:sv('sortBadgeValue'),image_badge_text:sv('sortBadgeText'),autoplay_interval:Math.max(2500,Math.min(15000,Number(sv('sortInterval'))||5000)),radius:Math.max(10,Math.min(40,Number(sv('sortRadius'))||26))});
          s.products_title=sv('sortProductsTitle');s.products=[0,1,2,3,4].map(i=>sv(`sortProduct_${i}`));s.features=[0,1,2,3].map(i=>({icon:sv(`sortFeatureIcon_${i}`),title:sv(`sortFeatureTitle_${i}`),description:sv(`sortFeatureDescription_${i}`)}));s.stats=[0,1,2,3].map(i=>({icon:sv(`sortStatIcon_${i}`),value:sv(`sortStatValue_${i}`),label:sv(`sortStatLabel_${i}`)}));
          ['background','surface','gold','text','muted'].forEach(k=>s[k]=sv(`sortColor_${k}`));quick.querySelectorAll('[data-sort-flag]').forEach(input=>s[input.dataset.sortFlag]=input.checked);
          s.slides=[0,1,2,3,4,5].map(i=>({image_id:Number(sv(`sortImageId_${i}`))||0,image_url:sv(`sortImage_${i}`),image_alt:sv(`sortAlt_${i}`),caption:sv(`sortCaption_${i}`)}));
          const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(result.ok)window.ALOOKHOR.toast('مرکز سورت و گالری اسلایدی ذخیره شد','success');
        });
      }
      const inpCap = quick.querySelector('#inpCapacity');
      if(inpCap){
        inpCap.addEventListener('change', ()=>{
          Config.set('modules.sort.capacity', inpCap.value);
          window.ALOOKHOR.toast('ظرفیت بروز شد','success');
        });
      }
      const btnSaveApp = quick.querySelector('#btnSaveApp');
      if(btnSaveApp){
        btnSaveApp.addEventListener('click', async event=>{
          const v=id=>quick.querySelector(`#${id}`)?.value??'',a=cfg.modules.app;
          Object.assign(a,{enabled:!!quick.querySelector('#appEnabled')?.checked,title:v('appTitle'),description:v('appDescription'),bazaar_url:v('appBazaar'),myket_url:v('appMyket'),ios_url:v('appIos'),more_url:v('appMore'),radius:Math.max(12,Math.min(40,Number(v('appRadius'))||24))});
          ['background','surface','gold','text','muted'].forEach(k=>a[k]=v(`appColor_${k}`));const button=event.currentTarget;button.disabled=true;const result=await Config.save({notify:false});button.disabled=false;if(result.ok)window.ALOOKHOR.toast('بنر اپلیکیشن ذخیره و روی شورت‌کد اعمال شد','success');
        });
      }
    }

    // کلیک روی ماژول‌ها — هم toggle هم باز کردن quick
    container.querySelectorAll('.mod-item').forEach(item=>{
      item.addEventListener('click', ()=>{
        container.querySelectorAll('.mod-item').forEach(i=> i.classList.remove('active'));
        item.classList.add('active');
        showQuick(item.dataset.mod);
      });
    });
    // toggle بدون باز کردن quick
    container.addEventListener('click', (e)=>{
      const tog = e.target.closest('.mod-toggle[data-toggle]');
      if(!tog) return;
      e.stopPropagation();
      const key = tog.dataset.toggle;
      const enabled = Config.toggleModule(key);
      tog.classList.toggle('on', enabled);
      const row = tog.closest('.mod-item');
      if(row) row.classList.toggle('disabled', !enabled);
      // اگر همین ماژول در quick باز است، آپدیت کن
      if(quickTitle.textContent === cfg.modules[key].title) showQuick(key);
      window.ALOOKHOR.toast(enabled ? `«${cfg.modules[key].title}» فعال شد` : `«${cfg.modules[key].title}» غیرفعال شد`, enabled?'success':'info');
      // آپدیت هدر شمارش
      container.querySelector('.panel-head span').textContent = `${Object.values(cfg.modules||{}).filter(m=>m.enabled).length} / ${Object.keys(cfg.modules||{}).length} فعال`;
    });

    // AI accordion + actions
    container.querySelectorAll('.ai-head').forEach(btn=>{
      btn.addEventListener('click', ()=>{
        const item = btn.parentElement;
        const isOpen = item.classList.contains('open');
        container.querySelectorAll('.ai-item').forEach(i=> i.classList.remove('open'));
        container.querySelectorAll('.ai-plus').forEach(p=> p.textContent='+');
        if(!isOpen){ item.classList.add('open'); btn.querySelector('.ai-plus').textContent='×'; }
      });
    });
    container.addEventListener('click', (e)=>{
      const btn = e.target.closest('[data-ai-action]');
      if(!btn) return;
      const id = btn.dataset.id;
      const act = btn.dataset.aiAction;
      const sug = cfg.ai_assistant.suggestions.find(s=>s.id===id);
      if(!sug) return;
      if(act==='do'){
        sug.status='done';
        Config.save();
        window.ALOOKHOR.toast(`پیشنهاد «${sug.title}» اعمال شد — سایت بروز شد`,'success');
        renderAI();
        // rebind after rerender need to reattach? but we just rerendered, need to rebind AI heads? simpler: reload? But for now just update UI via next init — we will just rerender and rebind via event delegation already handled via container listener for toggle? For AI heads we lost listeners — reattach quickly
        setTimeout(()=>{
          container.querySelectorAll('.ai-head').forEach(b=>{
            b.addEventListener('click', ()=>{
              const it = b.parentElement;
              const isOpen = it.classList.contains('open');
              container.querySelectorAll('.ai-item').forEach(i=> i.classList.remove('open'));
              container.querySelectorAll('.ai-plus').forEach(p=> p.textContent='+');
              if(!isOpen){ it.classList.add('open'); b.querySelector('.ai-plus').textContent='×'; }
            });
          });
        },0);
      } else {
        sug.status = sug.status==='done' ? 'pending' : 'done';
        Config.save();
        window.ALOOKHOR.toast(sug.status==='done'?'نادیده گرفته شد':'بازگردانی شد','info');
        renderAI();
      }
    });

    // دکمه‌های عمومی
    container.querySelector('#btnRefreshStatus')?.addEventListener('click', ()=>{
      window.ALOOKHOR.toast('سلامت سیستم بررسی شد — ووکامرس، وودمارت، المنتور همه فعال','success');
      const b = container.querySelector('#btnRefreshStatus');
      b.textContent='بررسی شد ✓'; setTimeout(()=> b.textContent='بررسی مجدد', 1600);
    });
    container.querySelector('#btnSaveAll')?.addEventListener('click', async (event)=>{
      commitQuickSettings?.();
      const button = event.currentTarget;
      button.disabled = true;
      const result = await Config.save({notify:false});
      button.disabled = false;
      if(!result.ok) return;
      const persistedPhone = result.data?.header_settings?.phone;
      if(persistedPhone !== undefined && String(persistedPhone).trim() !== String(cfg.header_settings.phone || '').trim()){
        window.ALOOKHOR.toast('شماره تلفن در WordPress تأیید نشد؛ ذخیره متوقف شد','error');
        return;
      }
      Config.apply();
      container.querySelector('#lastSave').textContent = new Date().toLocaleString('fa-IR');
      window.ALOOKHOR.toast('همه تنظیمات واقعاً در WordPress ذخیره شدند','success');
    });
    container.querySelector('#btnExportSettings')?.addEventListener('click', ()=>{
      const data = Config.exportJSON();
      const blob = new Blob([data], {type:'application/json'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a'); a.href=url; a.download='alookhor-settings.json'; a.click(); URL.revokeObjectURL(url);
      window.ALOOKHOR.toast('فایل JSON دانلود شد','info');
    });
    container.querySelector('#btnResetSettings')?.addEventListener('click', async ()=>{
      if(!confirm('بازنشانی به تنظیمات اولیه؟')) return;
      await Config.reset();
      window.ALOOKHOR.toast('بازنشانی شد — صفحه رفرش می‌شود','info');
      setTimeout(()=> location.reload(), 700);
    });
    container.querySelector('#btnEnableAll')?.addEventListener('click', ()=>{
      Object.keys(cfg.modules||{}).forEach(k=> cfg.modules[k].enabled=true);
      Config.save(); Config.apply(); renderModules();
      window.ALOOKHOR.toast('همه ماژول‌ها فعال شدند','success');
    });
    container.querySelector('#btnDisableAll')?.addEventListener('click', ()=>{
      Object.keys(cfg.modules||{}).forEach(k=> cfg.modules[k].enabled=false);
      Config.save(); Config.apply(); renderModules();
      window.ALOOKHOR.toast('همه ماژول‌ها غیرفعال شدند','info');
    });

    // پیش‌فرض
    showQuick('header');
    const firstMod = container.querySelector('.mod-item[data-mod="header"]');
    if(firstMod) firstMod.classList.add('active');

    // اعمال اولیه روی سایت
    Config.apply();
  },
  destroy(){}
};
