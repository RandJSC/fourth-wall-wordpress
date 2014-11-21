/**
 * Fourth Wall Events
 * Main JavaScript
 *
 * by Fifth Room Creative <info@fifthroomcreative.com>
 */

/* global Modernizr */
/* jshint -W064 */

(function(window, undefined) {

  'use strict';

  var config        = require('./config');
  var $             = require('jquery');
  var fastClick     = require('fastclick');
  var logger        = require('bragi-browser');
  var fweUtil       = require('./jquery.fourthwall-util');
  var fweUI         = require('./jquery.fourthwall-ui');
  var Slick         = require('slick-carousel');
  var Snap          = require('./snap.svg.custom');
  var Handlebars    = require('handlebars');
  var ButtonSpinner = require('./button-spinner');

  // remove me in production
  var debug = require('./jquery.debug');

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

  // Attach fastclick to body
  fastClick(document.body);

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

  // Footer contact form
  $contactForm.contactForm();

  logger.log('timing', 'End docReady');

})(window);
