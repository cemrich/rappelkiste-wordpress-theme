/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. Your javascript should grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
(function($) {

	wp.customize('accent_color', function(value) {
		value.bind(function(newval) {
			$('.post-nav, .widget').css('border-color', newval);
		});
	});

	wp.customize('accent_color_2', function(value) {
		value.bind(function(newval) {
			$('.section.bg-dark').css('background-color', newval);
			$('.blog-search').css('background-color', newval);
			$('.navigation').css('background-color', newval);
			$('.toggle-container').css('background-color', newval);
			$('.mobile-menu a').css('background-color', newval);
			$('.search-toggle .glass').css('background-color', newval);
			$('.blog-menu ul li').css('background-color', newval);
			$('.blog-menu li:hover a').css('background-color', newval);
			$('.blog-info').css('background-color', newval);
		
			$('.post').css('border-color', newval);
			$('.page').css('border-color', newval);
			
			$('.post-meta a').css('color', newval);
			$('.post-meta span').css('color', newval);
		});
	});
	
})(jQuery);
