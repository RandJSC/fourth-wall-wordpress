/* jshint -W097 */

var secrets     = require('../secrets.json');
var gulp        = require('gulp');
var gutil       = require('gulp-util');
var shell       = require('gulp-shell');
var colors      = require('colors');
var path        = require('path');
var fs          = require('fs');
var runSequence = require('run-sequence');
var helpers     = require('./lib/helpers.js');

gulp.task('ssh:keygen', function() {
  var keyfile = path.join(process.env.HOME, '.ssh', 'id_rsa');

  if (!fs.existsSync(keyfile)) {
    return gulp.src('')
      .pipe(shell('ssh-keygen -t rsa -b 2048 -N "" -f ' + keyfile));
  }

  gutil.log("RSA key already exists. Skipping");
});

gulp.task('ssh:uploadKey', function() {
  var keyfile    = path.join(process.env.HOME, '.ssh', 'id_rsa.pub');
  var pubKey     = fs.readFileSync(keyfile);
  var config     = secrets.servers.staging.ssh;
  var sshCommand = helpers.commandTemplate([
    "echo '<%= key %>'",
    '|',
    'ssh -p <%= staging.ssh.port %>',
    '<%= staging.ssh.username %>@<%= staging.ssh.hostname %>',
    "'cat >> ~/.ssh/authorized_keys'"
  ], { key: pubKey });

  return gulp.src('')
    .pipe(shell(sshCommand));
});

gulp.task('ssh:setup', function() {
  runSequence('ssh:keygen', 'ssh:uploadKey', function() {
    gutil.log('All done'.green);
  });
});
