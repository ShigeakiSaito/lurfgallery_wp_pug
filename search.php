<?php
get_header();

$post_type_labels = [
	'exhibitions' => 'Exhibitions',
	'artists'     => 'Artists',
	'artfairs'    => 'Art Fairs',
	'editions'    => 'Editions',
	'books'       => 'Books',
	'post'        => 'News',
	'page'        => '',
];
?>

	<main class="news-index">
		<h1>SEARCH</h1>

		<div class="news-index__heading">
			<h2 class="news-index__title">SEARCH</h2>
		</div>

		<?php if (have_posts()) : ?>
		<div class="news-index__container">
			<div class="news-index__search-query">
				<p>"<?php echo esc_html(get_search_query()); ?>" の検索結果：<?php echo esc_html($wp_query->found_posts); ?>件</p>
			</div>
			<ul class="news-index__list">
				<?php while (have_posts()) : the_post(); ?>
				<li class="news-index__item">
					<a href="<?php the_permalink(); ?>" class="news-card">
						<figure class="news-card__img">
							<?php if (has_post_thumbnail()) : ?>
							<img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium_large')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
							<?php else : ?>
							<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/common/noimage.png'); ?>" alt="" loading="lazy">
							<?php endif; ?>
						</figure>
						<div class="news-card__body">
							<h3 class="news-card__title"><?php the_title(); ?></h3>
							<div class="news-card__meta">
								<?php if (get_post_type() === 'post') : ?>
								<time class="news-card__date" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
								<?php $categories = get_the_category(); ?>
								<?php if (!empty($categories)) : ?>
								<span class="news-card__separator">/</span>
								<span class="news-card__category"><?php echo esc_html($categories[0]->name); ?></span>
								<?php endif; ?>
								<?php else : ?>
								<span class="news-card__category"><?php
									$pt = get_post_type();
									echo esc_html(isset($post_type_labels[$pt]) ? $post_type_labels[$pt] : get_post_type_object($pt)->labels->name);
								?></span>
								<?php endif; ?>
							</div>
						</div>
					</a>
				</li>
				<?php endwhile; ?>
			</ul>
		</div>

		<!-- ページネーション -->
		<div class="news-index__pagination">
			<?php
			the_posts_pagination([
				'mid_size' => 2,
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;',
			]);
			?>
		</div>

		<?php else : ?>
		<div class="news-index__container">
			<p class="news-index__no-results">検索結果が見つかりませんでした。</p>
		</div>
		<?php endif; ?>
	</main>

<?php get_footer(); ?>
