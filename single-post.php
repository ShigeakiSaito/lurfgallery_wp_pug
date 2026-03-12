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
				<?php if (has_post_thumbnail()) : ?>
				<figure class="news-detail__mv">
					<img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" alt="<?php the_title_attribute(); ?>">
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
