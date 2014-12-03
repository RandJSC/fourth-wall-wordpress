/**
 * Fourth Wall Events
 * Interactive Event Map
 */

/* global google */

(function(window, undefined) {

  'use strict';

  var $       = require('jquery');
  var config  = require('./lib/config');
  var logger  = require('bragi-browser');
  var forEach = require('lodash.foreach');

  $(document).ready(function() {
    logger.log('eventMap', 'Initializing event map');

    var $canvas  = $('#map-canvas');
    var data     = $canvas.data();
    var mapOpts  = {
      center: new google.maps.LatLng(data.startingLatitude, data.startingLongitude),
      zoom: data.zoom,
      zoomControl: data.enableZoom,
      minZoom: data.minZoom,
      maxZoom: data.maxZoom,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var eventMap = new google.maps.Map($canvas[0], mapOpts);

    eventMap.addListener('tilesloaded', function(evt) {
      logger.log('eventMap', 'Tiles loaded');

      var markersReq = $.ajax(data.pinsUrl, {
        type: 'GET',
        dataType: 'json'
      });

      markersReq.success(function(json) {
        logger.log('eventMap', 'Loaded map markers: %O', json);

        if (!json.length) {
          logger.log('eventMap', 'No map markers found.');
          return;
        }

        forEach(json, function(loc) {
          logger.log('eventMap', 'Adding map marker: %s', ('(' + loc.latitude + ', ' + loc.longitude + ')'));

          var latLng = new google.maps.LatLng(loc.latitude, loc.longitude);
          var marker = new google.maps.Marker({
            position: latLng,
            map: eventMap,
            title: loc.title,
            animation: google.maps.Animation.DROP
          });
        });
      });
    });

  });

})(window);
