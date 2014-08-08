/* jshint -W097 */

'use strict';

var gulp     = require('gulp');
var colors   = require('colors');
var zip      = require('gulp-zip');
var helpers  = require('./lib/helpers.js');
var theme    = require('../theme.json');
var _        = require('lodash');
var source   = 'build/**/*';
var filename = _.template('<%= theme.slug %>-<%= theme.version %>.zip', { theme: theme });

gulp.task('zip', function() {
  return gulp.src(source)
    .pipe(helpers.log(('Saving to dist/' + filename).cyan))
    .pipe(zip(filename))
    .pipe(gulp.dest('dist'));
});
