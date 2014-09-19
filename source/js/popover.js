/**
 * Fourth Wall Events
 * Popover Widget
 */

(function(window, undefined) {

  'use strict';

  var isBrowserify = function isBrowserify() {
    return (typeof exports !== 'undefined');
  };

  if (isBrowserify()) {
    var $ = require('jquery');
  }

  var Popover = function Popover(options) {
    var defaults = {
      id: 'popover',
      'class': []
    };

    this.opts  = $.extend(defaults, options);
    this.$root = $(document.documentElement);
    this.$elem = $('<div/>', {
      id: this.opts.id,
      'class': this.opts['class'].join(' ')
    });

  };

  Popover.prototype.show = function() {

  };

  Popover.prototype.hide = function() {

  };

  Popover.prototype.toggle = function() {

  };

  if (isBrowserify()) {
    module.exports = Popover;
  } else {
    window.Popover = Popover;
  }

})(window);
