/**
 * Fourth Wall Events
 * Interactive Event Map
 */

/* global google */

(function(window, undefined) {

  'use strict';

  var $      = require('jquery');
  var config = require('./lib/config');
  var logger = require('bragi-browser');

  $(document).ready(function() {
    logger.log('eventMap', 'Initializing event map');

    var $canvas = $('#map-canvas');

    var startLat   = $canvas.data('startingLatitude');
    var startLng   = $canvas.data('startingLongitude');
    var startZoom  = $canvas.data('zoom');
    var enableZoom = $canvas.data('enableZoom');

    var mapOpts = {
      center: new google.maps.LatLng(startLat, startLng),
      zoom: startZoom,
      zoomControl: enableZoom,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map     = new google.maps.Map($canvas[0], mapOpts);
  });

})(window);
