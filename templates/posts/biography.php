<?php
global $post;
?>

<div class="author-info">
	<div class="author-avatar">
		<?php
		if ( function_exists( 'malina_get_additional_user_meta_thumb' ) ){
			// retrieve our additional author meta info
			$user_meta_image = esc_attr( get_the_author_meta( 'user_meta_image', $post->post_author ) );
		    // make sure the field is set
		    if ( isset( $user_meta_image ) && $user_meta_image ) {
		        // only display if function exists
		        ?>
					<img alt="<?php esc_attr_e('author photo', 'malina'); ?>" src="<?php echo malina_get_additional_user_meta_thumb(); ?>" class="aligncenter" />
		        <?php } ?>
		<?php } else {
			echo get_avatar( get_the_author_meta('user_email'), '90', '' );
		} ?>
	</div><!-- .author-avatar -->

	<div class="author-description">
		<div class="author-title">
			<h2>
				<?php
					$fname = get_the_author_meta('first_name');
					$lname = get_the_author_meta('last_name');
					$full_name = '';
			
					if( empty($fname)){
					    $full_name = $lname;
					} elseif( empty( $lname )){
					    $full_name = $fname;
					} else {
					    //both first name and last name are present
					    $full_name = "{$fname} {$lname}";
					}
					if( empty($fname) && empty( $lname ) ){
						$full_name = get_the_author();
					}
				?>
				<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php echo esc_html($full_name); ?></a>
			</h2>
			<?php if(function_exists('malina_get_user_socials')){ echo malina_get_user_socials(); } ?>
		</div>
		<div class="author-bio">
			<?php the_author_meta( 'description' ); ?>
		</div><!-- .author-bio -->
	</div><!-- .author-description -->
</div><!-- .author-info -->
