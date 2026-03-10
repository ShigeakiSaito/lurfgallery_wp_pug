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
		<div class="exhibition-detail__works-cta">
			<p class="exhibition-detail__works-cta-text">販売作品リストをご希望の方は、お問い合わせよりご連絡ください</p>
			<a href="/contact/" class="exhibition-detail__works-cta-button">CONTACT</a>
		</div>

		<!-- ===== Section 09: EDITION ===== -->
		<section class="exhibition-detail__edition">
			<h3 class="exhibition-detail__section-heading">Eddition</h3>
			<div class="exhibition-detail__edition-grid">
				<a href="/exhibitions/edition/" class="exhibition-detail__edition-item">
					<div class="exhibition-detail__edition-img">
						<img src="/assets/img/exhibitions/img_exhibition-detail-work01.png" alt="Edition 1" loading="lazy">
					</div>
					<div class="exhibition-detail__edition-info">
						<p class="exhibition-detail__edition-artist">MAEDA Nobuaki</p>
						<p class="exhibition-detail__edition-spec">UB21-0210, 2021,Acrylic and pigment on <br>canvas,200.7×185.0×7.5cm</p>
					</div>
				</a>
				<a href="/exhibitions/edition/" class="exhibition-detail__edition-item">
					<div class="exhibition-detail__edition-img">
						<img src="/assets/img/exhibitions/img_exhibition-detail-work02.png" alt="Edition 2" loading="lazy">
					</div>
					<div class="exhibition-detail__edition-info">
						<p class="exhibition-detail__edition-artist">會見 明也</p>
						<p class="exhibition-detail__edition-spec">UB21-0210, 2021,Acrylic and pigment on <br>canvas,200.7×185.0×7.5cm</p>
					</div>
				</a>
				<a href="/exhibitions/edition/" class="exhibition-detail__edition-item">
					<div class="exhibition-detail__edition-img">
						<img src="/assets/img/exhibitions/img_exhibition-detail-work03.png" alt="Edition 3" loading="lazy">
					</div>
					<div class="exhibition-detail__edition-info">
						<p class="exhibition-detail__edition-artist">ヒロ杉山</p>
						<p class="exhibition-detail__edition-spec">UB21-0210, 2021,Acrylic and pigment on <br>canvas,200.7×185.0×7.5cm</p>
					</div>
				</a>
			</div>
		</section>

		<!-- ===== Section 10: BOOKS ===== -->
		<section class="exhibition-detail__books">
			<h3 class="exhibition-detail__section-heading">Books</h3>
			<div class="exhibition-detail__books-grid">
				<a href="/exhibitions/books/" class="exhibition-detail__books-item">
					<div class="exhibition-detail__books-img">
						<img src="/assets/img/exhibitions/img_exhibition-detail-work01.png" alt="Book 1" loading="lazy">
					</div>
					<div class="exhibition-detail__books-info">
						<p class="exhibition-detail__books-artist">MAEDA Nobuaki</p>
						<p class="exhibition-detail__books-spec">UB21-0210, 2021,Acrylic and pigment on <br>canvas,200.7×185.0×7.5cm</p>
					</div>
				</a>
				<a href="/exhibitions/books/" class="exhibition-detail__books-item">
					<div class="exhibition-detail__books-img">
						<img src="/assets/img/exhibitions/img_exhibition-detail-work02.png" alt="Book 2" loading="lazy">
					</div>
					<div class="exhibition-detail__books-info">
						<p class="exhibition-detail__books-artist">會見 明也</p>
						<p class="exhibition-detail__books-spec">UB21-0210, 2021,Acrylic and pigment on <br>canvas,200.7×185.0×7.5cm</p>
					</div>
				</a>
				<a href="/exhibitions/books/" class="exhibition-detail__books-item">
					<div class="exhibition-detail__books-img">
						<img src="/assets/img/exhibitions/img_exhibition-detail-work03.png" alt="Book 3" loading="lazy">
					</div>
					<div class="exhibition-detail__books-info">
						<p class="exhibition-detail__books-artist">ヒロ杉山</p>
						<p class="exhibition-detail__books-spec">UB21-0210, 2021,Acrylic and pigment on <br>canvas,200.7×185.0×7.5cm</p>
					</div>
				</a>
			</div>
		</section>

		<!-- ===== Section 11: EVENTS ===== -->
		<section class="exhibition-detail__events">
			<h3 class="exhibition-detail__section-heading">Events</h3>
			<div class="exhibition-detail__events-body">
				<div class="exhibition-detail__event-header">
					<h4 class="exhibition-detail__event-title">トークセッションのお知らせ</h4>
					<p class="exhibition-detail__event-text">あのイーハトーヴォのすきとおった風、夏でも底に冷たさをもつ青いそら、うつくしい森で飾られたモリーオ市、郊外のぎらぎらひかる草の波。 またそのなかでいっしょになったたくさんのひとたち、ファゼーロとロザーロ、羊飼のミーロや、顔の赤いこどもたち、地主のテーモ、山猫博士のボーガント・デストゥパーゴなど、いまこの暗い巨きな石の建物のなかで考えていると、みんなむかし風のなつかしい青い幻燈のように思われます。</p>
				</div>
				<div class="exhibition-detail__event-detail">
					<p class="exhibition-detail__event-subtitle">トークセッション</p>
					<ul class="exhibition-detail__event-list">
						<li class="exhibition-detail__event-item">
							<span class="exhibition-detail__event-label">会期</span>
							<span class="exhibition-detail__event-value">2025年8月2日(土)～9月1日(月)</span>
						</li>
						<li class="exhibition-detail__event-item">
							<span class="exhibition-detail__event-label">会場</span>
							<span class="exhibition-detail__event-value">LURF GALLERY 1F・2F</span>
						</li>
						<li class="exhibition-detail__event-item">
							<span class="exhibition-detail__event-label">時間</span>
							<span class="exhibition-detail__event-value">11：00 - 19：00</span>
						</li>
						<li class="exhibition-detail__event-item">
							<span class="exhibition-detail__event-label">住所</span>
							<span class="exhibition-detail__event-value">150-0033 東京都渋谷区猿楽町28-13 Roob1</span>
						</li>
						<li class="exhibition-detail__event-item">
							<span class="exhibition-detail__event-label">入場</span>
							<span class="exhibition-detail__event-value">無料</span>
						</li>
					</ul>
					<div class="exhibition-detail__event-notes">
						<p>※当日は席に限りがございますため、立ち見でのご鑑賞をお願いする場合がございます。</p>
						<p>※混雑の状況により、入場を一時制限させていただく場合がございます。</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ===== Section 12: ARTISTS ===== -->
		<section class="exhibition-detail__artists">
			<h3 class="exhibition-detail__section-heading">Artists</h3>
			<div class="exhibition-detail__artists-list">
				<div class="exhibition-detail__artist-item">
					<div class="exhibition-detail__artist-img">
						<img src="/assets/img/artfairs/img_artfairs-artists01.png" alt="AIKA NAGANO" loading="lazy">
					</div>
					<div class="exhibition-detail__artist-info">
						<p class="exhibition-detail__artist-name">AIKA NAGANO</p>
						<p class="exhibition-detail__artist-name-ja">永野 愛佳</p>
						<p class="exhibition-detail__artist-bio">無限空間である"間"を有限のものとして。日本絵画における画面の構成は図と余白である"間"が重要視されるが、自身の作品では余白の間を光と捉え、画面の地、つまり"有限の間"をメインとしている。本来触れる事のなかった無限の間に光として白い地を与え、時間や湿度、季節などの機微を含み作者の肉感を得ることを狙いとした。ものとものの間隔…</p>
						<a href="/artist/sample/" class="u-link-more">Learn more</a>
					</div>
				</div>
			</div>
		</section>

		<!-- ===== Section 13: INSTALLATION VIEWS ===== -->
		<section class="exhibition-detail__installation">
			<h3 class="exhibition-detail__section-heading">Installation Views</h3>
			<div class="exhibition-detail__installation-nav">
				<button class="exhibition-detail__installation-prev js-installation-prev" aria-label="前の画像"></button>
				<span class="exhibition-detail__installation-counter">
					<span class="js-installation-current">1</span>
					<span class="exhibition-detail__installation-separator">/</span>
					<span class="js-installation-total">6</span>
				</span>
				<button class="exhibition-detail__installation-next js-installation-next" aria-label="次の画像"></button>
			</div>
			<div class="exhibition-detail__installation-slider">
				<div class="swiper js-installation-swiper" id="installationSwiper">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<img src="/assets/img/artfairs/img_artfairs-installation01.png" alt="展示風景 1" loading="lazy">
						</div>
						<div class="swiper-slide">
							<img src="/assets/img/artfairs/img_artfairs-installation01.png" alt="展示風景 2" loading="lazy">
						</div>
						<div class="swiper-slide">
							<img src="/assets/img/artfairs/img_artfairs-installation01.png" alt="展示風景 3" loading="lazy">
						</div>
						<div class="swiper-slide">
							<img src="/assets/img/artfairs/img_artfairs-installation01.png" alt="展示風景 4" loading="lazy">
						</div>
						<div class="swiper-slide">
							<img src="/assets/img/artfairs/img_artfairs-installation01.png" alt="展示風景 5" loading="lazy">
						</div>
						<div class="swiper-slide">
							<img src="/assets/img/artfairs/img_artfairs-installation01.png" alt="展示風景 6" loading="lazy">
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- ===== Section 14: FILM ===== -->
		<section class="exhibition-detail__film">
			<div class="exhibition-detail__film-header">
				<h3 class="exhibition-detail__section-heading">Film</h3>
				<a href="https://www.youtube.com/" class="exhibition-detail__film-link" target="_blank" rel="noopener noreferrer">
					See more on Youtube
					<svg class="exhibition-detail__film-link-icon" width="24" height="24" viewBox="0 0 24 24"><path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8-8-8z" fill="currentColor"></path></svg>
				</a>
			</div>
			<div class="exhibition-detail__film-content">
				<div class="exhibition-detail__film-player">
					<iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="着想と実行 Exhibition Film" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen loading="lazy"></iframe>
				</div>
				<p class="exhibition-detail__film-caption">「着想と実行 Inspiration and Execution」展示記録映像</p>
			</div>
			<div class="exhibition-detail__film-body">
				<h4 class="exhibition-detail__film-title">トークセッションのお知らせ</h4>
				<p class="exhibition-detail__film-text">あのイーハトーヴォのすきとおった風、夏でも底に冷たさをもつ青いそら、うつくしい森で飾られたモリーオ市、郊外のぎらぎらひかる草の波。 またそのなかでいっしょになったたくさんのひとたち、ファゼーロとロザーロ、羊飼のミーロや、顔の赤いこどもたち、地主のテーモ、山猫博士のボーガント・デストゥパーゴなど、いまこの暗い巨きな石の建物のなかで考えていると、みんなむかし風のなつかしい青い幻燈のように思われます。</p>
			</div>
		</section>

		<!-- ===== Section 15: PRODUCT ===== -->
		<section class="exhibition-detail__product">
			<h3 class="exhibition-detail__section-heading">Product</h3>
			<div class="exhibition-detail__product-content">
				<div class="exhibition-detail__product-img">
					<img src="/assets/img/artfairs/img_artfairs-product01.png" alt="Exhibition Product" loading="lazy">
				</div>
			</div>
			<p class="exhibition-detail__product-text">あのイーハトーヴォのすきとおった風、夏でも底に冷たさをもつ青いそら、うつくしい森で飾られたモリーオ市、郊外のぎらぎらひかる草の波。 またそのなかでいっしょになったたくさんのひとたち、ファゼーロとロザーロ、羊飼のミーロや、顔の赤いこどもたち、地主のテーモ、山猫博士のボーガント・デストゥパーゴなど、いまこの暗い巨きな石の建物のなかで考えていると、みんなむかし風のなつかしい青い幻燈のように思われます。</p>
		</section>

	</main>

	<script>
		window.addEventListener('load', function() {
			// ----- Installation Views Swiper -----
			var installEl = document.querySelector('.js-installation-swiper');
			if (installEl) {
				var installSlides = installEl.querySelectorAll('.swiper-slide');
				var installTotal = document.querySelector('.js-installation-total');
				var installCurrent = document.querySelector('.js-installation-current');
				var installNav = document.querySelector('.exhibition-detail__installation-nav');

				if (installSlides.length <= 1) {
					if (installNav) installNav.style.display = 'none';
				} else {
					if (installTotal) installTotal.textContent = installSlides.length;

					function getInstallGap() {
						return window.innerWidth >= 768
							? Math.min(Math.max(window.innerWidth * 0.08, 40), 104)
							: 16;
					}

					var installSwiper = new Swiper('#installationSwiper', {
						loop: true,
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
									installCurrent.textContent = this.realIndex + 1;
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
