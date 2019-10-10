<?php

/**
 * Canae Adoc Light setup file
 *
 * @package canae-adoc-light
 */

/* Enable error display */

ini_set('display_errors', 'On');
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/* Set timezone */

date_default_timezone_set("Europe/Madrid");
setlocale(LC_ALL,"es_ES");

/* Database configuration */

$adoc_db_host = "";
$adoc_db_user = "";
$adoc_db_password = "";
$adoc_db_name = "";

/* Globals */

$adoc_pagetitle = null;
$adoc_url = "https://"; /* Do not add trailing slash */
$adoc_path = "C:\"; /* Do not add trailing slash */
$adoc_errors = array();
$adoc_successes = array();
$adoc_db = new mysqli($adoc_db_host, $adoc_db_user, $adoc_db_password, $adoc_db_name);

if ($adoc_db->connect_error) {
	trigger_error('Database connection failed: '  . $dbs->connect_error, E_USER_ERROR);
}

/* Require additional functions and classes */

require_once($adoc_path . "/sys/main_functions.php");
require_once($adoc_path . "/sys/user_classes.php");
require_once($adoc_path . "/sys/user_functions.php");

/* Session */

session_start();

if(isset($_SESSION["canae_adoc_lu"]) && is_object($_SESSION["canae_adoc_lu"])) {
	$loggedInUser = $_SESSION["canae_adoc_lu"];
}

?>
