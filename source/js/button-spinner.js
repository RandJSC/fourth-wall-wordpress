/**
 * Fourth Wall Events
 * Button Spinner Class + jQuery Plugin
 */

/* global window, setTimeout */

(function(window, undefined) {

  'use strict';

  var Q        = require('q');
  var $        = require('jquery');
  var ui       = require('./jquery.fourthwall-ui');
  var util     = require('./jquery.fourthwall-util');
  var Spinner  = require('spin.js');
  var isString = require('lodash.isstring');
  var logger   = require('bragi-browser');

  var ButtonSpinner = function ButtonSpinner(elem, options) {
    logger.log('buttonSpinner:init', 'Initializing button spinner on element: %O', elem);

    this.opts      = $.extend({}, ButtonSpinner.defaults, options);
    this.spinning  = false;
    this.$button   = $(elem);
    this.$label    = this.$button.find('.button-label');
    this.$spinWrap = $('<span/>', { 'class': 'button-spinner' });

    logger.log('buttonSpinner:init', 'Prepending spin wrapper span to button');
    this.$button.prepend(this.$spinWrap);
  };

  ButtonSpinner.prototype.start = function start() {
    var height = this.$button.height();

    this.spinner = this._createSpinner({
      height: height,
      radius: height * 0.2,
      length: height * 0.3,
      width: 3
    });

    this.$button.prop('disabled', true).addClass('loading');
    this.spinner.spin(this.$spinWrap[0]);
    this.spinning = true;

    return this;
  };

  ButtonSpinner.prototype.stop = function stop(message) {
    var self = this;

    if (message) {
      this.$label
        .data('origText', this.$label.text())
        .text(message);
    }

    this.$button.transRemoveClass('loading', function() {
      self.$button.prop('disabled', false);
      self.spinner.stop();
      self.spinning = false;

      if (message) {
        self.labelTimeout = window.setTimeout(function() {
          self.$label.text(self.$label.data('origText'));
        }, self.opts.labelDelay);
      }
    });

    return this;
  };

  ButtonSpinner.prototype._createSpinner = function _createSpinner(params) {
    var spinParams = $.extend(ButtonSpinner.defaults.spinner, this.opts.spinner, params);
    return new Spinner(spinParams);
  };

  ButtonSpinner.dataKey = 'buttonSpinner';

  ButtonSpinner.defaults = {
    labelDelay: 4000,
    spinner: {
      color:     '#fff',
      zIndex:    'auto',
      top:       'auto',
      left:      'auto',
      className: '',
      lines:     11
    }
  };

  module.exports = ButtonSpinner;

  /**
   * jQuery Plugin Interface
   */
  $.fn.extend({
    buttonSpinner: function buttonSpinner() {
      var slice  = [].slice;
      var option = arguments[0];
      var args   = args.length >= 2 ? slice.call(arguments, 1) : [];

      this.each(function() {
        var $elem = $(this);
        var data  = $elem.data(ButtonSpinner.dataKey);

        if (!data) {
          $elem.data(ButtonSpinner.dataKey, (data = new ButtonSpinner($elem, option)));
        }

        if (isString(option)) {
          data[option].apply(data, args);
        }
      });

      return this;
    }
  });

})(window);
