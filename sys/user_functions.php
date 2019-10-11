<?php
/**
 * Canae Adoc Light user functions file
 *
 * @package canae-adoc-light
 */
 
 /**
  * Inserts a user to the database and returns inserted user's id
  *
  * @param $user_name
  * @param $user_email
  * @param $user_password
  *
  * @return Inserted user's id
  */
function UserCreate($user_name, $user_email, $user_password) {
	global $adoc_db, $adoc_db_prefix;
	$user_name = utf8_decode($user_name);
	$statement = $adoc_db->prepare("INSERT INTO " . $adoc_db_prefix . "users (user_name, user_email, user_password) VALUES (?, ?, ?)");
	$statement->bind_param("sss", $user_name, $user_email, $user_password);
	$statement->execute();
	$statement->close();
	return $adoc_db->insert_id;
}

?>
