<?php if( is_active_sidebar('hidden-widgets') ){?>	
	<div id="hidden-area-widgets">
		<div class="widgets-side">
			<a href="#" class="close-button"><i class="la la-close"></i></a>
			<?php
				if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('Hidden Area Widgets') );
			?>
		</div>
	</div>
<?php } ?>