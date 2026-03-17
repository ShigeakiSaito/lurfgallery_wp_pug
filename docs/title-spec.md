# 各ページのタイトル

サイト名: `LURF GALLERY`
区切り文字: `｜`（全角）に統一
`Contemporary Art Gallery` はトップページのみ

## 固定ページ

| ページ | テンプレート | タイトル | 備考 |
|--------|-------------|---------|------|
| トップ | front-page.php | `LURF GALLERY｜Contemporary Art Gallery` | |
| 汎用固定ページ | page.php | `{ページタイトル}｜LURF GALLERY` | |
| FAQ | page-faq.php | `FAQ｜LURF GALLERY` | page.phpと同じルール |
| Cafe | page-cafe.php | `CAFE｜LURF GALLERY` | page.phpと同じルール |
| Contact | page-contact.php | `{ページタイトル}｜LURF GALLERY` | 他と統一 |
| Art Contact | page-art_contact.php | `{ページタイトル}｜LURF GALLERY` | 他と統一 |
| 検索結果 | search.php | `Search Results: {クエリ}｜LURF GALLERY` | |
| 404 | - | `Page not found｜LURF GALLERY` | |

## 投稿アーカイブ（一覧）

| ページ | テンプレート | タイトル |
|--------|-------------|---------|
| Exhibitions 一覧 | archive-exhibitions.php | `EXHIBITIONS｜LURF GALLERY` |
| Art Fair 一覧 | archive-artfairs.php | `ART FAIR｜LURF GALLERY` |
| Artists 一覧 | archive-artists.php | `ARTISTS｜LURF GALLERY` |
| News 一覧 | home.php | `NEWS｜LURF GALLERY` |

## 投稿詳細

| ページ | テンプレート | タイトル | 例 |
|--------|-------------|---------|-----|
| Exhibition 詳細 | single-exhibitions.php | `{投稿タイトル}｜EXHIBITIONS｜LURF GALLERY` | `着想と実行 Inspiration and Execution｜EXHIBITIONS｜LURF GALLERY` |
| Art Fair 詳細 | single-artfairs.php | `{投稿タイトル}｜ART FAIR｜LURF GALLERY` | `ART FAIR TOKYO 2026｜ART FAIR｜LURF GALLERY` |
| Artist 詳細 | single-artists.php | `{name1} {name2}｜ARTISTS｜LURF GALLERY` | `AKIYA AIMI 會見 明也｜ARTISTS｜LURF GALLERY` |
| Artwork 詳細 | single-artworks.php | `{アーティスト名} - {作品タイトル}｜EXHIBITIONS｜LURF GALLERY` | `TAKAHIRO UEDA - Cadmium red medium and cobalt green｜EXHIBITIONS｜LURF GALLERY` |
| Edition 詳細 | single-editions.php | `{アーティスト名} - {作品タイトル}｜EDITIONS｜LURF GALLERY` | `TAKAHIRO UEDA - Cadmium red medium and cobalt green｜EDITIONS｜LURF GALLERY` |
| Book 詳細 | single-books.php | `{アーティスト名} - {書籍タイトル}｜EXHIBITIONS｜LURF GALLERY` | `ARTIST NAME - Book name｜EXHIBITIONS｜LURF GALLERY` |
| News 詳細 | single-post.php | `{投稿タイトル}｜NEWS｜LURF GALLERY` | `北見和人氏展示会にてアートの講演を開催｜NEWS｜LURF GALLERY` |

## 実装方法

`functions.php` の `pre_get_document_title` フィルターで一括制御。
`header.php` からは `<title>` タグを削除し、`add_theme_support('title-tag')` による自動出力を使用。
