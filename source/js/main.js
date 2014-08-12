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
  'lodash/collections/forEach',
  'slick'
], function(doc, $, Snap, forEach) {

  var $container = $('#master-container');
  var $hamburger = $('#hamburger');
  var burgerSvg  = Snap('#hamburger-img');
  var svgPaths   = {
    burger: [
      'M1.97 2.122h30.127v.127H1.97z',
      'M1.97 12.994h30.126v.127H1.92z',
      'M1.97 23.916H32.11v.127H1.983z'
    ],
    close: [
      'M5.058 3.027l22.637 19.88-.083.095L4.974 3.122z',
      'M5.432 3.468l22.72 19.782-.083.096L5.347 3.563z',
      'M5.36 22.796L28.42 3.408l.08.097-23.06 19.39z'
    ]
  };

  $hamburger.on('click', function(evt) {
    $container.add($hamburger).toggleClass('menu-open');

    if ($hamburger.hasClass('menu-open')) {
      forEach(svgPaths.close, function(path, index) {
        var nthChild = index + 1;
        var element  = burgerSvg.select('path:nth-child(' + nthChild + ')');
        element.animate({ d: path }, 500);
      });
    } else {
      forEach(svgPaths.burger, function(path, index) {
        var nthChild = index + 1;
        var element  = burgerSvg.select('path:nth-child(' + nthChild + ')');
        element.animate({ d: path }, 500);
      });
    }

    return false;
  });

});
