(function($) {

	//$("input").tagsinput('items');

	"use strict";

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	$('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
  });

})(jQuery);

$(document).ready(function(){
    $('.slickSlider').slick({
        slidesToShow: 1,
        infinite: true,
        arrows: true,
    });
    $(".menuIcon").click(function(e){
        e.preventDefault();
        $(".menu").toggleClass("active");
        $(".menuIcon").toggleClass("active");
    });
  });
