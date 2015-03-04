/* ==============================================
jQuery
=============================================== */
$(document).ready(function () {
	
	"use strict";
	
	// ascensor initialize
	//$('#ascensor').ascensor({ascensorMap: [[1,1],[0,0],[0,1],[0,2],[1,2],[1,0],[2,0],[2,1],[10,10]]});					 // Ascensor
	//$('#ascensor').ascensor({ascensorMap: [[1,1],[0,0],[0,1],[0,2],[1,2],[1,0],[2,0],[2,1],[2,2]], queued: true});	// Ascensor Queued
	$('#ascensor').ascensor({ascensorMap: [[1,1],[1,0],[0,1],[1,2],[2,1],[0,0],[0,2],[2,2],[2,0]]}); 					// Horizontal
	//$('#ascensor').ascensor({ascensorMap: [[0,0],[1,0],[2,0],[3,0],[4,0],[5,0],[6,0],[7,0],[8,0]]});					// Vertical
	
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

});

/* ==============================================
Load Modules
=============================================== */
loadModules = function(){
	var list = $("#grid");
    list.empty();
    $(document).bind('ajaxStart', function(){
	    $(".load.Mod").show();
	}).bind('ajaxStop', function(){
	    $(".load.Mod").hide();
	});
        $.ajax({
            type: "POST",
            url: "modules",
            success:function(modules)
            {
                list.append(modules);
                list.mixitup();
                $("#grid li a ").each(function() { 
					$(this).hoverdir(); 
				});


				$("#newForm").submit(function(e){
	                e.preventDefault();
	                var $form = $(this); 
	                var errors = document.getElementsByClassName('float_form')

				    for (var i = 0; i < errors.length; i++){
				        errors[i].style.display = 'none';
				    }
	                $.ajax({
	                    type: "POST",
	                    url : $form.attr("action"),
	                    data : {modData: $form.serialize()},
	                    headers: {
					        'X-CSRF-Token': $('input[name="_token"]').val()
					    }
	                })
					.done(function(data){
						if(data.fail){
							$.each(data.errors, function( index, value ) {
						        var errorDiv = $('#newForm #'+index+'_Errors');
						        errorDiv.empty();
						        errorDiv.append('<i class="fa fa-times-circle"></i>'+value);
						        errorDiv.show();
						    });
					      $('#successMessage').empty();    
						} else {
							$('#newMod .close').click(); //hiding form

							setTimeout(function() { loadModules(); }, 1000);
							
						}
					});

        		});
            }
        });

}

$( ".electiveRegister" ).submit(function() {
	// Prevent default action.
	event.preventDefault();
	
	// Get form.
    var form = $(this);
    
    // Get the electiveId
    var electiveId = form.find('#electiveId').val();
    
    console.log(electiveId);
    
    return;
});

/* ==============================================
Loading
=============================================== */
$(window).load(function(){
	"use strict";
	jQuery('#loading').fadeOut(1000);
	loadModules();
});
