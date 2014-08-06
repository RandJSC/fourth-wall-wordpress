/* jshint -W097 */

'use strict';

var secrets = require('../secrets.json');
var gulp    = require('gulp');
var colors  = require('colors');
var path    = require('path');
var shell   = require('gulp-shell');
var helpers = require('./lib/helpers.js');

gulp.task('sync:up', function() {
  console.log('Syncing Up...'.blue);

  var config   = secrets.servers.staging.rsync;
  var buildDir = path.join(__dirname, '..', 'build/');
  var rsyncCmd = helpers.commandTemplate([
    'rsync -avzr',
    '-e "ssh -p <%= staging.ssh.port %>"',
    '--delete',
    '<%= buildDir %>',
    '<%= staging.rsync.username %>@<%= staging.rsync.hostname %>:<%= staging.rsync.path %>'
  ], { buildDir: buildDir });

  return gulp.src('', { read: false })
    .pipe(shell(rsyncCmd));
});
