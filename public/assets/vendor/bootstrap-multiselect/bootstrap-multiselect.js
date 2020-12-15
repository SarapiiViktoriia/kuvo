!function($) {
    "use strict";
    if (typeof ko !== 'undefined' && ko.bindingHandlers && !ko.bindingHandlers.multiselect) {
        ko.bindingHandlers.multiselect = {
            init: function (element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
                var listOfSelectedItems = allBindingsAccessor().selectedOptions,
                    config = ko.utils.unwrapObservable(valueAccessor());
                $(element).multiselect(config);
                if (isObservableArray(listOfSelectedItems)) {
                    listOfSelectedItems.subscribe(function (changes) {
                        var addedArray = [], deletedArray = [];
                        changes.forEach(function (change) {
                            switch (change.status) {
                                case 'added':
                                    addedArray.push(change.value);
                                    break;
                                case 'deleted':
                                    deletedArray.push(change.value);
                                    break;
                            }
                        });
                        if (addedArray.length > 0) {
                            $(element).multiselect('select', addedArray);
                        };
                        if (deletedArray.length > 0) {
                            $(element).multiselect('deselect', deletedArray);
                        };
                    }, null, "arrayChange");
                }
            },
            update: function (element, valueAccessor, allBindingsAccessor, viewModel, bindingContext) {
                var listOfItems = allBindingsAccessor().options,
                    ms = $(element).data('multiselect'),
                    config = ko.utils.unwrapObservable(valueAccessor());
                if (isObservableArray(listOfItems)) {
                    listOfItems.subscribe(function (theArray) {
                        $(element).multiselect('rebuild');
                    });
                }
                if (!ms) {
                    $(element).multiselect(config);
                }
                else {
                    ms.updateOriginalOptions();
                }
            }
        };
    }
    function isObservableArray(obj) {
        return ko.isObservable(obj) && !(obj.destroyAll === undefined);
    }
    function Multiselect(select, options) {
        this.options = this.mergeOptions(options);
        this.$select = $(select);
        this.originalOptions = this.$select.clone()[0].options;
        this.query = '';
        this.searchTimeout = null;
        this.options.multiple = this.$select.attr('multiple') === "multiple";
        this.options.onChange = $.proxy(this.options.onChange, this);
        this.options.onDropdownShow = $.proxy(this.options.onDropdownShow, this);
        this.options.onDropdownHide = $.proxy(this.options.onDropdownHide, this);
        this.buildContainer();
        this.buildButton();
        this.buildSelectAll();
        this.buildDropdown();
        this.buildDropdownOptions();
        this.buildFilter();
        this.updateButtonText();
        this.updateSelectAll();
        this.$select.hide().after(this.$container);
    };
    Multiselect.prototype = {
        defaults: {
            buttonText: function(options, select) {
                if (options.length === 0) {
                    return this.nonSelectedText + ' <b class="caret"></b>';
                }
                else {
                    if (options.length > this.numberDisplayed) {
                        return options.length + ' ' + this.nSelectedText + ' <b class="caret"></b>';
                    }
                    else {
                        var selected = '';
                        options.each(function() {
                            var label = ($(this).attr('label') !== undefined) ? $(this).attr('label') : $(this).html();
                            selected += label + ', ';
                        });
                        return selected.substr(0, selected.length - 2) + ' <b class="caret"></b>';
                    }
                }
            },
            buttonTitle: function(options, select) {
                if (options.length === 0) {
                    return this.nonSelectedText;
                }
                else {
                    var selected = '';
                    options.each(function () {
                        selected += $(this).text() + ', ';
                    });
                    return selected.substr(0, selected.length - 2);
                }
            },
            label: function(element){
                return $(element).attr('label') || $(element).html();
            },
            onChange : function(option, checked) {
            },
            onDropdownShow: function(event) {
            },
            onDropdownHide: function(event) {
            },
            buttonClass: 'btn btn-default',
            dropRight: false,
            selectedClass: 'active',
            buttonWidth: 'auto',
            buttonContainer: '<div class="btn-group" />',
            maxHeight: false,
            checkboxName: 'multiselect',
            includeSelectAllOption: false,
            includeSelectAllIfMoreThan: 0,
            selectAllText: ' Select all',
            selectAllValue: 'multiselect-all',
            enableFiltering: false,
            enableCaseInsensitiveFiltering: false,
            filterPlaceholder: 'Search',
            filterBehavior: 'text',
            preventInputChangeEvent: false,
            nonSelectedText: 'None selected',
            nSelectedText: 'selected',
            numberDisplayed: 3,
            templates: {
                button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"></button>',
                ul: '<ul class="multiselect-container dropdown-menu"></ul>',
                filter: '<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input class="form-control multiselect-search" type="text"></div>',
                li: '<li><a href="javascript:void(0);"><label></label></a></li>',
                divider: '<li class="divider"></li>',
                liGroup: '<li><label class="multiselect-group"></label></li>'
            }
        },
        constructor: Multiselect,
        buildContainer: function() {
            this.$container = $(this.options.buttonContainer);
            this.$container.on('show.bs.dropdown', this.options.onDropdownShow);
            this.$container.on('hide.bs.dropdown', this.options.onDropdownHide);
        },
        buildButton: function() {
            this.$button = $(this.options.templates.button).addClass(this.options.buttonClass);
            if (this.$select.prop('disabled')) {
                this.disable();
            }
            else {
                this.enable();
            }
            if (this.options.buttonWidth && this.options.buttonWidth !== 'auto') {
                this.$button.css({
                    'width' : this.options.buttonWidth
                });
            }
            var tabindex = this.$select.attr('tabindex');
            if (tabindex) {
                this.$button.attr('tabindex', tabindex);
            }
            this.$container.prepend(this.$button);
        },
        buildDropdown: function() {
            this.$ul = $(this.options.templates.ul);
            if (this.options.dropRight) {
                this.$ul.addClass('pull-right');
            }
            if (this.options.maxHeight) {
                this.$ul.css({
                    'max-height': this.options.maxHeight + 'px',
                    'overflow-y': 'auto',
                    'overflow-x': 'hidden'
                });
            }
            this.$container.append(this.$ul);
        },
        buildDropdownOptions: function() {
            this.$select.children().each($.proxy(function(index, element) {
                var tag = $(element).prop('tagName')
                    .toLowerCase();
                if (tag === 'optgroup') {
                    this.createOptgroup(element);
                }
                else if (tag === 'option') {
                    if ($(element).data('role') === 'divider') {
                        this.createDivider();
                    }
                    else {
                        this.createOptionValue(element);
                    }
                }
            }, this));
            $('li input', this.$ul).on('change', $.proxy(function(event) {
                var $target = $(event.target);
                var checked = $target.prop('checked') || false;
                var isSelectAllOption = $target.val() === this.options.selectAllValue;
                if (this.options.selectedClass) {
                    if (checked) {
                        $target.parents('li')
                            .addClass(this.options.selectedClass);
                    }
                    else {
                        $target.parents('li')
                            .removeClass(this.options.selectedClass);
                    }
                }
                var value = $target.val();
                var $option = this.getOptionByValue(value);
                var $optionsNotThis = $('option', this.$select).not($option);
                var $checkboxesNotThis = $('input', this.$container).not($target);
                if (isSelectAllOption) {
                    var values = [];
                    var availableInputs = $('li input[value!="' + this.options.selectAllValue + '"][data-role!="divider"]', this.$ul).filter(':visible');
                    for (var i = 0, j = availableInputs.length; i < j; i++) {
                        values.push(availableInputs[i].value);
                    }
                    if (checked) {
                        this.select(values);
                    }
                    else {
                        this.deselect(values);
                    }
                }
                if (checked) {
                    $option.prop('selected', true);
                    if (this.options.multiple) {
                        $option.prop('selected', true);
                    }
                    else {
                        if (this.options.selectedClass) {
                            $($checkboxesNotThis).parents('li').removeClass(this.options.selectedClass);
                        }
                        $($checkboxesNotThis).prop('checked', false);
                        $optionsNotThis.prop('selected', false);
                        this.$button.click();
                    }
                    if (this.options.selectedClass === "active") {
                        $optionsNotThis.parents("a").css("outline", "");
                    }
                }
                else {
                    $option.prop('selected', false);
                }
                this.$select.change();
                this.options.onChange($option, checked);
                this.updateButtonText();
                this.updateSelectAll();
                if(this.options.preventInputChangeEvent) {
                    return false;
                }
            }, this));
            $('li a', this.$ul).on('touchstart click', function(event) {
                event.stopPropagation();
                var $target = $(event.target);
                if (event.shiftKey) {
                    var checked = $target.prop('checked') || false;
                    if (checked) {
                        var prev = $target.parents('li:last')
                            .siblings('li[class="active"]:first');
                        var currentIdx = $target.parents('li')
                            .index();
                        var prevIdx = prev.index();
                        if (currentIdx > prevIdx) {
                            $target.parents("li:last").prevUntil(prev).each(
                                function() {
                                    $(this).find("input:first").prop("checked", true)
                                        .trigger("change");
                                }
                            );
                        }
                        else {
                            $target.parents("li:last").nextUntil(prev).each(
                                function() {
                                    $(this).find("input:first").prop("checked", true)
                                        .trigger("change");
                                }
                            );
                        }
                    }
                }
                $target.blur();
            });
            this.$container.on('keydown', $.proxy(function(event) {
                if ($('input[type="text"]', this.$container).is(':focus')) {
                    return;
                }
                if ((event.keyCode === 9 || event.keyCode === 27)
                        && this.$container.hasClass('open')) {
                    this.$button.click();
                }
                else {
                    var $items = $(this.$container).find("li:not(.divider):visible a");
                    if (!$items.length) {
                        return;
                    }
                    var index = $items.index($items.filter(':focus'));
                    if (event.keyCode === 38 && index > 0) {
                        index--;
                    }
                    else if (event.keyCode === 40 && index < $items.length - 1) {
                        index++;
                    }
                    else if (!~index) {
                        index = 0;
                    }
                    var $current = $items.eq(index);
                    $current.focus();
                    if (event.keyCode === 32 || event.keyCode === 13) {
                        var $checkbox = $current.find('input');
                        $checkbox.prop("checked", !$checkbox.prop("checked"));
                        $checkbox.change();
                    }
                    event.stopPropagation();
                    event.preventDefault();
                }
            }, this));
        },
        createOptionValue: function(element) {
            if ($(element).is(':selected')) {
                $(element).prop('selected', true);
            }
            var label = this.options.label(element);
            var value = $(element).val();
            var inputType = this.options.multiple ? "checkbox" : "radio";
            var $li = $(this.options.templates.li);
            $('label', $li).addClass(inputType);
            $('label', $li).append('<input type="' + inputType + '" name="' + this.options.checkboxName + '" />');
            var selected = $(element).prop('selected') || false;
            var $checkbox = $('input', $li);
            $checkbox.val(value);
            if (value === this.options.selectAllValue) {
                $checkbox.parent().parent()
                    .addClass('multiselect-all');
            }
            $('label', $li).append(" " + label);
            this.$ul.append($li);
            if ($(element).is(':disabled')) {
                $checkbox.attr('disabled', 'disabled')
                    .prop('disabled', true)
                    .parents('li')
                    .addClass('disabled');
            }
            $checkbox.prop('checked', selected);
            if (selected && this.options.selectedClass) {
                $checkbox.parents('li')
                    .addClass(this.options.selectedClass);
            }
        },
        createDivider: function(element) {
            var $divider = $(this.options.templates.divider);
            this.$ul.append($divider);
        },
        createOptgroup: function(group) {
            var groupName = $(group).prop('label');
            var $li = $(this.options.templates.liGroup);
            $('label', $li).text(groupName);
            this.$ul.append($li);
            if ($(group).is(':disabled')) {
                $li.addClass('disabled');
            }
            $('option', group).each($.proxy(function(index, element) {
                this.createOptionValue(element);
            }, this));
        },
        buildSelectAll: function() {
            var alreadyHasSelectAll = this.hasSelectAll();
            if (!alreadyHasSelectAll && this.options.includeSelectAllOption && this.options.multiple
                    && $('option[data-role!="divider"]', this.$select).length > this.options.includeSelectAllIfMoreThan) {
                if (this.options.includeSelectAllDivider) {
                    this.$select.prepend('<option value="" disabled="disabled" data-role="divider">');
                }
                this.$select.prepend('<option value="' + this.options.selectAllValue + '">' + this.options.selectAllText + '</option>');
            }
        },
        buildFilter: function() {
            if (this.options.enableFiltering || this.options.enableCaseInsensitiveFiltering) {
                var enableFilterLength = Math.max(this.options.enableFiltering, this.options.enableCaseInsensitiveFiltering);
                if (this.$select.find('option').length >= enableFilterLength) {
                    this.$filter = $(this.options.templates.filter);
                    $('input', this.$filter).attr('placeholder', this.options.filterPlaceholder);
                    this.$ul.prepend(this.$filter);
                    this.$filter.val(this.query).on('click', function(event) {
                        event.stopPropagation();
                    }).on('input keydown', $.proxy(function(event) {
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = this.asyncFunction($.proxy(function() {
                            if (this.query !== event.target.value) {
                                this.query = event.target.value;
                                $.each($('li', this.$ul), $.proxy(function(index, element) {
                                    var value = $('input', element).val();
                                    var text = $('label', element).text();
                                    var filterCandidate = '';
                                    if ((this.options.filterBehavior === 'text')) {
                                        filterCandidate = text;
                                    }
                                    else if ((this.options.filterBehavior === 'value')) {
                                        filterCandidate = value;
                                    }
                                    else if (this.options.filterBehavior === 'both') {
                                        filterCandidate = text + '\n' + value;
                                    }
                                    if (value !== this.options.selectAllValue && text) {
                                        var showElement = false;
                                        if (this.options.enableCaseInsensitiveFiltering && filterCandidate.toLowerCase().indexOf(this.query.toLowerCase()) > -1) {
                                            showElement = true;
                                        }
                                        else if (filterCandidate.indexOf(this.query) > -1) {
                                            showElement = true;
                                        }
                                        if (showElement) {
                                            $(element).show();
                                        }
                                        else {
                                            $(element).hide();
                                        }
                                    }
                                }, this));
                            }
                        }, this), 300, this);
                    }, this));
                }
            }
        },
        destroy: function() {
            this.$container.remove();
            this.$select.show();
            this.$select.data('multiselect', null);
        },
        refresh: function() {
            $('option', this.$select).each($.proxy(function(index, element) {
                var $input = $('li input', this.$ul).filter(function() {
                    return $(this).val() === $(element).val();
                });
                if ($(element).is(':selected')) {
                    $input.prop('checked', true);
                    if (this.options.selectedClass) {
                        $input.parents('li')
                            .addClass(this.options.selectedClass);
                    }
                }
                else {
                    $input.prop('checked', false);
                    if (this.options.selectedClass) {
                        $input.parents('li')
                            .removeClass(this.options.selectedClass);
                    }
                }
                if ($(element).is(":disabled")) {
                    $input.attr('disabled', 'disabled')
                        .prop('disabled', true)
                        .parents('li')
                        .addClass('disabled');
                }
                else {
                    $input.prop('disabled', false)
                        .parents('li')
                        .removeClass('disabled');
                }
            }, this));
            this.updateButtonText();
            this.updateSelectAll();
        },
        select: function(selectValues) {
            if(!$.isArray(selectValues)) {
                selectValues = [selectValues];
            }
            for (var i = 0; i < selectValues.length; i++) {
                var value = selectValues[i];
                var $option = this.getOptionByValue(value);
                var $checkbox = this.getInputByValue(value);
                if (this.options.selectedClass) {
                    $checkbox.parents('li')
                        .addClass(this.options.selectedClass);
                }
                $checkbox.prop('checked', true);
                $option.prop('selected', true);
            }
            this.updateButtonText();
        },
        clearSelection: function () {
            var selected = this.getSelected();
            if (selected.length) {
                var arry = [];
                for (var i = 0; i < selected.length; i = i + 1) {
                    arry.push(selected[i].value);
                }
                this.deselect(arry);
                this.$select.change();
            }
        },
        deselect: function(deselectValues) {
            if(!$.isArray(deselectValues)) {
                deselectValues = [deselectValues];
            }
            for (var i = 0; i < deselectValues.length; i++) {
                var value = deselectValues[i];
                var $option = this.getOptionByValue(value);
                var $checkbox = this.getInputByValue(value);
                if (this.options.selectedClass) {
                    $checkbox.parents('li')
                        .removeClass(this.options.selectedClass);
                }
                $checkbox.prop('checked', false);
                $option.prop('selected', false);
            }
            this.updateButtonText();
        },
        rebuild: function() {
            this.$ul.html('');
            $('option[value="' + this.options.selectAllValue + '"]', this.$select).remove();
            this.options.multiple = this.$select.attr('multiple') === "multiple";
            this.buildSelectAll();
            this.buildDropdownOptions();
            this.buildFilter();
            this.updateButtonText();
            this.updateSelectAll();
        },
        dataprovider: function(dataprovider) {
            var optionDOM = "";
            dataprovider.forEach(function (option) {
                optionDOM += '<option value="' + option.value + '">' + option.label + '</option>';
            });
            this.$select.html(optionDOM);
            this.rebuild();
        },
        enable: function() {
            this.$select.prop('disabled', false);
            this.$button.prop('disabled', false)
                .removeClass('disabled');
        },
        disable: function() {
            this.$select.prop('disabled', true);
            this.$button.prop('disabled', true)
                .addClass('disabled');
        },
        setOptions: function(options) {
            this.options = this.mergeOptions(options);
        },
        mergeOptions: function(options) {
            return $.extend(true, {}, this.defaults, options);
        },
        hasSelectAll: function() {
            return $('option[value="' + this.options.selectAllValue + '"]', this.$select).length > 0;
        },
        updateSelectAll: function() {
            if (this.hasSelectAll()) {
                var selected = this.getSelected();
                if (selected.length === $('option:not([data-role=divider])', this.$select).length - 1) {
                    this.select(this.options.selectAllValue);
                }
                else {
                    this.deselect(this.options.selectAllValue);
                }
            }
        },
        updateButtonText: function() {
            var options = this.getSelected();
            $('button', this.$container).html(this.options.buttonText(options, this.$select));
            $('button', this.$container).attr('title', this.options.buttonTitle(options, this.$select));
        },
        getSelected: function() {
            return $('option[value!="' + this.options.selectAllValue + '"]:selected', this.$select).filter(function() {
                return $(this).prop('selected');
            });
        },
        getOptionByValue: function (value) {
            var options = $('option', this.$select);
            var valueToCompare = value.toString();
            for (var i = 0; i < options.length; i = i + 1) {
                var option = options[i];
                if (option.value === valueToCompare) {
                    return $(option);
                }
            }
        },
        getInputByValue: function (value) {
            var checkboxes = $('li input', this.$ul);
            var valueToCompare = value.toString();
            for (var i = 0; i < checkboxes.length; i = i + 1) {
                var checkbox = checkboxes[i];
                if (checkbox.value === valueToCompare) {
                    return $(checkbox);
                }
            }
        },
        updateOriginalOptions: function() {
            this.originalOptions = this.$select.clone()[0].options;
        },
        asyncFunction: function(callback, timeout, self) {
            var args = Array.prototype.slice.call(arguments, 3);
            return setTimeout(function() {
                callback.apply(self || window, args);
            }, timeout);
        }
    };
    $.fn.multiselect = function(option, parameter) {
        return this.each(function() {
            var data = $(this).data('multiselect');
            var options = typeof option === 'object' && option;
            if (!data) {
                data = new Multiselect(this, options);
                $(this).data('multiselect', data);
            }
            if (typeof option === 'string') {
                data[option](parameter);
                if (option === 'destroy') {
                    $(this).data('multiselect', false);
                }
            }
        });
    };
    $.fn.multiselect.Constructor = Multiselect;
    $(function() {
        $("select[data-role=multiselect]").multiselect();
    });
}(window.jQuery);
