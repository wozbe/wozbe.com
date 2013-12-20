module.exports = function(grunt) {
  grunt.loadNpmTasks('grunt-symlink');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  
  grunt.file.mkdir('app/Resources/public/images/');
  
  var filesLess = {};
  
  // LESS Files management
  // Source LESS files are located inside : bundles/[bundle]/less/
  // Destination CSS files are located inside : built/[bundle]/css/
  var mappingFileLess = grunt.file.expandMapping(
    ['*/less/*.less', '*/less/*/*.less'], 
    'web/built/', {
      cwd: 'web/bundles/',
      rename: function(dest, matchedSrcPath, options) {
        return dest + matchedSrcPath.replace(/less/g, 'css');
      }
    });
    
  grunt.util._.each(mappingFileLess, function(value) {
    // Why value.src is an array ??
    filesLess[value.dest] = value.src[0];
  });
  
  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    
    less: {
      bundles: {
        files: filesLess
      }
    },
    copy: {
      bootstrap_glyphicons_white: {
        src: 'web/vendor/bootstrap/img/glyphicons-halflings-white.png',
        dest: 'app/Resources/public/images/glyphicons-halflings-white.png'
      },
      bootstrap_glyphicons: {
        src: 'web/vendor/bootstrap/img/glyphicons-halflings.png',
        dest: 'app/Resources/public/images/glyphicons-halflings.png'
      },
      font_awesome: {
        src: 'web/vendor/font-awesome/font/',
        dest: 'app/Resources/public/fonts/awesome'
      },
      app: {
        expand: true,
        cwd: 'app/Resources/public/',
        src: '**',
        dest: 'web/bundles/app/'
      }
    },
    concat: {
      dist: {
        src: [
          'web/vendor/jquery/jquery.js',
          'web/vendor/mustache/mustache.js',
          'web/vendor/isotope/jquery.isotope.js',
          'web/vendor/bootstrap/js/bootstrap-transition.js',
          'web/vendor/bootstrap/js/bootstrap-alert.js',
          'web/vendor/bootstrap/js/bootstrap-modal.js',
          'web/vendor/bootstrap/js/bootstrap-dropdown.js',
          'web/vendor/bootstrap/js/bootstrap-scrollspy.js',
          'web/vendor/bootstrap/js/bootstrap-tab.js',
          'web/vendor/bootstrap/js/bootstrap-tooltip.js',
          'web/vendor/bootstrap/js/bootstrap-popover.js',
          'web/vendor/bootstrap/js/bootstrap-button.js',
          'web/vendor/bootstrap/js/bootstrap-collapse.js',
          'web/vendor/bootstrap/js/bootstrap-carousel.js',
          'web/vendor/bootstrap/js/bootstrap-typeahead.js',
          'web/vendor/bootstrap/js/bootstrap-affix.js',
          'web/vendor/underscore/underscore.js',
          'web/bundles/app/js/wozbe.js'
        ],
        dest: 'web/built/app/js/wozbe.js'
      }
    },
    watch: {
      css: {
        files: ['web/bundles/*/less/*.less'],
        tasks: ['css']
      },
      javascript: {
        files: ['web/bundles/app/js/*.js'],
        tasks: ['javascript']
      }
    },
    uglify: {
      dist: {
        files: {
          'web/built/app/js/wozbe.min.js': ['web/built/app/js/wozbe.js']
        }
      }
    },
    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        eqnull: true,
        browser: true,
        undef: true,
        unused: true,
        bitwise: true,
        camelcase: true,
        forin: true,
        immed: true,
        latedef: true,
        newcap: true,
        quotmark: 'single',
        strict: true,
        maxparams: 4,
        maxdepth: 2,
        maxcomplexity: 3,
        globals: {
          'jQuery': true,
          '$': true,
          '_': true,
          'Mustache': true
        }
      },
      dist: {
        src: ['web/bundles/app/js/*.js']
      }
    }
  });

  // Default task(s).
  grunt.registerTask('default', ['css', 'javascript']);
  grunt.registerTask('css', ['less']);
  grunt.registerTask('javascript', ['jshint', 'concat', 'uglify']);
  grunt.registerTask('assets:install', ['copy']);

};