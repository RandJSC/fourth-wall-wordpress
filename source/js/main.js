/**
 * Fourth Wall Events
 * Main JavaScript
 *
 * by Fifth Room Creative <info@fifthroomcreative.com>
 */

require([
  '../../bower_components/requirejs-domready/domReady!',
  'jquery'
], function(doc, $) {

  console.log(doc, $);
  $('body').addClass('foo');

});
