<?php

	// ------------------------
	// WatchWord (Santo y Seña)
	// ------------------------
	
	// (c) 2017 Miguel Garcia / FloppySoftware
	//
	// http://www.floppysoftware.es
	// floppysoftware@gmail.com
	//
	// Released under the GNU Public License v3.
	
	// Revisions:
	// 24 Jan 2017 : mgl : Start.
	
	/**
	 * WatchWord class.
	 */
	class WatchWord {
		
		private static $storage          = 'text_files';
		private static $files_users_path = '.';
		private static $files_roles_path = '.';

		private function __construct(){
			// Nothing
		}
		
		/**
		 * Setup WatchWord environment:
		 * - storage: text_files | json_files
		 * - users_path: path for text_files and json_files (ie: /bin/ww_users)
		 * - roles_path: path for text_files and json_files
		 *
		 * @param options  parameters
		 */
		public static function setup($options) {
			if(array_key_exists('storage', $options)) {
				if($options['storage'] == 'text_files' || $options['storage'] == 'json_files') {
					self::$storage = $options['storage'];
					
					if(array_key_exists('users_path', $options)) {
						self::$files_users_path = trim($options['users_path']);
					}
					
					if(array_key_exists('roles_path', $options)) {
						self::$files_roles_path = trim($options['roles_path']);
					}
				}
			}
			
			session_start();
		}
		
		public static function userExists($user_id) {
			switch(self::$storage) {
				case 'text_files' : // P'abajo
				case 'json_files' : return file_exists(self::$files_users_path.DIRECTORY_SEPARATOR.'user_'.$user_id);
			}
			
			return null;
		}
		
		public static function getUserIdList() {
			switch(self::$storage) {
				case 'text_files' : // P'abajo
				case 'json_files' :
					$files = glob(self::$files_users_path.DIRECTORY_SEPARATOR.'user_*');
					$users = array();
					
					if($files !== false) {
						foreach($files as $fname) {
							$users[] = substr($fname, strpos($fname, 'user_') + 5);
						}
						
						return $users;
					}
					break;
			}
			
			return null;
		}
		
		
		
		public static function readUser($user_id) {
			if($user_id !== null && $user_id != '') {
				return self::readFile(self::$files_users_path.DIRECTORY_SEPARATOR.'user_'.$user_id);
			}
			
			return null;
		}
		
		public static function readRole($role_id) {
			if($role_id !== null && $role_id != '') {
				$input = self::readFile(self::$files_roles_path.DIRECTORY_SEPARATOR.'role_'.$role_id);
				
				if($input !== null) {
					if(self::$storage == 'text_files' && array_key_exists('perms', $input)) {
						$input['perms'] = explode(';', $input['perms']);
					}
					
					return $input;
				}
			}
			
			return null;
		}
		
		private static function readFile($fname) {
			switch(self::$storage) {
				case 'text_files' : return self::readTextFile($fname);
				case 'json_files' : return self::readJsonFile($fname);
			}
			
			return null;
		}
		
		private static function readTextFile($fname) {
			
			if($fname !== null && $fname != '') {
				if(file_exists($fname)) {
					$fh = fopen($fname, 'rt');
					
					if($fh) {
						$rec    = array();
						$lines  = 0;
						$io_err = false;
						
						while(true) {
							$ln = fgets($fh);
				
							if($ln !== false) {
								if($lines < 64 && strpos($ln, '|') !== false) {
									
									$ln    = str_replace("\n", '', $ln);
									$ln    = explode('|', $ln);
									
									$key   = $ln[0];
									$value = $ln[1];
									
									$rec[$key] = $value;

									++$lines;
								}
								else {
									$io_err = true;
									break;
								}
							}
							else {
								if(!feof($fh)) {
									$io_err = true;
								}
								break;
							}
						}
						
						fclose($fh);

						if(!$io_err) {

								// Success
								return $rec;
						}
					}
				}
			}
			
			// Failure
			return null;
		}
		
		private static function readJsonFile($fname) {
			if($fname !== null && $fname != '') {
				if(file_exists($fname)) {
					$file = file_get_contents($fname);
					
					if($file !== false) {
						$json = json_decode($file,true);
						
						if($json !== null) {
							return $json;
						}
					}
				}
			}
			
			// Failure
			return null;
		}
		
		public static function writeUser($user_data) {
			if($user_data !== null && is_array($user_data) && array_key_exists('id', $user_data) && $user_data['id'] != null && $user_data['id'] != '') {
				return self::writeFile(self::$files_users_path.DIRECTORY_SEPARATOR.'user_'.$user_data['id'],
				                     self::$files_users_path.DIRECTORY_SEPARATOR.'user_temp',
									 $user_data);
			}
			
			return null;
		}
		
		public static function writeRole($role_data) {
			if($role_data !== null && is_array($role_data) && array_key_exists('id', $role_data) && $role_data['id'] != null && $role_data['id'] != '') {
				if(self::$storage == 'text_files' && array_key_exists('perms', $role_data)) {
					$role_data['perms'] = implode(';', $role_data['perms']);
				}
				
				return self::writeFile(self::$files_roles_path.DIRECTORY_SEPARATOR.'role_'.$role_data['id'],
				                     self::$files_roles_path.DIRECTORY_SEPARATOR.'role_temp',
									 $role_data);
			}
			
			return null;
		}
		
		private static function writeFile($fname, $ftemp, $data) {
			switch(self::$storage) {
				case 'text_files' : $result = self::writeTextFile($fname, $ftemp, $data);
				                    break;
				case 'json_files' : $result = self::writeJsonFile($fname, $ftemp, $data);
				                    break;
				default           : $result = false;
				                    break;
			}
			
			if($result) {
				if(file_exists($fname)) {
					if(!unlink($fname)) {
						$result = false;
					}
				}
			}
			
			if($result) {
				if(rename($ftemp, $fname)) {
					
					// Success
					return true;
				}
			}
			
			// Failure
			return false;
		}
		
		private static function writeTextFile($fname, $ftemp, $data) {
			
			if($fname !== null && $fname != '' && $fname !== null && $fname != '' && $data !== null && is_array($data)) {			
				$fh     = fopen($ftemp, 'wt');
				$io_err = false;
				
				if($fh) {
					foreach($data as $key => $value) {
						if(!fwrite($fh, $key.'|'.$value."\n")) {
							$io_err = true;
							break;
						}
					}
					
					if(!fclose($fh)) {
						$io_err = true;
					}
					
					if(!$io_err) {
						
						// Success
						return true;
					}
				}
			}
			
			// Failure
			return false;
		}
		
		private static function writeJsonFile($fname, $ftemp, $data) {
			
			if($fname !== null && $fname != '' && $fname !== null && $fname != '' && $data !== null && is_array($data)) {			
				
				$json = json_encode($data);
				
				if($json !== false) {
					$result = file_put_contents($ftemp, $json);
					
					if($result !== false) {

						// Success
						return true;
					}
				}
			}
			
			// Failure
			return false;
		}
		
		public static function deleteUser($user_id) {
			if($user_id !== null && $user_id != '') {
				switch(self::$storage) {
					case 'text_files' : // P'abajo
					case 'json_files' :
						return self::deleteFile(self::$files_users_path.DIRECTORY_SEPARATOR.'user_'.$user_id);
				}
			}
			
			return null;
		}
		
		public static function deleteFile($fname) {
			if(file_exists($fname)) {
				if(unlink($fname)) {
					return true;
				}
			}
			
			return false;
		}
		
		public static function getRoleIdList() {
			switch(self::$storage) {
				case 'text_files' : // P'abajo
				case 'json_files' :
					$files = glob(self::$files_roles_path.DIRECTORY_SEPARATOR.'role_*');
					$roles = array();
					
					if($files !== false) {
						foreach($files as $fname) {
							$roles[] = substr($fname, strpos($fname, 'role_') + 5);
						}
						
						return $roles;
					}
					break;
			}
			
			return null;
		}
	}
	
?>