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
add_theme_support('title-tag');

// カスタムタイトルタグ
function custom_document_title( $title ) {
	$site_name = 'LURF GALLERY';
	$sep = '｜';

	// トップページ
	if ( is_front_page() ) {
		return $site_name . $sep . 'Contemporary Art Gallery';
	}

	// 404
	if ( is_404() ) {
		return 'Page not found' . $sep . $site_name;
	}

	// 検索結果
	if ( is_search() ) {
		return 'Search Results: ' . get_search_query() . $sep . $site_name;
	}

	// 投稿タイプアーカイブ
	if ( is_post_type_archive( 'exhibitions' ) ) {
		return 'EXHIBITIONS' . $sep . $site_name;
	}
	if ( is_post_type_archive( 'artfairs' ) ) {
		return 'ART FAIR' . $sep . $site_name;
	}
	if ( is_post_type_archive( 'artists' ) ) {
		return 'ARTISTS' . $sep . $site_name;
	}

	// News一覧 (home.php)
	if ( is_home() ) {
		return 'NEWS' . $sep . $site_name;
	}

	// 投稿詳細
	if ( is_singular() ) {
		$post_type = get_post_type();

		switch ( $post_type ) {
			case 'exhibitions':
				return get_the_title() . $sep . 'EXHIBITIONS' . $sep . $site_name;

			case 'artfairs':
				return get_the_title() . $sep . 'ART FAIR' . $sep . $site_name;

			case 'artists':
				$overview = get_field( 'overview' );
				$name1 = $overview['name1'] ?? '';
				$name2 = $overview['name2'] ?? '';
				$artist_title = trim( $name1 . ' ' . $name2 );
				if ( ! $artist_title ) {
					$artist_title = get_the_title();
				}
				return $artist_title . $sep . 'ARTISTS' . $sep . $site_name;

			case 'artworks':
				$artist_name = get_field( 'artist_name' );
				$work_title = get_field( 'title' );
				$parts = [];
				if ( ! empty( $artist_name['value'] ) ) $parts[] = $artist_name['value'];
				if ( ! empty( $work_title['value'] ) ) $parts[] = $work_title['value'];
				$item_title = implode( ' - ', $parts );
				if ( ! $item_title ) $item_title = get_the_title();
				return $item_title . $sep . 'EXHIBITIONS' . $sep . $site_name;

			case 'editions':
				$artist_name = get_field( 'artist_name' );
				$work_title = get_field( 'title' );
				$parts = [];
				if ( ! empty( $artist_name['value'] ) ) $parts[] = $artist_name['value'];
				if ( ! empty( $work_title['value'] ) ) $parts[] = $work_title['value'];
				$item_title = implode( ' - ', $parts );
				if ( ! $item_title ) $item_title = get_the_title();
				return $item_title . $sep . 'EDITIONS' . $sep . $site_name;

			case 'books':
				$artist_name = get_field( 'artist_name' );
				$work_title = get_field( 'title' );
				$parts = [];
				if ( ! empty( $artist_name['value'] ) ) $parts[] = $artist_name['value'];
				if ( ! empty( $work_title['value'] ) ) $parts[] = $work_title['value'];
				$item_title = implode( ' - ', $parts );
				if ( ! $item_title ) $item_title = get_the_title();
				return $item_title . $sep . 'EXHIBITIONS' . $sep . $site_name;

			case 'post':
				return get_the_title() . $sep . 'NEWS' . $sep . $site_name;

			case 'page':
				return get_the_title() . $sep . $site_name;
		}
	}

	// フォールバック
	return get_the_title() . $sep . $site_name;
}
add_filter( 'pre_get_document_title', 'custom_document_title' );

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

// フロントエンドではカスタムパーマリンクを返す
// 管理画面・REST APIではフィルターを適用せず、ブロックエディタのURLパネルを表示させる
function change_post_permalink( $permalink, $post ) {
    if ( is_admin() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
        return $permalink;
    }
    if ( $post->post_type === 'post' ) {
        return home_url( '/news/' . $post->post_name . '/' );
    }
    return $permalink;
}
add_filter( 'post_link', 'change_post_permalink', 10, 2 );

// ─────────────────────────────────────────────────────────────
// 投稿(news)スラッグ自動生成: 0001 または 0001-xxx 形式
// ─────────────────────────────────────────────────────────────
// 連番はpost metaに保存し、削除しても欠番にする（詰めない）
// カウンターは wp_options の 'news_seq_counter' で管理
// 新規作成時: ユーザー入力があれば 0001-xxx、なければ 0001
// 編集時: 連番部分(0001-)は維持し、後半のみ変更可能
// ─────────────────────────────────────────────────────────────

/**
 * 投稿に連番を割り当てる（未割り当ての場合のみ）
 */
