 <?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Nutrigen
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if(get_theme_mod('email-txt') || get_theme_mod('time-txt') || get_theme_mod('phone-txt') != '') { ?>
<div class="top-header">
	<div class="container">
    	<div class="top-left">
        	<ul>
            	<?php if(get_theme_mod('email-txt') != '') { ?>
                	<li><i class="fa fa-envelope-o"></i> <a href="<?php echo esc_attr(esc_html('mailto:','nutrigen').get_theme_mod('email-txt')); ?>"><?php echo esc_attr(get_theme_mod('email-txt')); ?></a></li>
				<?php }?>
                <?php if(get_theme_mod('time-txt') != '') { ?>
                	<li><i class="fa fa-clock-o"></i> <?php echo esc_html(get_theme_mod('time-txt')); ?></li>
				<?php }?>                                
            </ul>
        </div><!-- top left -->
    	<div class="top-right">        	
            <div class="phone">
            	<?php if(get_theme_mod('phone-txt') != '') { ?>              	
                    <i class="fa fa-phone"></i><strong>CALL: <?php echo esc_attr(get_theme_mod('phone-txt')); ?></strong>
				<?php }?>            	
            </div>
            <div class="clear"></div>
        </div><!-- top right --><div class="clear"></div>
    </div><!-- container -->
</div><!-- top header --> 
<?php } ?>


<div class="header">
	<div class="header-inner">
      <div class="logo">
       <?php nutrigen_the_custom_logo(); ?>
						<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php esc_attr(bloginfo( 'name' )); ?></a></h1>

					<?php $description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p><?php echo esc_html($description); ?></p>
					<?php endif; ?>
    </div><!-- .logo -->                 
    
    <div class="header_right">        		              
              <div class="toggle">
                <a class="toggleMenu" href="#">
                <?php esc_html_e('Menu','nutrigen'); ?>                
            </a>
            </div><!-- toggle -->    
            <div class="sitenav">                   
                <?php wp_nav_menu( array('theme_location' => 'primary') ); ?>                   
            </div><!--.sitenav --><div class="clear"></div>                  
        </div><!--header_right--><div class="clear"></div>  
 <div class="clear"></div>
</div><!-- .header-inner-->
</div><!-- .header -->