<?php
/**
 * Plugin Name: Malina Elements
 * Description: This plugin is required for use with Malina theme. It gathers all shortcodes and elements from Malina theme. It gives a possibility to keep this content data even if you switch the theme to another one. This is a part of new Envato requirements for WordPress theme developers.
 * Version: 1.3.9
 * Author: Artstudioworks
 * Author URI: http://themeforest.net/user/artstudioworks/portfolio
 * Text Domain: malina-elements
 * Domain Path: /languages
*/

add_action( 'plugins_loaded', 'malina_plugin_load_textdomain' );
/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function malina_plugin_load_textdomain() {
  load_plugin_textdomain( 'malina-elements', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

$dir = plugin_dir_path( __FILE__ );
define( 'MALINA_PLUGIN_URL',  plugin_dir_url( __FILE__ ) );
define( 'MALINA_PLUGIN_PATH',  plugin_dir_path( __FILE__ ) );
include_once ( trailingslashit( $dir ).'inc/update.php' );
include_once ( trailingslashit( $dir ).'inc/shortcodes.php' );
include_once ( trailingslashit( $dir ).'inc/customcss.php' );
include_once ( trailingslashit( $dir ).'inc/post-like/post-like-core.php' );//post like features
include_once ( trailingslashit( $dir ).'inc/post-view/post-view.php' );//post view features
//iclude widgets
include_once(trailingslashit( $dir ).'inc/widgets/twitter.php' );
include_once(trailingslashit( $dir ).'inc/widgets/socials.php'); // add socials widget
include_once(trailingslashit( $dir ).'inc/widgets/aboutme.php'); // add aboutMe widget
include_once(trailingslashit( $dir ).'inc/widgets/recentposts.php'); // add grid posts widget
include_once(trailingslashit( $dir ).'inc/widgets/bannerspot.php'); // add banner spot widget
include_once(trailingslashit( $dir ).'inc/widgets/latestposts.php'); // add latest posts widget
include_once(trailingslashit( $dir ).'inc/widgets/sliderposts.php'); // add slider posts widget
include_once(trailingslashit( $dir ).'inc/widgets/instagram.php'); // add instagram widget
include_once(trailingslashit( $dir ).'inc/widgets/subscribe.php'); // add instagram widget
include_once(trailingslashit( $dir ).'inc/widgets/map.php'); // add map widget
include_once(trailingslashit( $dir ).'inc/widgets/category.php' );
include_once(trailingslashit( $dir ).'inc/widgets/youtube_channel.php' );
/* Include Meta Box Script */
include_once(trailingslashit( $dir ).'inc/meta-boxes.php');

/* Include gutenberg blocks */
if( function_exists('register_block_type') ){
	include_once(trailingslashit($dir).'inc/gutenberg/gutenberg-blocks.php');
}
if(class_exists('WPBakeryVisualComposerAbstract')) {
	function malina_deactivate_vc_notice() {
	    if(is_admin()) {
	        setcookie('vchideactivationmsg', '1', strtotime('+3 years'), '/');
	        setcookie('vchideactivationmsg_vc11', (defined('WPB_VC_VERSION') ? WPB_VC_VERSION : '1'), strtotime('+3 years'), '/');
	    }
	}
	add_action('admin_init', 'malina_deactivate_vc_notice');
	include_once( trailingslashit( $dir ).'inc/vc-shortcodes.php');
}
if( !class_exists('WPBakeryVisualComposerAbstract') ) {
	include_once( trailingslashit( $dir ).'inc/vc-google-font.php');
}
if ( class_exists('RevSlider') ) {
	add_action( 'admin_init', 'malina_disable_revslider_notice' );
	function malina_disable_revslider_notice() {
		update_option( 'revslider-valid-notice', 'false' );
	}
}

function malina_shortcodes_scripts() {  
	wp_register_script('owl-carousel', MALINA_PLUGIN_URL . 'js/owl.carousel.min.js', array('jquery'), '2.3.4', TRUE);
	wp_register_script('isotope', MALINA_PLUGIN_URL . 'js/isotope.min.js', array('jquery'), '3.0.0', true);
}
add_action( 'wp_enqueue_scripts', 'malina_shortcodes_scripts' );
function malina_shortcodes_styles() {  
	wp_register_style( 'owl-carousel', MALINA_PLUGIN_URL . 'css/owl.carousel.css', array(), '2.3.4', 'all' );
}
add_action( 'wp_enqueue_scripts', 'malina_shortcodes_styles', 5);

if( function_exists('register_block_type') ){
	function malina_gutenberg_editor_styles() {
		wp_enqueue_style( 'malina-blocks-grid', MALINA_PLUGIN_URL . 'inc/gutenberg/css/grid.css');
	    wp_enqueue_style( 'malina-blocks-style', MALINA_PLUGIN_URL . 'inc/gutenberg/css/style.css');
	    wp_enqueue_style( 'malina-blocks-lineawesome', MALINA_PLUGIN_URL . 'inc/gutenberg/fonts/line-awesome/css/line-awesome.min.css');
	    wp_enqueue_style( 'malina-blocks-fontawesome', MALINA_PLUGIN_URL . 'inc/gutenberg/fonts/font-awesome/css/font-awesome.min.css');
	}
	add_action( 'enqueue_block_editor_assets', 'malina_gutenberg_editor_styles', 100 );
}

function malina_admin_scripts( $hook ) {
    global $post;
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'post' === $post->post_type ) {     
            wp_enqueue_script(  'malina-post-formats-select', MALINA_PLUGIN_URL . 'js/post-formats-select.js', array('jquery'), '1.0.0', true );
        }
    }
}
add_action( 'admin_enqueue_scripts', 'malina_admin_scripts', 10, 1 );


