<?php

/**
 * Canae Adoc Light logged in user functions file
 *
 * @package canae-adoc-light
 */

class loggedInUser {
	/**
	 * User id (number)
	 */
	private $user_id;
	
	/**
	 * User (full) name
	 */
	private $user_name;
	
	/**
	 * User email address
	 */
	private $user_email;
	
	/**
	 * User password (hashed)
	 */
	private $user_password;
	
	function __construct($user_data) {
		$this->user_id = $user_data["user_id"];
		$this->user_name = $user_data["user_name"];
		$this->user_email = $user_data["user_email"];
		$this->user_password = $user_data["user_password"];
	}
	
	public function getUserId() {
		return $this->user_id;
	}
	
	public function getUserName() {
		return $this->user_name;
	}
	
	public function getUserEmail() {
		return $this->user_Email;
	}
	
	public function getUserPassword() {
		return $this->user_password;
	}

	public function logout() {
		destroySession("canae_adoc_user");
	}
}

?>
