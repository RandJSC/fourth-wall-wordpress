/* jshint -W097 */

'use strict';

var secrets = require('../secrets.json');
var gulp    = require('gulp');
var chalk   = require('chalk');
var path    = require('path');
var shell   = require('gulp-shell');
var helpers = require('./lib/helpers.js');

var syncTask = function syncTask(opts) {
  var config   = secrets.servers.staging.rsync;
  opts         = (typeof opts === 'undefined') ? {} : opts;
  opts.source  = opts.source ? opts.source : path.join(__dirname, '..', 'build/');
  opts.dest    = opts.dest ? opts.dest : config.path;
  opts.message = opts.message ? opts.message : 'Beginning sync task';
  opts.direction = ( opts.direction === 'down' || opts.direction === 'up' ) ? opts.direction : 'up';

  var rsyncLines = [
    'rsync -avzr',
    '-e "ssh -p <%= staging.ssh.port %>"',
    '--delete'
  ];

  if (opts.direction === 'up') {
    rsyncLines.push('<%= source %>');
    rsyncLines.push('<%= staging.rsync.username %>@<%= staging.rsync.hostname %>:<%= dest %>');
  } else {
    rsyncLines.push('<%= staging.rsync.username %>@<%= staging.rsync.hostname %>:<%= source %>');
    rsyncLines.push('<%= dest %>');
  }

  return function() {
    console.log(chalk.blue(opts.message));

    var rsyncCmd = helpers.commandTemplate(rsyncLines, {
      source: opts.source,
      dest: opts.dest
    });

    return gulp.src('', { read: false })
      .pipe(shell(rsyncCmd));
  };
};

gulp.task('sync:up', syncTask({
  message: 'Syncing UP...'
}));

gulp.task('uploads:up', syncTask({
  source: '/home/vagrant/www/wp-content/uploads/',
  dest: 'public_html/fourthwall.fifthroomhosting.com/public/wp-content/uploads/',
  message: 'Syncing uploads UP...'
}));

gulp.task('uploads:down', syncTask({
  source: 'public_html/fourthwall.fifthroomhosting.com/public/wp-content/uploads/',
  dest: '/home/vagrant/www/wp-content/uploads/',
  message: 'Syncing uploads DOWN...',
  direction: 'down'
}));

gulp.task('plugins:up', syncTask({
  source: '/home/vagrant/www/wp-content/plugins/',
  dest: 'public_html/fourthwall.fifthroomhosting.com/public/wp-content/plugins/',
  message: 'Syncing plugins UP...',
  direction: 'up'
}));

gulp.task('plugins:down', syncTask({
  source: 'public_html/fourthwall.fifthroomhosting.com/public/wp-content/plugins/',
  dest: '/home/vagrant/www/wp-content/plugins/',
  message: 'Syncing plugins DOWN...',
  direction: 'down'
}));
