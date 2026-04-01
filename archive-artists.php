<?php get_header();

$noimage = esc_url(get_template_directory_uri() . '/assets/img/common/noimage.png');

// ===== タクソノミーからアーティストをグループ分け =====
$parent_artists = get_term_by('slug', 'artists', 'artist_category');
$parent_exhibited = get_term_by('slug', 'exhibited_artists', 'artist_category');

/**
 * 親タームの子タームごとにアーティストを取得
 */
function get_artists_by_subgroups($parent_term) {
	if (!$parent_term) return [];

	$children = get_terms(array(
		'taxonomy' => 'artist_category',
		'parent' => $parent_term->term_id,
		'hide_empty' => false,
	));

	$grouped = [];
	foreach ($children as $child) {
		$posts = get_posts(array(
			'post_type' => 'artists',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'tax_query' => array(
				array(
					'taxonomy' => 'artist_category',
					'field' => 'term_id',
					'terms' => $child->term_id,
				),
			),
		));
		if (!empty($posts)) {
			$grouped[] = array('term' => $child, 'posts' => $posts);
		}
	}
	return $grouped;
}

$artists_groups = get_artists_by_subgroups($parent_artists);
$exhibited_groups = get_artists_by_subgroups($parent_exhibited);

// グループ化済みのIDを収集
$assigned_ids = [];
foreach ($artists_groups as $group) {
	foreach ($group['posts'] as $p) $assigned_ids[] = $p->ID;
}
foreach ($exhibited_groups as $group) {
	foreach ($group['posts'] as $p) $assigned_ids[] = $p->ID;
}
$assigned_ids = array_unique($assigned_ids);

// 未分類アーティスト → Artistsセクション末尾に追加
$all_artists = get_posts(array(
	'post_type' => 'artists',
	'posts_per_page' => -1,
	'post_status' => 'publish',
));
$uncategorized = [];
foreach ($all_artists as $a) {
	if (!in_array($a->ID, $assigned_ids, true)) {
		$uncategorized[] = $a;
	}
}

// Artistsセクション用の全投稿をフラットに
$artists_flat = [];
foreach ($artists_groups as $group) {
	foreach ($group['posts'] as $p) $artists_flat[] = $p;
}
foreach ($uncategorized as $p) $artists_flat[] = $p;

// Exhibited Artistsセクション用の全投稿をフラットに
$exhibited_flat = [];
foreach ($exhibited_groups as $group) {
	foreach ($group['posts'] as $p) $exhibited_flat[] = $p;
}

/**
 * アーティストのインデックス用画像を取得
 */
