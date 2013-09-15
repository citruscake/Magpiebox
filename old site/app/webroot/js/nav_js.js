$(document).ready(function() {

$('.navbar .nav > li > a').hover(function(event) {
		if($(event.target).parent().hasClass('active') == false) {
			//$(event.target).css('background-color', '#428EB3');
			$(event.target).css('background-color', '#A643F5');
			//$(event.target).addClass('mb_nav_gradient');
		}
	},
	function(event) {
	if($(event.target).parent().hasClass('active') == false) {
		$(event.target).animate({
			//"background-color":'#925CBD'
			"background-color":'#1D1D1D'
		}, 150);
	}
});

});