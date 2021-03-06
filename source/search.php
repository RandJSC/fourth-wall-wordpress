<?php
get_header();

global $fwe_settings;

$banner = $fwe_settings['search_banner'];
?>

<section class="banner search">
  <figure id="page-banner">
    <?php if ($banner): ?>
      <?php $banner_src = wp_get_attachment_image_src($banner, 'full'); ?>
      <img src="<?php echo $banner_src[0]; ?>" alt="Search Results" width="100%">
    <?php endif; ?>
    <figcaption>Search Results</figcaption>
  </figure>
</section>

<section id="main-page-content" class="content-section">
  <?php if (!have_posts()): ?>
    <div class="search-header no-results">
      <h1>No Search Results Found</h1>
      <p>
        We're sorry, we couldn't find anything that matches &ldquo;<strong><em><?php the_search_query(); ?></em></strong>&rdquo;.
        Would you like to go <a href="<?php echo home_url(); ?>">back to the homepage</a>?
      </p>
    </div>
  <?php else: ?>
    <div class="search-header">
      <h1>Your Search Results:</h1>
      <p id="search-query">
        <?php the_search_query(); ?>
      </p>
    </div>

    <ol class="search-results">
      <?php while (have_posts()): the_post(); ?>
        <li class="result">
          <div class="result-internal">
            <h2>
              <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
              </a>
            </h2>
            <div class="result-excerpt">
              <?php the_excerpt(); ?>
            </div>
          </div>
        </li>
      <?php endwhile; ?>
    </ol>
  <?php endif; ?>

  <?php fwe_pagination_links(); ?>
</section>

<?php get_footer(); ?>
