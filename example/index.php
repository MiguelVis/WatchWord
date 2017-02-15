<?php

	// ---------------------
	// Example for WatchWord
	// ---------------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	
	require_once('includes.php');
	
	if(array_key_exists('user_id', $_POST) && array_key_exists('user_password', $_POST) && Session::getSessionId() == null) {
		$user_id       = trim($_POST['user_id']);
		$user_password = trim($_POST['user_password']);

		if($user_id !== '') {
			Session::login($user_id, $user_password);	
		}
	}

	if(Session::getSessionId() !== null) {
		header('Location: logged.php');
	}
	else {
?>


<!DOCTYPE html>
<html>

	<head>
		<title>Login Example</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
	</head>
	
	<body>

		<div class="w3-container">
		
			<h2>WatchWord</h2>
			<h3>Login Example</h3>

		  <div id="id01" class="w3-modal" style="display:block">
			<div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
		  
			  <div class="w3-center"><br>
				<img src="http://www.w3schools.com/w3images/avatar3.png" alt="Avatar" style="width:20%" class="w3-circle w3-margin-top">
			  </div>

			  <form class="w3-container" method="post" action="#">
				<div class="w3-section">
				  <label><b>User Id</b></label>
				  <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter User Id" name="user_id" required>
				  <label><b>Password</b></label>
				  <input class="w3-input w3-border" type="text" placeholder="Enter Password" name="user_password" required>
				  <button class="w3-btn-block w3-green w3-section w3-padding" type="submit">Login</button>
				  <input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Remember me
				</div>
			  </form>

			  <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>
			  </div>

			</div>
		  </div>
		</div>
            
	</body>
</html>

<?php
	}
?>
