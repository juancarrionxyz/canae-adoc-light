<?php

/**
 * Canae Adoc Light setup file
 *
 * @package canae-adoc-light
 */

/**
 * Enable error display
 */
ini_set('display_errors', 'On');
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/**
 * Set timezone
 */
date_default_timezone_set("Europe/Madrid");
setlocale(LC_ALL,"es_ES");

/**
 * Database configuration
 */
$adoc_db_host = "localhost";
$adoc_db_user = "inventario";
$adoc_db_password = "DL4GZDmMwLtRfeBUby95kkpBJFTwUmUbrSmdK9zw";
$adoc_db_name = "canae_adoc_light";
$adoc_db_prefix = "adoc_";

/**
 * Initialize lobals
 */
$adoc_page_title = null;
$adoc_app_title = "Canae Adoc Light";
$adoc_app_url = "https://adoc.asambleacanae.es"; /* Do not add trailing slash */
$adoc_app_path = "C:\inetpub\wwwroot\adoc.asambleacanae.es"; /* Do not add trailing slash */
$adoc_dir_separator = "\\";
$adoc_app_upload_dir = "upl"; /* Do not add trailing slash */
$adoc_errors = array();
$adoc_successes = array();
$adoc_db = new mysqli($adoc_db_host, $adoc_db_user, $adoc_db_password, $adoc_db_name);

if ($adoc_db->connect_error) {
	trigger_error('Database connection failed: '  . $dbs->connect_error, E_USER_ERROR);
}

/**
 * Require additional functions and classes
 */
require_once($adoc_app_path . "/sys/class.app.php");
require_once($adoc_app_path . "/sys/class.document.php");
require_once($adoc_app_path . "/sys/class.user.php");

/**
 * PHP session
 */
session_start();

if(isset($_SESSION["canae_adoc_logged_in_user"]) && is_object($_SESSION["canae_adoc_logged_in_user"])) {
	$loggedInUser = $_SESSION["canae_adoc_logged_in_user"];
}

?>
