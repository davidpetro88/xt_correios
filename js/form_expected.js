function modalShipping() {
	var id = $("#dialog");

	var maskHeight = $(document).height();
	var maskWidth = $(window).width();

	$('#mask').css({
		'width' : maskWidth,
		'height' : maskHeight
	});

	$('#mask').fadeIn(1000);
	$('#mask').fadeTo("slow", 0.8);

	// Get the window height and width
	var winH = $(window).height();
	var winW = $(window).width();

	$(id).css('top', winH / 2 - $(id).height() / 2);
	$(id).css('left', winW / 2 - $(id).width() / 2);

	$(id).fadeIn(2000);
}

$(document).ready(function() {

	$('a[name=modal]').click(function(e) {
		e.preventDefault();

		var id = $(this).attr('href');

		var maskHeight = $(document).height();
		var maskWidth = $(window).width();

		$('#mask').css({
			'width' : maskWidth,
			'height' : maskHeight
		});

		$('#mask').fadeIn(1000);
		$('#mask').fadeTo("slow", 0.8);

		// Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();

		$(id).css('top', winH / 2 - $(id).height() / 2);
		$(id).css('left', winW / 2 - $(id).width() / 2);

		$(id).fadeIn(2000);

	});

	$('.window .close').click(function(e) {
		e.preventDefault();
		$('#mask').hide();
		$('.window').hide();
	});

	$('#mask').click(function() {
		$(this).hide();
		$('.window').hide();
	});

});

function fecha() {
	$('.result-zip-code').hide();
	$('#result-consult-correios').hide();
	$("#loading").hide();

}

function maskZipCode(src, mask) {
	var i = src.value.length;
	var saida = mask.substring(0, 1);
	var texto = mask.substring(i);

	if (texto.substring(0, 1) != saida) {
		src.value += texto.substring(0, 1);
	}
}

var triggers = $(".modalInput").overlay({
	// some mask tweaks suitable for modal dialogs
	mask : {
		color : '#ebecff',
		loadSpeed : 200,
		opacity : 0.9
	},
	closeOnClick : false
});