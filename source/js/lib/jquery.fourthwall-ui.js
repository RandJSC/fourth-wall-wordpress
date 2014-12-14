/**
 * Fourth Wall Events
 * UI Functions
 */

/* jshint -W064 */
/* global Modernizr, FileReader, JSON */

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
  var sortBy      = require('lodash.sortby');
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
  var colors      = require('./colors');

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
          '&ndash;' +
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
          var url = $picker.val();

          if (url) {
            logger.log('categoryPicker', 'Redirecting to category: %s', url);
            window.location.pathname = url;
          } else {
            logger.log('categoryPicker', 'Redirecting to unfiltered gallery archive');
            window.location.pathname = $picker.data('landingPage');
          }
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
      }, 100);

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
    },

    setupResponsiveBackgrounds: function(options) {
      if (!this.length) return this;

      logger.log('stitchBackgrounds', 'Setting up responsive stitch backgrounds');

      var defaults = {
        throttle: 50,
        dataKey: 'data-backgrounds'
      };
      var opts     = assign(defaults, options);

      // We only care about stitch sections w/ data-backgrounds attributes
      var $stitches     = this.filter('[' + opts.dataKey + ']');

      // Iterate through breakpoints for each stitch every time the window is resized
      var resizeHandler = throttle(function(evt) {
        var $win  = $(window);
        var width = $win.width();

        //logger.log('stitchBackgrounds:verbose', 'Window resized: %d', width);

        $stitches.each(function() {
          var $stitch          = $(this);
          var $content         = $stitch.find('.post-content');
          var breakpoints      = $stitch.data('_backgrounds');
          var oldBreakpoint    = $stitch.data('oldBreakpoint');
          var oldMin           = oldBreakpoint ? parseInt(oldBreakpoint.minWidth, 10) : 0;
          var newBreakpoint    = find(breakpoints, function(bp) {
            return width >= parseInt(bp.minWidth, 10);
          });
          var newMin           = parseInt(newBreakpoint.minWidth, 10);

          if (!oldBreakpoint || oldMin !== newMin) {
            logger.log(
              'stitchBackgrounds',
              'Switching stitch background to min-width: %d for %O %O',
              newMin,
              $stitch[0],
              newBreakpoint
            );

            $stitch.data('oldBreakpoint', newBreakpoint).css({
              backgroundImage: 'url(' + newBreakpoint.backgroundImage + ')',
              backgroundSize: newBreakpoint.backgroundSize,
              backgroundPosition: newBreakpoint.backgroundPosition,
              backgroundRepeat: newBreakpoint.backgroundRepeat
            });

            var rgba = colors.hexToRGBA(newBreakpoint.backgroundColor, parseInt(newBreakpoint.colorOpacity, 10) / 100);
            $content.css({
              color: newBreakpoint.textColor,
              backgroundColor: colors.hexToRGBA(newBreakpoint.backgroundColor, (parseInt(newBreakpoint.colorOpacity, 10) / 100))
            });
          }
        });
      }, opts.throttle);

      // Parse, sort, and store stitch background JSON
      $stitches.each(function() {
        var backgrounds = $(this).data('backgrounds');

        backgrounds     = sortBy(backgrounds, function(bg) {
          return parseInt(bg.minWidth, 10);
        });
        backgrounds.reverse();

        $(this).data('_backgrounds', backgrounds);
      });

      $(window).on('resize', resizeHandler);
      resizeHandler();

      return this;
    },

    hireUsForm: function(options) {
      options      = options ? options : {};
      var defaults = {
        fileTypes: [
          'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // *.docx
          'application/msword',                                                      // *.doc
          'application/pdf',                                                         // *.pdf
          'application/vnd.oasis.opendocument.text',                                 // *.odt
          'text/plain',                                                              // *.txt
          'text/richtext'                                                            // *.rtf
        ]
      };
      var opts     = assign(defaults, options);

      return this.each(function() {
        logger.log('hireUsForm', 'Setting up Hire Us form');

        var $el        = $(this);
        var $fileInput = $el.find('input[type="file"]');
        var $rfpData   = $el.find('input#hire-rfp-file-data');
        var $rfpMime   = $el.find('input#hire-rfp-file-mime-type');
        var $rfpName   = $el.find('input#hire-rfp-file-name');
        var $submit    = $el.find('#hire-submit');

        if (!window.hasOwnProperty('FileReader') || !window.hasOwnProperty('File')) {
          var $rfpParagraph = $fileInput.closest('p');
          $rfpParagraph.html('<em>Your browser does not support file uploads. To send us an RFP, please email it to info@fourthwallevents.com.</em>');
          $fileInput = $([]);
        }

        $fileInput.on('change', function() {
          var $input     = $(this);
          var input      = $input[0];
          var file       = input.files[0];
          var mimeType   = find(opts.fileTypes, function(ft) { return ft === file.type; });

          logger.log('hireUsForm:rfpInput', 'User added a file to RFP input: %O', file);

          if (isUndefined(mimeType)) {
            logger.log('hireUsForm:rfpInput', 'Invalid MIME type: "%s". Resetting RFP file input.', file.type);
            $input.val('');
            $rfpMime.val('');
            $rfpName.val('');
            window.alert('Invalid file format! Only PDFs, MS Word documents, and text files are allowed.');
            return false;
          }

          $rfpMime.val(mimeType);
          $rfpName.val(file.name);

          logger.log('hireUsForm:rfpInput', 'Disabling form submission until RFP file is read.');

          $submit.prop('disabled', true);

          var reader       = new FileReader();
          reader.onloadend = function() {
            logger.log('hireUsForm:rfpInput', 'Finished reading RFP file as data URL.');

            $rfpData.val(reader.result);

            logger.log('hireUsForm:rfpInput', 'Re-enabling form submission.');

            $submit.prop('disabled', false);
          };

          reader.readAsDataURL(file);
        });

        $el.on('submit', function() {
          logger.log('hireUsForm:submission', 'Submitting "Hire Us" form');

          var jsonSubmission, ajax;
          var submission = {};
          var $inputs    = $el.find('input, select');
          var submitURL  = $el.attr('action');

          $inputs.each(function() {
            var $input = $(this);

            // skip file input, use hidden field instead
            if ($input.attr('type') !== 'file') {
              submission[ String($input.attr('name')) ] = $input.val();
            }
          });

          logger.log('hireUsForm:submission', 'JSON-encoding submission object: %O', submission);

          jsonSubmission = JSON.stringify(submission);

          ajax = $.ajax(submitURL, {
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            accepts: 'application/json',
            data: jsonSubmission,
            beforeSend: function(xhr, settings) {
              logger.log('hireUsForm:submission:ajax', 'Sending JSON form data to server');
            }
          });

          ajax.success(function(json) {
            logger.log('hireUsForm:submission:ajax', 'Received response from server: %O', json);
          });

          return false;
        });
      });
    }

  });

})(window);
