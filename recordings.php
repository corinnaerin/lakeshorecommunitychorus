<?php
	include ('funcs.php');
	connect();
	
	$message = "";
	$loginSuccess = false;
	
	if (isset($_POST['username'])) {
		$results = getUserByUsername($_POST['username']);
		
		if ($results == null) {
			$message = "Invalid username.";
		} else {
			$user = $results[0];
			$passwordHash = sha1($_POST['password']);
			
			
			if ($user->password != $passwordHash) {
				$message = "Invalid password.";
			} else {
				$expiration = null;
				$remember = "false";
				if (isset($_POST['remember'])) {
					$expiration =  60 * 60 * 24 * 60 + time();
					$remember = "true";
				}
				
				setcookie('lcc-user-id',$user->user_id);
				setcookie('lcc-username',$user->username, $expiration);
				setcookie('lcc-first-name',$user->first_name, $expiration);
				setcookie('lcc-remember', $remember, $expiration);
				setcookie('lcc-admin', $user->admin);
				$loginSuccess = true;
			}
		}
		
		if ( isXHR() ) {
			echo $message;
			return;
		}
		
	} else if (!isset($_COOKIE['lcc-user-id'])) {
		header("Location: index.php");
	}

	include ('views/recordings.tmpl.php');
?>