<?php
/**
 * Fourth Wall Events
 * Utility Functions
 */

function fwe_get_cta() {
  global $post;

  if ($post && property_exists($post, 'ID')) {
    $post_id = $post->ID;
    $cta_id  = get_post_meta($post_id, 'call_to_action', true);

    if (!$cta_id) {
      return fwe_get_random_cta();
    }

    return get_post($cta_id);
  }

  return fwe_get_random_cta();
}

function fwe_get_random_cta() {
  $cta = get_posts(array(
    'posts_per_page' => 1,
    'orderby'        => 'rand',
    'post_type'      => 'call_to_action',
    'post_status'    => 'publish',
  ));

  if (!empty($cta)) {
    return $cta[0];
  }
  return null;
}

function fwe_style_attribute($params = array()) {
  $value = '';

  foreach ($params as $key => $val) {
    if (empty($val)) {
      continue;
    }
    $value .= "{$key}:{$val};";
  }

  if (!empty($value)) {
    $value = ' style="' . $value . '"';
    return $value;
  }

  return '';
}

function fwe_is_url_local($url) {
  if (!preg_match('/^https?\:\/\//', $url)) {
    return true;
  }

  $site_url  = site_url();
  $is_remote = strpos($url, $site_url) === false;

  return !$is_remote;
}

function fwe_google_maps_link($params = array()) {

  $url_base = 'https://maps.google.com/?q=';

  if (array_key_exists('address', $params)) {
    $pieces = array(
      $params['address'],
      $params['city'],
      $params['state'],
      $params['zip_code'],
    );
  } else {
    $pieces = $params;
  }

  if (is_array($pieces)) {
    $oneliner = implode(', ', $pieces);
  } else {
    $oneliner = $pieces;
  }

  $query = urlencode($oneliner);

  return $url_base . $query;
}

function fwe_gforms_request_signature($route, $method = 'GET') {

  $settings    = get_option('fwe_settings');

  if (array_key_exists('gforms_api_key', $settings) && array_key_exists('gforms_private_key', $settings)) {
    $api_key     = $settings['gforms_api_key'];
    $private_key = $settings['gforms_private_key'];
  } else {
    $api_key     = 'bf72b8cd58';
    $private_key = '3d86b92f6e1a864';
  }

  $expiration  = strtotime('+60 mins');
  $sign_string = sprintf('%s:%s:%s:%s', $api_key, $method, $route, $expires);
  $hash        = hash_hmac('sha1', $sign_string, $private_key, true);

  return rawurlencode(base64_encode($hash));
}

function fwe_is_post($post) {
  return is_a($post, 'WP_Post');
}

function fwe_list_hooked_functions($tag = false) {
  global $wp_filter;

  $hook = array();

  if ($tag) {
    $hook[$tag] = $wp_filter[$tag];

    if (!is_array($hook[$tag])) {
      trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
      return;
    }
  } else {
    $hook = $wp_filter;
    ksort($hook);
  }

  foreach ($hook as $tag => $priority) {
    var_dump($tag, $priority);
  }
}

function fwe_tag_list($tags = array()) {
  if (empty($tags) || !is_array($tags)) return false;

  $links = array_map(function($tag) {
    $link = get_term_link($tag->term_id, $tag->taxonomy);
    return '<a href="' . $link . '">' . $tag->name . '</a>';
  }, $tags);

  echo implode(', ', $links);
}

function fwe_get_page_banner($post_id = null) {
  if (!$post_id) {
    global $post;
    $post_id = $post->ID;
  }

  $page    = get_post($post_id);
  $banner  = get_post_meta($post_id, 'banner_image', true);
  $caption = get_post_meta($post_id, 'banner_caption', true);

  if (!$banner) {
    if ($page->post_parent !== 0) {
      return fwe_get_page_banner($page->post_parent);
    } else {
      return null;
    }
  }

  return array('banner' => $banner, 'caption' => $caption);
}

function fwe_lazy_load_img_src($src, $index) {
  return ($index === 0) ? 'src="' . $src . '"' : 'data-lazy="' . $src . '"';
}

