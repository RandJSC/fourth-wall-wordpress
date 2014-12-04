<?php
/**
 * Fourth Wall Events
 * Author Page Template
 */

get_header();

global $fwe_settings;

$banner = $fwe_settings['whats_new_banner'];
$banner = wp_get_attachment_image_src($banner, 'full');
?>

<?php if ($banner): ?>
  <section class="banner">
    <figure id="page-banner">
      <img src="<?php echo $banner[0]; ?>" alt="What's New" width="100%">
      <figcaption>What's New</figcaption>
    </figure>
  </section>
<?php endif; ?>

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

<section id="main-page-content" class="content-section">
  <article class="author">
    <div class="headshot"></div>
  </article>
</section>
