<?php get_header(); ?>

	<main class="exhibition-detail">
		<h1>EXHIBITION DETAIL</h1>

		<!-- ===== Section 01: メインビジュアル ===== -->
		<?php $main_visual = get_field('main_visual'); ?>
		<?php if (!empty($main_visual['image'])) : ?>
		<section class="exhibition-detail__mv">
			<img class="exhibition-detail__mv-img" src="<?php echo esc_url($main_visual['image']['url']); ?>" alt="<?php echo esc_attr($main_visual['image']['alt']); ?>" width="1512" height="640" loading="eager">
			<div class="exhibition-detail__mv-overlay">
				<?php if (!empty($main_visual['text1'])) : ?>
				<h2 class="exhibition-detail__mv-title"><?php echo nl2br(esc_html($main_visual['text1'])); ?></h2>
				<?php endif; ?>
				<?php if (!empty($main_visual['text2'])) : ?>
				<p class="exhibition-detail__mv-period"><?php echo esc_html($main_visual['text2']); ?></p>
				<?php endif; ?>
			</div>
		</section>
		<?php endif; ?>

		<!-- ===== Section 02: リリース資料 + Contact ===== -->
		<?php
		$release = get_field('release');
		$contact = get_field('contact');
		$release_files = [];
		if ($release) {
			for ($i = 1; $i <= 3; $i++) {
				$fn = !empty($release['filename' . $i]) ? $release['filename' . $i] : '';
				$url = !empty($release['url' . $i]) ? $release['url' . $i] : '';
				if ($fn && $url) {
					$release_files[] = ['filename' => $fn, 'url' => $url];
				}
			}
		}
		?>
		<?php if ($release_files || $contact) : ?>
		<section class="exhibition-detail__materials">
			<div class="exhibition-detail__materials-inner">
				<?php if ($release_files) : ?>
				<ul class="exhibition-detail__materials-list">
					<?php foreach ($release_files as $file) : ?>
					<li>
						<a href="<?php echo esc_url($file['url']); ?>" class="exhibition-detail__materials-link" target="_blank" rel="noopener noreferrer" download>
							<?php echo esc_html($file['filename']); ?>
							<svg class="exhibition-detail__materials-icon" width="24" height="24" viewBox="0 -960 960 960" xmlns="http://www.w3.org/2000/svg">
								<path d="M480-340 280-540l56-56 104 104v-348h80v348l104-104 56 56-200 200ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z" fill="#1F1F1F"></path>
							</svg>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
				<?php if ($contact) : ?>
				<a href="/contact/" class="exhibition-detail__materials-contact">Contact</a>
				<?php endif; ?>
			</div>
		</section>
		<?php endif; ?>

		<!-- ===== Section 04: 展示会説明 ===== -->
		<?php $description = get_field('description'); ?>
		<?php if ($description) : ?>
		<section class="exhibition-detail__description">
			<div class="exhibition-detail__description-body">
				<p><?php echo nl2br(esc_html($description)); ?></p>
			</div>
		</section>
		<?php endif; ?>

		<!-- ===== Section 05: 展示概要 ===== -->
		<?php $overview = get_field('overview'); ?>
		<?php $overview_note = get_field('overview_note'); ?>
		<?php if ($overview || $overview_note) : ?>
		<section class="exhibition-detail__overview">
			<?php if ($overview) : ?>
			<?php echo $overview; ?>
			<?php endif; ?>
			<?php if ($overview_note) : ?>
			<p><?php echo esc_html($overview_note); ?></p>
			<?php endif; ?>
		</section>
		<?php endif; ?>

		<!-- ===== Section 06: ステートメント / 寄稿文 ===== -->
		<?php $statement = get_field('statement'); ?>
		<?php $contribution = get_field('contribution'); ?>
		<?php if ($statement || $contribution) : ?>
		<section class="exhibition-detail__statement">
			<?php if ($statement) : ?>
			<div class="exhibition-detail__statement-upper">
				<p class="exhibition-detail__statement-heading">Statement</p>
				<div class="exhibition-detail__statement-body">
					<?php echo nl2br(esc_html($statement)); ?>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($contribution) : ?>
			<div class="exhibition-detail__statement-lower">
				<?php echo nl2br(esc_html($contribution)); ?>
			</div>
			<?php endif; ?>
		</section>
		<?php endif; ?>

		<!-- ===== Section 07: FEATURED WORKS ===== -->
		<?php $featured_works = get_field('featured_works'); ?>
		<?php if ($featured_works) : ?>
		<?php
		$col = get_field('featured_works_column');
		$col = in_array($col, ['1', '2', '3']) ? $col : '3';
		?>
		<section class="exhibition-detail__works">
			<h3 class="exhibition-detail__section-heading">Featured Works</h3>
			<div class="exhibition-detail__works-grid">
				<div class="exhibition-detail__works-row exhibition-detail__works-row--col<?php echo $col; ?>">
					<?php
					$visible_count = (int) $col * 5;
					foreach ($featured_works as $index => $work) :
						$work_images = get_field('images', $work->ID);
						$work_image = '';
						if ($work_images && !empty($work_images[0]['image'])) {
							$work_image = $work_images[0]['image'];
						}
						$work_artist = get_field('artist_name', $work->ID);
						$work_title_field = get_field('title', $work->ID);
						$is_hidden = $index >= $visible_count;
					?>
					<a href="<?php echo esc_url(get_permalink($work->ID)); ?>" class="exhibition-detail__work<?php echo $is_hidden ? ' is-hidden' : ''; ?>">
						<?php if ($work_image) : ?>
						<div class="exhibition-detail__work-img">
							<img src="<?php echo esc_url($work_image['url']); ?>" alt="<?php echo esc_attr($work_image['alt']); ?>" loading="lazy">
						</div>
						<?php endif; ?>
						<div class="exhibition-detail__work-info">
							<?php if (!empty($work_artist['value'])) : ?>
							<p class="exhibition-detail__work-artist"><?php echo esc_html($work_artist['value']); ?></p>
							<?php endif; ?>
							<?php if (!empty($work_title_field['value'])) : ?>
							<p class="exhibition-detail__work-spec"><?php echo esc_html($work_title_field['value']); ?></p>
							<?php endif; ?>
						</div>
					</a>
					<?php endforeach; ?>
				</div>
			</div>

			<?php if (count($featured_works) > $visible_count) : ?>
			<!-- View more -->
			<div class="exhibition-detail__works-more" id="js-exhibition-works-more">
				<button type="button" class="u-button-more u-button-more--border">View more</button>
			</div>
			<?php endif; ?>
		</section>
		<?php endif; ?>

		<!-- ===== Section 08: CONTACTボタン（セクション間） ===== -->
		<?php $contact_url = get_field('contact_url'); ?>
		<?php if ($contact_url) : ?>
		<div class="exhibition-detail__works-cta">
			<p class="exhibition-detail__works-cta-text">販売作品リストをご希望の方は、お問い合わせよりご連絡ください</p>
			<a href="<?php echo esc_url($contact_url); ?>" class="exhibition-detail__works-cta-button">CONTACT</a>
		</div>
		<?php endif; ?>

		<!-- ===== Section 09: EDITION ===== -->
		<?php $editions = get_field('editions'); ?>
		<?php if ($editions) : ?>
		<section class="exhibition-detail__edition">
			<h3 class="exhibition-detail__section-heading">Edition</h3>
			<div class="exhibition-detail__edition-grid">
				<?php foreach ($editions as $edition) :
					$ed_images = get_field('images', $edition->ID);
					$ed_image = (!empty($ed_images[0]['image'])) ? $ed_images[0]['image'] : null;
					$ed_artist = get_field('artist_name', $edition->ID);
					$ed_title = get_field('title', $edition->ID);
				?>
				<a href="<?php echo esc_url(get_permalink($edition->ID)); ?>" class="exhibition-detail__edition-item">
					<?php if ($ed_image) : ?>
					<div class="exhibition-detail__edition-img">
						<img src="<?php echo esc_url($ed_image['url']); ?>" alt="<?php echo esc_attr($ed_image['alt']); ?>" loading="lazy">
					</div>
					<?php endif; ?>
					<div class="exhibition-detail__edition-info">
						<?php if (!empty($ed_artist['value'])) : ?>
						<p class="exhibition-detail__edition-artist"><?php echo esc_html($ed_artist['value']); ?></p>
						<?php endif; ?>
						<?php if (!empty($ed_title['value'])) : ?>
						<p class="exhibition-detail__edition-spec"><?php echo esc_html($ed_title['value']); ?></p>
						<?php endif; ?>
					</div>
				</a>
				<?php endforeach; ?>
			</div>
		</section>
		<?php endif; ?>

		<!-- ===== Section 10: BOOKS ===== -->
		<?php $books = get_field('books'); ?>
		<?php if ($books) : ?>
		<section class="exhibition-detail__books">
			<h3 class="exhibition-detail__section-heading">Books</h3>
			<div class="exhibition-detail__books-grid">
				<?php foreach ($books as $book) :
					$bk_images = get_field('images', $book->ID);
					$bk_image = (!empty($bk_images[0]['image'])) ? $bk_images[0]['image'] : null;
					$bk_artist = get_field('artist_name', $book->ID);
					$bk_title = get_field('title', $book->ID);
				?>
				<a href="<?php echo esc_url(get_permalink($book->ID)); ?>" class="exhibition-detail__books-item">
					<?php if ($bk_image) : ?>
					<div class="exhibition-detail__books-img">
						<img src="<?php echo esc_url($bk_image['url']); ?>" alt="<?php echo esc_attr($bk_image['alt']); ?>" loading="lazy">
					</div>
					<?php endif; ?>
					<div class="exhibition-detail__books-info">
						<?php if (!empty($bk_artist['value'])) : ?>
						<p class="exhibition-detail__books-artist"><?php echo esc_html($bk_artist['value']); ?></p>
						<?php endif; ?>
						<?php if (!empty($bk_title['value'])) : ?>
						<p class="exhibition-detail__books-spec"><?php echo esc_html($bk_title['value']); ?></p>
						<?php endif; ?>
					</div>
				</a>
				<?php endforeach; ?>
			</div>
		</section>
		<?php endif; ?>

		<!-- ===== Section 11: EVENTS ===== -->
		<?php $events = get_field('events'); ?>
		<?php if ($events) : ?>
		<section class="exhibition-detail__events">
			<h3 class="exhibition-detail__section-heading">Events</h3>
			<div class="exhibition-detail__events-body">
				<?php echo $events; ?>
			</div>
		</section>
		<?php endif; ?>

		<!-- ===== Section 12: ARTISTS ===== -->
		<?php $artists = get_field('artists'); ?>
		<?php if ($artists) : ?>
		<section class="exhibition-detail__artists">
			<h3 class="exhibition-detail__section-heading">Artists</h3>
			<div class="exhibition-detail__artists-list">
				<?php foreach ($artists as $artist) :
					$ar_mv = get_field('mv_images', $artist->ID);
					$ar_image = (!empty($ar_mv['pc'])) ? $ar_mv['pc'] : null;
					$ar_description = get_field('overview', $artist->ID)['profile'] ?? '';
				?>
				<div class="exhibition-detail__artist-item">
					<?php if ($ar_image) : ?>
					<div class="exhibition-detail__artist-img">
						<img src="<?php echo esc_url($ar_image['url']); ?>" alt="<?php echo esc_attr($ar_image['alt']); ?>" loading="lazy">
					</div>
					<?php endif; ?>
					<div class="exhibition-detail__artist-info">
						<p class="exhibition-detail__artist-name"><?php echo esc_html(get_the_title($artist->ID)); ?></p>
						<?php if ($ar_description) : ?>
						<p class="exhibition-detail__artist-bio"><?php echo esc_html($ar_description); ?></p>
						<?php endif; ?>
						<a href="<?php echo esc_url(get_permalink($artist->ID)); ?>" class="u-link-more">Learn more</a>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</section>
		<?php endif; ?>

		<!-- ===== Section 13: INSTALLATION VIEWS ===== -->
		<?php $installation_views = get_field('installation_views'); ?>
		<?php if ($installation_views) : ?>
		<section class="exhibition-detail__installation">
			<h3 class="exhibition-detail__section-heading">Installation Views</h3>
			<div class="exhibition-detail__installation-nav">
				<button class="exhibition-detail__installation-prev js-installation-prev" aria-label="前の画像"></button>
				<span class="exhibition-detail__installation-counter">
					<span class="js-installation-current">1</span>
					<span class="exhibition-detail__installation-separator">/</span>
					<span class="js-installation-total"><?php echo count($installation_views); ?></span>
				</span>
				<button class="exhibition-detail__installation-next js-installation-next" aria-label="次の画像"></button>
			</div>
			<div class="exhibition-detail__installation-slider">
				<div class="swiper js-installation-swiper" id="installationSwiper">
					<div class="swiper-wrapper">
						<?php foreach ($installation_views as $index => $view) : ?>
						<div class="swiper-slide">
							<img src="<?php echo esc_url($view['item']['url']); ?>" alt="<?php echo esc_attr($view['item']['alt'] ?: '展示風景 ' . ($index + 1)); ?>" loading="lazy">
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
		<?php endif; ?>

		<!-- ===== Section 14: FILM ===== -->
		<?php $film = get_field('film'); ?>
		<?php if (!empty($film['youtube_url'])) : ?>
		<?php
		// YouTube URL を埋め込み用に変換
		$youtube_embed_url = '';
		if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/))([a-zA-Z0-9_-]+)/', $film['youtube_url'], $matches)) {
			$youtube_embed_url = 'https://www.youtube.com/embed/' . $matches[1];
		}
		?>
		<section class="exhibition-detail__film">
			<div class="exhibition-detail__film-header">
				<h3 class="exhibition-detail__section-heading">Film</h3>
				<?php if (!empty($film['see_more_on_youtube_url'])) : ?>
				<a href="<?php echo esc_url($film['see_more_on_youtube_url']); ?>" class="exhibition-detail__film-link" target="_blank" rel="noopener noreferrer">
					See more on Youtube
					<svg class="exhibition-detail__film-link-icon" width="24" height="24" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8-8-8z" fill="currentColor"></path></svg>
				</a>
				<?php endif; ?>
			</div>
			<?php if ($youtube_embed_url) : ?>
			<div class="exhibition-detail__film-content">
				<div class="exhibition-detail__film-player">
					<iframe src="<?php echo esc_url($youtube_embed_url); ?>" title="Exhibition Film" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
				</div>
				<?php if (!empty($film['caption'])) : ?>
				<p class="exhibition-detail__film-caption"><?php echo esc_html($film['caption']); ?></p>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<?php if (!empty($film['event_title']) || !empty($film['event_description'])) : ?>
			<div class="exhibition-detail__film-body">
				<?php if (!empty($film['event_title'])) : ?>
				<h4 class="exhibition-detail__film-title"><?php echo esc_html($film['event_title']); ?></h4>
				<?php endif; ?>
				<?php if (!empty($film['event_description'])) : ?>
				<p class="exhibition-detail__film-text"><?php echo nl2br(esc_html($film['event_description'])); ?></p>
				<?php endif; ?>
			</div>
			<?php endif; ?>
		</section>
		<?php endif; ?>

		<!-- ===== Section 15: PRODUCT ===== -->
		<?php $product = get_field('product'); ?>
		<?php if (!empty($product['image']) || !empty($product['description'])) : ?>
		<section class="exhibition-detail__product">
			<h3 class="exhibition-detail__section-heading">Product</h3>
			<?php if (!empty($product['image'])) : ?>
			<div class="exhibition-detail__product-content">
				<div class="exhibition-detail__product-img">
					<img src="<?php echo esc_url($product['image']['url']); ?>" alt="<?php echo esc_attr($product['image']['alt']); ?>" loading="lazy">
				</div>
			</div>
			<?php endif; ?>
			<?php if (!empty($product['description'])) : ?>
			<p class="exhibition-detail__product-text"><?php echo nl2br(esc_html($product['description'])); ?></p>
			<?php endif; ?>
			<?php if (!empty($product['shop_name']) && !empty($product['shop_url'])) : ?>
			<p class="exhibition-detail__product-shop">
				<?php echo esc_html($product['shop_name']); ?> : <a href="<?php echo esc_url($product['shop_url']); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($product['shop_url']); ?></a>
			</p>
			<?php endif; ?>
		</section>
		<?php endif; ?>

	</main>

	<script>
		window.addEventListener('load', function() {
			// ----- Installation Views Swiper -----
			var installEl = document.querySelector('.js-installation-swiper');
			if (installEl) {
				var installSlides = installEl.querySelectorAll('.swiper-slide');
				var slideCount = installSlides.length;
				var installTotal = document.querySelector('.js-installation-total');
				var installCurrent = document.querySelector('.js-installation-current');
				var installNav = document.querySelector('.exhibition-detail__installation-nav');

				if (slideCount <= 1) {
					if (installNav) installNav.style.display = 'none';
				} else {
					if (installTotal) installTotal.textContent = slideCount;

					function getInstallGap() {
						return window.innerWidth >= 768
							? Math.min(Math.max(window.innerWidth * 0.08, 40), 104)
							: 16;
					}

					// loopにはslidesPerViewの2倍以上のスライドが必要
					var isPC = window.innerWidth >= 768;
					var canLoop = isPC ? slideCount > 4 : slideCount > 2;

					var installSwiper = new Swiper('#installationSwiper', {
						loop: canLoop,
						speed: 600,
						slidesPerView: 1,
						spaceBetween: getInstallGap(),
						breakpoints: {
							768: {
								slidesPerView: 2
							}
						},
						navigation: {
							prevEl: '.js-installation-prev',
							nextEl: '.js-installation-next'
						},
						on: {
							slideChange: function() {
								if (installCurrent) {
									var index = canLoop ? this.realIndex : this.activeIndex;
									installCurrent.textContent = index + 1;
								}
							}
						}
					});

					window.addEventListener('resize', function() {
						installSwiper.params.spaceBetween = getInstallGap();
						installSwiper.update();
					});
				}
			}

		});

	// ----- View more (FEATURED WORKS) -----
	const worksList = document.querySelector('.exhibition-detail__works-grid');
	const worksMoreWrap = document.getElementById('js-exhibition-works-more');

	if (worksList && worksMoreWrap) {
		const worksBtn = worksMoreWrap.querySelector('.u-button-more');

		const getShowCount = (item) => {
			const row = item.closest('.exhibition-detail__works-row');
			if (row?.classList.contains('exhibition-detail__works-row--col1')) return 1;
			if (row?.classList.contains('exhibition-detail__works-row--col2')) return 2;
			return 3;
		};

		const updateWorksMoreVisibility = () => {
			const hiddenItems = worksList.querySelectorAll('.exhibition-detail__work.is-hidden');
			if (hiddenItems.length === 0) {
				worksMoreWrap.style.display = 'none';
			}
		};

		updateWorksMoreVisibility();

		if (worksBtn) {
			worksBtn.addEventListener('click', () => {
				const hiddenItems = worksList.querySelectorAll('.exhibition-detail__work.is-hidden');
				if (hiddenItems.length === 0) return;

				const showCount = Math.min(getShowCount(hiddenItems[0]), hiddenItems.length);

				for (let i = 0; i < showCount; i++) {
					const item = hiddenItems[i];
					item.classList.remove('is-hidden');
					item.classList.add('is-appearing');

					item.addEventListener('animationend', () => {
						item.classList.remove('is-appearing');
					}, { once: true });
				}

				updateWorksMoreVisibility();
			});
		}
	}
	</script>

<?php get_footer(); ?>
