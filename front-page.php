<?php
if (! defined('ABSPATH')) exit;
get_header();
?>

<main class="top">
    <h1>LURF GALLERY</h1>
    <!-- phase1用MV -->    
    <div class="top__mv">
        <?php $upload_dir = wp_get_upload_dir(); ?>
        <a href="<?php echo esc_url( home_url( '/exhibitions/group-exhibition-imagination/' ) ); ?>">
            <video autoplay muted loop playsinline preload="metadata" class="only-pc">
                <source src="<?php echo esc_url($upload_dir['baseurl'] . '/2026/02/img_mv_pc.mp4'); ?>">
            </video>
            <video autoplay muted loop playsinline preload="metadata" class="only-sp">
                <source src="<?php echo esc_url($upload_dir['baseurl'] . '/2026/02/img_mv_sp.mp4'); ?>">
            </video>
        </a>
    </div>
    <!-- phase2用MV -->
    <!-- <div class="top__mv">
        <div class="swiper" id="topMvSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="">
                    <picture>
                        <source srcset="<?php echo esc_url(get_template_directory_uri() . '/assets/img/top/img_exhibition01.png'); ?>" media="(min-width: 768px)" width="3024" height="1504">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/top/img_exhibition01.png'); ?>" alt="" width="780" height="1016">
                    </picture>  
                    </a>
                </div>
                <div class="swiper-slide">
                    <a href="">
                    <picture>
                        <source srcset="<?php echo esc_url(get_template_directory_uri() . '/assets/img/top/img_exhibition02.png'); ?>" media="(min-width: 768px)" width="3024" height="1504">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/top/img_exhibition02.png'); ?>" alt="" width="780" height="1016">
                    </picture>  
                    </a>
                </div>
            </div>
        </div>
        <div class="swiper-controller-wrapper">
            <div class="swiper-button-prev mv-button-prev"></div>
            <div class="mv-progressbars"></div>
            <div class="swiper-button-next mv-button-next"></div>
        </div>
    </div> -->
    <!-- exhibitions: current -->
    <?php
    $current_exh_query = new WP_Query(array(
        'post_type' => 'exhibitions',
        'posts_per_page' => 4,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'exhibition_status',
                'field' => 'slug',
                'terms' => 'current',
            ),
        ),
    ));
    ?>
    <?php if ($current_exh_query->have_posts()) : ?>
    <section class="top__section top__section--exhibitions">
        <div class="top__inner">
            <h2 class="top__title">CURRENT EXHIBITIONS</h2>
            <ul class="top__events">
                <?php while ($current_exh_query->have_posts()) : $current_exh_query->the_post();
                    $exh_id = get_the_ID();
                    $exh_thumbnail = get_field('thumbnail', $exh_id);
                    $exh_mv = get_field('main_visual', $exh_id);
                    if (!$exh_thumbnail && !empty($exh_mv['image'])) {
                        $exh_thumbnail = $exh_mv['image'];
                    }
                    $exh_subtitle = get_field('subtitle', $exh_id);
                    $exh_period = get_field('period', $exh_id);
                    $exh_artists_obj = get_field('artists', $exh_id);
                    $exh_artist_names = [];
                    if ($exh_artists_obj) {
                        foreach ($exh_artists_obj as $exh_artist) {
                            $ar_id = is_object($exh_artist) ? $exh_artist->ID : $exh_artist;
                            $ar_overview = get_field('overview', $ar_id);
                            $exh_artist_names[] = $ar_overview['name2'] ?? get_the_title($ar_id);
                        }
                    }
                    $exh_artist_text = implode('／', $exh_artist_names);
                ?>
                <li class="event js-fade-up">
                    <a href="<?php the_permalink(); ?>" class="event__img">
                        <figure>
                            <?php if ($exh_thumbnail) : ?>
                            <img src="<?php echo esc_url($exh_thumbnail['url']); ?>" alt="<?php echo esc_attr($exh_thumbnail['alt'] ?? ''); ?>" loading="lazy">
                            <?php endif; ?>
                        </figure>
                    </a>
                    <div class="event__info">
                        <h3 class="event__title"><?php the_title(); ?></h3>
                        <?php if ($exh_subtitle) : ?>
                        <p class="event__lead"><?php echo esc_html($exh_subtitle); ?></p>
                        <?php endif; ?>
                        <?php if ($exh_artist_text) : ?>
                        <p class="event__note"><?php echo esc_html($exh_artist_text); ?></p>
                        <?php endif; ?>
                        <?php if ($exh_period) : ?>
                        <p class="event__date"><?php echo esc_html($exh_period); ?></p>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="event__link u-link-more">Learn more</a>
                    </div>
                </li>
                <?php endwhile; wp_reset_postdata(); ?>
            </ul>
        </div>
    </section>
    <?php endif; ?>

    <!-- exhibitions: forthcoming -->
    <?php
    $forthcoming_exh_query = new WP_Query(array(
        'post_type' => 'exhibitions',
        'posts_per_page' => 4,
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'exhibition_status',
                'field' => 'slug',
                'terms' => 'forthcoming',
            ),
        ),
    ));
    ?>
    <?php if ($forthcoming_exh_query->have_posts()) : ?>
    <section class="top__section top__section--exhibitions">
        <div class="top__inner">
            <h2 class="top__title">FORTHCOMING EXHIBITIONS</h2>
            <ul class="top__events">
                <?php while ($forthcoming_exh_query->have_posts()) : $forthcoming_exh_query->the_post();
                    $exh_id = get_the_ID();
                    $exh_thumbnail = get_field('thumbnail', $exh_id);
                    $exh_mv = get_field('main_visual', $exh_id);
                    if (!$exh_thumbnail && !empty($exh_mv['image'])) {
                        $exh_thumbnail = $exh_mv['image'];
                    }
                    $exh_subtitle = get_field('subtitle', $exh_id);
                    $exh_period = get_field('period', $exh_id);
                    $exh_artists_obj = get_field('artists', $exh_id);
                    $exh_artist_names = [];
                    if ($exh_artists_obj) {
                        foreach ($exh_artists_obj as $exh_artist) {
                            $ar_id = is_object($exh_artist) ? $exh_artist->ID : $exh_artist;
                            $ar_overview = get_field('overview', $ar_id);
                            $exh_artist_names[] = $ar_overview['name2'] ?? get_the_title($ar_id);
                        }
                    }
                    $exh_artist_text = implode('／', $exh_artist_names);
                ?>
                <li class="event js-fade-up">
                    <a href="<?php the_permalink(); ?>" class="event__img">
                        <figure>
                            <?php if ($exh_thumbnail) : ?>
                            <img src="<?php echo esc_url($exh_thumbnail['url']); ?>" alt="<?php echo esc_attr($exh_thumbnail['alt'] ?? ''); ?>" loading="lazy">
                            <?php endif; ?>
                        </figure>
                    </a>
                    <div class="event__info">
                        <h3 class="event__title"><?php the_title(); ?></h3>
                        <?php if ($exh_subtitle) : ?>
                        <p class="event__lead"><?php echo esc_html($exh_subtitle); ?></p>
                        <?php endif; ?>
                        <?php if ($exh_artist_text) : ?>
                        <p class="event__note"><?php echo esc_html($exh_artist_text); ?></p>
                        <?php endif; ?>
                        <?php if ($exh_period) : ?>
                        <p class="event__date"><?php echo esc_html($exh_period); ?></p>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="event__link u-link-more">Learn more</a>
                    </div>
                </li>
                <?php endwhile; wp_reset_postdata(); ?>
            </ul>
        </div>
    </section>
    <?php endif; ?>
    <!-- artfair -->
    <section class="top__section top__section--artfair">
        <div class="top__inner">
            <h2 class="top__title">ARTFAIR</h2>
            <ul class="top__events">
                <li class="event js-fade-up">
                    <a href="<?php echo esc_url( home_url( '/artfairs/art-fair-tokyo-2026/' ) ); ?>" class="event__img">
                    <figure>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/top/img_artfair-list-aft2026.jpg'); ?>" alt="" loading="lazy">
                    </figure>
                    </a>
                    <div class="event__info">
                    <h3 class="event__title">ART FAIR TOKYO 2026</h3>
                    <!-- <p class="event__lead"></p> -->
                    <p class="event__note">有馬晋平／大岩オスカール／谷﨑一心／長島伊織／吉田紳平</p>
                    <p class="event__date"><span>2026.03.13<span class="day">（金）</span></span><span class="en-dash">-</span><span>03.15<span class="day">（日）</span></span></p>
                    <a href="<?php echo esc_url( home_url( '/artfairs/art-fair-tokyo-2026/' ) ); ?>" class="event__link u-link-more">Learn more</a>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- news -->
    <?php
    $news_query = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => 4,
        'post_status' => 'publish',
    ));
    ?>
    <?php if ($news_query->have_posts()) : ?>
    <section class="top__section top__section--news">
        <div class="top__inner">
            <h2 class="top__title">NEWS</h2>
            <div class="top__newslist js-fade-up">
            <div class="swiper" id="topNewsSwiper">
                <div class="swiper-wrapper">
                    <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
                    <div class="swiper-slide news">
                        <a href="<?php the_permalink(); ?>" class="news__img">
                        <figure>
                            <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium_large')); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                            <?php else : ?>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/common/noimage.png'); ?>" alt="" loading="lazy">
                            <?php endif; ?>
                        </figure>
                        </a>
                        <div class="news__info">
                        <h3 class="news__title"><?php the_title(); ?></h3>
                        <p class="news__date"><?php echo get_the_date('Y.m.d'); ?></p>
                        <a href="<?php the_permalink(); ?>" class="news__link u-link-more">Learn more</a>
                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
            <div class="swiper-controller-wrapper">
                <div class="swiper-button-prev news-button-prev"></div>
                <div class="swiper-pagination news-pagination"></div>
                <div class="swiper-button-next news-button-next"></div>
            </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php
get_footer();
?>