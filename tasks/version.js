/* jshint -W097 */

var gulp = require('gulp');
var bump = require('gulp-bump');

var files = [
  './bower.json',
  './package.json',
  './composer.json',
  './theme.json'
];

gulp.task('bump:patch', function() {
  return gulp.src(files)
    .pipe(bump({ type: 'patch' }))
    .pipe(gulp.dest('./'));
});

gulp.task('bump:minor', function() {
  return gulp.src(files)
    .pipe(bump({ type: 'minor' }))
    .pipe(gulp.dest('./'));
});

gulp.task('bump:major', function() {
  return gulp.src(files)
    .pipe(bump({ type: 'major' }))
    .pipe(gulp.dest('./'));
});

gulp.task('bump:reset', function() {
  return gulp.src(files)
    .pipe(bump({ version: '0.1.0' }))
    .pipe(gulp.dest('./'));
});
