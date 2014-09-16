/**
 * Fourth Wall Events
 * Main JavaScript
 *
 * by Fifth Room Creative <info@fifthroomcreative.com>
 */

/* global Modernizr */

require([
  '../../bower_components/requirejs-domready/domReady!',
  'config',
  'jquery',
  'FastClick',
  'Snap',
  'bragi',
  'jquery.fourthwall-util',
  'jquery.fourthwall-ui',
  'slick'
], function(doc, config, $, FastClick, Snap, logger) {

  logger.log('timing', 'Begin docReady');

  var $container = $('#master-container');
  var $hamburger = $('#hamburger');
  var burgerSvg  = Snap('#hamburger-img');

  // Attach fastclick to body
  FastClick.attach(doc.body);

  $hamburger.toggleNav($container, burgerSvg);

  console.debug($.fn.transToggleClass);

  $('.slider .slides').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    slide: 'figure'
  });

  logger.log('timing', 'End docReady');
});
