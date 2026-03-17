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

	if ( is_post_type_archive( 'exhibitions' ) ) {
		wp_enqueue_script(
			'exhibitions-index-script',
			get_template_directory_uri() . '/assets/js/exhibitions-index.js',
			['theme-script'],
			filemtime( get_template_directory() . '/assets/js/exhibitions-index.js' ),
			true
		);
	}

	if ( is_post_type_archive( 'artfairs' ) ) {
		wp_enqueue_script(
			'exhibitions-index-script',
			get_template_directory_uri() . '/assets/js/exhibitions-index.js',
			['theme-script'],
			filemtime( get_template_directory() . '/assets/js/exhibitions-index.js' ),
			true
		);
	}
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');

add_theme_support('post-thumbnails');

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
		'taxonomies' => array('exhibition_status', 'exhibition_year'),
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
			'taxonomies' => array('exhibition_status', 'exhibition_year'),
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
			'taxonomies' => array('artist_category'),
		)
	);

	// artists カテゴリ
	register_taxonomy( 'artist_category', 'artists',
		array(
			'labels' => array(
				'name' => __( 'カテゴリ' ),
				'singular_name' => __( 'カテゴリ' ),
				'search_items' => __( 'カテゴリを検索' ),
				'all_items' => __( 'すべてのカテゴリ' ),
				'parent_item' => __( '親カテゴリ' ),
				'parent_item_colon' => __( '親カテゴリ:' ),
				'edit_item' => __( 'カテゴリを編集' ),
				'update_item' => __( 'カテゴリを更新' ),
				'add_new_item' => __( '新しいカテゴリを追加' ),
				'new_item_name' => __( '新しいカテゴリ名' ),
				'menu_name' => __( 'カテゴリ' ),
			),
			'hierarchical' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
		)
	);

	// exhibitions / artfairs 共有タクソノミー: ステータス
	register_taxonomy( 'exhibition_status', array('exhibitions', 'artfairs'),
		array(
			'labels' => array(
				'name' => __( 'ステータス' ),
				'singular_name' => __( 'ステータス' ),
				'search_items' => __( 'ステータスを検索' ),
				'all_items' => __( 'すべてのステータス' ),
				'edit_item' => __( 'ステータスを編集' ),
				'update_item' => __( 'ステータスを更新' ),
				'add_new_item' => __( '新しいステータスを追加' ),
				'new_item_name' => __( '新しいステータス名' ),
				'menu_name' => __( 'ステータス' ),
			),
			'hierarchical' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
		)
	);

	// exhibitions / artfairs 共有タクソノミー: 年度
	register_taxonomy( 'exhibition_year', array('exhibitions', 'artfairs'),
		array(
			'labels' => array(
				'name' => __( '年度' ),
				'singular_name' => __( '年度' ),
				'search_items' => __( '年度を検索' ),
				'all_items' => __( 'すべての年度' ),
				'edit_item' => __( '年度を編集' ),
				'update_item' => __( '年度を更新' ),
				'add_new_item' => __( '新しい年度を追加' ),
				'new_item_name' => __( '新しい年度名' ),
				'menu_name' => __( '年度' ),
			),
			'hierarchical' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
		)
	);
}
add_action( 'init', 'create_post_type' );

// 投稿(post)のURLを /news/{slug} に変更
function register_news_rewrite_rules() {
    add_rewrite_rule( 'news/?$', 'index.php?post_type=post', 'top' );
    add_rewrite_rule( 'news/page/([0-9]+)/?$', 'index.php?post_type=post&paged=$matches[1]', 'top' );
    add_rewrite_rule( 'news/([^/]+)/?$', 'index.php?name=$matches[1]', 'top' );
}
add_action( 'init', 'register_news_rewrite_rules' );

function change_post_permalink( $permalink, $post ) {
    if ( $post->post_type === 'post' ) {
        return home_url( '/news/' . $post->post_name . '/' );
    }
    return $permalink;
}
add_filter( 'post_link', 'change_post_permalink', 10, 2 );

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

// 「投稿」メニューを「news」に変更
function rename_post_menu_label() {
    global $menu, $submenu;

    foreach ( $menu as $key => $item ) {
        if ( $item[2] === 'edit.php' ) {
            $menu[ $key ][0] = 'news';
            break;
        }
    }

    if ( isset( $submenu['edit.php'] ) ) {
        $submenu['edit.php'][5][0] = 'news';
    }
}
add_action( 'admin_menu', 'rename_post_menu_label' );

// 検索対象の投稿タイプを拡張
function custom_search_post_types( $query ) {
	if ( $query->is_search() && $query->is_main_query() && ! is_admin() ) {
		$query->set( 'post_type', [ 'post', 'page', 'exhibitions', 'artfairs', 'artists' ] );
		$query->set( 'posts_per_page', -1 );
	}
}
add_action( 'pre_get_posts', 'custom_search_post_types' );

// カスタムフィールド(description)も検索対象に含める
function custom_search_join( $join, $query ) {
	global $wpdb;
	if ( $query->is_search() && $query->is_main_query() && ! is_admin() ) {
		$join .= " LEFT JOIN {$wpdb->postmeta} AS search_meta ON ({$wpdb->posts}.ID = search_meta.post_id AND search_meta.meta_key = 'description')";
	}
	return $join;
}
add_filter( 'posts_join', 'custom_search_join', 10, 2 );

function custom_search_where( $where, $query ) {
	global $wpdb;
	if ( $query->is_search() && $query->is_main_query() && ! is_admin() ) {
		$search_term = $query->get( 's' );
		$like = '%' . $wpdb->esc_like( $search_term ) . '%';
		$where = preg_replace(
			"/\({$wpdb->posts}\.post_title LIKE (.*?)\)/",
			"({$wpdb->posts}.post_title LIKE $1) OR (search_meta.meta_value LIKE '" . esc_sql( $like ) . "')",
			$where
		);
	}
	return $where;
}
add_filter( 'posts_where', 'custom_search_where', 10, 2 );

function custom_search_distinct( $distinct, $query ) {
	if ( $query->is_search() && $query->is_main_query() && ! is_admin() ) {
		return 'DISTINCT';
	}
	return $distinct;
}
add_filter( 'posts_distinct', 'custom_search_distinct', 10, 2 );

