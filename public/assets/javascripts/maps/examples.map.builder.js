(function( $ ) {
	'use strict';
	var $window = $(window);
	function fixMapListener() {
		fixMapSize();
		$(window).on('load resize orientationchange', function() {
			fixMapSize();
		});
	}
	function fixMapSize() {
		if ( $window.width() <= 767 ) {
			var windowHeight = $(window).height(),
				offsetTop = $('#gmap').offset().top,
				contentPadding = parseInt($('.content-body').css('padding-bottom'), 10);
			$('#gmap').height( windowHeight - offsetTop - contentPadding );
		}
	}
	$(function() {
		fixMapListener();
	});
}).apply(this, [ jQuery ]);
