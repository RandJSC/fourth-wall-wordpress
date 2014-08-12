/**
 * Fourth Wall Events
 * Main JavaScript
 *
 * by Fifth Room Creative <info@fifthroomcreative.com>
 */

require([
  '../../bower_components/requirejs-domready/domReady!',
  'jquery',
  'Snap',
  'slick'
], function(doc, $, Snap) {

  var $container = $('#master-container');
  var $hamburger = $('#hamburger');
  var burgerSvg  = Snap('#hamburger-img');

  window.svg = burgerSvg;

  $hamburger.on('click', function(evt) {
    $container.toggleClass('menu-open');
    return false;
  });

});
