<?php
$categories = get_terms('event_category', array(
  'hide_empty' => false,
));
?>

<section class="archive-filter">
  <form action="" method="get" id="event-categories">

    <select class="category-picker" name="category">
      <option value="">&ndash; Event Categories &ndash;</option>

      <?php foreach ($categories as $category): ?>
        <option value="<?php echo $category->slug; ?>">
          <?php echo $category->name; ?>
        </option>
      <?php endforeach; ?>
    </select>

  </form>
</section>