function assign_news_seq_number( $post_id ) {
    $seq = get_post_meta( $post_id, '_news_seq_number', true );
    if ( $seq ) {
        return (int) $seq;
    }
    $counter = (int) get_option( 'news_seq_counter', 0 );
    $counter++;
    update_option( 'news_seq_counter', $counter );
    update_post_meta( $post_id, '_news_seq_number', $counter );
    return $counter;
}

/**
 * 連番プレフィックスを取得: 0001
 */
function get_news_seq_prefix( $post_id ) {
    $seq = assign_news_seq_number( $post_id );
    return str_pad( $seq, 4, '0', STR_PAD_LEFT );
}

/**
 * スラッグから連番プレフィックスを除去して後半部分を取得
 */
function strip_news_seq_prefix( $slug ) {
    // 0001 または 0001-xxx 形式から後半を取得
    if ( preg_match( '/^\d{4}(?:-(.+))?$/', $slug, $matches ) ) {
        return $matches[1] ?? '';
    }
    return $slug;
}

/**
 * 連番プレフィックス付きスラッグを生成
 */
function build_news_slug( $prefix, $suffix ) {
    $suffix = sanitize_title( $suffix );
    if ( $suffix === '' ) {
        return $prefix;
    }
    return $prefix . '-' . $suffix;
}

/**
 * 投稿保存時にスラッグに連番プレフィックスを付与
 */
function auto_set_news_slug( $data, $postarr ) {
    if ( $data['post_type'] !== 'post' ) {
        return $data;
    }
    if ( $data['post_status'] === 'auto-draft' || defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $data;
    }
    $post_id = $postarr['ID'] ?? 0;
    if ( ! $post_id ) {
        return $data;
    }

    $prefix       = get_news_seq_prefix( $post_id );
    $current_slug = $data['post_name'];

    // ユーザー入力のスラッグから連番プレフィックスを除去して後半を取得
    $suffix = strip_news_seq_prefix( $current_slug );

    $data['post_name'] = build_news_slug( $prefix, $suffix );
    return $data;
}
add_filter( 'wp_insert_post_data', 'auto_set_news_slug', 10, 2 );

/**
 * WordPressの重複スラッグチェックによる -2 等の付与を防止
 * news用の連番スラッグ（0001, 0001-xxx）はそのまま通す
 */
function preserve_news_slug( $slug, $post_ID, $post_status, $post_type ) {
    if ( $post_type !== 'post' ) {
        return $slug;
    }
    $seq = get_post_meta( $post_ID, '_news_seq_number', true );
    if ( ! $seq ) {
        return $slug;
    }
    $prefix = str_pad( (int) $seq, 4, '0', STR_PAD_LEFT );
    // 連番プレフィックスで始まるスラッグなら、WordPress の変更を元に戻す
    // 例: 0001-2 → 0001, 0001-my-slug-2 → 0001-my-slug
    if ( preg_match( '/^' . preg_quote( $prefix, '/' ) . '(-.*)?(-\d+)$/', $slug, $m ) ) {
        return $prefix . ( $m[1] ?? '' );
    }
    return $slug;
}
add_filter( 'wp_unique_post_slug', 'preserve_news_slug', 10, 4 );

/**
 * 新規投稿作成後にスラッグを設定（初回保存時はIDがないため）
 */
function auto_set_news_slug_on_create( $post_id, $post, $update ) {
    if ( $post->post_type !== 'post' || $update ) {
        return;
    }
    if ( $post->post_status === 'auto-draft' ) {
        return;
    }
    $prefix = get_news_seq_prefix( $post_id );
    $suffix = strip_news_seq_prefix( $post->post_name );
    $slug   = build_news_slug( $prefix, $suffix );
    if ( $post->post_name !== $slug ) {
        remove_action( 'wp_after_insert_post', 'auto_set_news_slug_on_create', 10 );
        wp_update_post( [
            'ID'        => $post_id,
            'post_name' => $slug,
        ] );
        add_action( 'wp_after_insert_post', 'auto_set_news_slug_on_create', 10, 3 );
    }
}
add_action( 'wp_after_insert_post', 'auto_set_news_slug_on_create', 10, 3 );

// 投稿(news)一覧にスラッグ列を追加
function news_add_slug_column( $columns ) {
    $new_columns = [];
    foreach ( $columns as $key => $label ) {
        $new_columns[ $key ] = $label;
        if ( $key === 'title' ) {
            $new_columns['news_slug'] = 'スラッグ';
        }
    }
    return $new_columns;
}
add_filter( 'manage_posts_columns', 'news_add_slug_column' );

function news_show_slug_column( $column, $post_id ) {
    if ( $column === 'news_slug' ) {
        $post = get_post( $post_id );
        echo '<code>' . esc_html( $post->post_name ) . '</code>';
    }
}
add_action( 'manage_posts_custom_column', 'news_show_slug_column', 10, 2 );

