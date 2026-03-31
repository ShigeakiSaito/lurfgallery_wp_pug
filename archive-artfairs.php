<?php get_header(); ?>

	<main class="exhibitions-index">
		<h1>EXHIBITIONS</h1>

		<!-- タブナビゲーション -->
		<?php
		$current_status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'all';
		$current_year = isset($_GET['ex_year']) ? sanitize_text_field($_GET['ex_year']) : 'all';

		$status_terms = get_terms(array(
			'taxonomy' => 'exhibition_status',
			'hide_empty' => false,
		));
		$year_terms = get_terms(array(
			'taxonomy' => 'exhibition_year',
			'hide_empty' => false,
			'orderby' => 'name',
			'order' => 'DESC',
		));
		?>
		<nav class="exhibitions-index__nav">
			<div class="exhibitions-index__nav-inner">
				<ul class="exhibitions-index__tabs">
					<li class="exhibitions-index__tab<?php echo $current_status === 'all' ? ' is-active' : ''; ?>" data-status="all">ALL</li>
					<?php foreach ($status_terms as $term) : ?>
					<li class="exhibitions-index__tab<?php echo $current_status === $term->slug ? ' is-active' : ''; ?>" data-status="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></li>
					<?php endforeach; ?>
				</ul>
				<div class="exhibitions-index__year-select" id="js-year-select">
					<span class="exhibitions-index__year-label"><?php echo $current_year === 'all' ? 'SELECT YEAR' : esc_html($current_year); ?></span>
					<svg class="exhibitions-index__year-arrow" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1 1L5 5L9 1" stroke="#1A1A1A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
					</svg>
					<ul class="exhibitions-index__year-dropdown" id="js-year-dropdown">
						<li class="exhibitions-index__year-option<?php echo $current_year === 'all' ? ' is-active' : ''; ?>" data-year="all">ALL</li>
						<?php foreach ($year_terms as $term) : ?>
						<li class="exhibitions-index__year-option<?php echo $current_year === $term->slug ? ' is-active' : ''; ?>" data-year="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</nav>

		<?php
		// ===== WP_Query =====
		$query_args = array(
			'post_type' => 'artfairs',
			'posts_per_page' => -1,
			'post_status' => 'publish',
		);

		$tax_query = array();
		if ($current_status !== 'all') {
			$tax_query[] = array(
				'taxonomy' => 'exhibition_status',
				'field' => 'slug',
				'terms' => $current_status,
			);
		} else {
			// allの場合でも、ステータス未設定の投稿を除外
			$tax_query[] = array(
				'taxonomy' => 'exhibition_status',
				'operator' => 'EXISTS',
			);
		}
		if ($current_year !== 'all') {
			$tax_query[] = array(
				'taxonomy' => 'exhibition_year',
				'field' => 'slug',
				'terms' => $current_year,
			);
		}
		if (!empty($tax_query)) {
			$tax_query['relation'] = 'AND';
			$query_args['tax_query'] = $tax_query;
		}

		$exhibitions_query = new WP_Query($query_args);
		$exhibitions = $exhibitions_query->posts;

		// メインビジュアルがない、または「画像非表示」がtrueの場合はリスト表示
		$featured_posts = [];
		$list_posts = [];

		foreach ($exhibitions as $ex) {
			$ex_image = get_field('main_visual', $ex->ID)['image'] ?? null;
			$ex_no_image = get_field('no_display_image', $ex->ID) ?? false;
			if (!$ex_image || $ex_no_image) { // メインビジュアルがない、または「画像非表示」がtrueの場合はリスト表示
				$list_posts[] = $ex;
			} else {
				$featured_posts[] = $ex;
			}
		}
		?>

		<?php if (empty($featured_posts) && empty($list_posts)) : ?>
		<!-- 空状態メッセージ -->
		<div class="exhibitions-index__empty">
			<p class="exhibitions-index__empty-message">Sorry, there's nothing to see here yet.</p>
		</div>
		<?php else : ?>

		<!-- フィーチャード展示（current / forthcoming） -->
		<?php
		$featured_index = 0;
		foreach ($featured_posts as $ft_post) :
			$ft_id = $ft_post->ID;
			$ft_thumbnail = get_field('thumbnail', $ft_id);
			$ft_mv = get_field('main_visual', $ft_id);
			$ft_mv_image = (!empty($ft_mv['image'])) ? $ft_mv['image'] : null;
			if (!$ft_thumbnail) {
				$ft_thumbnail = $ft_mv_image; // サムネイルがない場合はメインビジュアルを使用
			}
			$ft_subtitle = get_field('subtitle', $ft_id);
			$ft_overview_table = get_field('overview_table', $ft_id);
			$ft_period = (!empty(get_field('period', $ft_id))) ? get_field('period', $ft_id) : '';
			$ft_description = get_field('description', $ft_id);

			// アーティスト名を取得（複数の場合は「、」で連結）
			$ft_artists_obj = get_field('artists', $ft_id);
			$ft_artist_names = [];
			if ($ft_artists_obj) {
				foreach ($ft_artists_obj as $ft_artist) {
					$ar_id = is_object($ft_artist) ? $ft_artist->ID : $ft_artist;
					$ar_overview = get_field('overview', $ar_id);
					$ft_artist_names[] = $ar_overview['name2'] ?? get_the_title($ar_id);
				}
			}
			$ft_artist_text = implode('／', $ft_artist_names);

			$reverse_class = ($featured_index % 2 === 1) ? ' exhibitions-index__featured--reverse' : '';
			$featured_index++;
		?>
		<section class="exhibitions-index__featured<?php echo $reverse_class; ?>">
			<?php if ($ft_thumbnail) : ?>
			<picture class="exhibitions-index__featured-img">
				<img src="<?php echo esc_url($ft_thumbnail['url']); ?>" alt="<?php echo esc_attr($ft_thumbnail['alt']); ?>" width="772" height="514" loading="eager">
			</picture>
			<?php endif; ?>
			<div class="exhibitions-index__featured-text">
				<?php if ($ft_artist_text) : ?>
				<p class="exhibitions-index__artist"><?php echo esc_html($ft_artist_text); ?></p>
				<?php endif; ?>
				<div class="exhibitions-index__subtitle">
					<p class="exhibitions-index__subtitle-main"><?php echo esc_html(get_the_title($ft_id)); ?></p>
					<?php if ($ft_subtitle) : ?>
					<p class="exhibitions-index__subtitle-sub"><?php echo esc_html($ft_subtitle); ?></p>
					<?php endif; ?>
				</div>
				<?php if ($ft_period) : ?>
				<div class="exhibitions-index__period"><?php echo esc_html($ft_period); ?></div>
				<?php endif; ?>
				<?php if ($ft_description) : ?>
				<p class="exhibitions-index__description"><?php echo esc_html($ft_description); ?></p>
				<?php endif; ?>
				<a href="<?php echo esc_url(get_permalink($ft_id)); ?>" class="u-link-more">Learn more</a>
			</div>
		</section>
		<?php endforeach; ?>

		<!-- 展示リスト（past） -->
		<?php if (!empty($list_posts)) : ?>
		<?php
		$initial_visible = 3;
		$list_index = 0;
		?>
		<div class="exhibitions-index__list" id="js-exhibitions-list">
			<?php foreach ($list_posts as $list_post) :
				$li_id = $list_post->ID;
				$li_subtitle = get_field('subtitle', $li_id);
				$li_overview_table = get_field('overview_table', $li_id);
				$li_period = (!empty(get_field('period', $li_id))) ? get_field('period', $li_id) : '';

				// アーティスト名
				$li_artists_obj = get_field('artists', $li_id);
				$li_artist_names = [];
				if ($li_artists_obj) {
					foreach ($li_artists_obj as $li_artist) {
						$ar_id = is_object($li_artist) ? $li_artist->ID : $li_artist;
						$ar_overview = get_field('overview', $ar_id);
						$li_artist_names[] = $ar_overview['name2'] ?? get_the_title($ar_id);
					}
				}
				$li_artist_text = implode('／', $li_artist_names);

				$hidden_class = ($list_index >= $initial_visible) ? ' is-hidden' : '';
				$list_index++;
			?>
			<article class="exhibitions-index__item<?php echo $hidden_class; ?>">
				<?php if ($li_artist_text) : ?>
				<p class="exhibitions-index__item-artist"><?php echo esc_html($li_artist_text); ?></p>
				<?php endif; ?>
				<div class="exhibitions-index__item-subtitle">
					<?php echo esc_html(get_the_title($li_id)); ?>
					<?php if ($li_subtitle) : ?>
					<br><span class="exhibitions-index__item-subtitle-sub"><?php echo esc_html($li_subtitle); ?></span>
					<?php endif; ?>
				</div>
				<div class="exhibitions-index__item-bottom">
					<?php if ($li_period) : ?>
					<div class="exhibitions-index__item-period"><?php echo esc_html($li_period); ?></div>
					<?php endif; ?>
					<a href="<?php echo esc_url(get_permalink($li_id)); ?>" class="u-link-more">Learn more</a>
				</div>
			</article>
			<?php endforeach; ?>
		</div>

		<!-- View more -->
		<?php if (count($list_posts) > $initial_visible) : ?>
		<div class="exhibitions-index__more" id="js-exhibitions-more">
			<button type="button" class="u-button-more u-button-more--border">View more</button>
		</div>
		<?php endif; ?>
		<?php endif; ?>
		<?php endif; ?>
	</main>

<?php get_footer(); ?>
