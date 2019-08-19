
<?php get_header(); ?>

<div id="page-wrap" class="container">
	<div id="content" class="span12">
		<div class="woocommerce">
			<?php if( class_exists('WooCommerce') ){
				woocommerce_content();
			} ?>
		</div>
	</div> <!-- end content -->
	
</div> <!-- end page-wrap -->
	
<?php get_footer(); ?>
