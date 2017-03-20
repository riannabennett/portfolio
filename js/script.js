$(document).ready(function(){
	
	//mixItUp Portfolio
	$('.portfolio').mixItUp();
	
	$('#portfolio .inner-portfolio .portfolio .mix').hover(
		function(){
			$(this).find('.inner-item').fadeIn( "fast" );
		}, 
		function(){
			$(this).find('.inner-item').fadeOut( "fast" );
		});
		
	//half
	var width = ($(".text").width() / 2);
	var height = ($(".text").height() / 2);
	$(".text").css({
		'margin-top': -height+'px'	
	});

});