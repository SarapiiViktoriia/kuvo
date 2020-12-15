(function($) {
    $.fn.matchHeight = function(byRow) {
        if (byRow === 'remove') {
            var that = this;
            this.css('height', '');
            $.each($.fn.matchHeight._groups, function(key, group) {
                group.elements = group.elements.not(that);
            });
            return this;
        }
        if (this.length <= 1)
            return this;
        byRow = (typeof byRow !== 'undefined') ? byRow : true;
        $.fn.matchHeight._groups.push({
            elements: this,
            byRow: byRow
        });
        $.fn.matchHeight._apply(this, byRow);
        return this;
    };
    $.fn.matchHeight._apply = function(elements, byRow) {
        var $elements = $(elements),
            rows = [$elements];
        if (byRow) {
            $elements.css({
                'display': 'block',
                'padding-top': '0',
                'padding-bottom': '0',
                'border-top-width': '0',
                'border-bottom-width': '0',
                'height': '100px'
            });
            rows = _rows($elements);
            $elements.css({
                'display': '',
                'padding-top': '',
                'padding-bottom': '',
                'border-top-width': '',
                'border-bottom-width': '',
                'height': ''
            });
        }
        $.each(rows, function(key, row) {
            var $row = $(row),
                maxHeight = 0;
            var hiddenParents = $row.parents().add($row).filter(':hidden');
            hiddenParents.css({ 'display': 'block' });
            $row.each(function(){
                var $that = $(this);
                $that.css({ 'display': 'block', 'height': '' });
                if ($that.outerHeight(false) > maxHeight)
                    maxHeight = $that.outerHeight(false);
                $that.css({ 'display': '' });
            });
            hiddenParents.css({ 'display': '' });
            $row.each(function(){
                var $that = $(this),
                    verticalPadding = 0;
                if ($that.css('box-sizing') !== 'border-box') {
                    verticalPadding += _parse($that.css('border-top-width')) + _parse($that.css('border-bottom-width'));
                    verticalPadding += _parse($that.css('padding-top')) + _parse($that.css('padding-bottom'));
                }
                $that.css('height', maxHeight - verticalPadding);
            });
        });
        return this;
    };
    $.fn.matchHeight._applyDataApi = function() {
        var groups = {};
        $('[data-match-height], [data-mh]').each(function() {
            var $this = $(this),
                groupId = $this.attr('data-match-height');
            if (groupId in groups) {
                groups[groupId] = groups[groupId].add($this);
            } else {
                groups[groupId] = $this;
            }
        });
        $.each(groups, function() {
            this.matchHeight(true);
        });
    };
    $.fn.matchHeight._groups = [];
    $.fn.matchHeight._throttle = 80;
    var previousResizeWidth = -1,
        updateTimeout = -1;
    $.fn.matchHeight._update = function(event) {
        if (event && event.type === 'resize') {
            var windowWidth = $(window).width();
            if (windowWidth === previousResizeWidth)
                return;
            previousResizeWidth = windowWidth;
        }
        if (updateTimeout === -1) {
            updateTimeout = setTimeout(function() {
                $.each($.fn.matchHeight._groups, function() {
                    $.fn.matchHeight._apply(this.elements, this.byRow);
                });
                updateTimeout = -1;
            }, $.fn.matchHeight._throttle);
        }
    };
    $($.fn.matchHeight._applyDataApi);
    $(window).bind('load resize orientationchange', $.fn.matchHeight._update);
    var _rows = function(elements) {
        var tolerance = 1,
            $elements = $(elements),
            lastTop = null,
            rows = [];
        $elements.each(function(){
            var $that = $(this),
                top = $that.offset().top - _parse($that.css('margin-top')),
                lastRow = rows.length > 0 ? rows[rows.length - 1] : null;
            if (lastRow === null) {
                rows.push($that);
            } else {
                if (Math.floor(Math.abs(lastTop - top)) <= tolerance) {
                    rows[rows.length - 1] = lastRow.add($that);
                } else {
                    rows.push($that);
                }
            }
            lastTop = top;
        });
        return rows;
    };
    var _parse = function(value) {
        return parseFloat(value) || 0;
    };
})(jQuery);
