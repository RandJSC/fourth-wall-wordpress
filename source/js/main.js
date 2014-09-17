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
  'hammerjs',
  'jquery.fourthwall-util',
  'jquery.fourthwall-ui',
  'slick'
], function(doc, config, $, FastClick, Snap, logger, Hammer) {

  logger.log('timing', 'Begin docReady');

  var $container   = $('#master-container');
  var $hamburger   = $('#hamburger');
  var burgerSvg    = Snap('#hamburger-img');
  var hammertime   = new Hammer.Manager($container[0], {});
  var canSwipe     = function canSwipe(recognizer, input) {
    return $container.hasClass('menu-open');
  };

  // Attach fastclick to body
  FastClick.attach(doc.body);

  $hamburger.toggleNav($container, burgerSvg);
  
  hammertime.add(new Hammer.Swipe({ enable: canSwipe }));
  hammertime.on('swiperight', function(evt) {
    $hamburger.trigger('click');
    logger.log('touch', 'swiperight');
    console.debug(evt);
  });

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
