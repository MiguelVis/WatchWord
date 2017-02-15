<?php

	// ---------------
	// WatchWord: User
	// ---------------
	
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
	 * User class.
	 */
	class User {
		
		// Global data for user object
		private $data = array();
		
		/**
		 * User Constructor.
		 *
		 * @param user_id        id
		 * @param user_password  password
		 * @param user_data      more data
		 */
		public function __construct($user_id = null, $user_password = null, $user_data = null){
			
			// Id
			$this->setId($user_id);
			
			// Password
			$this->setPassword($user_password);
			
			// Data
			if($user_data !== null) {
				foreach($user_data as $key => $value) {
					$this->setField($key, $value);
				}
			}
		}
		
		/**
		 * Get user id.
		 *
		 * @return  user id
		 */
		public function getId() {
			return $this->getField('id');
		}
		
		/**
		 * Get user password.
		 *
		 * @return  user password
		 */
		public function getPassword() {
			return $this->getField('password');
		}
		
		/**
		 * Get user data field.
		 *
		 * @param  field_name
		 * @return field value if exists, else null
		 */
		public function getField($field_name) {
			if(array_key_exists($field_name, $this->data)) {
				return $this->data[$field_name];
			}
			
			return null;
		}
		
		/**
		 * Set user id.
		 *
		 * @user_id  user id
		 */
		public function setId($user_id) {
			$this->setField('id', $user_id);
		}
		
		/**
		 * Set user password.
		 *
		 * @param  user_password
		 */
		public function setPassword($user_password) {
			$this->setField('password', $user_password);
		}
		
		/**
		 * Set user data field.
		 *
		 * @param  field_name
		 * @param  field_value
		 */		 
		public function setField($field_name, $field_value) {
			if($field_value === null) {
				$field_value = '';
			}
			
			$this->data[$field_name] = trim($field_value);
		}
		
		/**
		 * Get user object.
		 *
		 * @param   user_id
		 * @return  user object, or null on failure
		 */
		public static function get($user_id) {
			$input = WatchWord::readUser($user_id);
			
			if($input !== null) {
				$user = new User();
				
				foreach($input as $key => $value) {
					$user->setField($key, $value);
				}
				
				return $user;
			}
			
			return null;
		}
		
		/**
		 * Get list of user ids.
		 *
		 * @return array of user ids, or null on failure
		 */
		public static function getIdList() {
			return WatchWord::getUserIdList();
		}
		
		/**
		 * Update user data.
		 *
		 * @return true on success, or false on failure, or null on error
		 */
		public function update() {
			return WatchWord::writeUser($this->data);
		}
		
		/**
		 * Check if user exists.
		 *
		 * @return true if user exists, or false if not exists, or null on error
		 */
		public static function exists($user_id) {
			return WatchWord::userExists($user_id);
		}
		
		/**
		 * Delete user.
		 *
		 * @return true on success, or false on failure, or null on error
		 */
		public static function delete($user_id) {
			return WatchWord::deleteUser($user_id);
		}
	}
?>