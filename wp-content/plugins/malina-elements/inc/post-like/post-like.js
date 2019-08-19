jQuery(document).ready(function() {
    jQuery("body").on('click', '.item-like a', function(){
    	heart = jQuery(this);
        post_id = heart.data("post_id");
        jQuery.ajax({
            type: "post",
            url: malina_like_post.url,
            data: "action=post-like&nonce=" + malina_like_post.nonce + "&post_like=&post_id=" + post_id,
            success: function(a) {
                if (a != "already") {
                    heart.addClass("voted");
                    heart.find('span.like i').removeClass('la-heart-o').addClass('la-heart');
                    heart.next(".count").text(a)
                }
            }
        });
        return false;
    });
});