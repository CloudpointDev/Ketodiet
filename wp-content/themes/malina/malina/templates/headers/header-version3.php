<header id="side-header-vertical">
	<div class="logo">
		<?php if(get_theme_mod('malina_media_logo', get_template_directory_uri().'/images/thumbnail.png') != "") { ?>
			<a href="<?php echo esc_url(home_url()); ?>/" class="logo_main"><img src="<?php echo esc_url(get_theme_mod('malina_media_logo', get_template_directory_uri().'/images/thumbnail.png')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" /></a>
		<?php } else { ?>
			<a href="<?php echo esc_url(home_url()); ?>/" class="logo_text"><?php echo esc_attr(get_bloginfo('name')); ?></a>
		<?php } ?>
	</div>
	<?php
		if( has_nav_menu( 'side_navigation' ) ) { ?>
		<nav id="navigation" class="vertical">
			<ul id="nav" class="menu">
				<?php wp_nav_menu(array('theme_location' => 'side_navigation', 'depth'=>1, 'container' => false, 'menu_id' => 'nav', 'items_wrap'=>'%3$s', 'fallback_cb' => false)); ?>
				<?php if( get_theme_mod('malina_header_shopping_cart', false) && class_exists('WooCommerce') ) { 
					$cart_url = wc_get_cart_url();
					?>
					<li class="cart-main menu-item">
						<a class="my-cart-link" href="<?php echo esc_url($cart_url);?>"><i class="la la-shopping-cart"></i></a>
					</li>
				<?php } ?>
			</ul>
		</nav>
	<?php } ?>
	<div class="search-link">
		<?php if( get_theme_mod('malina_header_search_button', false) ) { ?>
			<form action="<?php echo esc_url(home_url('/')); ?>" id="header-searchform" method="get">
		        <input type="text" id="header-s" name="s" value="" autocomplete="off" />
		        <button type="submit"><i class="la la-search"></i></button>
			</form>
		<?php } ?>
	</div>
</header>