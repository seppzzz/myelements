// JavaScript Document


$(document).ready(function() {	

	// Bootstrap 4.X carousel current and total items counter...
	let elCarouselContainer = $('.carousel-container');
	let elCarousel = $('.carousel');
	let elCarouselItem = $('.carousel-item');
	let elCarouselCounter = $('.crsl_slide-counter');
	let elCaption = $('.carousel-caption');
	let newCaptionContainer = $('.newCaptionContainer');
	let suffix = true;
	

	elCarousel.each(function () {
		let $carousel = $(this);
		let totalItems = $carousel.find(elCarouselItem).length;
		if(suffix){
		   $carousel.closest( elCarouselContainer ).find(elCarouselCounter).html('1<sup>st</sup>/<span>' + totalItems + '</span>');
		}else{
			$carousel.closest( elCarouselContainer ).find(elCarouselCounter).html('1/' + totalItems + '');
		}
		
  		elCaption.css('display', 'none');
		let currentSlide = $carousel.find('div.active');
		let $caption = currentSlide.find(elCaption).clone();
		let newcaption = $caption.clone();
		$carousel.closest( elCarouselContainer ).find(newCaptionContainer).html(newcaption.html()).fadeIn(1500);	
		
	});

	elCarousel.on('slid.bs.carousel', function () {
		let $carousel = $(this);
		let currentIndex = $carousel.find('div.active').index() + 1;
		let ti = $carousel.find(elCarouselItem).length;
		if(suffix){
			$carousel.closest( elCarouselContainer ).find(elCarouselCounter).html('' + currentIndex + '<sup>' + nth(currentIndex) + '</sup>/<span>' + ti + '</span>');
		}else{
			$carousel.closest( elCarouselContainer ).find(elCarouselCounter).html('' + currentIndex + '/' + ti + '');	
		}
		
		let currentSlide = $carousel.find('div.active');
		let $caption = currentSlide.find(elCaption).clone();
		let newcaption = $caption.clone();
		$carousel.closest( elCarouselContainer ).find(newCaptionContainer).html(newcaption.html()).fadeIn(1500);	
		
	});
	
	
	
	function nth(n){
		return ["st","nd","rd"][((n+90)%100-10)%10-1]||"th";
	}
	
	function ordinal_suffix_of(i) {
		var j = i % 10,
			k = i % 100;
		if (j == 1 && k != 11) {
			return i + "st";
		}
		if (j == 2 && k != 12) {
			return i + "nd";
		}
		if (j == 3 && k != 13) {
			return i + "rd";
		}
		return i + "th";
	}
	
	
});





