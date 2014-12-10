<?php
if (is_single() || is_page()) {
  global $post;
  $description = strip_tags(get_the_excerpt());
}
?>
<script>
  var description   = '<?php echo $description; ?>';
  var addthis_share = {};

  if (description) {
    addthis_share.description = description;
  }
</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5488abf7308ad1fd" async="async"></script>
