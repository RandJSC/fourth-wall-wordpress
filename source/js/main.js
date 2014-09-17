/**
 * Fourth Wall Events
 * Main JavaScript
 *
 * by Fifth Room Creative <info@fifthroomcreative.com>
 */

/* global Modernizr */

(function(window, undefined) {

  'use strict';

  var config          = require('./config');
  var $               = require('jquery');
  var attachFastClick = require('fastclick');
  var logger          = require('bragi-browser');
  var fweUtil         = require('./jquery.fourthwall-util');
  var fweUI           = require('./jquery.fourthwall-ui');
  var Slick           = require('./slick.commonjs');
  var Hammer          = require('hammerjs');
  var Snap            = require('snapsvg/dist/snap.svg');

  logger.log('timing', 'Begin docReady');

  var $container = $('#master-container');
  var $hamburger = $('#hamburger');
  var burgerSvg  = Snap('#hamburger-img');
  var canSwipe   = function canSwipe(recognizer, input) {
    return $container.hasClass('menu-open');
  };

  // Attach fastclick to body
  attachFastClick(document.body);

  $hamburger.toggleNav($container, burgerSvg);

  if (Modernizr.touch) {
    var hammertime = new Hammer.Manager($container[0], {});
    
    hammertime.add(new Hammer.Swipe({ enable: canSwipe }));
    hammertime.on('swiperight', function(evt) {
      $hamburger.trigger('click');
      logger.log('touch', 'swiperight');
      console.debug(evt);
    });
  }

  $('.slider .slides').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    slide: 'figure'
  });

  logger.log('timing', 'End docReady');

})(window);
