jQuery(document).ready(function($) {
	var activeSliders = [];
	$(".owl-carousel").each(function() {
        	activeSliders.push($(this).attr("id"));
	});
	for (var i in activeSliders) {
        	var settings = {};
        	var data = $("#" + activeSliders[i]).data('settings').replace(/^/, "{").replace(/$/, "}").replace(/\'/g, "\"").replace(/\s:\s|\s:|:\s|:/g, "\":").replace(/,\n/g, ",\n\"").replace(/\n/g, "").replace(/{/g, "{\"").replace(/}\s,\s|}\s,|},\s|},/g, "},\"");
        	settings = JSON.parse(data);
        	$("#" + activeSliders[i]).owlCarousel(settings);
        	
        };
 });       