if(!function_exists('MalinaSharebox')){
	function MalinaSharebox($postID, $echo = false){
		if($postID != ''){
			$permalink = esc_url(get_permalink($postID));
			$title = esc_attr(get_the_title($postID));
			$description = esc_attr(get_the_title($postID));
		} else if(is_front_page()){
			$permalink = esc_url(home_url());
			$title = esc_attr(get_bloginfo('name'));
			$description = esc_attr(get_bloginfo('description'));
		} else {
			$permalink = esc_url(get_permalink($postID));
			$title = esc_attr(get_the_title($postID));
			$description = esc_attr(get_the_title($postID));
		}

		$out = '<div class="sharebox">';
			$out .= '<div class="social-icons">';
				$out .= '<ul class="unstyled">';
					if( get_theme_mod('malina_sharing_facebook',true) ) $out .= '<li class="social-facebook"><a href="//www.facebook.com/sharer.php?u='.esc_url($permalink).'&amp;t='.str_replace(' ', '+', $title).'" title="'.esc_html__( 'Share to Facebook', 'malina-elements').'" target="_blank"><i class="fab fa-facebook-f"></i></a></li>';
					if( get_theme_mod('malina_sharing_twitter',true) ) $out .= '<li class="social-twitter"><a href="//twitter.com/share?url='.esc_url($permalink).'" title="'.esc_html__( 'Share to Twitter', 'malina-elements').'" target="_blank"><i class="fab fa-twitter"></i></a></li>';	
					if( get_theme_mod('malina_sharing_pinterest',true) ) $out .= '<li class="social-pinterest"><a href="//pinterest.com/pin/create/link/?url='.esc_url($permalink).'&amp;media='.wp_get_attachment_url( get_post_thumbnail_id($postID) ).'&amp;description='.str_replace(" ", "+", $description).'" title="'.esc_html__( 'Share to Pinterest', 'malina-elements').'" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>';
					if( get_theme_mod('malina_sharing_whatsapp', false) ) $out .= '<li class="social-whatsapp"><a href="https://wa.me/?text='.esc_url($permalink).'" data-action="share/whatsapp/share" target="_blank" title="'.esc_html__('Share with Whatsapp', 'malina-elements').'"><i class="fab fa-whatsapp"></i></a></li>';
					if( get_theme_mod('malina_sharing_linkedin',false) ) $out .= '<li class="social-linkedin"><a href="http://linkedin.com/shareArticle?mini=true&amp;url='.esc_url($permalink).'&amp;title='.str_replace(' ', '+', $title).'" title="'.esc_html__( 'Share to LinkedIn', 'malina-elements').'" target="_blank"><i class="fab fa-linkedin"></i></a></li>';
					if( get_theme_mod('malina_sharing_googleplus',false) ) $out .= '<li class="social-googleplus"><a href="http://plus.google.com/share?url='.esc_url($permalink).'&amp;title='.str_replace(' ', '+', $title).'" title="'.esc_html__( 'Share To Google+', 'malina-elements').'" target="_blank"><i class="fab fa-google-plus"></i></a></li>';
					if( get_theme_mod('malina_sharing_email',false) ) $out .= '<li class="social-email"><a href="mailto:?subject='.str_replace(' ', '+', $title).'&amp;body='.esc_url($permalink).'" title="'.esc_html__( 'Share with E-Mail', 'malina-elements').'" target="_blank"><i class="fa fa-envelope"></i></a></li>';
				$out .= '</ul>';
			$out .= '</div>';
		$out .= '</div>';
		if($echo){
			echo $out;
		} else {
			return $out;
		}
	}
}
if( !function_exists('add_twitter_og_image')){
	function add_twitter_og_image(){
		if( is_single() && get_theme_mod('malina_sharing_twitter',true) ){
			global $post;
			$twitter_url    = get_permalink();
			 $twitter_title  = get_the_title();
			 $twitter_desc   = get_the_excerpt();
			   $twitter_thumbs = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
				$twitter_thumb  = $twitter_thumbs[0];
				  if(!$twitter_thumb) {
				  $twitter_thumb = 'http://www.gravatar.com/avatar/8eb9ee80d39f13cbbad56da88ef3a6ee?rating=PG&size=75';
				}
			?>
			<meta name="twitter:card" value="summary" />
			<meta name="twitter:url" value="<?php echo $twitter_url; ?>" />
			<meta name="twitter:title" value="<?php echo $twitter_title; ?>" />
			<meta name="twitter:description" value="<?php echo $twitter_desc; ?>" />
			<meta name="twitter:image" value="<?php echo $twitter_thumb; ?>" />
			<?php
		}
	}
	add_action('wp_head', 'add_twitter_og_image');
}
if(!function_exists('MalinaStickySharebox')){
	function MalinaStickySharebox($postID, $echo = false){
		if($postID != ''){
			$permalink = esc_url(get_permalink($postID));
			$title = esc_attr(get_the_title($postID));
			$description = esc_attr(get_the_title($postID));
		} else if(is_front_page()){
			$permalink = esc_url(home_url());
			$title = esc_attr(get_bloginfo('name'));
			$description = esc_attr(get_bloginfo('description'));
		} else {
			$permalink = esc_url(get_permalink($postID));
			$title = esc_attr(get_the_title($postID));
			$description = esc_attr(get_the_title($postID));
		}

		$out = '<div class="sharebox sharebox-sticky">';
			$out .= '<div class="social-icons">';
				$out .= '<span class="share-text">'.esc_html__('Share','malina-elements').'</span>';
				$out .= '<ul class="unstyled">';
					if( get_theme_mod('malina_sharing_facebook',true) ) $out .= '<li class="social-facebook"><a href="//www.facebook.com/sharer.php?u='.esc_url($permalink).'&amp;t='.str_replace(' ', '+', $title).'" title="'.esc_html__( 'Share to Facebook', 'malina-elements').'" target="_blank"><i class="fab fa-facebook-f"></i></a></li>';
					if( get_theme_mod('malina_sharing_twitter',true) ) $out .= '<li class="social-twitter"><a href="//twitter.com/home?status='.str_replace(' ', '+', $title).'+'.esc_url($permalink).'" title="'.esc_html__( 'Share to Twitter', 'malina-elements').'" target="_blank"><i class="fab fa-twitter"></i></a></li>';	
					if( get_theme_mod('malina_sharing_pinterest',true) ) $out .= '<li class="social-pinterest"><a href="//pinterest.com/pin/create/link/?url='.esc_url($permalink).'&amp;media='.wp_get_attachment_url( get_post_thumbnail_id($postID) ).'&amp;description='.str_replace(" ", "+", $description).'" title="'.esc_html__( 'Share to Pinterest', 'malina-elements').'" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>';
					if( get_theme_mod('malina_sharing_whatsapp', false) ) $out .= '<li class="social-whatsapp"><a href="https://wa.me/?text='.esc_url($permalink).'" data-action="share/whatsapp/share" target="_blank" title="'.esc_html__('Share with Whatsapp', 'malina-elements').'"><i class="fab fa-whatsapp"></i></a></li>';
					if( get_theme_mod('malina_sharing_linkedin',false) ) $out .= '<li class="social-linkedin"><a href="http://linkedin.com/shareArticle?mini=true&amp;url='.esc_url($permalink).'&amp;title='.str_replace(' ', '+', $title).'" title="'.esc_html__( 'Share to LinkedIn', 'malina-elements').'" target="_blank"><i class="fab fa-linkedin"></i></a></li>';
					if( get_theme_mod('malina_sharing_googleplus',false) ) $out .= '<li class="social-googleplus"><a href="http://plus.google.com/share?url='.esc_url($permalink).'&amp;title='.str_replace(' ', '+', $title).'" title="'.esc_html__( 'Share To Google+', 'malina-elements').'" target="_blank"><i class="fab fa-google-plus"></i></a></li>';
					if( get_theme_mod('malina_sharing_email',false) ) $out .= '<li class="social-email"><a href="mailto:?subject='.str_replace(' ', '+', $title).'&amp;body='.esc_url($permalink).'" title="'.esc_html__( 'Share with E-Mail', 'malina-elements').'" target="_blank"><i class="fa fa-envelope"></i></a></li>';
				$out .= '</ul>';
			$out .= '</div>';
		$out .= '</div>';
		if($echo){
			echo $out;
		} else {
			return $out;
		}
	}
}
if(!function_exists('malina_get_the_content')){
	function malina_get_the_content() {
		$content = get_the_content();
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		return $content;
	}
}
if( !function_exists('malina_get_post_format_content') ){
	function malina_get_post_format_content($echo = true, $img_size) {
		$post_format = get_post_format();
		global $post;
		global $_wp_additional_image_sizes;
		if(!$img_size){
			$img_size = 'post-thumbnail';
		}
		$out = '';
		$width  = get_option( "{$img_size}_size_w" );
		$height = get_option( "{$img_size}_size_h" );
		if( isset($_wp_additional_image_sizes["{$img_size}"]) && (!$width || !$height)){
			$width = $_wp_additional_image_sizes["{$img_size}"]['width'];
			$height = $_wp_additional_image_sizes["{$img_size}"]['height'];
		}
		if( !$width || !$height || $img_size == 'malina-masonry'){
			$proportions = '56.25';
		} else {
			$proportions = ($height/$width) * 100;
		}
		switch ($post_format) {
			case 'gallery':
				$autoplay = rwmb_get_value('malina_gallery_autoplay', $post->ID);
				$loop = rwmb_get_value('malina_gallery_loop', $post->ID);
				if(!$img_size) {
					$img_size = 'medium';
				}
				if($autoplay ){
					$autoplay = 'true';
				} else {
					$autoplay = 'false';
				}
				if($loop) {
					$loop = 'true';
				} else {
					$loop = 'false';
				}
				$id = rand(1, 999);
				$images = rwmb_get_value( 'malina_gallery_images', 'type=image&size='.$img_size, $post->ID );
				if ( !empty($images) ){
					$owl_custom = 'jQuery(window).load(function(){
						var owl = jQuery(".preview-post-gallery'.$id.'").owlCarousel({
				            items:1,
				            autoplay:'.$autoplay.',
				            singleItem:true,
				            loop:'.$loop.',
				            nav:true,
				            navRewind:false,
				            navText: [ \'<i class="la la-angle-left"></i>\',\'<i class="la la-angle-right"></i>\' ],
				            dots:false,
				            autoHeight: true,
				            themeClass: "owl-gallery"
		    			});	
					});';
					wp_add_inline_script('owl-carousel', $owl_custom);
					wp_add_inline_script('image-lightbox', 'jQuery(document).ready( function($){ $( \'a[data-lightbox="lightbox-gallery'.$id.'"]\' ).lightbox(); });');
					$out .= '<div class="preview-post-gallery'.$id.' slideshow_2">';
					foreach( $images as $image ) :
						$out .= '<div><a href="'.esc_url($image['full_url']).'" data-lightbox="lightbox-gallery'.$id.'" data-caption="'.esc_attr($image['caption']).'"><img src="'.esc_url($image['url']).'" alt="'.esc_attr($image['alt']).'" /></a></div>';
					endforeach;
					$out .= '</div>';
				} elseif( has_post_thumbnail() ) {
					$out .= '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, $img_size).'</a></figure>';
				}
				break;
			case 'video':
				$media = rwmb_meta('malina_post_format_video', $post->ID);
				$url = rwmb_get_value( 'malina_post_format_video', $post->ID );
				$proportions_supports = array('cloudup','collegehumor', 'funnyordie', 'flickr', 'youtube', 'dailymotion', 'vimeo', 'ted', 'videopress', 'vine', 'wordpress.tv');
				$check = false;
				foreach ($proportions_supports as $site) {
					if( strpos( $media, $site ) ){
						$check = true;
					}
				}
				if( $media && $url != '' ) {
					if($check){
						$out = '<div class="video-container" style="padding-bottom:'.$proportions.'%">'.$media.'</div>';
					} else {
						$out = '<div class="iframe-container">'.$media.'</div>';
					}
				} elseif( has_post_thumbnail() ) {
					$out .= '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, $img_size).'</a></figure>';
				}
				break;
			case 'audio':
				$media = rwmb_get_value('malina_post_format_audio', $post->ID);
				$url = rwmb_get_value( 'malina_post_format_audio', $post->ID );
				$media_sites = array('soundcloud', 'mixcloud', 'reverbnation', 'spotify');
				$check = false;
				global $wp_embed;
				if( $media && $url != '' ){
					foreach ($media_sites as $site) {
						if( strpos( $media, $site ) ){
							$check = true;
						}
					}
					if($check){
						$out = '<div class="video-container" style="padding-bottom:'.$proportions.'%">'.$wp_embed->run_shortcode("[embed]".$media."[/embed]").'</div>';
					} else {
						if( has_post_thumbnail() ){
							$out = '<div class="audio-block">';
							$out .= '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, $img_size).'</a></figure>';
							$out .= '<div class="audio-overlay">'.do_shortcode('[audio src="'.$media.'" loop="off" autoplay="0" preload="none"]').'</div>';
							$out .= '</div>';
						} else {
							$out = do_shortcode('[audio src="'.$media.'" loop="off" autoplay="0" preload="none"]');
						}
					}
					
				} elseif( has_post_thumbnail() ) {
					$out .= '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, $img_size).'</a></figure>';
				}
				break;
			case 'link':
				$link = rwmb_get_value( 'malina_post_format_link' );
				$title = rwmb_get_value( 'malina_post_format_link_title' );
				if(is_array($title)){
					$title = $title[0];
				}
				if(is_array($link)){
					$link = $link[0];
				}
				if($title == '') {
					$title = $link;
				}
				if ( $link != '' && has_post_thumbnail() ){
					$out = '<figure class="post-img"><a class="overlay-link" href="'.esc_url($link).'" rel="bookmark"><h2>'.$title.'</h2></a>'.get_the_post_thumbnail($post->ID, $img_size).'</figure>';
				} elseif( has_post_thumbnail() ) {
					$out = '<figure class="post-img">'.get_the_post_thumbnail($post->ID, $img_size).'</figure>';
				}
				break;
			case 'quote':
				$text = rwmb_get_value( 'malina_post_format_quote_text', $post->ID );
				if ( $text != '' ){
					$cite = rwmb_get_value( 'malina_post_format_quote_cite', $post->ID );
					$text_color = rwmb_get_value( 'malina_post_format_quote_text_color', $post->ID );
					$bg_color = rwmb_get_value( 'malina_post_format_quote_bg_color', $post->ID );
					$style = $style_cite = '';
					if($text_color){
						$style .= $style_cite = 'color:'.$text_color.';';
					}
					if($bg_color) {
						$style .= 'background-color:'.$bg_color.';';
					}
					$out = '<blockquote style="'.$style.'">';
					$out .= '<p class="mb0">'.esc_html($text).'</p>';
					if($cite){
						$out .='<cite style="'.$style_cite.'">'.esc_html($cite).'</cite>';
					}
					$out .= '</blockquote>';
					
				} elseif( has_post_thumbnail() ) {
					$out = '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, $img_size).'</a></figure>';
				}
				break;
			default:
				$media = rwmb_get_value( 'malina_post_format_embed', $post->ID );
				$url = rwmb_get_value( 'malina_post_format_embed', $post->ID );
				$proportions_supports = array('cloudup','collegehumor', 'funnyordie', 'flickr', 'youtube', 'dailymotion', 'vimeo', 'ted', 'videopress', 'vine', 'wordpress.tv');
				$check = false;
				foreach ($proportions_supports as $site) {
					if(!is_array($media)){
						if( strpos( $media, $site ) ){
							$check = true;
						}
					}
					
				}
				if($media && $url != '') {
					if($check){
						$out = '<div class="video-container" style="padding-bottom:'.$proportions.'%">'.$media.'</div>';
					} else {
						$out = '<div class="iframe-container">'.$media.'</div>';
					}
				} elseif( has_post_thumbnail() ){
					$out = '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, $img_size).'</a></figure>';
				}
				break;
		}
			$show_post_format = rwmb_get_value('malina_display_featured_img_instead', $post->ID);
			if( $show_post_format === 'true' ){
				$show_post_format = get_theme_mod('malina_display_featured_img_preview', true);
			}
			if( $show_post_format === '1' || $show_post_format === true || $show_post_format === 'true' ){
				if( has_post_thumbnail() ){
					$out = '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, $img_size).'</a></figure>';
				} else {
					$out = '';
				}
			}
		if( $echo ){
			echo $out;
		} else {
			return $out;
		}
	}
}
if(!function_exists('malina_post_has_more_link')){
	function malina_post_has_more_link( $post_id ) {
		$post = get_post( $post_id );
		$content = $post->post_content;
		$data_array = get_extended( $content );
		return '' !== $data_array['extended'];
	}
}
if(!function_exists('malina_custom_pagination')){
  function malina_custom_pagination($pages = '', $range = 4) {
  	$showitems = ($range * 2)+1;
    $out ='';

    global $paged;
	if(empty($paged)) $paged = 1;

    if($pages == '') {
      global $wp_query;
      $pages = $wp_query->max_num_pages;
      if(!$pages) {
        $pages = 1;
      }
    }
    
    if(1 != $pages) {
		if($paged > 1) {
			$out .= get_previous_posts_link('<i class="la la-angle-left"></i>');
		}
		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				$out .= ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
			}
		}
		if ($paged < $pages) {
			$out .= get_next_posts_link('<i class="la la-angle-right"></i>');
		}
    }
    return $out;
  }
}
if(!function_exists('MalinaCommentsNumber')){
	function MalinaCommentsNumber($postID, $echo = false){
		if( get_theme_mod('malina_single_disable_comments', false ) ){
			return;
		}
		$num_comments = get_comments_number($postID);
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = esc_html__('0 Comment', 'malina-elements');
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments .' '. esc_html__('Comments', 'malina-elements');
			} else {
				$comments = esc_html__('1 Comment', 'malina-elements');
			}
			$write_comments = '<a href="' . get_comments_link($postID) .'"><span>'. $comments.'</span></a>';
		} else {
			$write_comments =  '<span><span>'.esc_html__('Comments disabled.', 'malina-elements').'</span></span>';
		}
		if($echo){
			echo $write_comments;
		} else {
			return $write_comments;
		}
	}
	add_filter( 'MalinaCommentsNumber', 'MalinaCommentsNumber' );
}
if(!function_exists('malina_calculate_reading_time')){
	function malina_calculate_reading_time($postID = false, $echo = false) {
		$wpm = 250;
		if(!$postID){
			$postID = get_the_ID();
		}
		$include_shortcodes = true;
		$exclude_images = false;
		$tmpContent = get_post_field('post_content', $postID);
		$number_of_images = substr_count(strtolower($tmpContent), '<img ');
		if ( ! $include_shortcodes ) {
			$tmpContent = strip_shortcodes($tmpContent);
		}
		$tmpContent = strip_tags($tmpContent);
		$wordCount = str_word_count($tmpContent);

		if ( !$exclude_images ) {

			$additional_words_for_images = malina_calculate_images( $number_of_images, $wpm );
			$wordCount += $additional_words_for_images;
		}

		$wordCount = apply_filters( 'malina_filter_wordcount', $wordCount );

		$readingTime = ceil($wordCount / $wpm);

		// If the reading time is 0 then return it as < 1 instead of 0.
		if ( $readingTime < 1 ) {
			$readingTime = esc_html__('< 1 min read', 'malina-elements');
		} elseif($readingTime == 1) {
			$readingTime = esc_html__('1 min read', 'malina-elements');
		} else {
			$readingTime = $readingTime.' '.esc_html__('mins read', 'malina-elements');
		}

		if($echo){ 
			echo $readingTime;
		} else {
			return $readingTime;
		}
	}
}

