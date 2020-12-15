(function($) {
	'use strict';
	var $document,
		idleTime;
	$document = $(document);
	$(function() {
		$.idleTimer( 10000 ); 
		$document.on( 'idle.idleTimer', function() {
			LockScreen.show();
		});
	});
}).apply( this, [ jQuery ]);
