<footer class="site-footer" role="contentinfo">
  <div class="container site-footer__grid">

    <!-- Branding -->
    <div class="site-footer__branding">
      <?php if ( function_exists('the_custom_logo') && has_custom_logo() ) : ?>
        <div class="site-footer__brand">
          <?php the_custom_logo(); ?>
        </div>
      <?php else : ?>
        <a class="site-footer__title" href="<?php echo esc_url( home_url('/') ); ?>">
          <?php bloginfo('name'); ?>
        </a>
      <?php endif; ?>

      <?php $description = get_bloginfo('description', 'display'); ?>
      <?php if ( $description ) : ?>
        <p class="site-footer__tagline"><?php echo esc_html( $description ); ?></p>
      <?php endif; ?>
    </div>

    <!-- Footer menu -->
    <nav class="site-footer__menu" aria-label="<?php esc_attr_e('Footer menu', 'webkoers'); ?>">
      <strong class="site-footer__heading"><?php esc_html_e('Menu', 'webkoers'); ?></strong>

      <?php
        wp_nav_menu([
          'theme_location' => 'footer_main',
          'container'      => false,
          'menu_class'     => 'footer-menu footer-menu--main',
          'fallback_cb'    => false,
        ]);
      ?>
    </nav>

    <!-- Contact -->
    <div class="site-footer__contact">
      <strong class="site-footer__heading"><?php esc_html_e('Contact', 'webkoers'); ?></strong>
      <ul class="site-footer__list">
        <li><a href="mailto:info@webkoers.nl">info@webkoers.nl</a></li>
        <li><a href="tel:+31610052255">+31 6 1005 2255</a></li>
      </ul>
    </div>

    <!-- Info menu -->
    <nav class="site-footer__menu" aria-label="<?php esc_attr_e('Footer informatie', 'webkoers'); ?>">
      <strong class="site-footer__heading"><?php esc_html_e('Informatie', 'webkoers'); ?></strong>

      <?php
        wp_nav_menu([
          'theme_location' => 'footer_info',
          'container'      => false,
          'menu_class'     => 'footer-menu footer-menu--info',
          'fallback_cb'    => false,
        ]);
      ?>
    </nav>

  </div>

  <div class="site-footer__bottom">
    <div class="container">
      <span>© <?php echo esc_html( date('Y') ); ?> <?php bloginfo('name'); ?></span>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
