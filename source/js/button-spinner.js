/**
 * Fourth Wall Events
 * Button Spinner Class + jQuery Plugin
 */

(function(window, undefined) {

  'use strict';

  var Q        = require('q');
  var $        = require('jquery');
  var ui       = require('./jquery.fourthwall-ui');
  var util     = require('./jquery.fourthwall-util');
  var Spin     = require('spin.js');
  var isString = require('lodash.isstring');

  var ButtonSpinner = function ButtonSpinner(elem, options) {
  
  };

  ButtonSpinner.dataKey = 'buttonSpinner';

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
