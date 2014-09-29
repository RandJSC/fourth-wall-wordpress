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
var path       = require('path');

var localConfig  = secrets.servers.dev;
var remoteConfig = secrets.servers.staging;

var vagrant = {
  privateKey: path.join(process.env.HOME, '.vagrant.d', 'insecure_private_key'),
  port: localConfig.ssh.port,
  user: 'vagrant'
};

var escapeQuotes = function escapeQuotes(str) {
  return str.replace(/([\'])/g, "\\$1");
};

var commandTemplate = function commandTemplate(parts, bindings, glue) {
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

var remoteShell = function remoteShell(command, opts) {
  var cmd = commandTemplate([
    'ssh',
    '-p',
    '{{ staging.ssh.port }}',
    '{{ staging.ssh.username }}@{{ staging.ssh.hostname }}',
    "'{{{ command }}}'"
  ], { command: command, escape: escapeQuotes });

  return shell(cmd, opts);
};

var vagrantCommand = function vagrantCommand(command, opts) {
  var cmd = commandTemplate([
    'vagrant',
    'ssh',
    '--command',
    "'{{{ command }}}'"
  ], { command: command });

  return shell(cmd, opts);
};

var copyFromVagrant = function copyFromVagrant(file, dest, opts) {
  var cmd = commandTemplate([
    'scp',
    '-P {{ vagrant.port }}',
    '-o IdentityFile={{ vagrant.privateKey }}',
    '-o StrictHostKeyChecking=no',
    '-o UserKnownHostsFile=/dev/null',
    '-o PasswordAuthentication=no',
    '-o IdentitiesOnly=yes',
    '-o LogLevel=FATAL',
    '{{ vagrant.user }}@127.0.0.1:{{ file }}',
    '{{ dest }}'
  ], { vagrant: vagrant, file: file, dest: dest });

  return shell(cmd, opts);
};

var copyToVagrant = function copyToVagrant(file, dest, opts) {
  var cmd = commandTemplate([
    'scp',
    '-P {{ vagrant.port }}',
    '-o IdentityFile={{ vagrant.privateKey }}',
    '-o StrictHostKeyChecking=no',
    '-o UserKnownHostsFile=/dev/null',
    '-o PasswordAuthentication=no',
    '-o IdentitiesOnly=yes',
    '-o LogLevel=FATAL',
    '{{ file }}',
    '{{ vagrant.user }}@127.0.0.1:{{ dest }}'
  ], { vagrant: vagrant, file: file, dest: dest });

  return shell(cmd, opts);
};

var mysqlQuery = function mysqlQuery(query, remote) {
  if (_.isUndefined(remote)) {
    remote = false;
  }

  var vagrant = isVagrant();
  var command = commandTemplate([
    'mysql',
    (!vagrant ? '--host={{ dev.mysql.host }}' : ''),
    (!vagrant ? '--port={{ dev.mysql.port }}' : ''),
    '--user="{{ dev.mysql.username }}"',
    '--password="{{ dev.mysql.password }}"',
    '--database="{{ dev.mysql.database }}"',
    '--execute="{{{ query }}}"'
  ], { query: query, remote: remote });

  return command;
};

var log = function log(msg, once) {
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

var isVagrant = function isVagrant() {
  return process.env.USER === 'vagrant';
};

module.exports = {
  commandTemplate: commandTemplate,
  remoteShell: remoteShell,
  mysqlQuery: mysqlQuery,
  log: log,
  vagrantCommand: vagrantCommand,
  copyToVagrant: copyToVagrant,
  copyFromVagrant: copyFromVagrant,
  isVagrant: isVagrant
};
