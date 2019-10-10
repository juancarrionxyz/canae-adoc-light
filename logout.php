<?php

/**
 * Canae Adoc Light logout page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main_setup.php");

if (uLogged()) {
	$loggedInUser->logout();
}

header("Location: " . $adoc_url);

?>
