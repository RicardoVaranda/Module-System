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
	
	// portfolio
	$("#grid").mixitup();
	
	// portfolio hover
	$("#grid li a ").each(function() { 
		$(this).hoverdir(); 
	});

	$('.dep').on('change', function() {
	  $("#grid").mixitup('filter', this.value);
	});
	$('.elec').on('change', function() {
	  $("#grid.electives").mixitup('filter', this.value);
	});

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
	  		var classBlock = '<div class="col-sm-6 col-md-4 myclass'+electiveId+'"><div class="feature-box">' +
	  							'<div class="feature-icon"><i class="fa fa-twitter"></i></div>'+
	  							'<div class="feature-text"><h3>'+ response.shorttitle +'</h3>'+
	  							'<small style="float:right"><u>'+ response.credits +' Credits</u></small>'+
	  							'<p>'+ response.lecturer +'</p></br></div><form class="electiveUnregister">'+
	  								'<input type="hidden" id="electiveId" value="'+ electiveId +'" />'+
	  								'<button type="submit" class="pull-left btn-elec btn-primary"><i class="fa fa-arrow-right"></i>remove elective</button>'+
	  							'</form><button type="button" class="pull-right btn-elec btn-primary"><i class="fa fa-arrow-right"></i>check timetable</button>'+
	  						 '</div></div>';

	  		// Insert classBlock to myelectives.
	  		$('#myelectives').append(classBlock);

	  		// Inform user.
	  		successMessage("Successfully registered to module!");
	  		
	  		// Replace form with deregister form.
	  		$('#registration'+electiveId).closest('form').removeClass('electiveRegister').addClass('electiveUnregister');
	  		$('#registration'+electiveId).html("Unregister");
	  	} else {
	  		// Inform user of error.
	  		failMessage(response.errors);
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
	  	if(response.success) {
	  		// Remove from myelectives.
	  		var myclass = $('.myclass'+electiveId).remove();


	  		// Inform user.
	  		successMessage("Successfully unregistered from module!");
	  		
	  		// Replace form with deregister form.
	  		$('#registration'+electiveId).closest('form').removeClass('electiveUnregister').addClass('electiveRegister');
	  		$('#registration'+electiveId).html("Register");
	  	} else {
	  		// Inform user of error.
	  		failMessage(response.errors);
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

	  		// Prepare variable to hold all emails.
	  		var emails = '';

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
												'<table border="0px">'+
													'<tbody>'+
														'<tr><td>'+
															'<form class="removeStudent" action="" method="POST">'+
																'<input type="hidden" id="classId" value="'+ classId +'" />'+
																'<input type="hidden" id="studentId" value="'+ student.id +'" />'+
																'<button type="submit" class="btn btn-info pink"><i class="fa fa-arrow-right"></i>Remove</button>'+
															'</form>'+
														'</td><td>'+
															'<a target="_blank" href="https://mail.google.com/mail?view=cm&tf=0%22+&to='+ student.email +'">'+
																'<button class="btn btn-info pink">Email</button>'+
															'</a>'+
														'</td></tr>'+
													'</tbody>'+
												'</table>'+
											'</div>'+
										'</div>'+
									'</div>';
	  			$('#class-students').append(studentObject);

	  			// Store email.
	  			emails = emails + student.email + ',';
	  		}

	  		// Now update email all link.
	  		$('#classAll').attr('href', 'https://mail.google.com/mail?view=cm&tf=0%22+&to='+ emails);
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
	  		successMessage('Class updated successfully!');
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
		  		successMessage('Student Removed Successfully!');
		  	} else {
		  		$('#classleft').val($('#classleft').val()+1);
		  		$('#student'+studentId).remove();
		  		failMessage(response.errors);
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
												'<p>Email:</p><p>'+ lecturerEmail +'</p>'+
												'<form class="removeLecturer" action="" method="POST">'+
													'<input type="hidden" id="lecturerId" value="'+ response.id +'" />'+
													'<button type="submit" class="btn btn-primary"><i class="fa fa-arrow-right"></i>Remove</button>'+
												'</form>'+
											'</div>'+
										'</div>'+
									'</div>';
  			$('#lecturerContainer').append(lecturerObject);

  			// Now let's loop through lecturers and ensure we reset every 3 lecturers.
  			var counter = 0;
  			$('#lecturerContainer > .col-sm-4').each(function(){
  				if(counter === 3) {
  					$(this).addClass("clear");
  					counter = 0;
  				} else {
  					$(this).removeClass("clear");
  					counter++;
  				}
  			});

  			// Now close form.
  			$('#lecturer-close').click();

  			// Reset Form.
  			form.find('#lecturerName').val('');
  			form.find('#lecturerId').val('');
  			form.find('#lecturerEmail').val('');

	  		successMessage('Lecturer Created Successfully!');
	  	} else {
	  		// Inform user of errors.
	  		//alert(response.errors['email']);
	  		$.each( response.errors, function( key, value ) {
	  			/* 
	  			 * Let's check if key is username, and present it as Id instead.
	  			 * This is not ideal solution, but oh well it'll do.
	  			 */
	  			 if(key === 'username') {
	  			 	failMessage(value[0].replace("username", "Id"));
	  			 } else {
	  			 	failMessage(value[0]);
	  			 }
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

	    $.post( "account/remove-lecturer", {
						id: lecturerId})
		.done(function( data ) {
			var response = data;
		  	if(response.success) {
		  		// Remove lecturer.
		  		$('#lecturer'+lecturerId).remove();

		  		// Now let's loop through lecturers and ensure we reset every 3 lecturers.
	  			var counter = 0;
	  			$('#lecturerContainer > .col-sm-4').each(function(){
	  				if(counter === 3) {
	  					$(this).addClass("clear");
	  					counter = 0;
	  				} else {
	  					$(this).removeClass("clear");
	  					counter++;
	  				}
	  			});
		  			
		  		successMessage('Lecturer Removed Successfully!');
		  	} else {
		  		// Inform user of errors.
		  		failMessage(response.errors);
		  	}
		  	form.find('button').prop('disabled', false);
		  });

	} else {
		form.find('button').prop('disabled', false);
	}
});

