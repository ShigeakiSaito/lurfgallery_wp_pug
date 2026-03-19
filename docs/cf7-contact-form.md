# CF7: お問い合わせフォーム設定

## フォームタブ

```html
<!-- 入力エリア -->
<div class="contact__input-area" id="js-input-area">

<div class="contact__field contact__field--required">
	<label class="contact__label">お問い合わせ内容<span class="contact__required"></span></label>
	[text* your-content class:contact__input placeholder "お問い合わせ内容を入力してください"]
	<p class="contact__error" aria-live="polite"></p>
</div>

<div class="contact__field contact__field--required">
	<label class="contact__label">姓<span class="contact__required"></span></label>
	[text* your-last-name class:contact__input placeholder "鈴木"]
	<p class="contact__error" aria-live="polite"></p>
</div>

<div class="contact__field contact__field--required">
	<label class="contact__label">名<span class="contact__required"></span></label>
	[text* your-first-name class:contact__input placeholder "太郎"]
	<p class="contact__error" aria-live="polite"></p>
</div>

<div class="contact__field contact__field--required">
	<label class="contact__label">メールアドレス<span class="contact__required"></span></label>
	[email* your-email class:contact__input placeholder "sample@lurfgallery.co.jp"]
	<p class="contact__error" aria-live="polite"></p>
</div>

<div class="contact__field">
	<label class="contact__label">電話番号</label>
	[tel your-tel class:contact__input placeholder "0312341234"]
	<p class="contact__error" aria-live="polite"></p>
</div>

<div class="contact__field">
	<label class="contact__label">所属</label>
	[text your-company class:contact__input placeholder "有限会社COMPANY"]
	<p class="contact__error" aria-live="polite"></p>
</div>

<div class="contact__field contact__field--required">
	<label class="contact__label">メッセージ<span class="contact__required"></span></label>
	[textarea* your-message class:contact__textarea maxlength:1000 placeholder "お問い合わせ内容の詳細を入力してください"]
	<p class="contact__char-count"><span class="contact__char-current">0</span>/1000</p>
	<p class="contact__error" aria-live="polite"></p>
</div>

<div class="contact__privacy">
	<p>詳細情報を共有することにより、当社の<a href="/privacy-policy/" class="contact__privacy-link">プライバシーポリシー</a>に同意したものとみなします</p>
</div>

<div class="contact__submit">
	<button type="button" id="js-confirm-btn">確認</button>
</div>

</div>
<!-- / 入力エリア -->

<!-- 確認エリア（初期非表示、JSで切り替え） -->
<div class="contact__confirm-area" id="js-confirm-area">

<p class="contact-confirm__description">以下の内容でメッセージを送信します。</p>

<div class="contact-confirm__items">

<div class="contact-confirm__item">
	<p class="contact-confirm__label">お問い合わせ内容</p>
	<p class="contact-confirm__value" id="js-confirm-content"></p>
</div>

<div class="contact-confirm__item">
	<p class="contact-confirm__label">姓</p>
	<p class="contact-confirm__value" id="js-confirm-last-name"></p>
</div>

<div class="contact-confirm__item">
	<p class="contact-confirm__label">名</p>
	<p class="contact-confirm__value" id="js-confirm-first-name"></p>
</div>

<div class="contact-confirm__item">
	<p class="contact-confirm__label">メールアドレス</p>
	<p class="contact-confirm__value" id="js-confirm-email"></p>
</div>

<div class="contact-confirm__item">
	<p class="contact-confirm__label">電話番号</p>
	<p class="contact-confirm__value" id="js-confirm-tel"></p>
</div>

<div class="contact-confirm__item">
	<p class="contact-confirm__label">所属</p>
	<p class="contact-confirm__value" id="js-confirm-company"></p>
</div>

<div class="contact-confirm__item">
	<p class="contact-confirm__label">メッセージ</p>
	<p class="contact-confirm__value" id="js-confirm-message"></p>
</div>

</div>

<div class="contact-confirm__buttons">
	<button type="button" class="contact-confirm__btn contact-confirm__btn--back" id="js-back-btn">修正</button>
	<button type="button" class="contact-confirm__btn contact-confirm__btn--submit" id="js-submit-btn">送信</button>
</div>

</div>
<!-- / 確認エリア -->

[submit class:wpcf7-submit style:display:none "送信"]
```

## メールタブ

### 送信先
```
admin@example.com
```

### 題名
```
【LURF GALLERY】お問い合わせ: [your-content]
```

### メッセージ本文
```
お問い合わせ内容: [your-content]
姓: [your-last-name]
名: [your-first-name]
メールアドレス: [your-email]
電話番号: [your-tel]
所属: [your-company]

メッセージ:
[your-message]

---
このメールはLURF GALLERYのお問い合わせフォームから送信されました。
```

### メール(2) — 自動返信メール

**送信先**
```
[your-email]
```

**題名**
```
【LURF GALLERY】お問い合わせを受け付けました
```

**メッセージ本文**
```
[your-last-name] [your-first-name] 様

お問い合わせいただきありがとうございます。
以下の内容で承りました。

---

お問い合わせ内容: [your-content]
メッセージ:
[your-message]

---

内容を確認の上、担当者よりご連絡いたします。
しばらくお待ちくださいますようお願い申し上げます。

LURF GALLERY
```

## 備考

- 入力エリア(`#js-input-area`)と確認エリア(`#js-confirm-area`)を両方CF7フォーム内に配置
- CF7のsubmitボタンは `display:none` で非表示。確認画面の送信ボタンからCF7のsubmitをプログラム的にクリック
- `wpcf7mailsent` イベントでサンクスページ `/contact-thanks/` へリダイレクト
- `wpcf7invalid` イベントで確認画面→入力画面に戻す
- 固定ページのACFフィールド `formid` にCF7のフォームIDを設定
- バリデーションは `contact__field--required` クラスを持つフィールドを対象にJS側で実施
