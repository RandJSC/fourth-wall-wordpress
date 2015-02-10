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
var rjs         = $.r || require('gulp-r');
var path        = require('path');
var fs          = require('fs');
var _           = require('lodash');
var helpers     = require('./tasks/lib/helpers.js');
var server      = require('tiny-lr')();
var pngcrush    = require('imagemin-pngcrush');
var chalk       = require('chalk');
var exorcist    = require('exorcist');
var transform   = require('vinyl-transform');
var glob        = require('glob');
var notifier    = require('node-notifier');

// All optimizations are turned on by default. Pass --dev to
// enable the creation of source maps and other things that
// take up lots of space.
var isProduction = true;

if ($.util.env.dev) {
  isProduction = false;
}

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

var baseUrl  = 'http://' + (isProduction ? 'fourthwall.fifthroomhosting.com' : 'localhost:8888') + '/wp-content/themes/fourthwall';
var webPaths = {
  js: baseUrl + '/js'
};

var browserifyConfig = {
  insertGlobals: !isProduction,
  debug: true
};

var sassConfig = {
  style: isProduction ? 'compressed' : 'expanded',
  lineNumbers: !isProduction,
  debugInfo: !isProduction,
  precision: 10,
  loadPath: [
    'source/css'
  ]
};

var resources = {
  scss: 'source/css/**/*.scss',
  css: 'source/css/**/*.css',
  vendorStyles: [
    'node_modules/font-awesome/css/font-awesome.min.css'
  ],
  scripts: [ 'source/js/**/*.js' ],
  vendorScripts: [],
  standaloneScripts: [
    'source/js/modernizr.js',
    'source/js/modernizr-tests.js',
    'source/js/matchMedia.js'
  ],
  images: 'source/img/**/*.{png,jpg,gif,svg}',
  vendorImages: [
    'node_modules/slick-carousel/slick/ajax-loader.gif'
  ],
  svgs: 'source/img/**/*.svg',
  php: 'source/**/*.php',
  fonts: 'source/fonts/**/*',
  vendorFonts: [
    'node_modules/font-awesome/fonts/*',
    'node_modules/slick-carousel/slick/fonts/*'
  ],
  themeJSON: './theme.json',
  packageJSON: './package.json',
  composerJSON: './composer.json',
  misc: [ 'source/*', '!source/*.php', './theme.json' ]
};

// Pop a notification on error
gulp.on('error', function onError(err) {
  notifier.notify({
    title: 'Gulp Error!',
    message: err.message
  });
  $.util.log(chalk.bold(chalk.red('ERROR: ')) + err.message);
});

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
  'styles:vendor': 'Copy stylesheets from node_modules to build/css',
  'scsslint': 'Check SCSS syntax for best practices',
  'php': 'Copy PHP files to build folder',
  'scripts': 'Optimize AMD modules and copy scripts to build/js',
  'scripts:vendor': 'Copy needed scripts from node_modules to build/js',
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
  //var port = 35729;
  //$.livereload.listen(port);

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
    .pipe($.jshint)
    .pipe($.jshint.reporter('jshint-stylish'));
});

// Run all image related tasks
gulp.task('images', function(cb) {
  runSequence('images:vendor', 'images:optimize', 'images:rasterize');
  cb();
});

// Optimize images
gulp.task('images:optimize', [ 'images:vendor' ], function() {
  return gulp.src(resources.images)
    .pipe($.imagemin({
      progressive: true,
      svgoPlugins: [ { removeViewBox: false } ]
    }))
    .pipe(gulp.dest('build/img'))
    //.pipe($.livereload({ auto: false }))
    .pipe($.size({title: 'copy'}));
});

gulp.task('images:vendor', function() {
  if (!resources.vendorImages.length) {
    console.log(chalk.cyan('No vendor images. Skipping.'));
    return;
  }

  return gulp.src(resources.vendorImages)
    .pipe(gulp.dest('build/img'));
});

