<header class="title">
	<div class="meta-categories"><?php echo get_the_category_list(', '); ?></div>
	<h2><?php the_title(); ?></h2>
	<?php if( get_theme_mod('malina_single_post_meta_date', true ) ) {?><div class="meta-date"><time datetime="<?php echo esc_attr(date(DATE_W3C)); ?>"><?php the_time(get_option('date_format')); ?></time></div><?php } ?>
</header>