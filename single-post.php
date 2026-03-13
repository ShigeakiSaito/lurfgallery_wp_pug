<?php get_header(); ?>

	<main class="single news-detail">
		<h1>NEWS DETAIL</h1>

		<div class="news-detail__container">
			<!-- イントロ部分 -->
			<div class="news-detail__intro">
				<div class="news-detail__text">
					<div class="news-detail__meta">
						<time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date('Y.m.d'); ?></time>
						<?php $categories = get_the_category(); ?>
						<?php if (!empty($categories)) : ?>
						<span>/</span>
						<span><?php echo esc_html($categories[0]->name); ?></span>
						<?php endif; ?>
					</div>
					<h2 class="news-detail__title"><?php the_title(); ?></h2>
				</div>
				<?php
				$main_visual = get_field('main_visual');
				$has_mv = !empty($main_visual['pc']) || !empty($main_visual['sp']);
				?>
				<?php if ($has_mv || has_post_thumbnail()) : ?>
				<figure class="news-detail__mv">
					<?php if (!empty($main_visual['pc']) && !empty($main_visual['sp'])) : ?>
					<picture>
						<source media="(max-width: 767px)" srcset="<?php echo esc_url($main_visual['sp']['url']); ?>">
						<img src="<?php echo esc_url($main_visual['pc']['url']); ?>" alt="<?php echo esc_attr($main_visual['pc']['alt']); ?>">
					</picture>
					<?php elseif (!empty($main_visual['pc'])) : ?>
					<img src="<?php echo esc_url($main_visual['pc']['url']); ?>" alt="<?php echo esc_attr($main_visual['pc']['alt']); ?>">
					<?php elseif (!empty($main_visual['sp'])) : ?>
					<img src="<?php echo esc_url($main_visual['sp']['url']); ?>" alt="<?php echo esc_attr($main_visual['sp']['alt']); ?>">
					<?php elseif (has_post_thumbnail()) : ?>
					<img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>">
					<?php endif; ?>
					<?php $caption = get_field('caption'); ?>
					<?php if ($caption) : ?>
					<figcaption><?php echo esc_html($caption); ?></figcaption>
					<?php endif; ?>
				</figure>
				<?php endif; ?>
			</div>

			<!-- 記事エリア -->
			<div class="news-detail__body">
				<div class="single__editable">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</main>

<?php get_footer(); ?>
