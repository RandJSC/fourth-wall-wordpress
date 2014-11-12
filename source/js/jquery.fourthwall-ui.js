/**
 * Fourth Wall Events
 * UI Functions
 */

/* jshint -W064 */
/* global Modernizr */

(function(window, undefined) {
  'use strict';

  var forEach    = require('lodash.foreach');
  var debounce   = require('lodash.debounce');
  var $          = require('jquery');
  var config     = require('./config');
  var Snap       = require('./snap.svg.custom');
  var Hammer     = require('hammerjs');
  var logger     = require('bragi-browser');
  var fweUtil    = require('./jquery.fourthwall-util');
  var Handlebars = require('handlebars');

  var templates = {
    sliderArrow: Handlebars.compile(
      '<a href="" class="slider-arrow {{ side }}">' +
        '<span class="fa fa-angle-{{ side }}"></span>' +
      '</a>'
    ),
    arrowContainer: '<div class="slider-arrows"></div>'
  };

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
        var minus         = '&ndash;';
        var plus          = '+';
        var $el           = $(this);
        var $headerLinks  = $el.find('.pane-header a');
        var $allContent   = $el.find('.pane-content');
        var $allPlusMinus = $el.find('.plusminus');

        $allContent.each(function() {
          var height = $(this).outerHeight();
          $(this).data('height', height).css('maxHeight', 0);
        });

        $headerLinks.on('click', function(evt) {
          var $link      = $(this);
          var anyOpen    = $allContent.hasClass('open');
          var $plusMinus = $link.find('.plusminus');
          var $pane      = $link.closest('.pane');
          var $content   = $pane.find('.pane-content');
          var isOpen     = $content.hasClass('open');
          var height     = $content.data('height');

          if (anyOpen) {
            logger.log('accordion', 'Closing all panes');

            $allPlusMinus.html(plus);

            $allContent.afterTransition(function() {
              logger.log('accordion', 'Pane transition complete');

              if (!isOpen) {
                logger.log('accordion', 'Opening pane: %O', evt.target);
                $content.addClass('open').css('maxHeight', height);
                $plusMinus.html(minus);
              }
            }, true).css('maxHeight', 0).removeClass('open');
          } else {
            logger.log('accordion', 'Opening pane: %O', evt.target);
            $content.addClass('open').css('maxHeight', height);
            $plusMinus.html(minus);
          }

          return false;
        });

        $el.addClass('initialized');

        logger.log('accordion', 'Initialized accordion: %O', $el);
      });
    },

    photoSlider: function() {
      return this.each(function() {
        var $el = $(this);

        $el.slick({
          lazyLoad: 'ondemand',
          slidesToShow: 1,
          slidesToScroll: 1,
          dots: false,
          arrows: false,
          slide: 'figure',
          onInit: function(slider) {
            var sides      = [ 'left', 'right' ];
            var $container = slider.$slider.closest('.stitch-slider');

            if (!$container.length) return;

            $container.append(templates.arrowContainer);

            var $arrowContainer = $container.find('.slider-arrows');

            // append nav arrows to slider container
            forEach(sides, function(side) {
              var arrow = templates.sliderArrow({ side: side });
              $arrowContainer.append(arrow);
            });

            // bind click handlers to nav arrows
            $arrowContainer.find('.slider-arrow').on('click', function(evt) {
              if ($(this).hasClass('left')) {
                $el.slickPrev();
              } else {
                $el.slickNext();
              }
              return false;
            });
          }
        });
      });
    }

  });

})(window);
