$(document).ready(function () {
//pagination handling with ajax and laravel for navbar

$('#menubtn').click(function () 
	{
		$('#navbar').toggleClass("sidenavclosed sidenav");
		if ($('#navbar').hasClass('sidenavclosed')) {
			$('#main').removeClass("main");
			$('#main').addClass("mainwide");
		} else {
			$('#main').removeClass("mainwide");
			$('#main').addClass("main");
		}
	});
});

