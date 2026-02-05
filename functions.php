<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function theme_enqueue_assets() {

    wp_enqueue_style(
        'theme-style',
        get_template_directory_uri() . '/assets/css/style.css',
        [],
        filemtime( get_template_directory() . '/assets/css/style.css' )
    );

    wp_enqueue_style(
        'swiper',
        get_template_directory_uri() . '/assets/css/lib/swiper-bundle.min.css',
        [],
        '11'
    );

    wp_enqueue_script('jquery');

    wp_enqueue_script(
        'swiper',
        get_template_directory_uri() . '/assets/js/lib/swiper-bundle.min.js',
        [],
        '11',
        true
    );

    wp_enqueue_script(
        'theme-script',
        get_template_directory_uri() . '/assets/js/common.js',
        ['jquery'],
        filemtime( get_template_directory() . '/assets/js/common.js' ),
        true
    );

    if ( is_front_page() ) {
        wp_enqueue_script(
            'top-script',
            get_template_directory_uri() . '/assets/js/top.js',
            ['theme-script', 'swiper'],
            filemtime( get_template_directory() . '/assets/js/top.js' ),
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');
