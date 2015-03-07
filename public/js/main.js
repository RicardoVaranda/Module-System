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

$( document ).on('submit', '.electiveRegister', function() {
	// Prevent default action.
	event.preventDefault();
	
	// Get form.
    var form = $(this);
    
    // Disable button to prevent further clicks.
    form.find('button').prop('disabled', true);
    
    // Get the electiveId
    var electiveId = form.find('#electiveId').val();
    
    $.post( "account/register-elective", {
					electiveId: electiveId })
	.done(function( data ) {
		var response = data;
		// TODO: Replace alerts with divs or something.
	  	if(response.success) {
	  		// Inform user.
	  		alert("Successfully registered to module!");
	  		
	  		// Replace form with deregister form.
	  		form.removeClass('electiveRegister').addClass('electiveUnregister');
	  		form.find('button').html("Unregister");
	  	} else {
	  		// Inform user of error.
	  		alert(response.errors);
	  	}
	  	// Update spaces.
	  	$('#elective'+electiveId).html(response.spaces);
	});
	
	// Release Button.
	form.find('button').prop('disabled', false);
    
    return;
});

$( document ).on('submit', '.electiveUnregister', function() {
	// Prevent default action.
	event.preventDefault();
	
	// Get form.
    var form = $(this);
    
    // Disable button to prevent further clicks.
    form.find('button').prop('disabled', true);
    
    // Get the electiveId
    var electiveId = form.find('#electiveId').val();
    
    $.post( "account/unregister-elective", {
					electiveId: electiveId})
	.done(function( data ) {
		var response = data;
		// TODO: Replace alerts with divs or something.
	  	if(response.success) {
	  		// Inform user.
	  		alert("Successfully unregistered from module!");
	  		
	  		// Replace form with deregister form.
	  		form.removeClass('electiveUnregister').addClass('electiveRegister');
	  		form.find('button').html("Register");
	  	} else {
	  		// Inform user of error.
	  		alert(response.errors);
	  	}
	  	// Update spaces.
	  	$('#elective'+electiveId).html(response.spaces);
	});
	
	// Release Button.
	form.find('button').prop('disabled', false);
    
    return;
});

$( document ).on('change', '#class-Select', function() {

	var classId = $(this).val();

	$.post( "account/load-class", {
					classId: classId})
	.done(function( data ) {
		var response = data;
	  	if(response.success) {
	  		// Display class info.
	  		$('#classlimit').val(response.limit);
	  		$('#classleft').val(response.space);
	  		$('#classId').val(classId);

	  		// Display students for class.
	  		$('#class-students').empty();
	  		for(i = 0; i<response.students.length; i++) {
	  			var student = response.students[i];
	  			var studentObject = '<div class="col-sm-4" id="student'+ student.id +'">'+
										'<div class="feature-box">'+
											'<div class="feature-text">'+
												'<h3>Name: '+ student.name +'</h3>'+
												'<p>Student ID: '+ student.username +'</p>'+
												'<p>Major: '+ student.major +'</p>'+
												'<form class="removeStudent" action="" method="POST">'+
													'<input type="hidden" id="classId" value="'+ classId +'" />'+
													'<input type="hidden" id="studentId" value="'+ student.id +'" />'+
													'<button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i>Remove</button>'+
												'</form>'+
											'</div>'+
										'</div>'+
									'</div>';
	  			$('#class-students').append(studentObject);
	  		}
	  	}
	});
});

$( document ).on('submit', '#classForm', function() {
	// Prevent default action.
	event.preventDefault();
	
	// Get form.
    var form = $(this);

    // Get the class Id.
    var classId = form.find('#classId').val();

    // Get the space limit.
    var limit = form.find('#classlimit').val();

    $.post( "account/update-class", {
					classId: classId,
					limit: limit})
	.done(function( data ) {
		var response = data;
	  	if(response.success) {
	  		$('#classleft').val(response.space);
	  		alert('Class updated successfully!');
	  	}

	  });

    });

$( document ).on('submit', '.removeStudent', function() {
	// Prevent default action.
	event.preventDefault();
	
	// Get form.
    var form = $(this);

    // Get the class Id.
    var classId = form.find('#classId').val();

    // Get the student Id.
    var studentId = form.find('#studentId').val();

    $.post( "account/remove-student", {
					classId: classId,
					studentId: studentId})
	.done(function( data ) {
		var response = data;
	  	if(response.success) {
	  		$('#classleft').val(response.space);
	  		$('#student'+studentId).remove();
	  		alert('Student Removed Successfully!');
	  	}

	  });
});

/* ==============================================
Loading
=============================================== */
$(window).load(function(){
	"use strict";
	jQuery('#loading').fadeOut(1000);
});
