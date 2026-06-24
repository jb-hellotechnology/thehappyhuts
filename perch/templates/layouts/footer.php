	<footer>
		<p>&copy; <?php echo date('Y'); ?> The Happy Huts | Built by <a href="https://jackbarber.co.uk">Jack</a></p>
	</footer>
	<div style="display:block;width:0px;height:0px;overflow: hidden;">
	<p>Built by <a href="https://jackbarber.co.uk" title="Website designer in Whitby, North Yorkshire">Jack Barber</a> in <a href="https://whit.by" title="Whitby, North Yorkshire">Whitby, North Yorkshire</a>. Visit Herbal Apothecary for <a href="https://herbalapothecaryuk.com" title="Herbal Practitioner Supplies, Manufacturer of Produdcts for Herbalists">herbal practitioner supplies</a>, Sweet Cecily's for <a href="https://sweetcecilys.com" title="Natural and Ethically Produced Skincare Products">natural skincare</a>, BeeVital for <a href="https://beevitalpropolis.com" title="Propolis Health Products">propolis health supplements</a> and Future Health Store for <a href="https://futurehealthstore.com" title="Whole Foods, Health Supplements, Natural and Ethical Gifts">whole foods, health supplements, natural &amp; ethical gifts</a>.</p>
</div>
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
	

<!-- Matomo -->
<script type="text/javascript">
  var _paq = window._paq = window._paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="https://analytics.natureslaboratory.co.uk/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '8']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->


</body>
</html>