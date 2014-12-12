<div class="accordion">
  <?php for ($i = 0; $i < $pane_count; $i++): ?>
    <?php
    if (empty($panes['content'][$i]) || empty($panes['title'][$i])) continue;

    $header_id    = 'accordion-' . $id . '-header-' . $i;
    $pane_id      = 'accordion-' . $id . '-pane-' . $i;
    $pane_icon    = wp_get_attachment_image_src($panes['icon'][$i][0], 'full');
    $header_style = fwe_style_attribute(array(
      'background-color' => $panes['header_background'][$i],
    ));
    ?>
    <div class="pane">
      <div class="pane-header" id="<?php echo $header_id; ?>"<?php echo $header_style; ?>>
        <?php echo '<' . $header . '>'; ?>
          <a href="#<?php echo $pane_id; ?>">
            <div class="icon">
              <img src="<?php echo $pane_icon[0]; ?>">
            </div>
            <div class="title"><?php echo apply_filters('the_title', $panes['title'][$i]); ?></div>
            <div class="plusminus">+</div>
          </a>
        <?php echo '</' . $header . '>'; ?>
      </div>

      <div class="pane-content" id="<?php echo $pane_id; ?>">
        <div class="pane-body">
          <?php echo apply_filters('the_content', $panes['content'][$i]); ?>
        </div>
      </div>
    </div>
  <?php endfor; ?>
</div>