// ─────────────────────────────────────────────────────────────
// 投稿(news)スラッグ一括更新ツール
// ─────────────────────────────────────────────────────────────
// 管理画面「news > スラッグ一括更新」から実行可能
// 公開日昇順で連番を0001から振り直し、カウンターもリセットする
// ─────────────────────────────────────────────────────────────

// function news_slug_reindex_menu() {
//     add_submenu_page(
//         'edit.php',            // 投稿(news)メニュー配下
//         'スラッグ一括更新',
//         'スラッグ一括更新',
//         'manage_options',      // 管理者のみ
//         'news-slug-reindex',
//         'news_slug_reindex_page'
//     );
// }
// add_action( 'admin_menu', 'news_slug_reindex_menu' );

/*
function news_slug_reindex_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( '権限がありません。' );
    }

    $result_message = '';

    // 実行処理
    if ( isset( $_POST['do_reindex'] ) && check_admin_referer( 'news_slug_reindex_action' ) ) {
        $result_message = news_slug_reindex_execute();
    }

    // プレビュー取得
    $preview = news_slug_reindex_preview();

    ?>
    <div class="wrap">
        <h1>News スラッグ一括更新</h1>
        <p>すべての投稿(news)のスラッグを公開日昇順で <code>yyyy-mm-dd-0001</code> 形式に振り直します。</p>
        <p><strong>注意:</strong> 既存のURLが変わるため、外部からのリンクが切れる可能性があります。</p>

        <?php if ( $result_message ) : ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html( $result_message ); ?></p>
            </div>
        <?php endif; ?>

        <h2>プレビュー</h2>
        <?php if ( empty( $preview ) ) : ?>
            <p>対象の投稿がありません。</p>
        <?php else : ?>
            <table class="widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width:40px;">No.</th>
                        <th>タイトル</th>
                        <th>公開日</th>
                        <th>現在のスラッグ</th>
                        <th>更新後のスラッグ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $preview as $i => $item ) : ?>
                        <tr>
                            <td><?php echo esc_html( $i + 1 ); ?></td>
                            <td><?php echo esc_html( $item['title'] ); ?></td>
                            <td><?php echo esc_html( $item['date'] ); ?></td>
                            <td><code><?php echo esc_html( $item['current_slug'] ); ?></code></td>
                            <td><code><?php echo esc_html( $item['new_slug'] ); ?></code></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <form method="post" style="margin-top: 20px;">
                <?php wp_nonce_field( 'news_slug_reindex_action' ); ?>
                <input type="hidden" name="do_reindex" value="1">
                <?php submit_button( 'スラッグを一括更新する', 'primary', 'submit', false ); ?>
            </form>
        <?php endif; ?>
    </div>
    <?php
}
// */

/**
 * プレビュー: 更新前後のスラッグ一覧を返す
 */
/*
function news_slug_reindex_preview() {
    $posts = get_posts( [
        'post_type'      => 'post',
        'post_status'    => [ 'publish', 'draft', 'pending', 'future', 'private' ],
        'orderby'        => 'date',
        'order'          => 'ASC',
        'posts_per_page' => -1,
    ] );

    $preview = [];
    foreach ( $posts as $seq => $post ) {
        $seq_num  = $seq + 1;
        $new_slug = str_pad( $seq_num, 4, '0', STR_PAD_LEFT );

        $preview[] = [
            'title'        => $post->post_title,
            'date'         => substr( $post->post_date, 0, 10 ),
            'current_slug' => $post->post_name,
            'new_slug'     => $new_slug,
        ];
    }
    return $preview;
}
//*/

/**
 * 実行: 連番リセット＆スラッグ一括更新
 */
/*
function news_slug_reindex_execute() {
    $posts = get_posts( [
        'post_type'      => 'post',
        'post_status'    => [ 'publish', 'draft', 'pending', 'future', 'private' ],
        'orderby'        => 'date',
        'order'          => 'ASC',
        'posts_per_page' => -1,
    ] );

    // auto_set_news_slug が二重処理しないよう一時的に解除
    remove_filter( 'wp_insert_post_data', 'auto_set_news_slug', 10 );
    remove_action( 'wp_after_insert_post', 'auto_set_news_slug_on_create', 10 );

    $count = 0;
    foreach ( $posts as $seq => $post ) {
        $seq_num  = $seq + 1;
        $new_slug = str_pad( $seq_num, 4, '0', STR_PAD_LEFT );

        update_post_meta( $post->ID, '_news_seq_number', $seq_num );
        wp_update_post( [
            'ID'        => $post->ID,
            'post_name' => $new_slug,
        ] );
        $count++;
    }

    // カウンターを更新（最後の連番 = 投稿数）
    update_option( 'news_seq_counter', $count );

    // フック再登録
    add_filter( 'wp_insert_post_data', 'auto_set_news_slug', 10, 2 );
    add_action( 'wp_after_insert_post', 'auto_set_news_slug_on_create', 10, 3 );

    return $count . '件の投稿のスラッグを更新しました。';
}
//*/

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