function fwe_pagination_links($query = null) {
  global $paged, $wp_query;

  $paged = $paged ? $paged : 1;


  if (is_null($query)) {
    $query = $wp_query;
  }

  $pages = $query->max_num_pages;
  $pages = $pages ? $pages : 1;

  if ($pages > 1):
?>
    <div class="pagination">
      <a class="previous" href="<?php echo get_pagenum_link($paged - 1); ?>">
        <?php if ($paged > 1): ?>
          <span class="arrow">
            <span class="fa fa-arrow-left"></span>
          </span>
          <span class="link-text">Prev</span>
        <?php endif; ?>
      </a>

      <span class="current">
        <?php echo $paged; ?>
      </span>

      <a class="next" href="<?php echo get_pagenum_link($paged + 1); ?>">
        <?php if ($paged <= $pages - 1): ?>
          <span class="link-text">Next</span>
          <span class="arrow">
            <span class="fa fa-arrow-right"></span>
          </span>
        <?php endif; ?>
      </a>
    </div>
<?php
  endif;
}

function fwe_get_stitch_vars($page_id = 0) {
  if ($page_id === 0) return array();

  $stitch_page    = get_post($page_id);
  $stitch_content = get_post_meta($page_id, 'stitch_content', true);
  $stitch_content = apply_filters('the_content', $stitch_content);
  $pad_content    = get_post_meta($page_id, 'pad_content', true);
  $pad_content    = ($pad_content === 'no') ? false : true;
  $pad_content    = $pad_content ? ' padded' : '';
  $pad_header     = get_post_meta($page_id, 'pad_header', true);
  $pad_header     = ($pad_header === 'no') ? false : true;
  $pad_header     = $pad_header ? ' padded' : '';
  $slider_images  = get_post_meta($page_id, 'slider_images', true);
  $has_slides     = !empty($slider_images) && !empty($slider_images[0][0]);
  $slide_count    = $has_slides ? count($slider_images['image']) : 0;
  $backgrounds    = get_post_meta($page_id, 'page_backgrounds', true);
  $white_header   = '';

  if (!empty($backgrounds) && $backgrounds['background_image'][0]) {
    $white_header = ' white';
  }

  return array(
    'stitch_page'    => $stitch_page,
    'stitch_id'      => $page_id,
    'pad_header'     => $pad_header,
    'pad_content'    => $pad_content,
    'white_header'   => $white_header,
    'has_slides'     => $has_slides,
    'slide_count'    => $slide_count,
    'slider_images'  => $slider_images,
    'stitch_content' => $stitch_content,
  );
}

function fwe_get_surname($title) {
  $suffixes    = array('Jr', 'Jr.', 'II', 'III', 'IV', 'V');
  $name_pieces = array_reverse( explode( ' ', $title ) );
  $surname     = in_array( $name_pieces[0], $suffixes ) ? $name_pieces[1] : $name_pieces[0];
  $surname     = str_replace( ',', '', $surname );

  return $surname;
}

function fwe_term_links($terms) {
  $links = array_map(function($term) {
    return '<a href="' . get_term_link($term, $term->taxonomy) . '">' . $term->name . '</a>';
  }, $terms);

  return implode(', ', $links);
}

function fwe_relative_url($abs_url) {
  if (strpos($abs_url, 'http') !== 0) return $abs_url;
  return parse_url($abs_url, PHP_URL_PATH);
}

function fwe_build_page_background_object($arr) {
  if (empty($arr) || !array_key_exists('min_width', $arr)) {
    return array();
  }


  $length = count($arr['min_width']);
  $output = array();


  for ($i = 0; $i < $length; $i++) {
    $bg_image = wp_get_attachment_image_src($arr['background_image'][$i][0], 'full');
    $output[] = array(
      'minWidth'           => $arr['min_width'][$i],
      'backgroundColor'    => $arr['background_color'][$i],
      'backgroundImage'    => $bg_image ? $bg_image[0] : '',
      'backgroundSize'     => $arr['background_size'][$i],
      'backgroundPosition' => $arr['background_position'][$i],
      'backgroundRepeat'   => $arr['background_repeat'][$i][0],
    );
  }

  if (count($output) > 1) {
    usort($output, function($a, $b) {
      $min_a = (int) $a['minWidth'];
      $min_b = (int) $b['minWidth'];

      if ($min_a === $min_b) {
        return 0;
      }

      return ($min_a < $min_b) ? -1 : 1;
    });
  }

  return $output;
}
?>
