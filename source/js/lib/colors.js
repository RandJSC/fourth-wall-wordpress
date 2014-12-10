/**
 * Fourth Wall Events
 * Color Manipulation Helper Functions
 */

/* jshint -W064 */

(function(undefined) {
  'use strict';

  var Handlebars = require('handlebars');

  var templates = {
    rgba: Handlebars.compile('rgba({{ red }}, {{ green }}, {{ blue }}, {{ alpha }})')
  };

  module.exports = {
    hexToRGBA: function hexToRGBA(colorString, opacity) {
      if ((!opacity && opacity !== 0) || !(opacity >= 0 && opacity <= 1)) {
        opacity = 1;
      }

      // sanitize the string to contain only hex characters
      colorString = colorString.replace(/[^A-F0-9a-f]/g, '');

      // validate the length of the hex string
      if (colorString.length !== 6) {
        throw new Error('colorString must be 6 characters long');
      }

      var red   = parseInt(colorString.substr(0, 2), 16);
      var green = parseInt(colorString.substr(2, 2), 16);
      var blue  = parseInt(colorString.substr(4, 2), 16);

      return templates.rgba({
        red: red,
        green: green,
        blue: blue,
        alpha: opacity
      });
    }
  };
})();
