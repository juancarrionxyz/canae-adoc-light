<?php
/**
 * Canae Adoc Light user functions file
 *
 * @package canae-adoc-light
 */
 
class User {
	 /**
	  * Inserts a user to the database and returns inserted user's id
	  *
	  * @param $user_name
	  * @param $user_email
	  * @param $user_password
	  *
	  * @return Inserted user's id
	  */
	public static function create($user_name, $user_email, $user_password) {
		global $adoc_db, $adoc_db_prefix;
		$user_name = utf8_decode($user_name);
		$user_email = utf8_decode($user_email);
		$statement = $adoc_db->prepare("INSERT INTO " . $adoc_db_prefix . "users (user_name, user_email, user_password) VALUES (?, ?, ?)");
		$statement->bind_param("sss", $user_name, $user_email, $user_password);
		$statement->execute();
		$statement->close();
		return $adoc_db->insert_id;
	}

	/**
	 * Checks if a user is logged in
	 *
	 * @return boolean True if the user is logged in, else false
	 *
	 */
	public static function isLoggedIn() {
		global $loggedInUser, $adoc_db, $adoc_db_prefix;
		if ($loggedInUser == null) {
			return false;
		} else {
			$statement = $adoc_db->prepare("SELECT user_id, user_password FROM " . $adoc_db_prefix . "users WHERE user_id = ? AND user_password = ? LIMIT 1");
			$statement->bind_param("is", $loggedInUser->user_id, $loggedInUser->user_password);
			$statement->execute();
			$statement->store_result();
			if($statement->num_rows > 0) {
				$statement->close();
				return true;
			} else {
				$statement->close();
				destroySession("canae_adoc_user");
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
		$statement = $dbs->prepare("SELECT user_id FROM " . $adoc_db_prefix . "users WHERE iser_id = ? LIMIT 1");
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
	 * @pre User id exists in the table
	 *
	 * @param integer $uid User id to retrieve information of
	 *
	 * @return array() Array containing user data fields retrieved
	 */
	function getData($uid) {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("SELECT user_id, user_name, user_email, user_password FROM " . $adoc_db_prefix . "users WHERE user_id = ? LIMIT 1");
		$statement->bind_param("i", $user_id);
		$statement->execute();
		$statement->bind_result($result_user_id, $result_user_name, $result_user_email, $result_user_password);
		while($statement->fetch()) {
			$row = array("user_id" => $result_user_id, "user_name" => utf8_encode($result_user_name), "user_email" => utf8_encode($result_user_email), "user_password" => $result_user_password);
		}
		$statement->close();
		return $row;
	}
	
	/**
	 * Retrieves all users' information from the database
	 *
	 * @pre At least one user exists in the table
	 *
	 * @return array() Array containing arrays containing user data fields retrieved
	 */
	function getAllData() {
		global $adoc_db, $adoc_db_prefix;
		$statement = $adoc_db->prepare("SELECT user_id, user_name, user_email, user_password FROM " . $adoc_db_prefix . "users");
		$statement->execute();
		$statement->bind_result($result_user_id, $result_user_name, $result_user_email, $result_user_password);
		while($statement->fetch()) {
			$rows[$result_user_id] = array("user_id" => $result_user_id, "user_name" => utf8_encode($result_user_name), "user_email" => utf8_encode($result_user_email), "user_password" => utf8_encode($result_user_password));
		}
		$statement->close();
		return $rows;
	}
	
	/**
	 * Retrieves user id by specified user email address
	 *
	 * @pre There is a user with the given email address
	 *
	 * @param string $user_email User email address to look for
	 *
	 * @result integer User id corresponding to the specified user email address
	 */
	function idByEmail($user_email) {
		global $adoc_db, $adoc_db_prefix;
		$statement = $dbs->prepare("SELECT user_id FROM " . $adoc_db_prefix . "users WHERE user_email = ? LIMIT 1");
		$statement->bind_param("s", $user_email);
		$statement->execute();
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
	 * @pre There is a user with the given user id
	 *
	 * @param integer $user_id Id of the user to update
	 * @param string $user_name New user name for the user
	 * @param string $user_email New user email address for the user
	 *
	 * @return Statement execution result
	 */
	function update($user_id, $user_name, $user_email) {
		global $adoc_db, $adoc_db_prefix;
		$user_name = utf8_decode($user_name);
		$user_email = utf8_decode($user_email);
		$statement = $adoc_db->prepare("UPDATE " . $adoc_db_prefix . "users SET user_name = ?, user_email = ? WHERE user_id = ?");
		$statement->bind_param("ssi", $user_name, $user_email, $user_id);
		$result = $statement->execute();
		$statement->close();
		return $result;
	}

	/**
	 * Updates a user's password in the database
	 *
	 * @pre There is a user with the given user id
	 *
	 * @param integer $user_id Id of the user to update
	 * @param string $user_password New (hashed) password for the user
	 *
	 * @return Statement execution result
	 */
	function updatePassword($user_id, $user_password) {
		global $adoc_db, $adoc_db_prefix;
		$statement = $dbs->prepare("UPDATE " . $adoc_db_prefix . "users SET user_password = ? WHERE user_id = ?");
		$statement->bind_param("si", $user_password, $user_id);
		$result = $statement->execute();
		$statement->close();
		return $result;
	}
}

?>
