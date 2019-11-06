<?php

/**
 * Canae Adoc Light main functions file
 *
 * @package canae-adoc-light
 */

class App {
	public static function getTitle() {
		global $adoc_app_title;
		return $adoc_app_title;
	}

	public static function getUrl() {
		global $adoc_app_url;
		return $adoc_app_url;
	}

	public static function setPageTitle($page_title) {
		global $adoc_page_title;
		$adoc_page_title = $page_title;
	}

	/**
	 * Generate content for page title heading
	 *
	 * @return Current page title
	 */
	public static function getPageTitle() {
		global $adoc_page_title;
		return $adoc_page_title;
	}

	/**
	 * Generate content for HTML title tag
	 *
	 * @return Current page title combined with app name
	 */
	public static function getHtmlTitle() {
		global $adoc_page_title, $adoc_app_title;
		return $adoc_page_title . " – " . $adoc_app_title;
	}

	public static function requireLogged() {
		global $adoc_app_url;
		if (! User::isLoggedIn()) {
			header("Location: " . $adoc_app_url . "/login.php");
			die();
		}
	}

	public static function requireNotLogged() {
		global $adoc_app_url;
		if (User::isLoggedIn()) {
			header("Location: " . $adoc_app_url . "/index.php");
			die();
		}
	}

	public static function requireAdmin() {
		global $adoc_app_url, $loggedInUser;
		if (! User::isLoggedIn()) {
			header("Location: " . $adoc_app_url . "/login.php"); /* #TODO Show reason of redirection */
			die();
		}

		if (! $loggedInUser->isAdmin()) {
			header("Location: " . $adoc_app_url . "/index.php"); // #TODO Show reason of redirection
			die();
		}
	}

	/**
	 * Enqueues an error message to the global errors array
	 */
	public static function enqueueError($error) {
		global $adoc_errors;
		$adoc_errors[] = $error;
	}

	/**
	 * Enqueues a success message to the global errors array
	 */
	public static function enqueueSuccess($success) {
		global $adoc_successes;
		$adoc_successes[] = $success;
	}

	/**
	 * Checks if there are any success messages enqueued
	 */
	public static function emptySuccesses() {
		global $adoc_successes;
		return empty($adoc_successes);
	}

	/**
	 * Checks if there are any error messages enqueued
	 */
	public static function emptyErrors() {
		global $adoc_errors;
		return empty($adoc_errors);
	}

	/**
	 * Require theme header
	 */
	public static function getThemeHeader() {
		global $adoc_app_path, $loggedInUser;
		require_once($adoc_app_path . "/thm/header.php");
	}

	/**
	 * Require theme footer
	 */
	public static function getThemeFooter() {
		global $adoc_app_path, $loggedInUser;
		require_once($adoc_app_path . "/thm/footer.php");
	}

	/**
	 * Generate and echo errors and successes (result) block
	 */
	public static function resultBlock() {
		global $adoc_errors, $adoc_successes;
		if (count($adoc_errors) > 0 || count($adoc_successes) > 0) {
			echo '<div class="mdl-grid adoc-result-block"><div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col"><div class="mdl-card__supporting-text">';
			if(count($adoc_errors) > 0) {
				echo "<div>";
				foreach($adoc_errors as $error) {
					echo '<div><p>'.$error.'</p></div>';
				}
				echo "</div>";
			}
			if(count($adoc_successes) > 0) {
				echo "<div>";
				foreach($adoc_successes as $success) {
					echo '<div><p>'.$success.'</p></div>';
				}
				echo "</div>";
			}
			echo '</div></div></div>';
		}
	}

	/**
	 * Destroy a PHP session
	 *
	 * @param $session Name of the PHP session to destroy
	 */
	public static function destroySession($session) {
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
	public static function getUniqueCode($length = "") {
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
	public static function generateHash($text, $salt = null) {
		if ($salt === null) {
			$salt = substr(md5(uniqid(rand(), true)), 0, 25);
		} else {
			$salt = substr($salt, 0, 25);
		}
		return $salt . sha1($salt . $text);
	}
}

?>
