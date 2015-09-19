module.exports = function( grunt ) {

	var configObject = {
		config: {
			file         : 'external-content.php',
			glotpress_url: 'http://translate.tfrommen.de',
			languages    : 'languages/',
			name         : 'External Content',
			repository   : 'https://github.com/tfrommen/external-content',
			slug         : 'external-content',
			src_path     : 'src/',
			textdomain   : 'external-content'
		},

		// https://github.com/markoheijnen/grunt-glotpress
		glotpress_download: {
			languages: {
				options: {
					domainPath: '<%= config.src_path %><%= config.languages %>',
					url       : '<%= config.glotpress_url %>',
					slug      : '<%= config.slug %>',
					textdomain: '<%= config.textdomain %>'
				}
			}
		},

		// https://github.com/gruntjs/grunt-contrib-jshint
		jshint: {
			grunt: {
				src: [ 'Gruntfile.js' ]
			}
		},

		// https://github.com/cedaro/grunt-wp-i18n
		makepot: {
			pot: {
				options: {
					cwd        : '<%= config.src_path %>',
					domainPath : '<%= config.languages %>',
					mainFile   : '<%= config.file %>',
					potComments: 'Copyright (C) {{year}} <%= config.name %>\nThis file is distributed under the same license as the <%= config.name %> package.',
					potFilename: '<%= config.textdomain %>.pot',
					potHeaders : {
						poedit                 : true,
						'report-msgid-bugs-to' : '<%= config.repository %>/issues',
						'x-poedit-keywordslist': true
					},
					processPot : function( pot ) {
						var exclude = [
							'Plugin Name of the plugin/theme',
							'Plugin URI of the plugin/theme',
							'Author of the plugin/theme',
							'Author URI of the plugin/theme',
						    'translators: do not translate'
						];

						// Skip translations with the above defined meta comments
						for ( var translation in pot.translations[ '' ] ) {
							if ( 'undefined' === typeof pot.translations[ '' ][ translation ].comments.extracted ) {
								continue;
							}

							if ( exclude.indexOf( pot.translations[ '' ][ translation ].comments.extracted ) >= 0 ) {
								delete pot.translations[ '' ][ translation ];
							}
						}

						return pot;
					}
				}
			}
		},

		// https://github.com/gruntjs/grunt-contrib-watch
		watch: {
			options: {
				dot     : true,
				spawn   : true,
				interval: 2000
			},
			grunt  : {
				files: 'Gruntfile.js',
				tasks: [ 'jshint:grunt' ]
			}
		}
	};

	grunt.initConfig( configObject );

	// https://github.com/sindresorhus/load-grunt-tasks
	require( 'load-grunt-tasks' )( grunt );

	grunt.registerTask( 'default', [ 'watch' ] );
	grunt.registerTask( 'grunt', [ 'jshint:grunt' ] );
	grunt.registerTask( 'languages', [ 'makepot', 'glotpress_download' ] );
	grunt.registerTask( 'production', [ 'languages' ] );
	grunt.registerTask( 'test', [ 'jshint' ] );
};
