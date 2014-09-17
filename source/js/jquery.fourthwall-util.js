/**
 * Fourth Wall Events
 * Utility Functions & Helpers
 */

/* jshint -W064 */

(function(window, undefined) {
  'use strict';

  var $      = require('jquery');
  var config = require('./config');
  var logger = require('bragi-browser');

  var wrapClassTransition = function wrapClassTransition(method) {
    method = method ? method : 'toggleClass';

    return function(klass, callback) {
      callback = (typeof callback === 'function') ? callback : $.noop;
      return $(this).afterTransition(callback, true)[method](klass);
    };
  };

  module.exports = $.fn.extend({

    afterTransition: function(callback, once) {
      once = once ? true : false;

      return $(this).on('transitionend webkitTransitionEnd', function(evt) {
        if (once) {
          $(this).off('transitionend webkitTransitionEnd');
        }

        callback.call($(this), evt);
      });
    },
    transAddClass:    wrapClassTransition('addClass'),
    transRemoveClass: wrapClassTransition('removeClass'),
    transToggleClass: wrapClassTransition('toggleClass')

  });

})(window);