$( document ).on('submit', '#createUsersCSV', function() {
	// Prevent default action.
	event.preventDefault();
	
	// Get form.
    var form = $(this);
    // Lock Button.
	form.find('button').prop('disabled', true);

	// Get the file to upload.
	var file = form.find('#usersCSV').prop('files');

	var formData = new FormData($(this)[0]);

	$.ajax({
        url: 'account/uploadCSV',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
    		if(data.success) {
    			successMessage("Users created successfully!");
    		} else {
    			// Generate CSV string for download link.
    			var csvString = '';
    			var counter = 0;
    			$.each( data.errors, function( row, col ) {
    				$.each( col, function(key, value) {
    					if(counter === 5) {
    						counter = 0;
    						csvString = csvString + '"' + value + '"\n';
    					} else {
	    					csvString = csvString + '"' + value + '",';
	    					counter++;
	    				}
    				});
    			});
    			// Data URI
            	var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csvString);

            	// Create temporary link to file.
            	var link = '<a href="'+ csvData +'" target="_blank" download="Errors'+ data.filename +'" id="csvDownload">Text</a>';
            	$('body').append(link);
            	$('#csvDownload')[0].click();
            	$('#csvDownload').remove();
            	failMessage("Some users could not be created, please ensure the users in the returned file have a unique Id and Email!");
    		}
  		}
    });

	// Release Button.
	form.find('button').prop('disabled', false);
});

function successMessage(m) {
	// Empty out message.
	$('.message').empty();
	// Check if we are dealing with an array.
	if(m.constructor === Array) {
		$.each(m, function(key, value) {
			message(value, true);
		});
	} else {
		message(m, true);
	}
	// Make message visible.
	$('.message').show();

	// Hide message after 5 seconds.
	setTimeout(function() {
      $('.message').fadeOut();
	}, 5000);

}

function failMessage(m) {
	// Empty out message.
	$('.message').empty();
	// Check if we are dealing with an array.
	if(m.constructor === Array) {
		$.each(m, function(key, value) {
			message(value, false);
		});
	} else {
		message(m, false);
	}
	// Make message visible.
	$('.message').show();

	// Hide message after 5 seconds.
	setTimeout(function() {
      $('.message').fadeOut();
	}, 5000);
}

function message(message, success) {
	if(success) {
		$('.message').append('<div class="message-content success">'+ message +'</div>');
	} else {
		$('.message').append('<div class="message-content fail">'+ message +'</div>');
	}
}

/* ==============================================
Timetables
=============================================== */

var nClass = '1';
var classNum = '<br><div class="form-group"><i class="fa fa-sort-numeric-asc"></i>'+
			'<input type="number" name="classNum" id="numClass"'+
			'class="form-control" placeholder="Classes per Week" min="1" max="6" value="'+ nClass +'"/></div>';

var day = '';
var time = '';
var times = [];

