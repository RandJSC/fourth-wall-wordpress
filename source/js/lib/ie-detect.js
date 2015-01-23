/**
 * Fourth Wall Events
 * Internet Explorer Detection Module
 */

(function(window, undefined) {

  'use strict';

  var some = require('lodash.some');

  var html                = document.documentElement;
  var hasClassList        = 'classList' in html;

  var hasConditionalClass = function hasConditionalClass(klass) {
    if (hasClassList) {
      return html.classList.contains(klass);
    }

    var classes = html.className.split(' ');

    return some(classes, function(cls) {
      return cls === klass;
    });
  };

  var methods = {
    fallback: function fallback() {
      return hasConditionalClass('ie') || (/MSIE/i).test(window.navigator.userAgent);
    },
    8: function isIE8() {
      if (hasClassList) {
        return false;
      }
      return hasConditionalClass('lt-ie9');
    },
    9: function isIE9() {
      if (hasClassList) {
        return false;
      }
      return hasConditionalClass('lt-ie10') && !hasConditionalClass('lt-ie9');
    }
  };

  module.exports = {
    isIE: function isIE(ver) {
      if (!methods.hasOwnProperty(ver)) {
        return methods.fallback.call(this);
      }

      return methods[ver].call(this);
    },
    lte: function lte(ver) {
      // bro, are you even IE?
      var isIE = methods.fallback.call(this);

      if (!isIE) {
        return false;
      }

      var verClass = 'lt-ie' + (ver + 1);
      return hasConditionalClass(verClass);
    },
    version: function version() {
      if (!methods.fallback.call(this)) {
        return null;
      }

      var pattern = /MSIE\ ([\d\.]+);/;
      var matches = window.navigator.userAgent.match(pattern);

      if (matches.length > 1) {
        return matches[1];
      }

      return null;
    }
  };

})(window);
