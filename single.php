<?php
if (! defined('ABSPATH')) exit;
get_header();
?>

<?php if ( have_posts() ) : ?>
  <?php while ( have_posts() ) : the_post(); ?>
    <main class="single">
      <h1><?php the_title(); ?></h1>

      <?php 
      $pc_id = get_field('mv_pc');
      $sp_id = get_field('mv_sp');

      if ($pc_id || $sp_id) : 
          
          $pc_src = $pc_id ? wp_get_attachment_image_src($pc_id, 'full')[0] : '';
          $sp_src = $sp_id ? wp_get_attachment_image_src($sp_id, 'full')[0] : $pc_src;
          
          if (!$pc_src) { $pc_src = $sp_src; }
      ?>
        <div class="single__mv">
            <picture>
                <source media="(min-width: 768px)" srcset="<?php echo esc_url($pc_src); ?>">
                <img src="<?php echo esc_url($sp_src); ?>" alt="<?php the_title(); ?>" style="width:100%; height:auto;">
            </picture>
        </div>
      <?php endif; ?>

      <div class="single__inner">
        <section class="single__editable">
          <?php the_content(); ?>
        </section>
      </div>
    </main>
  <?php endwhile; ?>
<?php endif; ?>

<?php
get_footer();