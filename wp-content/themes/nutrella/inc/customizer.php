<?php
/**
 * Nutrella Theme Customizer
 *
 * @package Nutrella
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function nutrella_customize_register( $wp_customize ) {
	
function nutrella_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		
	$wp_customize->add_setting('color_scheme', array(
		'default' => '#a2cc41',
		'sanitize_callback'	=> 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'color_scheme',array(
			'label' => __('Color Scheme','nutrella'),
			'description'	=> __('Select color from here.','nutrella'),
			'section' => 'colors',
			'settings' => 'color_scheme'
		))
	);

	
	$wp_customize->add_setting('headerbg-color', array(
		'default' => '#ffffff',
		'sanitize_callback'	=> 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'headerbg-color',array(
			'description'	=> __('Select background color for header.','nutrella'),
			'section' => 'colors',
			'settings' => 'headerbg-color'
		))
	);
	
	$wp_customize->add_setting('footer-color', array(
		'default' => '#2e2e2e',
		'sanitize_callback'	=> 'sanitize_hex_color',
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'footer-color',array(
			'description'	=> __('Select background color for footer.','nutrella'),
			'section' => 'colors',
			'settings' => 'footer-color'
		))
	);
	
	
	// Slider Section Start		
	$wp_customize->add_section(
        'slider_section',
        array(
            'title' => __('Slider Settings', 'nutrella'),
            'priority' => null,
			'description'	=> __('Recommended image size (1420x567). Slider will work only when you select the static front page.','nutrella'),	
        )
    );
	
	$wp_customize->add_setting('page-setting7',array(
			'default' => '0',
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
	));
	
	$wp_customize->add_control('page-setting7',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Select page for slide one:','nutrella'),
			'section'	=> 'slider_section'
	));	
	
	$wp_customize->add_setting('page-setting8',array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'absint'
	));
	
	$wp_customize->add_control('page-setting8',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Select page for slide two:','nutrella'),
			'section'	=> 'slider_section'
	));	
	
	$wp_customize->add_setting('page-setting9',array(
			'default' => '0',
			'capability' => 'edit_theme_options',	
			'sanitize_callback'	=> 'absint'
	));
	
	$wp_customize->add_control('page-setting9',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Select page for slide three:','nutrella'),
			'section'	=> 'slider_section'
	));	
	
	$wp_customize->add_setting('slide_text',array(
			'sanitize_callback' => 'sanitize_text_field',
	));	 

	$wp_customize->add_control( 'slide_text', array(
    	   'section'   => 'slider_section',
    	   'label'     => __('Add text for slider button.','nutrella'),
    	   'type'      => 'text'
     ));
	
	$wp_customize->add_setting('hide_slider',array(
			'default' => true,
			'sanitize_callback' => 'nutrella_sanitize_checkbox',
			'capability' => 'edit_theme_options',
	));	 

	$wp_customize->add_control( 'hide_slider', array(
		   'settings' => 'hide_slider',
    	   'section'   => 'slider_section',
    	   'label'     => __('Check this to hide slider.','nutrella'),
    	   'type'      => 'checkbox'
     ));	
	
	// Slider Section End
	 
	 // Contact Section

	$wp_customize->add_section(
        'contact_section',
        array(
            'title' => __('Contact Details', 'nutrella'),
            'priority' => null,
			'description'	=> __('Add your contact info here.','nutrella'),	
        )
    );	
	
	$wp_customize->add_setting('loc-txt',array(
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('loc-txt',array(
			'type'	=> 'text',
			'label'	=> __('Add your address here.','nutrella'),
			'section'	=> 'contact_section'
	));
	
	$wp_customize->add_setting('address-txt',array(
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('address-txt',array(
			'type'	=> 'text',
			'section'	=> 'contact_section'
	));	
	
	$wp_customize->add_setting('opentext-txt',array(
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('opentext-txt',array(
			'type'	=> 'text',
			'label'	=> __('Add opening hours here.','nutrella'),
			'section'	=> 'contact_section'
	));	
	
	$wp_customize->add_setting('opentime-txt',array(
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('opentime-txt',array(
			'type'	=> 'text',
			'section'	=> 'contact_section'
	));
	
	$wp_customize->add_setting('phonetext-txt',array(
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('phonetext-txt',array(
			'type'	=> 'text',
			'label'	=> __('Add phone number here.','nutrella'),
			'section'	=> 'contact_section'
	));	
	
	$wp_customize->add_setting('phone-txt',array(
			'sanitize_callback'	=> 'sanitize_text_field'
	));
	
	$wp_customize->add_control('phone-txt',array(
			'type'	=> 'text',
			'section'	=> 'contact_section'
	));

	
	// Homepage Section Start		
	$wp_customize->add_section(
        'homepage_section',
        array(
            'title' => __('Homepage Boxes', 'nutrella'),
            'priority' => null,
			'description'	=> __('Select pages for homepage boxes. This section will be displayed only when you select the static front page.','nutrella'),	
        )
    );	
	
	$wp_customize->add_setting('page-setting1',array(
			'default' => '0',
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
	));
	
	$wp_customize->add_control('page-setting1',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Select page for first box:','nutrella'),
			'section'	=> 'homepage_section'
	));	
	
	$wp_customize->add_setting('page-setting2',array(
			'default' => '0',
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
	));
	
	$wp_customize->add_control('page-setting2',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Select page for second box:','nutrella'),
			'section'	=> 'homepage_section'
	));	
	
	$wp_customize->add_setting('page-setting3',array(
			'default' => '0',
			'capability' => 'edit_theme_options',
			'sanitize_callback'	=> 'absint'
	));
	
	$wp_customize->add_control('page-setting3',array(
			'type'	=> 'dropdown-pages',
			'label'	=> __('Select page for third box:','nutrella'),
			'section'	=> 'homepage_section'
	));	
	
	$wp_customize->add_setting('hide_section',array(
			'default' => true,
			'sanitize_callback' => 'nutrella_sanitize_checkbox',
			'capability' => 'edit_theme_options',
	));	 

	$wp_customize->add_control( 'hide_section', array(
		   'settings' => 'hide_section',
    	   'section'   => 'homepage_section',
    	   'label'     => __('Check this to hide section.','nutrella'),
    	   'type'      => 'checkbox'
     ));
	
}
add_action( 'customize_register', 'nutrella_customize_register' );	

function nutrella_css(){
		?>
        <style>
				a, 
				.tm_client strong,
				.postmeta a:hover,
				#sidebar ul li a:hover,
				.blog-post h3.entry-title,
				.sitenav ul li a:hover, 
				.sitenav ul li.current_page_item a, 
				.sitenav ul li:hover a.parent,
				.hright-icon{
					color:<?php echo esc_attr(get_theme_mod('color_scheme','#a2cc41')); ?>;
				}
				a.blog-more:hover,
				.nav-links .current, 
				.nav-links a:hover,
				#commentform input#submit,
				input.search-submit,
				.nivo-controlNav a.active,
				.blog-date .date,
				.section-box .sec-left a,
				#slider .top-bar .slide-button:hover,
				a.read-more:hover,
				#slider .top-bar .slide-button,
				.ser-content h4 a{
					background-color:<?php echo esc_attr(get_theme_mod('color_scheme','#a2cc41')); ?>;
				}
				#header{
					background-color:<?php echo esc_attr(get_theme_mod('headerbg-color','#ffffff')); ?>;
				}
				.copyright-wrapper{
					background-color:<?php echo esc_attr(get_theme_mod('footer-color','#2e2e2e')); ?>;
				}
		</style>
	<?php }
add_action('wp_head','nutrella_css');

function nutrella_customize_preview_js() {
	wp_enqueue_script( 'nutrella-customize-preview', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '20141216', true );
}
add_action( 'customize_preview_init', 'nutrella_customize_preview_js' );