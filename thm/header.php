<?php
/**
 * Canae Adoc Light theme header
 *
 * @package canae-adoc-light
 */
 
 ?><!doctype html>
<html lang="es">
	<head>
		<!-- Meta -->
		<meta charset="utf-8">
		<title><?php echo pageTitle(); ?></title>
		<!-- <meta name="description" content=""> -->
		<!-- <meta name="author" content=""> -->
		
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1">
		<meta name="theme-color" content="#551a8b">

		<!-- Styles and fonts -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700&display=swap" rel="stylesheet">
		<link href="<?php echo $adoc_url; ?>/thm/main_styles.css" rel="stylesheet">
		
		<!-- Scripts -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="<?php echo $adoc_url; ?>/thm/main_scripts.js"></script>
	</head>
	<body>
		<?php echo resultBlock(); ?>
		
		<section id="primary" class="content-area">
			<main id="main" class="site-main">
				<div>
					<h1>Canae Adoc Light</h1>