if(!function_exists('malina_calculate_images')){
	function malina_calculate_images( $total_images, $wpm ) {
		$additional_time = 0;
		// For the first image add 12 seconds, second image add 11, ..., for image 10+ add 3 seconds
		for ( $i = 1; $i <= $total_images; $i++ ) {
			if ( $i >= 10 ) {
				$additional_time += 3 * (int) $wpm / 60;
			} else {
				$additional_time += (12 - ($i - 1) ) * (int) $wpm / 60;
			}
		}

		return $additional_time;
	}
}


add_action('admin_head', 'malina_custom_fonts');
add_action('wp_enqueue_style', 'malina_custom_fonts');
function malina_custom_fonts() {
  $malina_icon_style = '.malina-element-icon {
      width:32px;
      height:32px;
      line-height:32px !important;
      border-radius:4px;
      background-image:none !important;
      background-color:#2b2735;
      color:#ffffff;
      font-size:22px !important;
      text-align:center;
    }';
  wp_add_inline_style('js_composer', $malina_icon_style);
  wp_add_inline_style('vc_inline_css', $malina_icon_style);
}
if(!function_exists('MalinaExcerpt')){
	function MalinaExcerpt($limit) {
		$excerpt = explode(' ', get_the_excerpt(), $limit);
		if (count($excerpt)>=$limit) {
			array_pop($excerpt);
			$excerpt = implode(" ",$excerpt);
		} else {
			$excerpt = implode(" ",$excerpt);
		} 
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		return $excerpt;
	}
}
if(!function_exists('malina_additional_user_fields')){
	function malina_additional_user_fields( $user ) {?>
	    <h3><?php _e( 'Additional User Meta', 'malina-elements' ); ?></h3>
	    <table class="form-table">
	        <tr>
	            <th><label for="user_meta_image"><?php esc_html_e( 'A special image for each user', 'malina-elements' ); ?></label></th>
	            <td>
	                <!-- Outputs the image after save -->
	                <img id="additional-user-image" src="<?php echo esc_url( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" style="width:150px;"><br />
	                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
	                <input type="text" name="user_meta_image" id="user_meta_image" value="<?php echo esc_url_raw( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" class="regular-text" />
	                <!-- Outputs the save button -->
	                <input type='button' class="additional-user-image button-pmalinary" value="<?php _e( 'Upload Image', 'malina-elements' ); ?>" id="uploadimage"/><br />
	                <span class="description"><?php esc_html_e( 'Upload an additional image for your user profile.', 'malina-elements' ); ?></span>
	            </td>
	        </tr>
	        <tr>
	            <th><h4><?php esc_html_e( 'User socials icons', 'malina-elements' ); ?></h4></th>
	            <td>
	                <p>
	                    <label for="user_facebook_url"><?php esc_html_e( 'Facebook:', 'malina-elements' ); ?></label><br>
	                    <input type="text" name="user_facebook_url" id="user_facebook_url" value="<?php echo esc_url_raw( get_the_author_meta( 'user_facebook_url', $user->ID ) ); ?>" class="regular-text" />
	                </p>
	                <p>
	                    <label for="user_twitter_url"><?php esc_html_e( 'Twitter:', 'malina-elements' ); ?></label><br>
	                    <input type="text" name="user_twitter_url" id="user_twitter_url" value="<?php echo esc_url_raw( get_the_author_meta( 'user_twitter_url', $user->ID ) ); ?>" class="regular-text" />
	                </p>
	                <p>
	                    <label for="user_pinterest_url"><?php esc_html_e( 'Pinterest:', 'malina-elements' ); ?></label><br>
	                    <input type="text" name="user_pinterest_url" id="user_pinterest_url" value="<?php echo esc_url_raw( get_the_author_meta( 'user_pinterest_url', $user->ID ) ); ?>" class="regular-text" />
	                </p>
	                <p>
	                    <label for="user_instagram_url"><?php esc_html_e( 'Instagram:', 'malina-elements' ); ?></label><br>
	                    <input type="text" name="user_instagram_url" id="user_instagram_url" value="<?php echo esc_url_raw( get_the_author_meta( 'user_instagram_url', $user->ID ) ); ?>" class="regular-text" />
	                </p>
	                <p>
	                    <label for="user_tumblr_url"><?php esc_html_e( 'Tumblr:', 'malina-elements' ); ?></label><br>
	                    <input type="text" name="user_tumblr_url" id="user_tumblr_url" value="<?php echo esc_url_raw( get_the_author_meta( 'user_tumblr_url', $user->ID ) ); ?>" class="regular-text" />
	                </p>
	                <p>
	                    <label for="user_rss_show"><input type="checkbox" name="user_rss_show" id="user_rss_show" value="false" <?php checked( get_the_author_meta( 'user_rss_show', $user->ID ), 'false' ); ?> /><?php esc_html_e('Disable rss icon','malina-elements'); ?></label>
	            </p><br>
	                <span class="description"><?php esc_html_e( 'Enter your socials links to user profile. Leave blank to hide icon.', 'malina-elements' ); ?></span>
	            </td>
	        </tr>
	 
	    </table><!-- end form-table -->
	<?php } // additional_user_fields
	add_action( 'show_user_profile', 'malina_additional_user_fields' );
	add_action( 'edit_user_profile', 'malina_additional_user_fields' );
}
if(!function_exists('malina_save_additional_user_meta')){
	function malina_save_additional_user_meta( $user_id ) {
	 
	    // only saves if the current user can edit user profiles
	    if ( !current_user_can( 'edit_user', $user_id ) )
	        return false;
	 
	    update_user_meta( $user_id, 'user_meta_image', $_POST['user_meta_image'] );
	    update_user_meta( $user_id, 'user_facebook_url', $_POST['user_facebook_url'] );
	    update_user_meta( $user_id, 'user_twitter_url', $_POST['user_twitter_url'] );
	    update_user_meta( $user_id, 'user_pinterest_url', $_POST['user_pinterest_url'] );
	    update_user_meta( $user_id, 'user_instagram_url', $_POST['user_instagram_url'] );
	    update_user_meta( $user_id, 'user_tumblr_url', $_POST['user_tumblr_url'] );
	    update_user_meta( $user_id, 'user_rss_show', $_POST['user_rss_show'] );
	}
	 
	add_action( 'personal_options_update', 'malina_save_additional_user_meta' );
	add_action( 'edit_user_profile_update', 'malina_save_additional_user_meta' );
}

