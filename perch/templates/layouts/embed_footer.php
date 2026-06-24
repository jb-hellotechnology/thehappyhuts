	<script src="/assets/js/slick.min.js" type="text/javascript"></script>
	<script>
		$('a.menu').click(function(){
			$(this).toggleClass('active');
			$('nav ul').toggleClass('show');
		})
		$(document).ready(function(){
			$('.testimonials .slider').slick({
			  dots: false,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 1,
			  adaptiveHeight: true,
			  arrows:true,
			  prevArrow: '#testimonialPrev',
			  nextArrow: '#testimonialNext'
			});
			$('.extras .items').slick({
			  dots: false,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 1,
			  adaptiveHeight: true,
			  arrows:true,
			  prevArrow: '#extraPrev',
			  nextArrow: '#extraNext'
			});
			$('.gallery.circle').slick({
			  dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 5,
			  slidesToScroll: 1,
			  arrows:true,
			  prevArrow: '#galleryPrev',
			  nextArrow: '#galleryNext',
			  responsive: [
			    {
			      breakpoint: 1024,
			      settings: {
			        slidesToShow: 4,
			        slidesToScroll: 4,
			        infinite: true,
			        dots: true
			      }
			    },
			    {
			      breakpoint: 600,
			      settings: {
			        slidesToShow: 3,
			        slidesToScroll: 3
			      }
			    },
			    {
			      breakpoint: 480,
			      settings: {
			        slidesToShow: 2,
			        slidesToScroll: 2
			      }
			    }
			  ]
			});
			$('.gallery.rectangle').slick({
			  dots: true,
			  infinite: true,
			  speed: 300,
			  slidesToShow: 1,
			  slidesToScroll: 1,
			  arrows:true,
			  prevArrow: '#galleryPrev',
			  nextArrow: '#galleryNext',
			  centerMode: true,
			  variableWidth: true,
			});
		})
	</script>

</body>
</html>