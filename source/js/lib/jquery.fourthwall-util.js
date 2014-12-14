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
  var assign = require('lodash.assign');

  // Private helper functions
  var wrapClassTransition = function wrapClassTransition(method) {
    method = method ? method : 'toggleClass';

    return function(klass, callback) {
      callback = (typeof callback === 'function') ? callback : $.noop;
      return $(this).afterTransition(callback, true)[method](klass);
    };
  };

  // jQuery instance methods
  module.exports = $.fn.extend({

    afterTransition: function(callback, once) {
      callback = $.isFunction(callback) ? callback : $.noop;
      once     = once ? true : false;

      return $(this).on('transitionend webkitTransitionEnd', function transCallback(evt) {
        if (once) {
          $(this).off('transitionend webkitTransitionEnd', transCallback);
        }

        callback.call($(this), evt);
      });
    },
    transAddClass:    wrapClassTransition('addClass'),
    transRemoveClass: wrapClassTransition('removeClass'),
    transToggleClass: wrapClassTransition('toggleClass'),

    verticallyCenter: function(options) {
      var defaults = {
        property: 'paddingTop'
      };

      var opts            = assign(defaults, options);

      return this.each(function() {
        var $root           = $(this);
        var $children       = $root.children();
        var rootHeight      = $root.innerHeight();
        var childrenHeights = 0;

        $children.each(function() {
          childrenHeights += $(this).height();
        });

        var topPad = ( rootHeight - childrenHeights ) / 2;

        $root.css(opts.property, '' + topPad + 'px');
      });
    }

  });

})(window);
