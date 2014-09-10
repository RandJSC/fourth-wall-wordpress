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
  'jquery.fourthwall-ui',
  'slick'
], function(doc, config, $, FastClick, Snap) {

  var $container = $('#master-container');
  var $hamburger = $('#hamburger');
  var burgerSvg  = Snap('#hamburger-img');

  // Attach fastclick to body
  FastClick.attach(doc.body);

  $hamburger.toggleNav($container, burgerSvg);

  $('.slider .slides').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    slide: 'figure'
  });
});
