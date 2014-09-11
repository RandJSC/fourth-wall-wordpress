/* jshint -W097 */

'use strict';

var gulp     = require('gulp');
var chalk    = require('chalk');
var zip      = require('gulp-zip');
var helpers  = require('./lib/helpers.js');
var theme    = require('../theme.json');
var _        = require('lodash');
var source   = 'build/**/*';
var filename = _.template('<%= theme.slug %>-<%= theme.version %>.zip', { theme: theme });

gulp.task('zip', function() {
  return gulp.src(source)
    .pipe(helpers.log(chalk.cyan('Saving to dist/' + filename)))
    .pipe(zip(filename))
    .pipe(gulp.dest('dist'));
});
