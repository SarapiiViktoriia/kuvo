if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (searchElement, fromIndex) {
        if ( this === undefined || this === null ) {
            throw new TypeError( '"this" is null or not defined' );
        }
        var length = this.length >>> 0; 
        fromIndex = +fromIndex || 0;
        if (Math.abs(fromIndex) === Infinity) {
            fromIndex = 0;
        }
        if (fromIndex < 0) {
            fromIndex += length;
            if (fromIndex < 0) {
                fromIndex = 0;
            }
        }
        for (;fromIndex < length; fromIndex++) {
            if (this[fromIndex] === searchElement) {
                return fromIndex;
            }
        }
        return -1;
    };
}
(function ($) {
    var defaultOptions = {
        tooltip: false,
        tooltipOpts: {
            content: "%s | X: %x | Y: %y",
            xDateFormat: null,
            yDateFormat: null,
            monthNames: null,
            dayNames: null,
            shifts: {
                x: 10,
                y: 20
            },
            defaultTheme: true,
            onHover: function(flotItem, $tooltipEl) {}
        }
    };
    var FlotTooltip = function(plot) {
        this.tipPosition = {x: 0, y: 0};
        this.init(plot);
    };
    FlotTooltip.prototype.init = function(plot) {
        var that = this;
        var plotPluginsLength = $.plot.plugins.length;
        this.plotPlugins = [];
        if (plotPluginsLength) {
            for (var p = 0; p < plotPluginsLength; p++) {
                this.plotPlugins.push($.plot.plugins[p].name);
            }
        }
        plot.hooks.bindEvents.push(function (plot, eventHolder) {
            that.plotOptions = plot.getOptions();
            if (that.plotOptions.tooltip === false || typeof that.plotOptions.tooltip === 'undefined') return;
            that.tooltipOptions = that.plotOptions.tooltipOpts;
            var $tip = that.getDomElement();
            $( plot.getPlaceholder() ).bind("plothover", plothover);
            $(eventHolder).bind('mousemove', mouseMove);
        });
        plot.hooks.shutdown.push(function (plot, eventHolder){
            $(plot.getPlaceholder()).unbind("plothover", plothover);
            $(eventHolder).unbind("mousemove", mouseMove);
        });
        function mouseMove(e){
            var pos = {};
            pos.x = e.pageX;
            pos.y = e.pageY;
            that.updateTooltipPosition(pos);
        }
        function plothover(event, pos, item) {
            var $tip = that.getDomElement();
            if (item) {
                var tipText;
                tipText = that.stringFormat(that.tooltipOptions.content, item);
                $tip.html( tipText );
                that.updateTooltipPosition({ x: pos.pageX, y: pos.pageY });
                $tip.css({
                        left: that.tipPosition.x + that.tooltipOptions.shifts.x,
                        top: that.tipPosition.y + that.tooltipOptions.shifts.y
                    })
                    .show();
                if(typeof that.tooltipOptions.onHover === 'function') {
                    that.tooltipOptions.onHover(item, $tip);
                }
            }
            else {
                $tip.hide().html('');
            }
        }
    };
    FlotTooltip.prototype.getDomElement = function() {
        var $tip = $('#flotTip');
        if( $tip.length === 0 ){
            $tip = $('<div />').attr('id', 'flotTip');
            $tip.appendTo('body').hide().css({position: 'absolute'});
            if(this.tooltipOptions.defaultTheme) {
                $tip.css({
                    'background': '#fff',
                    'z-index': '1040',
                    'padding': '0.4em 0.6em',
                    'border-radius': '0.5em',
                    'font-size': '0.8em',
                    'border': '1px solid #111',
                    'display': 'none',
                    'white-space': 'nowrap'
                });
            }
        }
        return $tip;
    };
    FlotTooltip.prototype.updateTooltipPosition = function(pos) {
        var $tip = $('#flotTip');
        var totalTipWidth = $tip.outerWidth() + this.tooltipOptions.shifts.x;
        var totalTipHeight = $tip.outerHeight() + this.tooltipOptions.shifts.y;
        if ((pos.x - $(window).scrollLeft()) > ($(window).innerWidth() - totalTipWidth)) {
            pos.x -= totalTipWidth;
        }
        if ((pos.y - $(window).scrollTop()) > ($(window).innerHeight() - totalTipHeight)) {
            pos.y -= totalTipHeight;
        }
        this.tipPosition.x = pos.x;
        this.tipPosition.y = pos.y;
    };
    FlotTooltip.prototype.stringFormat = function(content, item) {
        var percentPattern = /%p\.{0,1}(\d{0,})/;
        var seriesPattern = /%s/;
        var xLabelPattern = /%lx/; 
        var yLabelPattern = /%ly/; 
        var xPattern = /%x\.{0,1}(\d{0,})/;
        var yPattern = /%y\.{0,1}(\d{0,})/;
        var xPatternWithoutPrecision = "%x";
        var yPatternWithoutPrecision = "%y";
        var customTextPattern = "%ct";
        var x, y, customText;
        if (typeof item.series.threshold !== "undefined") {
            x = item.datapoint[0];
            y = item.datapoint[1];
            customText = item.datapoint[2];
        } else if (typeof item.series.lines !== "undefined" && item.series.lines.steps) {
            x = item.series.datapoints.points[item.dataIndex * 2];
            y = item.series.datapoints.points[item.dataIndex * 2 + 1];
            customText = "";
        } else {
            x = item.series.data[item.dataIndex][0];
            y = item.series.data[item.dataIndex][1];
            customText = item.series.data[item.dataIndex][2];
        }
        if (item.series.label === null && item.series.originSeries) {
            item.series.label = item.series.originSeries.label;
        }
        if( typeof(content) === 'function' ) {
            content = content(item.series.label, x, y, item);
        }
        if( typeof (item.series.percent) !== 'undefined' ) {
            content = this.adjustValPrecision(percentPattern, content, item.series.percent);
        }
        if( typeof(item.series.label) !== 'undefined' ) {
            content = content.replace(seriesPattern, item.series.label);
        }
        else {
            content = content.replace(seriesPattern, "");
        }
        if( this.hasAxisLabel('xaxis', item) ) {
            content = content.replace(xLabelPattern, item.series.xaxis.options.axisLabel);
        }
        else {
            content = content.replace(xLabelPattern, "");
        }
        if( this.hasAxisLabel('yaxis', item) ) {
            content = content.replace(yLabelPattern, item.series.yaxis.options.axisLabel);
        }
        else {
            content = content.replace(yLabelPattern, "");
        }
        if(this.isTimeMode('xaxis', item) && this.isXDateFormat(item)) {
            content = content.replace(xPattern, this.timestampToDate(x, this.tooltipOptions.xDateFormat, item.series.xaxis.options));
        }
        if(this.isTimeMode('yaxis', item) && this.isYDateFormat(item)) {
            content = content.replace(yPattern, this.timestampToDate(y, this.tooltipOptions.yDateFormat, item.series.yaxis.options));
        }
        if(typeof x === 'number') {
            content = this.adjustValPrecision(xPattern, content, x);
        }
        if(typeof y === 'number') {
            content = this.adjustValPrecision(yPattern, content, y);
        }
        if(typeof item.series.xaxis.ticks !== 'undefined') {
            var ticks;
            if(this.hasRotatedXAxisTicks(item)) {
                ticks = 'rotatedTicks';
            }
            else {
                ticks = 'ticks';
            }
            var tickIndex = item.dataIndex + item.seriesIndex;
            if(item.series.xaxis[ticks].length > tickIndex && !this.isTimeMode('xaxis', item)) {
                var valueX = (this.isCategoriesMode('xaxis', item)) ? item.series.xaxis[ticks][tickIndex].label : item.series.xaxis[ticks][tickIndex].v;
                if (valueX === x) {
                    content = content.replace(xPattern, item.series.xaxis[ticks][tickIndex].label);
                }
            }
        }
        if(typeof item.series.yaxis.ticks !== 'undefined') {
            for (var index in item.series.yaxis.ticks) {
                if (item.series.yaxis.ticks.hasOwnProperty(index)) {
                    var valueY = (this.isCategoriesMode('yaxis', item)) ? item.series.yaxis.ticks[index].label : item.series.yaxis.ticks[index].v;
                    if (valueY === y) {
                        content = content.replace(yPattern, item.series.yaxis.ticks[index].label);
                    }
                }
            }
        }
        if(typeof item.series.xaxis.tickFormatter !== 'undefined') {
            content = content.replace(xPatternWithoutPrecision, item.series.xaxis.tickFormatter(x, item.series.xaxis).replace(/\$/g, '$$'));
        }
        if(typeof item.series.yaxis.tickFormatter !== 'undefined') {
            content = content.replace(yPatternWithoutPrecision, item.series.yaxis.tickFormatter(y, item.series.yaxis).replace(/\$/g, '$$'));
        }
        if(customText) {
            content = content.replace(customTextPattern, customText);
        }
        return content;
    };
    FlotTooltip.prototype.isTimeMode = function(axisName, item) {
        return (typeof item.series[axisName].options.mode !== 'undefined' && item.series[axisName].options.mode === 'time');
    };
    FlotTooltip.prototype.isXDateFormat = function(item) {
        return (typeof this.tooltipOptions.xDateFormat !== 'undefined' && this.tooltipOptions.xDateFormat !== null);
    };
    FlotTooltip.prototype.isYDateFormat = function(item) {
        return (typeof this.tooltipOptions.yDateFormat !== 'undefined' && this.tooltipOptions.yDateFormat !== null);
    };
    FlotTooltip.prototype.isCategoriesMode = function(axisName, item) {
        return (typeof item.series[axisName].options.mode !== 'undefined' && item.series[axisName].options.mode === 'categories');
    };
    FlotTooltip.prototype.timestampToDate = function(tmst, dateFormat, options) {
        var theDate = $.plot.dateGenerator(tmst, options);
        return $.plot.formatDate(theDate, dateFormat, this.tooltipOptions.monthNames, this.tooltipOptions.dayNames);
    };
    FlotTooltip.prototype.adjustValPrecision = function(pattern, content, value) {
        var precision;
        var matchResult = content.match(pattern);
        if( matchResult !== null ) {
            if(RegExp.$1 !== '') {
                precision = RegExp.$1;
                value = value.toFixed(precision);
                content = content.replace(pattern, value);
            }
        }
        return content;
    };
    FlotTooltip.prototype.hasAxisLabel = function(axisName, item) {
        return (this.plotPlugins.indexOf('axisLabels') !== -1 && typeof item.series[axisName].options.axisLabel !== 'undefined' && item.series[axisName].options.axisLabel.length > 0);
    };
    FlotTooltip.prototype.hasRotatedXAxisTicks = function(item) {
        return ($.grep($.plot.plugins, function(p){ return p.name === "tickRotor"; }).length === 1 && typeof item.series.xaxis.rotatedTicks !== 'undefined');
    };
    var init = function(plot) {
      new FlotTooltip(plot);
    };
    $.plot.plugins.push({
        init: init,
        options: defaultOptions,
        name: 'tooltip',
        version: '0.6.7'
    });
})(jQuery);
