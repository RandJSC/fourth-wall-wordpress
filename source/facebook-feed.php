<?php
/**
 * Facebook Feed Partial
 */

global $fwe_settings;

if (array_key_exists('facebook_page_url', $fwe_settings) && $fwe_settings['facebook_page_url']):
?>
  <section id="facebook" class="content-section bg-none">
    <div class="section-inner">
      <h2>Fourth Wall on Facebook</h2>

      <div
        class="fb-like-box"
        data-href="<?php echo esc_url($fwe_settings['facebook_page_url']); ?>"
        data-width="<?php echo  (int) $fwe_settings['facebook_widget_width']; ?>"
        data-height="<?php echo (int) $fwe_settings['facebook_widget_height']; ?>"
        data-colorscheme="light"
        data-show-faces="false"
        data-header="false"
        data-stream="true"
        data-show-border="true"></div>

      <a href="<?php echo esc_url($fwe_settings['facebook_page_url']); ?>" class="button block center">
        Like on Facebook
        <span class="button-icon right fa fa-thumbs-up big"></span>
      </a>
    </div>
  </section>
<?php endif; ?>
