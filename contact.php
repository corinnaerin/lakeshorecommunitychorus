<?php 
	
	require ("funcs.php");
	
	if(isset($_POST['name'])) {
		$name = $_POST['name'];
		$email = $_POST['email'];
		$subject = $_POST['subject'];
		$message = $_POST['message'];
		$to="lakeshorecommunitychorus@gmail.com ";
		$body = "From: $name<br>
				Message: $message";
		
		if ($email == "" || $name == "" || $subject == "" || $message == "") {
			$usrMessage = "Please fill in all fields. Thank you.";
		} else {
			if (mail($to,$subject,$body,"MIME-Version: 1.0\nContent-type: text/html; charset=iso-8859-1\nFrom: $email\n")) {
				$usrMessage = "Thank you for contacting the Lakeshore Community Chorus! Your message was sent successfully.";
			} else {
				$usrMessage = "An error occurred while sending the message";
			}
		}
		
		if ( isXHR() ) {
			echo $usrMessage;
			return;
		}
	}
	
	include ('views/contact.tmpl.php');
?>
