        <?php
        $cta = fwe_get_cta();

        if ($cta):
          $bg_img    = get_post_meta($cta->ID, 'background_image', true);
          $bg_img    = wp_get_attachment_image_src($bg_img, 'full');
          $bg_size   = get_post_meta($cta->ID, 'background_size', true);
          $bg_pos    = get_post_meta($cta->ID, 'background_position', true);
          $bg_repeat = get_post_meta($cta->ID, 'background_repeat', true);
          $bg_color  = get_post_meta($cta->ID, 'background_color', true);

          $style_attr = fwe_style_attribute(array(
            'background-image'    => "url('{$bg_img[0]}')",
            'background-size'     => $bg_size,
            'background-position' => $bg_pos,
            'background-repeat'   => $bg_repeat,
            'background-color'    => $bg_color,
          ));
        ?>
          <div class="call-to-action"<?php echo $style_attr; ?>>
            <div class="cta-body">
              <div class="cta-contents">
                <?php echo apply_filters('the_content', $cta->post_content); ?>
              </div>
            </div>
          </div>
        <?php endif; ?>
        </div><!-- /#main-content -->
        <footer id="footer-main">
          <?php
          $year = strftime('%Y');
          ?>
          <p class="copyright">
            Copyright &copy; <?php echo $year; ?> Fourth Wall Events, All Rights Reserved.
          </p>
        </footer><!-- /#footer-main -->
      </div><!-- /.content-inner -->
    </div><!-- /.content -->
  </div><!-- /#master-container -->

  <?php wp_footer(); ?>
</body>
</html>
