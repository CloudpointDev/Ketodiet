	<?php 
	$pics = get_theme_mod('malina_footer_instagram_pics', '4');
	$pics_per_row = get_theme_mod('malina_footer_instagram_pics_per_row', '4');

	if( rwmb_get_value('malina_display_page_footer') && is_singular() ) {
	} elseif( get_theme_mod('malina_footer_instagram_access_token', '') == '' && get_theme_mod('malina_footer_copyright', '') == '' && get_theme_mod('malina_footer_socials', false) != true ){

	} elseif( get_theme_mod('malina_footer_layout', 'layout-2') === 'layout-2'){ ?>	
			<footer id="footer">
				<div class="special-bg"></div>
			<?php if( get_theme_mod('malina_footer_instagram_access_token', '') != '' && rwmb_get_value('malina_display_instagram') != 'disbale') { 
				$hide_items = $hide_link = '';
				if(rwmb_get_value('malina_display_instagram') == 'disable-items') {
					$hide_items = true;
				}
				if(rwmb_get_value('malina_display_instagram') == 'disable-link'){
					$hide_link = true;
				} 
				?>
				<div id="before-footer">
					<div class="container">
						<div class="span12">
							<?php the_widget( 'malina_widget_instagram', array('title'=>'', 'insta_title'=> get_theme_mod('malina_footer_instagram_title', ''), 'hide_items' => $hide_items, 'hide_link' => $hide_link, 'access_token'=>get_theme_mod('malina_footer_instagram_access_token', ''), 'pics'=>$pics, 'pics_per_row'=>$pics_per_row )); ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if( get_theme_mod('malina_footer_copyright', '') != '' || get_theme_mod('malina_footer_socials', true) ) { ?>
				<div class="container">
					<div class="span12">
						<?php if( get_theme_mod('malina_footer_socials', true ) && function_exists('malina_get_footer_social_links') ) { echo malina_get_footer_social_links(); } ?>
					</div>
					<div class="span12">
						<?php if( get_theme_mod('malina_footer_copyright', '') != '' ) { ?>
							<div id="footer-copy-block">
								<div class="copyright-text"><?php echo get_theme_mod('malina_footer_copyright', ''); ?></div>
							</div>
						<?php } ?>	
					</div>	
				</div>
				
			<?php } ?>
			</footer>	
			<div class="clear"></div>
		<?php
	} else { ?>	
		<footer id="footer">
			<div class="special-bg"></div>
			<?php if( get_theme_mod('malina_footer_instagram_access_token', '') != '' && rwmb_get_value('malina_display_instagram') != 'disbale') { 
				$hide_items = $hide_link = '';
				if(rwmb_get_value('malina_display_instagram') == 'disable-items') {
					$hide_items = true;
				}
				if(rwmb_get_value('malina_display_instagram') == 'disable-link'){
					$hide_link = true;
				}
				?>
				<div id="before-footer" class="fullwidth">
					<?php the_widget( 'malina_widget_instagram', array('title'=>'', 'insta_title'=> get_theme_mod('malina_footer_instagram_title', ''), 'hide_items' => $hide_items, 'hide_link' => $hide_link, 'access_token'=>get_theme_mod('malina_footer_instagram_access_token', ''), 'pics'=>$pics, 'pics_per_row'=>$pics_per_row)); ?>
				</div>
			<?php } ?>

			<?php if( is_active_sidebar('footer-widgets') ){ ?>
				<div id="footer-widgets">
					<div class="container">
						<div class="span12">
							<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Footer Widgets') ); ?>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if( get_theme_mod('malina_footer_copyright', '') != '' || get_theme_mod('malina_footer_socials', true) ) { ?>
				<div id="footer-bottom">
					<?php if( get_theme_mod('malina_footer_copyright_border', false) ){ ?>
						<hr class="separator-border">
					<?php } ?>
					<div class="container">
						<div class="span4">
							<?php if( get_theme_mod('malina_footer_copyright', '') != '' ) { ?>
								<div id="footer-copy-block">
									<div class="copyright-text"><?php echo get_theme_mod('malina_footer_copyright', ''); ?></div>
								</div>
							<?php } ?>	
						</div>
						<div class="span4">
							<?php if( get_theme_mod('malina_footer_logo', false) ){ ?>
								<h2 class="footer-logo">
									<?php if(get_theme_mod('malina_footer_logo_img','') != "") { ?>
										<a href="<?php echo esc_url(home_url()); ?>/" class="logo_main"><img src="<?php echo esc_url(get_theme_mod('malina_footer_logo_img')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" /></a>
									<?php } else { ?>
										<a href="<?php echo esc_url(home_url()); ?>/" class="logo_text"><?php echo esc_attr(get_bloginfo('name')); ?></a>
									<?php } ?>
								</h2>
							<?php } ?>
						</div>	
						<div class="span4">
							<?php if( get_theme_mod('malina_footer_socials', true) && function_exists('malina_get_social_links') && malina_get_social_links(false) != '' ) { 
								malina_get_social_links(true);
							} ?>
						</div>
					</div>
				</div>
			<?php } ?>
			</footer>	
			<div class="clear"></div>
		<?php
	} ?>
		</div> <!-- end boxed -->

	<?php wp_footer(); ?>
	</body>
</html>
