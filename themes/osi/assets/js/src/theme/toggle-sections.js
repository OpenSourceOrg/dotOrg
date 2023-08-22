/*
Name: Toggle Sections
Author: Team 51
Author URI: http://marktimemedia.com
Version: 0.1
License: GPLv2
*/

(function($) {

	$(document).ready(function(){

		$('.toggle-header h2').click(function(){
			var tab_id = $(this).parent().attr('id');

            if( $(this).parent().hasClass('open') ) {
                $(this).parent().removeClass('open');
                $('[data-toggle="'+tab_id+'"]').removeClass('open');
            } else {
                $(this).parent().addClass('open');
                $('[data-toggle="'+tab_id+'"]').addClass('open');
            }
		});

	});

})( jQuery );