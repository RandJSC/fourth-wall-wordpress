/* jshint -W097 */
/* jshint -W041 */

'use strict';

var secrets    = require('../secrets.json');
var gulp       = require('gulp');
var shell      = require('gulp-shell');
var colors     = require('colors');
var path       = require('path');
var fs         = require('fs');
var gutil      = require('gulp-util');
var _          = require('lodash');

var localConfig  = secrets.servers.dev;
var remoteConfig = secrets.servers.staging;

var commandTemplate = function(parts, bindings, glue) {
  if (glue == null || !_.isString(glue)) {
    glue = ' ';
  }

  if (!_.isObject(bindings)) {
    bindings = {};
  }

  bindings = _.assign({}, bindings, {
    dev: localConfig,
    staging: remoteConfig
  });

  if (_.isString(parts)) {
    return _.template(parts, bindings);
  }

  return _.template(parts.join(glue), bindings);
};

var remoteShell = function(command) {
  var escapeQuotes = function(str) {
    return str.replace(/([\'])/g, "\\$1");
  };

  var cmd = commandTemplate([
    'ssh',
    '-p',
    '<%= staging.ssh.port %>',
    '<%= staging.ssh.username %>@<%= staging.ssh.hostname %>',
    "'<%= escape(command) %>'"
  ], { command: command, escape: escapeQuotes });
  console.log(cmd);
  return shell(cmd);
};

var mysqlQuery = function(query, remote) {
  if (_.isUndefined(remote)) {
    remote = false;
  }

  var conf    = remote ? remoteConfig : localConfig;
  var command = commandTemplate([
    'mysql',
    '--user="<%= remote ? staging.mysql.username : dev.mysql.username %>"',
    '--password="<%= remote ? staging.mysql.password : dev.mysql.password %>"',
    '--execute="<%= query %>"',
    '--database="<%= remote ? staging.mysql.database : dev.mysql.database %>"'
  ], {
    query: query,
    remote: remote
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
    '--user="<%= dev.mysql.username %>"',
    '--password="<%= dev.mysql.password %>"',
    '<%= dev.mysql.database %>',
    '|',
    'gzip',
    '>',
    '/tmp/<%= dev.mysql.database %>.sql.gz'
  ]);

  var scpCmd = commandTemplate([
    'scp',
    '-P <%= staging.ssh.port %>',
    '/tmp/<%= dev.mysql.database %>.sql.gz',
    '<%= staging.ssh.username %>@<%= staging.ssh.hostname %>:/tmp/'
  ]);

  var loadDumpCmd = commandTemplate([
    '/home/frcweb/bin/wp-relocate.zsh',
    '-f /tmp/<%= dev.mysql.database %>.sql.gz',
    '-u <%= staging.mysql.username %>',
    '-p "<%= staging.mysql.password %>"',
    '-d <%= staging.mysql.database %>',
    '-o "http://<%= dev.url %>"',
    '-n "http://<%= staging.url %>"',
    '-x'
  ]);

  return gulp.src('')
    .pipe(shell(mysqlDumpCmd))
    .pipe(shell(scpCmd))
    .pipe(remoteShell(loadDumpCmd));
});

// [todo] - Use default variables in all commandTemplate calls
gulp.task('db:down', function() {
  gutil.log('Syncing staging database down to localhost...'.blue);

  var mysqlDumpCmd = commandTemplate([
    'mysqldump',
    '--user="<%= staging.mysql.username %>"',
    '--password="<%= staging.mysql.password %>"',
    "<%= staging.mysql.database %>",
    "|",
    "gzip",
    ">",
    "/tmp/<%= staging.mysql.database %>.sql.gz"
  ]);

  var scpCmd = commandTemplate([
    'scp',
    '-P',
    '<%= staging.ssh.port %>',
    '<%= staging.ssh.username %>@<%= staging.ssh.hostname %>:/tmp/<%= staging.mysql.database %>.sql.gz',
    '/tmp/'
  ]);

  var mysqlLoadCmd = commandTemplate([
    'zcat',
    '/tmp/<%= staging.mysql.database %>.sql.gz',
    '|',
    'mysql',
    '--user="<%= dev.mysql.username %>"',
    '--password="<%= dev.mysql.password %>"',
    '<%= dev.mysql.database %>'
  ]);

  var optionsQuery = commandTemplate("UPDATE wp_options SET option_value = 'http://<%= dev.url %>' WHERE option_name = 'home' OR option_name = 'siteurl';");
  var postGuids    = commandTemplate("UPDATE wp_posts SET guid = REPLACE(guid, 'http://<%= staging.url %>', 'http://<%= dev.url %>');");
  var postContent  = commandTemplate("UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://<%= staging.url %>', 'http://<%= dev.url %>');");

  return gulp.src('')
    .pipe(remoteShell(mysqlDumpCmd))
    .pipe(shell(scpCmd))
    .pipe(shell(mysqlLoadCmd))
    .pipe(shell(mysqlQuery(optionsQuery)))
    .pipe(shell(mysqlQuery(postGuids)))
    .pipe(shell(mysqlQuery(postContent)));
});
