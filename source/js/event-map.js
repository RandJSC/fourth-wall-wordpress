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
  var Spinner    = require('spin.js/spin');
  var moment     = require('moment');
  var TweenLite  = require('gsap/src/uncompressed/TweenLite');
  var ScrollTo   = require('gsap/src/uncompressed/plugins/ScrollToPlugin');

  $(document).ready(function() {
    logger.log('eventMap', 'Initializing event map');

    Handlebars.registerHelper('formatDate', function(dateStr) {
      var date   = moment(dateStr);
      var result = date.isValid() ? '<span class="fa fa-clock-o"></span><span class="formatted-date">' + date.format('MMMM D, YYYY') + '</span>' : '';
      return new Handlebars.SafeString(result);
    });

    Handlebars.registerPartial('item', $('#tpl-item-partial').html());

    var templates  = {
      markerTitle: Handlebars.compile('{{ title }} ({{ count }})'),
      locationContent: Handlebars.compile($('#tpl-location-content').html())
    };

    var loaded      = false;
    var $canvas     = $('#map-canvas');
    var $locContent = $('#location-content');
    var $spinner    = $locContent.children('.spinner');
    var $content    = $locContent.children('.content');
    var data        = $canvas.data();
    var mapOpts     = {
      center: new google.maps.LatLng(data.startingLatitude, data.startingLongitude),
      zoom: data.zoom,
      zoomControl: data.enableZoom,
      minZoom: data.minZoom,
      maxZoom: data.maxZoom,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var eventMap    = new google.maps.Map($canvas[0], mapOpts);
    var spinner     = new Spinner({
      lines: 11,
      length: 16,
      width: 7,
      radius: 17,
      corners: 1.0,
      trail: 60,
      color: '#000',
      className: 'wheel'
    });

    logger.log('eventMap', 'Appending spinner to #location-content');
    $spinner.html(spinner.spin().el);

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

          window.marker = marker;

          google.maps.event.addListener(marker, 'click', function() {
            logger.log('eventMap', 'Marker clicked: %s', loc.title);
            var contentReq = $.ajax(jsonLink, {
              type: 'GET',
              dataType: 'json',
              beforeSend: function() {
                logger.log('eventMap', 'Showing spinner');
                $spinner.addClass('visible');
                marker.setAnimation(google.maps.Animation.BOUNCE);
              }
            });

            contentReq.success(function(content) {
              logger.log('eventMap', 'Loaded location content: %O', content);
              logger.log('eventMap', 'Hiding spinner');

              $spinner.removeClass('visible');
              marker.setAnimation(null);

              logger.log('eventMap', 'Appending galleries and case studies');
              $content.html(templates.locationContent(content));
              TweenLite.to(window, 0.5, { scrollTo: { y: $locContent.offset().top } });
            });
          });
        });
      });

      loaded = true;
    });

  });

})(window);
