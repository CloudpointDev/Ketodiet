( function( api ) {

	// Extends our custom "nutrella" section.
	api.sectionConstructor['nutrella'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );