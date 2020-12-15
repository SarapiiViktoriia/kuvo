(function ($) {
    'use strict';
    $.fn.extend({
        maxlength: function (options, callback) {
            var documentBody = $('body'),
                defaults = {
                    alwaysShow: false, 
                    threshold: 10, 
                    warningClass: 'label label-success',
                    limitReachedClass: 'label label-important',
                    separator: ' / ',
                    preText: '',
                    postText: '',
                    showMaxLength : true,
                    placement: 'bottom',
                    showCharsTyped: true, 
                    validate: false, 
                    utf8: false 
                };
            if ($.isFunction(options) && !callback) {
                callback = options;
                options = {};
            }
            options = $.extend(defaults, options);
            function inputLength(input) {
              var text = input.val();
              text = text.replace(new RegExp('\r?\n','g'), '\n');
              var currentLength = 0;
              if (options.utf8) {
                currentLength = utf8Length(input.val());
              } else {
                currentLength = input.val().length;
              }
              return currentLength;
            }
            function utf8Length(string) {
              var utf8length = 0;
              for (var n = 0; n < string.length; n++) {
                var c = string.charCodeAt(n);
                if (c < 128) {
                  utf8length++;
                }
                else if((c > 127) && (c < 2048)) {
                  utf8length = utf8length+2;
                }
                else {
                  utf8length = utf8length+3;
                }
              }
              return utf8length;
            }
            function charsLeftThreshold(input, thereshold, maxlength) {
                var output = true;
                if (!options.alwaysShow && (maxlength - inputLength(input) > thereshold)) {
                    output = false;
                }
                return output;
            }
            function remainingChars(input, maxlength) {
                var length = maxlength - inputLength(input);
                return length;
            }
            function showRemaining(indicator) {
                indicator.css({
                    display: 'block'
                });
            }
            function hideRemaining(indicator) {
                indicator.css({
                    display: 'none'
                });
            }
            function updateMaxLengthHTML(maxLengthThisInput, typedChars) {
                var output = '';
                if (options.message){
                    output = options.message.replace('%charsTyped%', typedChars)
                            .replace('%charsRemaining%', maxLengthThisInput - typedChars)
                            .replace('%charsTotal%', maxLengthThisInput);
                } else {
                    if (options.preText) {
                        output += options.preText;
                    }
                    if (!options.showCharsTyped) {
                        output += maxLengthThisInput - typedChars;
                    }
                    else {
                        output += typedChars;
                    }
                    if (options.showMaxLength) {
                       output += options.separator + maxLengthThisInput;
                    }
                    if (options.postText) {
                        output += options.postText;
                    }
                }
                return output;
            }
            function manageRemainingVisibility(remaining, currentInput, maxLengthCurrentInput, maxLengthIndicator) {
                maxLengthIndicator.html(updateMaxLengthHTML(maxLengthCurrentInput, (maxLengthCurrentInput - remaining)));
                if (remaining > 0) {
                    if (charsLeftThreshold(currentInput, options.threshold, maxLengthCurrentInput)) {
                        showRemaining(maxLengthIndicator.removeClass(options.limitReachedClass).addClass(options.warningClass));
                    } else {
                        hideRemaining(maxLengthIndicator);
                    }
                } else {
                    showRemaining(maxLengthIndicator.removeClass(options.warningClass).addClass(options.limitReachedClass));
                }
            }
            function getPosition(currentInput) {
                var el = currentInput[0];
                return $.extend({}, (typeof el.getBoundingClientRect === 'function') ? el.getBoundingClientRect() : {
                    width: el.offsetWidth,
                    height: el.offsetHeight
                }, currentInput.offset());
            }
            function place(currentInput, maxLengthIndicator) {
                var pos = getPosition(currentInput),
                    inputOuter = currentInput.outerWidth(),
                    outerWidth = maxLengthIndicator.outerWidth(),
                    actualWidth = maxLengthIndicator.width(),
                    actualHeight = maxLengthIndicator.height();
                switch (options.placement) {
                case 'bottom':
                    maxLengthIndicator.css({top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2});
                    break;
                case 'top':
                    maxLengthIndicator.css({top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2});
                    break;
                case 'left':
                    maxLengthIndicator.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth});
                    break;
                case 'right':
                    maxLengthIndicator.css({top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width});
                    break;
                case 'bottom-right':
                    maxLengthIndicator.css({top: pos.top + pos.height, left: pos.left + pos.width});
                    break;
                case 'top-right':
                    maxLengthIndicator.css({top: pos.top - actualHeight, left: pos.left + inputOuter});
                    break;
                case 'top-left':
                    maxLengthIndicator.css({top: pos.top - actualHeight, left: pos.left - outerWidth});
                    break;
                case 'bottom-left':
                    maxLengthIndicator.css({top: pos.top + currentInput.outerHeight(), left: pos.left - outerWidth});
                    break;
                case 'centered-right':
                    maxLengthIndicator.css({top: pos.top + (actualHeight / 2), left: pos.left + inputOuter - outerWidth - 3});
                    break;
                }
            }
            function getMaxLength(currentInput) {
                return currentInput.attr('maxlength') || currentInput.attr('size');
            }
            return this.each(function() {
              var currentInput = $(this),
                  maxLengthCurrentInput,
                  maxLengthIndicator;
              $(window).resize(function() {
                if(maxLengthIndicator) {
                  place(currentInput, maxLengthIndicator);
                }
              });
              currentInput.focus(function () {
                var maxlengthContent = updateMaxLengthHTML(maxLengthCurrentInput, '0');
                  maxLengthCurrentInput = getMaxLength(currentInput);
                  if (!maxLengthIndicator) {
                    maxLengthIndicator = $('<span class="bootstrap-maxlength"></span>').css({
                      display: 'none',
                      position: 'absolute',
                      whiteSpace: 'nowrap',
                      zIndex: 1099
                    }).html(maxlengthContent);
                  }
                if (currentInput.is('textarea')) {
                    currentInput.data('maxlenghtsizex', currentInput.outerWidth());
                    currentInput.data('maxlenghtsizey', currentInput.outerHeight());
                    currentInput.mouseup(function() {
                        if (currentInput.outerWidth() !== currentInput.data('maxlenghtsizex') || currentInput.outerHeight() !== currentInput.data('maxlenghtsizey')) {
                            place(currentInput, maxLengthIndicator);
                        }
                        currentInput.data('maxlenghtsizex', currentInput.outerWidth());
                        currentInput.data('maxlenghtsizey', currentInput.outerHeight());
                    });
                }
                documentBody.append(maxLengthIndicator);
                var remaining = remainingChars(currentInput, getMaxLength(currentInput));
                    manageRemainingVisibility(remaining, currentInput, maxLengthCurrentInput, maxLengthIndicator);
                    place(currentInput, maxLengthIndicator);
              });
                currentInput.blur(function() {
                    maxLengthIndicator.remove();
                });
                currentInput.keyup(function() {
                    var remaining = remainingChars(currentInput, getMaxLength(currentInput)),
                        output = true;
                    if (options.validate && remaining < 0) {
                        output = false;
                    } else {
                        manageRemainingVisibility(remaining, currentInput, maxLengthCurrentInput, maxLengthIndicator);
                    }
                    return output;
                });
            });
        }
    });
}(jQuery));
