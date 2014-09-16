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
var pngcrush    = require('imagemin-pngcrush');
var chalk       = require('chalk');

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
    jquery: '../../bower_components/jquery/dist/jquery.min',
    slick: '../../bower_components/slick-carousel/slick/slick',
    lodash: '../../bower_components/lodash-amd/modern',
    Snap: '../../bower_components/Snap.svg/dist/snap.svg',
    FastClick: '../../bower_components/fastclick/lib/fastclick',
    bragi: '../../bower_components/Bragi-Browser/dist/bragi'
  }
};

var sassConfig = {
  style: 'expanded',
  precision: 10,
  loadPath: [
    'source/css'
  ]
};

var resources = {
  scss: 'source/css/**/*.scss',
  css: 'source/css/**/*.css',
  vendorStyles: [
    'bower_components/normalize.css/normalize.css'
  ],
  scripts: [ 'source/js/**/*.js', '!require.js' ],
  vendorScripts: [
    'bower_components/requirejs/require.js',
    'bower_components/matchmedia/matchMedia.js'
  ],
  images: 'source/img/**/*',
  vendorImages: [
    'bower_components/slick-carousel/slick/ajax-loader.gif'
  ],
  svgs: 'source/img/**/*.svg',
  php: 'source/**/*.php',
  fonts: 'source/fonts/**/*',
  vendorFonts: [
    'bower_components/font-awesome/fonts/*',
    'bower_components/slick-carousel/slick/fonts/*'
  ],
  themeJSON: './theme.json',
  packageJSON: './package.json',
  bowerJSON: './bower.json',
  misc: [ 'source/*', '!source/*.php', './theme.json' ]
};

// Print help text about tasks
gulp.task('help', $.helptext({
  'help': 'Print this message',
  'default': 'Delete previous build and rebuild everything',
  'watch': 'Watch source files for changes and build as necessary',
  'jshint': 'Check JavaScript syntax',
  'images': 'Optimize images and copy to build',
  'copy': 'Copy all remaining files verbatim to build folder',
  'fonts': 'Copy custom web fonts to build/fonts',
  'styles': 'Compile SCSS stylesheets',
  'styles:vendor': 'Copy stylesheets from bower_components to build/css',
  'scsslint': 'Check SCSS syntax for best practices',
  'php': 'Copy PHP files to build folder',
  'bower:install': 'Install bower packages',
  'scripts': 'Optimize AMD modules and copy scripts to build/js',
  'scripts:vendor': 'Copy needed scripts from bower to build/js',
  'clean': 'Delete build folder',
  'db:up': 'Run from inside Vagrant VM to replace staging database with the local one',
  'db:down': 'Run from inside Vagrant VM to replace local database with staging\'s',
  'ssh:keygen': 'Generate RSA public key if there is none',
  'ssh:uploadKey': 'Upload local public key to staging server for passwordless SSH access',
  'ssh:setup': 'Generate key and upload it to staging for passwordless SSH access',
  'sync:up': 'Rsync build folder up to staging',
  'bump:patch': 'Increment patch version in config files',
  'bump:minor': 'Increment minor version in config files',
  'bump:major': 'Increment major version in config files',
  'bump:reset': 'Reset theme version to 0.1.0',
  'zip': 'Zip up build folder to dist/'
}));

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
gulp.task('images', [ 'images:vendor' ], function() {
  return gulp.src(resources.images)
    .pipe($.cache($.imagemin({
      progressive: true,
      svgoPlugins: [ { removeViewBox: false } ],
      use: [ pngcrush() ]
    })))
    .pipe(gulp.dest('build/img'))
    //.pipe($.livereload({ auto: false }))
    .pipe($.size({title: 'copy'}));
});

gulp.task('images:vendor', function() {
  return gulp.src(resources.vendorImages)
    .pipe(gulp.dest('build/img'));
});

// Copy all files at the root level
gulp.task('copy', function() {
  return gulp.src(resources.misc, { dot: true })
    .pipe(gulp.dest('build'))
    //.pipe($.livereload({ auto: false }))
    .pipe($.size({title: 'copy'}));
});

// Copy fonts to build folder
gulp.task('fonts', [ 'fonts:vendor' ], function() {
  return gulp.src(resources.fonts)
    .pipe(gulp.dest('build/fonts'))
    //.pipe($.livereload({ auto: false }))
    .pipe($.size({title: 'fonts'}));
});

gulp.task('fonts:vendor', [ 'bower:install' ], function() {
  return gulp.src(resources.vendorFonts)
    .pipe(gulp.dest('build/fonts'));
});

// Compile and optimize stylesheets
gulp.task('styles', [ 'scsslint', 'styles:vendor' ], function() {
  return gulp.src(resources.scss)
    .pipe(helpers.log('Compiling SCSS'.yellow))
    .pipe($.rubySass(sassConfig))
    .on('error', console.error.bind(console))
    .pipe($.pleeease())
    .pipe(gulp.dest('build/css'))
    .pipe($.size({ title: 'scss' }));
});

gulp.task('styles:vendor', [ 'bower:install' ], function() {
  return gulp.src(resources.vendorStyles)
    .pipe(gulp.dest('build/css'));
});

gulp.task('scsslint', function() {
  return gulp.src([
    resources.scss,
    '!source/css/partials/bourbon/**/*',
    '!source/css/partials/neat/**/*',
    '!source/css/partials/font-awesome/**/*',
    '!source/css/slick.scss'
  ]).pipe($.scsslint('.scss-lint.yml')).pipe($.scsslint.reporter());
});

gulp.task('sassdoc', function() {
  return gulp.src('source/css')
    .pipe($.sassdoc({
      dest: 'doc',
      verbose: true,
      display: {
        access: [ 'public', 'private' ],
        alias: true,
        watermark: true
      },
      package: './package.json'
    }));
});

gulp.task('php', function() {
  return gulp.src(resources.php)
    .pipe(gulp.dest('build'))
    //.pipe($.livereload({ auto: false }))
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
    //.pipe($.livereload({ auto: false }))
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

module.exports = gulp;
