jQuery(document).on('click','.sblh-ignore',function(e){
e.preventDefault();
jQuery.post(sblhData.ajaxUrl,{action:'sblh_ignore_link',nonce:sblhData.nonce,post_id:jQuery(this).data('post'),url:jQuery(this).data('url')},()=>jQuery(this).closest('li').fadeOut());
});
jQuery('#sblh-bulk-recheck').on('click',function(){
const posts=[];jQuery('.sblh-post:checked').each(function(){posts.push(jQuery(this).val());});
jQuery.post(sblhData.ajaxUrl,{action:'sblh_bulk_recheck',nonce:sblhData.nonce,posts:posts},()=>alert('Recheck completed'));
});
