/* global jQuery:false */
/* global NAZARETH_STORAGE:false */

jQuery( document ).ready(
	function() {
		setTimeout( function() {
			jQuery('.editor-block-list__layout').addClass('scheme_' + NAZARETH_STORAGE['color_scheme']);
		}, 100 );
	}
);

