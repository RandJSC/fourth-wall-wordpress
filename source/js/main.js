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
  'slick'
], function(doc, config, $, FastClick, Snap, forEach) {

  // Attach fastclick to body
  FastClick.attach(doc.body);

  var $container = $('#master-container');
  var $hamburger = $('#hamburger');
  var burgerSvg  = Snap('#hamburger-img');

  $hamburger.on('click', function(evt) {
    $container.add($hamburger).toggleClass('menu-open');

    if ($hamburger.hasClass('menu-open')) {
      forEach(config.svg.paths.close, function(path, index) {
        var nthChild = index + 1;
        var element  = burgerSvg.select('path:nth-child(' + nthChild + ')');
        element.animate({ d: path }, config.svg.animation.speed);
      });
    } else {
      forEach(config.svg.paths.burger, function(path, index) {
        var nthChild = index + 1;
        var element  = burgerSvg.select('path:nth-child(' + nthChild + ')');
        element.animate({ d: path }, config.svg.animation.speed);
      });
    }

    return false;
  });

});
