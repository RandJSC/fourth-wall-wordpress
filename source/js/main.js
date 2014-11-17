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
  var gforms        = require('./gforms-api');
  var Handlebars    = require('handlebars');
  var ButtonSpinner = require('./button-spinner');

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

  $contactForm.on('submit', function(evt) {
    var $el         = $(this);
    var name        = $el.find('#contact-name').val();
    var email       = $el.find('#contact-email').val();
    var message     = $el.find('#contact-message').val();
    var formID      = $el.data('formId');
    var route       = 'forms/' + formID + '/entries';
    var signature   = gforms.getSignature(route, 'POST');
    var urlTemplate = Handlebars.compile('/gravityformsapi/{{ route }}?api_key={{ api_key }}&signature={{ signature }}&expires={{ expires }}');
    var fullURL     = urlTemplate({
      route: route,
      api_key: encodeURIComponent(config.gravityForms.apiKey),
      signature: encodeURIComponent(signature.signature),
      expires: encodeURIComponent(signature.expires)
    });

    logger.log('form', 'Contact form submission: %O', {
      name: name,
      email: email,
      message: message,
      formID: formID,
      route: route
    });

    var ajax = $.ajax(fullURL, {
      accepts: 'application/json',
      type: 'POST',
      dataType: 'json',
      contentType: 'application/json',
      data: JSON.stringify([{
        '1': name,
        '2': email,
        '3': message
      }])
    });

    ajax.success(function(json, txt, xhr) {
      logger.log('ajax', 'Received response from server: %O', json);
      $el[0].reset();
    });

    return false;
  });

  logger.log('timing', 'End docReady');

})(window);
