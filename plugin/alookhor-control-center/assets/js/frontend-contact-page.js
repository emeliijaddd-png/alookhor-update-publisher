(()=>{'use strict';
function rewrite(){const target=window.ALOOKHOR_CONTACT?.contact_url;if(!target)return;document.querySelectorAll('a[href]').forEach(link=>{const text=(link.textContent||'').replace(/\s+/g,' ').trim(),href=link.getAttribute('href')||'';if(text.includes('تماس با ما')||text.includes('お問い合わせ')||/\/contact\/?(?:#.*)?$/i.test(href)||href.includes('%D8%AA%D9%85%D8%A7%D8%B3-%D8%A8%D8%A7-%D9%85%D8%A7')||href.includes('تماس-با-ما'))link.href=target})}
function mark(input,bad){input.classList.toggle('is-invalid',bad);if('ariaInvalid' in input)input.setAttribute('aria-invalid',bad?'true':'false')}
function validate(form){let ok=true;form.querySelectorAll('input[name],select[name],textarea[name]').forEach(el=>{if(!el.matches('[required]'))return;const bad=el.type==='checkbox'?!el.checked:!el.checkValidity();mark(el,bad);if(bad&&ok){ok=false;typeof el.focus==='function'&&el.focus()}});return ok}
function init(form){if(form.dataset.ready)return;form.dataset.ready='1';
 form.addEventListener('input',e=>{const el=e.target;if(el.matches('.is-invalid'))mark(el,el.type==='checkbox'?!el.checked:!el.checkValidity())});
 form.addEventListener('change',e=>{const el=e.target;if(el.type==='checkbox'&&el.matches('.is-invalid'))mark(el,!el.checked)});
 form.addEventListener('submit',async event=>{event.preventDefault();
  const message=form.querySelector('.acp-msg'),button=form.querySelector('button[type=submit]'),label=button.querySelector('span');
  message.classList.remove('is-error');message.textContent='';
  if(!validate(form)){message.textContent='لطفاً فیلدهای مشخص‌شده را کامل کنید.';message.classList.add('is-error');return}
  const idle=label.textContent;button.disabled=true;button.classList.add('is-busy');label.textContent='در حال ارسال…';
  const data=new FormData(form);data.append('action','alookhor_contact_submit');
  try{const response=await fetch(window.ALOOKHOR_CONTACT?.ajax_url||'/wp-admin/admin-ajax.php',{method:'POST',body:data,credentials:'same-origin'}),result=await response.json();
   if(!result.success)throw Error(result.data?.message||'ارسال پیام انجام نشد.');
   message.textContent=result.data.message;form.reset();form.querySelectorAll('.is-invalid').forEach(el=>el.classList.remove('is-invalid'));form.classList.add('acp-sent');setTimeout(()=>form.classList.remove('acp-sent'),800);
  }catch(error){message.textContent=error.message;message.classList.add('is-error')}
  finally{button.disabled=false;button.classList.remove('is-busy');label.textContent=idle;message.scrollIntoView({block:'nearest',behavior:'smooth'})}})}
function faq(root){if(root.dataset.ready)return;root.dataset.ready='1';const items=root.querySelectorAll('details.acp-faq-item');items.forEach(item=>item.addEventListener('toggle',()=>{if(item.open)items.forEach(other=>{if(other!==item)other.open=false})}))}
function boot(){rewrite();document.querySelectorAll('.alookhor-acp-form').forEach(init);document.querySelectorAll('.alookhor-acp-faq').forEach(faq)}
document.readyState==='loading'?document.addEventListener('DOMContentLoaded',boot):boot();new MutationObserver(boot).observe(document.documentElement,{childList:true,subtree:true})
})();