function getClass(day, time)
{
	return '<div id="classTime">' +
			'<select style="width:33.333%;" id="cDay">' +
				'<option ' + ((day == "monday")? "selected=\"selected\"" : "") + ' value="monday">Monday</option>' +
				'<option ' + ((day == "tuesday")? "selected=\"selected\"" : "") + ' value="tuesday">Tuesday</option>' +
				'<option ' + ((day == "wednesday")? "selected=\"selected\"" : "") + ' value="wednesday">Wednesday</option>' +
				'<option ' + ((day == "thursday")? "selected=\"selected\"" : "") + ' value="thursday">Thursday</option>' +
				'<option ' + ((day == "friday")? "selected=\"selected\"" : "") + ' value="friday">Friday</option>' +
			'</select>' +
			'<select style="width:33.333%;" id="cTime">' +
				'<option ' + ((time == "9")? "selected=\"selected\"" : "") + ' value="9">9:00</option>' +
				'<option ' + ((time == "10")? "selected=\"selected\"" : "") + ' value="10">10:00</option>' +
				'<option ' + ((time == "11")? "selected=\"selected\"" : "") + ' value="11">11:00</option>' +
				'<option ' + ((time == "12")? "selected=\"selected\"" : "") + ' value="12">12:00</option>' +
				'<option ' + ((time == "13")? "selected=\"selected\"" : "") + ' value="13">13:00</option>' +
				'<option ' + ((time == "14")? "selected=\"selected\"" : "") + ' value="14">14:00</option>' +
				'<option ' + ((time == "15")? "selected=\"selected\"" : "") + ' value="15">15:00</option>' +
				'<option ' + ((time == "16")? "selected=\"selected\"" : "") + ' value="16">16:00</option>' +
				'<option ' + ((time == "17")? "selected=\"selected\"" : "") + ' value="17">17:00</option>' +
			'</select>' +
			'<input type"text"  style="width:33.333%;" maxlength="5" id="cRoom" placeholder="Room Number"/>'+
			'</div>';
}

var saveTimes = '</br><a data-toggle="modal" class="submit btn '+
				'btn-info btn-block" style="width:25%" role="button" '+
				'id="saveTime">Save Class Times</a>';
				
function getTimes(){
	times.length = 0;
	$("#classTimes").children().each(function() {
		day = $(this).find('#cDay').val();
		time = $(this).find('#cTime').val();
		room = $(this).find('#cRoom').val();
		times.push([day, time, room]);
	});
}
			
			
			
			
function saveButton(){
	$('#classTimes').append(saveTimes);
	$('#saveTime').on("click", function(){
		getTimes();
		for(var i = 0; i < parseInt($('#numClass').val()); i++){
			switch(times[i][0]){
				case 'monday':
					$("#timetable").find("tr:eq( "+ (parseInt(times[i][1])-7)+")").find("td:eq(1)");
				break;
				case 'tuesday':
					$("#timetable").find("tr:eq( "+ (parseInt(times[i][1])-7)+")").find("td:eq(2)"); 
				break;
				case 'wednesday':
					$("#timetable").find("tr:eq( "+ (parseInt(times[i][1])-7)+")").find("td:eq(3)");
				break;
				case 'thursday':
					$("#timetable").find("tr:eq( "+ (parseInt(times[i][1])-7)+")").find("td:eq(4)"); 
				break;
				case 'friday':
					$("#timetable").find("tr:eq( "+ (parseInt(times[i][1])-7)+")").find("td:eq(5)"); 
				break;
			}
		}
	});
}
			
			
$("#loadTT").click(
	function(){
		var opt = $('option[value="'+$('#elective').val()+'"]');
		if(!opt.length){
			alert('Error: No Elective Selected.')
			return;
		}

		$('#numClasses').empty();
		$('#classTimes').empty();
		
		$('#numClasses').append(classNum);
		$('#classTimes').append(getClass());
		$('#numClasses').append(saveButton());
		
		$('#numClass').change(function(){
			getTimes();
			$('#classTimes').empty();
			for(var i = 0 ; i< parseInt($('#numClass').val()); i++){
				if(times[i, 0] == null){
					times.push(['monday', '9', '']);
				}
				
				$('#classTimes').append(getClass(times[i][0], times[i][1], times[i][2]));
			}
			$('#classTimes').append(saveButton());
		});
		
	});
			

/* ==============================================
Loading
=============================================== */
$(window).load(function(){
	"use strict";
	jQuery('#loading').fadeOut(1000);
});
