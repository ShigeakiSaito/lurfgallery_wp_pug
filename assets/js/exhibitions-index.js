// ===== Year Select ドロップダウン =====
(function () {
	const yearSelect = document.getElementById('js-year-select');
	if (!yearSelect) return;

	const label = yearSelect.querySelector('.exhibitions-index__year-label');
	const options = yearSelect.querySelectorAll('.exhibitions-index__year-option');

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
		});
	});

	document.addEventListener('click', function () {
		yearSelect.classList.remove('is-open');
	});
})();

// ===== View more =====
(function () {
	var list = document.getElementById('js-exhibitions-list');
	var moreWrap = document.getElementById('js-exhibitions-more');
	if (!list || !moreWrap) return;

	var moreBtn = moreWrap.querySelector('.u-button-more');

	var updateMoreVisibility = function () {
		if (list.querySelectorAll('.exhibitions-index__item.is-hidden').length === 0) {
			moreWrap.style.display = 'none';
		}
	};

	updateMoreVisibility();

	if (moreBtn) {
		moreBtn.addEventListener('click', function () {
			var hiddenItems = list.querySelectorAll('.exhibitions-index__item.is-hidden');
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
