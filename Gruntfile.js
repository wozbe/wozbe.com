module.exports = function(grunt) {
  grunt.loadNpmTasks('grunt-symlink');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');
  
  grunt.file.mkdir('app/Resources/public/images/');
  
  var filesLess = {};
  
  //get all assets, and prepare less file to be compiled into assets/[bundle]/css/[file].css
  var mappingFileLess = grunt.file.expandMapping(
    ['*/less/*.less', '*/less/*/*.less'], 
    'web/built/', {
      cwd: 'web/bundles/',
      rename: function(dest, matchedSrcPath, options) {
        return dest + matchedSrcPath.replace(/less/g, 'css');
      }
    });
    
  grunt.util._.each(mappingFileLess, function(value) {
    //why value.src is an array ??
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
    symlink: {
      app: {
        dest: 'web/bundles/app',
        relativeSrc: '../../app/Resources/public/',
        options: {type: 'dir'}
      },
      bootstrap_glyphicons_white: {
        dest: 'app/Resources/public/images/glyphicons-halflings-white.png',
        relativeSrc: '../../../../web/vendor/bootstrap/img/glyphicons-halflings-white.png',
        options: {type: 'file'}
      },
      bootstrap_glyphicons: {
        dest: 'app/Resources/public/images/glyphicons-halflings.png',
        relativeSrc: '../../../../web/vendor/bootstrap/img/glyphicons-halflings.png',
        options: {type: 'file'}
      },
      font_awesome: {
        dest: 'app/Resources/public/fonts/awesome',
        relativeSrc: '../../../../web/vendor/font-awesome/font/',
        options: {type: 'dir'}
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
        files: ['web/bundles/*/less/*.less', 'app/Resources/public/less/*.less'],
        tasks: ['less']
      },
      javascript: {
        files: ['web/bundles/app/js/*.js'],
        tasks: ['concat']
      }
    }
  });

  // Default task(s).
  grunt.registerTask('default', ['less', 'concat']);

};