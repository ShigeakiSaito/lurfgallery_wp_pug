<?php get_header(); ?>

	<main class="artfair-index">
		<h1>ART FAIR</h1>

		<!-- タブナビゲーション -->
		<?php
		$current_status = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'all';
		$current_year = isset($_GET['af_year']) ? sanitize_text_field($_GET['af_year']) : 'all';

		$status_terms = get_terms(array(
			'taxonomy' => 'exhibition_status',
			'hide_empty' => false,
		));

		// current / forthcoming のスラッグを取得
		$cf_slugs = [];
		foreach ($status_terms as $term) {
			if ($term->slug !== 'past') {
				$cf_slugs[] = $term->slug;
			}
		}

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
					<li class="exhibitions-index__tab<?php echo $current_status === 'current-forthcoming' ? ' is-active' : ''; ?>" data-status="current-forthcoming">CURRENT & FORTHCOMING</li>
					<?php foreach ($status_terms as $term) :
						if ($term->slug === 'past') : ?>
					<li class="exhibitions-index__tab<?php echo $current_status === $term->slug ? ' is-active' : ''; ?>" data-status="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></li>
					<?php endif;
					endforeach; ?>
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
		if ($current_status === 'current-forthcoming') {
			// current と forthcoming を OR で取得
			$tax_query[] = array(
				'taxonomy' => 'exhibition_status',
				'field' => 'slug',
				'terms' => $cf_slugs,
				'operator' => 'IN',
			);
		} elseif ($current_status !== 'all') {
			$tax_query[] = array(
				'taxonomy' => 'exhibition_status',
				'field' => 'slug',
				'terms' => $current_status,
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

		$artfairs_query = new WP_Query($query_args);
		$artfairs = $artfairs_query->posts;
		?>

		<?php if (empty($artfairs)) : ?>
		<!-- 空状態メッセージ -->
		<div class="exhibitions-index__empty">
			<p class="exhibitions-index__empty-message">Sorry, there's nothing to see here yet.</p>
		</div>
		<?php else : ?>

		<?php
		$initial_visible = 3;
		$list_index = 0;
		?>
		<div class="artfair-index__list" id="js-artfair-list">
			<?php foreach ($artfairs as $af_post) :
				$af_id = $af_post->ID;
				$af_mv = get_field('main_visual', $af_id);
				$af_mv_image = (!empty($af_mv['image'])) ? $af_mv['image'] : null;
				$af_subtitle = get_field('subtitle', $af_id);
				$af_period = (!empty(get_field('period', $af_id))) ? get_field('period', $af_id) : '';
				$af_description = get_field('description', $af_id);

				// アーティスト名を取得（複数の場合は「、」で連結）
				$af_artists_obj = get_field('artists', $af_id);
				$af_artist_names = [];
				if ($af_artists_obj) {
					foreach ($af_artists_obj as $af_artist) {
						$ar_id = is_object($af_artist) ? $af_artist->ID : $af_artist;
						$ar_overview = get_field('overview', $ar_id);
						$af_artist_names[] = $ar_overview['name2'] ?? get_the_title($ar_id);
					}
				}
				$af_artist_text = implode('、', $af_artist_names);

				$hidden_class = ($list_index >= $initial_visible) ? ' is-hidden' : '';
				$list_index++;
			?>
			<article class="artfair-index__item<?php echo $hidden_class; ?>">
				<?php if ($af_mv_image) : ?>
				<picture class="artfair-index__img">
					<img src="<?php echo esc_url($af_mv_image['url']); ?>" alt="<?php echo esc_attr($af_mv_image['alt']); ?>" width="772" height="546" loading="<?php echo $list_index <= 1 ? 'eager' : 'lazy'; ?>">
				</picture>
				<?php endif; ?>
				<div class="artfair-index__text">
					<?php if ($af_artist_text) : ?>
					<p class="artfair-index__name"><?php echo esc_html($af_artist_text); ?></p>
					<?php endif; ?>
					<div class="artfair-index__subtitle">
						<p class="artfair-index__subtitle-main"><?php echo esc_html(get_the_title($af_id)); ?></p>
						<?php if ($af_subtitle) : ?>
						<p class="artfair-index__subtitle-sub"><?php echo esc_html($af_subtitle); ?></p>
						<?php endif; ?>
					</div>
					<?php if ($af_period) : ?>
					<div class="artfair-index__period"><?php echo esc_html($af_period); ?></div>
					<?php endif; ?>
					<?php if ($af_description) : ?>
					<p class="artfair-index__description"><?php echo esc_html($af_description); ?></p>
					<?php endif; ?>
					<div class="artfair-index__link">
						<a href="<?php echo esc_url(get_permalink($af_id)); ?>" class="u-link-more">Learn more</a>
					</div>
				</div>
			</article>
			<?php endforeach; ?>
		</div>

		<!-- View more -->
		<?php if (count($artfairs) > $initial_visible) : ?>
		<div class="artfair-index__more" id="js-artfair-more">
			<button type="button" class="u-button-more u-button-more--border">View more</button>
		</div>
		<?php endif; ?>
		<?php endif; ?>
	</main>

<?php get_footer(); ?>
