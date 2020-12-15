module.exports = function( grunt ) {
"use strict";
var
	coreFiles = [
		"jquery.ui.core.js",
		"jquery.ui.widget.js",
		"jquery.ui.mouse.js",
		"jquery.ui.draggable.js",
		"jquery.ui.droppable.js",
		"jquery.ui.resizable.js",
		"jquery.ui.selectable.js",
		"jquery.ui.sortable.js",
		"jquery.ui.effect.js"
	],
	uiFiles = coreFiles.map(function( file ) {
		return "ui/" + file;
	}).concat( expandFiles( "ui\n";
}
grunt.initConfig({
	pkg: grunt.file.readJSON("package.json"),
	files: {
		dist: "<%= pkg.name %>-<%= pkg.version %>"
	},
	compare_size: compareFiles,
	concat: {
		ui: {
			options: {
				banner: createBanner( uiFiles ),
				stripBanners: {
					block: true
				}
			},
			src: uiFiles,
			dest: "dist/jquery-ui.js"
		},
		i18n: {
			options: {
				banner: createBanner( allI18nFiles )
			},
			src: allI18nFiles,
			dest: "dist/i18n/jquery-ui-i18n.js"
		},
		css: {
			options: {
				banner: createBanner( cssFiles ),
				stripBanners: {
					block: true
				}
			},
			src: cssFiles,
			dest: "dist/jquery-ui.css"
		}
	},
	uglify: minify,
	cssmin: minifyCSS,
	htmllint: {
		all: grunt.file.expand( [ "demos*.html", "tests*.html" ] ).filter(function( file ) {
			return !/(?:ajax\/content\d\.html|tabs\/data\/test\.html|tests\/unit\/core\/core\.html)/.test( file );
		})
	},
	copy: {
		dist_units_images: {
			src: "themes/base/images*.html" ).filter(function( file ) {
			return !( /(all|index|test|dialog|dialog_deprecated|tooltip)\.html$/ ).test( file );
		})
	},
	jshint: {
		options: {
			jshintrc: true
		},
		all: [
			"ui*.js",
			"tests/unit*.js"
		]
	},
	csslint: {
		base_theme: {
			src: "themes/base/*.css",
			options: {
				csslintrc: ".csslintrc"
			}
		}
	}
});
grunt.registerTask( "default", [ "lint", "test" ] );
grunt.registerTask( "lint", [ "asciilint", "jshint", "csslint", "htmllint" ] );
grunt.registerTask( "test", [ "qunit" ] );
grunt.registerTask( "sizer", [ "concat:ui", "uglify:main", "compare_size:all" ] );
grunt.registerTask( "sizer_all", [ "concat:ui", "uglify", "compare_size" ] );
grunt.registerTask( "build", [ "concat", "uglify", "cssmin", "copy:dist_units_images" ] );
};
