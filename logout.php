<?php

/**
 * Canae Adoc Light logout page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main.php");

App::requireLogged();

User::logout();

header("Location: " . App::getUrl());

?>
