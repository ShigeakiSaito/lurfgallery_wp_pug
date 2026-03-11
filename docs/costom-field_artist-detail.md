# アーティスト詳細ページのカスタムフィールド

* MV画像
mv_images->pc (画像配列)
mv_images->sp (画像配列)

* MVテキスト
overview->name1

* アンカーナビゲーション
** Overview
** Selected Artworks: Artworksの指定が無ければ非表示
** Biography: Biographyの指定が無ければ非表示
** Exhibitions: Exhibitionsの指定が無ければ非表示
** Fairs: Artfairsの指定が無ければ非表示
** News: Newsの指定が無ければ非表示
** Product: Productの指定が無ければ非表示

* Overview: overview
** 作家画像1: image1
*** 画像: overview->image1->image
*** 表示先(詳細、一覧、非表示): overview->image1->display
** 作家画像2: image2
*** 画像: overview->image2->image
*** 表示先(詳細、一覧、非表示): overview->image2->display
** CONTACTボタン1: overview->contact1_url (設定時はOverview左の画像の下にCONTACTボタン表示)
** CONTACTボタン2: overview->contact2_url (設定時はOverview右のCONTACTボタン表示)
** 作家リンク1: overview->link1 (設定時はOverview左の画像の下にリンク追加)
*** ラベル: overview->link1->label
*** URL: overview->link1->url
** 作家リンク2: overview->link2 (設定時はOverview左の画像の下にリンク追加)
*** ラベル: overview->link2->label
*** URL: overview->link2->url
** 作家リンク3: overview->link3 (設定時はOverview左の画像の下にリンク追加)
*** ラベル: overview->link3->label
*** URL: overview->link3->url
** 作家名1: overview->name1 (アルファベット)
** 作家名2: overview->name2 (漢字)
** プロフィール: overview->profile

* SELECTED ARTWORKS: selected_artworks
** カラムセット: selected_artworks->set[]
*** カラムセットの表示カラム(col3, col2, col1): selected_artworks->set[]->columns
*** カラムセットの作品: selected_artworks->set[]->works[]

* BIOGRAPHY: biography
** テキスト部: biography->text
** 年代、内容のセット: biography->set[]
*** セットタイトル: biography->set[]->title
*** 年代・内容セット: biography->set[]->set[]
*** 年代: biography->set[]->set[]->year
*** 内容: biography->set[]->set[]->text

* EXHIBITIONS: exhibitions
** 投稿リスト：exhibitions[]

* ARTFAIR: artfairs
** 投稿リスト：artfairs[]

* NEWS: news
** 投稿リスト: news[]
