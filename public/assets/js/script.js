document.addEventListener('DOMContentLoaded', function () {
	var sidebar = document.getElementById('sidebar');
	var toggle = document.getElementById('sidebarToggle');

	if (sidebar && toggle) {
		toggle.addEventListener('click', function () {
			sidebar.classList.toggle('collapsed');
		});
	}

	var bellBtn = document.getElementById('bellBtn');
	var notifDrop = document.getElementById('notifDrop');

	if (bellBtn && notifDrop) {
		bellBtn.addEventListener('click', function (e) {
			e.stopPropagation();
			notifDrop.classList.toggle('open');
		});
		document.addEventListener('click', function (e) {
			if (!bellBtn.contains(e.target) && !notifDrop.contains(e.target)) {
				notifDrop.classList.remove('open');
			}
		});
	}

	document.querySelectorAll('[data-confirm]').forEach(function (link) {
		link.addEventListener('click', function (e) {
			if (!confirm(link.getAttribute('data-confirm'))) {
				e.preventDefault();
			}
		});
	});

	document.querySelectorAll('.banner').forEach(function (banner) {
		setTimeout(function () {
			banner.style.transition = 'opacity 400ms ease';
			banner.style.opacity = '0';
			setTimeout(function () {
				banner.style.display = 'none';
			}, 400);
		}, 4000);
	});
});