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

var localConfig     = secrets.servers.dev;
var remoteConfig    = secrets.servers.staging;

var commandTemplate = function(parts, bindings) {
  if (_.isString(parts)) {
    return _.template(parts, bindings);
  }

  return _.template(parts.join(' '), bindings);
};

var remoteShell = function(command) {
  var tpl = "ssh -p <%= port %> <%= username %>@<%= hostname %> '<%= command %>'";
  var cmd = _.template(tpl, {
    port: remoteConfig.ssh.port,
    username: remoteConfig.ssh.username,
    hostname: remoteConfig.ssh.hostname,
    command: command
  });
  return shell(cmd);
};

var mysqlQuery = function(query, remote) {
  if (_.isUndefined(remote)) {
    remote = false;
  }

  var conf    = remote ? remoteConfig : localConfig;
  var command = commandTemplate([
    'mysql',
    '--user="<%= username %>"',
    '--password="<%= password %>"',
    "--execute=\\'<%= query %>\\'",
    "--database=\\'<%= database %>\\'"
  ], {
    query: query,
    username: conf.mysql.username,
    password: conf.mysql.password,
    database: conf.mysql.database
  });

  console.log(command);

  return command;
};

gulp.task('db:up', function() {
  gutil.log('Syncing database up to staging...'.blue);

  var localConfig  = secrets.servers.dev;
  var remoteConfig = secrets.servers.staging;

  var mysqlDumpCmd = commandTemplate([
    'mysqldump',
    '--user="<%= username %>"',
    '--password="<%= password %>"',
    '<%= database %>',
    '|',
    'gzip',
    '>',
    '/tmp/<%= database %>.sql.gz'
  ], {
    username: localConfig.mysql.username,
    password: localConfig.mysql.password,
    database: localConfig.mysql.database
  });

  var scpCmd = commandTemplate([
    'scp',
    '-P <%= port %>',
    '/tmp/<%= database %>.sql.gz',
    '<%= username %>@<%= hostname %>:/tmp/'
  ], {
    port: remoteConfig.ssh.port,
    database: localConfig.mysql.database,
    username: remoteConfig.ssh.username,
    hostname: remoteConfig.ssh.hostname
  });

  var loadDumpCmd = commandTemplate([
    'zcat',
    '/tmp/<%= database %>.sql.gz',
    '|',
    'mysql',
    '--user="<%= username %>"',
    '--password="<%= password %>"',
    '<%= remoteDatabase %>'
  ], {
    database: localConfig.mysql.database,
    username: remoteConfig.mysql.username,
    password: remoteConfig.mysql.password,
    remoteDatabase: remoteConfig.mysql.database
  });

  var optionsQuery = 'UPDATE wp_options SET option_value = "http://' + remoteConfig.url + '" ';
  optionsQuery    += 'WHERE option_name = "home" OR option_name = "siteurl"';

  var postGuidsQuery = 'UPDATE wp_posts SET guid = REPLACE(guid, "http://' + localConfig.url;
  postGuidsQuery    += '", "http://';
  postGuidsQuery    += remoteConfig.url + '")';

  var postContentQuery = 'UPDATE wp_posts SET post_content = REPLACE(post_content, "http://' + localConfig.url + '" ';
  postContentQuery    += '", "http://';
  postContentQuery    += remoteConfig.url + '")';


  return gulp.src('')
    .pipe(shell(mysqlDumpCmd))
    .pipe(shell(scpCmd))
    .pipe(remoteShell(loadDumpCmd))
    .pipe(remoteShell(mysqlQuery(optionsQuery, true)))
    .pipe(remoteShell(mysqlQuery(postGuidsQuery, true)))
    .pipe(remoteShell(mysqlQuery(postContentQuery, true)));
});

gulp.task('db:down', function() {
  gutil.log('Syncing staging database down to localhost...'.blue);

  var config    = secrets.servers.staging;
  var devConfig = secrets.servers.dev;

  var mysqlDumpCmd = commandTemplate([
    'mysqldump',
    '--user="<%= username %>"',
    '--password="<%= password %>"',
    "<%= database %>",
    "|",
    "gzip",
    ">",
    "/tmp/<%= database %>.sql.gz"
  ], {
    username: config.mysql.username,
    password: config.mysql.password,
    database: config.mysql.database
  });

  var scpCmd = commandTemplate([
    'scp',
    '-P',
    config.ssh.port,
    '<%= username %>@<%= hostname %>:/tmp/<%= database %>.sql.gz',
    '/tmp/'
  ], {
    username: config.ssh.username,
    hostname: config.ssh.hostname,
    database: config.mysql.database
  });

  var mysqlLoadCmd = commandTemplate([
    'zcat',
    '<%= filename %>',
    '|',
    'mysql',
    '--user="<%= username %>"',
    '--password="<%= password %>"',
    '<%= database %>'
  ], {
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
    .pipe(remoteShell(mysqlDumpCmd))
    .pipe(shell(scpCmd))
    .pipe(shell(mysqlLoadCmd))
    .pipe(shell(mysqlQuery(optionsQuery)))
    .pipe(shell(mysqlQuery(postGuids)))
    .pipe(shell(mysqlQuery(postContent)));
});
