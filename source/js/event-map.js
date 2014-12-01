/**
 * Fourth Wall Events
 * Interactive Event Map
 */

(function(window, undefined) {

  'use strict';

  var $      = require('jquery');
  var config = require('./lib/config');
  var logger = require('bragi-browser');

  $(document).ready(function() {
    logger.log('eventMap', 'Initializing event map');
  });

})(window);
