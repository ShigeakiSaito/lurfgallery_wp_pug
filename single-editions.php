<?php get_header(); ?>

	<main class="single edition-detail">
		<h1>EDITION DETAIL</h1>

		<div class="edition-detail__container">
			<div class="edition-detail__content">
				<!-- 画像エリア -->
				<?php $images = get_field('images'); ?>
				<?php if ($images) : ?>
				<div class="edition-detail__gallery">
					<div class="swiper js-edition-swiper" id="editionSwiper">
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
					<div class="edition-detail__nav">
						<button class="edition-detail__prev js-edition-prev" aria-label="前の画像"></button>
						<span class="edition-detail__counter">
							<span class="js-edition-current">1</span>
							<span class="edition-detail__separator">/</span>
							<span class="js-edition-total"><?php echo count($images); ?></span>
						</span>
						<button class="edition-detail__next js-edition-next" aria-label="次の画像"></button>
					</div>
				</div>
				<?php endif; ?>

				<!-- テキストエリア -->
				<div class="edition-detail__info">
					<?php $artist_name = get_field('artist_name'); ?>
					<?php if (!empty($artist_name['is_display']) && !empty($artist_name['value'])) : ?>
					<h2 class="edition-detail__artist"><?php echo esc_html($artist_name['value']); ?></h2>
					<?php endif; ?>

					<?php $title = get_field('title'); ?>
					<?php if (!empty($title['is_display']) && !empty($title['value'])) : ?>
					<h3 class="edition-detail__title"><?php echo esc_html($title['value']); ?></h3>
					<?php endif; ?>

					<div class="edition-detail__spec">
						<div class="edition-detail__spec-items">
							<?php
							$spec_fields = [
								'year',
								'edition',
								'material',
								'sign',
								'frame',
								'size',
							];
							foreach ($spec_fields as $field_name) :
								$field = get_field($field_name);
								if (!empty($field['is_display']) && !empty($field['value'])) :
							?>
							<p><?php echo esc_html($field['value']); ?></p>
							<?php endif; endforeach; ?>
						</div>
						<?php $description = get_field('description'); ?>
						<?php if (!empty($description['is_display']) && !empty($description['value'])) : ?>
						<p class="edition-detail__description">
							<?php echo esc_html($description['value']); ?>
						</p>
						<?php endif; ?>
					</div>
					<?php $note = get_field('note'); ?>
					<?php if (!empty($note['is_display']) && !empty($note['value'])) : ?>
					<div class="edition-detail__text">
						<p><?php echo esc_html($note['value']); ?></p>
					</div>
					<?php endif; ?>
					<?php $buttons = get_field('buttons'); ?>
          <?php if (!empty($buttons['contact']) || !empty($buttons['purchase'])) : ?>
          <div class="edition-detail__buttons">
            <?php if (!empty($buttons['contact'])) : ?>
            <a href="/art_contact/" class="edition-detail__button">CONTACT</a>
            <?php endif; ?>
            <?php if (!empty($buttons['purchase'])) : ?>
            <a href="<?php echo esc_url(get_field('purchase_url')); ?>" class="edition-detail__button">PURCHASE</a>
            <?php endif; ?>
          </div>
          <?php endif; ?>
				</div>
			</div>

			<!-- 戻るリンク -->
			<div class="edition-detail__back">
				<a href="/exhibitions/" class="edition-detail__back-link">
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
			var swiperEl = document.querySelector('.js-edition-swiper');
			if (!swiperEl) return;

			var slides = swiperEl.querySelectorAll('.swiper-slide');
			var totalEl = document.querySelector('.js-edition-total');
			var currentEl = document.querySelector('.js-edition-current');
			var navEl = document.querySelector('.edition-detail__nav');

			// 1点のみの場合：ナビゲーション非表示、ループ無効
			if (slides.length <= 1) {
				if (navEl) navEl.style.display = 'none';
				return;
			}

			if (totalEl) totalEl.textContent = slides.length;

			var editionSwiper = new Swiper('#editionSwiper', {
				loop: true,
				speed: 600,
				navigation: {
					prevEl: '.js-edition-prev',
					nextEl: '.js-edition-next',
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
