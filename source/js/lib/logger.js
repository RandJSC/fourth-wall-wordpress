/**
 * Fourth Wall Events
 * Debug Logger Compatibility Layer
 *
 * (fixes IE 9 being a big baby about not having window.console)
 */

(function(window, undefined) {

  'use strict';

  var ie     = require('./ie-detect');
  var assign = require('lodash.assign');

  var Logger = (function() {
    var instance;
    var defaults = {
      disabled: false
    };

    var LoggerInstance = function(opts) {
      var noop     = function() {};

      this.options = assign(defaults, opts);
      this.backend = null;

      if (!ie.isIE()) {
        this.backend = require('bragi-browser');
      } else if ('console' in window) {
        // Allows us to call `window.console.apply(...)`
        window.console.log = Function.prototype.bind.call(console.log, console);
        this.backend       = window.console;
      } else {
        this.backend = noop;
      }
    };

    LoggerInstance.prototype.log = function log() {
      if (this.options.disabled) {
        return;
      }

      return this.backend.log.apply(this.backend, arguments);
    };

    return {
      getInstance: function getInstance(opts) {
        if (instance === undefined) {
          instance = new LoggerInstance(opts);
        }

        return instance;
      }
    };
  })();

  module.exports = Logger;

})(window);
