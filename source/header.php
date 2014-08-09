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
