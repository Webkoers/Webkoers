<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" role="banner">
  <div class="site-header__inner container">

    <!-- Logo -->
    <div class="site-header__brand">
      <?php if ( function_exists('the_custom_logo') && has_custom_logo() ) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <a class="site-header__title" href="<?php echo esc_url( home_url('/') ); ?>">
          <?php bloginfo('name'); ?>
        </a>
      <?php endif; ?>
    </div>

    <!-- Desktop nav -->
    <nav class="site-header__nav site-header__nav--desktop"
         aria-label="<?php echo esc_attr__('Hoofdnavigatie', 'webkoers'); ?>">
      <?php
        wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'menu menu--primary',
          'fallback_cb'    => false,
        ]);
      ?>
    </nav>

    <!-- Desktop CTA -->
    <a href="<?php echo esc_url( home_url('/kennismaken/') ); ?>"
       class="btn btn--primary site-header__cta site-header__cta--desktop">
      Kennismaken
    </a>

    <!-- Mobile menu -->
    <details class="site-header__menu">
      <summary class="site-header__burger"
               aria-label="<?php echo esc_attr__('Menu openen', 'webkoers'); ?>"
               aria-controls="site-header-drawer">
        <span class="site-header__burger-icon" aria-hidden="true"></span>
      </summary>

      <div id="site-header-drawer"
           class="site-header__drawer"
           role="dialog"
           aria-label="<?php echo esc_attr__('Mobiel menu', 'webkoers'); ?>">
        <nav class="site-header__nav site-header__nav--mobile"
             aria-label="<?php echo esc_attr__('Mobiele navigatie', 'webkoers'); ?>">
          <?php
            wp_nav_menu([
              'theme_location' => 'primary',
              'container'      => false,
              'menu_class'     => 'menu menu--mobile',
              'fallback_cb'    => false,
            ]);
          ?>
        </nav>

        <a href="<?php echo esc_url( home_url('/kennismaken/') ); ?>"
           class="btn btn--primary site-header__cta site-header__cta--mobile">
          Kennismaken
        </a>
      </div>
    </details>

  </div>
</header>
