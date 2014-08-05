/* jshint -W097 */

'use strict';
var gulp    = require('gulp');
var colors  = require('colors');
var path    = require('path');
var shell   = require('gulp-shell');
var secrets = require('../secrets.json');
var _       = require('lodash');

gulp.task('sync:up', function() {
  console.log('Syncing Up...'.blue);

  var config     = secrets.servers.staging.rsync;
  var buildDir   = path.join(__dirname, '..', 'build/');
  var commandTpl = [
    'rsync -avzr',
    '-e "ssh -p <%= port %>"',
    '--delete',
    '<%= buildDir %>',
    '<%= username %>@<%= hostname %>:<%= path %>'
  ].join(' ');
  var rsyncCmd   = _.template(commandTpl, {
    port: config.port,
    buildDir: buildDir,
    username: config.username,
    hostname: config.hostname,
    path: config.path
  });

  return gulp.src('', { read: false })
    .pipe(shell(rsyncCmd));
});
