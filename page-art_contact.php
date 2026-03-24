<?php
if (! defined('ABSPATH')) exit;
get_header();

$formid = get_field('formid');

// URLパラメータから作品情報を取得
$artwork_image  = isset($_GET['artwork_image']) ? esc_url($_GET['artwork_image']) : '';
$artwork_artist = isset($_GET['artwork_artist']) ? esc_html($_GET['artwork_artist']) : '';
$artwork_title  = isset($_GET['artwork_title']) ? esc_html($_GET['artwork_title']) : '';
$artwork_year   = isset($_GET['artwork_year']) ? esc_html($_GET['artwork_year']) : '';
$artwork_material = isset($_GET['artwork_material']) ? esc_html($_GET['artwork_material']) : '';
$artwork_size   = isset($_GET['artwork_size']) ? esc_html($_GET['artwork_size']) : '';
$ref            = isset($_GET['ref']) ? esc_url($_GET['ref']) : '';

// 作品情報テキスト（メール送信用）
$artwork_info_parts = array_filter([$artwork_artist, $artwork_title, $artwork_year, $artwork_material, $artwork_size]);
$artwork_info_text = implode(' / ', $artwork_info_parts);
?>

	<main class="contact">
		<h1>CONTACT</h1>

		<!-- ページタイトル -->
		<div class="contact__heading">
			<h2 class="contact__title">CONTACT</h2>
		</div>

		<div class="contact__container">
			<div class="contact__inner">

				<!-- 営業時間テキスト -->
				<div class="contact__description">
					<p>ルーフギャラリー カスタマーサポートの営業時間は、平日10:00 ～ 17:30（土日祝・年末年始を除く）です。<br>
						いただいたお問い合わせは翌営業日以降、順次ご回答させていただきます。</p>
				</div>

				<?php if ($formid) : ?>
				<div class="contact__form-wrap">
					<!-- お問い合わせ作品情報 -->
					<?php if ($artwork_info_text) : ?>
					<div class="contact__artwork-info-wrap">
						<p class="contact__artwork-info-heading">お問い合わせ作品</p>
						<?php if ($artwork_image) : ?>
						<div class="contact__artwork-info">
							<img src="<?php echo esc_url($artwork_image); ?>" alt="<?php echo $artwork_artist; ?>" loading="lazy">
						</div>
						<?php endif; ?>
						<p class="contact__artwork-info"><?php echo $artwork_info_text; ?></p>
					</div>
					<?php endif; ?>

					<?php echo do_shortcode('[contact-form-7 id="' . esc_attr($formid) . '" html_class="contact__form"]'); ?>
				</div>
				<?php endif; ?>

			</div>
		</div>

	</main>

	<script>
	document.addEventListener('DOMContentLoaded', function() {
		var wpcf7Form = document.querySelector('.wpcf7-form');
		if (!wpcf7Form) return;

		var inputArea = wpcf7Form.querySelector('#js-input-area');
		var confirmArea = wpcf7Form.querySelector('#js-confirm-area');
		var confirmBtn = wpcf7Form.querySelector('#js-confirm-btn');
		var backBtn = wpcf7Form.querySelector('#js-back-btn');
		var submitBtn = wpcf7Form.querySelector('#js-submit-btn');

		if (!inputArea || !confirmArea || !confirmBtn) return;

		// 隠しフィールドに作品情報をセット
		var artworkInfoField = wpcf7Form.querySelector('[name="your-artwork-info"]');
		if (artworkInfoField) {
			artworkInfoField.value = '<?php echo esc_js($artwork_info_text); ?>';
		}

		// 文字数カウント
		var textarea = wpcf7Form.querySelector('[name="your-message"]');
		var charCount = wpcf7Form.querySelector('.contact__char-current');
		if (textarea && charCount) {
			textarea.addEventListener('input', function() {
				charCount.textContent = String(textarea.value.length);
			});
		}

		// CF7フォームから値を取得
		function getFieldValue(name) {
			var el = wpcf7Form.querySelector('[name="' + name + '"]');
			return el ? el.value : '';
		}

		// 入力値を確認エリアに反映
		function populateConfirm() {
			var artworkEl = document.getElementById('js-confirm-artwork');
			if (artworkEl) {
				artworkEl.textContent = '<?php echo esc_js($artwork_info_text); ?>';
			}
			document.getElementById('js-confirm-last-name').textContent = getFieldValue('your-last-name');
			document.getElementById('js-confirm-first-name').textContent = getFieldValue('your-first-name');
			document.getElementById('js-confirm-email').textContent = getFieldValue('your-email');
			document.getElementById('js-confirm-tel').textContent = getFieldValue('your-tel') || '—';
			document.getElementById('js-confirm-company').textContent = getFieldValue('your-company') || '—';
			document.getElementById('js-confirm-message').textContent = getFieldValue('your-message');
		}

		// バリデーション: エラー状態をクリア
		function clearErrors() {
			wpcf7Form.querySelectorAll('.is-error').forEach(function(el) {
				el.classList.remove('is-error');
			});
			wpcf7Form.querySelectorAll('.contact__error').forEach(function(el) {
				el.textContent = '';
			});
		}

		// バリデーション: 必須フィールドチェック
		function validateForm() {
			clearErrors();
			var isValid = true;

			var requiredFields = wpcf7Form.querySelectorAll('.contact__field--required');
			requiredFields.forEach(function(fieldWrap) {
				var field = fieldWrap.querySelector('input, textarea');
				if (!field) return;

				if (!field.value.trim()) {
					isValid = false;
					field.classList.add('is-error');
					var errorEl = fieldWrap.querySelector('.contact__error');
					if (errorEl) {
						var labelEl = fieldWrap.querySelector('.contact__label');
						var label = labelEl ? labelEl.childNodes[0].textContent.trim() : '';
						errorEl.textContent = label + 'を入力してください';
					}
				}
				if (field.type === 'email' && field.value.trim() && !field.validity.valid) {
					isValid = false;
					field.classList.add('is-error');
					var errorEl = fieldWrap.querySelector('.contact__error');
					if (errorEl) {
						errorEl.textContent = 'メールアドレスの形式が正しくありません';
					}
				}
			});

			return isValid;
		}

		// 入力時にエラー状態を解除
		wpcf7Form.querySelectorAll('input, textarea').forEach(function(field) {
			field.addEventListener('input', function() {
				if (field.classList.contains('is-error')) {
					field.classList.remove('is-error');
					var fieldWrap = field.closest('.contact__field');
					if (fieldWrap) {
						var errorEl = fieldWrap.querySelector('.contact__error');
						if (errorEl) errorEl.textContent = '';
					}
				}
			});
		});

		// 確認ボタン → 確認画面表示
		confirmBtn.addEventListener('click', function() {
			if (!validateForm()) {
				var firstError = wpcf7Form.querySelector('.is-error');
				if (firstError) {
					firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
				}
				return;
			}
			populateConfirm();
			inputArea.style.display = 'none';
			confirmArea.style.display = 'block';
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});

		// 修正ボタン → 入力画面に戻る
		backBtn.addEventListener('click', function() {
			confirmArea.style.display = 'none';
			inputArea.style.display = 'block';
			window.scrollTo({ top: 0, behavior: 'smooth' });
		});

		// 送信ボタン → CF7フォームをsubmit
		submitBtn.addEventListener('click', function() {
			var cf7Submit = wpcf7Form.querySelector('.wpcf7-submit');
			if (cf7Submit) cf7Submit.click();
		});

		// CF7送信成功 → サンクスページへリダイレクト
		document.addEventListener('wpcf7mailsent', function() {
			var ref = '<?php echo esc_js($ref); ?>';
			var thanksUrl = '<?php echo esc_url(home_url('/art_contact/thanks/')); ?>';
			if (ref) {
				thanksUrl += '?ref=' + encodeURIComponent(ref);
			}
			window.location.href = thanksUrl;
		});

		// CF7送信失敗 → 入力画面に戻す
		document.addEventListener('wpcf7invalid', function() {
			confirmArea.style.display = 'none';
			inputArea.style.display = 'block';
		});
	});
	</script>

<?php get_footer(); ?>
