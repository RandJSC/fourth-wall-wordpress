<?php
global $fwe_settings;

if (fwe_theme_option_exists('where_weve_been_intro') && !empty($fwe_settings['where_weve_been_intro'])):
?>
  <div class="archive-intro">
    <?php echo apply_filters('the_content', $fwe_settings['where_weve_been_intro']); ?>
  </div>
<?php endif; ?>
