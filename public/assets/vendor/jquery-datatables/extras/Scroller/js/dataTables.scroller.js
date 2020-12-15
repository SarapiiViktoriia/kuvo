(function(window, document, undefined){
var factory = function( $, DataTable ) {
"use strict";
var Scroller = function ( oDTSettings, oOpts ) {
	if ( ! this instanceof Scroller )
	{
		alert( "Scroller warning: Scroller must be initialised with the 'new' keyword." );
		return;
	}
	if ( typeof oOpts == 'undefined' )
	{
		oOpts = {};
	}
	this.s = {
		"dt": oDTSettings,
		"tableTop": 0,
		"tableBottom": 0,
		"redrawTop": 0,
		"redrawBottom": 0,
		"autoHeight": true,
		"viewportRows": 0,
		"stateTO": null,
		"drawTO": null,
		heights: {
			jump: null,
			page: null,
			virtual: null,
			scroll: null,
			row: null,
			viewport: null
		},
		topRowFloat: 0,
		scrollDrawDiff: null,
		loaderVisible: false
	};
	this.s = $.extend( this.s, Scroller.oDefaults, oOpts );
	this.s.heights.row = this.s.rowHeight;
	this.dom = {
		"force":    document.createElement('div'),
		"scroller": null,
		"table":    null,
		"loader":   null
	};
	this.s.dt.oScroller = this;
	this._fnConstruct();
};
Scroller.prototype = {
	"fnRowToPixels": function ( rowIdx, intParse, virtual )
	{
		var pixels;
		if ( virtual ) {
			pixels = this._domain( 'virtualToPhysical', rowIdx * this.s.heights.row );
		}
		else {
			var diff = rowIdx - this.s.baseRowTop;
			pixels = this.s.baseScrollTop + (diff * this.s.heights.row);
		}
		return intParse || intParse === undefined ?
			parseInt( pixels, 10 ) :
			pixels;
	},
	"fnPixelsToRow": function ( pixels, intParse, virtual )
	{
		var diff = pixels - this.s.baseScrollTop;
		var row = virtual ?
			this._domain( 'physicalToVirtual', pixels ) / this.s.heights.row :
			( diff / this.s.heights.row ) + this.s.baseRowTop;
		return intParse || intParse === undefined ?
			parseInt( row, 10 ) :
			row;
	},
	"fnScrollToRow": function ( iRow, bAnimate )
	{
		var that = this;
		var ani = false;
		var px = this.fnRowToPixels( iRow );
		var preRows = ((this.s.displayBuffer-1)/2) * this.s.viewportRows;
		var drawRow = iRow - preRows;
		if ( drawRow < 0 ) {
			drawRow = 0;
		}
		if ( (px > this.s.redrawBottom || px < this.s.redrawTop) && this.s.dt._iDisplayStart !== drawRow ) {
			ani = true;
			px = this.fnRowToPixels( iRow, false, true );
		}
		if ( typeof bAnimate == 'undefined' || bAnimate )
		{
			this.s.ani = ani;
			$(this.dom.scroller).animate( {
				"scrollTop": px
			}, function () {
				setTimeout( function () {
					that.s.ani = false;
				}, 25 );
			} );
		}
		else
		{
			$(this.dom.scroller).scrollTop( px );
		}
	},
	"fnMeasure": function ( bRedraw )
	{
		if ( this.s.autoHeight )
		{
			this._fnCalcRowHeight();
		}
		var heights = this.s.heights;
		heights.viewport = $(this.dom.scroller).height();
		this.s.viewportRows = parseInt( heights.viewport / heights.row, 10 )+1;
		this.s.dt._iDisplayLength = this.s.viewportRows * this.s.displayBuffer;
		if ( bRedraw === undefined || bRedraw )
		{
			this.s.dt.oInstance.fnDraw();
		}
	},
	"_fnConstruct": function ()
	{
		var that = this;
		if ( !this.s.dt.oFeatures.bPaginate ) {
			this.s.dt.oApi._fnLog( this.s.dt, 0, 'Pagination must be enabled for Scroller' );
			return;
		}
		this.dom.force.style.position = "absolute";
		this.dom.force.style.top = "0px";
		this.dom.force.style.left = "0px";
		this.dom.force.style.width = "1px";
		this.dom.scroller = $('div.'+this.s.dt.oClasses.sScrollBody, this.s.dt.nTableWrapper)[0];
		this.dom.scroller.appendChild( this.dom.force );
		this.dom.scroller.style.position = "relative";
		this.dom.table = $('>table', this.dom.scroller)[0];
		this.dom.table.style.position = "absolute";
		this.dom.table.style.top = "0px";
		this.dom.table.style.left = "0px";
		$(this.s.dt.nTableWrapper).addClass('DTS');
		if ( this.s.loadingIndicator )
		{
			this.dom.loader = $('<div class="DTS_Loading">'+this.s.dt.oLanguage.sLoadingRecords+'</div>')
				.css('display', 'none');
			$(this.dom.scroller.parentNode)
				.css('position', 'relative')
				.append( this.dom.loader );
		}
		if ( this.s.heights.row && this.s.heights.row != 'auto' )
		{
			this.s.autoHeight = false;
		}
		this.fnMeasure( false );
		this.s.ingnoreScroll = true;
		this.s.stateSaveThrottle = this.s.dt.oApi._fnThrottle( function () {
			that.s.dt.oApi._fnSaveState( that.s.dt );
		}, 500 );
		$(this.dom.scroller).on( 'scroll.DTS', function (e) {
			that._fnScroll.call( that );
		} );
		$(this.dom.scroller).on('touchstart.DTS', function () {
			that._fnScroll.call( that );
		} );
		this.s.dt.aoDrawCallback.push( {
			"fn": function () {
				if ( that.s.dt.bInitialised ) {
					that._fnDrawCallback.call( that );
				}
			},
			"sName": "Scroller"
		} );
		$(window).on( 'resize.DTS', function () {
			that.fnMeasure( false );
			that._fnInfo();
		} );
		var initialStateSave = true;
		this.s.dt.oApi._fnCallbackReg( this.s.dt, 'aoStateSaveParams', function (oS, oData) {
			if(initialStateSave && that.s.dt.oLoadedState){
				oData.iScroller = that.s.dt.oLoadedState.iScroller;
				oData.iScrollerTopRow = that.s.dt.oLoadedState.iScrollerTopRow;
				initialStateSave = false;
			} else {
				oData.iScroller = that.dom.scroller.scrollTop;
				oData.iScrollerTopRow = that.s.topRowFloat;
			}
		}, "Scroller_State" );
		if ( this.s.dt.oLoadedState ) {
			this.s.topRowFloat = this.s.dt.oLoadedState.iScrollerTopRow || 0;
		}
		this.s.dt.aoDestroyCallback.push( {
			"sName": "Scroller",
			"fn": function () {
				$(window).off( 'resize.DTS' );
				$(that.dom.scroller).off('touchstart.DTS scroll.DTS');
				$(that.s.dt.nTableWrapper).removeClass('DTS');
				$('div.DTS_Loading', that.dom.scroller.parentNode).remove();
				that.dom.table.style.position = "";
				that.dom.table.style.top = "";
				that.dom.table.style.left = "";
			}
		} );
	},
	"_fnScroll": function ()
	{
		var
			that = this,
			heights = this.s.heights,
			iScrollTop = this.dom.scroller.scrollTop,
			iTopRow;
		if ( this.s.skip ) {
			return;
		}
		if ( this.s.ingnoreScroll ) {
			return;
		}
		if ( this.s.dt.bFiltered || this.s.dt.bSorted ) {
			this.s.lastScrollTop = 0;
			return;
		}
		this._fnInfo();
		clearTimeout( this.s.stateTO );
		this.s.stateTO = setTimeout( function () {
			that.s.dt.oApi._fnSaveState( that.s.dt );
		}, 250 );
		if ( iScrollTop < this.s.redrawTop || iScrollTop > this.s.redrawBottom ) {
			var preRows = Math.ceil( ((this.s.displayBuffer-1)/2) * this.s.viewportRows );
			if ( Math.abs( iScrollTop - this.s.lastScrollTop ) > heights.viewport || this.s.ani ) {
				iTopRow = parseInt(this._domain( 'physicalToVirtual', iScrollTop ) / heights.row, 10) - preRows;
				this.s.topRowFloat = (this._domain( 'physicalToVirtual', iScrollTop ) / heights.row);
			}
			else {
				iTopRow = this.fnPixelsToRow( iScrollTop ) - preRows;
				this.s.topRowFloat = this.fnPixelsToRow( iScrollTop, false );
			}
			if ( iTopRow <= 0 ) {
				iTopRow = 0;
			}
			else if ( iTopRow + this.s.dt._iDisplayLength > this.s.dt.fnRecordsDisplay() ) {
				iTopRow = this.s.dt.fnRecordsDisplay() - this.s.dt._iDisplayLength;
				if ( iTopRow < 0 ) {
					iTopRow = 0;
				}
			}
			else if ( iTopRow % 2 !== 0 ) {
				iTopRow++;
			}
			if ( iTopRow != this.s.dt._iDisplayStart ) {
				this.s.tableTop = $(this.s.dt.nTable).offset().top;
				this.s.tableBottom = $(this.s.dt.nTable).height() + this.s.tableTop;
				var draw =  function () {
					if ( that.s.scrollDrawReq === null ) {
						that.s.scrollDrawReq = iScrollTop;
					}
					that.s.dt._iDisplayStart = iTopRow;
					if ( that.s.dt.oApi._fnCalculateEnd ) { 
						that.s.dt.oApi._fnCalculateEnd( that.s.dt );
					}
					that.s.dt.oApi._fnDraw( that.s.dt );
				};
				if ( this.s.dt.oFeatures.bServerSide ) {
					clearTimeout( this.s.drawTO );
					this.s.drawTO = setTimeout( draw, this.s.serverWait );
				}
				else {
					draw();
				}
				if ( this.dom.loader && ! this.s.loaderVisible ) {
					this.dom.loader.css( 'display', 'block' );
					this.s.loaderVisible = true;
				}
			}
		}
		this.s.lastScrollTop = iScrollTop;
		this.s.stateSaveThrottle();
	},
	_domain: function ( dir, val )
	{
		var heights = this.s.heights;
		var coeff;
		if ( heights.virtual === heights.scroll ) {
			coeff = (heights.virtual-heights.viewport) / (heights.scroll-heights.viewport);
			if ( dir === 'virtualToPhysical' ) {
				return val / coeff;
			}
			else if ( dir === 'physicalToVirtual' ) {
				return val * coeff;
			}
		}
		var xMax = (heights.scroll - heights.viewport) / 2;
		var yMax = (heights.virtual - heights.viewport) / 2;
		coeff = yMax / ( xMax * xMax );
		if ( dir === 'virtualToPhysical' ) {
			if ( val < yMax ) {
				return Math.pow(val / coeff, 0.5);
			}
			else {
				val = (yMax*2) - val;
				return val < 0 ?
					heights.scroll :
					(xMax*2) - Math.pow(val / coeff, 0.5);
			}
		}
		else if ( dir === 'physicalToVirtual' ) {
			if ( val < xMax ) {
				return val * val * coeff;
			}
			else {
				val = (xMax*2) - val;
				return val < 0 ?
					heights.virtual :
					(yMax*2) - (val * val * coeff);
			}
		}
	},
	"_fnDrawCallback": function ()
	{
		var
			that = this,
			heights = this.s.heights,
			iScrollTop = this.dom.scroller.scrollTop,
			iActualScrollTop = iScrollTop,
			iScrollBottom = iScrollTop + heights.viewport,
			iTableHeight = $(this.s.dt.nTable).height(),
			displayStart = this.s.dt._iDisplayStart,
			displayLen = this.s.dt._iDisplayLength,
			displayEnd = this.s.dt.fnRecordsDisplay();
		this.s.skip = true;
		this._fnScrollForce();
		if ( displayStart === 0 ) {
			iScrollTop = this.s.topRowFloat * heights.row;
		}
		else if ( displayStart + displayLen >= displayEnd ) {
			iScrollTop = heights.scroll - ((displayEnd - this.s.topRowFloat) * heights.row);
		}
		else {
			iScrollTop = this._domain( 'virtualToPhysical', this.s.topRowFloat * heights.row );
		}
		this.dom.scroller.scrollTop = iScrollTop;
		this.s.baseScrollTop = iScrollTop;
		this.s.baseRowTop = this.s.topRowFloat;
		var tableTop = iScrollTop - ((this.s.topRowFloat - displayStart) * heights.row);
		if ( displayStart === 0 ) {
			tableTop = 0;
		}
		else if ( displayStart + displayLen >= displayEnd ) {
			tableTop = heights.scroll - iTableHeight;
		}
		this.dom.table.style.top = tableTop+'px';
		this.s.tableTop = tableTop;
		this.s.tableBottom = iTableHeight + this.s.tableTop;
		var boundaryPx = (iScrollTop - this.s.tableTop) * this.s.boundaryScale;
		this.s.redrawTop = iScrollTop - boundaryPx;
		this.s.redrawBottom = iScrollTop + boundaryPx;
		this.s.skip = false;
		if ( this.s.dt.oFeatures.bStateSave && this.s.dt.oLoadedState !== null &&
			 typeof this.s.dt.oLoadedState.iScroller != 'undefined' )
		{
			var ajaxSourced = (this.s.dt.sAjaxSource || that.s.dt.ajax) && ! this.s.dt.oFeatures.bServerSide ?
				true :
				false;
			if ( ( ajaxSourced && this.s.dt.iDraw == 2) ||
			     (!ajaxSourced && this.s.dt.iDraw == 1) )
			{
				setTimeout( function () {
					$(that.dom.scroller).scrollTop( that.s.dt.oLoadedState.iScroller );
					that.s.redrawTop = that.s.dt.oLoadedState.iScroller - (heights.viewport/2);
					setTimeout( function () {
						that.s.ingnoreScroll = false;
					}, 0 );
				}, 0 );
			}
		}
		else {
			that.s.ingnoreScroll = false;
		}
		setTimeout( function () {
			that._fnInfo.call( that );
		}, 0 );
		if ( this.dom.loader && this.s.loaderVisible ) {
			this.dom.loader.css( 'display', 'none' );
			this.s.loaderVisible = false;
		}
	},
	_fnScrollForce: function ()
	{
		var heights = this.s.heights;
		var max = 1000000;
		heights.virtual = heights.row * this.s.dt.fnRecordsDisplay();
		heights.scroll = heights.virtual;
		if ( heights.scroll > max ) {
			heights.scroll = max;
		}
		this.dom.force.style.height = heights.scroll+"px";
	},
	"_fnCalcRowHeight": function ()
	{
		var dt = this.s.dt;
		var origTable = dt.nTable;
		var nTable = origTable.cloneNode( false );
		var tbody = $('<tbody/>').appendTo( nTable );
		var container = $(
			'<div class="'+dt.oClasses.sWrapper+' DTS">'+
				'<div class="'+dt.oClasses.sScrollWrapper+'">'+
					'<div class="'+dt.oClasses.sScrollBody+'"></div>'+
				'</div>'+
			'</div>'
		);
		$('tbody tr:lt(4)', origTable).clone().appendTo( tbody );
		while( $('tr', tbody).length < 3 ) {
			tbody.append( '<tr><td>&nbsp;</td></tr>' );
		}
		$('div.'+dt.oClasses.sScrollBody, container).append( nTable );
		var appendTo;
		if (dt._bInitComplete) {
			appendTo = origTable.parentNode;
		} else {
			if (!this.s.dt.nHolding) {
				this.s.dt.nHolding = $( '<div></div>' ).insertBefore( this.s.dt.nTable );
			}
			appendTo = this.s.dt.nHolding;
		}
		container.appendTo( appendTo );
		this.s.heights.row = $('tr', tbody).eq(1).outerHeight();
		container.remove();
	},
	"_fnInfo": function ()
	{
		if ( !this.s.dt.oFeatures.bInfo )
		{
			return;
		}
		var
			dt = this.s.dt,
			language = dt.oLanguage,
			iScrollTop = this.dom.scroller.scrollTop,
			iStart = Math.floor( this.fnPixelsToRow(iScrollTop, false, this.s.ani)+1 ),
			iMax = dt.fnRecordsTotal(),
			iTotal = dt.fnRecordsDisplay(),
			iPossibleEnd = Math.ceil( this.fnPixelsToRow(iScrollTop+this.s.heights.viewport, false, this.s.ani) ),
			iEnd = iTotal < iPossibleEnd ? iTotal : iPossibleEnd,
			sStart = dt.fnFormatNumber( iStart ),
			sEnd = dt.fnFormatNumber( iEnd ),
			sMax = dt.fnFormatNumber( iMax ),
			sTotal = dt.fnFormatNumber( iTotal ),
			sOut;
		if ( dt.fnRecordsDisplay() === 0 &&
			   dt.fnRecordsDisplay() == dt.fnRecordsTotal() )
		{
			sOut = language.sInfoEmpty+ language.sInfoPostFix;
		}
		else if ( dt.fnRecordsDisplay() === 0 )
		{
			sOut = language.sInfoEmpty +' '+
				language.sInfoFiltered.replace('_MAX_', sMax)+
					language.sInfoPostFix;
		}
		else if ( dt.fnRecordsDisplay() == dt.fnRecordsTotal() )
		{
			sOut = language.sInfo.
					replace('_START_', sStart).
					replace('_END_',   sEnd).
					replace('_MAX_',   sMax).
					replace('_TOTAL_', sTotal)+
				language.sInfoPostFix;
		}
		else
		{
			sOut = language.sInfo.
					replace('_START_', sStart).
					replace('_END_',   sEnd).
					replace('_MAX_',   sMax).
					replace('_TOTAL_', sTotal) +' '+
				language.sInfoFiltered.replace(
					'_MAX_',
					dt.fnFormatNumber(dt.fnRecordsTotal())
				)+
				language.sInfoPostFix;
		}
		var callback = language.fnInfoCallback;
		if ( callback ) {
			sOut = callback.call( dt.oInstance,
				dt, iStart, iEnd, iMax, iTotal, sOut
			);
		}
		var n = dt.aanFeatures.i;
		if ( typeof n != 'undefined' )
		{
			for ( var i=0, iLen=n.length ; i<iLen ; i++ )
			{
				$(n[i]).html( sOut );
			}
		}
	}
};
Scroller.defaults = {
	"trace": false,
	"rowHeight": "auto",
	"serverWait": 200,
	"displayBuffer": 9,
	"boundaryScale": 0.5,
	"loadingIndicator": false
};
Scroller.oDefaults = Scroller.defaults;
Scroller.version = "1.2.2";
if ( typeof $.fn.dataTable == "function" &&
     typeof $.fn.dataTableExt.fnVersionCheck == "function" &&
     $.fn.dataTableExt.fnVersionCheck('1.9.0') )
{
	$.fn.dataTableExt.aoFeatures.push( {
		"fnInit": function( oDTSettings ) {
			var init = oDTSettings.oInit;
			var opts = init.scroller || init.oScroller || {};
			var oScroller = new Scroller( oDTSettings, opts );
			return oScroller.dom.wrapper;
		},
		"cFeature": "S",
		"sFeature": "Scroller"
	} );
}
else
{
	alert( "Warning: Scroller requires DataTables 1.9.0 or greater - www.datatables.net/download");
}
$.fn.dataTable.Scroller = Scroller;
$.fn.DataTable.Scroller = Scroller;
if ( $.fn.dataTable.Api ) {
	var Api = $.fn.dataTable.Api;
	Api.register( 'scroller()', function () {
		return this;
	} );
	Api.register( 'scroller().rowToPixels()', function ( rowIdx, intParse, virtual ) {
		var ctx = this.context;
		if ( ctx.length && ctx[0].oScroller ) {
			return ctx[0].oScroller.fnRowToPixels( rowIdx, intParse, virtual );
		}
	} );
	Api.register( 'scroller().pixelsToRow()', function ( pixels, intParse, virtual ) {
		var ctx = this.context;
		if ( ctx.length && ctx[0].oScroller ) {
			return ctx[0].oScroller.fnPixelsToRow( pixels, intParse, virtual );
		}
	} );
	Api.register( 'scroller().scrollToRow()', function ( row, ani ) {
		this.iterator( 'table', function ( ctx ) {
			if ( ctx.oScroller ) {
				ctx.oScroller.fnScrollToRow( row, ani );
			}
		} );
		return this;
	} );
	Api.register( 'scroller().measure()', function ( redraw ) {
		this.iterator( 'table', function ( ctx ) {
			if ( ctx.oScroller ) {
				ctx.oScroller.fnMeasure( redraw );
			}
		} );
		return this;
	} );
}
return Scroller;
}; 
if ( typeof define === 'function' && define.amd ) {
	define( ['jquery', 'datatables'], factory );
}
else if ( typeof exports === 'object' ) {
    factory( require('jquery'), require('datatables') );
}
else if ( jQuery && !jQuery.fn.dataTable.Scroller ) {
	factory( jQuery, jQuery.fn.dataTable );
}
})(window, document);
