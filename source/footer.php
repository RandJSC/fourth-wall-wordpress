          <?php
          global $fwe_settings, $theme_uri;

          $cta = fwe_get_cta();

          if ($fwe_settings['address']) {
            $map_link = fwe_google_maps_link(array(
              'address'  => $fwe_settings['address'],
              'city'     => $fwe_settings['city'],
              'state'    => $fwe_settings['state'],
              'zip_code' => $fwe_settings['zip_code'],
            ));
          }


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
                  <div class="cta-text">
                    <?php echo apply_filters('the_content', $cta->post_content); ?>
                  </div>

                  <?php if (!empty($btn_txt) && !empty($link_url)): ?>
                    <div class="cta-button">
                      <a class="button center block" href="<?php echo esc_url($link_url); ?>"<?php echo $target; ?>>
                        <?php echo $btn_txt; ?>
                      </a>
                    </div>
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

          <div id="address" itemscope itemtype="http://schema.org/LocalBusiness">
            <meta itemprop="name" content="<?php echo esc_attr($fwe_settings['company_name']); ?>">
            <meta itemprop="description" content="<?php echo esc_attr($fwe_settings['description']); ?>">

            <p class="hide" itemprop="name"><?php echo $fwe_settings['company_name']; ?></p>
            <p class="hide" itemprop="description"><?php echo $fwe_settings['description']; ?></p>

            <div class="street-address contact">
              <div class="icon">
                <a href="<?php echo $map_link; ?>" target="_blank">
                  <span class="fa fa-map-marker"></span>
                </a>
              </div>

              <div class="info">
                <a href="<?php echo $map_link; ?>" target="_blank">
                  <address itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                    <span itemprop="streetAddress"><?php echo $fwe_settings['address']; ?>,</span>
                    <span itemprop="addressLocality"><?php echo $fwe_settings['city']; ?>,</span>
                    <span itemprop="addressRegion"><?php echo $fwe_settings['state']; ?></span>
                    <span itemprop="postalCode"><?php echo $fwe_settings['zip_code']; ?></span>
                  </address>
                </a>
              </div>
            </div>

            <div class="email contact">
              <div class="icon">
                <a href="mailto:<?php echo esc_attr($fwe_settings['contact_email']); ?>">
                  <span class="fa fa-envelope"></span>
                </a>
              </div>

              <div class="info">
                <a href="mailto:<?php echo esc_attr($fwe_settings['contact_email']); ?>">
                  <span itemprop="email"><?php echo $fwe_settings['contact_email']; ?></span>
                </a>
              </div>
            </div>

            <div class="phone contact">
              <div class="icon">
                <a href="tel://<?php echo esc_attr($fwe_settings['phone']); ?>">
                  <span class="fa fa-phone"></span>
                </a>
              </div>

              <div class="info">
                <a href="tel://<?php echo esc_attr($fwe_settings['phone']); ?>">
                  <span itemprop="telephone">
                    <?php echo $fwe_settings['phone']; ?>
                  </span>
                </a>
              </div>
            </div>
          </div>

          <div id="contact-form">
            <form action="" method="post" data-form-id="<?php echo $fwe_settings['contact_form_id']; ?>" data-confirmation="<?php echo esc_attr($fwe_settings['contact_success_message']); ?>">
              <div class="row">
                <p class="split">
                  <input type="text" placeholder="Your Name" name="contact_name" id="contact-name" required>
                </p>
                <p class="split">
                  <input type="email" placeholder="Your Email" name="contact_email" id="contact-email" required>
                </p>
              </div>
              <p>
                <textarea name="contact_message" id="contact-message"></textarea>
              </p>
              <p class="right">
                <button type="submit">
                  <span class="button-label">Submit &raquo;</span>
                </button>
              </p>
            </form>
          </div>

          <hr>

          <div id="footer-nav">
            <?php
            wp_nav_menu(array(
              'theme_location' => 'footer_nav',
              'fallback_cb'    => false,
            ));
            ?>
          </div>
        </footer>

        <footer id="copyright">
          <?php
          $year = strftime('%Y');
          ?>
          <p class="copyright-message">
            &copy; <?php echo $year; ?> Fourth Wall Events
          </p>
          <p class="credits">
            Designed and built by <a href="http://fifthroomcreative.com" target="_blank">Fifth Room Creative</a>
          </p>
        </footer><!-- /#footer-main -->

      </div><!-- /.content-inner -->
    </div><!-- /.content -->
  </div><!-- /#master-container -->

  <?php wp_footer(); ?>
  <script src="<?php echo $theme_uri; ?>/js/main.js"></script>
</body>
</html>
