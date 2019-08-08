( function( api ) {

	// Extends our custom "nutrigen" section.
	api.sectionConstructor['nutrigen'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );