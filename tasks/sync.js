var gulp   = require('gulp');
var colors = require('colors');
var spawn  = require('child_process').spawn;
var path   = require('path');

gulp.task('sync:up', function() {
  console.log('Syncing Up...'.blue);

  var subdomain = 'fourthwall.fifthroomhosting.com';
  var themeSlug = 'fourthwall';
  var buildDir  = path.join(__dirname, '..', 'build/');
  var rsync     = spawn('rsync', [
    '-avzr',
    '-e',
    '"ssh -p 31173"',
    '--delete',
    buildDir,
    'frcweb@fifthroomcreative.com:public_html/' + subdomain + '/public/wp-content/themes' + themeSlug + '/'
  ]);

  rsync.stdout.on('data', function(data) {
    console.log(data);
  });

  rsync.stderr.on('data', function(data) {
    console.log(data.toString().red);
  });

  rsync.on('close', function(code) {
    console.log("rsync exited with status " + code);
  });
});
