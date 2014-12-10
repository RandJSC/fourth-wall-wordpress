/**
 * Fourth Wall Events
 * Main JavaScript
 *
 * by Fifth Room Creative <info@fifthroomcreative.com>
 */

/* global Modernizr, matchMedia, addthis */
/* jshint -W064 */

(function(window, undefined) {

  'use strict';

  var config        = require('./lib/config');
  var $             = require('jquery');
  var fastClick     = require('fastclick');
  var logger        = require('bragi-browser');
  var fweUtil       = require('./lib/jquery.fourthwall-util');
  var fweUI         = require('./lib/jquery.fourthwall-ui');
  var Slick         = require('slick-carousel');
  var Snap          = require('./lib/snap.svg.custom');
  var Handlebars    = require('handlebars');
  var ButtonSpinner = require('./lib/button-spinner');

  // remove me in production
  var debug = require('./lib/jquery.debug');

  logger.log('timing', 'Begin docReady');

  var burgerSvg           = Snap('#hamburger-img');
  var $container          = $('#master-container');
  var $hamburger          = $('#hamburger');
  var $contactForm        = $('#contact-form form');
  var $testimonialSliders = $('.testimonial-slider');
  var $accordions         = $('.accordion');
  var $homepageSlider     = $('.slider .slides');
  var $stitchSliders      = $('.stitch-slider .slides');
  var $teamMembers        = $('.team-members');
  var $gallerySliders     = $('.gallery-slider .slides');
  var $categoryPicker     = $('#event-categories');
  var $stitches           = $('section.stitch');

  // Console access to jQuery:
  window.jQuery = window.$ = $;

  // Setup AddThis sharing buttons
  addthis.button('.addthis-share');

  var navListener = function navListener(mq) {
    var $mainNav   = $('#main-nav');
    var $mobileNav = $('#mobile-nav');

    if (mq.matches && $mobileNav.children().length) {
      logger.log('mobileNav', 'Moving mobile nav contents to main nav container');
      $mobileNav.children().prependTo($mainNav);
    } else if (!mq.matches && $mainNav.children().length) {
      logger.log('mobileNav', 'Moving main nav contents to mobile nav container');
      $mainNav.children().prependTo($mobileNav);
    } else {
      logger.log('mobileNav', 'Nothing needs to be done');
    }
  };

  // Attach fastclick to body
  fastClick(document.body);

  if (Modernizr.matchmedia) {
    var navMQ = matchMedia('screen and (min-width: ' + config.breakpoints.aboveTablet + 'px)');
    navListener(navMQ);

    if (Modernizr.matchmedialistener) {
      navMQ.addListener(navListener);
    }
  }

  $hamburger.toggleNav($container, burgerSvg);

  // Homepage slider (if present)
  $homepageSlider.homepageSlider();

  // Photo sliders
  $stitchSliders.photoSlider();

  // Testimonial sliders
  $testimonialSliders.testimonialSlider();

  // Accordions
  $accordions.accordion();

  // Team Members viewer shortcode
  $teamMembers.teamMembersShortcode();

  // Gallery sliders
  $gallerySliders.photoSlider({
    popup: true,
    container: '.gallery-slider'
  });

  // Event category picker
  $categoryPicker.eventCategoryPicker();

  // Stitch pushState scroll watcher
  $stitches.stitchScroll();

  // Set up breakpoints for responsive stitch backgrounds
  $stitches.setupResponsiveBackgrounds();

  // Footer contact form
  $contactForm.contactForm();

  logger.log('timing', 'End docReady');

})(window);
