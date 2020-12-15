(function( $ ) {
	'use strict';
	var SessionTimeout = {
		options: {
			keepAliveUrl: '',
			alertOn: 15000, 
			timeoutOn: 20000 
		},
		alertTimer: null,
		timeoutTimer: null,
		initialize: function() {
			this
				.start()
				.setup();
		},
		start: function() {
			var _self = this;
			this.alertTimer = setTimeout(function() {
				_self.onAlert();
			}, this.options.alertOn );
			this.timeoutTimer = setTimeout(function() {
				_self.onTimeout();
			}, this.options.timeoutOn );
			return this;
		},
		setup: function() {
			var _self = this;
			$( document ).ajaxSuccess(function() {
				_self.reset();
			});
			return this;
		},
		reset: function() {
			clearTimeout(this.alertTimer);
			clearTimeout(this.timeoutTimer);
			this.start();
			return this;
		},
		keepAlive: function() {
			if ( !this.options.keepAliveUrl ) {
				this.reset();
				return;
			}
			var _self = this;
			$.post( this.options.keepAliveUrl, function( data ) {
				_self.reset();
			});
		},
		onAlert: function() {
			var renew = confirm( 'Your session is about to expire, do you want to renew?' );
			if ( renew ) {
				this.keepAlive();
			}
		},
		onTimeout: function() {
			self.location.href = 'pages-signin.html';
		}
	};
	$(function() {
		SessionTimeout.initialize();
	});
}).apply(this, [ jQuery ]);
