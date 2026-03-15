// ===== URL パラメータ操作ヘルパー =====
function updateUrlParam(key, value) {
	var url = new URL(window.location.href);
	if (value === 'all') {
		url.searchParams.delete(key);
	} else {
		url.searchParams.set(key, value);
	}
	window.location.href = url.toString();
}

// ===== ステータスタブ =====
(function () {
	var tabs = document.querySelectorAll('.exhibitions-index__tab');
	tabs.forEach(function (tab) {
		tab.addEventListener('click', function () {
			var status = tab.dataset.status;
			updateUrlParam('status', status);
		});
	});
})();

// ===== Year Select ドロップダウン =====
(function () {
	var yearSelect = document.getElementById('js-year-select');
	if (!yearSelect) return;

	var label = yearSelect.querySelector('.exhibitions-index__year-label');
	var options = yearSelect.querySelectorAll('.exhibitions-index__year-option');

	yearSelect.addEventListener('click', function (e) {
		e.stopPropagation();
		yearSelect.classList.toggle('is-open');
	});

	options.forEach(function (option) {
		option.addEventListener('click', function (e) {
			e.stopPropagation();
			options.forEach(function (o) { o.classList.remove('is-active'); });
			option.classList.add('is-active');

			var year = option.dataset.year;
			if (label) {
				label.textContent = year === 'all' ? 'SELECT YEAR' : year;
			}
			yearSelect.classList.remove('is-open');

			updateUrlParam('af_year', year);
		});
	});

	document.addEventListener('click', function () {
		yearSelect.classList.remove('is-open');
	});
})();

// ===== View more =====
(function () {
	var list = document.getElementById('js-artfair-list');
	var moreWrap = document.getElementById('js-artfair-more');
	if (!list || !moreWrap) return;

	var moreBtn = moreWrap.querySelector('.u-button-more');

	var updateMoreVisibility = function () {
		if (list.querySelectorAll('.artfair-index__item.is-hidden').length === 0) {
			moreWrap.style.display = 'none';
		}
	};

	updateMoreVisibility();

	if (moreBtn) {
		moreBtn.addEventListener('click', function () {
			var hiddenItems = list.querySelectorAll('.artfair-index__item.is-hidden');
			var showCount = Math.min(3, hiddenItems.length);

			for (var i = 0; i < showCount; i++) {
				var item = hiddenItems[i];
				item.classList.remove('is-hidden');
				item.classList.add('is-appearing');
				item.addEventListener('animationend', function () {
					this.classList.remove('is-appearing');
				}, { once: true });
			}

			updateMoreVisibility();
		});
	}
})();
