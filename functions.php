<?php

/**
 * Enqueue styles/scripts
 */
function webkoers_enqueue_assets() {
  $css_rel  = '/assets/css/main.css';
  $css_file = get_template_directory() . $css_rel;
  $css_uri  = get_template_directory_uri() . $css_rel;

  $ver = file_exists($css_file) ? filemtime($css_file) : wp_get_theme()->get('Version');

  wp_enqueue_style(
    'webkoers-main',
    $css_uri,
    [],
    $ver
  );
}
add_action('wp_enqueue_scripts', 'webkoers_enqueue_assets');


/**
 * Theme setup
 */
function webkoers_theme_setup() {

  // Menulocaties
  register_nav_menus([
    'primary'      => __('Hoofdmenu', 'webkoers'),
    'footer_main'  => __('Footer menu', 'webkoers'),
    'footer_info'  => __('Footer informatie', 'webkoers'),
  ]);

  add_theme_support('custom-logo', [
    'height'      => 120,
    'width'       => 300,
    'flex-height' => true,
    'flex-width'  => true,
  ]);

  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', [
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    'style',
    'script'
  ]);
}
add_action('after_setup_theme', 'webkoers_theme_setup');

  $js_rel  = '/assets/js/portfolio-filter.js';
  $js_file = get_template_directory() . $js_rel;
  $js_uri  = get_template_directory_uri() . $js_rel;

  $js_ver = file_exists($js_file) ? filemtime($js_file) : wp_get_theme()->get('Version');

  wp_enqueue_script(
    'webkoers-portfolio-filter',
    $js_uri,
    [],
    $js_ver,
    true
  );

    $marquee_rel  = '/assets/js/marquee.js';
  $marquee_file = get_template_directory() . $marquee_rel;
  $marquee_uri  = get_template_directory_uri() . $marquee_rel;

  $marquee_ver = file_exists($marquee_file) ? filemtime($marquee_file) : wp_get_theme()->get('Version');

  wp_enqueue_script(
    'webkoers-marquee',
    $marquee_uri,
    [],
    $marquee_ver,
    true
  );

// Preloader script laden
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_script(
    'webkoers-preloader',
    get_template_directory_uri() . '/assets/js/preloader.js',
    [],
    null,
    true
  );
});

function add_preloader_html() {
  get_template_part('template-parts/blocks/preloader');
}

add_action('wp_body_open', 'add_preloader_html');
