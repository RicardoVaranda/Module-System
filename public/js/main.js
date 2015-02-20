/* ==============================================
Google Map
=============================================== */
function initialize() {
	
	"use strict";
	
	var mapProp = {
  		center:new google.maps.LatLng(40.758440, -73.985186), 		// <- Your LatLng
  		zoom:16,
		scrollwheel: false,
  		mapTypeId:google.maps.MapTypeId.ROADMAP
  	};
	var map = new google.maps.Map(document.getElementById("map"),mapProp);
}
//google.maps.event.addDomListener(window, 'load', initialize);

/* ==============================================
jQuery
=============================================== */
$(document).ready(function () {
	
	"use strict";
	
	// ascensor initialize
	//$('#ascensor').ascensor({ascensorMap: [[1,1],[0,0],[0,1],[0,2],[1,2],[1,0],[2,0],[2,1],[10,10]]});					 // Ascensor
	//$('#ascensor').ascensor({ascensorMap: [[1,1],[0,0],[0,1],[0,2],[1,2],[1,0],[2,0],[2,1],[2,2]], queued: true});	// Ascensor Queued
	$('#ascensor').ascensor({ascensorMap: [[1,1],[1,0],[0,1],[1,2],[1,2],[0,5],[0,6],[0,7],[0,8]]}); 					// Horizontal
	//$('#ascensor').ascensor({ascensorMap: [[0,0],[1,0],[2,0],[3,0],[4,0],[5,0],[6,0],[7,0],[8,0]]});					// Vertical
	
	// load tweets
	$(".follow .load-tweets").load("php/twitter.php");
	
	$("[href='#']").click(function(e){
		e.preventDefault();
	});
	
	// show, hide navbar
	$(".tile").click(function(){
		$(".navbar").animate({bottom:0},"slow");
	}); 
	$(".home-link").click(function(){
		$(".navbar").animate({bottom:-50},"slow");
	}); 

	// navbar-callapse close on click
	$('.navbar li a').on('click',function(){
		if ( $('.navbar-collapse').hasClass("in") ) {
			$('.navbar-collapse').collapse('hide');
		}
	})
	
	$("#about-carousel").carousel({interval: 2000});
	
	// portfolio
	$("#grid").mixitup();
	
	// portfolio hover
	$("#grid li a ").each(function() { 
		$(this).hoverdir(); 
	});

	$('.dep').on('change', function() {
	  $("#grid").mixitup('filter', this.value);
	})

	// center box
	function centerBox(){
		
		"use strict";
		
		var wHeight = $(window).height() ;
		$(".section .center-box").each(function() {
			var paddingTop =  $(this).height() ;
			if ( paddingTop < wHeight ) {
				paddingTop = ( wHeight - paddingTop ) / 2;
				$(this).css("padding-top",paddingTop);
			} else {
				$(this).css("padding-top","0");
			}
		});
	};
	
	$(window).resize(function(){
		centerBox();
	}).resize();

	// contact form
	$('input, textarea').placeholder();
	
	/*$('#contactform').submit(function(){
	
		"use strict";
		
		var action = $(this).attr('action');
		
		$("#state-message").slideUp(750,function() {
		$('#state-message').hide();
		
		$.post(action, { 
			name: $('#name').val(),
			email: $('#email').val(),
			message: $('#message').val()
		},
			function(data){
				document.getElementById('state-message').innerHTML = data;
				$('#state-message').slideDown('slow');
				$('#contactform img.loader').fadeOut('slow',function(){$(this).remove()});
				$('#submit').removeAttr('disabled'); 
				if(data.match('success') != null) $('#contactform').slideUp('slow');
			}
		);
		});
		return false; 
	});*/

});

/* ==============================================
Testimonials
=============================================== */

jQuery(function( $ ){
	
	"use strict";
	
	var randomnumber, quoteclass, author, timeout;
	
	startTestimonials();
	
	$('.client .photos ul li').hover( function(){

		window.clearTimeout(timeout);
		
		$('.client .photos ul li.active').removeClass('active');
		
		quoteclass = $(this).attr('class');
		
		author = $(this).find('img').attr('alt');
		author = author.split('-');
		author = author[0] + '<span> - ' + author[1] + '</span>';
		
		$('.client .quotes ul li.active').fadeOut('slow', function(){
			$(this).removeClass('active');
			$('.client .quotes ul li.' + quoteclass).fadeIn().addClass('active');
			$('.client .photos .author').html(author);
		});
		
		$(this).addClass('active');
		
	}, function(){
		timeout = window.setTimeout( startTestimonials, 5000 );
		return false;
	});
	
	function startTestimonials() {
		
		"use strict";
		
		$('.client .photos ul li.active').removeClass('active');
		
		randomnumber = Math.floor( (Math.random()*6) + 1 );
		
		author = $('.client .photos ul li.quote-' + randomnumber).find('img').attr('alt');
		author = author.split('-');
		author = author[0] + '<span> - ' + author[1] + '</span>';
		
		$('.client .quotes ul li.active').fadeOut('slow', function(){
			$(this).removeClass('active');
			$('.client .quotes ul li.quote-' + randomnumber).fadeIn().addClass('active');
			$('.client .photos .author').html(author);
		});
		
		$('.client .photos ul li.quote-' + randomnumber).addClass('active');
		
		timeout = window.setTimeout( startTestimonials, 5000 );
	}
	
});


/* ==============================================
Loading
=============================================== */
$(window).load(function(){
	"use strict";
	jQuery('#loading').fadeOut(1000);
});