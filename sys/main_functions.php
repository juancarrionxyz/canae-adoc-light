<?php

/**
 * Canae Adoc Light main functions file
 *
 * @package canae-adoc-light
 */

/**
 * Generate content for HTML title tag
 *
 * @return Current page title combined with app name
 */
function pageTitle() {
	global $adoc_pagetitle, $adoc_appname;
	return $adoc_pagetitle . " – " . $adoc_appname;
}

/**
 * Destroy a PHP session
 *
 * @param $session Name of the PHP session to destroy
 */
function destroySession($session) {
	if (isset($_SESSION[$session])) {
		$_SESSION[$session] = null;
		unset($_SESSION[$session]);
	}
}

/**
 * Generate a random md5 unique code
 *
 * @param $length Length of the code to be generated
 *
 * @return Generated code
 */
function getUniqueCode($length = "") {
	$code = md5(uniqid(rand(), true));
	if ($length != "") {
		return substr($code, 0, $length);
	} else{
		return $code;
	}
}

/**
 * Generate a random md5 unique string from a plain text
 *
 * @param $text Source text
 * @param $salt Optional salt
 *
 * @return Generated string
 */
function generateHash($text, $salt = null) {
	if ($salt === null) {
		$salt = substr(md5(uniqid(rand(), true)), 0, 25);
	} else {
		$salt = substr($salt, 0, 25);
	}
	return $salt . sha1($salt . $text);
}

/**
 * Generate and echo errors and successes (result) block
 */
function resultBlock() {
	global $adoc_errors, $adoc_successes;
	$level = 0;
	if(count($adoc_errors) > 0) {
		echo "<div>";
		foreach($adoc_errors as $error) {
			echo '<div><p>'.$error.'</p></div>';
			$level++;
		}
		echo "</div>";
	}
	if(count($adoc_successes) > 0) {
		echo "<div>";
		foreach($adoc_successes as $success) {
			echo '<div><p>'.$success.'</p></div>';
			$level++;
		}
		echo "</div>";
	}
}

?>
