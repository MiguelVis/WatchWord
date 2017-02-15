<?php

	// ---------------------
	// Example for WatchWord
	// ---------------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	
	require_once('includes.php');
	
	if(Session::getSessionId() == null) {
		header('Location: index.php');
	}
	else {
		
		$err = 'MISSING_PARAMETERS';
		
		if(array_key_exists('user_id', $_POST)) {
				
			$user_id = $_POST['user_id'];
				
			if(User::exists($user_id)) {			
				if(User::delete($user_id)) {
					$err = null;
				}
				else {
					$err = 'CANT_DELETE_USER';
				}
			}
			else {
				$err = 'USER_NOT_EXISTS';
			}
		}
		
		$q = ($err !== null ? '?error='.$err : '');
		
		header('Location: logged.php'.$q.'#section_users');
	}
?>