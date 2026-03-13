<?php
get_header();

$mv_images = get_field('mv_images');
$overview = get_field('overview');
$selected_artworks = get_field('selected_artworks');
$biography = get_field('biography');

$noimage = esc_url(get_template_directory_uri() . '/assets/img/common/noimage.png');

$exhibitions = get_field('exhibitions');
$artfairs = get_field('artfairs');
$news = get_field('news');

// ===== SELECTED ARTWORKS: 初期表示行数（変更はここだけ） =====
$artworks_initial_rows = 5; // PC版で表示する行数
?>

	<main class="single artist-detail">
		<h1>ARTISTS</h1>

		<!-- ===== Section 01: MV ===== -->
		<section class="artist-detail__mv">
			<?php if ($mv_images['pc']) : ?>
			<div class="artist-detail__mv-bg u-pc" style="background-image: url('<?php echo esc_url($mv_images['pc']['url'] ?? ''); ?>'); }"></div>
			<?php endif; ?>
			<?php if ($mv_images['sp']) : ?>
			<div class="artist-detail__mv-bg u-sp" style="background-image: url('<?php echo esc_url($mv_images['sp']['url'] ?? ''); ?>'); }"></div>
			<?php endif; ?>
			<div class="artist-detail__mv-overlay"></div>
			<div class="artist-detail__mv-inner">
				<h2 class="artist-detail__mv-name"><?php echo esc_html($overview['name1'] ?? ''); ?></h2>
				<div class="artist-detail__mv-img">
					<?php
					$mv_pc = $mv_images['pc'] ?? null;
					$mv_sp = $mv_images['sp'] ?? null;
					if ($mv_pc || $mv_sp) :
						$pc_url = $mv_pc ? esc_url($mv_pc['url']) : '';
						$sp_url = $mv_sp ? esc_url($mv_sp['url']) : '';
						$alt = $mv_pc ? esc_attr($mv_pc['alt']) : ($mv_sp ? esc_attr($mv_sp['alt']) : '');
					?>
					<picture>
						<?php if ($sp_url) : ?>
						<source srcset="<?php echo $sp_url; ?>" media="(max-width: 767px)">
						<?php endif; ?>
						<img src="<?php echo $pc_url ?: $sp_url; ?>" alt="<?php echo $alt; ?>" width="398" height="500" loading="eager">
					</picture>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<!-- ===== Section 02: ページ内アンカーナビゲーション ===== -->
		<?php
		$has_artworks = !empty($selected_artworks['set']);
		$has_biography = !empty($biography['text']) || !empty($biography['set']);
		// Exhibitions / Fairs / News / Product はカスタムフィールド未実装のため一旦非表示
		$has_exhibitions = !empty($exhibitions);
		$has_fairs = !empty($artfairs);
		$has_news = !empty($news);
		$has_product = false;
		?>
		<nav class="artist-detail__nav" id="js-artist-nav">
			<ul class="artist-detail__nav-list">
				<li><a href="#overview" class="artist-detail__nav-link is-active">OVERVIEW</a></li>
				<?php if ($has_artworks) : ?>
				<li><a href="#selected-artworks" class="artist-detail__nav-link">SELECTED ARTWORKS</a></li>
				<?php endif; ?>
				<?php if ($has_biography) : ?>
				<li><a href="#biography" class="artist-detail__nav-link">BIOGRAPHY</a></li>
				<?php endif; ?>
				<?php if ($has_exhibitions) : ?>
				<li><a href="#exhibitions" class="artist-detail__nav-link">EXHIBITIONS</a></li>
				<?php endif; ?>
				<?php if ($has_fairs) : ?>
				<li><a href="#fairs" class="artist-detail__nav-link">FAIRS</a></li>
				<?php endif; ?>
				<?php if ($has_news) : ?>
				<li><a href="#news" class="artist-detail__nav-link">NEWS</a></li>
				<?php endif; ?>
				<?php if ($has_product) : ?>
				<li><a href="#product" class="artist-detail__nav-link">PRODUCT</a></li>
				<?php endif; ?>
			</ul>
		</nav>

		<!-- ===== Section 03: OVERVIEW ===== -->
		<section class="artist-detail__section artist-detail__overview" id="overview">
			<h3 class="artist-detail__section-heading">OVERVIEW</h3>
			<div class="artist-detail__overview-content">
				<!-- 作家画像・左カラム -->
				<div class="artist-detail__overview-left">
					<div class="artist-detail__overview-img">
						<?php
						$image1 = $overview['image1'] ?? null;
						$image1_display = $image1['display'] ?? '';
						$image1_id = $image1['image'] ?? null;
						$image1_url = $image1_id ? wp_get_attachment_image_url($image1_id, 'medium_large') : '';
						$image1_alt = $image1_id ? get_post_meta($image1_id, '_wp_attachment_image_alt', true) : '';
						if ($image1_display === 'detail' && $image1_url) : ?>
						<img src="<?php echo esc_url($image1_url); ?>" alt="<?php echo esc_attr($image1_alt); ?>" width="386" height="386" loading="lazy">
						<?php else : ?>
						<img src="<?php echo $noimage; ?>" alt="" width="386" height="386" loading="lazy">
						<?php endif; ?>
					</div>
					<div class="artist-detail__overview-meta">
						<?php $contact1_url = $overview['contact1_url'] ?? ''; ?>
						<?php if ($contact1_url) : ?>
						<a href="<?php echo esc_url($contact1_url); ?>" class="artist-detail__overview-contact">CONTACT</a>
						<?php endif; ?>
						<?php for ($i = 1; $i <= 3; $i++) :
							$link = $overview["link{$i}"] ?? '';
							if ($link) : ?>
						<a href="<?php echo esc_url($link); ?>" class="artist-detail__overview-link" target="_blank" rel="noopener noreferrer"><?php echo esc_html($link); ?></a>
						<?php endif; endfor; ?>
					</div>
				</div>
				<!-- テキスト・プロフィール -->
				<div class="artist-detail__overview-body">
					<div class="artist-detail__overview-header">
						<div class="artist-detail__overview-name">
							<?php if (!empty($overview['name1'])) : ?>
							<span class="artist-detail__overview-name-en"><?php echo esc_html($overview['name1']); ?></span>
							<?php endif; ?>
							<?php if (!empty($overview['name2'])) : ?>
							<span class="artist-detail__overview-name-jp"><?php echo esc_html($overview['name2']); ?></span>
							<?php endif; ?>
						</div>
						<?php $contact2_url = $overview['contact2_url'] ?? ''; ?>
						<?php if ($contact2_url) : ?>
						<a href="<?php echo esc_url($contact2_url); ?>" class="artist-detail__overview-contact">CONTACT</a>
						<?php endif; ?>
					</div>
					<?php $profile = $overview['profile'] ?? ''; ?>
					<?php if ($profile) : ?>
					<div class="artist-detail__overview-profile">
						<div class="artist-detail__overview-profile-text" id="js-artist-profile">
							<?php echo nl2br(esc_html($profile)); ?>
						</div>
						<div class="artist-detail__overview-viewmore">
							<button type="button" class="artist-detail__overview-viewmore-btn" id="js-artist-profile-toggle">
								<span class="artist-detail__overview-viewmore-label">View more</span>
								<span class="artist-detail__overview-viewmore-icon"></span>
							</button>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</section>

		<!-- ===== Section 04: SELECTED ARTWORKS ===== -->
		<?php if ($has_artworks) : ?>
		<section class="artist-detail__section artist-detail__artworks" id="selected-artworks">
			<h3 class="artist-detail__section-heading">SELECTED ARTWORKS</h3>
			<div class="artist-detail__artworks-grid" id="js-artworks-grid">
				<?php
				$sets = $selected_artworks['set'];
				foreach ($sets as $set) :
					$columns = $set['columns'] ?? 'col3';
					$works = $set['works'] ?? [];
					if (empty($works)) continue;

					// カラム数から初期表示件数を算出
					$col_count = ($columns === 'col1') ? 1 : (($columns === 'col2') ? 2 : 3);
					$initial_visible = $col_count * $artworks_initial_rows;
				?>
				<div class="artist-detail__artworks-row artist-detail__artworks-row--<?php echo esc_attr($columns); ?>"
					data-col-count="<?php echo esc_attr($col_count); ?>"
					data-initial-rows="<?php echo esc_attr($artworks_initial_rows); ?>">
					<?php foreach ($works as $index => $artwork_id) :
						$artwork_id = is_object($artwork_id) ? $artwork_id->ID : $artwork_id;
						$artwork_images = get_field('images', $artwork_id);
						$artwork_thumb = '';
						if ($artwork_images && !empty($artwork_images[0]['image'])) {
							$artwork_thumb = $artwork_images[0]['image']['url'];
						}
						$artwork_artist = get_field('artist_name', $artwork_id);
						$artwork_title = get_field('title', $artwork_id);
						$artwork_year = get_field('year', $artwork_id);
						$artwork_material = get_field('material', $artwork_id);
						$artwork_size = get_field('size', $artwork_id);

						$artist_text = (!empty($artwork_artist['is_display']) && !empty($artwork_artist['value'])) ? $artwork_artist['value'] : '';
						$title_text = (!empty($artwork_title['is_display']) && !empty($artwork_title['value'])) ? $artwork_title['value'] : '';

						$spec_parts = [];
						foreach ([$artwork_year, $artwork_material, $artwork_size] as $spec) {
							if (!empty($spec['is_display']) && !empty($spec['value'])) {
								$spec_parts[] = $spec['value'];
							}
						}
						$spec_text = implode(', ', $spec_parts);

						// 初期表示件数を超えたら is-hidden を付与
						$hidden_class = ($index >= $initial_visible) ? ' is-hidden' : '';
					?>
					<a href="<?php echo esc_url(get_permalink($artwork_id)); ?>" class="artist-detail__artwork<?php echo $hidden_class; ?>">
						<div class="artist-detail__artwork-img">
							<?php if ($artwork_thumb) : ?>
							<img src="<?php echo esc_url($artwork_thumb); ?>" alt="<?php echo esc_attr($title_text); ?>" loading="lazy">
							<?php else : ?>
							<img src="<?php echo $noimage; ?>" alt="" loading="lazy">
							<?php endif; ?>
						</div>
						<div class="artist-detail__artwork-info">
							<?php if ($artist_text) : ?>
							<p class="artist-detail__artwork-artist"><?php echo esc_html($artist_text); ?></p>
							<?php endif; ?>
							<?php if ($title_text) : ?>
							<p class="artist-detail__artwork-title"><?php echo esc_html($title_text); ?></p>
							<?php endif; ?>
							<?php if ($spec_text) : ?>
							<p class="artist-detail__artwork-spec"><?php echo esc_html($spec_text); ?></p>
							<?php endif; ?>
						</div>
					</a>
					<?php endforeach; ?>
				</div>
				<?php // View more を row の外に配置し、data-target-row で紐づけ ?>
				<?php if (count($works) > $initial_visible) : ?>
				<div class="artist-detail__artworks-more js-artworks-more" data-target-row="<?php echo esc_attr($columns); ?>">
					<button type="button" class="u-button-more">View more</button>
				</div>
				<?php endif; ?>
				<?php endforeach; ?>
			</div>

			<!-- CTA -->
			<div class="artist-detail__artworks-cta">
				<p class="artist-detail__artworks-cta-text">販売作品リストをご希望の方は、お問い合わせよりご連絡ください</p>
				<a href="/art_contact/" class="artist-detail__artworks-contact">CONTACT</a>
			</div>
		</section>
		<?php endif; ?>

		<!-- ===== Section 05: BIOGRAPHY ===== -->
		<?php if ($has_biography) : ?>
		<section class="artist-detail__section artist-detail__biography" id="biography">
			<h3 class="artist-detail__section-heading artist-detail__section-heading--large">BIOGRAPHY</h3>
			<?php $bio_text = $biography['text'] ?? ''; ?>
			<?php if ($bio_text) : ?>
			<div class="artist-detail__bio-text">
				<?php echo wp_kses_post($bio_text); ?>
			</div>
			<?php endif; ?>
			<?php $bio_sets = $biography['set'] ?? []; ?>
			<?php if ($bio_sets) : ?>
			<div class="artist-detail__bio-body">
				<?php foreach ($bio_sets as $bio_group) :
					$group_title = $bio_group['title'] ?? '';
					$group_items = $bio_group['set'] ?? [];
					if (empty($group_title) && empty($group_items)) continue;
				?>
				<div class="artist-detail__bio-group">
					<?php if ($group_title) : ?>
					<h4 class="artist-detail__bio-group-heading"><?php echo esc_html($group_title); ?></h4>
					<?php endif; ?>
					<?php if ($group_items) : ?>
					<div class="artist-detail__bio-list is-collapsed">
						<?php foreach ($group_items as $item) : ?>
						<div class="artist-detail__bio-item">
							<span class="artist-detail__bio-year"><?php echo esc_html($item['year'] ?? ''); ?></span>
							<span class="artist-detail__bio-content"><?php echo nl2br(esc_html($item['text'] ?? '')); ?></span>
						</div>
						<?php endforeach; ?>
					</div>
					<div class="artist-detail__bio-more">
						<button type="button" class="artist-detail__overview-viewmore-btn js-bio-toggle">
							<span class="artist-detail__overview-viewmore-label">View more</span>
							<span class="artist-detail__overview-viewmore-icon"></span>
						</button>
					</div>
					<?php endif; ?>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</section>
		<?php endif; ?>

		<!-- ===== Section 06: EXHIBITIONS ===== -->
		<!-- TODO: カスタムフィールド実装後に動的化 -->
		<?php if ($has_exhibitions) : ?>
		<section class="artist-detail__section artist-detail__slider-section" id="exhibitions">
			<div class="artist-detail__slider-header">
				<h3 class="artist-detail__section-heading artist-detail__section-heading--large">EXHIBITIONS</h3>
			</div>
			<div class="artist-detail__slider-nav">
				<button class="artist-detail__slider-prev js-exh-prev" aria-label="前のスライド"></button>
				<span class="artist-detail__slider-counter">
					<span class="js-exh-current">1</span>
					<span>/</span>
					<span class="js-exh-total">4</span>
				</span>
				<button class="artist-detail__slider-next js-exh-next" aria-label="次のスライド"></button>
			</div>
			<div class="artist-detail__slider-body">
				<div class="swiper js-artist-exh-swiper" id="artistExhSwiper">
					<div class="swiper-wrapper">
						<?php foreach ($exhibitions as $exh) :
						  // $exh はACFの投稿オブジェクト
							$exh_id = is_object($exh) ? $exh->ID : $exh;
							$exh_title = get_field('main_visual', $exh_id)['text1'] ?? get_the_title($exh_id); // タイトル
							$exh_subtitle = get_field('main_visual', $exh_id)['text2'] ?? ''; // サブタイトル
							$exh_images = get_field('main_visual', $exh_id); // 画像配列
							$exh_image_url = '';
							$exh_image_alt = '';
							echo "<!-- " . print_r($exh_images, true) . " -->";
							if ($exh_images && !empty($exh_images['image'])) {
								$exh_image_url = esc_url($exh_images['image']['url']);
								$exh_image_alt = esc_attr($exh_images['image']['alt'] ?? '');
							}
							$exh_artists = get_field('artists', $exh_id); // アーティスト名配列
							$exh_artist_text = '';
							if ($exh_artists && is_array($exh_artists)) {
								$artist_names = [];
								foreach ($exh_artists as $artist) {
									if (is_object($artist)) {
										$artist_names[] = get_field('overview', $artist->ID)['name2'] ?? get_the_title($artist->ID);
									}
								}
								$exh_artist_text = implode('✕', $artist_names);
							}
						?>
						<div class="swiper-slide">
							<a href="<?php echo get_permalink($exh_id); ?>" class="artist-detail__exh-card">
								<div class="artist-detail__exh-card-img">
									<img src="<?php echo $exh_image_url; ?>" alt="<?php echo $exh_image_alt; ?>" loading="lazy">
								</div>
								<p class="artist-detail__exh-card-artist"><?php echo esc_html($exh_artist_text); ?></p>
								<p class="artist-detail__exh-card-title"><?php echo esc_html($exh_title); ?></p>
								<?php if ($exh_subtitle) : ?>
								<p class="artist-detail__exh-card-subtitle"><?php echo esc_html($exh_subtitle); ?></p>
								<?php endif; ?>
								<p class="artist-detail__exh-card-period">会期</p>
							</a>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
		<?php endif; ?>

		<!-- ===== Section 07: ART FAIR ===== -->
		<!-- TODO: カスタムフィールド実装後に動的化 -->
		<?php if ($has_fairs) : ?>
		<section class="artist-detail__section artist-detail__slider-section" id="fairs">
			<div class="artist-detail__slider-header">
				<h3 class="artist-detail__section-heading artist-detail__section-heading--large">ARTFAIR</h3>
			</div>
			<div class="artist-detail__slider-nav">
				<button class="artist-detail__slider-prev js-fair-prev" aria-label="前のスライド"></button>
				<span class="artist-detail__slider-counter">
					<span class="js-fair-current">1</span>
					<span>/</span>
					<span class="js-fair-total">4</span>
				</span>
				<button class="artist-detail__slider-next js-fair-next" aria-label="次のスライド"></button>
			</div>
			<div class="artist-detail__slider-body">
				<div class="swiper js-artist-fair-swiper" id="artistFairSwiper">
					<div class="swiper-wrapper">
					</div>
				</div>
			</div>
		</section>
		<?php endif; ?>

		<!-- ===== Section 08: NEWS ===== -->
		<!-- TODO: カスタムフィールド実装後に動的化 -->
		<?php if ($has_news) : ?>
		<section class="artist-detail__section artist-detail__slider-section" id="news">
			<div class="artist-detail__slider-header">
				<h3 class="artist-detail__section-heading artist-detail__section-heading--large">NEWS</h3>
			</div>
			<div class="artist-detail__slider-nav">
				<button class="artist-detail__slider-prev js-news-prev" aria-label="前のスライド"></button>
				<span class="artist-detail__slider-counter">
					<span class="js-news-current">1</span>
					<span>/</span>
					<span class="js-news-total">4</span>
				</span>
				<button class="artist-detail__slider-next js-news-next" aria-label="次のスライド"></button>
			</div>
			<div class="artist-detail__slider-body">
				<div class="swiper js-artist-news-swiper" id="artistNewsSwiper">
					<div class="swiper-wrapper">
						<?php foreach ($news as $news_item) :
							// $news_item はACFの投稿オブジェクト
							$news_id = is_object($news_item) ? $news_item->ID : $news_item;
							$news_title = get_the_title($news_id);
							// サムネイル取得
							$news_image = get_the_post_thumbnail_url($news_id, 'full') ? get_post_thumbnail_id($news_id) : null;
							echo "<!-- news image ID: " . print_r($news_image, true) . " -->";
							if ($news_image):
								$news_image_url = $news_image ? esc_url(wp_get_attachment_image_url($news_image, 'medium_large')) : '';
								$news_image_alt = $news_image ? esc_attr(get_post_meta($news_image, '_wp_attachment_image_alt', true)) : '';
							else:
								$news_image_url = $noimage;
								$news_image_alt = '';
							endif;
						?>
						<div class="swiper-slide">
							<a href="<?php echo get_permalink($news_id); ?>" class="artist-detail__news-card">
								<div class="artist-detail__news-card-img">
									<img src="<?php echo $news_image_url; ?>" alt="<?php echo $news_image_alt; ?>" loading="lazy">
								</div>
								<p class="artist-detail__news-card-title"><?php echo esc_html($news_title); ?></p>
								<p class="artist-detail__news-card-date"><?php echo get_the_date('Y.m.d', $news_id); ?></p>
							</a>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</section>
		<?php endif; ?>

	</main>

	<script>
	document.addEventListener('DOMContentLoaded', () => {
		// ----- プロフィール View more / View less -----
		const profileToggle = document.getElementById('js-artist-profile-toggle');
		const profileText = document.getElementById('js-artist-profile');

		if (profileToggle && profileText) {
			profileToggle.addEventListener('click', () => {
				const isExpanded = profileText.classList.toggle('is-expanded');
				profileToggle.classList.toggle('is-expanded', isExpanded);
				const label = profileToggle.querySelector('.artist-detail__overview-viewmore-label');
				if (label) {
					label.textContent = isExpanded ? 'View less' : 'View more';
				}
			});
		}

		// ----- SELECTED ARTWORKS View more（row ごとに独立、ボタンは row の外） -----
		document.querySelectorAll('.js-artworks-more').forEach(moreWrap => {
			// 直前の兄弟要素が対応する row
			const row = moreWrap.previousElementSibling;
			if (!row || !row.classList.contains('artist-detail__artworks-row')) return;

			const moreBtn = moreWrap.querySelector('.u-button-more');
			const colCount = parseInt(row.dataset.colCount, 10) || 3;

			/**
			 * hidden アイテムが 0 件になったらボタンを非表示にする
			 */
			const updateMoreVisibility = () => {
				const hiddenItems = row.querySelectorAll('.artist-detail__artwork.is-hidden');
				if (hiddenItems.length === 0) {
					moreWrap.style.display = 'none';
				}
			};

			// 初期チェック
			updateMoreVisibility();

			if (moreBtn) {
				moreBtn.addEventListener('click', () => {
					const hiddenItems = row.querySelectorAll('.artist-detail__artwork.is-hidden');
					if (hiddenItems.length === 0) return;

					// 1行分（= カラム数）だけ表示する
					const showCount = Math.min(colCount, hiddenItems.length);

					for (let i = 0; i < showCount; i++) {
						const item = hiddenItems[i];
						item.classList.remove('is-hidden');
						item.classList.add('is-appearing');

						item.addEventListener('animationend', () => {
							item.classList.remove('is-appearing');
						}, { once: true });
					}

					updateMoreVisibility();
				});
			}
		});

		// ----- BIOGRAPHY View more（グループ単位） -----
		document.querySelectorAll('.artist-detail__bio-group').forEach(group => {
			const list = group.querySelector('.artist-detail__bio-list');
			const toggle = group.querySelector('.js-bio-toggle');
			if (!list || !toggle) return;

			const items = list.querySelectorAll('.artist-detail__bio-item');
			if (items.length < 3) {
				toggle.parentElement.style.display = 'none';
				list.classList.remove('is-collapsed');
				return;
			}

			toggle.addEventListener('click', () => {
				const isCollapsed = list.classList.toggle('is-collapsed');
				toggle.classList.toggle('is-expanded', !isCollapsed);
				const label = toggle.querySelector('.artist-detail__overview-viewmore-label');
				if (label) {
					label.textContent = isCollapsed ? 'View more' : 'View less';
				}
			});
		});

		// ----- アンカーナビゲーション: アクティブ状態の追従 -----
		const nav = document.getElementById('js-artist-nav');
		const navLinks = nav ? nav.querySelectorAll('.artist-detail__nav-link') : [];
		const sections = [];

		navLinks.forEach(link => {
			const href = link.getAttribute('href');
			if (href && href.startsWith('#')) {
				const section = document.getElementById(href.slice(1));
				if (section) {
					sections.push({ el: section, link: link });
				}
			}
		});

		if (sections.length > 0) {
			const observer = new IntersectionObserver((entries) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						navLinks.forEach(l => l.classList.remove('is-active'));
						const active = sections.find(s => s.el === entry.target);
						if (active) {
							active.link.classList.add('is-active');
						}
					}
				});
			}, {
				rootMargin: '-80px 0px -60% 0px',
				threshold: 0
			});

			sections.forEach(s => observer.observe(s.el));
		}

		// ----- アンカーナビゲーション: スムーススクロール -----
		navLinks.forEach(link => {
			link.addEventListener('click', (e) => {
				const href = link.getAttribute('href');
				if (href && href.startsWith('#')) {
					const target = document.getElementById(href.slice(1));
					if (target) {
						e.preventDefault();
						const navHeight = nav ? nav.offsetHeight : 0;
						const targetTop = target.getBoundingClientRect().top + window.scrollY - navHeight;
						window.scrollTo({ top: targetTop, behavior: 'smooth' });
					}
				}
			});
		});

	});

	// ----- Swiper 初期化（load イベントで実行） -----
	window.addEventListener('load', function() {
		function initArtistSlider(swiperSelector, prevSelector, nextSelector, currentSelector, totalSelector) {
			var swiperEl = document.querySelector(swiperSelector);
			if (!swiperEl) return;
			var slides = swiperEl.querySelectorAll('.swiper-slide');
			var totalEl = document.querySelector(totalSelector);
			var currentEl = document.querySelector(currentSelector);
			var navContainer = document.querySelector(prevSelector);
			if (navContainer) navContainer = navContainer.parentElement;

			if (slides.length <= 2) {
				if (navContainer) navContainer.style.display = 'none';
			}
			if (totalEl) totalEl.textContent = slides.length;

			new Swiper(swiperSelector, {
				loop: slides.length > 2,
				speed: 600,
				slidesPerView: 1,
				spaceBetween: 16,
				breakpoints: {
					768: {
						slidesPerView: 2,
						spaceBetween: 104
					}
				},
				navigation: {
					prevEl: prevSelector,
					nextEl: nextSelector
				},
				on: {
					slideChange: function() {
						if (currentEl) currentEl.textContent = this.realIndex + 1;
					}
				}
			});
		}

		// EXHIBITIONS
		initArtistSlider('#artistExhSwiper', '.js-exh-prev', '.js-exh-next', '.js-exh-current', '.js-exh-total');
		// ART FAIR
		initArtistSlider('#artistFairSwiper', '.js-fair-prev', '.js-fair-next', '.js-fair-current', '.js-fair-total');
		// NEWS
		initArtistSlider('#artistNewsSwiper', '.js-news-prev', '.js-news-next', '.js-news-current', '.js-news-total');
	});
	</script>

<?php get_footer(); ?>