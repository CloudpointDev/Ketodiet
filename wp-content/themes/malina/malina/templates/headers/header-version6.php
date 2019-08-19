<div id="header-main" class="<?php if( get_theme_mod('malina_fixed_header', true) ) echo 'fixed_header'; ?>">
	<header id="header" class="header4 header6 clearfix">
		<?php if( get_theme_mod('malina_header_search_button', false) ) { ?>
		<div class="search-area">
			<div class="container">
				<div class="span12">
					<form action="<?php echo esc_url(home_url('/')); ?>" id="header-searchform" method="get">
				        <input type="text" id="header-s" name="s" value="" placeholder="<?php esc_attr_e('Search...', 'malina'); ?>" autocomplete="off" />
				        <button type="submit"><i class="la la-search"></i></button>
					</form>
				</div>
			</div>
			<a href="#" class="close-search"><i class="la la-times"></i></a>
		</div>
		<?php } ?>
		<div class="<?php echo get_theme_mod('malina_header_grid', 'container header-fullwidth'); ?>">
				<div class="span12">
					<div class="logo">
						<?php if( get_theme_mod('malina_header_hidden_area', true) && is_active_sidebar('hidden-widgets') ) { ?>
						<div class="hidden-area-button">
							<a href="#" class="open-hidden-area">
								<span class="line-1"></span>
								<span class="line-2"></span>
								<span class="line-3"></span>
							</a>
						</div>
					<?php } ?>
						<?php if(get_theme_mod('malina_media_logo','') != "") { ?>
							<a href="<?php echo esc_url(home_url('/')); ?>" class="logo_main"><img src="<?php echo esc_url(get_theme_mod('malina_media_logo')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" /></a>
						<?php } else { ?>
							<a href="<?php echo esc_url(home_url('/')); ?>" class="logo_text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
						<?php } ?>
					</div>
					<div  id="navigation-block">
						<?php if( has_nav_menu( 'main_navigation' ) ) { ?>
							<?php if(function_exists('wp_megamenu')){
							 	$wpmm_nav_location_settings = get_wpmm_option('main_navigation');
							 	if(!empty($wpmm_nav_location_settings['is_enabled'])){
							 		wp_megamenu(array('theme_location' => 'main_navigation'));
							 	} else { ?>
									<nav id="navigation">
										<ul id="nav" class="menu">
											<?php wp_nav_menu(array('theme_location' => 'main_navigation', 'container' => false, 'menu_id' => 'nav', 'items_wrap'=>'%3$s', 'fallback_cb' => false)); ?>
										</ul>
									</nav>
							 	<?php }
							} else { ?>
							<nav id="navigation">
								<ul id="nav" class="menu">
									<?php wp_nav_menu(array('theme_location' => 'main_navigation', 'container' => false, 'menu_id' => 'nav', 'items_wrap'=>'%3$s', 'fallback_cb' => false)); ?>
								</ul>
							</nav>
						<?php }
							if( get_theme_mod('malina_header_search_button', false) ) { ?>
								<div class="search-link">
									<a href="javascript:void(0);" class="search-button"><i class="la la-search"></i></a>
								</div>
							<?php }
						} ?>
						
					</div>
					<div class="social-icons-block">
						<?php if( get_theme_mod('malina_header_socials', true) && function_exists('malina_get_social_links') ) { malina_get_social_links(); } ?>
						<?php if( get_theme_mod('malina_header_shopping_cart', false) && class_exists('WooCommerce') ) { 
							$count = WC()->cart->cart_contents_count;
							?>
							<div class="cart-main menu-item cart-contents">
								<a class="my-cart-link" href="<?php echo wc_get_cart_url(); ?>"><i class="la la-shopping-cart"></i>
									<?php if ( $count > 0 ) {
								        ?>
								        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
								        <?php
								    } ?>
								</a>
							</div>
						<?php } ?>
					</div>
				</div>
		</div>
	</header>
</div>