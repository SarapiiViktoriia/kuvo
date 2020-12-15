(function(win, doc, undefined){
	var docElem			= doc.documentElement,
		proxyURL		= doc.getElementById("respond-proxy").href,
		redirectURL		= (doc.getElementById("respond-redirect") || location).href,
		baseElem		= doc.getElementsByTagName("base")[0],
		urls			= [],
		refNode;
	function encode(url){
		return win.encodeURIComponent(url);
	}
	 function fakejax( url, callback ){
		var iframe,
			AXO;
		if ( "ActiveXObject" in win ) {
			AXO = new ActiveXObject( "htmlfile" );
			AXO.open();
			AXO.write( '<iframe id="x"></iframe>' );
			AXO.close();
			iframe = AXO.getElementById( "x" );
		} else {
			iframe = doc.createElement( "iframe" );
			iframe.style.cssText = "position:absolute;top:-99em";
			docElem.insertBefore(iframe, docElem.firstElementChild || docElem.firstChild );
		}
		iframe.src = checkBaseURL(proxyURL) + "?url=" + encode(redirectURL) + "&css=" + encode(checkBaseURL(url));
		function checkFrameName() {
			var cssText;
			try {
				cssText = iframe.contentWindow.name;
			}
			catch (e) { }
			if (cssText) {
				iframe.src = "about:blank";
				iframe.parentNode.removeChild(iframe);
				iframe = null;
				if (AXO) {
					AXO = null;
					if (win.CollectGarbage) {
						win.CollectGarbage();
					}
				}
				callback(cssText);
			}
			else{
				win.setTimeout(checkFrameName, 100);
			}
		}
		win.setTimeout(checkFrameName, 500);
	}
	function checkBaseURL(href) {
        var el = document.createElement('div'),
        escapedURL = href.split('&').join('&amp;').
            split('<').join('&lt;').
            split('"').join('&quot;');
        el.innerHTML = '<a href="' + escapedURL + '">x</a>';
        return el.firstChild.href;
	}
	function checkRedirectURL() {
		if (~ !redirectURL.indexOf(location.host)) {
			var fakeLink = doc.createElement("div");
			fakeLink.innerHTML = '<a href="' + redirectURL + '"></a>';
			docElem.insertBefore(fakeLink, docElem.firstElementChild || docElem.firstChild );
			redirectURL = fakeLink.firstChild.href;
			fakeLink.parentNode.removeChild(fakeLink);
			fakeLink = null;
		}
	}
	function buildUrls(){
		var links = doc.getElementsByTagName( "link" );
		for( var i = 0, linkl = links.length; i < linkl; i++ ){
			var thislink	= links[i],
				href		= links[i].href,
				extreg		= (/^([a-zA-Z:]*\/\/(www\.)?)/).test( href ),
				ext			= (baseElem && !extreg) || extreg;
			if( thislink.rel.indexOf( "stylesheet" ) >= 0 && ext ){
				(function( link ){			
					fakejax( href, function( css ){
						link.styleSheet.rawCssText = css;
						respond.update();
					} );
				})( thislink );
			}	
		}
	}
	if( !respond.mediaQueriesSupported ){
		checkRedirectURL();
		buildUrls();
	}
})( window, document );
