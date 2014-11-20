<?php
global $fwe_settings;

if (array_key_exists('where_weve_been_intro', $fwe_settings) && !empty($fwe_settings['where_weve_been_intro'])):
?>
  <div class="archive-intro">
    <?php echo apply_filters('the_content', $fwe_settings['where_weve_been_intro']); ?>
  </div>
<?php endif; ?>
