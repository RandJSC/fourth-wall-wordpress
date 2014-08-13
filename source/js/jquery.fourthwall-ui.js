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
        'Snap'
      ], factory);
    } else {
      return factory(root.jQuery);
    }
  };

  initialize(window, function($, config, forEach, Snap) {

    return $.fn.extend({

      toggleNav: function(container, svg) {
        var $hamburger = this;
        var $container = $(container);
        var $svg       = Snap(svg);

        $hamburger.on('click', function(evt) {
          $container.add($hamburger).toggleClass('menu-open');

          if ($hamburger.hasClass('menu-open')) {
            forEach(config.svg.paths.close, function(path, index) {
              var nthChild = index + 1;
              var element  = $svg.select('path:nth-child(' + nthChild + ')');
              element.animate({ d: path }, config.svg.animation.speed);
            });
          } else {
            forEach(config.svg.paths.burger, function(path, index) {
              var nthChild = index + 1;
              var element  = $svg.select('path:nth-child(' + nthChild + ')');
              element.animate({ d: path }, config.svg.animation.speed);
            });
          }

          return false;
        });


        return this;
      }

    });
  });
})(window);
