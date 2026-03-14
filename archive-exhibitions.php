<?php get_header(); ?>

	<main class="exhibitions-index">
		<h1>EXHIBITIONS</h1>

		<!-- タブナビゲーション -->
		<?php
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
					<li class="exhibitions-index__tab is-active" data-status="all">ALL</li>
					<?php foreach ($status_terms as $term) : ?>
					<li class="exhibitions-index__tab" data-status="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></li>
					<?php endforeach; ?>
				</ul>
				<div class="exhibitions-index__year-select" id="js-year-select">
					<span class="exhibitions-index__year-label">SELECT YEAR</span>
					<svg class="exhibitions-index__year-arrow" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1 1L5 5L9 1" stroke="#1A1A1A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
					</svg>
					<ul class="exhibitions-index__year-dropdown" id="js-year-dropdown">
						<li class="exhibitions-index__year-option is-active" data-year="all">ALL</li>
						<?php foreach ($year_terms as $term) : ?>
						<li class="exhibitions-index__year-option" data-year="<?php echo esc_attr($term->slug); ?>"><?php echo esc_html($term->name); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</nav>

		<!-- フィーチャード展示 -->
		<section class="exhibitions-index__featured">
			<picture class="exhibitions-index__featured-img">
				<img src="/assets/img/exhibitions/img_exhibition01.png" alt="着想と実行 展示風景" width="772" height="514" loading="eager">
			</picture>
			<div class="exhibitions-index__featured-text">
				<p class="exhibitions-index__artist">前田信明 × 谷﨑一心</p>
				<div class="exhibitions-index__subtitle">
					<p class="exhibitions-index__subtitle-main">呼吸する絵画</p>
					<p class="exhibitions-index__subtitle-sub">Breathing Paintings Cross / Vortex―交差と渦</p>
				</div>
				<div class="exhibitions-index__period">
					2025.06.21 <span class="exhibitions-index__period-week">(日)</span> - 07.27 <span class="exhibitions-index__period-week">(月)</span>
				</div>
				<p class="exhibitions-index__description">
					ここにサンプルテキストが入ります。ここにサンプルテキストが入ります。ここにサンプルテキストが入ります。ここにサンプルテキストが入ります。ここにサンプルテキストが入ります。ここにサンプルテキストが入ります。ここにサンプルテキストが入ります。
				</p>
				<a href="/exhibitions/sample/" class="u-link-more">Learn more</a>
			</div>
		</section>

		<!-- 展示リスト -->
		<div class="exhibitions-index__list" id="js-exhibitions-list">
			<article class="exhibitions-index__item">
				<p class="exhibitions-index__item-artist">グループ展「1998_oid」</p>
				<div class="exhibitions-index__item-subtitle">
					1998_oid
				</div>
				<div class="exhibitions-index__item-bottom">
					<div class="exhibitions-index__item-period">
						<span class="exhibitions-index__item-period-label">前期</span> 2025.06.21 <span class="exhibitions-index__item-period-week">(日)</span> — 07.27 <span class="exhibitions-index__item-period-week">(月)</span><br>
					</div>
					<a href="/exhibitions/sample/" class="u-link-more">Learn more</a>
				</div>
			</article>

			<article class="exhibitions-index__item">
				<p class="exhibitions-index__item-artist">WAVE 2025</p>
				<div class="exhibitions-index__item-subtitle">
					WAVE 2025
				</div>
				<div class="exhibitions-index__item-bottom">
					<div class="exhibitions-index__item-period">
						<span class="exhibitions-index__item-period-label">前期</span> 2025.06.21 <span class="exhibitions-index__item-period-week">(日)</span> — 07.27 <span class="exhibitions-index__item-period-week">(月)</span><br>
						<span class="exhibitions-index__item-period-label">後期</span> 2025.06.21 <span class="exhibitions-index__item-period-week">(日)</span> — 07.27 <span class="exhibitions-index__item-period-week">(月)</span>
					</div>
					<a href="/exhibitions/sample/" class="u-link-more">Learn more</a>
				</div>
			</article>

			<article class="exhibitions-index__item">
				<p class="exhibitions-index__item-artist">谷﨑一心</p>
				<div class="exhibitions-index__item-subtitle">
					谷﨑一心 個展<br>
					<span class="exhibitions-index__item-subtitle-sub">イメージの創造 Creation of Image</span>
				</div>
				<div class="exhibitions-index__item-bottom">
					<div class="exhibitions-index__item-period">
						2025.06.21 <span class="exhibitions-index__item-period-week">(日)</span> — 07.27 <span class="exhibitions-index__item-period-week">(月)</span>
					</div>
					<a href="/exhibitions/sample/" class="u-link-more">Learn more</a>
				</div>
			</article>
		</div>

		<!-- View more -->
		<div class="exhibitions-index__more" id="js-exhibitions-more">
			<button type="button" class="u-button-more u-button-more--border">View more</button>
		</div>
	</main>

<?php get_footer(); ?>
