<?php
$classes = array( 'posts' );

if (isset($border_class)) {
  $classes[] = $border_class;
}

$classes = 'class="' . implode(' ', $classes) . '"';
?>
<section id="quick-links" <?php echo $classes; ?>>
  <?php
  wp_nav_menu(array(
    'theme_location' => 'post_quick_links',
    'container'      => 'nav',
    'fallback_cb'    => false,
    'walker'         => new Walker_FWE_QuickLinks(),
    'link_before'    => '<span class="text">',
    'link_after'     => '</span>',
  ));
  ?>
</section>
