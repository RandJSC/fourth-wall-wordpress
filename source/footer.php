          <?php
          global $fwe_settings, $theme_uri;

          $cta = fwe_get_cta();

          if ($cta):
            $bg_img    = get_post_meta($cta->ID, 'background_image', true);
            $bg_img    = wp_get_attachment_image_src($bg_img, 'full');
            $bg_size   = get_post_meta($cta->ID, 'background_size', true);
            $bg_pos    = get_post_meta($cta->ID, 'background_position', true);
            $bg_repeat = get_post_meta($cta->ID, 'background_repeat', true);
            $bg_color  = get_post_meta($cta->ID, 'background_color', true);
            $link_url  = get_post_meta($cta->ID, 'link_url', true);
            $btn_txt   = get_post_meta($cta->ID, 'button_text', true);
            $target    = fwe_is_url_local($link_url) ? '' : ' target="_blank"';

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

                  <?php if (!empty($btn_txt) && !empty($link_url)): ?>
                    <a class="button center block" href="<?php echo esc_url($link_url); ?>"<?php echo $target; ?>>
                      <?php echo $btn_txt; ?>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endif; ?>
        </div><!-- /#main-content -->

        <footer id="socials">
          <?php
          wp_nav_menu(array(
            'theme_location' => 'social_links',
            'walker' => new Walker_FWE_Socials,
          ));
          ?>
        </footer>

        <footer id="contact">
          <h2>Contact</h2>
          <p>Drop us a line. Give us a call. Let us know how we can help get your audience talking.</p>
          <div itemscope itemtype="http://schema.org/LocalBusiness">
            <meta itemprop="name" content="<?php echo esc_attr($fwe_settings['company_name']); ?>">
            <meta itemprop="description" content="<?php echo esc_attr($fwe_settings['description']); ?>">

            <address itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
              <span itemprop="streetAddress"><?php echo $fwe_settings['address']; ?></span>
              <span itemprop="addressLocality"><?php echo $fwe_settings['city']; ?></span>
              <span itemprop="addressRegion"><?php echo $fwe_settings['state']; ?></span>
              <span itemprop="postalCode"><?php echo $fwe_settings['zip_code']; ?></span>
            </address>
            
            <div class="email">
              <a href="mailto:<?php echo esc_attr($fwe_settings['contact_email']); ?>" itemprop="email">
                <?php echo $fwe_settings['contact_email']; ?>
              </a>
            </div>

            <div class="phone">
              <span itemprop="telephone">
                <?php echo $fwe_settings['phone']; ?>
              </span>
            </div>
          </div>
        </footer>

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
