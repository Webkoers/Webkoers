<?php
// inc/menu.php (of menu.php in theme root)

if ( ! defined('ABSPATH') ) {
  exit;
}

add_action('after_setup_theme', function () {
  register_nav_menus([
    'primary' => __('Hoofdmenu', 'webkoers'),
    'footer'  => __('Footer menu', 'webkoers'),
  ]);
});
