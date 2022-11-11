// JavaScript Document


$(document).ready(function() {	

	// Bootstrap 4.X carousel current and total items counter...
	let elCarouselContainer = $('.carousel-container');
    let elCarousel = $('.carousel');
    let elCarouselItem = $('.carousel-item');
    let elCarouselCounter = $('.crsl_slide-counter');

    elCarousel.each(function () {
        let $carousel = $(this);
        let totalItems = $carousel.find(elCarouselItem).length;
		
        /*if (totalItems < 10) {
            totalItems = '0' + totalItems;
        }*/
		
		$carousel.closest( elCarouselContainer ).find(elCarouselCounter).html('1/' + totalItems + '');
        //$carousel.parent().find(elCarouselCounter).html('01/' + totalItems + '');
    });

    elCarousel.on('slid.bs.carousel', function () {
        let $carousel = $(this);
        let currentIndex = $carousel.find('div.active').index() + 1;
        /*if (currentIndex < 10) {
            currentIndex = '0' + currentIndex
        }*/
        let ti = $carousel.find(elCarouselItem).length;
       /* if (ti < 10) {
            ti = '0' + ti;
        }*/
        //$carousel.find(elCarouselCounter).html('' + currentIndex + '/' + ti + '');
		$carousel.closest( elCarouselContainer ).find(elCarouselCounter).html('' + currentIndex + '/' + ti + '');
    });
	
});




/*
$('a').click(function(index) {
  var clone = $(this).clone();
  clone.css('position', 'absolute');
  clone.css('left', $(this).position().left);
  clone.css('top', $(this).position().top);
  $('body').append(clone);

  $(this).hide();
  $(this).text($(this).attr("data-r"));

  clone.fadeOut(500, function() {
    clone.remove();
  });
  $(this).fadeIn(500);
});

*/

