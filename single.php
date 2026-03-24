<?php
if (! defined('ABSPATH')) exit;
get_header();
?>

<main class="single"> 
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            
            <h1><?php the_title(); ?></h1>

            <?php
            $mv_type = get_field('mv_type');
            $pc_id   = get_field('mv_img_pc');
            $sp_id   = get_field('mv_img_sp');
            $v_pc    = get_field('mv_video_pc');
            $v_sp    = get_field('mv_video_sp');

            $pc_img = $pc_id ? wp_get_attachment_image_src($pc_id, 'full') : false;
            $pc_src = $pc_img ? $pc_img[0] : '';
            $sp_img = $sp_id ? wp_get_attachment_image_src($sp_id, 'full') : false;
            $sp_src = $sp_img ? $sp_img[0] : $pc_src;
            if (!$pc_src) { $pc_src = $sp_src; }
            ?>

            <div class="single__mv">
            <?php if ($mv_type === 'video' && ($v_pc || $v_sp)) : ?>

                <?php if ($v_pc) : ?>
                <video autoplay muted loop playsinline webkit-playsinline preload="metadata" class="only-pc">
                    <source src="<?php echo esc_url($v_pc); ?>">
                </video>
                <?php endif; ?>

                <?php if ($v_sp) : ?>
                <video autoplay muted loop playsinline webkit-playsinline preload="metadata" class="only-sp">
                    <source src="<?php echo esc_url($v_sp); ?>">
                </video>
                <?php endif; ?>

                <?php else : ?>

                <?php if ($pc_src || $sp_src) : ?>
                <picture>
                    <source media="(min-width: 768px)" srcset="<?php echo esc_url($pc_src); ?>">
                    <img src="<?php echo esc_url($sp_src); ?>" alt="<?php the_title(); ?>">
                </picture>
                <?php endif; ?>

            <?php endif; ?>
            </div>

            <div class="single__inner">
                <section class="single__editable">
                    <?php the_content(); ?>
                </section>
            </div>

        <?php endwhile; ?>
    <?php endif; ?>
</main> <?php
get_footer();