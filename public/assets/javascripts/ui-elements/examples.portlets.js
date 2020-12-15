(function( $ ) {
	'use strict';
	$('#portletRefresh').on('click', function(ev) {
		ev.preventDefault();
		window.location.reload();
	});
	$('#portletReset').on('click', function(ev) {
		ev.preventDefault();
		store.remove('__portletOrder');
		store.remove('__portletState');
		window.location.reload();
	});
}).apply( this, [ jQuery ]);
