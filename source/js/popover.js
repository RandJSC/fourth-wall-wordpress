/**
 * Fourth Wall Events
 * Popover Widget
 */

/* global _, BRAGI */

(function(window, undefined) {

  'use strict';

  var $          = require('jquery');
  var Handlebars = require('handlebars');
  var debounce   = require('lodash.debounce');
  var logger     = require('bragi-browser');
  var Q          = require('q');

  var Popover = function Popover(options) {
    // Singleton - always return the same instance on subsequent initializations
    if (Popover.prototype._singletonInstance) {
      return Popover.prototype._singletonInstance;
    }

    Popover.prototype._singletonInstance = this;

    var _title;
    var _content;
    var self     = this;
    var defaults = {
      id: 'popover',
      'class': []
    };

    this.visible = false;
    this.onPage  = false;
    this.opts    = $.extend(defaults, options);
    this.$root   = $(document.documentElement);
    this.$elem   = $('<div/>', {
      id: this.opts.id,
      'class': this.opts['class'].join(' '),
      css: {
        display: 'none'
      }
    });
    this.templates = {
      modalContent: Handlebars.compile([
        '{{#if title}}',
          '<div class="modal-title">{{{title}}}</div>',
        '{{/if}}',
        '<div class="modal-content">{{{content}}}</div>',
      ].join("\n"))
    };

    // Title property getter/setter
    Object.defineProperty(this, 'title', {
      enumerable: true,
      get: function() {
        return _title;
      },
      set: function(val) {
        _title = val;
        self.refresh();
      }
    });

    Object.defineProperty(this, 'content', {
      enumerable: true,
      get: function() {
        return _content;
      },
      set: function(val) {
        _content = val;
        self.refresh();
      }
    });

    this.title   = this.opts.title;
    this.content = this.opts.content;
  };

  Popover.prototype.refresh = debounce(function refresh() {
    var html = this.templates.modalContent({
      title: this.title,
      content: this.content
    });

    logger.log('popover', 'Refresh triggered: %O', {
      title: this.title,
      content: this.content
    });

    this.$elem.html(html);

    if (!this.onPage) {
      this.append();
    }
  }, 50);

  Popover.prototype.append = function append() {
    if (this.onPage) {
      logger.log('popover', 'Already on page. Doing nothing.');
      return false;
    }

    logger.log('popover', 'Appending to page');

    this.$root.append(this.$elem);
    this.onPage = true;
    return this.onPage;
  };

  Popover.prototype.remove = function remove() {
    if (!this.onPage) {
      logger.log('popover', 'Not on page yet. Doing nothing.');
      return false;
    }

    logger.log('popover', 'Removing from page');
    this.$elem.detach();
    this.onPage = false;
    return this.onPage;
  };

  Popover.prototype.destroy = function destroy() {
    logger.log('popover', 'Removing from page and destroying singleton instance');
    if (this.onPage) {
      this.remove();
    }

    delete Popover.prototype._singletonInstance;

    return true;
  };

  Popover.prototype.show = function show() {
    logger.log('popover', 'Showing popover');

    var self     = this;
    var deferred = Q.defer();

    this.$elem.transAddClass('visible', function() {
      deferred.resolve(self);
    });

    this.visible = true;

    return deferred.promise;
  };

  Popover.prototype.hide = function hide() {
    logger.log('popover', 'Hiding popover');

    var self     = this;
    var deferred = Q.defer();

    this.$elem.transRemoveClass('visible', function() {
      deferred.resolve(self);
    });

    this.visible = false;

    return deferred.promise;
  };

  Popover.prototype.toggle = function toggle(cb) {
    logger.log('popover', 'Toggling visibility');
    return this.visible ? this.hide() : this.show();
  };

  module.exports = Popover;

})(window);
