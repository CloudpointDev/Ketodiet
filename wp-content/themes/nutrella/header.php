 <?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Nutrella
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
        
<div id="header">
            <div class="header-inner">	
				<div class="logo">
					<?php nutrella_the_custom_logo(); ?>
						<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_html(bloginfo( 'name' )); ?></a></h1>

					<?php $description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p><?php echo esc_html($description); ?></p>
					<?php endif; ?>
				</div><!-- logo -->
                <div class="header_right">  
                <?php if(get_theme_mod('loc-txt') != '' || get_theme_mod('address-txt') != ''){ ?>
                    <div class="right-box">
                        <div class="hright-icon">            	
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                    	</div><!-- hright-icon -->
                        <div class="hright-content">
                            <span class="small-text"><?php echo esc_html(get_theme_mod('loc-txt')); ?></span><!-- boldtext -->
                            <span class="bold-text"><?php echo esc_html(get_theme_mod('address-txt')); ?></span><!-- smalltext -->
                        </div><!-- hright-content --><div class="clear"></div>
                    </div><!-- right-box -->
       			 <?php } ?>
                 <?php if(get_theme_mod('opentext-txt') != '' || get_theme_mod('opentime-txt') != '' ){ ?>
                    <div class="right-box">
                        <div class="hright-icon">            	
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                        </div><!-- hright-icon -->
                        <div class="hright-content">
                            <span class="small-text"><?php echo esc_html(get_theme_mod('opentext-txt')); ?></span><!-- boldtext -->
                            <span class="bold-text"><?php echo esc_html(get_theme_mod('opentime-txt')); ?></span><!-- smalltext -->
                        </div><!-- hright-content --><div class="clear"></div>
                    </div><!-- right-box -->
        		<?php } ?> 
                <?php if(get_theme_mod('phonetext-txt') != '' || get_theme_mod('phone-txt') != '' ){ ?>
                    <div class="right-box">
                        <div class="hright-icon">            	
                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                        </div><!-- hright-icon -->
                        <div class="hright-content">
                            <span class="small-text"><?php echo esc_html(get_theme_mod('phonetext-txt')); ?></span><!-- boldtext -->
                            <span class="bold-text"><?php echo esc_html(get_theme_mod('phone-txt')); ?></span><!-- smalltext -->
                        </div><!-- hright-content --><div class="clear"></div>
                    </div><!-- right-box --><div class="clear"></div>
        		<?php } ?>		
    </div><!--header_right--><div class="clear"></div>
            </div><!-- header-inner -->
            <div class="separator"></div><!-- separator --> 
            <div id="navigation">
            <div class="toggle">
						<a class="toggleMenu" href="#"><?php esc_html_e('Menu','nutrella'); ?></a>
				</div> 						
				<div class="sitenav">
						<?php wp_nav_menu( array('theme_location' => 'primary') ); ?>							
				</div>
                <?php if(get_theme_mod('top-link') != '') { ?>						
                    <div class="get_a_quote">
                        <a href="<?php echo esc_url(get_theme_mod('top-link')); ?>"><?php esc_html_e('Get a Quote','nutrella') ;?></a>
                    </div><!-- get_a_quote --><div class="clear"></div>
                <?php } ?>
                </div><!-- navigation -->             
		</div><!-- header -->