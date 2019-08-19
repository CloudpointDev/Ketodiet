<?php get_header(); ?>

<?php 
	MalinaSetPostViews(get_the_ID());
	$post_layout = rwmb_get_value( 'malina_post_layout' );
	if(is_array($post_layout)){
		$post_layout = '';
	}
	if( $post_layout == 'default'){
		$post_layout = get_theme_mod( 'malina_single_post_layout', 'default' );
	}
	
	switch ($post_layout) {
		case 'sideimage':
			get_template_part('templates/posts/single/template', 'sideimage');
			break;
		case 'wide':
			get_template_part('templates/posts/single/template', 'wide');
			break;
		case 'fullwidth':
			get_template_part('templates/posts/single/template', 'fullwidth');
			break;
		case 'fullwidth-alt':
			get_template_part('templates/posts/single/template', 'fullwidth-alt');
			break;
		case 'fullwidth-alt2':
			get_template_part('templates/posts/single/template', 'fullwidth-alt2');
			break;
		default:
			get_template_part('templates/posts/single/template', 'default');
			break;
	}
?>

<?php get_footer(); ?>
