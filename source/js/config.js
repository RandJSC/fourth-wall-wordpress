/**
 * Fourth Wall Events
 * Global Settings and Configuration
 */

(function() {
  'use strict';

  var config = {};

  config.defaults = {
    animation: {
      speed: 350
    }
  };

  config.colors = {
    blue: '#008fd1',
    text: '#747474'
  };

  config.svg = {
    paths: {
      burger: [
        'M1.97 2.122h30.127v.127H1.97z',
        'M1.97 12.994h30.126v.127H1.92z',
        'M1.97 23.916H32.11v.127H1.983z'
      ],
      close: [
        'M5.058 3.027l22.637 19.88-.083.095L4.974 3.122z',
        'M5.432 3.468l22.72 19.782-.083.096L5.347 3.563z',
        'M5.36 22.796L28.42 3.408l.08.097-23.06 19.39z'
      ]
    },
    animation: {
      speed: 350
    }
  };

  config.gravityForms = {
    apiKey: 'bf72b8cd58'
  };

  module.exports = config;
})();

