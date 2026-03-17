<?php
if (! defined('ABSPATH')) exit;
get_header();
?>

<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>

	<main class="cafe page">
    <h1 class="cafe__title page__title">CAFE</h1>
    <div class="cafe__mv">
      <div class="swiper" id="cafeMvSwiper">
        <div class="swiper-wrapper">
          <?php if ( have_rows('cafe-mv') ) : ?>
            <?php while ( have_rows('cafe-mv') ) : the_row(); ?>
            <div class="swiper-slide">
              <figure>
                <img src="<?php the_sub_field('cafe-mv-img'); ?>" alt="">
              </figure>
            </div>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
      </div>

      <div class="swiper-controller-wrapper">
        <div class="swiper-button-prev mv-button-prev"></div>
        <div class="mv-progressbars"></div>
        <div class="swiper-button-next mv-button-next"></div>
      </div>
    </div>
    <section class="cafe__contens page__editable">
      <div class="page__inner">
        <?php the_content(); ?>
      </div>
    </section>
  </main>

  <?php endwhile; ?>
<?php endif; ?>
<?php
get_footer();
?>