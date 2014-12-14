<?php
$classes = isset($banner_classes) ? ' ' . $banner_classes : '';
?>
<section class="banner<?php echo $classes; ?>">
  <figure id="page-banner">
    <img src="<?php echo $banner[0]; ?>" alt="<?php echo $caption; ?>" width="100%">
    <figcaption><?php echo $caption; ?></figcaption>
  </figure>
</section>
