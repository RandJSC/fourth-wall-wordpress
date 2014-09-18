/**
 * Fourth Wall Events
 * Gravity Forms API Helpers
 */

(function(window, undefined) {

  var logger = require('bragi-browser');
  var config = require('./config');
  var HMAC   = require('crypto-js/hmac-sha1');
  var Base64 = require('crypto-js/enc-base64');

  // Private helpers
  var hmacBase64 = function hmacBase64(str, privKey) {
    var hash   = HMAC(str, privKey);
    var base64 = Base64.stringify(hash);
    return base64;
  };

  module.exports = {
    getSignature: function getSignature(route, method) {
      route          = route ? route : '/';
      method         = method ? method : 'GET';
      var d          = new Date();
      var unixTime   = parseInt(d.getTime() / 1000);
      var expiration = unixTime + 3600; // +1 hour
      var strToSign  = config.gravityForms.apiKey + ':';
      strToSign     += method + ':';
      strToSign     += route + ':';
      strToSign     += expiration;
      var signed     = hmacBase64(strToSign, config.gravityForms.privateKey);

      logger.log('gforms', 'Gravity Forms signature calculated: %O', {
        route: route,
        signature: signed,
        expiration: expiration
      });

      return {
        signature: signed,
        expires: expiration
      };
    }
  };

})(window);
