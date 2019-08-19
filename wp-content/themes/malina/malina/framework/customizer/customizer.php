<?php 
/* customizer */
$malina_cache_time_google_fonts = get_option('malina_cache_time_google_fonts');
$diff = time() - $malina_cache_time_google_fonts;
$crt = 604800;
$google_fonts = $google_fonts_vc = array();
function malina_sanitize_text_html( $input ) {
  return wp_kses_post( force_balance_tags( ''.$input ) );
}
function malina_create_font_types_vc( $variants ){
	$font_types = array();
	foreach ($variants as $variant) {
		switch ($variant) {
			case '100':
				$font_types[] = 'Thin:100:normal';
				break;
			case '100italic':
				$font_types[] = 'Thin italic:100:italic';
				break;
			case '200':
				$font_types[] = 'Extra-Light:200:normal';
				break;
			case '200italic':
				$font_types[] = 'Extra-Light italic:200:italic';
				break;
			case '300':
				$font_types[] = 'Light:300:normal';
				break;
			case '300italic':
				$font_types[] = 'Light italic:300:italic';
				break;
			case '500':
				$font_types[] = 'Medium:500:normal';
				break;
			case '500italic':
				$font_types[] = 'Medium italic:500:italic';
				break;
			case '600':
				$font_types[] = 'Semi-bold:600:normal';
				break;
			case '600italic':
				$font_types[] = 'Semi-bold italic:600:italic';
				break;
			case '700':
				$font_types[] = 'Bold:700:normal';
				break;
			case '700italic':
				$font_types[] = 'Bold italic:700:italic';
				break;
			case '800':
				$font_types[] = 'Extra-bold:800:normal';
				break;
			case '800italic':
				$font_types[] = 'Extra-bold italic:800:italic';
				break;
			case '900':
				$font_types[] = 'Black:900:normal';
				break;
			case '900italic':
				$font_types[] = 'Black italic:900:italic';
				break;
			case 'italic':
				$font_types[] = 'Regular italic:400:italic';
			case 'regular':
				$font_types[] = 'Regular:400:normal';
			default:
				
				break;
		}
	}
	$tmp = implode(',', $font_types);
	return $tmp;
}
function malina_get_all_posts(){
	$args = array(
		'post_status' => 'publish',
		'post_type' => 'post',
		'posts_per_page' => -1,
		'orderby'		=> 'date'
	);
	$the_query = new WP_Query( $args );
	$array_of_post = array();
	$array_of_post['no'] = esc_html__('-- No select --', 'malina');
	if($the_query->have_posts()){
		while ($the_query->have_posts()) {
			$the_query->the_post();
			$array_of_post[get_the_ID()] = get_the_title();
		}
	}
	wp_reset_postdata();
	return $array_of_post;
}
function malina_sanitize_posts_select( $input )
{
    $valid = malina_get_all_posts();
    foreach ($input as $value) {
        if ( !array_key_exists( $value, $valid ) ) {
            return [];
        }
    }
    return $input;
}
function malina_get_all_posts_pages(){
	$args = array(
		'post_status' => 'publish',
		'post_type' => array('post', 'page'),
		'posts_per_page' => -1,
		'orderby'		=> 'date'
	);
	$the_query = new WP_Query( $args );
	$array_of_post = array();
	$array_of_post['no'] = esc_html__('-- No select --', 'malina');
	if($the_query->have_posts()){
		while ($the_query->have_posts()) {
			$the_query->the_post();
			$array_of_post[get_the_ID()] = get_the_title();
		}
	}
	wp_reset_postdata();
	return $array_of_post;
}
if( $diff >= $crt || empty($malina_cache_time_google_fonts ) ){
	$url = "http://www.artstudioworks.net/webfonts/fonts.json";
	$tmpresult = wp_remote_get($url);
	$result = wp_remote_retrieve_body( $tmpresult );
	$result = json_decode($result, TRUE);
	if(is_array($result)){
		foreach ( $result['items'] as $font ) {
		    $google_fonts[] = $font['family'];
		    $temp_font = (object)array(); 
		    $temp_font->font_family = $font['family'];
		    $temp_font->font_types = malina_create_font_types_vc($font['variants']);
		    if( in_array('italic', $font['variants'] ) ){
		    	$temp_font->font_styles = 'regular,italic';
		    } else {
		    	$temp_font->font_styles = 'regular';
		    }
		    $temp_font->font_family_description = esc_html__( 'Select font family', 'malina' );
	    	$temp_font->font_style_description = esc_html__( 'Select font styling', 'malina' );
		    $google_fonts_vc[] = $temp_font;         
		}
	}
	$google_fonts = array_filter($google_fonts);
	update_option('malina_cached_google_fonts', serialize($google_fonts));
	update_option('malina_cached_google_fonts_vc', $google_fonts_vc);
	update_option('malina_cache_time_google_fonts', time());
} else {
	$google_fonts = maybe_unserialize(get_option('malina_cached_google_fonts'));
}
if(empty($google_fonts)){
	$google_fonts = array('ABeeZee','Abel','Abril Fatface','Aclonica','Acme','Actor','Adamina','Advent Pro','Aguafina Script','Akronim','Aladin','Aldrich','Alef','Alegreya','Alegreya SC','Alegreya Sans','Alegreya Sans SC','Alex Brush','Alfa Slab One','Alice','Alike','Alike Angular','Allan','Allerta','Allerta Stencil','Allura','Almendra','Almendra Display','Almendra SC','Amarante','Amaranth','Amatic SC','Amethysta','Anaheim','Andada','Andika','Angkor','Annie Use Your Telescope','Anonymous Pro','Antic','Antic Didone','Antic Slab','Anton','Arapey','Arbutus','Arbutus Slab','Architects Daughter','Archivo Black','Archivo Narrow','Arimo','Arizonia','Armata','Artifika','Arvo','Asap','Asset','Astloch','Asul','Atomic Age','Aubrey','Audiowide','Autour One','Average','Average Sans','Averia Gruesa Libre','Averia Libre','Averia Sans Libre','Averia Serif Libre','Bad Script','Balthazar','Bangers','Basic','Battambang','Baumans','Bayon','Belgrano','Belleza','BenchNine','Bentham','Berkshire Swash','Bevan','Bigelow Rules','Bigshot One','Bilbo','Bilbo Swash Caps','Bitter','Black Ops One','Bokor','Bonbon','Boogaloo','Bowlby One','Bowlby One SC','Brawler','Bree Serif','Bubblegum Sans','Bubbler One','Buda','Buenard','Butcherman','Butterfly Kids','Cabin','Cabin Condensed','Cabin Sketch','Caesar Dressing','Cagliostro','Calligraffitti','Cambo','Candal','Cantarell','Cantata One','Cantora One','Capriola','Cardo','Carme','Carrois Gothic','Carrois Gothic SC','Carter One','Caudex','Cedarville Cursive','Ceviche One','Changa One','Chango','Chau Philomene One','Chela One','Chelsea Market','Chenla','Cherry Cream Soda','Cherry Swash','Chewy','Chicle','Chivo','Cinzel','Cinzel Decorative','Clicker Script','Coda','Coda Caption','Codystar','Combo','Comfortaa','Coming Soon','Concert One','Condiment','Content','Contrail One','Convergence','Cookie','Copse','Corben','Courgette','Cousine','Coustard','Covered By Your Grace','Crafty Girls','Creepster','Crete Round','Crimson Text','Croissant One','Crushed','Cuprum','Cutive','Cutive Mono','Damion','Dancing Script','Dangrek','Dawning of a New Day','Days One','Delius','Delius Swash Caps','Delius Unicase','Della Respira','Denk One','Devonshire','Didact Gothic','Diplomata','Diplomata SC','Domine','Donegal One','Doppio One','Dorsa','Dosis','Dr Sugiyama','Droid Sans','Droid Sans Mono','Droid Serif','Duru Sans','Dynalight','EB Garamond','Eagle Lake','Eater','Economica','Ek Mukta','Electrolize','Elsie','Elsie Swash Caps','Emblema One','Emilys Candy','Engagement','Englebert','Enriqueta','Erica One','Esteban','Euphoria Script','Ewert','Exo','Exo 2','Expletus Sans','Fanwood Text','Fascinate','Fascinate Inline','Faster One','Fasthand','Fauna One','Federant','Federo','Felipa','Fenix','Finger Paint','Fira Mono','Fira Sans','Fjalla One','Fjord One','Flamenco','Flavors','Fondamento','Fontdiner Swanky','Forum','Francois One','Freckle Face','Fredericka the Great','Fredoka One','Freehand','Fresca','Frijole','Fruktur','Fugaz One','GFS Didot','GFS Neohellenic','Gabriela','Gafata','Galdeano','Galindo','Gentium Basic','Gentium Book Basic','Geo','Geostar','Geostar Fill','Germania One','Gilda Display','Give You Glory','Glass Antiqua','Glegoo','Gloria Hallelujah','Goblin One','Gochi Hand','Gorditas','Goudy Bookletter 1911','Graduate','Grand Hotel','Gravitas One','Great Vibes','Griffy','Gruppo','Gudea','Habibi','Hammersmith One','Hanalei','Hanalei Fill','Handlee','Hanuman','Happy Monkey','Headland One','Henny Penny','Herr Von Muellerhoff','Holtwood One SC','Homemade Apple','Homenaje','IM Fell DW Pica','IM Fell DW Pica SC','IM Fell Double Pica','IM Fell Double Pica SC','IM Fell English','IM Fell English SC','IM Fell French Canon','IM Fell French Canon SC','IM Fell Great Primer','IM Fell Great Primer SC','Iceberg','Iceland','Impmalina','Inconsolata','Inder','Indie Flower','Inika','Irish Grover','Istok Web','Italiana','Italianno','Jacques Francois','Jacques Francois Shadow','Jim Nightshade','Jockey One','Jolly Lodger','Josefin Sans','Josefin Slab','Joti One','Judson','Julee','Julius Sans One','Junge','Jura','Just Another Hand','Just Me Again Down Here','Kameron','Kantumruy','Karla','Kaushan Script','Kavoon','Kdam Thmor','Keania One','Kelly Slab','Kenia','Khmer','Kite One','Knewave','Kotta One','Koulen','Kranky','Kreon','Kristi','Krona One','La Belle Aurore','Lancelot','Lato','League Script','Leckerli One','Ledger','Lekton','Lemon','Libre Baskerville','Life Savers','Lilita One','Lily Script One','Limelight','Linden Hill','Lobster','Lobster Two','Londrina Outline','Londrina Shadow','Londrina Sketch','Londrina Solid','Lora','Love Ya Like A Sister','Loved by the King','Lovers Quarrel','Luckiest Guy','Lusitana','Lustria','Macondo','Macondo Swash Caps','Magra','Maiden Orange','Mako','Marcellus','Marcellus SC','Marck Script','Margarine','Marko One','Marmelad','Marvel','Mate','Mate SC','Maven Pro','McLaren','Meddon','MedievalSharp','Medula One','Megrim','Meie Script','Merienda','Merienda One','Merriweather','Merriweather Sans','Metal','Metal Mania','Metamorphous','Metrophobic','Michroma','Milonga','Miltonian','Miltonian Tattoo','Miniver','Miss Fajardose','Modern Antiqua','Molengo','Molle','Monda','Monofett','Monoton','Monsieur La Doulaise','Montaga','Montez','Montserrat','Montserrat Alternates','Montserrat Subrayada','Moul','Moulpali','Mountains of Christmas','Mouse Memoirs','Mr Bedfort','Mr Dafoe','Mr De Haviland','Mrs Saint Delafield','Mrs Sheppards','Muli','Mystery Quest','Neucha','Neuton','New Rocker','News Cycle','Niconne','Nixie One','Nobile','Nokora','Norican','Nosifer','Nothing You Could Do','Noticia Text','Noto Sans','Noto Serif','Nova Cut','Nova Flat','Nova Mono','Nova Oval','Nova Round','Nova Script','Nova Slim','Nova Square','Numans','Nunito','Odor Mean Chey','Offside','Old Standard TT','Oldenburg','Oleo Script','Oleo Script Swash Caps','Open Sans','Open Sans Condensed','Oranienbaum','Orbitron','Oregano','Orienta','Original Surfer','Oswald','Over the Rainbow','Overlock','Overlock SC','Ovo','Oxygen','Oxygen Mono','PT Mono','PT Sans','PT Sans Caption','PT Sans Narrow','PT Serif','PT Serif Caption','Pacifico','Paprika','Parisienne','Passero One','Passion One','Pathway Gothic One','Patrick Hand','Patrick Hand SC','Patua One','Paytone One','Peralta','Permanent Marker','Petit Formal Script','Petrona','Philosopher','Piedra','Pinyon Script','Pirata One','Plaster','Play','Playball','Playfair Display','Playfair Display SC','Podkova','Poiret One','Poller One','Poly','Pompiere','Pontano Sans','Port Lligat Sans','Port Lligat Slab','Prata','Preahvihear','Press Start 2P','Princess Sofia','Prociono','Prosto One','Puritan','Purple Purse','Quando','Quantico','Quattrocento','Quattrocento Sans','Questrial','Quicksand','Quintessential','Qwigley','Racing Sans One','Radley','Raleway','Raleway Dots','Rambla','Rammetto One','Ranchers','Rancho','Rationale','Redressed','Reenie Beanie','Revalia','Ribeye','Ribeye Marrow','Righteous','Risque','Roboto','Roboto Condensed','Roboto Slab','Rochester','Rock Salt','Rokkitt','Romanesco','Ropa Sans','Rosario','Rosarivo','Rouge Script','Rubik Mono One','Rubik One','Ruda','Rufina','Ruge Boogie','Ruluko','Rum Raisin','Ruslan Display','Russo One','Ruthie','Rye','Sacramento','Sail','Salsa','Sanchez','Sancreek','Sansita One','Sarina','Satisfy','Scada','Schoolbell','Seaweed Script','Sevillana','Seymour One','Shadows Into Light','Shadows Into Light Two','Shanti','Share','Share Tech','Share Tech Mono','Shojumaru','Short Stack','Siemreap','Sigmar One','Signika','Signika Negative','Simonetta','Sintony','Sirin Stencil','Six Caps','Skranji','Slackey','Smokum','Smythe','Sniglet','Snippet','Snowburst One','Sofadi One','Sofia','Sonsie One','Sorts Mill Goudy','Source Code Pro','Source Sans Pro','Source Serif Pro','Special Elite','Spicy Rice','Spinnaker','Spirax','Squada One','Stalemate','Stalinist One','Stardos Stencil','Stint Ultra Condensed','Stint Ultra Expanded','Stoke','Strait','Sue Ellen Francisco','Sunshiney','Supermercado One','Suwannaphum','Swanky and Moo Moo','Syncopate','Tangerine','Taprom','Tauri','Telex','Tenor Sans','Text Me One','The Girl Next Door','Tienne','Tinos','Titan One','Titillium Web','Trade Winds','Trocchi','Trochut','Trykker','Tulpen One','Ubuntu','Ubuntu Condensed','Ubuntu Mono','Ultra','Uncial Antiqua','Underdog','Unica One','UnifrakturCook','UnifrakturMaguntia','Unkempt','Unlock','Unna','VT323','Vampiro One','Varela','Varela Round','Vast Shadow','Vibur','Vidaloka','Viga','Voces','Volkhov','Vollkorn','Voltaire','Waiting for the Sunrise','Wallpoet','Walter Turncoat','Warnes','Wellfleet','Wendy One','Wire One','Yanone Kaffeesatz','Yellowtail','Yeseva One','Yesteryear','Zeyada');
}