gulp.task('images:rasterize', function() {
  return gulp.src(resources.svgs)
    .pipe($.rsvg({ scale: 4, format: 'png' }))
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

gulp.task('fonts:vendor', function() {
  if (!resources.vendorFonts.length) {
    console.log(chalk.cyan('No vendor fonts. Skipping.'));
    return;
  }

  return gulp.src(resources.vendorFonts)
    .pipe(gulp.dest('build/fonts'));
});

// Compile and optimize stylesheets
gulp.task('styles', [ 'styles:vendor' ], function() {
  del.sync(['build/css/*.map']);

  return gulp.src(resources.scss)
    .pipe(helpers.log(chalk.yellow('Compiling SCSS')))
    .pipe($.rubySass(sassConfig))
    .on('error', console.error.bind(console))
    .pipe($.if(isProduction, $.sourcemaps.init()))
    .pipe($.if(isProduction, $.pleeease()))
    .pipe($.if(isProduction, $.sourcemaps.write()))
    .pipe(gulp.dest('build/css'))
    .pipe($.size({ title: 'scss' }));
});

gulp.task('styles:vendor', function() {
  if (!resources.vendorStyles.length) {
    $.util.log(chalk.cyan('No vendor styles. Skipping.'));
    return;
  }

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

gulp.task('php', function(cb) {
  runSequence('php:copy', 'php:composer');
  cb();
});

gulp.task('php:copy', function() {
  return gulp.src(resources.php)
    .pipe(gulp.dest('build'))
    .pipe($.size({ title: 'php' }));
});

gulp.task('php:composer', function() {
  return gulp.src('')
    .pipe($.shell('php composer.phar install'));
});

gulp.task('scripts', function(cb) {
  runSequence(
    [ 'scripts:vendor', 'scripts:copy' ],
    'scripts:main',
    'scripts:eventMap',
    'sourcemaps:fix'
  );
  cb();
});

gulp.task('scripts:main', function() {
  return gulp.src('source/js/main.js')
    .pipe($.browserify(browserifyConfig))
    .pipe(transform(function() { return exorcist('build/js/main.browserify.map'); }))
    .pipe($.if(isProduction, $.uglifyjs({
      inSourceMap: 'main.browserify.map',
      outSourceMap: 'main.js.map',
      sourceRoot: webPaths.js
    })))
    .pipe(gulp.dest('build/js'))
    .pipe($.if(isProduction, $.gzip({ gzipOptions: { level: 9 } })))
    .pipe($.size({ title: 'main-js' }))
    .pipe(gulp.dest('build/js'));
});

gulp.task('scripts:eventMap', function() {
  return gulp.src('source/js/event-map.js')
    .pipe($.browserify(browserifyConfig))
    .pipe(transform(function() { return exorcist('build/js/event-map.browserify.map'); }))
    .pipe($.if(isProduction, $.uglifyjs({
      inSourceMap: 'event-map.browserify.map',
      outSourceMap: 'event-map.map',
      sourceRoot: webPaths.js
    })))
    .pipe(gulp.dest('build/js'))
    .pipe($.if(isProduction, $.gzip({ gzipOptions: { level: 9 } })))
    .pipe($.size({ title: 'event-map.js' }))
    .pipe(gulp.dest('build/js'));
});

gulp.task('scripts:vendor', function() {
  if (!resources.vendorScripts.length) {
    $.util.log(chalk.cyan('No vendor scripts to copy. Skipping.'));
    return;
  }

  return gulp.src(resources.vendorScripts)
    .pipe(gulp.dest('build/js'))
    .pipe($.size({ title: 'vendorScripts' }));
});

gulp.task('scripts:copy', function() {
  del.sync(['build/js/*.map']);

  return gulp.src(resources.standaloneScripts)
    .pipe($.if(isProduction, $.uglifyjs('bundle.js', {
      outSourceMap: true,
      sourceRoot: webPaths.js
    }), $.concat('bundle.js')))
    .pipe($.size({ title: 'uglified-js' }))
    .pipe(gulp.dest('build/js'));
});

gulp.task('sourcemaps:fix', function(cb) {
  var maps    = glob.sync('build/js/*.map');
  var pathReg = /(js\/.+)$/;

  $.util.log(chalk.magenta('Fixing file paths in source maps...'));

  if (maps.length) {
    _.forEach(maps, function(map, idx) {
      var json = JSON.parse(fs.readFileSync(map));

      if (!json.sources.length) return;

      json.sources = _.map(json.sources, function(src) {
        var matches = src.match(pathReg);

        if (!matches || matches.length < 2) return src;

        var endPath = matches[1];
        var fullUrl = baseUrl + '/' + endPath;

        return fullUrl;
      });

      var fileData = JSON.stringify(json);

      fs.writeFileSync(map, fileData);

      $.util.log(chalk.green('Fixed: ') + map);
    });
  } else {
    $.util.log(chalk.magenta('No source maps found. Skipping.'));
  }

  cb();
});

gulp.task('totalsize', function() {
  return gulp.src('build/**/*')
    .pipe($.size({ title: 'grand total' }));
});

gulp.task('clean', del.bind(null, ['.tmp', 'build']));

gulp.task('default', ['clean'], function(cb) {
  runSequence('styles', [ 'images', 'copy', 'php', 'fonts', 'scripts' ], 'totalsize', cb);
});

// Load custom, per-project tasks from tasks folder
try {
  require('require-dir')('tasks');
} catch (err) {
  console.error(err);
}

module.exports = gulp;
