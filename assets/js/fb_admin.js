jQuery( document ).ready( function( $ ){

	$( '#add_page_id' ).on( 'click', function() {
		var count_next = $(this).data('count')+1;

		//document.getElementById('row').innerHTML += '<input type="text" id="br_settings[br_site_url]['+count_next+']"  name="br_settings[br_site_url]['+count_next+']" value="" >';
		$( '#row' ).append( '<br><input type="text" id="fb_settings[fb_page_id]['+count_next+']"  name="fb_settings[fb_page_id]['+count_next+']" value="" >' );
		$( '#add_page_id' ).data('count', count_next);
	});
});