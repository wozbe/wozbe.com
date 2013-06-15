module.exports = function(grunt) {

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    
    less: {
      development: {
        files: {
          "web/css/bootstrap.css": "web/vendor/bootstrap/less/bootstrap.less"
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-symlink');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['less']);

};