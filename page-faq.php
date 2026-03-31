<?php
if (! defined('ABSPATH')) exit;
get_header();
?>

<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>

  <main class="faq page">
    <h1 class="faq__title page__title">FAQ</h1>
    <div class="page__inner">
      <h2 class="faq__subtitle page__subtitle">カフェのご利用について</h2>
      <ul class="faq__list">
        <?php if ( have_rows('faq') ) : ?>
          <?php while ( have_rows('faq') ) : the_row(); ?>
            <li class="faq__item">
              <div class="faq__question js-ac-toggle is-opened">
                <p class="faq__text">
                  <span>Q．</span>
                  <span><?php the_sub_field('question'); ?></span>
                </p>
              </div>
              <div class="faq__answer js-ac-content">
                <p class="faq__text">
                  <span>A．</span>
                  <span><?php the_sub_field('answer'); ?></span>
                </p>
              </div>
            </li>
          <?php endwhile; ?>
        <?php endif; ?>
      </ul>
    </div>
  </main>

  <?php endwhile; ?>
<?php endif; ?>
<?php
get_footer();
?>