<?php

	// ------------------
	// WatchWord: Session
	// ------------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU Public License v3.
	
	// Revisions:
	// 24 Jan 2017 : mgl : Start.
	// 06 Feb 2017 : mgl : Documented.
	
	/**
	 * Session class.
	 */
	class Session {
		
		// Globals for session class
		private static $logged_user;
		private static $session_id;
		
		/**
		 * Constructor
		 */
		private function __construct(){
			// Nothing
		}
		
		/**
		 * User login.
		 *
		 * @param  user_id        user id
		 * @param  user_password  user password
		 * @return true on success, or false on failure
		 */
		public static function login($user_id, $user_password) {
			if($user_id !== null && $user_password !== null) {
				$user_id       = trim($user_id);
				$user_password = trim($user_password);
				
				if($user_id !== '') {
					$user = User::get($user_id);
					
					if($user !== null) {
						if($user->getPassword() == $user_password) {
							if(self::$logged_user !== null) {
								self::logout();	
							}
							
							//session_start();
							session_regenerate_id(true); 
													
							self::$logged_user = $user_id;
							self::$session_id  = session_id();
							
							$_SESSION['logged_user'] = self::$logged_user;
							$_SESSION['session_id']  = self::$session_id;
							
							// Success
							return true;
						}
					}
				}
			}
			
			// Failure
			return false;
		}
		
		/**
		 * User logout.
		 */
		public static function logout() {
			$_SESSION = array();
			session_destroy();
			
			self::$logged_user = null;
			self::$session_id  = null;
		}
		
		/**
		 * User re-login.
		 *
		 * @return true on success, or false on failure
		 */		 
		private static function reLogin() {
			if(self::$logged_user == null) {
			
				if(array_key_exists('logged_user', $_SESSION) && array_key_exists('session_id', $_SESSION)) {
					if($_SESSION['session_id'] == session_id()) {
						self::$logged_user = $_SESSION['logged_user'];
						self::$session_id  = $_SESSION['session_id'];
						
						return true;
					}
				}
			}
			
			return false;
		}
		
		/**
		 * Get id of logged user.
		 *
		 * @return user id
		 */
		public static function getUserId() {
			self::reLogin();
			
			return self::$logged_user;
		}
		
		/**
		 * Get session id.
		 *
		 * @return session id
		 */
		public static function getSessionId() {
			self::reLogin();
			
			return self::$session_id;
		}
	}
?>
