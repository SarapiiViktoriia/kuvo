(function(window, document, undefined) {
var factory = function( $, DataTable ) {
"use strict";
var FixedColumns = function ( dt, init ) {
	var that = this;
	if ( ! this instanceof FixedColumns )
	{
		alert( "FixedColumns warning: FixedColumns must be initialised with the 'new' keyword." );
		return;
	}
	if ( typeof init == 'undefined' )
	{
		init = {};
	}
	if ( $.fn.dataTable.camelToHungarian ) {
		$.fn.dataTable.camelToHungarian( FixedColumns.defaults, init );
	}
	var dtSettings = $.fn.dataTable.Api ?
		new $.fn.dataTable.Api( dt ).settings()[0] :
		dt.fnSettings();
	this.s = {
		"dt": dtSettings,
		"iTableColumns": dtSettings.aoColumns.length,
		"aiOuterWidths": [],
		"aiInnerWidths": []
	};
	this.dom = {
		"scroller": null,
		"header": null,
		"body": null,
		"footer": null,
		"grid": {
			"wrapper": null,
			"dt": null,
			"left": {
				"wrapper": null,
				"head": null,
				"body": null,
				"foot": null
			},
			"right": {
				"wrapper": null,
				"head": null,
				"body": null,
				"foot": null
			}
		},
		"clone": {
			"left": {
				"header": null,
				"body": null,
				"footer": null
			},
			"right": {
				"header": null,
				"body": null,
				"footer": null
			}
		}
	};
	dtSettings._oFixedColumns = this;
	if ( ! dtSettings._bInitComplete )
	{
		dtSettings.oApi._fnCallbackReg( dtSettings, 'aoInitComplete', function () {
			that._fnConstruct( init );
		}, 'FixedColumns' );
	}
	else
	{
		this._fnConstruct( init );
	}
};
FixedColumns.prototype = {
	"fnUpdate": function ()
	{
		this._fnDraw( true );
	},
	"fnRedrawLayout": function ()
	{
		this._fnColCalc();
		this._fnGridLayout();
		this.fnUpdate();
	},
	"fnRecalculateHeight": function ( nTr )
	{
		delete nTr._DTTC_iHeight;
		nTr.style.height = 'auto';
	},
	"fnSetRowHeight": function ( nTarget, iHeight )
	{
		nTarget.style.height = iHeight+"px";
	},
	"fnGetPosition": function ( node )
	{
		var idx;
		var inst = this.s.dt.oInstance;
		if ( ! $(node).parents('.DTFC_Cloned').length )
		{
			return inst.fnGetPosition( node );
		}
		else
		{
			if ( node.nodeName.toLowerCase() === 'tr' ) {
				idx = $(node).index();
				return inst.fnGetPosition( $('tr', this.s.dt.nTBody)[ idx ] );
			}
			else
			{
				var colIdx = $(node).index();
				idx = $(node.parentNode).index();
				var row = inst.fnGetPosition( $('tr', this.s.dt.nTBody)[ idx ] );
				return [
					row,
					colIdx,
					inst.oApi._fnVisibleToColumnIndex( this.s.dt, colIdx )
				];
			}
		}
	},
	"_fnConstruct": function ( oInit )
	{
		var i, iLen, iWidth,
			that = this;
		if ( typeof this.s.dt.oInstance.fnVersionCheck != 'function' ||
		     this.s.dt.oInstance.fnVersionCheck( '1.8.0' ) !== true )
		{
			alert( "FixedColumns "+FixedColumns.VERSION+" required DataTables 1.8.0 or later. "+
				"Please upgrade your DataTables installation" );
			return;
		}
		if ( this.s.dt.oScroll.sX === "" )
		{
			this.s.dt.oInstance.oApi._fnLog( this.s.dt, 1, "FixedColumns is not needed (no "+
				"x-scrolling in DataTables enabled), so no action will be taken. Use 'FixedHeader' for "+
				"column fixing when scrolling is not enabled" );
			return;
		}
		this.s = $.extend( true, this.s, FixedColumns.defaults, oInit );
		var classes = this.s.dt.oClasses;
		this.dom.grid.dt = $(this.s.dt.nTable).parents('div.'+classes.sScrollWrapper)[0];
		this.dom.scroller = $('div.'+classes.sScrollBody, this.dom.grid.dt )[0];
		this._fnColCalc();
		this._fnGridSetup();
		var mouseController;
		$(this.dom.scroller)
			.on( 'mouseover.DTFC touchstart.DTFC', function () {
				mouseController = 'main';
			} )
			.on( 'scroll.DTFC', function () {
				if ( mouseController === 'main' ) {
					if ( that.s.iLeftColumns > 0 ) {
						that.dom.grid.left.liner.scrollTop = that.dom.scroller.scrollTop;
					}
					if ( that.s.iRightColumns > 0 ) {
						that.dom.grid.right.liner.scrollTop = that.dom.scroller.scrollTop;
					}
				}
			} );
		var wheelType = 'onwheel' in document.createElement('div') ?
			'wheel.DTFC' :
			'mousewheel.DTFC';
		if ( that.s.iLeftColumns > 0 ) {
			$(that.dom.grid.left.liner)
				.on( 'mouseover.DTFC touchstart.DTFC', function () {
					mouseController = 'left';
				} )
				.on( 'scroll.DTFC', function () {
					if ( mouseController === 'left' ) {
						that.dom.scroller.scrollTop = that.dom.grid.left.liner.scrollTop;
						if ( that.s.iRightColumns > 0 ) {
							that.dom.grid.right.liner.scrollTop = that.dom.grid.left.liner.scrollTop;
						}
					}
				} )
				.on( wheelType, function(e) { 
					var xDelta = e.type === 'wheel' ?
						-e.originalEvent.deltaX :
						e.originalEvent.wheelDeltaX;
					that.dom.scroller.scrollLeft -= xDelta;
				} );
		}
		if ( that.s.iRightColumns > 0 ) {
			$(that.dom.grid.right.liner)
				.on( 'mouseover.DTFC touchstart.DTFC', function () {
					mouseController = 'right';
				} )
				.on( 'scroll.DTFC', function () {
					if ( mouseController === 'right' ) {
						that.dom.scroller.scrollTop = that.dom.grid.right.liner.scrollTop;
						if ( that.s.iLeftColumns > 0 ) {
							that.dom.grid.left.liner.scrollTop = that.dom.grid.right.liner.scrollTop;
						}
					}
				} )
				.on( wheelType, function(e) {
					var xDelta = e.type === 'wheel' ?
						-e.originalEvent.deltaX :
						e.originalEvent.wheelDeltaX;
					that.dom.scroller.scrollLeft -= xDelta;
				} );
		}
		$(window).on( 'resize.DTFC', function () {
			that._fnGridLayout.call( that );
		} );
		var bFirstDraw = true;
		var jqTable = $(this.s.dt.nTable);
		jqTable
			.on( 'draw.dt.DTFC', function () {
				that._fnDraw.call( that, bFirstDraw );
				bFirstDraw = false;
			} )
			.on( 'column-sizing.dt.DTFC', function () {
				that._fnColCalc();
				that._fnGridLayout( that );
			} )
			.on( 'column-visibility.dt.DTFC', function () {
				that._fnColCalc();
				that._fnGridLayout( that );
				that._fnDraw( true );
			} )
			.on( 'destroy.dt.DTFC', function () {
				jqTable.off( 'column-sizing.dt.DTFC destroy.dt.DTFC draw.dt.DTFC' );
				$(that.dom.scroller).off( 'scroll.DTFC mouseover.DTFC' );
				$(window).off( 'resize.DTFC' );
				$(that.dom.grid.left.liner).off( 'scroll.DTFC mouseover.DTFC '+wheelType );
				$(that.dom.grid.left.wrapper).remove();
				$(that.dom.grid.right.liner).off( 'scroll.DTFC mouseover.DTFC '+wheelType );
				$(that.dom.grid.right.wrapper).remove();
			} );
		this._fnGridLayout();
		this.s.dt.oInstance.fnDraw(false);
	},
	"_fnColCalc": function ()
	{
		var that = this;
		var iLeftWidth = 0;
		var iRightWidth = 0;
		this.s.aiInnerWidths = [];
		this.s.aiOuterWidths = [];
		$.each( this.s.dt.aoColumns, function (i, col) {
			var th = $(col.nTh);
			var border;
			if ( ! th.filter(':visible').length ) {
				that.s.aiInnerWidths.push( 0 );
				that.s.aiOuterWidths.push( 0 );
			}
			else
			{
				var iWidth = th.outerWidth();
				if ( that.s.aiOuterWidths.length === 0 ) {
					border = $(that.s.dt.nTable).css('border-left-width');
					iWidth += typeof border === 'string' ? 1 : parseInt( border, 10 );
				}
				if ( that.s.aiOuterWidths.length === that.s.dt.aoColumns.length-1 ) {
					border = $(that.s.dt.nTable).css('border-right-width');
					iWidth += typeof border === 'string' ? 1 : parseInt( border, 10 );
				}
				that.s.aiOuterWidths.push( iWidth );
				that.s.aiInnerWidths.push( th.width() );
				if ( i < that.s.iLeftColumns )
				{
					iLeftWidth += iWidth;
				}
				if ( that.s.iTableColumns-that.s.iRightColumns <= i )
				{
					iRightWidth += iWidth;
				}
			}
		} );
		this.s.iLeftWidth = iLeftWidth;
		this.s.iRightWidth = iRightWidth;
	},
	"_fnGridSetup": function ()
	{
		var that = this;
		var oOverflow = this._fnDTOverflow();
		var block;
		this.dom.body = this.s.dt.nTable;
		this.dom.header = this.s.dt.nTHead.parentNode;
		this.dom.header.parentNode.parentNode.style.position = "relative";
		var nSWrapper =
			$('<div class="DTFC_ScrollWrapper" style="position:relative; clear:both;">'+
				'<div class="DTFC_LeftWrapper" style="position:absolute; top:0; left:0;">'+
					'<div class="DTFC_LeftHeadWrapper" style="position:relative; top:0; left:0; overflow:hidden;"></div>'+
					'<div class="DTFC_LeftBodyWrapper" style="position:relative; top:0; left:0; overflow:hidden;">'+
						'<div class="DTFC_LeftBodyLiner" style="position:relative; top:0; left:0; overflow-y:scroll;"></div>'+
					'</div>'+
					'<div class="DTFC_LeftFootWrapper" style="position:relative; top:0; left:0; overflow:hidden;"></div>'+
				'</div>'+
				'<div class="DTFC_RightWrapper" style="position:absolute; top:0; left:0;">'+
					'<div class="DTFC_RightHeadWrapper" style="position:relative; top:0; left:0;">'+
						'<div class="DTFC_RightHeadBlocker DTFC_Blocker" style="position:absolute; top:0; bottom:0;"></div>'+
					'</div>'+
					'<div class="DTFC_RightBodyWrapper" style="position:relative; top:0; left:0; overflow:hidden;">'+
						'<div class="DTFC_RightBodyLiner" style="position:relative; top:0; left:0; overflow-y:scroll;"></div>'+
					'</div>'+
					'<div class="DTFC_RightFootWrapper" style="position:relative; top:0; left:0;">'+
						'<div class="DTFC_RightFootBlocker DTFC_Blocker" style="position:absolute; top:0; bottom:0;"></div>'+
					'</div>'+
				'</div>'+
			'</div>')[0];
		var nLeft = nSWrapper.childNodes[0];
		var nRight = nSWrapper.childNodes[1];
		this.dom.grid.dt.parentNode.insertBefore( nSWrapper, this.dom.grid.dt );
		nSWrapper.appendChild( this.dom.grid.dt );
		this.dom.grid.wrapper = nSWrapper;
		if ( this.s.iLeftColumns > 0 )
		{
			this.dom.grid.left.wrapper = nLeft;
			this.dom.grid.left.head = nLeft.childNodes[0];
			this.dom.grid.left.body = nLeft.childNodes[1];
			this.dom.grid.left.liner = $('div.DTFC_LeftBodyLiner', nSWrapper)[0];
			nSWrapper.appendChild( nLeft );
		}
		if ( this.s.iRightColumns > 0 )
		{
			this.dom.grid.right.wrapper = nRight;
			this.dom.grid.right.head = nRight.childNodes[0];
			this.dom.grid.right.body = nRight.childNodes[1];
			this.dom.grid.right.liner = $('div.DTFC_RightBodyLiner', nSWrapper)[0];
			block = $('div.DTFC_RightHeadBlocker', nSWrapper)[0];
			block.style.width = oOverflow.bar+"px";
			block.style.right = -oOverflow.bar+"px";
			this.dom.grid.right.headBlock = block;
			block = $('div.DTFC_RightFootBlocker', nSWrapper)[0];
			block.style.width = oOverflow.bar+"px";
			block.style.right = -oOverflow.bar+"px";
			this.dom.grid.right.footBlock = block;
			nSWrapper.appendChild( nRight );
		}
		if ( this.s.dt.nTFoot )
		{
			this.dom.footer = this.s.dt.nTFoot.parentNode;
			if ( this.s.iLeftColumns > 0 )
			{
				this.dom.grid.left.foot = nLeft.childNodes[2];
			}
			if ( this.s.iRightColumns > 0 )
			{
				this.dom.grid.right.foot = nRight.childNodes[2];
			}
		}
	},
	"_fnGridLayout": function ()
	{
		var oGrid = this.dom.grid;
		var iWidth = $(oGrid.wrapper).width();
		var iBodyHeight = $(this.s.dt.nTable.parentNode).outerHeight();
		var iFullHeight = $(this.s.dt.nTable.parentNode.parentNode).outerHeight();
		var oOverflow = this._fnDTOverflow();
		var
			iLeftWidth = this.s.iLeftWidth,
			iRightWidth = this.s.iRightWidth,
			iRight;
		if ( oOverflow.x )
		{
			iBodyHeight -= oOverflow.bar;
		}
		oGrid.wrapper.style.height = iFullHeight+"px";
		if ( this.s.iLeftColumns > 0 )
		{
			oGrid.left.wrapper.style.width = iLeftWidth+"px";
			oGrid.left.wrapper.style.height = "1px";
			oGrid.left.body.style.height = iBodyHeight+"px";
			if ( oGrid.left.foot ) {
				oGrid.left.foot.style.top = (oOverflow.x ? oOverflow.bar : 0)+"px"; 
			}
			oGrid.left.liner.style.width = (iLeftWidth+oOverflow.bar)+"px";
			oGrid.left.liner.style.height = iBodyHeight+"px";
		}
		if ( this.s.iRightColumns > 0 )
		{
			iRight = iWidth - iRightWidth;
			if ( oOverflow.y )
			{
				iRight -= oOverflow.bar;
			}
			oGrid.right.wrapper.style.width = iRightWidth+"px";
			oGrid.right.wrapper.style.left = iRight+"px";
			oGrid.right.wrapper.style.height = "1px";
			oGrid.right.body.style.height = iBodyHeight+"px";
			if ( oGrid.right.foot ) {
				oGrid.right.foot.style.top = (oOverflow.x ? oOverflow.bar : 0)+"px";
			}
			oGrid.right.liner.style.width = (iRightWidth+oOverflow.bar)+"px";
			oGrid.right.liner.style.height = iBodyHeight+"px";
			oGrid.right.headBlock.style.display = oOverflow.y ? 'block' : 'none';
			oGrid.right.footBlock.style.display = oOverflow.y ? 'block' : 'none';
		}
	},
	"_fnDTOverflow": function ()
	{
		var nTable = this.s.dt.nTable;
		var nTableScrollBody = nTable.parentNode;
		var out = {
			"x": false,
			"y": false,
			"bar": this.s.dt.oScroll.iBarWidth
		};
		if ( nTable.offsetWidth > nTableScrollBody.clientWidth )
		{
			out.x = true;
		}
		if ( nTable.offsetHeight > nTableScrollBody.clientHeight )
		{
			out.y = true;
		}
		return out;
	},
	"_fnDraw": function ( bAll )
	{
		this._fnGridLayout();
		this._fnCloneLeft( bAll );
		this._fnCloneRight( bAll );
		if ( this.s.fnDrawCallback !== null )
		{
			this.s.fnDrawCallback.call( this, this.dom.clone.left, this.dom.clone.right );
		}
		$(this).trigger( 'draw.dtfc', {
			"leftClone": this.dom.clone.left,
			"rightClone": this.dom.clone.right
		} );
	},
	"_fnCloneRight": function ( bAll )
	{
		if ( this.s.iRightColumns <= 0 ) {
			return;
		}
		var that = this,
			i, jq,
			aiColumns = [];
		for ( i=this.s.iTableColumns-this.s.iRightColumns ; i<this.s.iTableColumns ; i++ ) {
			if ( this.s.dt.aoColumns[i].bVisible ) {
				aiColumns.push( i );
			}
		}
		this._fnClone( this.dom.clone.right, this.dom.grid.right, aiColumns, bAll );
	},
	"_fnCloneLeft": function ( bAll )
	{
		if ( this.s.iLeftColumns <= 0 ) {
			return;
		}
		var that = this,
			i, jq,
			aiColumns = [];
		for ( i=0 ; i<this.s.iLeftColumns ; i++ ) {
			if ( this.s.dt.aoColumns[i].bVisible ) {
				aiColumns.push( i );
			}
		}
		this._fnClone( this.dom.clone.left, this.dom.grid.left, aiColumns, bAll );
	},
	"_fnCopyLayout": function ( aoOriginal, aiColumns )
	{
		var aReturn = [];
		var aClones = [];
		var aCloned = [];
		for ( var i=0, iLen=aoOriginal.length ; i<iLen ; i++ )
		{
			var aRow = [];
			aRow.nTr = $(aoOriginal[i].nTr).clone(true, true)[0];
			for ( var j=0, jLen=this.s.iTableColumns ; j<jLen ; j++ )
			{
				if ( $.inArray( j, aiColumns ) === -1 )
				{
					continue;
				}
				var iCloned = $.inArray( aoOriginal[i][j].cell, aCloned );
				if ( iCloned === -1 )
				{
					var nClone = $(aoOriginal[i][j].cell).clone(true, true)[0];
					aClones.push( nClone );
					aCloned.push( aoOriginal[i][j].cell );
					aRow.push( {
						"cell": nClone,
						"unique": aoOriginal[i][j].unique
					} );
				}
				else
				{
					aRow.push( {
						"cell": aClones[ iCloned ],
						"unique": aoOriginal[i][j].unique
					} );
				}
			}
			aReturn.push( aRow );
		}
		return aReturn;
	},
	"_fnClone": function ( oClone, oGrid, aiColumns, bAll )
	{
		var that = this,
			i, iLen, j, jLen, jq, nTarget, iColumn, nClone, iIndex, aoCloneLayout,
			jqCloneThead, aoFixedHeader;
		if ( bAll )
		{
			if ( oClone.header !== null )
			{
				oClone.header.parentNode.removeChild( oClone.header );
			}
			oClone.header = $(this.dom.header).clone(true, true)[0];
			oClone.header.className += " DTFC_Cloned";
			oClone.header.style.width = "100%";
			oGrid.head.appendChild( oClone.header );
			aoCloneLayout = this._fnCopyLayout( this.s.dt.aoHeader, aiColumns );
			jqCloneThead = $('>thead', oClone.header);
			jqCloneThead.empty();
			for ( i=0, iLen=aoCloneLayout.length ; i<iLen ; i++ )
			{
				jqCloneThead[0].appendChild( aoCloneLayout[i].nTr );
			}
			this.s.dt.oApi._fnDrawHead( this.s.dt, aoCloneLayout, true );
		}
		else
		{
			aoCloneLayout = this._fnCopyLayout( this.s.dt.aoHeader, aiColumns );
			aoFixedHeader=[];
			this.s.dt.oApi._fnDetectHeader( aoFixedHeader, $('>thead', oClone.header)[0] );
			for ( i=0, iLen=aoCloneLayout.length ; i<iLen ; i++ )
			{
				for ( j=0, jLen=aoCloneLayout[i].length ; j<jLen ; j++ )
				{
					aoFixedHeader[i][j].cell.className = aoCloneLayout[i][j].cell.className;
					$('span.DataTables_sort_icon', aoFixedHeader[i][j].cell).each( function () {
						this.className = $('span.DataTables_sort_icon', aoCloneLayout[i][j].cell)[0].className;
					} );
				}
			}
		}
		this._fnEqualiseHeights( 'thead', this.dom.header, oClone.header );
		if ( this.s.sHeightMatch == 'auto' )
		{
			$('>tbody>tr', that.dom.body).css('height', 'auto');
		}
		if ( oClone.body !== null )
		{
			oClone.body.parentNode.removeChild( oClone.body );
			oClone.body = null;
		}
		oClone.body = $(this.dom.body).clone(true)[0];
		oClone.body.className += " DTFC_Cloned";
		oClone.body.style.paddingBottom = this.s.dt.oScroll.iBarWidth+"px";
		oClone.body.style.marginBottom = (this.s.dt.oScroll.iBarWidth*2)+"px"; 
		if ( oClone.body.getAttribute('id') !== null )
		{
			oClone.body.removeAttribute('id');
		}
		$('>thead>tr', oClone.body).empty();
		$('>tfoot', oClone.body).remove();
		var nBody = $('tbody', oClone.body)[0];
		$(nBody).empty();
		if ( this.s.dt.aiDisplay.length > 0 )
		{
			var nInnerThead = $('>thead>tr', oClone.body)[0];
			for ( iIndex=0 ; iIndex<aiColumns.length ; iIndex++ )
			{
				iColumn = aiColumns[iIndex];
				nClone = $(this.s.dt.aoColumns[iColumn].nTh).clone(true)[0];
				nClone.innerHTML = "";
				var oStyle = nClone.style;
				oStyle.paddingTop = "0";
				oStyle.paddingBottom = "0";
				oStyle.borderTopWidth = "0";
				oStyle.borderBottomWidth = "0";
				oStyle.height = 0;
				oStyle.width = that.s.aiInnerWidths[iColumn]+"px";
				nInnerThead.appendChild( nClone );
			}
			$('>tbody>tr', that.dom.body).each( function (z) {
				var n = this.cloneNode(false);
				n.removeAttribute('id');
				var i = that.s.dt.oFeatures.bServerSide===false ?
					that.s.dt.aiDisplay[ that.s.dt._iDisplayStart+z ] : z;
				for ( iIndex=0 ; iIndex<aiColumns.length ; iIndex++ )
				{
					var aTds = that.s.dt.aoData[i].anCells || that.s.dt.oApi._fnGetTdNodes( that.s.dt, i );
					iColumn = aiColumns[iIndex];
					if ( aTds.length > 0 )
					{
						nClone = $( aTds[iColumn] ).clone(true, true)[0];
						n.appendChild( nClone );
					}
				}
				nBody.appendChild( n );
			} );
		}
		else
		{
			$('>tbody>tr', that.dom.body).each( function (z) {
				nClone = this.cloneNode(true);
				nClone.className += ' DTFC_NoData';
				$('td', nClone).html('');
				nBody.appendChild( nClone );
			} );
		}
		oClone.body.style.width = "100%";
		oClone.body.style.margin = "0";
		oClone.body.style.padding = "0";
		if ( bAll )
		{
			if ( typeof this.s.dt.oScroller != 'undefined' )
			{
				oGrid.liner.appendChild( this.s.dt.oScroller.dom.force.cloneNode(true) );
			}
		}
		oGrid.liner.appendChild( oClone.body );
		this._fnEqualiseHeights( 'tbody', that.dom.body, oClone.body );
		if ( this.s.dt.nTFoot !== null )
		{
			if ( bAll )
			{
				if ( oClone.footer !== null )
				{
					oClone.footer.parentNode.removeChild( oClone.footer );
				}
				oClone.footer = $(this.dom.footer).clone(true, true)[0];
				oClone.footer.className += " DTFC_Cloned";
				oClone.footer.style.width = "100%";
				oGrid.foot.appendChild( oClone.footer );
				aoCloneLayout = this._fnCopyLayout( this.s.dt.aoFooter, aiColumns );
				var jqCloneTfoot = $('>tfoot', oClone.footer);
				jqCloneTfoot.empty();
				for ( i=0, iLen=aoCloneLayout.length ; i<iLen ; i++ )
				{
					jqCloneTfoot[0].appendChild( aoCloneLayout[i].nTr );
				}
				this.s.dt.oApi._fnDrawHead( this.s.dt, aoCloneLayout, true );
			}
			else
			{
				aoCloneLayout = this._fnCopyLayout( this.s.dt.aoFooter, aiColumns );
				var aoCurrFooter=[];
				this.s.dt.oApi._fnDetectHeader( aoCurrFooter, $('>tfoot', oClone.footer)[0] );
				for ( i=0, iLen=aoCloneLayout.length ; i<iLen ; i++ )
				{
					for ( j=0, jLen=aoCloneLayout[i].length ; j<jLen ; j++ )
					{
						aoCurrFooter[i][j].cell.className = aoCloneLayout[i][j].cell.className;
					}
				}
			}
			this._fnEqualiseHeights( 'tfoot', this.dom.footer, oClone.footer );
		}
		var anUnique = this.s.dt.oApi._fnGetUniqueThs( this.s.dt, $('>thead', oClone.header)[0] );
		$(anUnique).each( function (i) {
			iColumn = aiColumns[i];
			this.style.width = that.s.aiInnerWidths[iColumn]+"px";
		} );
		if ( that.s.dt.nTFoot !== null )
		{
			anUnique = this.s.dt.oApi._fnGetUniqueThs( this.s.dt, $('>tfoot', oClone.footer)[0] );
			$(anUnique).each( function (i) {
				iColumn = aiColumns[i];
				this.style.width = that.s.aiInnerWidths[iColumn]+"px";
			} );
		}
	},
	"_fnGetTrNodes": function ( nIn )
	{
		var aOut = [];
		for ( var i=0, iLen=nIn.childNodes.length ; i<iLen ; i++ )
		{
			if ( nIn.childNodes[i].nodeName.toUpperCase() == "TR" )
			{
				aOut.push( nIn.childNodes[i] );
			}
		}
		return aOut;
	},
	"_fnEqualiseHeights": function ( nodeName, original, clone )
	{
		if ( this.s.sHeightMatch == 'none' && nodeName !== 'thead' && nodeName !== 'tfoot' )
		{
			return;
		}
		var that = this,
			i, iLen, iHeight, iHeight2, iHeightOriginal, iHeightClone,
			rootOriginal = original.getElementsByTagName(nodeName)[0],
			rootClone    = clone.getElementsByTagName(nodeName)[0],
			jqBoxHack    = $('>'+nodeName+'>tr:eq(0)', original).children(':first'),
			iBoxHack     = jqBoxHack.outerHeight() - jqBoxHack.height(),
			anOriginal   = this._fnGetTrNodes( rootOriginal ),
			anClone      = this._fnGetTrNodes( rootClone ),
			heights      = [];
		for ( i=0, iLen=anClone.length ; i<iLen ; i++ )
		{
			iHeightOriginal = anOriginal[i].offsetHeight;
			iHeightClone = anClone[i].offsetHeight;
			iHeight = iHeightClone > iHeightOriginal ? iHeightClone : iHeightOriginal;
			if ( this.s.sHeightMatch == 'semiauto' )
			{
				anOriginal[i]._DTTC_iHeight = iHeight;
			}
			heights.push( iHeight );
		}
		for ( i=0, iLen=anClone.length ; i<iLen ; i++ )
		{
			anClone[i].style.height = heights[i]+"px";
			anOriginal[i].style.height = heights[i]+"px";
		}
	}
};
FixedColumns.defaults = {
	"iLeftColumns": 1,
	"iRightColumns": 0,
	"fnDrawCallback": null,
	"sHeightMatch": "semiauto"
};
FixedColumns.version = "3.0.2";
$.fn.dataTable.FixedColumns = FixedColumns;
$.fn.DataTable.FixedColumns = FixedColumns;
return FixedColumns;
}; 
if ( typeof define === 'function' && define.amd ) {
	define( ['jquery', 'datatables'], factory );
}
else if ( typeof exports === 'object' ) {
    factory( require('jquery'), require('datatables') );
}
else if ( jQuery && !jQuery.fn.dataTable.FixedColumns ) {
	factory( jQuery, jQuery.fn.dataTable );
}
})(window, document);
