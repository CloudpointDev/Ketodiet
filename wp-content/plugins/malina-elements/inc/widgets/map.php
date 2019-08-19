<?php


class widget_malina_map extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => esc_html__('Display your location', 'malina-elements') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'kenadllmap' );
		parent::__construct( 'kenadllmap', esc_html__('malina-Map', 'malina-elements'), $widget_ops, $control_ops );
	}

	// Widget Output
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$address = isset($instance['address']) ? $instance['address'] : 'NY';
		$zoom = isset($instance['zoom']) ? $instance['zoom'] : '1';
		$map_id = 'map'.$this->id;
		$marker = MALINA_PLUGIN_URL."/images/mapmarker.png";
		// ------
		echo $before_widget;
		if ( $title !='' ) echo $before_title . $title . $after_title;
		
		echo '<div class="map" id="'.esc_attr($map_id).'" style="height:185px;"></div><div class="located-at">'.esc_html__('Located at:','malina-elements').'<span> '.esc_html($address).'</span></div>';
		echo '<script type="text/javascript">
		var map;
			function initMap() {
			  var styles = "";//[{"featureType": "transit","elementType": "labels.text.stroke","stylers": [ {"visibility": "off"}]},{"featureType": "landscape","elementType": "all","stylers": [ {"visibility": "off"},{"hue": "#454043"},{"saturation": -76},{"lightness": 43}]},{"featureType": "landscape","elementType": "all","stylers": [ {"visibility": "off"},{"hue": "#454440"}]},{"featureType": "road","elementType": "labels","stylers": [ {"visibility": "off"},{"hue": "#b8ab97"},{"lightness": 29}]},{"featureType": "road","elementType": "all","stylers": [ {"visibility": "off"}]},{"featureType": "water","elementType": "all","stylers": [ {"visibility": "on"},{"color": "#ffffff"},{"lightness": 13}]},{"featureType": "poi.park","elementType": "all","stylers": [ {"visibility": "off"},{"hue": "#50a10f"}]},{"featureType": "transit","elementType": "labels","stylers": [ {"visibility": "on"},{"lightness": 27}]},{"featureType": "landscape.man_made", "elementType": "all", "stylers": [ {"visibility": "off"}]},{"featureType": "all","elementType": "labels","stylers": [ {"visibility": "off"},{"lightness": 37}]},{"featureType": "poi.medical", "elementType": "all","stylers": [ {"visibility": "off"}]},{"featureType": "poi.school","elementType": "all","stylers": [ {"visibility": "on"}]},{"featureType": "poi","elementType": "labels","stylers": [ {"visibility": "off"},{"lightness": 30}]},{"featureType": "landscape.natural","elementType": "all","stylers": [ {"visibility": "off"}]},{"featureType": "landscape.natural.landcover","elementType": "all","stylers": [ {"visibility": "off"}]},{"featureType": "poi","elementType": "all","stylers": [ {"visibility": "off"}]},{"featureType": "transit", "elementType": "all", "stylers": [ {"visibility": "off"}]},{"featureType": "administrative","elementType": "all","stylers": [ {"visibility": "off"}]}];
			  map = new google.maps.Map(document.getElementById("'.$map_id.'"), {
			    center: new google.maps.LatLng(35,10),
			    zoom: '.$zoom.',
			    minZoom: 1,
			    navigationControl:!1,
			    mapTypeControl:!1,
			    scaleControl:!1,
			    streetViewControl:!1,
			    disableDefaultUI: true
			  });
			  map.setOptions({styles: styles});
				var address = "'.$address.'";
				var geocoder = new google.maps.Geocoder();
				var image = "'.esc_url($marker).'";
				geocoder.geocode({
				  "address": address
				}, 
				function(results, status) {
				  if(status == google.maps.GeocoderStatus.OK) {
				     new google.maps.Marker({
				        position: results[0].geometry.location,
				        map: map,
				        icon: image
				     });
				     map.setCenter(results[0].geometry.location);}
				});
			}
    	</script>';
		echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key='.get_theme_mod('malina_google_map_api_key','AIzaSyAx66dUdUxqso3rtXMWBwgaICBrGS-3xyo').'&libraries=places,geometry&callback=initMap&v=weekly"></script>';
		echo $after_widget;
		// ------
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['zoom'] = $new_instance['zoom'];
		$instance['address'] = sanitize_text_field($new_instance['address']);
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => '', 'zoom' => '3', 'address' => 'NY');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('address')); ?>"><?php esc_html_e('Address:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('address')); ?>" name="<?php echo esc_attr($this->get_field_name('address')); ?>" value="<?php echo esc_attr($instance['address']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('zoom')); ?>"><?php esc_html_e('Zoom:','malina-elements'); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('zoom')); ?>" name="<?php echo esc_attr($this->get_field_name('zoom')); ?>" value="<?php echo esc_attr($instance['zoom']); ?>" />
		</p>
		
    <?php }
}

// Add Widget
function widget_malina_map_init() {
	register_widget('widget_malina_map');
}
add_action('widgets_init', 'widget_malina_map_init');

?>