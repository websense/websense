$(function() {
	var localeElements = $('#locale_list li a');
	for(var i = localeElements.length - 1; i >= 0; i--) {
		var localeElement = $(localeElements[i]);
		localeElement.click(function() {
			var locale = this.getAttribute('data-locale');
			$.post('ajax/change_locale.php', {
				locale : locale
			}, function() {
				// Refresh page, so change in locale takes effect.
				location.reload(true);
			})
			return false;
		});
	}
});
