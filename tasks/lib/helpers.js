/* jshint -W097 */
/* jshint -W041 */

'use strict';

var secrets    = require('../../secrets.json');
var _          = require('lodash');
var gulp       = require('gulp');
var gutil      = require('gulp-util');
var shell      = require('gulp-shell');
var mapStream  = require('map-stream');
var Handlebars = require('handlebars');

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

  var allParts = _.isArray(parts) ? parts.join(glue) : parts;
  var template = Handlebars.compile(allParts);

  return template(bindings);
};

var remoteShell = function(command, opts) {
  var escapeQuotes = function(str) {
    return str.replace(/([\'])/g, "\\$1");
  };

  var cmd = commandTemplate([
    'ssh',
    '-p',
    '{{ staging.ssh.port }}',
    '{{ staging.ssh.username }}@{{ staging.ssh.hostname }}',
    "'{{{ command }}}'"
  ], { command: command, escape: escapeQuotes });

  return shell(cmd, opts);
};

var mysqlQuery = function(query, remote) {
  if (_.isUndefined(remote)) {
    remote = false;
  }

  var command = commandTemplate([
    'mysql',
    '--user="{{ dev.mysql.username }}"',
    '--password="{{ dev.mysql.password }}"',
    '--database="{{ dev.mysql.database }}"',
    '--execute="{{{ query }}}"'
  ], { query: query, remote: remote });

  return command;
};

var log = function(msg, once) {
  if (once == null) {
    once = true;
  }

  var times = 0;

  return mapStream(function(file, cb) {
    if (times < 1) {
      gutil.log(msg);
    }

    times++;
    cb(null, file);
  });
};

module.exports = {
  commandTemplate: commandTemplate,
  remoteShell: remoteShell,
  mysqlQuery: mysqlQuery,
  log: log
};
