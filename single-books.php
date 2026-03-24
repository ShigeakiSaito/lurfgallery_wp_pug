<?php get_header(); ?>

	<main class="single books-detail">
		<h1>BOOKS DETAIL</h1>

		<div class="books-detail__container">
			<div class="books-detail__content">
				<!-- 画像エリア -->
				<?php $images = get_field('images'); ?>
				<?php if ($images) : ?>
				<div class="books-detail__gallery">
					<div class="swiper js-books-swiper" id="booksSwiper">
						<div class="swiper-wrapper">
							<?php foreach ($images as $index => $row) :
								$image = $row['image'];
								if (!$image) continue;
							?>
							<div class="swiper-slide">
								<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
							</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="books-detail__nav">
						<button class="books-detail__prev js-books-prev" aria-label="前の画像"></button>
						<span class="books-detail__counter">
							<span class="js-books-current">1</span>
							<span class="books-detail__separator">/</span>
							<span class="js-books-total"><?php echo count($images); ?></span>
						</span>
						<button class="books-detail__next js-books-next" aria-label="次の画像"></button>
					</div>
				</div>
				<?php endif; ?>

				<!-- テキストエリア -->
				<div class="books-detail__info">
					<?php $artist_name = get_field('artist_name'); ?>
					<?php if (!empty($artist_name['is_display_detail']) && !empty($artist_name['value'])) : ?>
					<h2 class="books-detail__artist"><?php echo esc_html($artist_name['value']); ?></h2>
					<?php endif; ?>

					<?php $title = get_field('title'); ?>
					<?php if (!empty($title['is_display_detail']) && !empty($title['value'])) : ?>
					<h3 class="books-detail__title"><?php echo esc_html($title['value']); ?></h3>
					<?php endif; ?>

					<div class="books-detail__spec">
						<div class="books-detail__spec-items">
							<?php
							$spec_fields = [
								'release_date',
								'size',
								'page_num',
							];
							foreach ($spec_fields as $field_name) :
								$field = get_field($field_name);
								if (!empty($field['is_display_detail']) && !empty($field['value'])) :
							?>
							<p><?php echo esc_html($field['value']); ?></p>
							<?php endif; endforeach; ?>
						</div>
						<?php $description = get_field('description'); ?>
						<?php if (!empty($description['is_display_detail']) && !empty($description['value'])) : ?>
						<p class="books-detail__description"><?php echo esc_html($description['value']); ?></p>
						<?php endif; ?>
					</div>
					<?php $note = get_field('note'); ?>
					<?php if (!empty($note['is_display_detail']) && !empty($note['value'])) : ?>
					<div class="books-detail__text">
						<p><?php echo esc_html($note['value']); ?></p>
					</div>
					<?php endif; ?>
					<?php $price = get_field('price'); ?>
					<?php if (!empty($price['is_display_detail']) && !empty($price['value'])) : ?>
					<p class="books-detail__price">￥<?php echo esc_html(number_format((int) $price['value'])); ?> <span class="books-detail__tax">(税込)</span></p>
					<?php endif; ?>
					<?php $buttons = get_field('buttons'); ?>
					<?php if (!empty($buttons['contact']) || !empty($buttons['purchase'])) : ?>
					<?php
					// 作品お問い合わせURL構築
					$release_date_field = get_field('release_date');
					$size_field = get_field('size');
					$contact_params = [
						'artwork_artist'   => !empty($artist_name['value']) ? $artist_name['value'] : '',
						'artwork_title'    => !empty($title['value']) ? $title['value'] : '',
						'artwork_year'     => !empty($release_date_field['value']) ? $release_date_field['value'] : '',
						'artwork_size'     => !empty($size_field['value']) ? $size_field['value'] : '',
						'ref'              => get_permalink(),
					];
					if (!empty($images[0]['image']['url'])) {
						$contact_params['artwork_image'] = $images[0]['image']['url'];
					}
					$art_contact_url = home_url('/art_contact/') . '?' . http_build_query($contact_params);
					?>
					<div class="books-detail__buttons">
						<?php if (!empty($buttons['contact'])) : ?>
						<a href="<?php echo esc_url($art_contact_url); ?>" class="books-detail__button">CONTACT</a>
						<?php endif; ?>
						<?php if (!empty($buttons['purchase'])) : ?>
						<a href="<?php echo esc_url(get_field('purchase_url')); ?>" class="books-detail__button">PURCHASE</a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- 戻るリンク -->
			<div class="books-detail__back">
				<a href="/exhibitions/" class="books-detail__back-link">
					<svg width="24" height="24" viewBox="0 -960 960 960" xmlns="http://www.w3.org/2000/svg">
						<path d="M360-200 80-480l280-280 57 56-184 184h567v80H233l184 184-57 56Z" fill="#222"></path>
					</svg>
					<span>Back</span>
				</a>
			</div>
		</div>
	</main>

	<script>
		window.addEventListener('load', function() {
			var swiperEl = document.querySelector('.js-books-swiper');
			if (!swiperEl) return;

			var slides = swiperEl.querySelectorAll('.swiper-slide');
			var totalEl = document.querySelector('.js-books-total');
			var currentEl = document.querySelector('.js-books-current');
			var navEl = document.querySelector('.books-detail__nav');

			// 1点のみの場合：ナビゲーション非表示、ループ無効
			if (slides.length <= 1) {
				if (navEl) navEl.style.display = 'none';
				return;
			}

			if (totalEl) totalEl.textContent = slides.length;

			var booksSwiper = new Swiper('#booksSwiper', {
				loop: true,
				speed: 600,
				navigation: {
					prevEl: '.js-books-prev',
					nextEl: '.js-books-next',
				},
				on: {
					slideChange: function() {
						if (currentEl) {
							currentEl.textContent = this.realIndex + 1;
						}
					}
				}
			});
		});
	</script>

<?php get_footer(); ?>
