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
var reload      = browserSync.reload;

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

// Lint JavaScript
gulp.task('jshint', function() {
  return gulp.src('source/js/**/*.js')
    .pipe(reload({stream: true, once: true}))
    .pipe($.jshint)
    .pipe($.jshint.reporter('jshint-stylish'))
    .pipe($.if(!browserSync.active, $.jshint.reporter('fail')));
});

// Optimize images
gulp.task('images', function() {
  return gulp.src('source/images/**/*')
    .pipe($.cache($.imagemin({
      progressive: true,
      interlaced: true
    })))
    .pipe(gulp.dest('build/images'))
    .pipe($.size({title: 'copy'}));
});

// Copy all files at the root level
gulp.task('copy', function() {
  return gulp.src(['source/*', '!source/*.html'], { dot: true })
    .pipe(gulp.dest('build'))
    .pipe($.size({title: 'copy'}));
});

// Copy fonts to build folder
gulp.task('fonts', function() {
  return gulp.src(['source/fonts/**'])
    .pipe(gulp.dest('build/fonts'))
    .pipe($.size({title: 'fonts'}));
});

// Compile and optimize stylesheets
gulp.task('styles', function() {
  return gulp.src([
      'source/styles/*.scss',
      'source/styles/**/*.css'
    ])
    .pipe($.changed('.tmp/styles', { extension: '.css' }))
    .pipe($.if('*.scss', $.rubySass({
        style: 'expanded',
        precision: 10
      }).on('error', console.error.bind(console))
    ))
    .pipe($.pleeease)
    .pipe(gulp.dest('build/css'));
});

gulp.task('clean', del.bind(null, ['.tmp', 'build']));

gulp.task('gulp-plugins', function() {
  console.log($);
});

// Load custom, per-project tasks from tasks folder
try {
  require('require-dir')('tasks');
} catch (err) {
  console.error(err);
}
