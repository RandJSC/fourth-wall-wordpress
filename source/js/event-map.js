/**
 * Fourth Wall Events
 * Interactive Event Map
 */

/* global google */

(function(window, undefined) {

  'use strict';

  var $          = require('jquery');
  var config     = require('./lib/config');
  var logger     = require('bragi-browser');
  var forEach    = require('lodash.foreach');
  var Handlebars = require('handlebars');

  var templates  = {
    markerTitle: Handlebars.compile('{{ title }} ({{ count }})')
  };

  $(document).ready(function() {
    logger.log('eventMap', 'Initializing event map');

    var loaded   = false;
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
      if (loaded) {
        return;
      }

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

          var jsonLink     = loc.links.json;
          var projectCount = loc.galleries + loc.case_studies;
          var title        = templates.markerTitle({ title: loc.title, count: projectCount });
          var latLng       = new google.maps.LatLng(loc.latitude, loc.longitude);
          var marker       = new google.maps.Marker({
            position: latLng,
            map: eventMap,
            title: title,
            animation: google.maps.Animation.DROP
          });

          google.maps.event.addListener(marker, 'click', function() {
            logger.log('eventMap', 'Marker clicked: %s', loc.title);
            var contentReq = $.ajax(jsonLink, {
              type: 'GET',
              dataType: 'json'
            });

            contentReq.success(function(content) {
              
            });
          });
        });
      });

      loaded = true;
    });

  });

})(window);
