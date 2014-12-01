/**
 * Fourth Wall Events
 * JS Debugging Helpers
 */

/* jshint -W064 */
/* jshint -W041 */

(function(window, undefined) {
  'use strict';

  var $        = require('jquery');
  var contains = require('lodash.contains');

  var styles = {
    bold: 'font-weight: bold',
    normal: 'font-weight: normal',
    blue: 'color: #0000FF'
  };

  var AncestryClimber = function AncestryClimber(elem, callback) {
    if (!elem) {
      throw new Error('Please supply a DOM element!');
    }

    if (!callback) {
      throw new Error('Please supply a callback function!');
    }

    this.$elem      = $(elem);
    this.callback   = callback;
    this.iterations = 0;
  };

  AncestryClimber.prototype.climb = function climb(skipStop) {
    if (skipStop == null) {
      skipStop = true;
    }

    this.iterations += 1;

    var $parent = this.$elem.parent();
    var stop    = this.callback.call(this.$elem, this.iterations) === false;

    if (skipStop) {
      stop = false;
    }

    this.$elem = $parent;

    if (!stop && $parent[0].nodeName !== '#document') {
      return this.climb(false);
    }
  };

  module.exports = $.fn.extend({

    climbAncestry: function(cb) {
      var climber = new AncestryClimber(this[0], cb);
      climber.climb();
      return this;
    },

    positionAncestor: function() {
      var stopPositions = [
        'relative',
        'absolute',
        'fixed'
      ];

      return this.each(function() {
        console.group('Position Ancestry');
        $(this).climbAncestry(function(iters) {
          var pos  = this.css('position');
          var stop = !(contains(stopPositions, pos) && iters > 1);
          console.log(
            '%c%O: %c%s',
            styles.bold,
            this[0],
            (stop ? styles.normal : styles.blue),
            pos
          );
          return stop;
        });
        console.groupEnd();
      });
    }

  });

})(window);
