/* ==============================================
jQuery
=============================================== */
$(document).ready(function () {
	
	"use strict";
	//Controls the navigation
	$('#ascensor').ascensor({ascensorMap: [[1,1],[1,0],[0,1],[1,2],[2,1],[0,0],[0,2],[2,2],[2,0]]}); 					// Horizontal
	
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
	  	// Release Button.
		form.find('button').prop('disabled', false);
	});
    
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
	  	// Release Button.
		form.find('button').prop('disabled', false);
	});
    
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

    // Lock Button.
	form.find('button').prop('disabled', true);

	// Ask user if they are sure they want to remove student.
	var confirmation = confirm("Do you want to remove the student from your class?");
	if(confirmation) {

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
		  	} else {
		  		$('#classleft').val($('#classleft').val()+1);
		  		$('#student'+studentId).remove();
		  		alert(response.errors);
		  	}
		  	// Release Button.
			form.find('button').prop('disabled', false);
		  });
	} else {
		// Release Button.
			form.find('button').prop('disabled', false);
	}
});


$( document ).on('submit', '#createLecturer', function() {
	// Prevent default action.
	event.preventDefault();
	
	// Get form.
    var form = $(this);

     // Disable button to prevent further clicks.
    form.find('button').prop('disabled', true);

    // Get the lecturer details.
    var lecturerName = form.find('#lecturerName').val();
    var lecturerId = form.find('#lecturerId').val();
    var lecturerEmail = form.find('#lecturerEmail').val();

    console.log("create");

    $.post( "account/create-lecturer", {
					name: lecturerName,
					username: lecturerId,
					email: lecturerEmail})
	.done(function( data ) {
		var response = data;
	  	if(response.success) {
	  		// Add lecturer to lecturer container.
	  		var lecturerObject = '<div class="col-sm-4" id="lecturer'+ response.id +'">'+
										'<div class="feature-box">'+
											'<div class="feature-text">'+
												'<h3>Name: '+ lecturerName +'</h3>'+
												'<p>Lecturer ID: '+ lecturerId +'</p>'+
												'<p>Email: '+ lecturerEmail +'</p>'+
												'<form class="removeLecturer" action="" method="POST">'+
													'<input type="hidden" id="lecturerId" value="'+ response.id +'" />'+
													'<button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i>Remove</button>'+
												'</form>'+
											'</div>'+
										'</div>'+
									'</div>';
  			$('#lecturerContainer').append(lecturerObject);

  			// Reset Form.
  			form.find('#lecturerName').val('');
  			form.find('#lecturerId').val('');
  			form.find('#lecturerEmail').val('');

	  		alert('Lecturer Created Successfully!');
	  	} else {
	  		// Inform user of errors.
	  		//alert(response.errors['email']);
	  		$.each( response.errors, function( key, value ) {
			  alert( value );
			});
	  	}
	  	// Enable button.
    	form.find('button').prop('disabled', false);
	  });
});

$( document ).on('submit', '.removeLecturer', function() {
	// Prevent default action.
	event.preventDefault();
	
	// Get form.
    var form = $(this);
    // Lock Button.
	form.find('button').prop('disabled', true);

	// Ask user if they are sure they want to remove lecturer.
	var confirmation = confirm("Do you want to remove the lecturer?");
	if(confirmation) {

	    // Get the lecturer Id.
	    var lecturerId = form.find('#lecturerId').val();

	    console.log("remove");

	    $.post( "account/remove-lecturer", {
						id: lecturerId})
		.done(function( data ) {
			var response = data;
		  	if(response.success) {
		  		// Remove lecturer.
		  		$('#lecturer'+lecturerId).remove();
		  			
		  		alert('Lecturer Removed Successfully!');
		  	} else {
		  		// Inform user of errors.
		  		alert(response.errors);
		  	}
		  	form.find('button').prop('disabled', false);
		  });

	} else {
		form.find('button').prop('disabled', false);
	}
});

/* ==============================================
Loading
=============================================== */
$(window).load(function(){
	"use strict";
	jQuery('#loading').fadeOut(1000);
});
