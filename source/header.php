<?php
global $fwe_settings, $theme_uri;
$theme_uri    = get_stylesheet_directory_uri();
$fwe_settings = get_option('fwe_settings');
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie11 lt-ie10 lt-ie9" lang="en"> <![endif]-->
<!--[if IE 9]> <html class="no-js lt-ie11 lt-ie10" lang="en"> <![endif]-->
<!--[if IE 10]> <html class="no-js lt-ie11" lang="en"> <![endif]-->
<!--[if gt IE 10]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <title><?php wp_title(); ?></title>

  <?php if ($fwe_settings['favicon_ico']): ?>
    <?php
    $ico_src     = wp_get_attachment_image_src($fwe_settings['favicon_ico'], 'full');
    $favicon_ico = $ico_src[0];
    ?>
    <link rel="shortcut icon" href="<?php echo $favicon_ico; ?>">
  <?php endif; ?>

  <?php if ($fwe_settings['favicon_png']): ?>
    <?php
    $png_src     = wp_get_attachment_image_src($fwe_settings['favicon_png'], 'full');
    $favicon_png = $png_src[0];
    ?>
    <link rel="icon" href="<?php echo $favicon_png; ?>">
  <?php endif; ?>

  <?php if ($fwe_settings['apple_touch_icon']): ?>
    <?php
    $touch_icon = wp_get_attachment_image_src($fwe_settings['apple_touch_icon'], 'full');
    $touch_icon = $touch_icon[0];
    ?>
    <link rel="apple-touch-icon-precomposed" href="<?php echo $touch_icon; ?>">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="<?php echo $touch_icon; ?>">
  <?php endif; ?>

  <script src="<?php echo $theme_uri; ?>/js/bundle.js"></script>

  <?php include(locate_template('partials/addthis.php')); ?>

  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <?php include(locate_template('partials/facebook-init.php')); ?>

  <div id="master-container" class="full-width">
    <div id="mobile-nav" class="menu">
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

            <div id="main-nav" class="menu">
              <?php
              get_search_form();

              wp_nav_menu(array(
                'theme_location' => 'main_nav',
                'container'      => 'nav',
                'fallback_cb'    => false,
              ));
              ?>
            </div>
          </header><!-- /#logo-nav-search -->
          <div id="main-content">
