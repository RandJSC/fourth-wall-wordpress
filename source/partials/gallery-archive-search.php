<?php
$categories   = get_terms('event_category', array(
  'hide_empty' => false,
));
$landing_page = fwe_relative_url(get_post_type_archive_link('gallery'));
?>

<section class="archive-filter">
  <form action="" method="get" id="event-categories">

    <select class="category-picker" name="category" data-landing-page="<?php echo $landing_page; ?>">
      <option value="">&ndash; Event Categories &ndash;</option>

      <?php foreach ($categories as $category): ?>
        <?php
        $term_link = get_term_link($category, $category->taxonomy);
        $term_link = fwe_relative_url($term_link);
        ?>
        <option value="<?php echo $term_link; ?>">
          <?php echo $category->name; ?>
        </option>
      <?php endforeach; ?>
    </select>

  </form>
</section>
