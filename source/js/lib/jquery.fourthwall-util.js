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
        property: 'paddingTop',
        height: 'sum'
      };

      var opts = assign(defaults, options);

      return this.each(function() {
        var $root           = $(this);
        var $children       = $root.children();
        var rootHeight      = $root.innerHeight();
        var childrenHeights = 0;
        var tallestHeight   = 0;

        if (opts.height === 'sum') {
          $children.each(function() {
            childrenHeights += $(this).height();
          });
        } else if (opts.height === 'tallest') {
          $children.each(function() {
            var height = $(this).height();

            if (height > tallestHeight) {
              tallestHeight = height;
            }
          });

          childrenHeights = tallestHeight;
        }

        logger.log('verticallyCenter', 'Vertically centering %O (%d)', $root, childrenHeights);

        var topPad = ( rootHeight - childrenHeights ) / 2;

        $root.css(opts.property, '' + topPad + 'px');
      });
    },

    newWindowIfOffsite: function() {
      var pageHost = window.location.host;

      return this.each(function() {
        var $link = $(this);

        if ($link[0].host !== pageHost) {
          logger.log('offsiteLinks', 'Binding new window click handler to %O', $link[0]);

          $link.on('click', function(evt) {
            evt.preventDefault();
            evt.stopPropagation();
            window.open( $(this).attr('href'), '_blank' );
          });
        }
      });
    },

    pngFallback: function() {
      return this.each(function() {
        var $elem = $(this);
        var bgImg = $elem.css('backgroundImage');
        var isSVG = (/\.svg/).test(bgImg);

        if ($elem.is('img')) {
          $elem.attr('src', $elem.attr('src').replace('.svg', '.png'));
        }

        if (isSVG) {
          $elem.css('backgroundImage', bgImg.replace('.svg', '.png'));
        }
      });
    }

  });

})(window);