if ( ! function_exists( 'malina_helper_vc_fonts' ) ) {
	function malina_helper_vc_fonts( $fonts_list ) {

		$google_fonts_vc = get_option('malina_cached_google_fonts_vc');
		
		if( !empty($google_fonts_vc) ) {
			$fonts_list = $google_fonts_vc;
		}
	    
	    return $fonts_list;
	}
}
add_filter('vc_google_fonts_get_fonts_filter', 'malina_helper_vc_fonts');

function malina_register_theme_customizer( $wp_customize ) {

	/**
	 * Multiple checkbox customize control class.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	class Malina_Customize_Control_Checkbox_Multiple extends WP_Customize_Control {

	    /**
	     * The type of customize control being rendered.
	     *
	     * @since  1.0.0
	     * @access public
	     * @var    string
	     */
	    public $type = 'checkbox-multiple';

	    /**
	     * Enqueue scripts/styles.
	     *
	     * @since  1.0.0
	     * @access public
	     * @return void
	     */
	    public function enqueue() {
	        wp_enqueue_script( 'js-for-customize' );
	    }

	    /**
	     * Displays the control content.
	     *
	     * @since  1.0.0
	     * @access public
	     * @return void
	     */
	    public function render_content() {

	        if ( empty( $this->choices ) )
	            return; ?>

	        <?php if ( !empty( $this->label ) ) : ?>
	            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	        <?php endif; ?>

	        <?php if ( !empty( $this->description ) ) : ?>
	            <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
	        <?php endif; ?>

	        <?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

	        <ul>
	            <?php foreach ( $this->choices as $value => $label ) : ?>

	                <li>
	                    <label>
	                        <input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> />
	                        <?php echo esc_html( $label ); ?>
	                    </label>
	                </li>

	            <?php endforeach; ?>
	        </ul>

	        <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
	    <?php }
	}
	/**
	* Custom Customizer Control: Sortable Checkboxes
	* @link https://shellcreeper.com/?p=1503
	*/
	class Malina_Control_Image_Select extends WP_Customize_Control {
	 
	    public function enqueue(){
	        wp_enqueue_style( 'css-for-customize' );
	        wp_enqueue_script( 'js-for-customize' );
	        
	    }

	    public function render_content(){

	        if ( empty( $this->choices ) ){ return; }
	 
	        if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif;
				if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo esc_html($this->description) ; ?></span>
			<?php endif;

	        $html = array();
			$tpl  = '<label class="asw-image-select"><img src="%s"><input type="%s" class="hidden" name="%s" value="%s" %s%s></label>';
			$field = $this->input_attrs;
			foreach ( $this->choices as $value => $image )
			{
				$html[] = sprintf(
					$tpl,
					$image,
					$field['multiple'] ? 'checkbox' : 'radio',
					$this->id,
					esc_attr( $value ),
					$this->get_link(),
					checked( $this->value(), $value, false )
				);
			}
			echo implode(' ', $html); 
	    }
	}

	/**
	 * Multiple select customize control class.
	 */
	class Malina_Customize_Control_Multiple_Select extends WP_Customize_Control {

	    /**
	     * The type of customize control being rendered.
	     */
	    public $type = 'multiple-select';

	    /**
	     * Displays the multiple select on the customize screen.
	     */
	    public function render_content() {

	    if ( empty( $this->choices ) )
	        return;
	    ?>
	        <label>
	            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	            <select <?php $this->link(); ?> multiple="multiple" style="height: 100%;">
	                <?php
	                    foreach ( $this->choices as $value => $label ) {
	                        if( is_array($this->value())) {
	                        	$selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
	                        } else {
	                        	$selected = '';	                        }
	                        echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
	                    }
	                ?>
	            </select>
	        </label>
	    <?php }
	}

	global $google_fonts;
	
	$faces = array( 
		'Arial' => 'Arial',
		'Verdana' => 'Verdana',
		'Trebuchet' => 'Trebuchet',
		'Georgia, sans-serif' => 'Georgia',
		'Times New Roman, sans-serif' => 'Times New Roman',
		'Tahoma' => 'Tahoma',
		'Palatino' => 'Palatino',
		'Helvetica, sans-serif' => 'Helvetica'
	);
	if( is_array($google_fonts) ){
		$google_fonts = array_combine($google_fonts, $google_fonts);
		$faces = array_merge($faces, $google_fonts);
	}
	$font_weights  = array(
		'100' => esc_html__('Thin', 'malina'),
		'200' => esc_html__('Extra-Light', 'malina'),
		'300' => esc_html__('Light', 'malina'),
		'400' => esc_html__('Regular', 'malina'),
		'500' => esc_html__('Medium', 'malina'),
		'600' => esc_html__('Semi-Bold', 'malina'),
		'700' => esc_html__('Bold', 'malina'),
		'800' => esc_html__('Extra-Bold', 'malina'),
		'900' => esc_html__('Black', 'malina')
	);

	$image_sizes = get_intermediate_image_sizes();
	$image_sizes[]= 'full';
	$image_sizes = array_combine($image_sizes, $image_sizes);
	class Malina_Customize_Control_Title extends WP_Customize_Control {

	    public function render_content(){

	        if ( empty( $this->label ) ){ return; }
	 
	        if ( ! empty( $this->label ) ) : ?>
					<h2><?php echo esc_html( $this->label ); ?>
				<?php endif;
				if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo esc_html($this->description) ; ?></span>
			</h2><?php endif; 
	    }
	}
	$order = array(
		'DESC'=> esc_html__('From highest to lowest', 'malina'),
		'ASC' => esc_html__('From lowest to highest', 'malina')
	);
	$orderby = array(
		'modified' => esc_html__('Last modified date', 'malina'),
		'comment_count' => esc_html__('Popularity', 'malina'),
		'title' => esc_html__('Title', 'malina'),
		'rand' => esc_html__('Random', 'malina'),
		'date' => esc_html__('Date', 'malina'),
		'post__in' => esc_html__('Preserve post ID order', 'malina')

	);
	$show_hide = array(
		'show' => esc_html__('Show', 'malina'),
		'hide' => esc_html__('Hide', 'malina')
	);
	$wp_customize->add_panel( 'malina_theme_options', array(
	    'priority' => 1,
	    'title' => esc_html__( 'Theme Options', 'malina' ),
	    'description' => esc_html__( 'Options for theme customizing', 'malina' ),
	) );
	
	$wp_customize->add_section(
	    'malina_general_options',
	    array(
	        'title'     => esc_html__('General', 'malina'),
	        'priority'  => 1,
	        'panel' => 'malina_theme_options'
	    )
	);
	$wp_customize->add_setting(
	    'malina_page_loading',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_page_loading',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Page loading animation','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_smooth_scroll',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_smooth_scroll',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Enable smooth scroll','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_live_search',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_live_search',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Enable live search.','malina'),
	        'description'     => esc_html__('Enable ajax search in header search form.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_gdpr_checkbox_consent',
	    array(
	        'default'    =>  'Save my name, email, and website in this browser for the next time I comment.',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_gdpr_checkbox_consent',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Comments cookies opt-in checkbox label','malina'),
	        'description' => esc_html__('This is checkbox label in comment form','malina'),
	        'type'      => 'textarea'
	    )
	);
	if(function_exists('malina_header_meta')){
		$wp_customize->add_setting(
		    'malina_seo_settings',
		    array(
		        'default'    =>  false,
		        'transport'  =>  'postMessage',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_seo_settings',
		    array(
		        'section'   => 'malina_general_options',
		        'label'     => esc_html__('Seo settings','malina'),
		        'description' => esc_html__('Check to disable inbuilt SEO','malina'),
		        'type'      => 'checkbox'
		    )
		);
		$wp_customize->add_setting(
		    'malina_meta_keywords',
		    array(
		        'default'            => '',
		        'transport'          => 'postMessage',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_meta_keywords',
		    array(
		        'section'  => 'malina_general_options',
		        'label'    => esc_html__('Meta Keywords', 'malina'),
		        'description' => esc_html__('Add relevant keywords separated with commas to improve SEO.','malina'),
		        'type'     => 'textarea'
		    )
		);
		$wp_customize->add_setting(
		    'malina_meta_description',
		    array(
		        'default'            => '',
		        'transport'          => 'postMessage',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_meta_description',
		    array(
		        'section'  => 'malina_general_options',
		        'label'    => esc_html__('Meta Description', 'malina'),
		        'description' => esc_html__('Enter a short description of the website for SEO.','malina'),
		        'type'     => 'textarea'
		    )
		);
	}
	$wp_customize->add_setting(
	    'malina_responsiveness',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_responsiveness',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Responsive Layout','malina'),
	        'description' => esc_html__('Check to enable responsiveness on your site.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_zoom_mobile',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_zoom_mobile',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Zoom on mobile devices','malina'),
	        'description' => esc_html__('Check to enable zoom on mobile devices. It will disable responsiveness on mobiles.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_back_to_top',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_back_to_top',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Back to top button','malina'),
	        'description' => esc_html__('Check to enable {back to top} button.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	/*images crop*/
	$wp_customize->add_setting(
	    'malina_images_cropping',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_images_cropping',
	        array(
	            'label'      	=> esc_html__( 'Images crop settings', 'malina' ),
	            'section'		=> 'malina_general_options',
	            'settings'		=> 'malina_images_cropping',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_crop_thumbnail',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_crop_thumbnail',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Crop thumbnail','malina'),
	        'description' => esc_html__('Check to enable cropping for thumbnail image size (160x160).','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_crop_medium',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_crop_medium',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Crop medium','malina'),
	        'description' => esc_html__('Check to enable cropping for medium image size (570x410).','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_crop_large',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_crop_large',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Crop large','malina'),
	        'description' => esc_html__('Check to enable cropping for large image size (1170x730).','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_crop_post_thumbnail',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_crop_post_thumbnail',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Crop post-thumbnail','malina'),
	        'description' => esc_html__('Check to enable cropping for post-thumbnail image size (845x550).','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_extra_medium_crop',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_extra_medium_crop',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Crop malina-extra-medium','malina'),
	        'description' => esc_html__('Check to enable cropping for malina-extra-medium image size (520x410).','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_slider_crop',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_slider_crop',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Crop malina-slider','malina'),
	        'description' => esc_html__('Check to enable cropping for malina-slider image size (1170x605).','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_fullwidth_slider_crop',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_fullwidth_slider_crop',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Crop malina-fullwidth-slider','malina'),
	        'description' => esc_html__('Check to enable cropping for malina-fullwidth-slider image size (1900x650).','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_google_map_api_key',
	    array(
	        'default'    =>  '',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_google_map_api_key',
	    array(
	        'section'   => 'malina_general_options',
	        'label'     => esc_html__('Add your google map api key to use it.','malina'),
	        'description' => esc_html__('Register your api key here https://cloud.google.com/maps-platform/','malina'),
	        'type'      => 'text'
	    )
	);
	/********************************/
	$wp_customize->add_section(
	    'malina_search_options',
	    array(
	        'title'     => esc_html__('Search Page', 'malina'),
	        'priority'  => 6,
	        'panel' => 'malina_theme_options'
	    )
	);
	$wp_customize->add_setting(
	    'malina_search_style',
	    array(
	        'default'    =>  'style_1',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_search_style',
	    array(
	        'section'   => 'malina_search_options',
	        'label'     => esc_html__('Search page layout','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'style_1' => esc_html__('Grid', 'malina'),
	        	'style_2' => esc_html__( 'Featured', 'malina' ),
	        	'style_3' => esc_html__( 'Featured even/odd', 'malina' ),
	        	'style_4' => esc_html__( 'Masonry', 'malina' ),
	        	'style_5' => esc_html__( 'List', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_search_post_count',
	    array(
	        'default'    =>  '6',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_search_post_count',
	    array(
	        'section'   => 'malina_search_options',
	        'label'     => esc_html__('Search page posts count','malina'),
	        'description' => esc_html__('Enter posts count for search page.','malina'),
	        'type'      => 'text'
	    )
	);
	$wp_customize->add_setting(
	    'malina_search_columns',
	    array(
	        'default'    =>  'span6',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_search_columns',
	    array(
	        'section'   => 'malina_search_options',
	        'label'     => esc_html__('Layout columns count','malina'),
	        'description'	=> esc_html__('Select columns count for "Grid", "Masonry" layouts', 'malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'span6' => esc_html__('Two columns', 'malina'),
	        	'span4' => esc_html__( 'Three columns', 'malina' ),
	        	'span3' => esc_html__( 'Four columns', 'malina' ),
	        	'span2' => esc_html__( 'Six columns', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_likes_search',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_likes_search',
	    array(
	        'section'   => 'malina_search_options',
	        'label'     => esc_html__('Show post likes count','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_views_search',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_views_search',
	    array(
	        'section'   => 'malina_search_options',
	        'label'     => esc_html__('Show post views count','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_comments_search',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_comments_search',
	    array(
	        'section'   => 'malina_search_options',
	        'label'     => esc_html__('Show post comments count','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_date_search',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_date_search',
	    array(
	        'section'   => 'malina_search_options',
	        'label'     => esc_html__('Show post date label','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_read_time_search',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_read_time_search',
	    array(
	        'section'   => 'malina_search_options',
	        'label'     => esc_html__('Show estimate time to read post','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_pagination_search',
	    array(
	        'default'    =>  'standard',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_pagination_search',
	    array(
	        'section'   => 'malina_search_options',
	        'label'     => esc_html__('Search page pagination','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'standard' => esc_html__('Standard pagination', 'malina'),
	        	'true' => esc_html__( 'Ajax Load More', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_search_excerpt_count',
	    array(
	        'default'    =>  '15',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_search_excerpt_count',
	    array(
	        'section'   => 'malina_search_options',
	        'label'     => esc_html__('Search excerpt count','malina'),
	        'description' => esc_html__('Enter excerpt count for search page.','malina'),
	        'type'      => 'text'
	    )
	);
	$wp_customize->add_setting(
	    'malina_sidebar_pos_search',
	    array(
	        'default'     => 'sidebar-right',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Control_Image_Select (
	        $wp_customize,
	        'malina_sidebar_pos_search',
	        array(
	            'label'      	=> esc_html__( 'Search page sidebar', 'malina' ),
	            'description'	=> esc_html__('Select sidebar position on search page, or disable it.', 'malina'),
	            'section'		=> 'malina_search_options',
	            'settings'		=> 'malina_sidebar_pos_search',
	            'choices'		=> array(
	            	'sidebar-right' => get_template_directory_uri().'/framework/customizer/images/sr.png',
	            	'sidebar-left'	=> get_template_directory_uri().'/framework/customizer/images/sl.png',
	            	'none'	=> get_template_directory_uri().'/framework/customizer/images/none.png',
	            ),
	            'input_attrs' => array(
	            	'multiple' => false
	            )
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_sticky_sidebar_search',
	    array(
	        'default'    =>  'sticky',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_sticky_sidebar_search',
	    array(
	        'section'   => 'malina_search_options',
	        'label'     => esc_html__('Sidebar sticky','malina'),
	        'description'     => esc_html__('Select sidebar sticky on scroll or not.','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'sticky' => esc_html__('Sticky', 'malina'),
	        	'scrolled' => esc_html__( 'Scrolled', 'malina' ),
	        )
	    )
	);
	/*******************************/
	/********************************/
	$wp_customize->add_section(
	    'malina_archive_options',
	    array(
	        'title'     => esc_html__('Archive Category/Tag Page', 'malina'),
	        'priority'  => 5,
	        'panel' => 'malina_theme_options'
	    )
	);
	$wp_customize->add_setting(
	    'malina_archive_style',
	    array(
	        'default'    =>  'style_1',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_archive_style',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Archive page layout','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'style_1' => esc_html__('Grid', 'malina'),
	        	'style_2' => esc_html__( 'Featured', 'malina' ),
	        	'style_3' => esc_html__( 'Featured even/odd', 'malina' ),
	        	'style_4' => esc_html__( 'Masonry', 'malina' ),
	        	'style_5' => esc_html__( 'List', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_archive_post_count',
	    array(
	        'default'    =>  '6',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_archive_post_count',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Category page posts count','malina'),
	        'description' => esc_html__('Enter posts count for category/tag page.','malina'),
	        'type'      => 'text'
	    )
	);
	$wp_customize->add_setting(
	    'malina_archive_columns',
	    array(
	        'default'    =>  'span6',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_archive_columns',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Layout columns count','malina'),
	        'description'	=> esc_html__('Select columns count for "Grid", "Masonry" layouts', 'malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'span6' => esc_html__('Two columns', 'malina'),
	        	'span4' => esc_html__( 'Three columns', 'malina' ),
	        	'span3' => esc_html__( 'Four columns', 'malina' ),
	        	'span2' => esc_html__( 'Six columns', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_archive_thumbnail_size',
	    array(
	        'default'    =>  'medium',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_archive_thumbnail_size',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Archive post humbnail size','malina'),
	        'type'      => 'select',
	        'choices'	=> $image_sizes
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_likes_archive',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_likes_archive',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Show post likes count','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_views_archive',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_views_archive',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Show post views count','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_comments_archive',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_comments_archive',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Show post comments count','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_date_archive',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_date_archive',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Show post date label','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_read_time_archive',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_read_time_archive',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Show estimate time to read post','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_pagination_archive',
	    array(
	        'default'    =>  'standard',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_pagination_archive',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Archive Posts pagination type','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'standard' => esc_html__('Standard pagination', 'malina'),
	        	'true' => esc_html__( 'Ajax Load More', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_archive_excerpt_count',
	    array(
	        'default'    =>  '17',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_archive_excerpt_count',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Category excerpt count','malina'),
	        'description' => esc_html__('Enter excerpt count for category/tag page.','malina'),
	        'type'      => 'text'
	    )
	);
	$wp_customize->add_setting(
	    'malina_sidebar_pos_archive',
	    array(
	        'default'     => 'sidebar-right',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Control_Image_Select (
	        $wp_customize,
	        'malina_sidebar_pos_archive',
	        array(
	            'label'      	=> esc_html__( 'Archive page sidebar', 'malina' ),
	            'description'	=> esc_html__('Select sidebar position on archive page, or disable it.', 'malina'),
	            'section'		=> 'malina_archive_options',
	            'settings'		=> 'malina_sidebar_pos_archive',
	            'choices'		=> array(
	            	'sidebar-right' => get_template_directory_uri().'/framework/customizer/images/sr.png',
	            	'sidebar-left'	=> get_template_directory_uri().'/framework/customizer/images/sl.png',
	            	'none'	=> get_template_directory_uri().'/framework/customizer/images/none.png',
	            ),
	            'input_attrs' => array(
	            	'multiple' => false
	            )
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_sticky_sidebar_archive',
	    array(
	        'default'    =>  'sticky',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_sticky_sidebar_archive',
	    array(
	        'section'   => 'malina_archive_options',
	        'label'     => esc_html__('Sidebar sticky','malina'),
	        'description'     => esc_html__('Select sidebar sticky on scroll or not.','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'sticky' => esc_html__('Sticky', 'malina'),
	        	'scrolled' => esc_html__( 'Scrolled', 'malina' ),
	        )
	    )
	);
	/*******************************/
	$wp_customize->add_section(
	    'malina_blog_options',
	    array(
	        'title'     => esc_html__('Blog', 'malina'),
	        'priority'  => 4,
	        'panel' => 'malina_theme_options'
	    )
	);
	$wp_customize->add_setting(
	    'malina_blog_title_style',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_blog_title_style',
	        array(
	            'label'      	=> esc_html__( 'Blog page style', 'malina' ),
	            'section'		=> 'malina_blog_options',
	            'settings'		=> 'malina_blog_title_style',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_blog_style',
	    array(
	        'default'    =>  'style_1',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_blog_style',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Blog layout','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'style_1' => esc_html__('Grid', 'malina'),
	        	'style_2' => esc_html__( 'Featured', 'malina' ),
	        	'style_3' => esc_html__( 'Featured even/odd', 'malina' ),
	        	'style_4' => esc_html__( 'Masonry', 'malina' ),
	        	'style_5' => esc_html__( 'List', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_blog_columns',
	    array(
	        'default'    =>  'span6',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_blog_columns',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Layout columns count','malina'),
	        'description'	=> esc_html__('Select columns count for "Grid", "Masonry" layouts', 'malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'span6' => esc_html__('Two columns', 'malina'),
	        	'span4' => esc_html__( 'Three columns', 'malina' ),
	        	'span3' => esc_html__( 'Four columns', 'malina' ),
	        	'span2' => esc_html__( 'Six columns', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_blog_elements_align',
	    array(
	        'default'    =>  'textcenter',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_blog_elements_align',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Select elements alignment','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'textleft' => esc_html__('Left', 'malina'),
	        	'textcenter' => esc_html__( 'Center', 'malina' ),
	        	'textright' => esc_html__( 'Right', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_blog_thumbnail_size',
	    array(
	        'default'    =>  'medium',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_blog_thumbnail_size',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Posts thumbnail size','malina'),
	        'type'      => 'select',
	        'choices'	=> $image_sizes
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_likes',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_likes',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Show post likes count','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_views',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_views',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Show post views count','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_comments',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_comments',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Show post comments count','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_categories',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_categories',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Show post categories','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_date',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_date',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Show post date label','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_read_time',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_read_time',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Show estimate time to read post','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_ignore_featured_posts',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_ignore_featured_posts',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Ignore featured posts?','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_ignore_sticky_posts',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_ignore_sticky_posts',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Ignore sticky posts?','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_post_pagination',
	    array(
	        'default'    =>  'standard',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_post_pagination',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Posts pagination type','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'standard' => esc_html__('Standard pagination', 'malina'),
	        	'true' => esc_html__( 'Ajax Load More', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_sidebar_pos',
	    array(
	        'default'     => 'sidebar-right',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Control_Image_Select (
	        $wp_customize,
	        'malina_sidebar_pos',
	        array(
	            'label'      	=> esc_html__( 'Blog page sidebar', 'malina' ),
	            'description'	=> esc_html__('Select sidebar position on blog page, or disable it.', 'malina'),
	            'section'		=> 'malina_blog_options',
	            'settings'		=> 'malina_sidebar_pos',
	            'choices'		=> array(
	            	'sidebar-right' => get_template_directory_uri().'/framework/customizer/images/sr.png',
	            	'sidebar-left'	=> get_template_directory_uri().'/framework/customizer/images/sl.png',
	            	'none'	=> get_template_directory_uri().'/framework/customizer/images/none.png',
	            ),
	            'input_attrs' => array(
	            	'multiple' => false
	            )
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_sticky_sidebar',
	    array(
	        'default'    =>  'sticky',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_sticky_sidebar',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Sidebar sticky','malina'),
	        'description'     => esc_html__('Select sidebar sticky on scroll or not.','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'sticky' => esc_html__('Sticky', 'malina'),
	        	'scrolled' => esc_html__( 'Scrolled', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_display_featured_img_preview',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_display_featured_img_preview',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Post format on preview','malina'),
	        'description' => esc_html__('Check this if you need to display featured image on preview instead of post format (video, gallery, audio, etc.). It will overwrite option globally.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_blog_excerpt_count',
	    array(
	        'default'    =>  '15',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_blog_excerpt_count',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Blog excerpt count','malina'),
	        'description' => esc_html__('Enter excerpt count for blog page.','malina'),
	        'type'      => 'text'
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_hero_slider',
	    array(
	        'default'    =>  'herosection',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_hero_slider',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Blog Hero Section','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'slider' => esc_html__('Slider', 'malina'),
	        	'herosection' => esc_html__( 'Fullwidth image + carousel', 'malina' ),
	        	'none' => esc_html__( 'None', 'malina' )
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_post_hero_settings_title',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_post_hero_settings_title',
	        array(
	            'label'      	=> esc_html__( 'Hero section settings', 'malina' ),
	            'section'		=> 'malina_blog_options',
	            'settings'		=> 'malina_post_hero_settings_title',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_blog_hero_image',
	    array(
	        'default'      => '',
	        'transport'    => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'malina_blog_hero_image',
	        array(
	            'label'    => esc_html__('Blog Hero Image','malina'),
	            'settings' => 'malina_blog_hero_image',
	            'section'  => 'malina_blog_options'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_hero_section_padtop',
	    array(
	        'default'    =>  '25',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_hero_section_padtop',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Hero section top padding','malina'),
	        'type'      => 'number'
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_hero_section_padright',
	    array(
	        'default'    =>  '25',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_hero_section_padright',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Hero section right padding','malina'),
	        'type'      => 'number'
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_hero_section_padbottom',
	    array(
	        'default'    =>  '25',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_hero_section_padbottom',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Hero section bottom padding','malina'),
	        'type'      => 'number'
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_hero_section_padleft',
	    array(
	        'default'    =>  '25',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_hero_section_padleft',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Hero section left padding','malina'),
	        'type'      => 'number'
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_hero_slides_count',
	    array(
	        'default'    =>  '5',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_hero_slides_count',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Blog hero section carousel items count','malina'),
	        'description' => esc_html__('Enter items count for hero section posts carousel on blog page.','malina'),
	        'type'      => 'number'
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_hero_text',
	    array(
	        'default'    =>  'Hello...',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'malina_sanitize_text_html',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_hero_text',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Hero section text','malina'),
	        'description' => esc_html__('Enter your hero section text.','malina'),
	        'type'      => 'text'
	    )
	);

	$wp_customize->add_setting( 
		'malina_home_hero_posts', 
		array(
	    	'default' => '',
	    	'transport'  =>  'refresh',
	    	'sanitize_callback' => 'malina_sanitize_posts_select',
		) 
	);
	 
	$wp_customize->add_control(
	    new Malina_Customize_Control_Multiple_Select(
	        $wp_customize,
	        'malina_home_hero_posts',
	        array(
	            'settings' => 'malina_home_hero_posts',
	            'label'    => esc_html__('Carousel posts IDs','malina'),
	            'description' => esc_html__('Select posts to show.','malina'),
	            'section'  => 'malina_blog_options',
	            'type'     => 'multiple-select', 
	            'choices'  => malina_get_all_posts()
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_hero_posts_orderby',
	    array(
	        'default'    =>  'date',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_hero_posts_orderby',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Order posts by:','malina'),
	        'type'      => 'select',
	        'choices'	=> $orderby
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_hero_posts_order',
	    array(
	        'default'    =>  'DESC',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_hero_posts_order',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Order','malina'),
	        'description' => esc_html__('Designates the ascending or descending order', 'malina'),
	        'type'      => 'select',
	        'choices'	=> $order
	    )
	);
	$wp_customize->add_setting(
	    'malina_post_slider_settings_title',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_post_slider_settings_title',
	        array(
	            'label'      	=> esc_html__( 'Blog slider settings', 'malina' ),
	            'section'		=> 'malina_blog_options',
	            'settings'		=> 'malina_post_slider_settings_title',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_slides_count',
	    array(
	        'default'    =>  '3',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_slides_count',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Blog page slider slides count','malina'),
	        'description' => esc_html__('Enter slides count for home page slider.','malina'),
	        'type'      => 'number'
	    )
	);
	$wp_customize->add_setting( 
		'malina_home_slider_posts', 
		array(
	    	'default' => '',
	    	'transport'  =>  'refresh',
	    	'sanitize_callback' => 'malina_sanitize_posts_select'
		) 
	);
	 
	$wp_customize->add_control(
	    new Malina_Customize_Control_Multiple_Select(
	        $wp_customize,
	        'malina_home_slider_posts',
	        array(
	            'settings' => 'malina_home_slider_posts',
	            'label'    => esc_html__('Slider posts IDs','malina'),
	            'description' => esc_html__('Select posts to show.','malina'),
	            'section'  => 'malina_blog_options', // Enter the name of your own section
	            'type'     => 'multiple-select', // The $type in our class
	            'choices'  => malina_get_all_posts_pages() // Your choices
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_slider_orderby',
	    array(
	        'default'    =>  'date',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_slider_orderby',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Order items by:','malina'),
	        'type'      => 'select',
	        'choices'	=> $orderby
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_slider_slideshow',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_slider_slideshow',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Slideshow','malina'),
	        'description' => esc_html__('Check to enable autoplay.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_slider_loop',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_slider_loop',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Loop','malina'),
	        'description' => esc_html__('Check to enable loop.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_slider_style',
	    array(
	        'default'    =>  'center',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_slider_style',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Slider layout','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'center' => esc_html__('Centered', 'malina'),
	        	'center2' => esc_html__('Two Centered', 'malina'),
	        	'simple' => esc_html__( 'Simple', 'malina' ),
	        	'two_per_row' => esc_html__( 'Two in row', 'malina' ),
	        	'three_per_row' => esc_html__( 'Three per row', 'malina' )
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_slider_width',
	    array(
	        'default'    =>  'fullwidth',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_slider_width',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Slider width','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'fullwidth' => esc_html__('Fullwidth', 'malina'),
	        	'container' => esc_html__( 'Container', 'malina' )
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_slider_overlay',
	    array(
	        'default'    =>  1,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_slider_overlay',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Slider item overlay','malina'),
	        'type'      => 'checkbox'
	    )
	);

	$wp_customize->add_setting(
	    'malina_home_slider_show_date',
	    array(
	        'default'    =>  1,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_slider_show_date',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Slider show date','malina'),
	        'type'      => 'checkbox'
	    )
	);

	$wp_customize->add_setting(
	    'malina_home_slider_readmore',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_slider_readmore',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Slider show readmore','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_slider_meta_categories',
	    array(
	        'default'    =>  1,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_slider_meta_categories',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Slider meta categories','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_home_slider_height',
	    array(
	        'default'    =>  '',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_home_slider_height',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Slider height','malina'),
	        'description' => esc_html__('Enter slider height in (px)','malina'),
	        'type'      => 'number'
	    )
	);
	$wp_customize->add_setting(
	    'malina_post_single_settings_title',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_post_single_settings_title',
	        array(
	            'label'      	=> esc_html__( 'Single post view', 'malina' ),
	            'section'		=> 'malina_blog_options',
	            'settings'		=> 'malina_post_single_settings_title',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_layout',
	    array(
	        'default'    =>  'default',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_post_layout',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Single post layout','malina'),
	        'description'     => esc_html__('Select your single post layout by default. Also, you can select "single post layout" for specific post.','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'default' => esc_html__('Standard', 'malina'),
	        	'wide' => esc_html__( 'Wide', 'malina' ),
	        	'fullwidth' => esc_html__( 'Fullwidth', 'malina' ),
	        	'fullwidth-alt' => esc_html__( 'Fullwidth Alt', 'malina' ),
	        	'fullwidth-alt2' => esc_html__( 'Fullwidth Alt 2', 'malina' ),
	        	'sideimage' => esc_html__( 'Side', 'malina' )
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_sidebar',
	    array(
	        'default'     => 'sidebar-right',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Control_Image_Select (
	        $wp_customize,
	        'malina_single_post_sidebar',
	        array(
	            'label'      	=> esc_html__( 'Single post sidebar', 'malina' ),
	            'description'	=> esc_html__('Select sidebar position on single post view, or disable it.', 'malina'),
	            'section'		=> 'malina_blog_options',
	            'settings'		=> 'malina_single_post_sidebar',
	            'choices'		=> array(
	            	'sidebar-right' => get_template_directory_uri().'/framework/customizer/images/sr.png',
	            	'sidebar-left'	=> get_template_directory_uri().'/framework/customizer/images/sl.png',
	            	'none'	=> get_template_directory_uri().'/framework/customizer/images/none.png',
	            ),
	            'input_attrs' => array(
	            	'multiple' => false
	            )
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_title_block',
	    array(
	        'default'    =>  'above',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_post_title_block',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Select title block position','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'above' => esc_html__('Above featured image', 'malina'),
	        	'under' => esc_html__( 'Under Featured image', 'malina' )
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_meta_date',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_post_meta_date',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Display date in title block?','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_related',
	    array(
	        'default'    =>  'false',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_post_related',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Related posts block','malina'),
	        'description'     => esc_html__('Select show or hide related posts.','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'true' => esc_html__('Show', 'malina'),
	        	'false' => esc_html__( 'Hide', 'malina' ),
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_sicky_sharebox',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_post_sicky_sharebox',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Sticky vertical sharebox','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_likes',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_post_likes',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Show post likes count','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_views',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_post_views',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Show post views count','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_read_time',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_post_read_time',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Show estimate time to read post','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_meta_sharebox',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_post_meta_sharebox',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Show sharebox in meta','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_author_info',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_post_author_info',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Author info','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_post_navigation',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_post_navigation',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Posts navigation','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_single_disable_comments',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_single_disable_comments',
	    array(
	        'section'   => 'malina_blog_options',
	        'label'     => esc_html__('Disable comments','malina'),
	        'description'     => esc_html__('Check to disable comments on single post view','malina'),
	        'type'      => 'checkbox'
	    )
	);
	/*******************************/
	$wp_customize->add_section(
	    'malina_header_options',
	    array(
	        'title'     => esc_html__('Header', 'malina'),
	        'priority'  => 2,
	        'panel'		=> 'malina_theme_options'
	    )
	);
	$wp_customize->add_setting(
	    'malina_header_variant',
	    array(
	        'default'     => 'header-version4',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    new Malina_Control_Image_Select (
	        $wp_customize,
	        'malina_header_variant',
	        array(
	            'label'      	=> esc_html__( 'Header style', 'malina' ),
	            'description'	=> esc_html__('Select header style.', 'malina'),
	            'section'		=> 'malina_header_options',
	            'settings'		=> 'malina_header_variant',
	            'choices'		=> array(
	            	'header-version1'	=> get_template_directory_uri().'/framework/customizer/images/h1.png',
	            	'header-version2'	=> get_template_directory_uri().'/framework/customizer/images/h2.png',
	            	'header-version3'	=> get_template_directory_uri().'/framework/customizer/images/h3.png',
	            	'header-version4'	=> get_template_directory_uri().'/framework/customizer/images/h4.png',
	            	'header-version5'	=> get_template_directory_uri().'/framework/customizer/images/h5.png',
	            	'header-version6'	=> get_template_directory_uri().'/framework/customizer/images/h6.png',
	            	'header-version7'	=> get_template_directory_uri().'/framework/customizer/images/h7.png',
	            ),
	            'input_attrs' => array(
	            	'multiple' => false
	            )
	        )
	    )
	);
	$wp_customize->add_setting(
		'malina_fixed_header', 
		array(
			'default' => true, 
			'transport' => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
	    'malina_fixed_header',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Fixed Header','malina'),
	        'description' => esc_html__('Check to fix your header at the top of the page.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_header_grid',
	    array(
	        'default'    =>  'container header-fullwidth',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_header_grid',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Strech header','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'container' => esc_html__('Do not strech', 'malina'),
	        	'container header-fullwidth' => esc_html__('Strech header', 'malina')
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_header_image',
	    array(
	        'default'      => '',
	        'transport'    => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'malina_header_image',
	        array(
	            'label'    => esc_html__('Header Background Image','malina'),
	            'settings' => 'malina_header_image',
	            'section'  => 'malina_header_options'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_header_bg_size',
	    array(
	        'default'    =>  'auto',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_header_bg_size',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Background size','malina'),
	        'type'      => 'radio',
	        'choices'	=> array(
	        	'auto' => esc_html__('Auto', 'malina'),
	        	'cover' => esc_html__('Cover', 'malina'),
	        	'contain' => esc_html__('Contain', 'malina')
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_header_bg_color',
	    array(
	        'default'     => '#ffffff',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_header_bg_color',
	        array(
	            'label'      => esc_html__( 'Header background color', 'malina' ),
	            'section'    => 'malina_header_options',
	            'settings'   => 'malina_header_bg_color'
	        )
	    )
	);

    $wp_customize->add_setting(
	    'malina_header_bg_color_opacity',
	    array(
	        'default'    =>  1,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_header_bg_color_opacity',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => __('Header background color opacity','malina'),
	        'type'      => 'range',
	        'input_attrs' => array( 'min' => 0, 'max' => 1, 'step'  => 0.1 )
	    )
	);
	$wp_customize->add_setting(
	    'malina_header_bottom_border_width',
	    array(
	        'default'    =>  '1',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_header_bottom_border_width',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Header bottom border width','malina'),
	        'description' => esc_html__('Use this field to set border width. Do not set (px).', 'malina'),
	        'type'      => 'text',
	    )
	);
	$wp_customize->add_setting(
	    'malina_header_border_color',
	    array(
	        'default'     => '#e5e6e8',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_header_border_color',
	        array(
	            'label'      => esc_html__( 'Header bottom border color', 'malina' ),
	            'section'    => 'malina_header_options',
	            'settings'   => 'malina_header_border_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_header_top_border_width',
	    array(
	        'default'    =>  '0',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_header_top_border_width',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Header top border width','malina'),
	        'description' => esc_html__('Use this field to set border width. Do not set (px).', 'malina'),
	        'type'      => 'text',
	    )
	);
	$wp_customize->add_setting(
	    'malina_header_top_border_color',
	    array(
	        'default'     => '#e5e6e8',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_header_top_border_color',
	        array(
	            'label'      => esc_html__( 'Header top border color', 'malina' ),
	            'section'    => 'malina_header_options',
	            'settings'   => 'malina_header_top_border_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_media_logo',
	    array(
	        'default'      => '',
	        'transport'    => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'malina_media_logo',
	        array(
	            'label'    => esc_html__('Logo Image','malina'),
	            'settings' => 'malina_media_logo',
	            'section'  => 'malina_header_options'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_media_logo_width',
	    array(
	        'default'    =>  '18',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_media_logo_width',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Logo size','malina'),
	        'description' => esc_html__('Use this field to set image width or for text font size. Do not set (px).', 'malina'),
	        'type'      => 'text',
	    )
	);
	$wp_customize->add_setting(
	    'malina_logo_font_family',
	    array(
	        'default'     => 'Montserrat',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_logo_font_family',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('font family','malina'),
	        'type'      => 'select',
	        'choices'	=> $faces
	    )
	);
	$wp_customize->add_setting(
	    'malina_logo_color',
	    array(
	        'default'     => '#1c1d1f',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_logo__color',
	        array(
	            'label'      => esc_html__( 'Logo text color', 'malina' ),
	            'section'    => 'malina_header_options',
	            'settings'   => 'malina_logo_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_logo_font_weight',
	    array(
	        'default'     => '500',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_logo_font_weight',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Logo font weight','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_weights
	    )
	);
	$wp_customize->add_setting(
	    'malina_logo_transform',
	    array(
	        'default'    =>  'uppercase',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_logo_transform',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Logo text transform','malina'),
	        'type'      => 'select',
	        'choices' 	=> array(
	        	'none' => esc_html__('None', 'malina'),
	        	'capitalize' => esc_html__('Capitalize', 'malina'),
	        	'uppercase' => esc_html__('Uppercase', 'malina')
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_logo_title_letter_spacing',
	    array(
	        'default'     => '1.5',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_logo_title_letter_spacing',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Logo title letter-spacing','malina'),
	        'type'      => 'number',
	        'input_attrs' => array( 'min' => 0, 'max' => 10, 'step'  => 0.1 )
	    )
	);
	$wp_customize->add_setting(
	    'malina_mobile_logo_settings_title',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_mobile_logo_settings_title',
	        array(
	            'label'      	=> esc_html__( 'Mobile logo', 'malina' ),
	            'section'		=> 'malina_header_options',
	            'settings'		=> 'malina_mobile_logo_settings_title',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_media_logo_mobile',
	    array(
	        'default'      => '',
	        'transport'    => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'malina_media_logo_mobile',
	        array(
	            'label'    => esc_html__('Mobile Logo Image','malina'),
	            'settings' => 'malina_media_logo_mobile',
	            'section'  => 'malina_header_options'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_media_logo_mobile_width',
	    array(
	        'default'    =>  '',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_media_logo_mobile_width',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Mobile Logo size','malina'),
	        'description' => esc_html__('Use this field to set image width or for text font size. Do not set (px).', 'malina'),
	        'type'      => 'text',
	    )
	);
	
	$wp_customize->add_setting(
	    'malina_nav_settings_title',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_nav_settings_title',
	        array(
	            'label'      	=> esc_html__( 'Navigation Settings', 'malina' ),
	            'section'		=> 'malina_header_options',
	            'settings'		=> 'malina_nav_settings_title',
	        )
	    )
	);
	$font_sizes = array();
	$font_sizes_px_none = array();
	for ($i = 9; $i <= 50; $i++){ 
		$font_sizes[$i.'px'] = $i.'px';
		$font_sizes_px_none[$i] = $i.'px';
	}
    $wp_customize->add_setting(
	    'malina_menu_font_size',
	    array(
	        'default'     => '12px',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_menu_font_size',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('font size','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_sizes
	    )
	);
	
	$wp_customize->add_setting(
	    'malina_menu_font_family',
	    array(
	        'default'     => 'Montserrat',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_menu_font_family',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('font family','malina'),
	        'type'      => 'select',
	        'choices'	=> $faces
	    )
	);
	$wp_customize->add_setting(
	    'malina_menu_font_weight',
	    array(
	        'default'     => '500',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_menu_font_weight',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('font weight','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_weights
	    )
	);
	$wp_customize->add_setting(
	    'malina_menu_transform',
	    array(
	        'default'    =>  'uppercase',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_menu_transform',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Menu text transform','malina'),
	        'type'      => 'select',
	        'choices' 	=> array(
	        	'none' => esc_html__('None', 'malina'),
	        	'capitalize' => esc_html__('Capitalize', 'malina'),
	        	'uppercase' => esc_html__('Uppercase', 'malina')
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_menu_item_color',
	    array(
	        'default'     => '#2c2e30',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_menu_item_color',
	        array(
	            'label'      => esc_html__( 'items color (initial)', 'malina' ),
	            'section'    => 'malina_header_options',
	            'settings'   => 'malina_menu_item_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_menu_item_color_active',
	    array(
	        'default'     => '#8c8f93',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_menu_item_color_active',
	        array(
	            'label'      => esc_html__( 'items color (hover, active)', 'malina' ),
	            'section'    => 'malina_header_options',
	            'settings'   => 'malina_menu_item_color_active'
	        )
	    )
	);

	$wp_customize->add_setting(
	    'malina_menu_item_padding',
	    array(
	        'default'    =>  '42',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_menu_item_padding',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => __('Space between items','malina'),
	        'description' => __('Space between menu items.','malina'),
	        'type'      => 'range',
	        'input_attrs' => array( 'min' => 10, 'max' => 80, 'step'  => 2 )
	    )
	);

	$wp_customize->add_setting(
	    'malina_navigation_disable_dots',
	    array(
	        'default'    =>  true,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_navigation_disable_dots',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => esc_html__('Disable dots','malina'),
	        'description' => esc_html__('Check to disable dots between menu items.','malina'),
	        'type'      => 'checkbox'
	    )
	);

	$wp_customize->add_setting(
	    'malina_menu_dropdown_bg',
	    array(
	        'default'     => '#ffffff',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_menu_dropdown_bg',
	        array(
	            'label'      => esc_html__( 'Dropdown menu background color', 'malina' ),
	            'section'    => 'malina_header_options',
	            'settings'   => 'malina_menu_dropdown_bg'
	        )
	    )
	);
    $wp_customize->add_setting(
	    'malina_menu_dropdown_bg_opacity',
	    array(
	        'default'    =>  '1',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_menu_dropdown_bg_opacity',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => __('Dropdown menu background opacity','malina'),
	        'type'      => 'range',
	        'input_attrs' => array( 'min' => 0, 'max' => 1, 'step'  => 0.1 )
	    )
	);
	$wp_customize->add_setting(
	    'malina_menu_dropdown_items_border',
	    array(
	        'default'     => '#bbc4c7',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_menu_dropdown_items_border',
	        array(
	            'label'      => esc_html__( 'Dropdown menu items border', 'malina' ),
	            'section'    => 'malina_header_options',
	            'settings'   => 'malina_menu_dropdown_items_border'
	        )
	    )
	);

	$wp_customize->add_setting(
	    'malina_header_elements_title',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_header_elements_title',
	        array(
	            'label'      	=> esc_html__( 'Header elements', 'malina' ),
	            'section'		=> 'malina_header_options',
	            'settings'		=> 'malina_header_elements_title',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_header_search_button',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_header_search_button',
	    array(
	        'section'   => 'malina_header_options',
	        'label'     => __('Search button','malina'),
	        'description' => __('Check to enable search button in header.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	if(function_exists('malina_get_social_links')) {
		$wp_customize->add_setting(
		    'malina_header_socials',
		    array(
		        'default'    =>  true,
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_header_socials',
		    array(
		        'section'   => 'malina_header_options',
		        'label'     => esc_html__('Socials','malina'),
		        'description' => esc_html__('Check to enable socials in header.','malina'),
		        'type'      => 'checkbox'
		    )
		);
		$wp_customize->add_setting(
		    'malina_header_socials_color',
		    array(
		        'default'     => '',
		        'transport'   => 'postMessage',
		        'sanitize_callback' => 'sanitize_hex_color',
		    )
		);

	    $wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'malina_header_socials_color',
		        array(
		            'label'      => esc_html__( 'Header socials icons color', 'malina' ),
		            'section'    => 'malina_header_options',
		            'settings'   => 'malina_header_socials_color'
		        )
		    )
		);
	}
	if( class_exists('WooCommerce')){
		$wp_customize->add_setting(
		    'malina_header_shopping_cart',
		    array(
		        'default'    =>  false,
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_header_shopping_cart',
		    array(
		        'section'   => 'malina_header_options',
		        'label'     => __('Shopping cart icon','malina'),
		        'description' => __('Check to enable shopping cart icon.','malina'),
		        'type'      => 'checkbox'
		    )
		);
	}
	$wp_customize->add_section(
	    'malina_footer_options',
	    array(
	        'title'     => esc_html__('Footer', 'malina'),
	        'priority'  => 3,
	        'panel'		=> 'malina_theme_options'
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_layout',
	    array(
	        'default'     => 'layout-2',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_footer_layout',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Footer layout','malina'),
	        'type'      => 'select',
	        'choices'	=> array(
	        	'layout-1' => esc_html__('Fullwidth layout','malina'),
	        	'layout-2' => esc_html__('Container layout','malina')
	        )
	    )
	);

	$wp_customize->add_setting(
	    'malina_footer_bg_image',
	    array(
	        'default'      => '',
	        'transport'    => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'malina_footer_bg_image',
	        array(
	            'label'    => esc_html__('Footer Background Image','malina'),
	            'settings' => 'malina_footer_bg_image',
	            'section'  => 'malina_footer_options'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_bg_size',
	    array(
	        'default'    =>  'auto',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_footer_bg_size',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Background size','malina'),
	        'type'      => 'radio',
	        'choices'	=> array(
	        	'auto' => esc_html__('Auto', 'malina'),
	        	'cover' => esc_html__('Cover', 'malina'),
	        	'contain' => esc_html__('Contain', 'malina')
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_bg_position',
	    array(
	        'default'    =>  'center bottom',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_footer_bg_position',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Background position','malina'),
	        'type'      => 'radio',
	        'choices'	=> array(
	        	'center top' => esc_html__('Center Top', 'malina'),
	        	'center center' => esc_html__('Center Center', 'malina'),
	        	'center bottom' => esc_html__('Center Bottom', 'malina')
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_bg_color',
	    array(
	        'default'     => '#1d1f20',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_footer_bg_color',
	        array(
	            'label'      => esc_html__( 'Footer background color', 'malina' ),
	            'section'    => 'malina_footer_options',
	            'settings'   => 'malina_footer_bg_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_top_padding',
	    array(
	        'default'    =>  '45',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_footer_top_padding',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Footer top padding','malina'),
	        'description' => esc_html__('Do not set (px).', 'malina'),
	        'type'      => 'text',
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_bottom_padding',
	    array(
	        'default'    =>  '90',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_footer_bottom_padding',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Footer bottom padding','malina'),
	        'description' => esc_html__('Do not set (px).', 'malina'),
	        'type'      => 'text',
	    )
	);
	if(function_exists('malina_get_social_links')) {
		$wp_customize->add_setting(
		    'malina_footer_instagram_title',
		    array(
		        'default'    		=>  'MALINA INSTAGRAM',
		        'transport'  		=>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_footer_instagram_title',
		    array(
		        'section'   => 'malina_footer_options',
		        'label'     => esc_html__('Instagram title','malina'),
		        'type'      => 'text',
		    )
		);
		$wp_customize->add_setting(
		    'malina_footer_instagram_access_token',
		    array(
		        'default'    		=>  '',
		        'transport'  		=>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_footer_instagram_access_token',
		    array(
		        'section'   => 'malina_footer_options',
		        'label'     => esc_html__('Instagram access token','malina'),
		        'description' => esc_html__('If you want to show instagram in footer area, please input access token.','malina').' <a href="https://instagram.com/oauth/authorize/?client_id=1677ed07ddd54db0a70f14f9b1435579&redirect_uri=http://instagram.pixelunion.net&response_type=token">'.esc_html__('Get access token', 'malina').'</a>',
		        'type'      => 'text',
		    )
		);
		$wp_customize->add_setting(
		    'malina_footer_instagram_pics',
		    array(
		        'default'    		=>  '4',
		        'transport'  		=>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_footer_instagram_pics',
		    array(
		        'section'   => 'malina_footer_options',
		        'label'     => esc_html__('Instagram items count, max count is 20 items','malina'),
		        'type'      => 'text',
		    )
		);
		$wp_customize->add_setting(
		    'malina_footer_instagram_pics_per_row',
		    array(
		        'default'    		=>  '4',
		        'transport'  		=>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_footer_instagram_pics_per_row',
		    array(
		        'section'   => 'malina_footer_options',
		        'label'     => esc_html__('Instagram items count per row','malina'),
		        'type'      => 'select',
		        'choices'	=> array(
		        	'2' => esc_html__('Two per row', 'malina'),
		        	'3' => esc_html__('Three per row', 'malina'),
		        	'4' => esc_html__('Four per row', 'malina'),
		        	'6' => esc_html__('Six per row', 'malina')
		        )
		    )
		);
		$wp_customize->add_setting(
		    'malina_footer_socials',
		    array(
		        'default'    =>  true,
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_footer_socials',
		    array(
		        'section'   => 'malina_footer_options',
		        'label'     => esc_html__('Socials','malina'),
		        'description' => esc_html__('Check to enable socials in footer.','malina'),
		        'type'      => 'checkbox'
		    )
		);
		$wp_customize->add_setting(
		    'malina_footer_socials_color',
		    array(
		        'default'     => '',
		        'transport'   => 'postMessage',
		        'sanitize_callback' => 'sanitize_hex_color',
		    )
		);
	    $wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
		        'malina_footer_socials_color',
		        array(
		            'label'      => esc_html__( 'Socials color', 'malina' ),
		            'section'    => 'malina_footer_options',
		            'settings'   => 'malina_footer_socials_color'
		        )
		    )
		);
	}
	$wp_customize->add_setting(
	    'malina_footer_copy_title',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_footer_copy_title',
	        array(
	            'label'      	=> esc_html__( 'Copyright Section settings', 'malina' ),
	            'section'		=> 'malina_footer_options',
	            'settings'		=> 'malina_footer_copy_title',
	        )
	    )
	);
	$wp_customize->add_setting(
	'malina_footer_copyright_border',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_footer_copyright_border',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Footer copyright section border','malina'),
	        'description' => esc_html__('Check to enable border for copyright footer section.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_copyright',
	    array(
	        'default'    		=>  '',
	        'transport'  		=>  'refresh',
	        'sanitize_callback' => 'malina_sanitize_text_html',
	    )
	);
	$wp_customize->add_control(
	    'malina_footer_copyright',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Copyright text','malina'),
	        'description' => esc_html__('Add copyright text to footer area.','malina'),
	        'type'      => 'textarea',
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_copyright_font_size',
	    array(
	        'default'     => '11px',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_footer_copyright_font_size',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Copyright text font size','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_sizes
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_copyright_font_family',
	    array(
	        'default'     => 'Montserrat',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_footer_copyright_font_family',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Copyright text font family','malina'),
	        'type'      => 'select',
	        'choices'	=> $faces
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_copyright_color',
	    array(
	        'default'     => '#ffffff',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_footer_copyright_color',
	        array(
	            'label'      => esc_html__( 'Copyright text color', 'malina' ),
	            'section'    => 'malina_footer_options',
	            'settings'   => 'malina_footer_copyright_color'
	        )
	    )
	);

	$wp_customize->add_setting(
	'malina_footer_logo',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_footer_logo',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Footer logo','malina'),
	        'description' => esc_html__('Check to enable logo in copyright footer section.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_logo_img',
	    array(
	        'default'      => '',
	        'transport'    => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    new WP_Customize_Image_Control(
	        $wp_customize,
	        'malina_footer_logo_img',
	        array(
	            'label'    => esc_html__('Footer Logo Image','malina'),
	            'settings' => 'malina_footer_logo_img',
	            'section'  => 'malina_footer_options'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_logo_size',
	    array(
	        'default'     => '18',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_footer_logo_size',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Logo size','malina'),
	        'description' => esc_html__('Logo width for image or font size for text logo. Do not set (px)','malina'),
	        'type'      => 'text',
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_logo_font_family',
	    array(
	        'default'     => 'Montserrat',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_footer_logo_font_family',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Footer Logo font family','malina'),
	        'type'      => 'select',
	        'choices'	=> $faces
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_logo_color',
	    array(
	        'default'     => '#151516',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
	 $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_footer_logo_color',
	        array(
	            'label'      => esc_html__( 'Footer text logo color', 'malina' ),
	            'section'    => 'malina_footer_options',
	            'settings'   => 'malina_footer_logo_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_logo_transform',
	    array(
	        'default'    =>  'uppercase',
	        'transport'  =>  'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_footer_logo_transform',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('Footer logo text transform','malina'),
	        'type'      => 'select',
	        'choices' 	=> array(
	        	'none' => esc_html__('None', 'malina'),
	        	'capitalize' => esc_html__('Capitalize', 'malina'),
	        	'uppercase' => esc_html__('Uppercase', 'malina')
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_footer_logo_font_weight',
	    array(
	        'default'     => '400',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_footer_logo_font_weight',
	    array(
	        'section'   => 'malina_footer_options',
	        'label'     => esc_html__('font weight','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_weights
	    )
	);
	/*--------------------------------------------------*/
	$wp_customize->add_section(
	    'malina_headings_options',
	    array(
	        'title'     => esc_html__('Headings', 'malina'),
	        'priority'  => 6,
	        'panel'		=> 'malina_theme_options'
	    )
	);
	$wp_customize->add_setting(
	    'malina_blog_head_title',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_blog_head_title',
	        array(
	            'label'      	=> esc_html__( 'Posts headings', 'malina' ),
	            'section'		=> 'malina_headings_options',
	            'settings'		=> 'malina_blog_head_title',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_posts_headings_font_size',
	    array(
	        'default'     => '34',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_posts_headings_font_size',
	    array(
	        'section'   => 'malina_headings_options',
	        'label'     => esc_html__('font size','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_sizes_px_none
	    )
	);
	$wp_customize->add_setting(
	    'malina_posts_headings_font_weight',
	    array(
	        'default'     => '300',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_posts_headings_font_weight',
	    array(
	        'section'   => 'malina_headings_options',
	        'label'     => esc_html__('font weight','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_weights
	    )
	);
	$wp_customize->add_setting(
	    'malina_posts_headings_font_family',
	    array(
	        'default'     => 'Montserrat',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_posts_headings_font_family',
	    array(
	        'section'   => 'malina_headings_options',
	        'label'     => esc_html__('font family','malina'),
	        'type'      => 'select',
	        'choices'	=> $faces
	    )
	);
	$wp_customize->add_setting(
	    'malina_posts_headings_letter_spacing',
	    array(
	        'default'     => '1.5',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_posts_headings_letter_spacing',
	    array(
	        'section'   => 'malina_headings_options',
	        'label'     => esc_html__('Post title letter-spacing','malina'),
	        'type'      => 'number',
	        'input_attrs' => array( 'min' => 0, 'max' => 10, 'step'  => 0.1 )
	    )
	);
	$wp_customize->add_setting(
	    'malina_post_headings_transform',
	    array(
	        'default'    =>  'uppercase',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_post_headings_transform',
	    array(
	        'section'   => 'malina_headings_options',
	        'label'     => esc_html__('Title text transform','malina'),
	        'type'      => 'select',
	        'choices' 	=> array(
	        	'none' => esc_html__('None', 'malina'),
	        	'capitalize' => esc_html__('Capitalize', 'malina'),
	        	'uppercase' => esc_html__('Uppercase', 'malina')
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_posts_headings_item_color',
	    array(
	        'default'     => '#1c1d1f',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_posts_headings_item_color',
	        array(
	            'label'      => esc_html__( 'items color (initial)', 'malina' ),
	            'section'    => 'malina_headings_options',
	            'settings'   => 'malina_posts_headings_item_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_posts_headings_item_color_active',
	    array(
	        'default'     => '#ce8460',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_posts_headings_item_color_active',
	        array(
	            'label'      => esc_html__( 'items color (hover)', 'malina' ),
	            'section'    => 'malina_headings_options',
	            'settings'   => 'malina_posts_headings_item_color_active'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_widgets_head_title',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_widgets_head_title',
	        array(
	            'label'      	=> esc_html__( 'Widgets headings', 'malina' ),
	            'section'		=> 'malina_headings_options',
	            'settings'		=> 'malina_widgets_head_title',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_widgets_headings_font_size',
	    array(
	        'default'     => '11px',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_widgets_headings_font_size',
	    array(
	        'section'   => 'malina_headings_options',
	        'label'     => esc_html__('font size','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_sizes
	    )
	);
	$wp_customize->add_setting(
	    'malina_widgets_headings_font_weight',
	    array(
	        'default'     => '400',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_widgets_headings_font_weight',
	    array(
	        'section'   => 'malina_headings_options',
	        'label'     => esc_html__('font weight','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_weights
	    )
	);
	$wp_customize->add_setting(
	    'malina_widgets_headings_font_family',
	    array(
	        'default'     => 'Montserrat',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_widgets_headings_font_family',
	    array(
	        'section'   => 'malina_headings_options',
	        'label'     => esc_html__('font family','malina'),
	        'type'      => 'select',
	        'choices'	=> $faces
	    )
	);
	$wp_customize->add_setting(
	    'malina_widgets_headings_letter_spacing',
	    array(
	        'default'     => '1',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_widgets_headings_letter_spacing',
	    array(
	        'section'   => 'malina_headings_options',
	        'label'     => esc_html__('Widget title letter-spacing','malina'),
	        'type'      => 'number',
	        'input_attrs' => array( 'min' => 0, 'max' => 10, 'step'  => 0.1 )
	    )
	);
	$wp_customize->add_setting(
	    'malina_widgets_headings_transform',
	    array(
	        'default'    =>  'uppercase',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_widgets_headings_transform',
	    array(
	        'section'   => 'malina_headings_options',
	        'label'     => esc_html__('Widget title text transform','malina'),
	        'type'      => 'select',
	        'choices' 	=> array(
	        	'none' => esc_html__('None', 'malina'),
	        	'capitalize' => esc_html__('Capitalize', 'malina'),
	        	'uppercase' => esc_html__('Uppercase', 'malina')
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_widgets_headings_item_color',
	    array(
	        'default'     => '#1c1d1f',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_widgets_headings_item_color',
	        array(
	            'label'      => esc_html__( 'color', 'malina' ),
	            'section'    => 'malina_headings_options',
	            'settings'   => 'malina_widgets_headings_item_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_widgets_headings_separator',
	    array(
	        'default'    =>  false,
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_widgets_headings_separator',
	    array(
	        'section'   => 'malina_headings_options',
	        'label'     => esc_html__('Widget heading separator','malina'),
	        'description' => esc_html__('Check to enable heading separator line.','malina'),
	        'type'      => 'checkbox'
	    )
	);
	if(function_exists('malina_get_social_links')) {
		$wp_customize->add_section(
		    'malina_socials_options',
		    array(
		        'title'     => esc_html__('Socials', 'malina'),
		        'description' => esc_html__('Add your social links, otherwise leave blank if you need not some links.','malina'),
		        'priority'  => 7,
		        'panel'		=> 'malina_theme_options'
		    )
		);
		$wp_customize->add_setting(
		    'malina_sharing_facebook',
		    array(
		        'default'    =>  true,
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_sharing_facebook',
		    array(
		        'section'   => 'malina_socials_options',
		        'label'     => esc_html__('Show Facebook in share box.','malina'),
		        'type'      => 'checkbox'
		    )
		);
		$wp_customize->add_setting(
		    'malina_sharing_twitter',
		    array(
		        'default'    =>  true,
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_sharing_twitter',
		    array(
		        'section'   => 'malina_socials_options',
		        'label'     => esc_html__('Show Twitter in share box.','malina'),
		        'type'      => 'checkbox'
		    )
		);
		$wp_customize->add_setting(
		    'malina_sharing_whatsapp',
		    array(
		        'default'    =>  false,
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_sharing_whatsapp',
		    array(
		        'section'   => 'malina_socials_options',
		        'label'     => esc_html__('Show whatsapp in share box.','malina'),
		        'type'      => 'checkbox'
		    )
		);
		$wp_customize->add_setting(
		    'malina_sharing_pinterest',
		    array(
		        'default'    =>  true,
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_sharing_pinterest',
		    array(
		        'section'   => 'malina_socials_options',
		        'label'     => esc_html__('Show Pinterest in share box.','malina'),
		        'type'      => 'checkbox'
		    )
		);
		$wp_customize->add_setting(
		    'malina_sharing_linkedin',
		    array(
		        'default'    =>  false,
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_sharing_linkedin',
		    array(
		        'section'   => 'malina_socials_options',
		        'label'     => esc_html__('Show Linkedin in share box.','malina'),
		        'type'      => 'checkbox'
		    )
		);
		$wp_customize->add_setting(
		    'malina_sharing_googleplus',
		    array(
		        'default'    =>  false,
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_sharing_googleplus',
		    array(
		        'section'   => 'malina_socials_options',
		        'label'     => esc_html__('Show Google+ in share box.','malina'),
		        'type'      => 'checkbox'
		    )
		);
		$wp_customize->add_setting(
		    'malina_sharing_email',
		    array(
		        'default'    =>  false,
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_sharing_email',
		    array(
		        'section'   => 'malina_socials_options',
		        'label'     => esc_html__('Show Email in share box.','malina'),
		        'type'      => 'checkbox'
		    )
		);
	
		$socials = array('vkontakte', 'facebook', 'twitter', 'instagram', 'goodreads', 'pinterest', 'google_plus', 'spotify', 'forrst', 'dribbble', 'flickr', 'linkedin', 'digg', 'vimeo', 'yahoo', 'tumblr', 'youtube', 'deviantart', 'behance', 'paypal', 'delicious');
		foreach ($socials as $social) {
			$wp_customize->add_setting(
			    'malina_social_'.$social,
			    array(
			        'default'    =>  '',
			        'transport'  =>  'refresh',
		        	'sanitize_callback' => 'sanitize_text_field',
			    )
			);
			$wp_customize->add_control(
			    'malina_social_'.$social,
			    array(
			        'section'   => 'malina_socials_options',
			        'label'     => esc_html__(ucfirst(str_replace('_', ' ', $social)).' url','malina'),
			        'type'      => 'text'
			    )
			);
		}
		$wp_customize->add_setting(
		    'malina_social_skype',
		    array(
		        'default'    =>  '',
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_social_skype',
		    array(
		        'section'   => 'malina_socials_options',
		        'label'     => esc_html__('Skype account','malina'),
		        'type'      => 'text'
		    )
		);
		$wp_customize->add_setting(
		    'malina_social_rss',
		    array(
		        'default'    =>  false,
		        'transport'  =>  'refresh',
		        'sanitize_callback' => 'sanitize_text_field',
		    )
		);
		$wp_customize->add_control(
		    'malina_social_rss',
		    array(
		        'section'   => 'malina_socials_options',
		        'label'     => esc_html__('Show rss','malina'),
		        'type'      => 'checkbox'
		    )
		);
	}
	$wp_customize->add_section(
	    'malina_styling_options',
	    array(
	        'title'     => esc_html__('Styling', 'malina'),
	        'priority'  => 8,
	        'panel'		=> 'malina_theme_options'
	    )
	);
	$wp_customize->add_setting(
	    'malina_accent_color',
	    array(
	        'default'     => '#ce8460',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_accent_color',
	        array(
	            'label'      => esc_html__( 'Theme main color', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_accent_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_body_font_size',
	    array(
	        'default'     => '13px',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_body_font_size',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Body font size','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_sizes
	    )
	);
	$wp_customize->add_setting(
	    'malina_body_line_height',
	    array(
	        'default'     => '28px',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_body_line_height',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Body text line height','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_sizes
	    )
	);
	$wp_customize->add_setting(
	    'malina_body_font_family',
	    array(
	        'default'     => 'Open Sans',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_body_font_family',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Body font family','malina'),
	        'type'      => 'select',
	        'choices'	=> $faces
	    )
	);
	$wp_customize->add_setting(
	    'malina_body_color',
	    array(
	        'default'     => '#444b4d',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_body_color',
	        array(
	            'label'      => esc_html__( 'Body text color', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_body_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_links_color',
	    array(
	        'default'     => '#ce8460',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
	$wp_customize->add_setting(
	    'malina_body_top_padding',
	    array(
	        'default'     => '0',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_body_top_padding',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => __('Body top padding','malina'),
	        'type'      => 'number',
	        'input_attrs' => array( 'min' => 0, 'max' => 150, 'step'  => 1 )
	    )
	);
	$wp_customize->add_setting(
	    'malina_body_right_padding',
	    array(
	        'default'     => '0',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_body_right_padding',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => __('Body right padding','malina'),
	        'type'      => 'number',
	        'input_attrs' => array( 'min' => 0, 'max' => 150, 'step'  => 1 )
	    )
	);
	$wp_customize->add_setting(
	    'malina_body_bottom_padding',
	    array(
	        'default'     => '0',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_body_bottom_padding',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => __('Body bottom padding','malina'),
	        'type'      => 'number',
	        'input_attrs' => array( 'min' => 0, 'max' => 150, 'step'  => 1 )
	    )
	);
	$wp_customize->add_setting(
	    'malina_body_left_padding',
	    array(
	        'default'     => '0',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_body_left_padding',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => __('Body left padding','malina'),
	        'type'      => 'number',
	        'input_attrs' => array( 'min' => 0, 'max' => 150, 'step'  => 1 )
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_links_color',
	        array(
	            'label'      => esc_html__( 'Links color (initial)', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_links_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_links_color_hover',
	    array(
	        'default'     => '#1c1d1f',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_links_color_hover',
	        array(
	            'label'      => esc_html__( 'Links color (hover)', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_links_color_hover'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_meta_title_style',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_meta_title_style',
	        array(
	            'label'      	=> esc_html__( 'Meta Categories styling', 'malina' ),
	            'section'		=> 'malina_styling_options',
	            'settings'		=> 'malina_meta_title_style',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_meta_categories_font_size',
	    array(
	        'default'     => '18px',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_meta_categories_font_size',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Meta categories font size','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_sizes
	    )
	);
	$wp_customize->add_setting(
	    'malina_meta_categories_font_family',
	    array(
	        'default'     => 'Dancing Script',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_meta_categories_font_family',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Meta categories font family','malina'),
	        'type'      => 'select',
	        'choices'	=> $faces
	    )
	);
	$wp_customize->add_setting(
	    'malina_meta_categories_transform',
	    array(
	        'default'    =>  'none',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_meta_categories_transform',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Meta ctegories text transform','malina'),
	        'type'      => 'select',
	        'choices' 	=> array(
	        	'none' => esc_html__('None', 'malina'),
	        	'capitalize' => esc_html__('Capitalize', 'malina'),
	        	'uppercase' => esc_html__('Uppercase', 'malina')
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_meta_categories_color',
	    array(
	        'default'     => '#ce8460',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_meta_categories_color',
	        array(
	            'label'      => esc_html__( 'Meta categories color initial', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_meta_categories_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_meta_categories_color_hover',
	    array(
	        'default'     => '#ccc',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_meta_categories_color_hover',
	        array(
	            'label'      => esc_html__( 'Meta categories color hover', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_meta_categories_color_hover'
	        )
	    )
	);
    $wp_customize->add_setting(
	    'malina_meta_info_title_style',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_meta_info_title_style',
	        array(
	            'label'      	=> esc_html__( 'Meta Info (likes, views, etc.) styling', 'malina' ),
	            'section'		=> 'malina_styling_options',
	            'settings'		=> 'malina_meta_info_title_style',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_meta_info_font_size',
	    array(
	        'default'     => '11px',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_meta_info_font_size',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Meta font size','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_sizes
	    )
	);
	$wp_customize->add_setting(
	    'malina_meta_info_font_family',
	    array(
	        'default'     => 'Montserrat',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_meta_info_font_family',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Meta info font family','malina'),
	        'type'      => 'select',
	        'choices'	=> $faces
	    )
	);
	$wp_customize->add_setting(
	    'malina_meta_info_transform',
	    array(
	        'default'    =>  'uppercase',
	        'transport'  =>  'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_meta_info_transform',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Meta info text transform','malina'),
	        'type'      => 'select',
	        'choices' 	=> array(
	        	'none' => esc_html__('None', 'malina'),
	        	'capitalize' => esc_html__('Capitalize', 'malina'),
	        	'uppercase' => esc_html__('Uppercase', 'malina')
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_meta_info_color',
	    array(
	        'default'     => '#888c8e',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_meta_info_color',
	        array(
	            'label'      => esc_html__( 'Meta info color initial', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_meta_info_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_buttons_title_style',
	    array(
	        'default'     => '',
	        'transport'   => 'refresh',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    new Malina_Customize_Control_Title (
	        $wp_customize,
	        'malina_buttons_title_style',
	        array(
	            'label'      	=> esc_html__( 'Buttons styling', 'malina' ),
	            'section'		=> 'malina_styling_options',
	            'settings'		=> 'malina_buttons_title_style',
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_button_font_size',
	    array(
	        'default'     => '11px',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_button_font_size',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Button font size','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_sizes
	    )
	);
	$wp_customize->add_setting(
	    'malina_button_font_family',
	    array(
	        'default'     => 'Montserrat',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_button_font_family',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Button font family','malina'),
	        'type'      => 'select',
	        'choices'	=> $faces
	    )
	);
	$wp_customize->add_setting(
	    'malina_button_letter_spacing',
	    array(
	        'default'     => '1',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_button_letter_spacing',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => __('Default button letter spacing','malina'),
	        'type'      => 'range',
	        'input_attrs' => array( 'min' => 0, 'max' => 5, 'step'  => 0.1 )
	    )
	);
	$wp_customize->add_setting(
	    'malina_button_font_weight',
	    array(
	        'default'     => '300',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
    $wp_customize->add_control(
	    'malina_button_font_weight',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => esc_html__('Default button font weight','malina'),
	        'type'      => 'select',
	        'choices'	=> $font_weights
	    )
	);
	$wp_customize->add_setting(
	    'malina_button_default_bg_color',
	    array(
	        'default'     => '#1d1f20',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_button_default_bg_color',
	        array(
	            'label'      => esc_html__( 'Button default background color', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_button_default_bg_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_button_default_text_color',
	    array(
	        'default'     => '#ffffff',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_button_default_text_color',
	        array(
	            'label'      => esc_html__( 'Button default text color', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_button_default_text_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_button_default_border_color',
	    array(
	        'default'     => '#1d1f20',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_button_default_border_color',
	        array(
	            'label'      => esc_html__( 'Button default border color', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_button_default_border_color'
	        )
	    )
	);

	$wp_customize->add_setting(
	    'malina_button_border_radius',
	    array(
	        'default'     => '0',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_button_border_radius',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => __('Default button border radius','malina'),
	        'type'      => 'range',
	        'input_attrs' => array( 'min' => 0, 'max' => 50, 'step'  => 1 )
	    )
	);

	$wp_customize->add_setting(
	    'malina_button_vertical_padding',
	    array(
	        'default'     => '13',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_button_vertical_padding',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => __('Default button top/bottom padding','malina'),
	        'type'      => 'number',
	        'input_attrs' => array( 'min' => 0, 'max' => 30, 'step'  => 1 )
	    )
	);

	$wp_customize->add_setting(
	    'malina_button_horizontal_padding',
	    array(
	        'default'     => '32',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_text_field',
	    )
	);
	$wp_customize->add_control(
	    'malina_button_horizontal_padding',
	    array(
	        'section'   => 'malina_styling_options',
	        'label'     => __('Default button left/right padding','malina'),
	        'type'      => 'number',
	        'input_attrs' => array( 'min' => 0, 'max' => 64, 'step'  => 1 )
	    )
	);

	$wp_customize->add_setting(
	    'malina_button_loadmore_bg_color',
	    array(
	        'default'     => '#ffffff',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_button_loadmore_bg_color',
	        array(
	            'label'      => esc_html__( 'Button loadmore background color', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_button_loadmore_bg_color'
	        )
	    )
	);
    $wp_customize->add_setting(
	    'malina_button_loadmore_border_color',
	    array(
	        'default'     => '#b8b6bb',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);
    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_button_loadmore_border_color',
	        array(
	            'label'      => esc_html__( 'Button loadmore border color', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_button_loadmore_border_color'
	        )
	    )
	);
	$wp_customize->add_setting(
	    'malina_button_loadmore_text_color',
	    array(
	        'default'     => '#201f22',
	        'transport'   => 'postMessage',
	        'sanitize_callback' => 'sanitize_hex_color',
	    )
	);

    $wp_customize->add_control(
	    new WP_Customize_Color_Control(
	        $wp_customize,
	        'malina_button_loadmore_text_color',
	        array(
	            'label'      => esc_html__( 'Button loadmore text color', 'malina' ),
	            'section'    => 'malina_styling_options',
	            'settings'   => 'malina_button_loadmore_text_color'
	        )
	    )
	);

	$wp_customize->add_section(
	    'malina_google_fonts_options',
	    array(
	        'title'     => esc_html__('Google fonts ext.', 'malina'),
	        'description' => esc_html__('Select google fonts extensions to load. It allows to reduce load speed.','malina'),
	        'priority'  => 9,
	        'panel'		=> 'malina_theme_options'
	    )
	);
	$wp_customize->add_setting(
        'malina_google_font_subset',
        array(
            'default'           => 'latin',
            'sanitize_callback' => 'sanitize_text_field'
        )
    );
    $wp_customize->add_control(
        new Malina_Customize_Control_Checkbox_Multiple(
            $wp_customize,
            'malina_google_font_subset',
            array(
                'section' => 'malina_google_fonts_options',
                'label'   => esc_html__( 'Languages subset', 'malina' ),
                'choices' => array(
                	'latin' => esc_html__( 'Latin', 'malina' ),
                    'cyrillic' => esc_html__( 'Cyrillic', 'malina' ),
                    'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'malina' ),
                    'greek' => esc_html__( 'Greek', 'malina' ),
                    'greek-ext' => esc_html__( 'Greek Extended', 'malina' ),
                    'latin-ext' => esc_html__( 'Latin Extended', 'malina' ),
                    'vietnamese' => esc_html__( 'Vietnamese', 'malina' ),
                )
            )
        )
    );
    $google_fonts = malina_get_used_google_fonts();
    foreach ( $google_fonts as $font ) {
    	$font_l = strtolower(str_replace(' ', '-', $font));
    	$wp_customize->add_setting(
	        'malina_google_font_'.$font_l,
	        array(
	            'default'           => '400',
	            'sanitize_callback' => 'sanitize_text_field'
	        )
	    );
	    $wp_customize->add_control(
	        new Malina_Customize_Control_Checkbox_Multiple(
	            $wp_customize,
	            'malina_google_font_'.$font_l,
	            array(
	                'section' => 'malina_google_fonts_options',
	                'label'   => $font,
	                'choices' => malina_get_google_font_styles()
	            )
	        )
	    );
    }
}
add_action( 'customize_register', 'malina_register_theme_customizer', 110 );
function malina_sanitize_multiple_checkbox( $values ) {

    $multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;

    return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
}
/* Register Customizer Scripts */
add_action( 'customize_controls_enqueue_scripts', 'malina_share_customize_register_scripts', 0 );
/**
 * Register Scripts
 * so we can easily load this scripts multiple times when needed (?)
 */
function malina_share_customize_register_scripts(){
	/* CSS */
	wp_register_style( 'css-for-customize', get_template_directory_uri() . '/framework/customizer/css/customizer-control.css' );
	/* JS */
	wp_register_script( 'js-for-customize', get_template_directory_uri() . '/framework/customizer/js/customizer-control.js', array( 'jquery', 'jquery-ui-sortable', 'customize-controls' ) );
}

add_action( 'customize_preview_init', 'malina_customizer_live_preview' );
function malina_customizer_live_preview() {
     wp_enqueue_script(
        'asw-theme-customizer',
        get_template_directory_uri() . '/framework/customizer/js/theme-customizer.js',
        array( 'jquery', 'customize-preview' ),
        '1.0',
        true
    );
}
function malina_get_used_google_fonts(){
	$googlefonts = array_unique(
		array(
			get_theme_mod('malina_menu_font_family', 'Montserrat'),
			get_theme_mod('malina_logo_font_family', 'Montserrat'),
			get_theme_mod('malina_posts_headings_font_family', 'Montserrat'),
			get_theme_mod('malina_widgets_headings_font_family', 'Montserrat'),
			get_theme_mod('malina_body_font_family', 'Open Sans'),
			get_theme_mod('malina_button_font_family', 'Montserrat'),
			get_theme_mod('malina_footer_copyright_font_family', 'Montserrat'),
			get_theme_mod('malina_meta_categories_font_family', 'Dancing Script'),
			get_theme_mod('malina_footer_logo_font_family', 'Montserrat'),
		)
	);
	return $googlefonts;
}
function malina_get_google_font_styles(){
	$google_style = '100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
	$google_style = explode(',', $google_style);
	return array_combine($google_style, $google_style);
}
if (!function_exists('malina_google_fonts')){
	add_action( 'wp_enqueue_scripts', 'malina_google_fonts' );
	add_action( 'enqueue_block_editor_assets', 'malina_google_fonts' );
	function malina_google_fonts() {
		$default = array(
				'Arial',
				'Verdana',
				'Trebuchet',
				'Georgia, sans-serif',
				'Times New Roman, sans-serif',
				'Tahoma',
				'Palatino',
				'Helvetica, sans-serif'
		);

		$googlefonts = malina_get_used_google_fonts();	
		$customfont = '';
		$googlefonts = array_unique($googlefonts);
		$google_style = ':100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
		$fonts_set = '';
		$subset = get_theme_mod('malina_google_font_subset');
		$subset_str = '';
		if(is_array($subset)){
			$subset = array_unique($subset);
			if(!empty($subset)){
				$subset_str = implode(',', $subset);
			}
		} else {
			$subset_str = $subset;
		}
		if($subset_str == '' || $subset_str == 'latin'){
			$subset_str = '';
		} else {
			$subset_str = '&amp;subset='.$subset_str;
		}
		$count = 1;	
		foreach($googlefonts as $getfonts) {
			if(!in_array($getfonts, $default)) {
				$font_l = strtolower(str_replace(' ', '-', $getfonts));
				$google_style_t = get_theme_mod('malina_google_font_'.$font_l);
				if(is_array($google_style_t)){
					$google_style_t = array_unique($google_style_t);
					if(!empty($google_style_t)){
						$google_style = ':'.implode(',', $google_style_t);
					}
				} else {
					if($google_style_t != ''){
						$google_style = ':'.$google_style_t;
					}
				}
				$customfont = str_replace(' ', '+', $getfonts).$google_style;
				if($customfont != ''){
					$font_name = strtolower(str_replace(' ', '-', $getfonts));
					if($count == 1) {
						$divider = '';
					} else {
						$divider = '|';
					}
				    $fonts_set .= $divider.$customfont;
				}
				$count++;
			}
		}
		if( $fonts_set != '' ){
			wp_enqueue_style( 'google-fonts-malina', esc_url("//fonts.googleapis.com/css?family=".$fonts_set.$subset_str), array(), NULL, 'all' );
		}
	}
}