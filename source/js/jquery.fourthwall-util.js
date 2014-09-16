/**
 * Fourth Wall Events
 * Utility Functions & Helpers
 */

/* jshint -W064 */

(function(window, undefined) {
  'use strict';

  var initialize = function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      return define([
        'jquery',
        'config',
        'lodash/collections/forEach',
        'bragi'
      ], factory);
    }

    return factory(root.jQuery);
  };

  initialize(window, function($, config, forEach, logger) {

    var wrapClassTransition = function wrapClassTransition(method) {
      method = method ? method : 'toggleClass';

      return function(klass, callback) {
        callback = (typeof callback === 'function') ? callback : $.noop;
        return $(this).afterTransition(callback, true)[method](klass);
      };
    };

    return $.fn.extend({

      afterTransition: function(callback, once) {
        once = once ? true : false;

        return $(this).on('transitionend webkitTransitionEnd', function(evt) {
          if (once) {
            $(this).off('transitionend webkitTransitionEnd');
          }

          callback.call($(this), evt);
        });
      },

      transAddClass: wrapClassTransition('addClass'),

      transRemoveClass: wrapClassTransition('removeClass'),

      transToggleClass: wrapClassTransition('toggleClass')

    });

  });

})(window);
