(function ($) {
	var
	defaults = {
		className: 'autosizejs',
		id: 'autosizejs',
		append: '',
		callback: false,
		resizeDelay: 10,
		placeholder: true
	},
	copy = '<textarea tabindex="-1" style="position:absolute; top:-999px; left:0; right:auto; bottom:auto; border:0; padding: 0; -moz-box-sizing:content-box; -webkit-box-sizing:content-box; box-sizing:content-box; word-wrap:break-word; height:0 !important; min-height:0 !important; overflow:hidden; transition:none; -webkit-transition:none; -moz-transition:none;"/>',
	typographyStyles = [
		'fontFamily',
		'fontSize',
		'fontWeight',
		'fontStyle',
		'letterSpacing',
		'textTransform',
		'wordSpacing',
		'textIndent'
	],
	mirrored,
	mirror = $(copy).data('autosize', true)[0];
	mirror.style.lineHeight = '99px';
	if ($(mirror).css('lineHeight') === '99px') {
		typographyStyles.push('lineHeight');
	}
	mirror.style.lineHeight = '';
	$.fn.autosize = function (options) {
		if (!this.length) {
			return this;
		}
		options = $.extend({}, defaults, options || {});
		if (mirror.parentNode !== document.body) {
			$(document.body).append(mirror);
		}
		return this.each(function () {
			var
			ta = this,
			$ta = $(ta),
			maxHeight,
			minHeight,
			boxOffset = 0,
			callback = $.isFunction(options.callback),
			originalStyles = {
				height: ta.style.height,
				overflow: ta.style.overflow,
				overflowY: ta.style.overflowY,
				wordWrap: ta.style.wordWrap,
				resize: ta.style.resize
			},
			timeout,
			width = $ta.width();
			if ($ta.data('autosize')) {
				return;
			}
			$ta.data('autosize', true);
			if ($ta.css('box-sizing') === 'border-box' || $ta.css('-moz-box-sizing') === 'border-box' || $ta.css('-webkit-box-sizing') === 'border-box'){
				boxOffset = $ta.outerHeight() - $ta.height();
			}
			minHeight = Math.max(parseInt($ta.css('minHeight'), 10) - boxOffset || 0, $ta.height());
			$ta.css({
				overflow: 'hidden',
				overflowY: 'hidden',
				wordWrap: 'break-word', 
				resize: ($ta.css('resize') === 'none' || $ta.css('resize') === 'vertical') ? 'none' : 'horizontal'
			});
			function setWidth() {
				var width;
				var style = window.getComputedStyle ? window.getComputedStyle(ta, null) : false;
				if (style) {
					width = ta.getBoundingClientRect().width;
					if (width === 0) {
						width = parseInt(style.width,10);
					}
					$.each(['paddingLeft', 'paddingRight', 'borderLeftWidth', 'borderRightWidth'], function(i,val){
						width -= parseInt(style[val],10);
					});
				} else {
					width = Math.max($ta.width(), 0);
				}
				mirror.style.width = width + 'px';
			}
			function initMirror() {
				var styles = {};
				mirrored = ta;
				mirror.className = options.className;
				mirror.id = options.id;
				maxHeight = parseInt($ta.css('maxHeight'), 10);
				$.each(typographyStyles, function(i,val){
					styles[val] = $ta.css(val);
				});
				$(mirror).css(styles).attr('wrap', $ta.attr('wrap'));
				setWidth();
				if (window.chrome) {
					var width = ta.style.width;
					ta.style.width = '0px';
					var ignore = ta.offsetWidth;
					ta.style.width = width;
				}
			}
			function adjust() {
				var height, original;
				if (mirrored !== ta) {
					initMirror();
				} else {
					setWidth();
				}
				if (!ta.value && options.placeholder) {
					mirror.value = ($ta.attr("placeholder") || '') + options.append;
				} else {
					mirror.value = ta.value + options.append;
				}
				mirror.style.overflowY = ta.style.overflowY;
				original = parseInt(ta.style.height,10);
				mirror.scrollTop = 0;
				mirror.scrollTop = 9e4;
				height = mirror.scrollTop;
				if (maxHeight && height > maxHeight) {
					ta.style.overflowY = 'scroll';
					height = maxHeight;
				} else {
					ta.style.overflowY = 'hidden';
					if (height < minHeight) {
						height = minHeight;
					}
				}
				height += boxOffset;
				if (original !== height) {
					ta.style.height = height + 'px';
					if (callback) {
						options.callback.call(ta,ta);
					}
				}
			}
			function resize () {
				clearTimeout(timeout);
				timeout = setTimeout(function(){
					var newWidth = $ta.width();
					if (newWidth !== width) {
						width = newWidth;
						adjust();
					}
				}, parseInt(options.resizeDelay,10));
			}
			if ('onpropertychange' in ta) {
				if ('oninput' in ta) {
					$ta.on('input.autosize keyup.autosize', adjust);
				} else {
					$ta.on('propertychange.autosize', function(){
						if(event.propertyName === 'value'){
							adjust();
						}
					});
				}
			} else {
				$ta.on('input.autosize', adjust);
			}
			if (options.resizeDelay !== false) {
				$(window).on('resize.autosize', resize);
			}
			$ta.on('autosize.resize', adjust);
			$ta.on('autosize.resizeIncludeStyle', function() {
				mirrored = null;
				adjust();
			});
			$ta.on('autosize.destroy', function(){
				mirrored = null;
				clearTimeout(timeout);
				$(window).off('resize', resize);
				$ta
					.off('autosize')
					.off('.autosize')
					.css(originalStyles)
					.removeData('autosize');
			});
			adjust();
		});
	};
}(window.jQuery || window.$)); 
