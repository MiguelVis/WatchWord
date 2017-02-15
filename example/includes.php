<?php

	// ---------------------
	// Example for WatchWord
	// ---------------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	
	require_once(dirname(__FILE__) . '/../watchword/watchword.php');
	require_once(dirname(__FILE__) . '/../watchword/role.php');
	require_once(dirname(__FILE__) . '/../watchword/user.php');
	require_once(dirname(__FILE__) . '/../watchword/session.php');
	
	WatchWord::setup(
		array(
			'storage'    => 'text_files',
			'users_path' => dirname(__FILE__).'/../users',
			'roles_path' => dirname(__FILE__).'/../roles'
		)
	);
?>