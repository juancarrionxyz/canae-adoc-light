<?php

/**
 * Canae Adoc Light user functions file
 *
 * @package canae-adoc-light
 */
 
class User {
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
	
	/**
	 * User is admin (boolean)
	 */
	private $user_is_admin;
	
	function __construct($user_id, $user_name, $user_email, $user_password, $user_is_admin) {
		$this->user_id = $user_id;
		$this->user_name = $user_name;
		$this->user_email = $user_email;
		$this->user_password = $user_password;
		$this->user_is_admin = $user_is_admin;
	}
	
	public function getId() {
		return $this->user_id;
	}
	
	public function getName() {
		return $this->user_name;
	}
	
	public function getEmail() {
		return $this->user_email;
	}
	
	public function getPassword() {
		return $this->user_password;
	}
	
	public function isAdmin() {
		return $this->user_is_admin == 1;
	}

	public static function logout() {
		App::destroySession("canae_adoc_logged_in_user");
	}

	/**
	 * Inserts a user to the database and returns inserted user's id
	 *
	 * @param $user_name
	 * @param $user_email
	 * @param $user_password
	 *
	 * @return Inserted user's id
	 */
	public static function create($user_name, $user_email, $user_password, $user_is_admin) {
		global $adoc_db, $adoc_db_prefix;
		$user_name = ($user_name);
		$user_email = ($user_email);
		$statement = $adoc_db->prepare("INSERT INTO " . $adoc_db_prefix . "users (user_name, user_email, user_password, user_is_admin) VALUES (?, ?, ?, ?)");
		$statement->bind_param("sssi", $user_name, $user_email, $user_password, $user_is_admin);
		$statement->execute();
		$result_id = $adoc_db->insert_id;
		$statement->close();
		return $result_id;
	}

	/**
	 * Deletes a user from the database
	 *
	 * @requires Specified user id exists in the database
	 *
	 * @param integer $user_id Id of the user to delete
	 *
	 * @return Statement execution result
	 */
	public static function delete($user_id) {
		global $adoc_db, $adoc_db_prefix;

		$statement = $adoc_db->prepare("DELETE FROM " . $adoc_db_prefix . "users WHERE user_id = ?");
		$statement->bind_param("i", $user_id);
		$statement->execute();
		$statement->close();
	}

	/**
	 * Checks if a user is logged in
	 *
	 * @return boolean True if the user is logged in, else false
	 */
	public static function isLoggedIn() {
		global $loggedInUser, $adoc_db, $adoc_db_prefix;
		if ($loggedInUser == null) {
			return false;
		} else {
			$param_user_name = ($loggedInUser->user_name);
			$param_user_email = ($loggedInUser->user_email);

			$statement = $adoc_db->prepare("SELECT user_id FROM " . $adoc_db_prefix . "users WHERE user_id = ? AND user_name = ? AND user_email = ? AND user_password = ? AND user_is_admin = ? LIMIT 1");
			$statement->bind_param("isssi", $loggedInUser->user_id, $param_user_name, $param_user_email, $loggedInUser->user_password, $loggedInUser->user_is_admin);
			$statement->execute();
			$statement->store_result();
			
			if ($statement->num_rows > 0) {
				$statement->close();
				return true;
			} else {
				$statement->close();
				App::destroySession("canae_adoc_logged_in_user");
				return false;
			}
		}
	}

	/**
	 * Checks if there is a user with a specific id
	 *
	 * @param integer $user_id User id to check
	 *
	 * @return boolean True if there is a user with the specified id, else false
	 */
	public static function idExists($user_id) {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("SELECT user_id FROM " . $adoc_db_prefix . "users WHERE user_id = ? LIMIT 1");
		$statement->bind_param("i", $user_id);
		$statement->execute();
		$statement->store_result();
		if($statement->num_rows > 0) {
			return true;
		} else {
			return false;
		}
		$statement->free_result();
		$statement->close();
	}
	
