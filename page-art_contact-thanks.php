<?php
/**
 * Template Name: Art Contact Thanks
 */
if (! defined('ABSPATH')) exit;

// リファラーチェック — 直接アクセスはトップへリダイレクト
$referer = wp_get_referer();
if (! $referer || strpos($referer, '/art_contact') === false) {
	wp_safe_redirect(home_url('/'));
	exit;
}

get_header();

// 遷移元の作品ページURL
$ref = isset($_GET['ref']) ? esc_url($_GET['ref']) : '';
?>

	<main class="contact-thanks">
		<h1>CONTACT</h1>

		<!-- ページタイトル -->
		<div class="contact-thanks__heading">
			<h2 class="contact-thanks__title">CONTACT</h2>
		</div>

		<div class="contact-thanks__container">
			<div class="contact-thanks__inner">

				<p class="contact-thanks__message">お問い合わせいただきありがとうございます。</p>
				<p class="contact-thanks__sub-message">内容を確認の上、担当者よりご連絡いたします。<br>しばらくお待ちくださいますようお願い申し上げます。</p>

				<div class="contact-thanks__action">
					<?php if ($ref) : ?>
					<a href="<?php echo esc_url($ref); ?>" class="contact-thanks__btn">作品ページへ戻る</a>
					<?php else : ?>
					<a href="<?php echo esc_url(home_url('/')); ?>" class="contact-thanks__btn">トップページへ戻る</a>
					<?php endif; ?>
				</div>

			</div>
		</div>

	</main>

<?php get_footer(); ?>
