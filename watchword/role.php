<?php

	// ---------------
	// WatchWord: Role
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
	 * Role class.
	 */
	class Role {
		
		// Global data for role object
		private $data = array();
		
		/**
		 * Role constructor.
		 *
		 * @param role_id     id
		 * @param role_perms  permissions
		 * @param role_data   more data
		 */
		public function __construct($role_id = null, $role_perms = null, $role_data = null){
			
			// Id
			$this->setId($role_id);
			
			// Permissions
			$this->setPerms($role_perms);
			
			// Data
			if($role_data !== null) {
				foreach($role_data as $key => $value) {
					$this->setField($key, $value);
				}
			}
		}
		
		/**
		 * Get role id.
		 *
		 * @return role id
		 */
		public function getId() {
			return $this->getField('id');
		}
		
		/**
		 * Get role permissions.
		 *
		 * @return role permissions
		 */
		public function getPerms() {
			return $this->getField('perms');
		}
		
		/**
		 * Get role data field.
		 *
		 * @param  field_name  field name
		 * @return field value if exists, else null
		 */
		public function getField($field_name) {
			if(array_key_exists($field_name, $this->data)) {
				return $this->data[$field_name];
			}
			
			return null;
		}
		
		/**
		 * Set role id.
		 *
		 * @param role_id  role id
		 */
		public function setId($role_id) {
			$this->setField('id', $role_id);
		}
		
		/**
		 * Set role permissions.
		 *
		 * @param role_perms  role permissions
		 */
		public function setPerms($role_perms) {
			$this->setField('perms', $role_perms);
		}
		
		/**
		 * Set role data field.
		 *
		 * @param field_name   field name
		 * @param field_value  field value
		 */
		public function setField($field_name, $field_value) {
			if($field_name == 'perms')
			{
				if($field_value === null || !is_array($field_value)) {
					$field_value = array();
				}
				
				$this->data['perms'] = $field_value;
			}
			else
			{
				if($field_value === null) {
					$field_value = '';
				}
				
				$this->data[$field_name] = trim($field_value);
			}
		}
		
		/**
		 * Get role object.
		 *
		 * @param  role_id  role id
		 * @return role object, or null on failure
		 */
		public static function get($role_id) {
			$input = WatchWord::readRole($role_id);
			
			if($input !== null) {
				$role = new Role();
				
				foreach($input as $key => $value) {
					$role->setField($key, $value);
				}
				
				return $role;
			}
			
			return null;
		}
		
		/**
		 * Update role data.
		 *
		 * @return @return true on success, or false on failure, or null on error
		 */
		public function update() {
			return WatchWord::writeRole($this->data);
		}
	}
?>
