/* jshint -W097 */

'use strict';

var secrets    = require('../secrets.json');
var gulp       = require('gulp');
var shell      = require('gulp-shell');
var colors     = require('colors');
var path       = require('path');
var fs         = require('fs');
var gutil      = require('gulp-util');
var mysql      = require('mysql');
var async      = require('async');
var _          = require('lodash');

gulp.task('db:up', function() {
  gutil.log('Syncing database up to staging...'.blue);

  gutil.log('Done!'.green);
});

gulp.task('db:down', function() {
  gutil.log('Syncing staging database down to localhost...'.blue);

  var config    = secrets.servers.staging;
  var devConfig = secrets.servers.dev;

  var mysqlDumpTpl = [
    'mysqldump',
    '--user="<%= username %>"',
    '--password="<%= password %>"',
    "<%= database %>",
    "|",
    "gzip",
    ">",
    "/tmp/<%= database %>.sql.gz"
  ].join(' ');
  var mysqlDumpCmd = _.template(mysqlDumpTpl, {
    username: config.mysql.username,
    password: config.mysql.password,
    database: config.mysql.database
  });

  var sshTpl = [
    'ssh',
    '-p',
    config.ssh.port,
    '<%= username %>@<%= hostname %>',
    "'<%= command %>'"
  ].join(' ');
  var sshCmd = _.template(sshTpl, {
    username: config.ssh.username,
    hostname: config.ssh.hostname,
    command: mysqlDumpCmd
  });

  var scpTpl = [
    'scp',
    '-P',
    config.ssh.port,
    '<%= username %>@<%= hostname %>:/tmp/<%= database %>.sql.gz',
    '/tmp/'
  ].join(' ');
  var scpCmd = _.template(scpTpl, {
    username: config.ssh.username,
    hostname: config.ssh.hostname,
    database: config.mysql.database
  });

  var mysqlLoadTpl = [
    'zcat',
    '<%= filename %>',
    '|',
    'mysql',
    '--user="<%= username %>"',
    '--password="<%= password %>"',
    '<%= database %>'
  ].join(' ');
  var mysqlLoadCmd = _.template(mysqlLoadTpl, {
    filename: '/tmp/' + config.mysql.database + '.sql.gz',
    username: devConfig.mysql.username,
    password: devConfig.mysql.password,
    database: devConfig.mysql.database
  });

  var mysqlQueryCmd = function(query) {
    var commandTpl = [
      'echo',
      '"<%= query %>"',
      '|',
      'mysql',
      '--user="<%= username %>"',
      '--password="<%= password %>"',
      '<%= database %>'
    ].join(' ');

    return _.template(commandTpl, {
      query: query,
      username: devConfig.mysql.username,
      password: devConfig.mysql.password,
      database: devConfig.mysql.database
    });
  };

  var optionsQuery = "UPDATE wp_options SET option_value = 'http://";
  optionsQuery    += devConfig.url;
  optionsQuery    += "' WHERE option_name = 'home' OR option_name = 'siteurl';";

  var postGuids = "UPDATE wp_posts SET guid = REPLACE(guid, 'http://";
  postGuids    += config.url;
  postGuids    += "', 'http://";
  postGuids    += devConfig.url;
  postGuids    += "');";

  var postContent = "UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://";
  postContent += config.url;
  postContent += "', 'http://";
  postContent += devConfig.url;
  postContent += "');";

  return gulp.src('')
    .pipe(shell(sshCmd))
    .pipe(shell(scpCmd))
    .pipe(shell(mysqlLoadCmd))
    .pipe(shell(mysqlQueryCmd(optionsQuery)))
    .pipe(shell(mysqlQueryCmd(postGuids)))
    .pipe(shell(mysqlQueryCmd(postContent)));
});
