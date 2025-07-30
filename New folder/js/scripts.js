var $ = jQuery;
jQuery(document).ready(function($) {
    jQuery('.menu-open').click(function(){
		jQuery(this).addClass('active');
		jQuery('body').addClass('menu-open');
		jQuery('.mobile-menu-wrap').slideToggle();
	});
	jQuery('.menu-close').click(function(){
		jQuery(this).removeClass('active');
		jQuery('body').removeClass('menu-open');
		jQuery('.mobile-menu-wrap').slideToggle();
	});


	$(".search-form-wrap a").click(function (e) {
		e.preventDefault();
        $(".search-form-sec").slideToggle();
    });

	$('.owl-carousel.events-carousel-home').owlCarousel({
	    loop: false,
	    nav:false,
	    dots:true,
	    navText:[
	    	'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M17 7.18457L1 7.18457M1 7.18457L6.89474 13.1846M1 7.18457L6.89474 1.18457" stroke="black" stroke-width="1.2" stroke-linecap="round"/></svg>','<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M1.00001 7.18457H17M17 7.18457L11.1053 1.18457M17 7.18457L11.1053 13.1846" stroke="black" stroke-width="1.2" stroke-linecap="round"/></svg>'],
	    responsive:{
	        0:{
	            items:1,
	        },
	        768:{
	            items:2,
	    		margin: 20,

	        },
	        1199:{
	    		margin: 40,
	            items:2,
	        }
	    }
	});
	$('.owl-carousel.events-carousel, .owl-carousel.articles-carousel').owlCarousel({
	    loop: false,
	    nav:false,
	    dots:true,
	    navText:[
	    	'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M17 7.18457L1 7.18457M1 7.18457L6.89474 13.1846M1 7.18457L6.89474 1.18457" stroke="black" stroke-width="1.2" stroke-linecap="round"/></svg>','<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M1.00001 7.18457H17M17 7.18457L11.1053 1.18457M17 7.18457L11.1053 13.1846" stroke="black" stroke-width="1.2" stroke-linecap="round"/></svg>'],
	    responsive:{
	        0:{
	            items:1,
	        },
	        768:{
	            items:2,
	    		margin: 20,

	        },
	        1299:{
	    		margin: 30,
	            items:3,
	        }
	    }
	});
	$('.owl-carousel.resources-carousel').owlCarousel({
	    loop: false,
	    margin: 32,
	    nav:false,
	    dots:true,
	    navText:[
	    	'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M17 7.18457L1 7.18457M1 7.18457L6.89474 13.1846M1 7.18457L6.89474 1.18457" stroke="black" stroke-width="1.2" stroke-linecap="round"/></svg>','<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M1.00001 7.18457H17M17 7.18457L11.1053 1.18457M17 7.18457L11.1053 13.1846" stroke="black" stroke-width="1.2" stroke-linecap="round"/></svg>'],
	    responsive:{
	        0:{
	            items:1,
	        },
	        768:{
	            items:3,
	        },
	        992:{
	            items:4
	        },
	        1199:{
	            items:5
	        }
	    }
	});
	$('.owl-carousel.library-Info-carousel').owlCarousel({
	    loop: false,
	    margin: 24,
	    nav:true,
	    dots:true,
	    navText:[
	    	'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M17 7.18457L1 7.18457M1 7.18457L6.89474 13.1846M1 7.18457L6.89474 1.18457" stroke="black" stroke-width="1.2" stroke-linecap="round"/></svg>','<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M1.00001 7.18457H17M17 7.18457L11.1053 1.18457M17 7.18457L11.1053 13.1846" stroke="black" stroke-width="1.2" stroke-linecap="round"/></svg>'],
	    responsive:{
	        0:{
	            items:1,
	        },
	        768:{
	            items:2,
	        },
	        992:{
	            items:3
	        },
	        1199:{
	            items:4
	        }
	    }
	});

	


	function fullWidthCarouselFix() {
		const $container = $('.container');
		const $carouselBlock = $('.partners-block .carousel-block');
		const windowWidth = $(window).width();

		const containerOffset = $container.offset().left; // distance from left of window
		const paddingLeft = parseInt($container.css('padding-left')) || 0;
		const paddingRight = parseInt($container.css('padding-right')) || 0;

		// Total offset = offset from left plus any internal padding
		const totalLeftOffset = containerOffset + paddingLeft;
		const totalRightOffset = containerOffset + paddingRight;

		$('.partners-block .carousel-block').css({
			'margin-left': -totalLeftOffset + 'px',
			'margin-right': -totalRightOffset + 'px',
		});
	}


	fullWidthCarouselFix();
	$(window).on('resize', fullWidthCarouselFix);

	$('.owl-carousel.partners-carousel').owlCarousel({
	    loop: true,
		autoplay: true,
	    nav:false,
	    dots:false,
	    navText:[
	    	'<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M17 7.18457L1 7.18457M1 7.18457L6.89474 13.1846M1 7.18457L6.89474 1.18457" stroke="black" stroke-width="1.2" stroke-linecap="round"/></svg>','<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M1.00001 7.18457H17M17 7.18457L11.1053 1.18457M17 7.18457L11.1053 13.1846" stroke="black" stroke-width="1.2" stroke-linecap="round"/></svg>'],
	    responsive: {
			0: {
				items: 1,
				margin: 50,
				stagePadding: 100
			},
			768: {
				items: 2,
				margin: 50,
				stagePadding: 100
			},
			992: {
				items: 4,
	    		margin: 50,
				stagePadding: 100
			},
			1400: {
				items: 5,
	    		margin: 100,
				stagePadding: 200
			}
		}
	});



	$('.mobile-menu .menu-item-has-children > a').append('<span class="nav-toggle-icon"></span>');

	$('.nav-toggle-icon').click(function(e) {
		e.preventDefault();
		var clickedMenuItem 	= $(this).closest('.menu-item-has-children');
		var subMenu 			= clickedMenuItem.find('.sub-menu');
		$('.menu-item-has-children').not(clickedMenuItem).removeClass('active').find('.sub-menu').slideUp();
		clickedMenuItem.toggleClass('active');
		subMenu.slideToggle();
	});


	// Calender js

	const calendar = flatpickr("#calendar", {
		inline: true,
		"locale": "pl",
		onDayCreate: function(dObj, dStr, fp, dayElem) {
		const date = dayElem.dateObj.toLocaleDateString('sv-SE');
		if (events.includes(date)) {
			dayElem.classList.add("event-day");
		}
		},
		onReady: function(selectedDates, dateStr, instance) {
		createCustomHeader(instance);
		},
		onMonthChange: function(selectedDates, dateStr, instance) {
		updateCustomMonthLabel(instance);
		},
		onYearChange: function(selectedDates, dateStr, instance) {
		updateCustomMonthLabel(instance);
		}
	});
	function createCustomHeader(fp) {
		const oldHeader = document.querySelector(".custom-month-header");
		if (oldHeader) oldHeader.remove();
		const header = document.createElement("div");
		header.className = "custom-month-header";
		const prev = document.createElement("span");
		prev.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M17 7.18457L1 7.18457M1 7.18457L6.89474 13.1846M1 7.18457L6.89474 1.18457" stroke="white" stroke-width="1.2" stroke-linecap="round"/></svg>';
		prev.addEventListener("click", () => fp.changeMonth(-1));
		const label = document.createElement("span");
		label.className = "custom-month-label";
		label.textContent = getMonthYear(fp);
		const next = document.createElement("span");
		next.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none"><path d="M1.00001 7.18457H17M17 7.18457L11.1053 1.18457M17 7.18457L11.1053 13.1846" stroke="white" stroke-width="1.2" stroke-linecap="round"/></svg>';
		next.addEventListener("click", () => fp.changeMonth(1));
		header.appendChild(prev);
		header.appendChild(label);
		header.appendChild(next);
		fp.calendarContainer.insertBefore(header, fp.calendarContainer.firstChild);
	}
	function updateCustomMonthLabel(fp) {
		const label = document.querySelector(".custom-month-label");
		if (label) {
		label.textContent = getMonthYear(fp);
		}
	}
	function getMonthYear(fp) {
		const month = fp.l10n.months.longhand[fp.currentMonth];
		return `${month} ${fp.currentYear}`;
	}
	$("#reset-calendar").on("click", function () {
		calendar.clear();
		calendar.setDate(null);
		calendar.jumpToDate(new Date());
		updateCustomMonthLabel(calendar);
	});
	

  	// Forms validations
  	$('.needs-validation').submit(function(event) {
	    if (!this.checkValidity()) {
	      event.preventDefault();
	      event.stopPropagation();
	    }
	    $(this).addClass('was-validated');
  	});
	
	if ($.fancybox) {
		$('[data-fancybox="gallery"]').fancybox({
			buttons: [
				"close"
			],
			defaultType: false,
			infobar : false,
			caption : function( instance, item ) {
				var caption = $(this).data('caption') || '';
				return ( caption.length ? caption + '<br />' : '' ) + 'zdjęcie <span data-fancybox-index></span> z <span data-fancybox-count></span>';
			}
			
		});
	}


	

    $( "ol.wp-block-list" ).each(function() {
	  	var   val=1;
	    if ( $(this).attr("start")){
	  		val =  $(this).attr("start");
	    }
	  	val=val-1;
	 	val= 'li '+ val;
		$(this ).css('counter-increment',val );
	});







});
