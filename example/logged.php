<?php

	// ---------------------
	// Example for WatchWord
	// ---------------------
	
	require_once('includes.php');
	
	if(Session::getSessionId() == null) {
		header('Location: index.php');
	}
	else {
		// Load data from current logged user
		$user_id      = Session::getUserId();
		$user_name    = User::get($user_id)->getField('name');
		$user_role_id = User::get($user_id)->getField('role');
		
		// Load roles id list
		$roles_id_list = WatchWord::getRoleIdList();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Logged Example</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
		<!--link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway"-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
			html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
		</style>
	</head>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-container w3-top w3-black w3-large w3-padding" style="z-index:4">
  <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-right">TheCheapTrip Co.&nbsp;<i class="fa fa-plane fa-fw" style="color:yellow"></i></span>
</div>

<!-- Sidenav/menu -->
<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="http://www.w3schools.com/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8">
      <span>Welcome, <strong><?php echo($user_name); ?></strong></span>
	  <br>
      <a href="#" class="w3-hover-none w3-hover-text-yellow w3-show-inline-block">
		<p class="w3-tooltip">
			<i class="fa fa-envelope"></i>
			<span style="position:absolute;left:1em;top:3em" class="w3-text w3-tag w3-small w3-gray">Email</span>
		</p>
	  </a>
      <a href="#" class="w3-hover-none w3-hover-text-green w3-show-inline-block">
		<p class="w3-tooltip">
			<i class="fa fa-user"></i>
			<span style="position:absolute;left:1em;top:3em" class="w3-text w3-tag w3-small w3-gray">Profile</span>
		</p>
	  </a>
      <a href="#" class="w3-hover-none w3-hover-text-blue w3-show-inline-block">
		<p class="w3-tooltip">
			<i class="fa fa-cog"></i>
			<span style="position:absolute;left:1em;top:3em" class="w3-text w3-tag w3-small w3-gray">Settings</span>
		</p>
	  </a>
	  <a href="logout.php" class="w3-hover-none w3-hover-text-red w3-show-inline-block">
		<p class="w3-tooltip">
			<i class="fa fa-power-off"></i>
			<span style="position:absolute;left:1em;top:3em" class="w3-text w3-tag w3-small w3-gray">Logout</span>
		</p>
	  </a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
  <a href="#" class="w3-padding"><i class="fa fa-eye fa-fw"></i>  Overview</a>
  <a href="#section_messages" class="w3-padding"><i class="fa fa-comment fa-fw"></i>  Messages</a>
  <a href="#section_stats" class="w3-padding"><i class="fa fa-line-chart fa-fw"></i>  Stats</a>
  <a href="#section_countries" class="w3-padding"><i class="fa fa-globe fa-fw"></i>  Countries</a>
<?php
	// Only Admin users can see Users section --------
	if($user_role_id == 'Admin') {
?>
  <a href="#section_users" class="w3-padding"><i class="fa fa-users fa-fw"></i>  Users</a>
<?php
	}
	// -----------------------------------------------
?>
  <br>
  <br>
</nav>

<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>52</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Messages</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-line-chart w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>99</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Stats</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-globe w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>18</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Countries</h4>
      </div>
    </div>
<?php
	// Only Admin users can see Users section --------
	if($user_role_id == 'Admin') {
?>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php echo(count(User::getIdList())); ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Users</h4>
      </div>
    </div>
<?php
	}
	// -----------------------------------------------
?>
  </div>
  
  <div class="w3-container w3-section">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
        <h5>Regions</h5>
        <img src="http://www.w3schools.com/w3images/region.jpg" style="width:100%" alt="Google Regional Map">
      </div>
      <div class="w3-twothird">
        <h5>Feeds</h5>
        <table class="w3-table w3-striped w3-white">
          <tr>
            <td><i class="fa fa-user w3-blue w3-padding-tiny"></i></td>
            <td>New record, over 90 views.</td>
            <td><i>10 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bell w3-red w3-padding-tiny"></i></td>
            <td>Database error.</td>
            <td><i>15 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-users w3-orange w3-text-white w3-padding-tiny"></i></td>
            <td>New record, over 40 users.</td>
            <td><i>17 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-comment w3-red w3-padding-tiny"></i></td>
            <td>New comments.</td>
            <td><i>25 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bookmark w3-light-blue w3-padding-tiny"></i></td>
            <td>Check transactions.</td>
            <td><i>28 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-laptop w3-red w3-padding-tiny"></i></td>
            <td>CPU overload.</td>
            <td><i>35 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-share-alt w3-green w3-padding-tiny"></i></td>
            <td>New shares.</td>
            <td><i>39 mins</i></td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <hr>
  
  <!-- ################################################### -->
  
  <div class="w3-container" id="section_messages">
    <h5>Messages</h5>
    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="http://www.w3schools.com/w3images/avatar3.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>John <span class="w3-opacity w3-medium">Sep 29, 2014, 9:12 PM</span></h4>
        <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>

    <div class="w3-row">
      <div class="w3-col m2 text-center">
        <img class="w3-circle" src="http://www.w3schools.com/w3images/avatar1.png" style="width:96px;height:96px">
      </div>
      <div class="w3-col m10 w3-container">
        <h4>Bo <span class="w3-opacity w3-medium">Sep 28, 2014, 10:15 PM</span></h4>
        <p>Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p><br>
      </div>
    </div>
  </div>
  <br>
  
  <!-- ################################################### -->
  
  <div class="w3-container" id="section_stats">
    <h5>Stats</h5>
    <p>New Visitors</p>
    <div class="w3-progress-container w3-grey">
      <div id="myBar" class="w3-progressbar w3-green" style="width:25%">
        <div class="w3-center w3-text-white">+25%</div>
      </div>
    </div>

    <p>New Users</p>
    <div class="w3-progress-container w3-grey">
      <div id="myBar" class="w3-progressbar w3-orange" style="width:50%">
        <div class="w3-center w3-text-white">50%</div>
      </div>
    </div>

    <p>Bounce Rate</p>
    <div class="w3-progress-container w3-grey">
      <div id="myBar" class="w3-progressbar w3-red" style="width:75%">
        <div class="w3-center w3-text-white">75%</div>
      </div>
    </div>
  </div>
  <hr>
  
  <!-- ################################################### -->

  <div class="w3-container" id="section_countries">
    <h5>Countries</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white w3-card-4">
		<thead>
			<tr class="w3-blue">
				<th>Country</th>
				<th>Sales</th>
			</tr>
		</thead>
      <tr>
        <td>United States</td>
        <td>65%</td>
      </tr>
      <tr>
        <td>UK</td>
        <td>15.7%</td>
      </tr>
      <tr>
        <td>Russia</td>
        <td>5.6%</td>
      </tr>
      <tr>
        <td>Spain</td>
        <td>2.1%</td>
      </tr>
      <tr>
        <td>India</td>
        <td>1.9%</td>
      </tr>
      <tr>
        <td>France</td>
        <td>1.5%</td>
      </tr>
    </table>
	<br>

  </div>
  <hr>
  
  <!-- ################################################### -->
  
<?php
	// Only Admin users can see Users section --------
	if($user_role_id == 'Admin') {
?>
  <div class="w3-container" id="section_users">
    <h5>
		Users
		<button class="w3-btn w3-small w3-right w3-green" onclick="document.getElementById('modal_add_user').style.display='block'">
			<strong><i class="fa fa-plus-square-o"></i></strong>&nbsp;&nbsp;Add user
		</button>
	</h5>
    <table class="w3-table w3-striped w3-bordered w3-border w3-hoverable w3-white w3-card-4">
		<thead>
			<tr class="w3-blue">
				<th>Id</th>
				<th>Name</th>
				<th>Role</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
<?php
		$userIdList = User::getIdList();
	
		if(!count($userIdList)) {
?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
<?php
		}
		else {	
			foreach($userIdList as $userId) {
				$user = User::get($userId);
				
				if($user !== null) {
					$userName = $user->getField('name');
					$userRole = $user->getField('role')
?>
		<tr>
			<td><?php echo($userId); ?></td>
			<td><?php echo($userName); ?></td>
			<td><?php echo($userRole); ?></td>
			<td>
				<i class="w3-hover-none w3-hover-text-blue w3-show-inline-block fa fa-info fa-fw"
					onclick="user_info(<?php echo('\''.$userId.'\',\''.$userName.'\',\''.$userRole.'\''); ?>);"></i>
				<i class="w3-hover-none w3-hover-text-green w3-show-inline-block fa fa-pencil fa-fw"
					onclick="user_edit(<?php echo('\''.$userId.'\',\''.$userName.'\',\''.$userRole.'\''); ?>);"></i>
				<i class="w3-hover-none w3-hover-text-red w3-show-inline-block fa fa-close fa-fw"
					onclick="user_delete('<?php echo($userId); ?>');"></i>
			</td>
		</tr>
<?php
				}
			}
		}
?>
    </table>
	<br>
  </div>
  
  <hr>
  
  <!-- ###################### MODAL: ADD USER ############################# -->
  
  <div id="modal_add_user" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container w3-teal"> 
        <span onclick="document.getElementById('modal_add_user').style.display='none'" class="w3-closebtn">&times;</span>
        <h2>Add User</h2>
      </header>
	  
      <form class="w3-container" method="post" action="do_add_user.php">
        <div class="w3-section">
          <label><b>Email</b></label>
          <input class="w3-input w3-margin-bottom" type="email" placeholder="Enter Email" name="user_id" required>
          <label><b>Password</b></label>
          <input class="w3-input w3-margin-bottom" type="password" placeholder="Enter Password" name="user_password" required>
		  <label><b>Name</b></label>
          <input class="w3-input w3-margin-bottom" type="text" placeholder="Enter Name" name="user_name" required>
		  <label><b>Role</b></label>
		  <select class="w3-select w3-margin-bottom" name="user_role_id" required>
			<option value="" disabled selected>Choose a role</option>
<?php
			foreach($roles_id_list as $role_id) {
				echo('<option value="'.$role_id.'">'.$role_id.'</option>');
			}
?>
		  </select>
		  <hr>
          <button class="w3-btn w3-green" type="submit">Save</button>
		  <button class="w3-btn w3-green" type="button" onclick="document.getElementById('modal_add_user').style.display='none'">Cancel</button>
        </div>
      </form>
    </div>
  </div>
  
  <!-- ###################### MODAL: EDIT USER ############################# -->
  
  <div id="modal_edit_user" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container w3-teal"> 
        <span onclick="document.getElementById('modal_edit_user').style.display='none'" class="w3-closebtn">&times;</span>
        <h2>Edit User</h2>
      </header>
	  
      <form class="w3-container" method="post" action="do_edit_user.php">
        <div class="w3-section">
          <label><b>Email</b></label>
          <input class="w3-input w3-margin-bottom" type="email" placeholder="" id="modal_edit_user_id" value="" disabled>
		  <input class="" type="hidden" placeholder="" id="modal_edit_user_id_hidden" name="user_id" value="">
          <label><b>Password</b></label>
          <input class="w3-input w3-margin-bottom" type="password" placeholder="" id="modal_edit_user_password" name="user_password" value="">
		  <label><b>Name</b></label>
          <input class="w3-input w3-margin-bottom" type="text" placeholder="" id="modal_edit_user_name" name="user_name" value="" required>
		  <label><b>Role</b></label>
		  <select class="w3-select w3-margin-bottom" id="modal_edit_user_role_id" name="user_role_id" required>
			<option value="" disabled selected>Choose a role</option>
<?php
			foreach($roles_id_list as $role_id) {
				echo('<option value="'.$role_id.'">'.$role_id.'</option>');
			}
?>
		  </select>
		  <hr>
          <button class="w3-btn w3-green" type="submit">Update</button>
		  <button class="w3-btn w3-green" type="button" onclick="document.getElementById('modal_edit_user').style.display='none'">Cancel</button>
        </div>
      </form>
    </div>
  </div>
  
  <!-- ###################### MODAL: USER INFO ############################# -->
  
  <div id="modal_user_info" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container w3-teal"> 
        <span onclick="document.getElementById('modal_user_info').style.display='none'" class="w3-closebtn">&times;</span>
        <h2>User Info</h2>
      </header>
	  
      <form class="w3-container" method="post" action="">
        <div class="w3-section">
          <label><b>Email</b></label>
          <input class="w3-input w3-margin-bottom" type="email" placeholder="" id="modal_user_info_id" disabled>
		  <label><b>Name</b></label>
          <input class="w3-input w3-margin-bottom" type="text" placeholder="" id="modal_user_info_name" disabled>
		  <label><b>Role</b></label>
		  <input class="w3-input w3-margin-bottom" type="text" placeholder="" id="modal_user_info_role_id" disabled>
		  <hr>
		  <button class="w3-btn w3-green" type="button" onclick="document.getElementById('modal_user_info').style.display='none'">Continue</button>
        </div>
      </form>
    </div>
  </div>
  
  <!-- ###################### MODAL: DELETE USER ############################# -->
  
  <div id="modal_delete_user" class="w3-modal">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container w3-teal"> 
        <span onclick="document.getElementById('modal_delete_user').style.display='none'" class="w3-closebtn">&times;</span>
        <h2>Delete User</h2>
      </header>
	  
      <form class="w3-container" method="post" action="do_delete_user.php">
        <div class="w3-section">
			<input class="" type="hidden" id="modal_delete_user_id" name="user_id" value="">
			<p>
				Are you sure do you want to delete the user
				'<b><span id="modal_delete_user_show">x</span></b>'?
			</p> 
			<hr>
          <button class="w3-btn w3-green" type="submit">Delete</button>
		  <button class="w3-btn w3-green" type="button" onclick="document.getElementById('modal_delete_user').style.display='none'">Cancel</button>
        </div>
      </form>

	  </div>
  </div>
<?php
	}
	// -----------------------------------------------
?>

	<!-- ################################################### -->

  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-dark-grey">
    <p>Powered by <a href="http://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
  </footer>
  
  <!-- ###################### MODAL: ERROR FROM ACTION ############################# -->

<?php
	if(array_key_exists('error', $_GET)) {
?>
  <div id="modal_show_error" class="w3-modal" style="display: block">
    <div class="w3-modal-content w3-card-8 w3-animate-zoom" style="max-width:600px">
      <header class="w3-container w3-teal"> 
        <span onclick="document.getElementById('modal_show_error').style.display='none'" class="w3-closebtn">&times;</span>
        <h2>Error!</h2>
      </header>
	  
      <div class="w3-container">
        <div class="w3-section">
<?php
		switch($_GET['error']) {
			case 'MISSING_PARAMETERS' :
				$txt = 'Missing parameters';
				break;
			case 'USER_ALREADY_EXISTS' :
				$txt = 'User already exists.';
				break;
			case 'CANT_ADD_USER' :
				$txt = 'Can\'t add user.';
				break;
			case 'CANT_UPDATE_USER' :
				$txt = 'Can\'t update user.';
				break;
			case 'USER_NOT_EXISTS' :
				$txt = 'User does not exists.';
				break;
			case 'CANT_DELETE_USER' :
				$txt = 'Can\'t delete user.';
				break;
			default :
				$txt = 'Unknown error: '.$_GET['error'].'.';
				break;
		}
?>
		  <p><?php echo($txt); ?></p>
		  
		  <hr>
		
		  <button class="w3-btn w3-green" onclick="document.getElementById('modal_show_error').style.display='none'">Continue</button>
        </div>
      </div>
    </div>
  </div>
<?php
	}
?>


  <!-- End page content -->
</div>

<script>
	// Get the Sidenav
	var mySidenav = document.getElementById("mySidenav");

	// Get the DIV with overlay effect
	var overlayBg = document.getElementById("myOverlay");

	// Toggle between showing and hiding the sidenav, and add overlay effect
	function w3_open() {
		if (mySidenav.style.display === 'block') {
			mySidenav.style.display = 'none';
			overlayBg.style.display = "none";
		} else {
			mySidenav.style.display = 'block';
			overlayBg.style.display = "block";
		}
	}

	// Close the sidenav with the close button
	function w3_close() {
		mySidenav.style.display = "none";
		overlayBg.style.display = "none";
	}

<?php
	// Only Admin users can see Users section --------
	if($user_role_id == 'Admin') {
?>	
	// User edit
	function user_edit(user_id, user_name, user_role_id) {
		document.getElementById("modal_edit_user_id").value        = user_id;
		document.getElementById("modal_edit_user_id_hidden").value = user_id;
		document.getElementById("modal_edit_user_name").value      = user_name;
		//document.getElementById("modal_edit_user_role_id").value = user_role_id;
		var selector = document.getElementById("modal_edit_user_role_id");
		var items    = selector.options.length;
		for(i = 0; i < items; ++i) {
			var option = selector.options[i];
			
			if(option.value == user_role_id) {
				option.selected = true;
			}
		}
		document.getElementById('modal_edit_user').style.display = 'block';
	}
	
	// User info
	function user_info(user_id, user_name, user_role_id) {
		document.getElementById("modal_user_info_id").value      = user_id;
		document.getElementById("modal_user_info_name").value    = user_name;
		document.getElementById("modal_user_info_role_id").value = user_role_id;
		document.getElementById('modal_user_info').style.display = 'block';
	}
	
	// User delete
	function user_delete(user_id) {
		document.getElementById("modal_delete_user_id").value       = user_id;
		document.getElementById("modal_delete_user_show").innerHTML = user_id;
		document.getElementById('modal_delete_user').style.display  = 'block';
	}
<?php
	}
	// -----------------------------------
?>
</script>

</body>
</html>

<?php
	}
?>
