/* jshint -W097 */

'use strict';
var gulp   = require('gulp');
var colors = require('colors');
var path   = require('path');
var rsync  = require('rsyncwrapper').rsync;
var gutil  = require('gulp-util');

gulp.task('sync:up', function() {
  console.log('Syncing Up...'.blue);

  var subdomain  = 'fourthwall.fifthroomhosting.com';
  var themeSlug  = 'fourthwall';
  var buildDir   = path.join(__dirname, '..', 'build/');
  var remotePath = path.join(
    'frcweb@fifthroomcreative.com:public_html',
    subdomain,
    'public',
    'wp-content',
    'themes',
    themeSlug
  );

  rsync({
    src: buildDir,
    dest: remotePath,
    ssh: true,
    port: 31173,
    recursive: true,
    args: [ '--verbose' ],
    onStdout: function(data) {
      gutil.log(data.toString());
    },
    onStderr: function(data) {
      gutil.log(data.toString());
    }
  }, function(err) {
    if (err !== null) {
      console.error(err);
    }
  });

});
