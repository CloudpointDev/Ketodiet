<?php
$pt = get_theme_mod('malina_home_hero_section_padtop', '25');
$pr = get_theme_mod('malina_home_hero_section_padright', '25');
$pb = get_theme_mod('malina_home_hero_section_padbottom', '25');
$pl = get_theme_mod('malina_home_hero_section_padleft', '25');

$style = 'padding:'.$pt.'px '.$pr.'px '.$pb.'px '.$pl.'px;';
?>
<div id="blog-herosection" style="<?php echo esc_attr($style); ?>">
	<div class="bg">
	<?php
	$out = '';
	$hellotext = get_theme_mod('malina_home_hero_text', 'Hello...');
	if( get_theme_mod('malina_blog_hero_image','') != '' ){
		$out .= '<div class="blog-herosection-image">';
		if( $hellotext != '' ){
			$out .= '<div class="herosection_text">'.$hellotext.'</div>';	
		}
		$out .= '<img src="'.get_theme_mod('malina_blog_hero_image','').'" alt="hero image"></div>';
	}
	$post_ids = get_theme_mod('malina_home_hero_posts','');
	$orderby = get_theme_mod('malina_home_hero_posts_orderby','date');
	$order = get_theme_mod('malina_home_hero_posts_order','DESC');
	$posts_per_page = get_theme_mod('malina_home_hero_slides_count','5');

    $args = array(
	    'post_type' => 'post',
	    'posts_per_page' => $posts_per_page,
	    'order'          => $order,
	    'orderby'        => $orderby,
	    'post_status'    => 'publish',
	    'post__not_in' => get_option( 'sticky_posts' ),
	    'meta_query' => array(
	        array(
	         'key' => '_thumbnail_id',
	         'compare' => 'EXISTS'
	        )
	    )
    );
	if(!is_array($post_ids) && strlen($post_ids) && $post_ids != 'no'){
		$post_ids = trim($post_ids);
		$post_ids = explode(',', $post_ids);
		$args['post__in'] = $post_ids;
	} elseif( is_array($post_ids) && !empty($post_ids) && !in_array('no', $post_ids)){
		$args['post__in'] = $post_ids;
	}
    $thumbsize = 'medium';
	$the_query = new WP_Query( $args );
	if( $the_query->have_posts() ) {
		wp_enqueue_script('owl-carousel');
		wp_enqueue_style( 'owl-carousel' );
		$owl_custom = 'jQuery(document).ready(function($){
				"use strict";
				setTimeout(function(){ var owl = $("#recent-posts-slider").owlCarousel(
			    {
			        items: 3,
			        margin: 0,
			        dots: false,
			        nav: true,
			        navText: [ \'<i class="la la-arrow-left"></i>\',\'<i class="la la-arrow-right"></i>\' ],
			        autoplay: true,
			        responsiveClass:true,
			        loop: false,
			        smartSpeed: 450,
			        autoHeight: false,
			        responsive:{
			            0:{
			                items:1,
			            },
			            760:{
			                items:2,
			            },
			            960:{
			                items:3
			            }
			        },
			        themeClass: "owl-recentposts"';
				    $owl_custom .= '});
					$(window).load(function(){
						owl.trigger(\'refresh.owl.carousel\');
					});
				}, 10);
			});';
		wp_add_inline_script('owl-carousel', $owl_custom);
		$out .= '<div id="recent-posts-slider" class="recent-posts">';
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$out .= '<div class="recent-post-item">';
					if( has_post_thumbnail() ){
						$out .= '<div class="post-img">'.get_the_post_thumbnail(get_the_ID(), $thumbsize).'</div>';
					}
					$out .= '<div class="post-more">';
						$out .= '<div class="title"><h3><a href="'.esc_url(get_the_permalink()).'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.esc_attr(get_the_title()).'</a></h3></div>';
						$out .= '<div class="meta-date"><time datetime="'.esc_attr(date(DATE_W3C)).'">'.get_the_time(get_option('date_format')).'</time></div>';
					$out .= '</div>';
				$out .= '</div>';
			}
		$out .= '</div>';
		echo ''.$out;
		
	}
	wp_reset_postdata();
	?>
	</div>
</div>