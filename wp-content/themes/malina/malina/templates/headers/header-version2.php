<header id="side-header">
	<div class="overlay-bg">
	<div class="logo">
		<?php if(get_theme_mod('malina_media_logo','') != "") { ?>
			<a href="<?php echo esc_url(home_url()); ?>/" class="logo_main"><img src="<?php echo esc_url(get_theme_mod('malina_media_logo')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" /></a>
		<?php } else { ?>
			<a href="<?php echo esc_url(home_url()); ?>/" class="logo_text"><?php echo esc_attr(get_bloginfo('name')); ?></a>
		<?php } ?>
	</div>
	<?php
		if( has_nav_menu( 'side_navigation' ) ) { ?>
		<nav id="navigation" class="side-navigation">
			<ul id="nav" class="menu">
				<?php wp_nav_menu(array('theme_location' => 'side_navigation', 'container' => false, 'menu_id' => 'nav', 'items_wrap'=>'%3$s', 'fallback_cb' => false)); ?>
			</ul>
		</nav>
	<?php } ?>
	<?php if( get_theme_mod('malina_header_socials', true) && function_exists('malina_get_social_links') ) { 
		echo '<div class="socials-block">';
		malina_get_social_links();
		echo '</div>'; 
	} ?>
	</div>
</header>