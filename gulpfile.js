/* jshint -W097 */
/**
 * Fourth Wall Events WordPress Theme
 * Gulp Tasks
 */

'use strict';

var gulp        = require('gulp');
var $           = require('gulp-load-plugins')({ lazy: true });
var del         = require('del');
var runSequence = require('run-sequence');
var browserSync = require('browser-sync');
var pagespeed   = require('psi');
var rjs         = $.r || require('gulp-r');
var path        = require('path');
var fs          = require('fs');
var reload      = browserSync.reload;
var _           = require('lodash');
var helpers     = require('./tasks/lib/helpers.js');
var server      = require('tiny-lr')();

var AUTOPREFIXER_BROWSERS = [
  'ie >= 8',
  'ie_mob >= 10',
  'ff >= 30',
  'chrome >= 34',
  'safari >= 7',
  'opera >= 23',
  'ios >= 6',
  'android >= 4.4',
  'bb >= 10'
];

var rjsConfig = {
  baseUrl: path.join(__dirname, 'source', 'js'),
  paths: {
    jquery: '../../bower_components/jquery/dist/jquery.min'
  }
};

var resources = {
  scss: 'source/css/**/*.scss',
  css: 'source/css/**/*.css',
  scripts: [ 'source/js/**/*.js', '!require.js' ],
  vendorScripts: [
    'bower_components/requirejs/require.js',
    'bower_components/matchmedia/matchMedia.js'
  ],
  images: 'source/images/**/*',
  php: 'source/**/*.php',
  fonts: 'source/fonts/**/*',
  themeJSON: './theme.json',
  packageJSON: './package.json',
  bowerJSON: './bower.json',
  misc: [ 'source/*', '!source/*.php', './theme.json' ]
};

// Watcher task, benevolently minding your files and responding to changes in them.
gulp.task('watch', function() {
  var port = 35729;

  $.livereload.listen(port);

  gulp.watch(resources.scss, [ 'styles' ]);
  gulp.watch(resources.css, [ 'copy' ]);
  gulp.watch(resources.images, [ 'images' ]);
  gulp.watch(resources.scripts, [ 'scripts' ]);
  gulp.watch(resources.php, [ 'php' ]);
  gulp.watch(resources.fonts, [ 'fonts' ]);
  gulp.watch(resources.themeJSON, [ 'styles' ]);
});

// Lint JavaScript
gulp.task('jshint', function() {
  return gulp.src(resources.scripts)
    .pipe(reload({stream: true, once: true}))
    .pipe($.jshint)
    .pipe($.jshint.reporter('jshint-stylish'))
    .pipe($.if(!browserSync.active, $.jshint.reporter('fail')));
});

// Optimize images
gulp.task('images', function() {
  return gulp.src(resources.images)
    .pipe($.cache($.imagemin({
      progressive: true,
      interlaced: true
    })))
    .pipe(gulp.dest('build/images'))
    .pipe($.livereload({ auto: false }))
    .pipe($.size({title: 'copy'}));
});

// Copy all files at the root level
gulp.task('copy', function() {
  return gulp.src(resources.misc, { dot: true })
    .pipe(gulp.dest('build'))
    .pipe($.livereload({ auto: false }))
    .pipe($.size({title: 'copy'}));
});

// Copy fonts to build folder
gulp.task('fonts', function() {
  return gulp.src(resources.fonts)
    .pipe(gulp.dest('build/fonts'))
    .pipe($.livereload({ auto: false }))
    .pipe($.size({title: 'fonts'}));
});

// Compile and optimize stylesheets
gulp.task('styles', function() {
  var themeData   = require(resources.themeJSON);
  var styleHeader = _.template([
    '/*',
    'Theme Name: <%= themeName %>',
    'Description: <%= description %>',
    'Author: <%= author %>',
    'Author URI: <%= authorUri %>',
    'Version: <%= version %>',
    'Tags: <%= tags.join(", ") %>',
    '*/',
    "\n"
  ].join("\n"), themeData);

  var mainFilter = $.filter(function(file) {
    return (/style\.s?css/).test(file.path.toString());
  });

  return gulp.src(resources.scss)
    .pipe(helpers.log('Compiling SCSS'.yellow))
    .pipe($.rubySass({
      style: 'expanded',
      precision: 10,
      loadPath: ['source/css']
    }))
    .on('error', console.error.bind(console))
    .pipe($.pleeease())
    .pipe(gulp.dest('build/css'))
    .pipe($.size({ title: 'scss' }))
    .pipe(helpers.log('Adding theme metadata'.yellow))
    .pipe($.livereload({ auto: false }))
    .pipe(mainFilter)
      .pipe($.insert.prepend(styleHeader))
      .pipe(gulp.dest('build'));
});

gulp.task('php', function() {
  return gulp.src(resources.php)
    .pipe(gulp.dest('build/'))
    .pipe($.livereload({ auto: false }))
    .pipe($.size({ title: 'php' }));
});

gulp.task('bower:install', function() {
  return $.bower()
    .pipe(gulp.dest('bower_components'));
});

gulp.task('scripts', [ 'scripts:vendor' ], function() {
  var mainFilter = $.filter(function(file) {
    return (/main(\.min)?\.js$/).test(file.path);
  });

  gulp.src(resources.scripts)
    .pipe(mainFilter)
      .pipe(rjs(rjsConfig))
      .pipe($.rename({ extname: '.min.js' }))
      .pipe(gulp.dest('build/js'));
  return mainFilter.restore({ end: true })
    .pipe($.rename({ extname: '.min.js' }))
    .pipe($.livereload({ auto: false }))
    .pipe(gulp.dest('build/js'));
});

gulp.task('scripts:vendor', ['bower:install'], function() {
  return gulp.src(resources.vendorScripts)
    .pipe(gulp.dest('build/js'))
    .pipe($.size({ title: 'vendorScripts' }));
});

gulp.task('clean', del.bind(null, ['.tmp', 'build']));

gulp.task('default', ['clean'], function(cb) {
  runSequence('styles', 'bower:install', [ 'images', 'copy', 'php', 'fonts', 'scripts' ], cb);
});

// Load custom, per-project tasks from tasks folder
try {
  require('require-dir')('tasks');
} catch (err) {
  console.error(err);
}
