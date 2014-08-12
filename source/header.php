<?php
$theme_uri = get_stylesheet_directory_uri();
$settings  = get_option('fwe_theme_settings');
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie10 lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie10 lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie10 lt-ie9" lang="en"> <![endif]-->
<!--[if IE 9]> <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">

  <title><?php wp_title(); ?></title>

  <?php // [todo] - Favicons and Apple touch icon ?>

  <?php // Google Web Fonts: Source Sans Pro ?>
  <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,400italic,600italic' rel='stylesheet' type='text/css'>

  <script src="<?php echo $theme_uri; ?>/js/modernizr.min.js"></script>
  <script src="<?php echo $theme_uri; ?>/js/modernizr-tests.min.js"></script>
  <script data-main="<?php echo $theme_uri; ?>/js/main.min.js"
          src="<?php echo $theme_uri; ?>/js/require.js"></script>
  <script>
    // Asynchronously load matchMedia polyfill if needed
    if (!Modernizr.matchmedia) {
      var s    = document.createElement('script');
      var head = document.getElementsByTagName('head')[0];
      s.src    = '<?php echo $theme_uri; ?>/js/matchMedia.js';
      head.appendChild(s);
    }
  </script>

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <div id="master-container" class="full-width">
    <div id="main-nav" class="menu">
      <?php
      get_search_form();

      wp_nav_menu(array(
        'theme_location' => 'main-nav',
        'container'      => 'nav',
        'fallback_cb'    => false,
      ));
      ?>
    </div><!-- /#main-nav -->
    
    <div class="pusher">
      <div class="content">
        <div class="content-inner">
          <header id="logo-nav-btn" class="container">
            <a href="<?php echo site_url('/'); ?>" id="logo">
              <img src="<?php echo $theme_uri; ?>/img/fwe-logo.svg" alt="Fourth Wall Events">
            </a><!-- /#logo -->

            <a href="#main-nav" id="hamburger">
            
              <svg xmlns="http://www.w3.org/2000/svg" width="34" height="26" id="hamburger-img">
                <g fill="#fff" stroke="#008fd1" stroke-width="3.873" stroke-linecap="square" stroke-linejoin="round">
                  <path d="M1.97 2.122h30.127v.127H1.97z"/>
                  <path d="M1.97 12.994h30.126v.127H1.92z"/>
                  <path d="M1.97 23.916H32.11v.127H1.983z"/>
                </g>
              </svg>
 
            </a><!-- /#hamburger -->
          </header><!-- /#logo-nav-search -->
          <section id="main-content">