if(!function_exists('malina_user_photo_scripts') ){
	function malina_user_photo_scripts() {
		global $pagenow;
		if($pagenow !== 'profile.php') return;
		wp_enqueue_media(); 
		wp_enqueue_script('malina-author-photo', MALINA_PLUGIN_URL . 'js/author.photo.js', array('jquery'), '1.0.0');
	}
	add_action('admin_enqueue_scripts', 'malina_user_photo_scripts');
}
if(!function_exists('malina_get_attachment_image_by_url')){
	function malina_get_attachment_image_by_url( $url ) {
 
    // Split the $url into two parts with the wp-content directory as the separator.
    $parse_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );
 
    // Get the host of the current site and the host of the $url, ignoring www.
    $this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );
    $file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );
 
    // Return nothing if there aren't any $url parts or if the current host and $url host do not match.
    if ( !isset( $parse_url[1] ) || empty( $parse_url[1] ) || ( $this_host != $file_host ) ) {
        return;
    }
 
    // Now we're going to quickly search the DB for any attachment GUID with a partial path match.
    // Example: /uploads/2013/05/test-image.jpg
    global $wpdb;
 
    $prefix     = $wpdb->prefix;
    $attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM " . $prefix . "posts WHERE guid RLIKE %s;", $parse_url[1] ) );
 
    // Returns null if no attachment is found.
    return $attachment[0];
}
}

