<?php
get_header();

$post_type_labels = [
	'artists'     => 'Artists',
	'exhibitions' => 'Exhibitions',
	'artfairs'    => 'Art Fairs',
	'post'        => 'News',
	'editions'    => 'Editions',
	'books'       => 'Books',
	'page'        => 'Pages',
];

// 記事タイプごとにグループ化
$grouped = [];
if (have_posts()) {
	while (have_posts()) {
		the_post();
		$pt = get_post_type();
		if (!isset($grouped[$pt])) {
			$grouped[$pt] = [];
		}
		$grouped[$pt][] = get_post();
	}
}

// $post_type_labels の順序でソート（定義順を維持）
$ordered = [];
foreach ($post_type_labels as $pt => $label) {
	if (isset($grouped[$pt])) {
		$ordered[$pt] = $grouped[$pt];
	}
}
?>

	<main class="search-results">
		<h1>SEARCH</h1>

		<div class="search-results__heading">
			<h2 class="search-results__title">SEARCH</h2>
		</div>

		<?php if (!empty($ordered)) : ?>
		<div class="search-results__container">
			<div class="search-results__query">
				<p>"<?php echo esc_html(get_search_query()); ?>" の検索結果：<?php echo esc_html($wp_query->found_posts); ?>件</p>
			</div>

			<!-- アンカーリンク -->
			<nav class="search-results__nav">
				<ul class="search-results__nav-list">
					<?php foreach ($ordered as $pt => $posts) : ?>
					<li class="search-results__nav-item">
						<a href="#search-<?php echo esc_attr($pt); ?>"><?php echo esc_html($post_type_labels[$pt]); ?></a>
					</li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<!-- 記事タイプ別セクション -->
			<?php foreach ($ordered as $pt => $posts) : ?>
			<section class="search-results__section" id="search-<?php echo esc_attr($pt); ?>">
				<div class="search-results__section-heading">
					<h3 class="search-results__section-title"><?php echo esc_html($post_type_labels[$pt]); ?></h3>
					<span class="search-results__section-count">( <?php echo count($posts); ?> )</span>
				</div>

				<ul class="search-results__list">
					<?php foreach ($posts as $post) : setup_postdata($post); ?>
					<li class="search-results__item">
						<a href="<?php the_permalink(); ?>" class="news-card">
							<figure class="news-card__img">
								<?php if (has_post_thumbnail()) : ?>
								<img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium_large')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
								<?php else : ?>
								<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/common/noimage.png'); ?>" alt="" loading="lazy">
								<?php endif; ?>
							</figure>
							<div class="news-card__body">
								<div class="news-card__meta">
									<?php if ($pt === 'post') : ?>
									<time class="news-card__date" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
									<?php $categories = get_the_category(); ?>
									<?php if (!empty($categories)) : ?>
									<span class="news-card__separator">/</span>
									<span class="news-card__category"><?php echo esc_html($categories[0]->name); ?></span>
									<?php endif; ?>
									<?php else : ?>
									<span class="news-card__category"><?php echo esc_html($post_type_labels[$pt]); ?></span>
									<?php endif; ?>
								</div>
								<h3 class="news-card__title"><?php the_title(); ?></h3>
							</div>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</section>
			<?php endforeach; ?>
			<?php wp_reset_postdata(); ?>
		</div>

		<?php else : ?>
		<div class="search-results__container">
			<p class="search-results__no-results">検索結果が見つかりませんでした。</p>
		</div>
		<?php endif; ?>
	</main>

<?php get_footer(); ?>
