/**
 * Fourth Wall Events
 * UI Functions
 */

/* jshint -W064 */
/* global Modernizr */

(function(window, undefined) {
  'use strict';

  var forEach  = require('lodash.foreach');
  var debounce = require('lodash.debounce');
  var $        = require('jquery');
  var config   = require('./config');
  var Snap     = require('./snap.svg.custom');
  var Hammer   = require('hammerjs');
  var logger   = require('bragi-browser');
  var fweUtil  = require('./jquery.fourthwall-util');

  module.exports = $.fn.extend({

    toggleNav: function(container, svg) {
      var $hamburger = this;
      var $container = $(container);
      var $svg       = Snap(svg);
      var canSwipe   = function(recognizer, input) {
        var menuOpen = $container.hasClass('menu-open');
        var logMsg   = 'Swipe recognizer ' + (menuOpen ? 'enabled' : 'disabled');
        logger.log('touch', logMsg);
        return menuOpen;
      };

      if (Modernizr.touch) {
        logger.log('touch', 'Registering swipe handler');

        var hammertime = new Hammer.Manager($container[0], {});
        $container.data('hammertime', hammertime);

        hammertime.add(new Hammer.Swipe({ enable: debounce(canSwipe, 100) }));
        hammertime.on('swiperight', function(evt) {
          $hamburger.trigger('click');
          logger.log('touch', 'swiperight on screen');
          logger.log('touch', 'Touch event: %O', evt);
        });
      }

      $hamburger.on('click', function(evt) {
        var animatePaths = function(path, index) {
          var nthChild = index + 1;
          var element  = $svg.select('path:nth-child(' + nthChild + ')');
          element.animate({ d: path }, config.svg.animation.speed);
        };

        logger.log('nav', 'toggling: %O', evt);
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
    },

    testimonialSlider: function() {
      return this.each(function() {
        var $el     = $(this);
        var $slider = $el.find('ul');
        var $dots   = $(this).find('a.slider-dot');

        $slider.slick({
          infinite: false,
          arrows: false,
          dots: false,
          draggable: false,
          slide: 'li',
          onInit: function(slider) {
            logger.log('testimonialSlider', 'Slider initialized: %O', slider);

            $dots.on('click', function(evt) {
              var slideNum = $(this).data('index');
              $slider.slickGoTo(slideNum);
              $dots.removeClass('current');
              $(this).addClass('current');
              return false;
            });
          },
          onAfterChange: function(slider) {
            logger.log('testimonialSlider', 'Slide transition');
            $dots.removeClass('current').eq(slider.currentSlide).addClass('current');
          }
        });
      });
    },

    accordion: function() {
      return this.each(function() {
        var $el          = $(this);
        var $headerLinks = $el.find('.pane-header a');
        var $allContent  = $el.find('.pane-content');

        $headerLinks.on('click', function(evt) {
          var $pane    = $(this).closest('.pane');
          var $content = $pane.find('.pane-content');
          var isOpen   = !$content.hasClass('closed');

          logger.log('accordion', 'Closing all panes');
          $allContent.addClass('closed');

          if (!isOpen) {
            logger.log('accordion', 'Opening pane: %O', evt.target);
            $content.removeClass('closed');
          }

          return false;
        });

        logger.log('accordion', 'Initialized accordion: %O', $el);
      });
    },

    photoSlider: function() {
      return this.each(function() {
        $(this).slick({
          lazyLoad: 'ondemand',
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false,
          arrows: false,
          slide: 'figure'
        });
      });
    }

  });

})(window);
