<?php
if($_POST) {

	$email_to = "youremail@yourwebsite.com"; 	// <- Your Email Address
	$email_subject = "contact form"; 			// <- Your Email Subject

	$name     = $_POST['name'];
	$email    = $_POST['email'];
	$message  = stripslashes($_POST['message']);
				
	if(trim($name) == '') {
		echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		You must enter your name.</div>";
		exit();
	} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		You have enter an invalid e-mail address, try again.</div>";
		exit();
	} else if(trim($message) == '') {
		echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		Please enter your message.</div>";
		exit();
	}
	
	if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

	$text  = "Name:    $name" . PHP_EOL;
	$text .= "EMAIL:   $email" . PHP_EOL;
	$text .= "MESSAGE: $message". PHP_EOL;

	$title = "You have been contacted by $name " . PHP_EOL . PHP_EOL;
	$content = "$text" . PHP_EOL . PHP_EOL;
	$reply = "You can contact $name via email: $email";

	$text = wordwrap( $title . $content . $reply, 70 );

	$header  = "From: $email" . PHP_EOL;
	$header .= "MIME-Version: 1.0" . PHP_EOL;
	$header .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;

	if ( mail($email_to, $email_subject, $text, $header) ) {
		echo "<fieldset>";			
		echo "<div class='alert alert-success'>";
		echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
		echo "<strong>Sent Successfully.</strong>";
		echo "<p>Thank you $name, your message has been submitted to us.</p>";
		echo "</div>";
		echo "</fieldset>";
	} else {
		echo 'ERROR!';
	}

}

?>