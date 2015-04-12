(function($) {

	jQuery(document).bind('gform_post_render', function (event, formId, current_page) {
	    $('#gform_page_' + formId + '_' + current_page ).addClass('active');

	    
	});

	/**
	 * Calculate the height after the window completely loads
	 */
	$(window).load(function(){
	    $('.dop-form .gfield.tab').eq(0).each(function() {

			toggleTabContainer( $(this) );
		});
	});
	

	/**
	 * Check for tab clicks
	 */
	toggleTabEvent();

	/**
	 * Check for fields being selected and also make active
	 * previously selected values
	 */
	checkChecked();

	/**
	 * When switching pages, check for tabs that need to be activated
	 */
	jQuery(document).bind('gform_page_loaded', function(event, form_id, current_page){
        var firstTab = $('#gform_page_' + form_id + '_' + current_page + ' .gfield.tab').eq(0).addClass('active');
        
        // Activate first tab
        toggleTabContainer( firstTab );

        // Check for selected fields
        checkChecked();

        // Allow toggle of tabs when switching between pages
        toggleTabEvent();
    });

	function toggleTabContainer( tab ) {
		if( tab === undefined )
			return false;

		$('.dop-form .gfield.tab').removeClass('active');

		$tab = $(tab);

		$tab.addClass('active');

		$tab.css( 'height', $tab.children('.ginput_container').height() + 100 );

		//$tab.closest('.gform_page').css( 'height', 'auto' ); // Recalculate the height before we set it again
		//$tab.closest('.gform_page').css( 'height', $tab.closest('.gform_page').height() + $tab.children('.ginput_container').height() + 180 );
	}

	function toggleTabEvent() {
		$('.dop-form .gfield.tab .gfield_label').on('click', function(e) {
			e.preventDefault();

			toggleTabContainer( $(this).closest('.gfield') );
		});
	}

	function checkChecked() {
		$('.dop-form input[type=checkbox], .dop-form input[type=radio]').each(function(e) {
			
			$(this).siblings('label').on('click', function(e) {

				var multiple = $(this).closest('ul').is('.gfield_radio, .gfield_infoselect') ? false : true;

				if( multiple ) {
					$(this).toggleClass('active');
				}else {
					$(this).closest('ul').find('label').removeClass('active');

					$(this).addClass('active');
				}
			});
			
		});

		
	}

})(jQuery); 