	/**
	 * Checks if there is a user with a specified email address
	 *
	 * @param string $user_email User email address to check
	 *
	 * @return boolean True if there is a user with the specified email address, else false
	 */
	public static function emailExists($user_email) {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("SELECT user_id FROM " . $adoc_db_prefix . "users WHERE user_email = ? LIMIT 1");
		$statement->bind_param("s", $user_email);
		$statement->execute();
		$statement->store_result();
		if($statement->num_rows > 0) {
			return true;
		} else {
			return false;
		}
		$statement->free_result();
		$statement->close();
	}
	
	/**
	 * Retrieves a user's information from the database
	 *
	 * @requires User id exists in the table
	 *
	 * @param integer $uid User id to retrieve information of
	 *
	 * @return array() Array containing user data fields retrieved
	 */
	public static function retrieve($user_id) {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("SELECT user_id, user_name, user_email, user_password, user_is_admin FROM " . $adoc_db_prefix . "users WHERE user_id = ? LIMIT 1");
		$statement->bind_param("i", $user_id);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($result_user_id, $result_user_name, $result_user_email, $result_user_password, $result_user_is_admin);
		while($statement->fetch()) {
			$row = new User($result_user_id, ($result_user_name), ($result_user_email), $result_user_password, $result_user_is_admin);
		}
		$statement->close();
		return $row;
	}
	
	/**
	 * Retrieves all users' information from the database
	 *
	 * @requires At least one user exists in the table
	 *
	 * @return array() Array containing arrays containing user data fields retrieved
	 */
	public static function getAll() {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("SELECT user_id, user_name, user_email, user_password, user_is_admin FROM " . $adoc_db_prefix . "users");
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($result_user_id, $result_user_name, $result_user_email, $result_user_password, $result_user_is_admin);
		while($statement->fetch()) {
			$rows[$result_user_id] = new User($result_user_id, ($result_user_name), ($result_user_email), ($result_user_password), $result_user_is_admin);
		}
		$statement->close();
		return $rows;
	}
	
	/**
	 * Retrieves user id by specified user email address
	 *
	 * @requires There is a user with the given email address
	 *
	 * @param string $user_email User email address to look for
	 *
	 * @return integer User id corresponding to the specified user email address
	 */
	public static function idByEmail($user_email) {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("SELECT user_id FROM " . $adoc_db_prefix . "users WHERE user_email = ? LIMIT 1");
		$statement->bind_param("s", $user_email);
		$statement->execute();
		$statement->store_result();
		$statement->bind_result($result_user_id);
		$return_user_id = null;
		while($statement->fetch()) {
			$return_user_id = $result_user_id;
		}
		$statement->close();
		return $return_user_id;
	}

	/**
	 * Updates a user's information in the database
	 *
	 * @requires There is a user with the given user id
	 *
	 * @param integer $user_id Id of the user to update
	 * @param string $user_name New user name for the user
	 * @param string $user_email New user email address for the user
	 *
	 * @return Statement execution result
	 */
	public static function update($user_id, $user_name, $user_email, $user_is_admin) {
		global $adoc_db, $adoc_db_prefix;
		$user_name = ($user_name);
		$user_email = ($user_email);
		$statement = $adoc_db->prepare("UPDATE " . $adoc_db_prefix . "users SET user_name = ?, user_email = ?, user_is_admin = ? WHERE user_id = ?");
		$statement->bind_param("ssii", $user_name, $user_email, $user_is_admin, $user_id);
		$result = $statement->execute();
		$statement->close();
		return $result;
	}

	/**
	 * Updates a user's password in the database
	 *
	 * @requires There is a user with the given user id
	 *
	 * @param integer $user_id Id of the user to update
	 * @param string $user_password New (hashed) password for the user
	 *
	 * @return Statement execution result
	 */
	public static function updatePassword($user_id, $user_password) {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("UPDATE " . $adoc_db_prefix . "users SET user_password = ? WHERE user_id = ?");
		$statement->bind_param("si", $user_password, $user_id);
		$result = $statement->execute();
		$statement->close();
		return $result;
	}
}

?>
