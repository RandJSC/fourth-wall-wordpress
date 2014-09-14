        <?php
        global $post;

        if ($post && property_exists($post, 'ID')) {
          $post_id = $post->ID;
          $cta_id = get_post_meta($post_id, 'call_to_action', true);
          var_dump($cta_id);
        }
        ?>
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
