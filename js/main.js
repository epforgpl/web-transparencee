$(function() {
	//$('.excerpt').dotdotdot();
	
	
	$('path').tooltip({track: true});
	$('g').tooltip({track: true});
	
	$('.filter-title').on('click',function() {
		$(this).parents('.filter-wrapper').toggleClass('opened');
	});
	
	$('.pb-wrapper').each(function() {
		$(this).children('.excerpt').css({
			'height' : parseInt($(this).height()) - parseInt($(this).children('h3').outerHeight()) - 35 + 'px'
		});
		
		$(this).children('.excerpt').dotdotdot();
	});
	
	$('.filter-list a').each(function() {
		if ($(this).hasClass('current')) {
			$(this).parents('.filter-wrapper').addClass('opened');
			$(this).attr( 'href' , $(this).attr('href').replace( $(this).data('filter'), 'all' ) );
		}
	});
	
	$('.open-filter').on('click', function(e) {
		e.preventDefault();
		$('.all-filter').toggleClass('opened');
		return false;
	});
	
	
	$('.hamburger').on('click', function() {
		if ( $(this).hasClass('open') ) {
			$(this).removeClass('open');
			$('.mobile-overlay').removeClass('open');
		}
		else {
			$(this).addClass('open');
			$('.mobile-overlay').addClass('open');
		}
	});
	
});


$(window).on('load', function() {
	
});