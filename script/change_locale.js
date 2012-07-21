$(function() {
	$('#locale_list li a').click(function(){
		var locale = this.getAttribute('data-locale');
		$.post('ajax/change_locale.php', {
			locale : locale
		}, function() {
			// Refresh page, so change in locale takes effect.
			location.reload(true);
		});
		// Stop propagation, don't visit the actual link.
		return false;
	});
});