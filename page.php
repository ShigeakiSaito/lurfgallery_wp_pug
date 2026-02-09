<?php
if (! defined('ABSPATH')) exit;
get_header();
?>

<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <main class="page">
      <div class="page__inner">
        <h1 class="page__title"><?php the_title(); ?></h1>
        <div class="page__editable">
          <?php the_content(); ?>
        </div>
      </div>
    </main>
  <?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();
?>