jQuery( document ).ready( function($) {
	$( 'ul.my-multicheck-sortable-list' ).sortable({
	    axis: "y",
	    cursor: "move",
	    update: function( e, ui ){
	        $('ul.my-multicheck-sortable-list input').trigger( 'change' );
	    }
	});
	$( "ul.my-multicheck-sortable-list li input" ).on( 'change', function(){
 
	    /* Get the value, and convert to string. */
	    this_checkboxes_values = $( this ).parents( 'ul.my-multicheck-sortable-list' ).find( 'li input' ).map( function(){
	        var active = '0';
	        if( $(this).prop("checked") ){
	            var active = '1';
	        }
	        return this.value + ':' + active;
	    }).get().join( ',' );
	   /* Add the value to hidden input. */
	   $( this ).parents( 'ul.my-multicheck-sortable-list' ).next( 'input[type="hidden"]' ).val( this_checkboxes_values ).trigger( 'change' );
	 
	});

	$( '.asw-image-select input' ).on( 'change', function ()
	{
		var $this = $( this ),
			type = $this.attr( 'type' ),
			selected = $this.is( ':checked' ),
			$parent = $this.parent(),
			$others = $parent.siblings();
		if ( selected )
		{
			$parent.addClass( 'asw-active' );
			if ( type === 'radio' )
			{
				$others.removeClass( 'asw-active' );
			}
		}
		else
		{
			$parent.removeClass( 'asw-active' );
		}
	} );

	$( '.asw-image-select input' ).trigger( 'change' );
	/* === Checkbox Multiple Control === */

    $( '.customize-control-checkbox-multiple input[type="checkbox"]' ).on( 'change', function() {

            checkbox_values = $( this ).parents( '.customize-control-checkbox-multiple' ).find( 'input[type="checkbox"]:checked' ).map(
                function() {
                    return this.value;
                }
            ).get().join( ',' );

            $( this ).parents( '.customize-control-checkbox-multiple' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
        }
    );
    $( '.customize-control-checkbox-multiple input' ).trigger( 'change' );
})