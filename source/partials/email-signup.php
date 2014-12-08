<?php
/**
 * Email Signup Partial
 */

global $fwe_settings;
?>

<section id="email-signup" class="content-section bg blue">
  <div class="section-inner">
    <h2>Email Signup</h2>

    <div class="signup-intro">
      <?php if (!empty($fwe_settings['email_signup_copy'])): ?>
        <?php echo apply_filters('the_content', $fwe_settings['email_signup_copy']); ?>
      <?php endif; ?>
    </div>

    <form action="" method="post">
      <p>
        <input type="text" name="name" placeholder="Your Name" required>
        <span class="required">*</span>
      </p>
      <p>
        <input type="email" name="email" placeholder="Email Address" required>
        <span class="required">*</span>
      </p>
      <button type="submit" class="fwe-button">
        <span class="button-label">Submit &raquo;</span>
      </button>
    </form>
  </div>
</section>
