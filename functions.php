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

// 投稿機能の追加
function create_post_type() {
	// exhibitions
  register_post_type( 'exhibitions',
    array(
      'labels' => array(
        'name' => __( 'exhibitions' ),
        'singular_name' => __( 'exhibitions' )
      ),
      'public' => true,
			'show_in_rest' => true,
      'has_archive' => true,
      'menu_position' => 6,
			'supports' => array('title', 'custom-fields'),
    )
	);
	// artworks
	register_post_type( 'artworks',
		array(
			'labels' => array(
				'name' => __( 'artworks' ),
				'singular_name' => __( 'artworks' )
			),
			'public' => true,
			'show_in_rest' => true,
			// 'has_archive' => true,
			'menu_position' => 6,
			'supports' => array('title', 'custom-fields'),
		)
	);
	// editions
	register_post_type( 'editions',
		array(
			'labels' => array(
				'name' => __( 'editions' ),
				'singular_name' => __( 'editions' )
			),
			'public' => true,
			'show_in_rest' => true,
			// 'has_archive' => true,
			'menu_position' => 6,
			'supports' => array('title', 'custom-fields'),
		)
	);
	// books
	register_post_type( 'books',
		array(
			'labels' => array(
				'name' => __( 'books' ),
				'singular_name' => __( 'books' )
			),
			'public' => true,
			'show_in_rest' => true,
			// 'has_archive' => true,
			'menu_position' => 6,
			'supports' => array('title', 'custom-fields'),
		)
	);
	// artfairs
	register_post_type( 'artfairs',
		array(
			'labels' => array(
				'name' => __( 'artfairs' ),
				'singular_name' => __( 'artfairs' )
			),
			'public' => true,
			'show_in_rest' => true,
			'has_archive' => true,
			'menu_position' => 6,
			'supports' => array('title', 'custom-fields'),
		)
	);
	// artists
	register_post_type( 'artists',
		array(
			'labels' => array(
				'name' => __( 'artists' ),
				'singular_name' => __( 'artists' )
			),
			'public' => true,
			'show_in_rest' => true,
			'has_archive' => true,
			'menu_position' => 6,
			'supports' => array('title', 'custom-fields'),
		)
	);
}
add_action( 'init', 'create_post_type' );

// メニュー位置変更
function custom_admin_menu_order() {
    global $menu;

    $moves = [
        'upload.php' => 15,
        'edit.php?post_type=artfairs' => 11,
    ];
    $collected = [];

    foreach ( $menu as $key => $item ) {
        if ( isset( $moves[ $item[2] ] ) ) {
            $collected[ $item[2] ] = $menu[ $key ];
            unset( $menu[ $key ] );
        }
    }

    foreach ( $collected as $slug => $item ) {
        $pos = $moves[ $slug ];
        while ( isset( $menu[ $pos ] ) ) {
            $pos++;
        }
        $menu[ $pos ] = $item;
    }

    ksort( $menu );
}
add_action( 'admin_menu', 'custom_admin_menu_order', 999 );

