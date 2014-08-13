/**
 * Fourth Wall Events
 * Main JavaScript
 *
 * by Fifth Room Creative <info@fifthroomcreative.com>
 */

require([
  '../../bower_components/requirejs-domready/domReady!',
  'config',
  'jquery',
  'FastClick',
  'Snap',
  'lodash/collections/forEach',
  'jquery.fourthwall-ui',
  'slick'
], function(doc, config, $, FastClick, Snap, forEach) {

  // Attach fastclick to body
  FastClick.attach(doc.body);

  var $container = $('#master-container');
  var $hamburger = $('#hamburger');
  var burgerSvg  = Snap('#hamburger-img');

  $hamburger.toggleNav($container, burgerSvg);

});
