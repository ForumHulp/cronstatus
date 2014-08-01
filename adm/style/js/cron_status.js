; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
	time = 60;
	function progress() {
		var element = $('#ProgressStatus');
		if (time === 9) element.css("right", "12px");
		element.html(time);
		if (time === 0) clearInterval(progress);
		time--;
	}
	setInterval(progress, 1000);
})(jQuery, window, document);