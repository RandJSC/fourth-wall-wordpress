<?php
get_header();

global $fwe_settings;

$banner = $fwe_settings['search_banner'];
?>

<?php if ($banner): ?>
  <?php
  $banner_src = wp_get_attachment_image_src($banner, 'full');
  ?>
  <section class="banner">
    <figure id="page-banner">
      <img src="<?php echo $banner_src[0]; ?>" alt="Search Results" width="100%">
      <figcaption>Search Results</figcaption>
    </figure>
  </section>
<?php endif; ?>

<section id="main-page-content" class="content-section">
  <?php if (!have_posts()): ?>
    <div class="search-header">
      <h1>No Search Results Found</h1>
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
          <h2>
            <a href="<?php the_permalink(); ?>">
              <?php the_title(); ?>
            </a>
          </h2>
          <div class="result-excerpt">
            <?php the_excerpt(); ?>
          </div>
        </li>
      <?php endwhile; ?>
    </ol>
  <?php endif; ?>
</section>

<?php get_footer(); ?>
