<?php

	require_once('watchword.php');
	require_once('role.php');
	require_once('user.php');
	
	WatchWord::setup(
		array(
			'storage'    => 'text_files',
			'users_path' => 'C:\\xampp\\htdocs\\oop',
			'roles_path' => 'C:\\xampp\\htdocs\\oop'
		)
	);
	
	function print_user($user)
	{
		echo('========>'.'<br>');
		echo($user -> getId().'<br>');
		echo($user -> getPassword().'<br>');
		echo($user -> getField('age').'<br>');
		echo($user -> getField('role').'<br>');
		print_r(Role::get($user -> getField('role'))->getPerms());
		echo('<br>'.'<========'.'<br>');
	}
	
	$user = new User('Elvis');
	
	$roleKing = new Role('King', array('read', 'write'));
	$roleKing->update();
	
	$user->setPassword('Graceland');
	
	$user->setField('age', 42);
	$user->setField('role', $roleKing->getId());
	
	print_user($user);
	
	if($user -> update()) {
		echo('User save OK'.'<br>');
	}
	else {
		echo('User save FAILED'.'<br>');
	}
	
	$user -> setPassword('1977');
	
	if($user -> update()) {
		echo('User save OK'.'<br>');
	}
	else {
		echo('User save FAILED'.'<br>');
	}
	
	$user = User::get('Elvis');
	
	if($user !== null) {
		echo('User load OK'.'<br>');
	}
	else {
		echo('User load FAILED'.'<br>');
	}
	
	print_user($user);

?>