function progress(percent, $element) {
    var progressBarWidth = percent * $element.width() / 100;
    $element.find('div').animate({ width: progressBarWidth }, 500).html(percent + "%&nbsp;");
	tijd = tijd - 1.7;
}
tijd = 100;
setInterval(function(){progress(tijd, $('#progressBar'))},1000);