if(!function_exists('malina_get_additional_user_meta_thumb')){
	function malina_get_additional_user_meta_thumb($user_id='') {
	 	global $post;
	 	if($user_id == ''){
	 		$user_id = $post->post_author;
	 	}
	    $attachment_url = esc_url( get_the_author_meta( 'user_meta_image', $user_id ) );
	 
	     // grabs the id from the URL using Frankie Jarretts function
	    $attachment_id = malina_get_attachment_image_by_url( $attachment_url );
	 
	    // retrieve the thumbnail size of our image
	    $image_thumb = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
	 
	    // return the image thumbnail
	    return $image_thumb[0];
	 
	}
}

if( !function_exists('malina_get_user_socials') ){
	function malina_get_user_socials($user_id='') {
	 	global $post;
	 	if($user_id == ''){
	 		$user_id = $post->post_author;
	 	}
	    $facebook = get_the_author_meta( 'user_facebook_url', $user_id );
	    $twitter = get_the_author_meta( 'user_twitter_url', $user_id );
	    $pinterest = get_the_author_meta( 'user_pinterest_url', $user_id );
	    $instagram = get_the_author_meta( 'user_instagram_url', $user_id );
	    $tumblr = get_the_author_meta( 'user_tumblr_url', $user_id );
	    $rss_feed = get_author_feed_link($user_id, '');
	    $user_rss_show = get_the_author_meta( 'user_rss_show', $user_id ) ? get_the_author_meta( 'user_rss_show', $user_id ) : 'false';
	    if($facebook != "" || $twitter != "" || $pinterest != "" || $instagram != '' || $tumblr != "") $output = '<div class="social-icons"><ul class="unstyled">';
		if($facebook != "") { 
			$output .= '<li class="social-facebook"><a href="'.esc_url($facebook).'" target="_blank" title="'.esc_html__( 'Facebook', 'malina-elements').'"><i class="fab fa-facebook-f"></i></a></li>';
		}
		if($twitter != "") { 
			$output .= '<li class="social-twitter"><a href="'.esc_url($twitter).'" target="_blank" title="'.esc_html__( 'Twitter', 'malina-elements').'"><i class="fab fa-twitter"></i></a></li>';
		}
		if($pinterest != "") { 
			$output .= '<li class="social-pinterest"><a href="'.esc_url($pinterest).'" target="_blank" title="'.esc_html__( 'Pinterest', 'malina-elements').'"><i class="fab fa-pinterest-p"></i></a></li>';
		}
		if($instagram != '') { 
			$output .= '<li class="social-instagram"><a href="'.esc_url($instagram).'" target="_blank" title="'.esc_html__( 'Instagram', 'malina-elements').'"><i class="fab fa-instagram"></i></a></li>';
		}
		if($tumblr != "") { 
			$output .= '<li class="social-tumblr"><a href="'.esc_url($tumblr).'" target="_blank" title="'.esc_html__( 'Tumblr', 'malina-elements').'"><i class="fab fa-tumblr"></i></a></li>';
		}
		if($user_rss_show != 'false') { 
			$output .= '<li class="social-rss"><a href="'.esc_url($rss_feed).'" target="_blank" title="'.esc_html__( 'RSS', 'malina-elements').'"><i class="fa fa-rss"></i></a></li>';
		} 
	    if($facebook != "" || $twitter != "" || $pinterest != "" || $instagram != '' || $tumblr != "") $output .= '</ul></div>';
	    
		return $output;
	}
}
// Echo theme's meta data if enabled
if(!function_exists('malina_header_meta')) {
	/**
	 * Function that echoes meta data if our seo is enabled
	 */
	function malina_header_meta() {
		$metas = '';
		if( !get_theme_mod('malina_seo_settings', false) ) {
			$meta_description = esc_html(get_post_meta(get_the_ID(), "malina_page_meta_description", true));
			$meta_keywords = esc_html(get_post_meta(get_the_ID(), "malina_page_meta_keywords", true));
			if($meta_description) { 
				$metas .= '<meta name="description" content="'.$meta_description.'">'."\r\n";
			} else if( get_theme_mod('malina_meta_description', false) ){
				$metas .= '<meta name="description" content="'.get_theme_mod('malina_meta_description').'">'."\r\n";
			}
			if($meta_keywords) {
				$metas .= '<meta name="keywords" content="'.$meta_keywords.'">'."\r\n";
			} else if( get_theme_mod('malina_meta_keywords', false) ){
				$metas .= '<meta name="keywords" content="'.get_theme_mod('malina_meta_keywords').'">'."\r\n";
			}
		}
		echo ''.$metas;
	}
	add_action('malina_header_meta', 'malina_header_meta');
}
if( !function_exists('malina_get_custom_social_icon')){
	function malina_get_custom_social_icon(){
		$icons = array();
		return apply_filters( 'malina_add_social_icon_filter', $icons );
	}
}
if(!function_exists('malina_get_social_links_items')){
	function malina_get_social_links_items(){
		$output='';
			if(get_theme_mod('malina_social_vkontakte', '') != "") { 
				$output .= '<li class="social-vkontakte"><a href="'.esc_url(get_theme_mod('malina_social_vkontakte', '')).'" target="_blank" title="'. esc_html__( 'Vkontakte', 'malina-elements').'"><i class="fab fa-vk"></i></a></li>';
			}
			if(get_theme_mod('malina_social_facebook', '') != "") { 
				$output .= '<li class="social-facebook"><a href="'.esc_url(get_theme_mod('malina_social_facebook', '')).'" target="_blank" title="'. esc_html__( 'Facebook', 'malina-elements').'"><i class="fab fa-facebook-f"></i></a></li>';
			}
			if(get_theme_mod('malina_social_twitter', '') != "") { 
				$output .= '<li class="social-twitter"><a href="'.esc_url(get_theme_mod('malina_social_twitter', '')).'" target="_blank" title="'. esc_html__( 'Twitter', 'malina-elements').'"><i class="fab fa-twitter"></i></a></li>';
			}
			if(get_theme_mod('malina_social_goodreads', '') != "") { 
				$output .= '<li class="social-goodreads"><a href="'.esc_url(get_theme_mod('malina_social_goodreads', '')).'" target="_blank" title="'. esc_html__( 'Goodreads', 'malina-elements').'"><i class="fab fa-goodreads-g"></i></a></li>';
			}
			if(get_theme_mod('malina_social_pinterest', '') != "") { 
				$output .= '<li class="social-pinterest"><a href="'.esc_url(get_theme_mod('malina_social_pinterest', '')).'" target="_blank" title="'. esc_html__( 'Pinterest', 'malina-elements').'"><i class="fab fa-pinterest-p"></i></a></li>';
			}
			if(get_theme_mod('malina_social_vimeo', '') != "") { 
				$output .= '<li class="social-vimeo"><a href="'.esc_url(get_theme_mod('malina_social_vimeo', '')).'" target="_blank" title="'. esc_html__( 'Vimeo', 'malina-elements').'"><i class="fab fa-vimeo"></i></a></li>';
			}	 
			if(get_theme_mod('malina_social_instagram', '') != '') { 
				$output .= '<li class="social-instagram"><a href="'.esc_url(get_theme_mod('malina_social_instagram', '')).'" target="_blank" title="'. esc_html__( 'Instagram', 'malina-elements').'"><i class="fab fa-instagram"></i></a></li>';
			}
			if(get_theme_mod('malina_social_tumblr', '') != "") { 
				$output .= '<li class="social-tumblr"><a href="'.esc_url(get_theme_mod('malina_social_tumblr', '')).'" target="_blank" title="'. esc_html__( 'Tumblr', 'malina-elements').'"><i class="fab fa-tumblr"></i></a></li>';
			}
			if(get_theme_mod('malina_social_google_plus', '') != "") { 
				$output .= '<li class="social-googleplus"><a href="'.esc_url(get_theme_mod('malina_social_google_plus', '')).'" target="_blank" title="'. esc_html__( 'Google plus', 'malina-elements').'"><i class="fab fa-google-plus"></i></a></li>';
			}
			if(get_theme_mod('malina_social_spotify', '') != "") { 
				$output .= '<li class="social-spotify"><a href="'.esc_url(get_theme_mod('malina_social_spotify', '')).'" target="_blank" title="'. esc_html__( 'Spotify', 'malina-elements').'"><i class="fab fa-spotify"></i></a></li>';
			}
			if(get_theme_mod('malina_social_forrst', '') != "") { 
				$output .= '<li class="social-forrst"><a href="'.esc_url(get_theme_mod('malina_social_forrst', '')).'" target="_blank" title="'. esc_html__( 'Forrst', 'malina-elements').'"><i class="fa icon-forrst"></i></a></li>';
			}
			if(get_theme_mod('malina_social_dribbble', '') != "") { 
				$output .= '<li class="social-dribbble"><a href="'.esc_url(get_theme_mod('malina_social_dribbble', '')).'" target="_blank" title="'. esc_html__( 'Dribbble', 'malina-elements').'"><i class="fab fa-dribbble"></i></a></li>';
			}
			if(get_theme_mod('malina_social_flickr', '') != "") { 
				$output .= '<li class="social-flickr"><a href="'.esc_url(get_theme_mod('malina_social_flickr', '')).'" target="_blank" title="'. esc_html__( 'Flickr', 'malina-elements').'"><i class="fab fa-flickr"></i></a></li>';
			}
			if(get_theme_mod('malina_social_linkedin', '') != "") { 
				$output .= '<li class="social-linkedin"><a href="'.esc_url(get_theme_mod('malina_social_linkedin', '')).'" target="_blank" title="'. esc_html__( 'LinkedIn', 'malina-elements').'"><i class="fab fa-linkedin"></i></a></li>';
			}
			if(get_theme_mod('malina_social_skype', '') != "") { 
				$output .= '<li class="social-skype"><a href="skype:'.esc_attr(get_theme_mod('malina_social_skype', '')).'" title="'. esc_html__( 'Skype', 'malina-elements').'"><i class="fab fa-skype"></i></a></li>';
			}
			if(get_theme_mod('malina_social_digg', '') != "") { 
				$output .= '<li class="social-digg"><a href="'.esc_url(get_theme_mod('malina_social_digg', '')).'" target="_blank" title="'. esc_html__( 'Digg', 'malina-elements').'"><i class="fab fa-digg"></i></a></li>';
			}
			if(get_theme_mod('malina_social_yahoo', '') != "") { 
				$output .= '<li class="social-yahoo"><a href="'.esc_url(get_theme_mod('malina_social_yahoo', '')).'" target="_blank" title="'. esc_html__( 'Yahoo', 'malina-elements').'"><i class="fab fa-yahoo"></i></a></li>';
			}
			if(get_theme_mod('malina_social_youtube', '') != "") { 
				$output .= '<li class="social-youtube"><a href="'.esc_url(get_theme_mod('malina_social_youtube', '')).'" target="_blank" title="'. esc_html__( 'YouTube', 'malina-elements').'"><i class="fab fa-youtube"></i></a></li>';
			}
			if(get_theme_mod('malina_social_deviantart', '') != "") { 
				$output .= '<li class="social-deviantart"><a href="'.esc_url(get_theme_mod('malina_social_deviantart', '')).'" target="_blank" title="'. esc_html__( 'DeviantArt', 'malina-elements').'"><i class="fab fa-deviantart"></i></a></li>';
			}
			if(get_theme_mod('malina_social_behance', '') != "") { 
				$output .= '<li class="social-behance"><a href="'.esc_url(get_theme_mod('malina_social_behance', '')).'" target="_blank" title="'. esc_html__( 'Behance', 'malina-elements').'"><i class="fab fa-behance"></i></a></li>';
			}
			if(get_theme_mod('malina_social_paypal', '') != "") { 
				$output .= '<li class="social-paypal"><a href="'.esc_url(get_theme_mod('malina_social_paypal', '')).'" target="_blank" title="'. esc_html__( 'PayPal', 'malina-elements').'"><i class="fab fa-paypal"></i></a></li>';
			}
			if(get_theme_mod('malina_social_delicious', '') != "") { 
				$output .= '<li class="social-delicious"><a href="'.esc_url(get_theme_mod('malina_social_delicious', '')).'" target="_blank" title="'. esc_html__( 'Delicious', 'malina-elements').'"><i class="fab fa-delicious"></i></a></li>';
			}
			if(get_theme_mod('malina_social_rss', false)) { 
				$output .= '<li class="social-rss"><a href="'.esc_url(get_bloginfo('rss2_url')).'" target="_blank" title="'. esc_html__( 'RSS', 'malina-elements').'"><i class="fa fa-rss"></i></a></li>';
			}
			$extra_icons = malina_get_custom_social_icon();
			if( !empty($extra_icons) ){
				foreach ($extra_icons as $icon) {
					$name = str_replace(' ', '', $icon['name']);
					$output .= '<li class="social-'.esc_attr(strtolower($name)).'"><a href="'.esc_url($icon['url']).'" target="_blank" title="'.esc_attr(ucfirst($icon['name'])).'"><i class="'.esc_attr($icon['icon']).'"></i></a></li>';
				}
			}
			return $output;
	}
}
if(!function_exists('malina_get_social_links')){
	function malina_get_social_links($echo = true){
		$output='';
		if( malina_get_social_links_items() != '' ){
			$output .= '<div class="social-icons">';
				$output .= '<ul class="unstyled">';
					$output .= malina_get_social_links_items(); 
				$output .= '</ul>';
			$output .= '</div>';
		}
		
		if($echo){
			echo ''.$output;
		} else {
			return $output;
		}
	}
}
if(!function_exists('malina_get_footer_social_links_items')){
	function malina_get_footer_social_links_items(){
		$output='';
			if(get_theme_mod('malina_social_vkontakte', '') != "") { 
				$output .= '<li class="social-vkontakte"><a href="'.esc_url(get_theme_mod('malina_social_vkontakte', '')).'" target="_blank" title="'. esc_html__( 'Vkontakte', 'malina-elements').'"><i class="fab fa-vk"></i><span>'. esc_html__( 'Vkontakte', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_facebook', '') != "") { 
				$output .= '<li class="social-facebook"><a href="'.esc_url(get_theme_mod('malina_social_facebook', '')).'" target="_blank" title="'. esc_html__( 'Facebook', 'malina-elements').'"><i class="fab fa-facebook-f"></i><span>'. esc_html__( 'Facebook', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_twitter', '') != "") { 
				$output .= '<li class="social-twitter"><a href="'.esc_url(get_theme_mod('malina_social_twitter', '')).'" target="_blank" title="'. esc_html__( 'Twitter', 'malina-elements').'"><i class="fab fa-twitter"></i><span>'. esc_html__( 'Twitter', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_goodreads', '') != "") { 
				$output .= '<li class="social-goodreads"><a href="'.esc_url(get_theme_mod('malina_social_goodreads', '')).'" target="_blank" title="'. esc_html__( 'Goodreads', 'malina-elements').'"><i class="fab fa-goodreads-g"></i><span>'. esc_html__( 'Goodreads', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_pinterest', '') != "") { 
				$output .= '<li class="social-pinterest"><a href="'.esc_url(get_theme_mod('malina_social_pinterest', '')).'" target="_blank" title="'. esc_html__( 'Pinterest', 'malina-elements').'"><i class="fab fa-pinterest-p"></i><span>'. esc_html__( 'Pinterest', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_vimeo', '') != "") { 
				$output .= '<li class="social-vimeo"><a href="'.esc_url(get_theme_mod('malina_social_vimeo', '')).'" target="_blank" title="'. esc_html__( 'Vimeo', 'malina-elements').'"><i class="fab fa-vimeo"></i><span>'. esc_html__( 'Vimeo', 'malina-elements').'</span></a></li>';
			}	 
			if(get_theme_mod('malina_social_instagram', '') != '') { 
				$output .= '<li class="social-instagram"><a href="'.esc_url(get_theme_mod('malina_social_instagram', '')).'" target="_blank" title="'. esc_html__( 'Instagram', 'malina-elements').'"><i class="fab fa-instagram"></i><span>'. esc_html__( 'Instagram', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_tumblr', '') != "") { 
				$output .= '<li class="social-tumblr"><a href="'.esc_url(get_theme_mod('malina_social_tumblr', '')).'" target="_blank" title="'. esc_html__( 'Tumblr', 'malina-elements').'"><i class="fab fa-tumblr"></i><span>'. esc_html__( 'Tumblr', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_google_plus', '') != "") { 
				$output .= '<li class="social-googleplus"><a href="'.esc_url(get_theme_mod('malina_social_google_plus', '')).'" target="_blank" title="'. esc_html__( 'Google plus', 'malina-elements').'"><i class="fab fa-google-plus"></i><span>'. esc_html__( 'Google plus', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_spotify', '') != "") { 
				$output .= '<li class="social-spotify"><a href="'.esc_url(get_theme_mod('malina_social_spotify', '')).'" target="_blank" title="'. esc_html__( 'Spotify', 'malina-elements').'"><i class="fab fa-spotify"></i><span>'. esc_html__( 'Spotify', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_forrst', '') != "") { 
				$output .= '<li class="social-forrst"><a href="'.esc_url(get_theme_mod('malina_social_forrst', '')).'" target="_blank" title="'. esc_html__( 'Forrst', 'malina-elements').'"><i class="fa icon-forrst"></i><span>'. esc_html__( 'Forrst', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_dribbble', '') != "") { 
				$output .= '<li class="social-dribbble"><a href="'.esc_url(get_theme_mod('malina_social_dribbble', '')).'" target="_blank" title="'. esc_html__( 'Dribbble', 'malina-elements').'"><i class="fab fa-dribbble"></i><span>'. esc_html__( 'Dribbble', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_flickr', '') != "") { 
				$output .= '<li class="social-flickr"><a href="'.esc_url(get_theme_mod('malina_social_flickr', '')).'" target="_blank" title="'. esc_html__( 'Flickr', 'malina-elements').'"><i class="fab fa-flickr"></i><span>'. esc_html__( 'Flickr', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_linkedin', '') != "") { 
				$output .= '<li class="social-linkedin"><a href="'.esc_url(get_theme_mod('malina_social_linkedin', '')).'" target="_blank" title="'. esc_html__( 'LinkedIn', 'malina-elements').'"><i class="fab fa-linkedin"></i><span>'. esc_html__( 'LinkedIn', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_skype', '') != "") { 
				$output .= '<li class="social-skype"><a href="skype:'.esc_attr(get_theme_mod('malina_social_skype', '')).'" title="'. esc_html__( 'Skype', 'malina-elements').'"><i class="fab fa-skype"></i><span>'. esc_html__( 'Skype', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_digg', '') != "") { 
				$output .= '<li class="social-digg"><a href="'.esc_url(get_theme_mod('malina_social_digg', '')).'" target="_blank" title="'. esc_html__( 'Digg', 'malina-elements').'"><i class="fab fa-digg"></i><span>'. esc_html__( 'Digg', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_yahoo', '') != "") { 
				$output .= '<li class="social-yahoo"><a href="'.esc_url(get_theme_mod('malina_social_yahoo', '')).'" target="_blank" title="'. esc_html__( 'Yahoo', 'malina-elements').'"><i class="fab fa-yahoo"></i><span>'. esc_html__( 'Yahoo', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_youtube', '') != "") { 
				$output .= '<li class="social-youtube"><a href="'.esc_url(get_theme_mod('malina_social_youtube', '')).'" target="_blank" title="'. esc_html__( 'YouTube', 'malina-elements').'"><i class="fab fa-youtube"></i><span>'. esc_html__( 'YouTube', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_deviantart', '') != "") { 
				$output .= '<li class="social-deviantart"><a href="'.esc_url(get_theme_mod('malina_social_deviantart', '')).'" target="_blank" title="'. esc_html__( 'DeviantArt', 'malina-elements').'"><i class="fab fa-deviantart"></i><span>'. esc_html__( 'DeviantArt', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_behance', '') != "") { 
				$output .= '<li class="social-behance"><a href="'.esc_url(get_theme_mod('malina_social_behance', '')).'" target="_blank" title="'. esc_html__( 'Behance', 'malina-elements').'"><i class="fab fa-behance"></i><span>'. esc_html__( 'Behance', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_paypal', '') != "") { 
				$output .= '<li class="social-paypal"><a href="'.esc_url(get_theme_mod('malina_social_paypal', '')).'" target="_blank" title="'. esc_html__( 'PayPal', 'malina-elements').'"><i class="fab fa-paypal"></i><span>'. esc_html__( 'PayPal', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_delicious', '') != "") { 
				$output .= '<li class="social-delicious"><a href="'.esc_url(get_theme_mod('malina_social_delicious', '')).'" target="_blank" title="'. esc_html__( 'Delicious', 'malina-elements').'"><i class="fab fa-delicious"></i><span>'. esc_html__( 'Delicious', 'malina-elements').'</span></a></li>';
			}
			if(get_theme_mod('malina_social_rss', false)) { 
				$output .= '<li class="social-rss"><a href="'.esc_url(get_bloginfo('rss2_url')).'" target="_blank" title="'. esc_html__( 'RSS', 'malina-elements').'"><i class="fa fa-rss"></i><span>'. esc_html__( 'RSS', 'malina-elements').'</span></a></li>';
			}
			$extra_icons = malina_get_custom_social_icon();
			if( !empty($extra_icons) ){
				foreach ($extra_icons as $icon) {
					$name = str_replace(' ', '', $icon['name']);
					$output .= '<li class="social-'.esc_attr(strtolower($name)).'"><a href="'.esc_url($icon['url']).'" target="_blank" title="'.esc_attr(ucfirst($icon['name'])).'"><i class="'.esc_attr($icon['icon']).'"></i><span>'.esc_attr(ucfirst($icon['name'])).'</span></a></li>';
				}
			}
		return $output;
	}
}
if(!function_exists('malina_get_footer_social_links')){
	function malina_get_footer_social_links($echo = true){
		$output='';
		if( malina_get_footer_social_links_items() != '' ){
			$output .= '<div class="social-icons">';
				$output .= '<ul class="unstyled">';
					$output .= malina_get_footer_social_links_items();
				$output .= '</ul>';
			$output .= '</div>';
		}
		if($echo){
			echo ''.$output;
		} else {
			return $output;
		}
	}
}
?>