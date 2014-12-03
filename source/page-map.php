<?php
/*
Template Name: Map Page
*/

get_header();

global $post, $fwe_settings;

$banner      = fwe_get_page_banner($post->ID);
$api_key     = $fwe_settings['google_maps_api_key'];
$enable_zoom = $fwe_settings['map_enable_zoom'] ? 'true' : 'false';
?>

<?php include(locate_template('partials/subpage-banner.php')); ?>

<?php if (have_posts()): while (have_posts()): the_post(); ?>

  <?php include(locate_template('partials/subpage-main-content.php')); ?>

<?php endwhile; endif; ?>

<section id="event-map">
  <div
    id="map-canvas"
    data-starting-latitude="<?php echo $fwe_settings['map_starting_latitude']; ?>"
    data-starting-longitude="<?php echo $fwe_settings['map_starting_longitude']; ?>"
    data-zoom="<?php echo $fwe_settings['map_zoom_level']; ?>"
    data-enable-zoom="<?php echo $enable_zoom; ?>"
    data-min-zoom="<?php echo $fwe_settings['map_min_zoom']; ?>"
    data-max-zoom="<?php echo $fwe_settings['map_max_zoom']; ?>"
    data-pins-url="<?php echo site_url('/wp-json/fwe/locations'); ?>"></div>
</section>

<section id="location-content">
  <div class="spinner"></div>
  <div class="content"></div>
</section>

<script type="text/x-handlebars-template" id="tpl-location-content">
  <h1>{{ title }}</h1>

  {{#if case_studies}}
    <h2>Case Studies</h2>
    <ol>
      {{#each case_studies}}
        {{> item}}
      {{/each}}
    </ol>
  {{/if}}

  {{#if galleries}}
    <h2>Galleries</h2>
    <ol>
      {{#each galleries}}
        {{> item}}
      {{/each}}
    </ol>
  {{/if}}
</script>

<script type="text/x-handlebars-template" id="tpl-item-partial">
  <li>
    <div class="thumbnail">
      {{#if this.featured_image}}
        <a href="{{ this.link }}">
          {{#with this.featured_image.attachment_meta.sizes.thumbnail}}
            <img src="{{ url }}" width="{{ width }}" height="{{ height }}">
          {{/with}}
        </a>
      {{/if}}
    </div>
    <div class="item-content">
      <h3>
        <a href="{{ this.link }}">{{ this.title }}</a>
      </h3>
      <div class="date">
        {{ formatDate this.event_date }}
      </div>

      {{{ this.excerpt }}}
    </div>
  </li>
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $api_key; ?>"></script>
<script src="<?php echo $theme_uri; ?>/js/event-map.js"></script>

<?php get_footer(); ?>
