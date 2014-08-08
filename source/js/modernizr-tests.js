/**
 * Fourth Wall Events
 * Modernizr Custom Tests
 */

(function(window, Modernizr, undefined) {

  'use strict';

  Modernizr.addTest('matchmedia', function() {
    if (window.matchMedia && typeof window.matchMedia === 'function') {
      return true;
    }

    return false;
  });

  Modernizr.addTest('matchmedialistener', function() {
    if (!Modernizr.matchmedia) return false;
    var matcher = window.matchMedia('only all');

    if (matcher.addListener && typeof matcher.addListener === 'function') {
      return true;
    }

    return false;
  });

})(window, window.Modernizr);
