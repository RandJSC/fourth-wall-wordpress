/* jshint -W097 */
/* jshint -W041 */

'use strict';

var secrets = require('../secrets.json');
var gulp    = require('gulp');
var shell   = require('gulp-shell');
var colors  = require('colors');
var path    = require('path');
var fs      = require('fs');
var gutil   = require('gulp-util');
var _       = require('lodash');
var helpers = require('./lib/helpers.js');

var localConfig  = secrets.servers.dev;
var remoteConfig = secrets.servers.staging;

gulp.task('db:up', function() {
  gutil.log('Syncing database up to staging...'.blue);

  var localConfig  = secrets.servers.dev;
  var remoteConfig = secrets.servers.staging;

  var mysqlDumpCmd = helpers.commandTemplate([
    'mysqldump',
    '--user="<%= dev.mysql.username %>"',
    '--password="<%= dev.mysql.password %>"',
    '<%= dev.mysql.database %>',
    '|',
    'gzip',
    '>',
    '/tmp/<%= dev.mysql.database %>.sql.gz'
  ]);

  var scpCmd = helpers.commandTemplate([
    'scp',
    '-P <%= staging.ssh.port %>',
    '/tmp/<%= dev.mysql.database %>.sql.gz',
    '<%= staging.ssh.username %>@<%= staging.ssh.hostname %>:/tmp/'
  ]);

  var loadDumpCmd = helpers.commandTemplate([
    'bin/wp-relocate.zsh',
    '-f /tmp/<%= dev.mysql.database %>.sql.gz',
    '-u <%= staging.mysql.username %>',
    '-p "<%= staging.mysql.password %>"',
    '-d <%= staging.mysql.database %>',
    '-o "http://<%= dev.url %>"',
    '-n "http://<%= staging.url %>"',
    '-x'
  ]);

  return gulp.src('')
    .pipe(helpers.log('Dumping local database'.yellow))
    .pipe(shell(mysqlDumpCmd, { quiet: true }))
    .pipe(helpers.log('Uploading to staging'.yellow))
    .pipe(shell(scpCmd, { quiet: true }))
    .pipe(helpers.log('Loading database dump on staging'.yellow))
    .pipe(helpers.remoteShell(loadDumpCmd, { quiet: true }))
    .pipe(helpers.log('Done!'.green));
});

gulp.task('db:down', function() {
  gutil.log('Syncing staging database down to localhost...'.blue);

  var mysqlDumpCmd = helpers.commandTemplate([
    'mysqldump',
    '--user="<%= staging.mysql.username %>"',
    '--password="<%= staging.mysql.password %>"',
    "<%= staging.mysql.database %>",
    "|",
    "gzip",
    ">",
    "/tmp/<%= staging.mysql.database %>.sql.gz"
  ]);

  var scpCmd = helpers.commandTemplate([
    'scp',
    '-P',
    '<%= staging.ssh.port %>',
    '<%= staging.ssh.username %>@<%= staging.ssh.hostname %>:/tmp/<%= staging.mysql.database %>.sql.gz',
    '/tmp/'
  ]);

  var mysqlLoadCmd = helpers.commandTemplate([
    'zcat',
    '/tmp/<%= staging.mysql.database %>.sql.gz',
    '|',
    'mysql',
    '--user="<%= dev.mysql.username %>"',
    '--password="<%= dev.mysql.password %>"',
    '<%= dev.mysql.database %>'
  ]);

  var optionsQuery = helpers.commandTemplate("UPDATE wp_options SET option_value = 'http://<%= dev.url %>' WHERE option_name = 'home' OR option_name = 'siteurl';");
  var postGuids    = helpers.commandTemplate("UPDATE wp_posts SET guid = REPLACE(guid, 'http://<%= staging.url %>', 'http://<%= dev.url %>');");
  var postContent  = helpers.commandTemplate("UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://<%= staging.url %>', 'http://<%= dev.url %>');");

  return gulp.src('')
    .pipe(helpers.log('Dumping remote database'.yellow))
    .pipe(helpers.remoteShell(mysqlDumpCmd, { quiet: true }))
    .pipe(helpers.log('Downloading remote database dump'.yellow))
    .pipe(shell(scpCmd, { quiet: true }))
    .pipe(helpers.log('Loading database dump'.yellow))
    .pipe(shell(mysqlLoadCmd, { quiet: true }))
    .pipe(helpers.log('Changing URLs in database'.yellow))
    .pipe(shell(helpers.mysqlQuery(optionsQuery), { quiet: true }))
    .pipe(shell(helpers.mysqlQuery(postGuids), { quiet: true }))
    .pipe(shell(helpers.mysqlQuery(postContent), { quiet: true }))
    .pipe(helpers.log('Done!'.green));
});
