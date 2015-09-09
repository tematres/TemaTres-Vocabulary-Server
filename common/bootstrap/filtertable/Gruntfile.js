/*global module:false*/
module.exports = function(grunt) {
  "use strict";

  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON("package.json"),
    concat: {
      options: {
        banner: "/**\n" +
                " * <%= pkg.name %>\n" +
                " * <%= pkg.description %>\n" +
                " *\n" +
                " * @author <%= pkg.author.name %>\n" +
                " * @copyright <%= pkg.author.name %> <%= grunt.template.today('yyyy') %>\n" +
                " * @license <%= pkg.licenses[0].type %> <<%= pkg.licenses[0].url %>>\n" +
                " * @link <%= pkg.homepage %>\n" +
                " * @module <%= pkg.name %>\n" +
                " * @version <%= pkg.version %>\n" +
                " */\n"
      },
      dist: {
        files: {
          "lib/jquery.filterable.js":
                ["src/filterable-utils.js",
                 "src/filterable-cell.js",
                 "src/filterable-row.js",
                 "src/filterable.js"],
          "lib/bootstrap-filterable.css":
                ["src/bootstrap-filterable.css"]
        }
      }
    },
    uglify: {
      options: {
        banner: "/**\n" +
                " * @author <%= pkg.author.name %>\n" +
                " * @copyright <%= pkg.author.name %> <%= grunt.template.today('yyyy') %>\n" +
                " * @license <%= pkg.licenses[0].type %> <<%= pkg.licenses[0].url %>>\n" +
                " * @link <%= pkg.homepage %>\n" +
                " * @module <%= pkg.name %>\n" +
                " * @version <%= pkg.version %> **/\n"
      },
      dist: {
        files: {
          "lib/jquery.filterable.min.js": ["lib/jquery.filterable.js"]
        }
      }
    },
    qunit: {
      files: ["test/index.html"]
    },
    jshint: {
      files : [
        "Gruntfile.js",
        "bower.json",
        "src/*.js",
        "test/specs/*.js"
      ],
      options: {
        curly     : true,
        eqeqeq    : true,
        immed     : true,
        latedef   : true,
        noempty   : true,
        newcap    : true,
        noarg     : true,
        sub       : true,
        undef     : true,
        eqnull    : true,
        jquery    : true,
        unused    : true,
        bitwise   : true,
        camelcase : true,
        forin     : true,
        nonew     : true,
        quotmark  : true,
        trailing  : true
      }
    },
    csslint: {
      strict: {
        options: {
          import: 2
        },
        src: ["src/**/*.css"]
      }
    }
  });
  
  // Load Plugins
  grunt.loadNpmTasks("grunt-contrib-uglify");
  grunt.loadNpmTasks("grunt-contrib-jshint");
  grunt.loadNpmTasks("grunt-contrib-qunit");
  grunt.loadNpmTasks("grunt-contrib-watch");
  grunt.loadNpmTasks("grunt-contrib-concat");
  grunt.loadNpmTasks("grunt-contrib-csslint");
  
  // Default task.
  grunt.registerTask("default", ["jshint", "csslint", "qunit", "concat", "uglify"]);

};