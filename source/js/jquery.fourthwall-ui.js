/**
 * Fourth Wall Events
 * UI Functions
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
        'Snap',
        'bragi',
        'jquery.fourthwall-util'
      ], factory);
    } else {
      return factory(root.jQuery);
    }
  };

  initialize(window, function($, config, forEach, Snap, logger) {

    return $.fn.extend({

      toggleNav: function(container, svg) {
        var $hamburger = this;
        var $container = $(container);
        var $svg       = Snap(svg);

        $hamburger.on('click', function(evt) {
          var animatePaths = function(path, index) {
            var nthChild = index + 1;
            var element  = $svg.select('path:nth-child(' + nthChild + ')');
            element.animate({ d: path }, config.svg.animation.speed);
          };

          logger.log('nav', 'toggling');
          $container.add($hamburger).toggleClass('menu-open');

          if ($hamburger.hasClass('menu-open')) {
            logger.log('svg', 'animating to X');
            forEach(config.svg.paths.close, animatePaths);
            $svg.select('g').animate({
              stroke: config.colors.text
            }, config.svg.animation.speed);
          } else {
            logger.log('svg', 'animating to hamburger');
            forEach(config.svg.paths.burger, animatePaths);
            $svg.select('g').animate({
              stroke: config.colors.blue
            }, config.svg.animation.speed);
          }

          return false;
        });


        return this;
      }

    });
  });
})(window);
