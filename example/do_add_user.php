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
		
		if(array_key_exists('user_id', $_POST)
			&& array_key_exists('user_password', $_POST)
			&& array_key_exists('user_name', $_POST)
			&& array_key_exists('user_role_id', $_POST)) {
				
			$user_id       = $_POST['user_id'];
			$user_password = $_POST['user_password'];
			$user_name     = $_POST['user_name'];
			$user_role_id  = $_POST['user_role_id'];
				
			if(!User::exists($user_id)) {
				$user = new User($user_id, $user_password);
				
				$user->setField('name', $user_name);
				$user->setField('role', $user_role_id);
				
				if($user->update()) {
					$err = null;
				}
				else {
					$err = 'CANT_ADD_USER';
				}
			}
			else {
				$err = 'USER_ALREADY_EXISTS';
			}
		}
		
		$q = ($err !== null ? '?error='.$err : '');
		
		header('Location: logged.php'.$q.'#section_users');
	}
?>