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
var reload      = browserSync.reload;
var _           = require('lodash');

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

var resources = {
  scss: 'source/css/**/*.scss',
  css: 'source/css/**/*.css',
  scripts: 'source/js/**/*.js',
  images: 'source/images/**/*',
  php: 'source/**/*.php',
  fonts: 'source/fonts/**/*',
  themeJSON: './theme.json',
  packageJSON: './package.json',
  bowerJSON: './bower.json',
  misc: [ 'source/*', '!source/*.php' ]
};

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
    .pipe($.size({title: 'copy'}));
});

// Copy all files at the root level
gulp.task('copy', function() {
  return gulp.src(resources.misc, { dot: true })
    .pipe(gulp.dest('build'))
    .pipe($.size({title: 'copy'}));
});

// Copy fonts to build folder
gulp.task('fonts', function() {
  return gulp.src(resources.fonts)
    .pipe(gulp.dest('build/fonts'))
    .pipe($.size({title: 'fonts'}));
});

// Compile and optimize stylesheets
gulp.task('styles', function() {
  var themeData = require(resources.themeJSON);
  var styleHeader = _.template([
    '/*',
    'Theme Name: <%= themeName %>',
    'Description: <%= description %>',
    'Author: <%= author %>',
    'Author URI: <%= authorUri %>',
    'Version: <%= version %>',
    'Tags: <%= tags.join(", ") %>',
    '*/'
  ].join("\n"), themeData);
  var mainFilter = $.filter('style.css');

  return gulp.src(resources.scss)
    .pipe($.rubySass({
      style: 'expanded',
      precision: 10,
      loadPath: ['source/css']
    }))
    .on('error', console.error.bind(console))
    .pipe($.pleeease())
    .pipe(gulp.dest('build/css'))
    .pipe(mainFilter)
      .pipe($.insert.prepend(styleHeader))
      .pipe(gulp.dest('build'))
    .pipe(mainFilter.restore())
    .pipe($.size({ title: 'styles:scss', showFiles: true }));
});

gulp.task('php', function() {
  return gulp.src(resources.php)
    .pipe(gulp.dest('build/'))
    .pipe($.size({ title: 'php' }));
});

gulp.task('bower:install', function() {
  return gulp.src('').pipe($.shell('bower install'));
});

gulp.task('scripts', [ 'bower:install' ], function() {
  return gulp.src(resources.scripts)
    .pipe(rjs({
      baseUrl: path.join(__dirname, 'source', 'js')
    }))
    .pipe($.rename({ extname: '.min.js' }))
    .pipe(gulp.dest('build/js'));
});

gulp.task('clean', del.bind(null, ['.tmp', 'build']));

gulp.task('default', ['clean'], function(cb) {
  runSequence('styles', 'bower:install', [ 'images', 'copy', 'php', 'fonts' ], cb);
});

// Load custom, per-project tasks from tasks folder
try {
  require('require-dir')('tasks');
} catch (err) {
  console.error(err);
}
