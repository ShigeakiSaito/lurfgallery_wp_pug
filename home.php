<?php get_header(); ?>

	<main class="news-index">
		<h1>NEWS</h1>

		<!-- ページタイトル -->
		<div class="news-index__heading">
			<h2 class="news-index__title">NEWS</h2>
		</div>

		<?php
		$news_query = new WP_Query([
			'post_type' => 'post',
			'posts_per_page' => -1,
			'post_status' => 'publish',
		]);
		?>

		<?php if ($news_query->have_posts()) : ?>
		<div class="news-index__container">
			<ul class="news-index__list">
				<?php $index = 0; ?>
				<?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
				<li class="news-index__item<?php echo $index >= 12 ? ' is-hidden' : ''; ?>">
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
								<time class="news-card__date" datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
								<?php $categories = get_the_category(); ?>
								<?php if (!empty($categories)) : ?>
								<span class="news-card__separator">/</span>
								<span class="news-card__category"><?php echo esc_html($categories[0]->name); ?></span>
								<?php endif; ?>
							</div>
						</div>
					</a>
				</li>
				<?php $index++; ?>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</ul>
			
			<!-- View more -->
			<?php if ($news_query->found_posts > 12) : ?>
			<div class="news-index__more" id="js-news-more">
				<button type="button" class="u-button-more u-button-more--border">View more</button>
			</div>
			<?php endif; ?>
		</div>

		<?php endif; ?>
	</main>

	<script>
		window.addEventListener('load', function() {
			var newsList = document.querySelector('.news-index__list');
			var moreWrap = document.getElementById('js-news-more');

			if (!newsList || !moreWrap) return;

			var moreBtn = moreWrap.querySelector('.u-button-more');

			var updateMoreVisibility = function() {
				var hiddenItems = newsList.querySelectorAll('.news-index__item.is-hidden');
				if (hiddenItems.length === 0) {
					moreWrap.style.display = 'none';
				}
			};

			updateMoreVisibility();

			if (moreBtn) {
				moreBtn.addEventListener('click', function() {
					var hiddenItems = newsList.querySelectorAll('.news-index__item.is-hidden');
					if (hiddenItems.length === 0) return;

					var showCount = Math.min(12, hiddenItems.length);

					for (var i = 0; i < showCount; i++) {
						var item = hiddenItems[i];
						item.classList.remove('is-hidden');
						item.classList.add('is-appearing');

						item.addEventListener('animationend', function() {
							this.classList.remove('is-appearing');
						}, { once: true });
					}

					updateMoreVisibility();
				});
			}
		});
	</script>

<?php get_footer(); ?>
