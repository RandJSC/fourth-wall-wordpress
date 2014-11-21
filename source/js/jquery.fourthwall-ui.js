/**
 * Fourth Wall Events
 * UI Functions
 */

/* jshint -W064 */
/* global Modernizr */

(function(window, undefined) {
  'use strict';

  var has         = require('lodash.has');
  var isUndefined = require('lodash.isundefined');
  var isEmpty     = require('lodash.isempty');
  var isObject    = require('lodash.isobject');
  var forEach     = require('lodash.foreach');
  var debounce    = require('lodash.debounce');
  var assign      = require('lodash.assign');
  var throttle    = require('lodash.throttle');
  var find        = require('lodash.find');
  var $           = require('jquery');
  var config      = require('./config');
  var Snap        = require('./snap.svg.custom');
  var Hammer      = require('hammerjs');
  var logger      = require('bragi-browser');
  var fweUtil     = require('./jquery.fourthwall-util');
  var Handlebars  = require('handlebars');
  var TweenLite   = require('gsap/src/uncompressed/TweenLite');
  var ScrollTo    = require('gsap/src/uncompressed/plugins/ScrollToPlugin');
  var Magnific    = require('./jquery.magnific-popup');
  var gforms      = require('./gforms-api');

  $.magnificPopup    = Magnific.root;
  $.fn.magnificPopup = Magnific.plugin;

  Handlebars.registerHelper('socialLink', function(icon, url) {
    if (!url) return '';

    var listItem = '<li>' +
        '<a href="' + url + '">' +
          '<span class="fa ' + icon + '"></span>' +
        '</a>' +
      '</li>';

    return new Handlebars.SafeString(listItem);
  });

  Handlebars.registerHelper('emailLink', function(address) {
    if (!address) return '';

    var listItem = '<li>' +
        '<a href="mailto:' + address + '">' +
          '<span class="fa fa-envelope"></span>' +
        '</a>' +
      '</li>';

    return new Handlebars.SafeString(listItem);
  });

  var templates = {
    sliderArrow: Handlebars.compile(
      '<a href="" class="slider-arrow {{ side }}">' +
        '<span class="fa fa-angle-{{ side }}"></span>' +
      '</a>'
    ),
    arrowContainer: '<div class="slider-arrows"></div>',
    teamMemberDetail: Handlebars.compile(
      '<div class="team-member-photo">' +
        '<img src="{{ headshot.src }}" width="{{ headshot.width }}" height="{{ headshot.height }}" alt="{{ title }}">' +
      '</div>' +
      '<div class="team-member-content">' +
        '<h3>{{ title }}</h3>' +
        '<div class="title-location">' +
          '<span class="title">{{ job_title }}</span>' +
          '<span class="location">{{ location }}</span>' +
        '</div>' +
        '{{{ content }}}' +
        '<ul class="contact">' +
          '{{ socialLink "fa-facebook" facebook }}' +
          '{{ socialLink "fa-twitter" twitter }}' +
          '{{ socialLink "fa-instagram" instagram }}' +
          '{{ socialLink "fa-linkedin" linkedin }}' +
          '{{ socialLink "fa-pinterest" pinterest }}' +
          '{{ socialLink "fa-google-plus" google_plus }}' +
          '{{ emailLink email }}' +
        '</ul>' +
      '</div>'
    )
  };

  var slickDefaults = {
    lazyLoad: 'ondemand',
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    slide: 'figure'
  };

  module.exports = $.fn.extend({

    toggleNav: function(container, svg) {
      var $hamburger = this;
      var $container = $(container);
      var $svg       = Snap(svg);
      var canSwipe   = function(recognizer, input) {
        var menuOpen = $container.hasClass('menu-open');
        var logMsg   = 'Swipe recognizer ' + (menuOpen ? 'enabled' : 'disabled');
        logger.log('touch', logMsg);
        return menuOpen;
      };

      if (Modernizr.touch) {
        logger.log('touch', 'Registering swipe handler');

        var hammertime = new Hammer.Manager($container[0], {});
        $container.data('hammertime', hammertime);

        hammertime.add(new Hammer.Swipe({ enable: debounce(canSwipe, 100) }));
        hammertime.on('swiperight', function(evt) {
          $hamburger.trigger('click');
          logger.log('touch', 'swiperight on screen');
          logger.log('touch', 'Touch event: %O', evt);
        });
      }

      $hamburger.on('click', function(evt) {
        var animatePaths = function(path, index) {
          var nthChild = index + 1;
          var element  = $svg.select('path:nth-child(' + nthChild + ')');
          element.animate({ d: path }, config.svg.animation.speed);
        };

        logger.log('nav', 'toggling: %O', evt);
        $container.add($hamburger).toggleClass('menu-open');

        if ($hamburger.hasClass('menu-open')) {
          logger.log('svg', 'animating to X');
          forEach(config.svg.paths.close, animatePaths);
          $svg.select('g').animate({
            stroke: config.colors.text
          }, config.svg.animation.speed);
        } else {
          logger.log('svg', 'animating to hamburger');
          forEach(config.svg.paths.burger, animatePaths);
          $svg.select('g').animate({
            stroke: config.colors.blue
          }, config.svg.animation.speed);
        }

        return false;
      });

      return this;
    },

    testimonialSlider: function() {
      return this.each(function() {
        var $el     = $(this);
        var $slider = $el.find('ul');
        var $dots   = $(this).find('a.slider-dot');

        $slider.slick({
          infinite: false,
          arrows: false,
          dots: false,
          draggable: false,
          slide: 'li',
          onInit: function(slider) {
            logger.log('testimonialSlider', 'Slider initialized: %O', slider);

            $dots.on('click', function(evt) {
              var slideNum = $(this).data('index');
              $slider.slickGoTo(slideNum);
              $dots.removeClass('current');
              $(this).addClass('current');
              return false;
            });
          },
          onAfterChange: function(slider) {
            logger.log('testimonialSlider', 'Slide transition');
            $dots.removeClass('current').eq(slider.currentSlide).addClass('current');
          }
        });
      });
    },

    accordion: function() {
      return this.each(function() {
        var minus         = '&ndash;';
        var plus          = '+';
        var $el           = $(this);
        var $headerLinks  = $el.find('.pane-header a');
        var $allContent   = $el.find('.pane-content');
        var $allPlusMinus = $el.find('.plusminus');

        $allContent.each(function() {
          var height = $(this).outerHeight();
          $(this).data('height', height).css('maxHeight', 0);
        });

        $headerLinks.on('click', function(evt) {
          var $link      = $(this);
          var anyOpen    = $allContent.hasClass('open');
          var $plusMinus = $link.find('.plusminus');
          var $pane      = $link.closest('.pane');
          var $content   = $pane.find('.pane-content');
          var isOpen     = $content.hasClass('open');
          var height     = $content.data('height');

          if (anyOpen) {
            logger.log('accordion', 'Closing all panes');

            $allPlusMinus.html(plus);

            $allContent.afterTransition(function() {
              logger.log('accordion', 'Pane transition complete');

              if (!isOpen) {
                logger.log('accordion', 'Opening pane: %O', evt.target);
                $content.addClass('open').css('maxHeight', height);
                $plusMinus.html(minus);
              }
            }, true).css('maxHeight', 0).removeClass('open');
          } else {
            logger.log('accordion', 'Opening pane: %O', evt.target);
            $content.addClass('open').css('maxHeight', height);
            $plusMinus.html(minus);
          }

          return false;
        });

        $el.addClass('initialized');

        logger.log('accordion', 'Initialized accordion: %O', $el);
      });
    },

    homepageSlider: function() {
      return this.each(function() {
        return $(this).slick(slickDefaults);
      });
    },

    photoSlider: function(opts) {
      var defaults = {
        popup: false,
        container: '.stitch-slider'
      };
      var options  = isObject(opts) ? assign(defaults, opts) : defaults;

      return this.each(function() {
        logger.log('gallery', 'Setting up photo slider on %O', this);

        var $el = $(this);

        var slickOpts = assign(slickDefaults, {
          onInit: function(slider) {
            var sides      = [ 'left', 'right' ];
            var $container = slider.$slider.closest(options.container);

            if (!$container.length) return;

            var $imgLinks = $container.find('a');

            if (options.popup) {
              logger.log('gallery', 'Binding Magnific Popup to slider images');
              $imgLinks.magnificPopup({ type: 'image' });
            }

            $container.append(templates.arrowContainer);

            var $arrowContainer = $container.find('.slider-arrows');

            var centerArrows = throttle(function(evt) {
              var arrowHeight  = $arrowContainer.height();
              var sliderHeight = $el.height();
              var arrowTop     = Math.round(sliderHeight / 2 - arrowHeight);

              $arrowContainer.css('top', arrowTop);
            }, 100);

            // append nav arrows to slider container
            forEach(sides, function(side) {
              var arrow = templates.sliderArrow({ side: side });
              $arrowContainer.append(arrow);
            });

            // vertically center nav arrows in slider frame
            centerArrows();
            $(window).on('resize', centerArrows);

            // bind click handlers to nav arrows
            $arrowContainer.find('.slider-arrow').on('click', function(evt) {
              if ($(this).hasClass('left')) {
                $el.slickPrev();
              } else {
                $el.slickNext();
              }
              return false;
            });
          }
        });

        $el.slick(slickOpts);
      });
    },

    teamMembersShortcode: function() {
      return this.each(function() {
        var $root           = $(this);
        var $viewer         = $root.find('.team-member-viewer');
        var $thumbLinks     = $root.find('.team-thumbs a');
        var $detailArea     = $root.find('.team-member-detail');
        var $fadeWrap       = $root.find('.fade-wrap');
        var $collapseButton = $root.find('.collapse-button');
        var teamMembers     = {};
        var viewerHeight    = $viewer.height();
        var detailY         = Math.round($detailArea.offset().top);
        var doc             = document.documentElement;

        logger.log('teamMembers', 'Setting viewer maxHeight to %d', viewerHeight);

        $viewer.css('maxHeight', viewerHeight);

        $collapseButton.on('click', function(evt) {
          logger.log('teamMembers', 'Setting viewer maxHeight to 0');
          $viewer.css('maxHeight', 0).data('visible', false);
          return false;
        });

        $thumbLinks.on('click', function(evt) {
          var ajax;
          var $el     = $(this);
          var scrollY = (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
          var slug    = $el.data('slug');
          var jsonURL = $el.attr('href');
          var success = function(obj) {
            logger.log('teamMembers', 'Team member selected and loaded: %s', obj.slug);

            if (!teamMembers.hasOwnProperty(obj.slug)) {
              logger.log('teamMembers', 'Caching team member: %O', obj);
              teamMembers[obj.slug] = obj;
            }

            var html = templates.teamMemberDetail(obj);

            $detailArea.html(html);
            $fadeWrap.addClass('visible');
            resetMaxHeight();
          };
          var resetMaxHeight = function() {
            $viewer.afterTransition(function(evt) {
              logger.log('teamMembers', 'Resetting viewer height');
              $viewer.css('maxHeight', '');
              viewerHeight = $viewer.height();
              $viewer.css('maxHeight', viewerHeight);
              logger.log('teamMembers', 'Viewer height is now %d', viewerHeight);
            }, true).css('maxHeight', viewerHeight);
          };

          if (scrollY !== detailY) {
            TweenLite.to(window, 0.5, { scrollTo: { y: detailY } });
          }

          if (!$viewer.data('visible')) {
            resetMaxHeight();
          }

          $fadeWrap.transRemoveClass('visible', function() {
            if (teamMembers.hasOwnProperty(slug)) {
              success(teamMembers[slug]);
              return;
            }

            ajax = $.ajax(jsonURL, {
              type: 'GET',
              dataType: 'json'
            });

            ajax.success(success);
          });

          return false;
        });
      });
    },

    eventCategoryPicker: function() {
      return this.each(function() {
        logger.log('categoryPicker', 'Setting up event category picker on %O', this);

        var $el     = $(this);
        var $picker = $el.find('.category-picker');

        // disable form submission
        $el.on('submit', function() { return false; });

        // redirect to event category on selection
        $picker.on('change', function(evt) {
          var slug = $picker.val();

          logger.log('categoryPicker', 'Redirecting to category: %s', slug);
        });
      });
    },

    stitchScroll: function() {
      logger.log('stitchScroll', 'Getting stitch offsets and binding scroll handler');

      // no stitch sections, no nothing
      if (!this.length) {
        logger.log('stitchScroll', 'No stitches found');
        return this;
      }

      // do nothing if browser doesn't support pushState
      if (!(has(window, 'history') && has(window.history, 'pushState'))) {
        return this;
      }

      var currentStitch = null;
      var lastStitch    = null;
      var $win          = $(window);
      var $stitches     = $(this);

      var getOffsets = function() {
        return $stitches.map(function() {
          var offset = $(this).offset().top;

          return {
            element: $(this),
            offset: Math.round(offset)
          };
        }).get();
      };

      var offsets = getOffsets();

      logger.log('stitchScroll', 'Stitch offsets are: %O', offsets);

      var resizeHandler = throttle(function() {
        offsets = getOffsets();
        logger.log('stitchScroll', 'Stitch offsets are: %O', offsets);
      });

      var scrollHandler = throttle(function() {
        var scrollTop   = $win.scrollTop();
        var firstStitch = offsets[0];

        // remember what the previous stitch was for comparison
        lastStitch = currentStitch;

        if (scrollTop < firstStitch.offset) {
          currentStitch = null;
        } else {
          var result = find(offsets, function(offset) {
            return offset.offset >= scrollTop;
          });

          if (!isUndefined(result)) {
            currentStitch = result;
          }
        }

        if (!isUndefined(currentStitch) && currentStitch !== lastStitch) {
          logger.log('stitchScroll', 'Current stitch: %O', currentStitch);

          var path = currentStitch.element.data('url');

          logger.log('stitchScroll', 'Pushing history state to %s', path);
          window.history.pushState({ offset: currentStitch.offset }, '', path);
        }
      }, 100);

      logger.log('stitchScroll', 'Binding resize and scroll handlers to window');

      $win.on('resize', resizeHandler).on('scroll', scrollHandler);

      return this;
    },

    contactForm: function() {
      logger.log('contactForm', 'Binding footer contact form submit handler');

      return this.on('submit', function(evt) {
        var $el         = $(this);
        var name        = $el.find('#contact-name').val();
        var email       = $el.find('#contact-email').val();
        var message     = $el.find('#contact-message').val();
        var formID      = $el.data('formId');
        var route       = 'forms/' + formID + '/entries';
        var signature   = gforms.getSignature(route, 'POST');
        var urlTemplate = Handlebars.compile('/gravityformsapi/{{ route }}?api_key={{ api_key }}&signature={{ signature }}&expires={{ expires }}');
        var fullURL     = urlTemplate({
          route: route,
          api_key: encodeURIComponent(config.gravityForms.apiKey),
          signature: encodeURIComponent(signature.signature),
          expires: encodeURIComponent(signature.expires)
        });

        logger.log('form', 'Contact form submission: %O', {
          name: name,
          email: email,
          message: message,
          formID: formID,
          route: route
        });

        var ajax = $.ajax(fullURL, {
          accepts: 'application/json',
          type: 'POST',
          dataType: 'json',
          contentType: 'application/json',
          data: JSON.stringify([{
            '1': name,
            '2': email,
            '3': message
          }])
        });

        ajax.success(function(json, txt, xhr) {
          logger.log('ajax', 'Received response from server: %O', json);
          $el[0].reset();
        });

        return false;
      });
    }

  });

})(window);
