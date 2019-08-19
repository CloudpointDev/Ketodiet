function show_hide_boxes(val) {
    switch (val) {
        case 'video':
            jQuery('#post_slides, #post_quote, #post_audio, #post_link, #post_standard').css({'display':'none'})
             jQuery('#post_video').slideDown('normal');
            break;
        case 'audio':
            jQuery('#post_slides, #post_video, #post_quote, #post_link, #post_standard').css({'display':'none'})
             jQuery('#post_audio').slideDown('normal');
            break;
        case 'gallery':
            jQuery('#post_quote, #post_video, #post_audio, #post_link, #post_standard').css({'display':'none'})
            jQuery('#post_slides').slideDown('normal');
            break;
        case 'link':
            jQuery('#post_slides, #post_video, #post_audio, #post_quote, #post_standard').css({'display':'none'})
            jQuery('#post_link').slideDown('normal');
            break;
        case 'quote':
            jQuery('#post_slides, #post_video, #post_audio, #post_link, #post_standard').css({'display':'none'})
            jQuery('#post_quote').slideDown('normal');
            break;
        default:
            jQuery('#post_slides, #post_video, #post_audio, #post_link, #post_quote').css({'display':'none'})
            jQuery('#post_standard').slideDown('normal');
    }
}
jQuery(document).ready(function(){
    jQuery('#post_slides, #post_video, #post_audio, #post_link, #post_quote, #post_standard').addClass('hide-if-js');
       show_hide_boxes(jQuery('input:radio[name="post_format"]:checked').val());
	jQuery('input:radio[name="post_format"]').change(function(){
	    show_hide_boxes(jQuery(this).val());
	});

    jQuery("input.rwmb-checkbox").each(function(){
        if (jQuery(this).is(":checked")){ 
            jQuery(this).val('1');
        } else {
            jQuery(this).val('0');
        }
        jQuery('input.rwmb-checkbox').change(function(){
            if (jQuery(this).is(":checked")){ 
                jQuery(this).val('1');
            } else {
                jQuery(this).val('0');
            }
        });
    });

});
jQuery(window).on('load', function(){
    if(jQuery('body').hasClass('block-editor-page')){
        var postFormat = wp.data.select('core/editor').getEditedPostAttribute('format');
        show_hide_boxes(postFormat);
    }
});
jQuery(document).on('change', 'select[id*="post-format"]',function(){
    show_hide_boxes(this.value);
});
