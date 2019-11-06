<?php

/**
 * Canae Adoc Light document view generator
 *
 * @package canae-adoc-light
 */

require_once("./sys/main.php");

App::requireLogged();

// Check document id

if (! isset($_GET["id"])) {
	die("Need id");
}

$document_id = $_GET["id"];

if (! Document::idExists($document_id)) {
	die("Document does not exist in the database");
}

$d = Document::retrieve($document_id);

// Generate viewable content

header('Content-type: application/pdf');
header('Content-Disposition: download; filename="' . $d->getFileName() . '"');
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($d->getFilePath()));
header('Accept-Ranges: bytes');

@readfile($d->getFilePath());

?>