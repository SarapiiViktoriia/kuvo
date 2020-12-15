(function( $ ) {
	'use strict';
	$('#treeBasic').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
		'types' : {
			'default' : {
				'icon' : 'fa fa-folder'
			},
			'file' : {
				'icon' : 'fa fa-file'
			}
		},
		'plugins': ['types']
	});
	$('#treeCheckbox').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}
		},
		'types' : {
			'default' : {
				'icon' : 'fa fa-folder'
			},
			'file' : {
				'icon' : 'fa fa-file'
			}
		},
		'plugins': ['types', 'checkbox']
	});
	$('#treeAjaxHTML').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}, 
			'check_callback' : true,
			'data' : {
				'url' : function (node) {
				  return 'assets/ajax/ajax-treeview-nodes.html';
				},
				'data' : function (node) {
				  return { 'parent' : node.id };
				}
			}
		},
		'types' : {
			'default' : {
				'icon' : 'fa fa-folder'
			},
			'file' : {
				'icon' : 'fa fa-file'
			}
		},
		'plugins': ['types']
	});
	$('#treeAjaxJSON').jstree({
		'core' : {
			'themes' : {
				'responsive': false
			}, 
			'check_callback' : true,
			'data' : {
				'url' : function (node) {
					return node.id === '#' ? 'assets/ajax/ajax-treeview-roots.json' : 'assets/ajax/ajax-treeview-children.json';
				},
				'data' : function (node) {
					return { 'id' : node.id };
				}
			}
		},
		'types' : {
			'default' : {
				'icon' : 'fa fa-folder'
			},
			'file' : {
				'icon' : 'fa fa-file'
			}
		},
		'plugins': ['types']
	});
	$('#treeDragDrop').jstree({
		'core' : {
			'check_callback' : true,
			'themes' : {
				'responsive': false
			}
		},
		'types' : {
			'default' : {
				'icon' : 'fa fa-folder'
			},
			'file' : {
				'icon' : 'fa fa-file'
			}
		},
		'plugins': ['types', 'dnd']
	});
}).apply( this, [ jQuery ]);
