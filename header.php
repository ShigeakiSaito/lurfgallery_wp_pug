<!DOCTYPE html>
<html lang="ja">

<head>   
    <meta charset="utf-8">
    <link rel="icon" type="image/svg+xml" href="<?php echo esc_url(get_template_directory_uri() . '/assets/favicon.png'); ?>">
    <meta name="viewport" content="width=device-width">
    <title>LURF GALLERY｜Contemporary Art Gallery</title>
    <!-- confirm -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta name="keywords" content="">
    <meta name="format-detection" content="telephone=no">
    <meta name="referrer" content="no-referrer-when-downgrade" />
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php the_permalink(); ?>">
    <meta property="og:image" content="<?php bloginfo('template_url'); ?>/assets/img/ogp.jpg">
    <meta property="og:site_name" content="<?php bloginfo('name'); ?>">
    <meta property="og:description" content="<?php bloginfo('description'); ?>" />
    <meta property="fb:app_id" content="">
    <meta name="twitter:card" content="photo" />
    <meta name="twitter:title" content="<?php bloginfo('name'); ?>" />
    <meta name="twitter:description" content="<?php bloginfo('description'); ?>" />
    <meta name="twitter:url" content="<?php the_permalink(); ?>" />
    <meta name="twitter:image" content="<?php bloginfo('template_url'); ?>/assets/img/ogp.jpg">
    <meta name="twitter:app:country" content="jp">
    <?php wp_head(); ?>
</head>

<body>   
<header class="header">
    <button class="header__button js-menu-toggle" aria-label="メニューの開閉"></button>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo">
        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/common/img_logo.png'); ?>" alt="LURF GALLERY">
    </a>
    <div class="header__menu js-menu">
        <nav class="header__nav">
            <ul class="header__list">
                <li><a href="">EXHIBITIONS</a></li>
                <li><a href="">ARTISTS</a></li>
                <li><a href="">ART FAIRS</a></li>
                <li><a href="">NEWS</a></li>
            </ul>
            <ul class="header__sublist">
                <li><a href="">ABOUT</a></li>
                <li><a href="">CONTACT</a></li>
                <li><a href="">SHOP</a></li>
                <li><a href="">INFORMATION</a></li>
            </ul>
            <form action="" class="header__search">
                <label><input type="text" placeholder="SEARCH"></label>
            </form>
            <div class="header__language">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="jp">JP</a>
                <span>/</span>
                <a href="<?php echo esc_url(home_url('/en/')); ?>" class="en">EN</a>
            </div>
        </nav>
    </div>
</header>