function get_artist_index_image($post_id) {
	$overview = get_field('overview', $post_id);
	for ($i = 1; $i <= 2; $i++) {
		$img_field = $overview["image{$i}"] ?? null;
		if ($img_field && ($img_field['display'] ?? '') === 'index') {
			$img_value = $img_field['image'] ?? null;
			if (!$img_value) continue;
			// return_format が array の場合
			if (is_array($img_value)) {
				return array(
					'url' => $img_value['url'] ?? '',
					'alt' => $img_value['alt'] ?? '',
				);
			}
			// return_format が空(ID)の場合
			return array(
				'url' => wp_get_attachment_image_url($img_value, 'medium_large'),
				'alt' => get_post_meta($img_value, '_wp_attachment_image_alt', true),
			);
		}
	}
	return null;
}
?>

	<main class="artists-index">
		<h1 class="artists-index__title">ARTISTS</h1>

		<!-- グリッド/リスト切り替えボタン -->
		<div class="artists-index__toggle">
			<div class="artists-index__toggle-inner">
				<button class="artists-index__toggle-icon is-active" aria-label="グリッド表示">
					<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="0.5" y="0.5" width="6" height="6" rx="1" stroke="currentColor"></rect>
						<rect x="9.5" y="0.5" width="6" height="6" rx="1" stroke="currentColor"></rect>
						<rect x="0.5" y="9.5" width="6" height="6" rx="1" stroke="currentColor"></rect>
						<rect x="9.5" y="9.5" width="6" height="6" rx="1" stroke="currentColor"></rect>
					</svg>
				</button>
				<span class="artists-index__toggle-divider"></span>
				<button class="artists-index__toggle-icon" aria-label="リスト表示">
					<svg width="17" height="9" viewBox="0 0 17 9" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M3.94875 1.314V0.0577499H17V1.314H3.94875ZM3.94875 5.12825V3.87175H17V5.12825H3.94875ZM3.94875 8.94225V7.686H17V8.94225H3.94875ZM0.68575 1.37175C0.49975 1.37175 0.339 1.30417 0.2035 1.169C0.0678333 1.03367 0 0.867749 0 0.671249C0 0.480083 0.0678333 0.320417 0.2035 0.19225C0.339167 0.0640834 0.50275 0 0.69425 0C0.885917 0 1.04675 0.0648341 1.17675 0.194501C1.30675 0.324167 1.37175 0.48475 1.37175 0.67625C1.37175 0.869416 1.306 1.03367 1.1745 1.169C1.043 1.30417 0.880083 1.37175 0.68575 1.37175ZM0.68575 5.17625C0.49975 5.17625 0.339 5.10933 0.2035 4.9755C0.0678333 4.84183 0 4.68058 0 4.49175C0 4.29475 0.0678333 4.13092 0.2035 4.00025C0.339167 3.86975 0.50275 3.8045 0.69425 3.8045C0.885917 3.8045 1.04675 3.8705 1.17675 4.0025C1.30675 4.13433 1.37175 4.30125 1.37175 4.50325C1.37175 4.68442 1.306 4.84192 1.1745 4.97575C1.043 5.10942 0.880083 5.17625 0.68575 5.17625ZM0.68575 9C0.49975 9 0.339 8.93233 0.2035 8.797C0.0678333 8.66167 0 8.49575 0 8.29925C0 8.10825 0.0678333 7.94867 0.2035 7.8205C0.339167 7.69233 0.50275 7.62825 0.69425 7.62825C0.885917 7.62825 1.04675 7.693 1.17675 7.8225C1.30675 7.95217 1.37175 8.11283 1.37175 8.3045C1.37175 8.4975 1.306 8.66167 1.1745 8.797C1.043 8.93233 0.880083 9 0.68575 9Z" fill="currentColor"></path>
					</svg>
				</button>
			</div>
		</div>

		<!-- ===== グリッド表示 ===== -->
		<div class="artists-index__view artists-index__view--grid is-active">
			<!-- ARTISTS -->
			<?php if (!empty($artists_flat)) : ?>
			<section class="artists-index__section artists-index__section--featured">
				<h2 class="artists-index__heading">ARTISTS</h2>
				<div class="artists-index__grid artists-index__grid--featured">
					<?php foreach ($artists_flat as $artist_post) :
						$a_id = $artist_post->ID;
						$a_overview = get_field('overview', $a_id);
						$a_name1 = $a_overview['name1'] ?? '';
						$a_name2 = $a_overview['name2'] ?? '';
						$a_profile = $a_overview['profile'] ?? '';
						$a_img = get_artist_index_image($a_id);
					?>
					<a href="<?php echo esc_url(get_permalink($a_id)); ?>" class="artists-index__card">
						<div class="artists-index__card-img">
							<img src="<?php echo esc_url($a_img ? $a_img['url'] : $noimage); ?>" alt="<?php echo esc_attr($a_img ? $a_img['alt'] : ''); ?>" width="280" height="198" loading="lazy">
						</div>
						<p class="artists-index__card-name"><?php echo esc_html($a_name1); ?><?php if ($a_name2) : ?><br><?php echo esc_html($a_name2); ?><?php endif; ?></p>
						<p class="artists-index__card-desc"><?php echo esc_html($a_profile); ?></p>
					</a>
					<?php endforeach; ?>
				</div>
			</section>
			<?php endif; ?>

			<!-- EXHIBITED ARTISTS -->
			<?php if (!empty($exhibited_flat)) : ?>
			<section class="artists-index__section artists-index__section--exhibited">
				<h2 class="artists-index__heading">EXHIBITED ARTISTS</h2>
				<div class="artists-index__grid artists-index__grid--exhibited">
					<?php foreach ($exhibited_flat as $artist_post) :
						$a_id = $artist_post->ID;
						$a_overview = get_field('overview', $a_id);
						$a_name1 = $a_overview['name1'] ?? '';
						$a_name2 = $a_overview['name2'] ?? '';
						$a_profile = $a_overview['profile'] ?? '';
						$a_img = get_artist_index_image($a_id);
					?>
					<a href="<?php echo esc_url(get_permalink($a_id)); ?>" class="artists-index__card">
						<div class="artists-index__card-img">
							<img src="<?php echo esc_url($a_img ? $a_img['url'] : $noimage); ?>" alt="<?php echo esc_attr($a_img ? $a_img['alt'] : ''); ?>" width="280" height="198" loading="lazy">
						</div>
						<p class="artists-index__card-name"><?php echo esc_html($a_name1); ?><?php if ($a_name2) : ?><br><?php echo esc_html($a_name2); ?><?php endif; ?></p>
						<p class="artists-index__card-desc"><?php echo esc_html($a_profile); ?></p>
					</a>
					<?php endforeach; ?>
				</div>
			</section>
			<?php endif; ?>
		</div>

		<!-- ===== リスト表示 ===== -->
		<div class="artists-index__view artists-index__view--list">
			<!-- ARTIST -->
			<?php if (!empty($artists_groups) || !empty($uncategorized)) : ?>
			<section class="artists-index__section artists-index__section--list-featured">
				<h2 class="artists-index__heading">ARTIST</h2>
				<div class="artists-index__list">
					<?php foreach ($artists_groups as $group) : ?>
					<div class="artists-index__list-group">
						<?php foreach ($group['posts'] as $artist_post) :
							$a_id = $artist_post->ID;
							$a_overview = get_field('overview', $a_id);
							$a_name1 = $a_overview['name1'] ?? '';
						?>
						<a href="<?php echo esc_url(get_permalink($a_id)); ?>" class="artists-index__list-item">
							<span class="artists-index__list-item-name"><?php echo esc_html($a_name1); ?></span>
						</a>
						<?php endforeach; ?>
					</div>
					<?php endforeach; ?>
					<?php if (!empty($uncategorized)) : ?>
					<div class="artists-index__list-group">
						<?php foreach ($uncategorized as $artist_post) :
							$a_id = $artist_post->ID;
							$a_overview = get_field('overview', $a_id);
							$a_name1 = $a_overview['name1'] ?? '';
						?>
						<a href="<?php echo esc_url(get_permalink($a_id)); ?>" class="artists-index__list-item">
							<span class="artists-index__list-item-name"><?php echo esc_html($a_name1); ?></span>
						</a>
						<?php endforeach; ?>
					</div>
					<?php endif; ?>
				</div>
			</section>
			<?php endif; ?>

			<!-- EXHIBITED ARTISTS -->
			<?php if (!empty($exhibited_groups)) : ?>
			<section class="artists-index__section artists-index__section--exhibited">
				<h2 class="artists-index__heading">EXHIBITED ARTISTS</h2>
				<div class="artists-index__list">
					<?php foreach ($exhibited_groups as $group) : ?>
					<div class="artists-index__list-group">
						<?php foreach ($group['posts'] as $artist_post) :
							$a_id = $artist_post->ID;
							$a_overview = get_field('overview', $a_id);
							$a_name1 = $a_overview['name1'] ?? '';
						?>
						<a href="<?php echo esc_url(get_permalink($a_id)); ?>" class="artists-index__list-item">
							<span class="artists-index__list-item-name"><?php echo esc_html($a_name1); ?></span>
						</a>
						<?php endforeach; ?>
					</div>
					<?php endforeach; ?>
				</div>
			</section>
			<?php endif; ?>
		</div>

		<script>
		(function() {
			var buttons = document.querySelectorAll('.artists-index__toggle-icon');
			var views = document.querySelectorAll('.artists-index__view');

			buttons.forEach(function(button, index) {
				button.addEventListener('click', function() {
					buttons.forEach(function(btn) { btn.classList.remove('is-active'); });
					views.forEach(function(view) { view.classList.remove('is-active'); });
					button.classList.add('is-active');
					views[index].classList.add('is-active');
				});
			});
		})();
		</script>
	</main>

<?php get_footer(); ?>
