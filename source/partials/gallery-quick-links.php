<section id="quick-links" class="gallery">
  <?php
  wp_nav_menu(array(
    'theme_location' => 'gallery_quick_links',
    'container'      => 'nav',
    'fallback_cb'    => false,
    'walker'         => new Walker_FWE_QuickLinks(),
  ));
  ?>
</section>
