<?php add_filter('wp_nav_menu_items','malina_menu_logo_center', 10, 2); ?>
<div id="header-main" class="<?php if( get_theme_mod('malina_fixed_header', true) ) echo 'fixed_header'; ?>">
<header id="header" class="header5 clearfix">
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
	<div class="header-top">
		<div class="header-top-inner">
			<div class="search-and-open">
				<?php if( get_theme_mod('malina_header_hidden_area', true) && is_active_sidebar('hidden-widgets') ) { ?>
					<div class="hidden-area-button">
						<a href="#" class="open-hidden-area">
							<span class="line-1"></span>
							<span class="line-2"></span>
							<span class="line-3"></span>
						</a>
					</div>
				<?php } ?>
			</div>
			<div id="navigation-block">
				<div class="extra-container">
					<div class="container">
						<div class="span12">
						<?php
							if( has_nav_menu( 'main_navigation' ) ) { ?>
								<?php 
								if(function_exists('wp_megamenu')){
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
							} ?>
						</div>
					</div>
				</div>
			</div>
			<div class="socials-block">
				<?php if( get_theme_mod('malina_header_socials', true) && function_exists('malina_get_social_links') ) { malina_get_social_links(); } ?>
			</div>
		</div>
	</div>
</header>
</div>