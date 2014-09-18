/**
 * Fourth Wall Events
 * Main JavaScript
 *
 * by Fifth Room Creative <info@fifthroomcreative.com>
 */

/* global Modernizr */

(function(window, undefined) {

  'use strict';

  var config    = require('./config');
  var $         = require('jquery');
  var fastClick = require('fastclick');
  var logger    = require('bragi-browser');
  var fweUtil   = require('./jquery.fourthwall-util');
  var fweUI     = require('./jquery.fourthwall-ui');
  var Slick     = require('./slick.commonjs');
  var Snap      = require('./snap.svg.custom');
  var gforms    = require('./gforms-api');

  logger.log('timing', 'Begin docReady');

  var $container = $('#master-container');
  var $hamburger = $('#hamburger');
  var burgerSvg  = Snap('#hamburger-img');

  // Attach fastclick to body
  fastClick(document.body);

  $hamburger.toggleNav($container, burgerSvg);

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
