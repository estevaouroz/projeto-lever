<?php

function _add_javascript()
{
  // force all scripts to load in footer
  remove_action('wp_head', 'wp_print_scripts');
  remove_action('wp_head', 'wp_print_head_scripts', 9);
  // remove_action('wp_head', 'wp_enqueue_scripts', 1);


  wp_enqueue_script('jquery');
  wp_enqueue_script('gsap', get_template_directory_uri() . '/assets/dist/vendor/gsap/gsap.min.js', ['jquery'], ASSETS_VERSION, true);

  wp_enqueue_script('scrolltrigger', get_template_directory_uri() . '/assets/dist/vendor/scrolltrigger/scrolltrigger.min.js', ['jquery'], ASSETS_VERSION, true);
  wp_enqueue_script('lenis', get_template_directory_uri() . '/assets/src/vendor/lenis-main/dist/lenis.min.js', ['jquery'], ASSETS_VERSION, true);

  wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/dist/vendor/swiper/swiper.min.js', ['jquery'], ASSETS_VERSION, true);
  wp_enqueue_script('main', get_template_directory_uri() . '/assets/dist/js/main.min.js', ['jquery'], ASSETS_VERSION, true);
}
add_action('wp_enqueue_scripts', '_add_javascript', 100);

function _add_stylesheets()
{
  // removing all WP css files enqueued by default
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
  wp_dequeue_style('wc-block-style');
  wp_dequeue_style('global-styles');
  wp_dequeue_style('classic-theme-styles');
  wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/dist/vendor/swiper/swiper.min.css');

  wp_enqueue_style('main', get_template_directory_uri() . '/assets/dist/css/main.css');
  wp_enqueue_style('home-page', get_template_directory_uri() . '/assets/dist/css/pages/home/home.css', array(), ASSETS_VERSION);
}
add_action('wp_enqueue_scripts', '_add_stylesheets');