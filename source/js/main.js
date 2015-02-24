/**
 * Fourth Wall Events
 * Main JavaScript
 *
 * by Fifth Room Creative <info@fifthroomcreative.com>
 */

/* global matchMedia, addthis */
/* jshint -W064 */

(function(window, undefined) {

  'use strict';

  var ie         = require('./lib/ie-detect');
  var config     = require('./lib/config');
  var $          = require('jquery');
  var fastClick  = require('fastclick');
  var fweUtil    = require('./lib/jquery.fourthwall-util');
  var fweUI      = require('./lib/jquery.fourthwall-ui');
  var Slick      = require('slick-carousel');
  var Snap       = require('./lib/snap.svg.custom');
  var Handlebars = require('handlebars');
  var logger     = require('./lib/logger').getInstance();
  var features   = require('./lib/feature-detection');
  var matchMedia = require('./lib/match-media-polyfill');

  // remove me in production
  if (config.debug) {
    var debug       = require('./lib/jquery.debug');
    var MemoryStats = require('memory-stats/memory-stats');

    if (config.showMemoryStats) {
      var stats = new MemoryStats();
      stats.domElement.style.position = 'fixed';
      stats.domElement.style.right    = '0px';
      stats.domElement.style.bottom   = '0px';
      stats.domElement.style.zIndex   = 1000;
      document.body.appendChild(stats.domElement);

      window.requestAnimationFrame(function rafLoop() {
        stats.update();
        window.requestAnimationFrame(rafLoop);
      });
    }
  }

  $(function() {

    logger.log('timing', 'Begin docReady');

    $(document.documentElement).removeClass('no-js').addClass('js');

    var burgerSvg           = Snap('#hamburger-img');
    var $container          = $('#master-container');
    var $hamburger          = $('#hamburger');
    var $contactForm        = $('#contact-form form');
    var $testimonialSliders = $('.testimonial-slider');
    var $accordions         = $('.accordion');
    var $homepageSlider     = $('.slider .slides');
    var $pageSlider         = $('.main-page-slider .slides');
    var $stitchSliders      = $('.stitch-slider .slides');
    var $teamMembers        = $('.team-members');
    var $gallerySliders     = $('.gallery-slider .slides');
    var $categoryPicker     = $('#event-categories');
    var $stitches           = $('section.stitch');
    var $hireForm           = $('#hire-form form');
    var $nameTitles         = $('.name-title');
    var $teamThumbs         = $('a.team-member');
    var $quickLinks         = $('#quick-links a');
    var $emailSignup        = $('#email-signup form');
    var $logoGrids          = $('.logo-grid');
    var $cta                = $('.call-to-action');
    var $banner             = $('section.banner');

    // Console access to libraries (debug mode only):
    if (config.debug) {
      window.jQuery        = window.$ = $;
      window.logger        = logger;
      window.FastClick     = fastClick;
      window.Snap          = Snap;
      window.Handlebars    = Handlebars;
      window.config        = config;
      window.ie            = ie;
    } else {
      // If not in debug mode, disable all logged messages
      logger.options.groupsEnabled = false;
      logger.options.disabled = true;
    }

    // Setup AddThis sharing buttons
    if (window.hasOwnProperty('addthis')) {
      logger.log('addthis', 'Setting up AddThis share link');

      addthis.button('.addthis-share', {
        ui_offset_top: 15
      });
    }

    // Vertically center quicklink text
    $quickLinks.verticallyCenter({ height: 'tallest' });

    var navListener = function navListener(mq) {
      var $mainNav   = $('#main-nav');
      var $mobileNav = $('#mobile-nav');

      if (mq.matches && $mobileNav.children().length) {
        logger.log('mobileNav', 'Moving mobile nav contents to main nav container');
        $mobileNav.children().prependTo($mainNav);
      } else if (!mq.matches && $mainNav.children().length) {
        logger.log('mobileNav', 'Moving main nav contents to mobile nav container');
        $mainNav.children().prependTo($mobileNav);
      } else {
        logger.log('mobileNav', 'Nothing needs to be done');
      }
    };

    // Tag offsite links to open in new tab/window
    $('a').newWindowIfOffsite();

    // Attach fastclick to body
    fastClick(document.body);

    if (features.matchMedia) {
      var navMQ = matchMedia('screen and (min-width: ' + config.breakpoints.aboveTablet + 'px)');
      navListener(navMQ);

      if (features.matchMediaListener) {
        navMQ.addListener(navListener);
      }
    }

    // Team Members Stuff
    if (!features.touch) {
      $nameTitles.verticallyCenter();

      $teamThumbs.hover(function() {
        $(this).toggleClass('hovering');
      });
    }

    $hamburger.toggleNav($container, burgerSvg);

    // Banner height
    $banner.fixBannerHeight();

    // Homepage slider (if present)
    $homepageSlider.homepageSlider({ autoplay: true, autoplaySpeed: 5000 });

    // Main Page slider (on generic pages)
    $pageSlider.photoSlider({
      container: '.main-page-slider',
      popup: true
    });

    // Photo sliders
    $stitchSliders.photoSlider({ popup: true });

    // Testimonial sliders
    $testimonialSliders.testimonialSlider();

    // Accordions
    $accordions.accordion();

    // Team Members viewer shortcode
    $teamMembers.teamMembersShortcode();

    // Gallery sliders
    $gallerySliders.photoSlider({
      popup: true,
      container: '.gallery-slider',
      navLinks: '.photo-grid .photo a'
    });

    // Event category picker
    $categoryPicker.eventCategoryPicker();

    // Stitch pushState scroll watcher
    $stitches.stitchScroll();

    // Set up breakpoints for responsive stitch backgrounds
    $stitches.setupResponsiveBackgrounds();

    // Footer contact form
    $contactForm.contactForm();

    // Hire Us form
    $hireForm.hireUsForm();

    // AJAX email subscription form
    $emailSignup.subscribeForm();

    // Who We've Worked With, etc. logo grids
    $logoGrids.logoGrid();

    // Vertically center CTA button
    var centerCTA = function() {
      logger.log('callToAction:button', 'Vertically centering Call To Action button');
      var $container = $cta.find('.cta-contents');
      var $button    = $cta.find('.cta-button');
      var marginTop  = ($container.height() - $button.height()) / 2;

      $button.css('marginTop', marginTop + 'px');
    };

    centerCTA();
    $(window).on('resize', centerCTA);

    logger.log('timing', 'End docReady');

  });

})(window);
