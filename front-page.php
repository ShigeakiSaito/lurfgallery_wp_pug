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
            <video autoplay muted loop playsinline>
                <source src="<?php echo esc_url($upload_dir['baseurl'] . '/2026/02/img_mv_pc.mp4'); ?>" media="(min-width: 768px)">
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
    <!-- exhibitions -->
    <section class="top__section top__section--exhibitions">
        <div class="top__inner">
            <h2 class="top__title">FORTHCOMING EXHIBITIONS</h2>
            <ul class="top__events">
                <li class="event js-fade-up">
                    <a href="<?php echo esc_url( home_url( '/exhibitions/group-exhibition-imagination/' ) ); ?>" class="event__img">
                        <figure>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/top/img_exhibition-list-imagination.jpg'); ?>" alt="" loading="lazy">
                        </figure>
                    </a>
                    <div class="event__info">
                        <h3 class="event__title">IMAGINATION</h3>
                        <!-- <p class="event__lead"></p> -->
                        <p class="event__note">有馬晋平／大岩オスカール／谷﨑一心／長島伊織／吉田紳平</p>
                        <p class="event__date"><span>2026.03.13<span class="day">（金）</span></span><span class="en-dash">-</span><span>04.04<span class="day">（日）</span></span></p>
                        <a href="<?php echo esc_url( home_url( '/exhibitions/group-exhibition-imagination/' ) ); ?>" class="event__link u-link-more">Learn more</a>
                    </div>
                </li>
            </ul>
        </div>
    </section>
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
    <section class="top__section top__section--news">
        <div class="top__inner">
            <h2 class="top__title">NEWS</h2>
            <div class="top__newslist js-fade-up">
            <div class="swiper" id="topNewsSwiper">
                <div class="swiper-wrapper">
                    <!-- <div class="swiper-slide news">
                        <a href="" class="news__img">
                        <figure>
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/top/img_news01.png'); ?>" alt="" loading="lazy">
                        </figure>
                        </a>
                        <div class="news__info">
                        <h3 class="news__title">【7月/8月】休館日および営業時間変更のお知らせ</h3>
                        <p class="news__date">2025.06.21</p>
                        <a href="" class="news__link u-link-more">Learn more</a>
                        </div> 
                    </div> -->
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
</main>

<?php
get_footer();
?>