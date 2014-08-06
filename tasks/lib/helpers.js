/* jshint -W097 */
/* jshint -W041 */

'use strict';

var secrets   = require('../../secrets.json');
var _         = require('lodash');
var gulp      = require('gulp');
var gutil     = require('gulp-util');
var shell     = require('gulp-shell');
var mapStream = require('map-stream');

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

var remoteShell = function(command, opts) {
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

  return shell(cmd, opts);
};

var mysqlQuery = function(query, remote) {
  if (_.isUndefined(remote)) {
    remote = false;
  }

  var command = commandTemplate([
    'mysql',
    '--user="<%= dev.mysql.username %>"',
    '--password="<%= dev.mysql.password %>"',
    '--database="<%= dev.mysql.database %>"',
    '--execute="<%= query %>"'
  ], { query: query, remote: remote });

  return command;
};

var log = function(msg) {
  return mapStream(function(file, cb) {
    gutil.log(msg);
    cb(null, file);
  });
};

module.exports = {
  commandTemplate: commandTemplate,
  remoteShell: remoteShell,
  mysqlQuery: mysqlQuery,
  log: log
};
