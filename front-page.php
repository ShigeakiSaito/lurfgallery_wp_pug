<?php
if (! defined('ABSPATH')) exit;
get_header();
?>

<main class="top">
    <h1>LURF GALLERY</h1>
    <div class="top__mv">
        <div class="swiper" id="topMvSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="">
                    <picture>
                        <source srcset="<?php echo esc_url(get_template_directory_uri() . '/assets/img/top/img_mv01_pc.png'); ?>" media="(min-width: 768px)" width="3024" height="1504">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/top/img_mv01_sp.png'); ?>" alt="" width="780" height="1016">
                    </picture>  
                    </a>
                </div>
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
    </div>
    <!-- exhibitions -->
    <section class="top__section top__section--exhibitions">
        <div class="top__inner">
            <h2 class="top__title">FORTHCOMING EXHIBITIONS</h2>
            <ul class="top__exhibitions">
                <li class="exhibition js-fade-up">
                    <a href="" class="exhibition__img">
                    <figure>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/top/img_exhibition01.png'); ?>" alt="" loading="lazy">
                    </figure>
                    </a>
                    <div class="exhibition__info">
                    <h3 class="exhibition__title">前田信明 × 谷﨑一心</h3>
                    <p class="exhibition__lead">呼吸する絵画</p>
                    <p class="exhibition__note">Breathing Paintings Cross / Vortex―交差と渦</p>
                    <p class="exhibition__date"><span>2025.06.21<span class="day">（日）</span></span><span class="en-dash">-</span><span>07.27<span class="day">（月）</span></span></p>
                    <a href="" class="exhibition__link u-link-more">Learn more</a>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- artfair -->
    <section class="top__section top__section--artfair">
        <div class="top__inner">
            <h2 class="top__title">ARTFAIR</h2>
            <ul class="top__exhibitions">
                <li class="exhibition js-fade-up">
                    <a href="" class="exhibition__img">
                    <figure>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/top/img_exhibition01.png'); ?>" alt="" loading="lazy">
                    </figure>
                    </a>
                    <div class="exhibition__info">
                    <h3 class="exhibition__title">前田信明 × 谷﨑一心</h3>
                    <p class="exhibition__lead">呼吸する絵画</p>
                    <p class="exhibition__note">Breathing Paintings Cross / Vortex―交差と渦</p>
                    <p class="exhibition__date"><span>2025.06.21<span class="day">（日）</span></span><span class="en-dash">-</span><span>07.27<span class="day">（月）</span></span></p>
                    <a href="" class="exhibition__link u-link-more">Learn more</a>
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
                <div class="swiper-slide news">
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
                </div>
                <div class="swiper-slide news">
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
                </div>
                <div class="swiper-slide news">
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
                </div>
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