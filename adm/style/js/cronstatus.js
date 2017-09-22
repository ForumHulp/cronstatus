; (function ($, window, document) {
	// do stuff here and use $, window and document safely
	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
	'use strict';
	
	$(".cron_run_link").css("display", "none");
	$("#ProgressStatus, #circle, .cron_run").css("display", "block");
	if ($.cookie("neverstarted") == 1)
	{
		$('#never_started').css("display", "table-cell");
	}
	var time = 59;
	function progress() {
		var element = $('#ProgressStatus');
		var circle = $('#circle');
		if (time === 9) {element.css("right", "12px");}
		element.html(time);
		$('#date').text(getISODateTime());
		if (time === 0) {
			clearInterval(interval);
			element.html("");
			circle.removeClass("fa-circle-o-notch");
			circle.addClass("fa-refresh");
			$.ajax({
				url: removeParam('action', window.location.href) + "&table=true",
				context: document.getElementById("cron_table"),
				error: function (e, text) {
					circle.css("display", "none");
					if (text === "timeout") {
						$("#LoadErrorTimeout").css("display", "inline-block");
						$("#LoadError").css("display", "block");
					} else {
						$("#LoadPageError").css("display", "inline-block");
						$("#LoadError").css("display", "block");
					}
				},
				success: function (s) {
					element.css("right", "8px");
					element.html(60);
					time = 59;
					circle.removeClass("fa-refresh");
					circle.addClass("fa-circle-o-notch");
					interval = setInterval(progress, 1000);
					$(this).html(s);
					$('#date').text(getISODateTime());
					$(".cron_run_link").css("display", "none");
					$(".cron_run").bind("click", run_cron);
					$(".cron_now").bind("click", run_now);
					$(".cron_run").css("display", "block");
					$(".cron_now").css("display", "block");
					if ($.cookie("neverstarted") == 1)
					{
						$('#never_started').css("display", "table-cell");
					}
				}
			});
		}
		time--;
	}
	var interval = setInterval(progress, 1000);

	$("a.simpledialog").simpleDialog({
		opacity: 0.1,
		width: '650px',
		closeLabel: '&times;'
	});

	$(document).on("click", "#never_startedbtn", function (e) {
		e.preventDefault();
		if ($('#never_started').css('display') == 'none') {
			$.cookie("neverstarted", 1);
		} else{
			$.cookie("neverstarted", 0);
		}
		$('#never_started').toggle('slow');
	});

	function getISODateTime(d) {
		var s = function(a,b){return(1e15+a+"").slice(-b);};
		if (typeof d === 'undefined') {d = new Date();}
		return  s(d.getDate(),2) + '-' +
				s(d.getMonth()+1,2) + '-' +
				d.getFullYear() + ' ' +
				s(d.getHours(),2) + ':' +
				s(d.getMinutes(),2) + ':' +
				s(d.getSeconds(),2);
	}
	// For immediate display
	$('#date').text(getISODateTime());

	function run_now(event) {
		event.preventDefault();
		$(".cron_run").css("display", "none");
		$(".cron_now").css("display", "none");
		 /*jshint validthis: true */
		var cron_task = this.id;
		$(this).next().css("display", "block");

		$.ajax({
			url: removeParam('action', window.location.href) + "&action=runnow&table=true&cron_type=" + cron_task + "&t=" + time,
			success: function () {
				$("#run_cron_task").attr("src", cron_url + "&cron_type=" + cron_task + "&t=" + time);
				time = 10;
			}
		});
	}
	$(".cron_now").bind("click", run_now);

	function run_cron() {
		$("#run_cron_task").attr("src", cron_url + "&cron_type=" + this.id + "&t=" + time);
		$(".cron_run").css("display", "none");
		$(".cron_now").css("display", "none");
		 /*jshint validthis: true */
		$(this).next().css("display", "block");
		time = 10;
	}
	$(".cron_run").bind("click", run_cron);

	function removeParam(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
		if (queryString !== "") {
			params_arr = queryString.split("&");
			for (var i = params_arr.length - 1; i >= 0; i -= 1) {
				param = params_arr[i].split("=")[0];
				if (param === key) {
					params_arr.splice(i, 1);
				}
			}
			rtn = rtn + "?" + params_arr.join("&");
		}
		return rtn;
	}
})(jQuery, window, document);
