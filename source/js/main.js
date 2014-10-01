/**
 * Fourth Wall Events
 * Main JavaScript
 *
 * by Fifth Room Creative <info@fifthroomcreative.com>
 */

/* global Modernizr */

(function(window, undefined) {

  'use strict';

  var config        = require('./config');
  var $             = require('jquery');
  var fastClick     = require('fastclick');
  var logger        = require('bragi-browser');
  var fweUtil       = require('./jquery.fourthwall-util');
  var fweUI         = require('./jquery.fourthwall-ui');
  var Slick         = require('./slick.commonjs');
  var Snap          = require('./snap.svg.custom');
  var gforms        = require('./gforms-api');
  var Handlebars    = require('handlebars');
  var ButtonSpinner = require('./button-spinner');

  logger.log('timing', 'Begin docReady');

  var $container   = $('#master-container');
  var $hamburger   = $('#hamburger');
  var $contactForm = $('#contact-form form');
  var burgerSvg    = Snap('#hamburger-img');

  // Attach fastclick to body
  fastClick(document.body);

  $hamburger.toggleNav($container, burgerSvg);

  $('.slider .slides').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    slide: 'figure'
  });

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
