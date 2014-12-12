<section id="quick-links" class="posts">
  <?php
  wp_nav_menu(array(
    'theme_location' => 'post_quick_links',
    'container'      => 'nav',
    'fallback_cb'    => false,
    'walker'         => new Walker_FWE_QuickLinks(),
  ));
  ?>
</section>
