( function( api ) {
	// Extends our custom "psyclone-lite" section.
	api.sectionConstructor['psyclone-lite'] = api.Section.extend( {
		// No events for this type of section.
		attachEvents: function () {},
		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );
} )( wp.customize );