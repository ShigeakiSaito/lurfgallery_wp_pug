# ACF カスタムフィールド仕様書

## 概要

各投稿タイプにおける ACF (Advanced Custom Fields) のフィールド定義と、画像の取得方法をまとめたドキュメント。
**一覧サムネイル** は、検索結果やアーカイブページで使用するサムネイル画像の取得元を示す。

---

## 投稿タイプ別 サムネイル取得元

| 投稿タイプ   | 一覧サムネイル           | 詳細メインビジュアル     |
|:-------------|:-------------------------|:-------------------------|
| News (post)  | アイキャッチ画像         | アイキャッチ画像         |
| 固定ページ   | アイキャッチ画像         | アイキャッチ画像       |
| Exhibitions  | `main_visual->image`   | `main_visual->image`   |
| Artists      | `mv_images->pc`        | `mv_images->pc`       |
| Art Fairs    | `main_visual->image`   | `main_visual->image`   |
| Artworks     | `images`の1枚目         | `images`（ギャラリー）   |
| Editions     | `images`の1枚目         | `images`（ギャラリー）   |
| Books        | `images`の1枚目         | `images`（ギャラリー）   |

- **アイキャッチ画像**: WordPress標準機能。`get_the_post_thumbnail_url($id, 'medium_large')` で取得
- **フォールバック画像**: `/assets/img/common/noimage.png`

---

## 投稿タイプ別 フィールド定義

### News (post)

| フィールド名 | 型       | 説明                           | 使用テンプレート |
|:-------------|:---------|:-------------------------------|:-----------------|
| caption      | テキスト | メインビジュアルのキャプション | single-post.php  |

サムネイル: アイキャッチ画像を使用。

### 固定ページ

ACF フィールドなし。アイキャッチ画像を使用。

### Exhibitions

| フィールド名 | 型     | 説明                                   | 使用テンプレート |
|:-------------|:-------|:---------------------------------------|:-----------------|
| main_visual  | グループ | メインビジュアル                     | single.php       |

`main_visual` グループの構造:
```php
$mv = get_field('main_visual');
$image_url = $mv['image']['url'];  // 画像URL
$image_alt = $mv['image']['alt'];  // alt テキスト
```

一覧サムネイル:
```php
$mv = get_field('main_visual', $post_id);
$thumb_url = $mv['image']['url'];
```

### Artists

| フィールド名 | 型       | 説明                   | 使用テンプレート      |
|:-------------|:---------|:-----------------------|:---------------------|
| mv_images    | グループ | メインビジュアル画像   | single-artists.php   |

`mv_images` グループの構造:
```php
$mv = get_field('mv_images');
$pc_url = $mv['pc']['url'];   // PC用画像
$pc_alt = $mv['pc']['alt'];
```

一覧サムネイル:
```php
$mv = get_field('mv_images', $post_id);
$thumb_url = $mv['pc']['url'];
```

### Art Fairs

| フィールド名 | 型       | 説明             | 使用テンプレート      |
|:-------------|:---------|:-----------------|:---------------------|
| main_visual  | グループ | メインビジュアル | single-artfairs.php  |

`main_visual` グループの構造: Exhibitions と同一。
```php
$mv = get_field('main_visual');
$image_url = $mv['image']['url'];
```

### Artworks / Editions / Books（共通構造）

| フィールド名 | 型             | 説明               | 使用テンプレート    |
|:-------------|:---------------|:-------------------|:-------------------|
| images       | リピーター     | ギャラリー画像     | single-{type}.php  |
| artist_name  | テキスト       | アーティスト名     | single-{type}.php  |
| title        | テキスト       | 作品タイトル       | single-{type}.php  |
| description  | テキストエリア | 説明文             | single-{type}.php  |
| note         | テキストエリア | 備考               | single-{type}.php  |
| buttons      | リピーター     | アクションボタン   | single-{type}.php  |
| purchase_url | URL            | 購入リンク         | single-{type}.php  |
| price        | テキスト       | 価格（Books のみ） | single-books.php   |

`images` リピーターの構造:
```php
$images = get_field('images'); // 行の配列
foreach ($images as $row) {
    $url = $row['image']['url'];
    $alt = $row['image']['alt'];
}
```

一覧サムネイル（1枚目を使用）:
```php
$images = get_field('images', $post_id);
$thumb_url = !empty($images) ? $images[0]['image']['url'] : '';
```

---

## 新規投稿タイプ追加用テンプレート

```markdown
### {投稿タイプ名}

| フィールド名 | 型 | 説明 | 使用テンプレート |
|:-------------|:---|:-----|:-----------------|
|              |    |      |                  |

取得方法:
\```php
// コード例
\```

備考:
-
```
