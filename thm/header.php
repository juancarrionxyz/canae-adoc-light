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
		<title><?php echo App::getHtmlTitle(); ?></title>
		<!-- <meta name="description" content=""> -->
		<!-- <meta name="author" content=""> -->
		
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1">
		<meta name="theme-color" content="#551a8b">

		<!-- Styles and fonts -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.purple-green.min.css">
		<link href="https://fonts.googleapis.com/css?family=Ubuntu:400,700&display=swap" rel="stylesheet">
		<link href="<?php echo App::getUrl(); ?>/thm/main_styles.css?v=0.000<?php echo time(); ?>" rel="stylesheet">
		
		<!-- Scripts -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
		<script src="<?php echo App::getUrl(); ?>/thm/main_scripts.js"></script>
	</head>
	<body>
		
		<div class="adoc-layout mdl-layout mdl-js-layout <?php if (User::isLoggedIn()) { ?>mdl-layout--fixed-drawer<?php } ?> mdl-layout--fixed-header">
			<header class="adoc-header mdl-layout__header mdl-color-text--grey-600">
				<div class="mdl-layout__header-row">
					<span class="mdl-layout-title"><?php echo App::getPageTitle(); ?></span>
					<div class="mdl-layout-spacer"></div>
					<!--button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
						<i class="material-icons">more_vert</i>
					</button>
					<ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
						<li class="mdl-menu__item">About</li>
						<li class="mdl-menu__item">Contact</li>
						<li class="mdl-menu__item">Legal information</li>
					</ul-->
				</div>
			</header>
			<?php if (User::isLoggedIn()) { ?>
			<div class="adoc-drawer mdl-layout__drawer mdl-color--blue-grey-900 mdl-color-text--blue-grey-50">
				
				<header class="adoc-drawer-header">
					
					<img src="<?php echo App::getUrl(); ?>/thm/user.jpg" class="adoc-avatar">
					<div class="adoc-avatar-dropdown"><span><?php echo $loggedInUser->getName(); ?></span></div>
					
				</header>
				
				<div class="adoc-app-title"><span><?php echo App::getTitle(); ?></span></div>

				<nav class="adoc-navigation mdl-navigation mdl-color--blue-grey-800">
					<a class="mdl-navigation__link" href="<?php echo App::getUrl(); ?>/index.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Inicio</a>
					
					<?php if ($loggedInUser->isAdmin()) { ?>
					<hr>
					<a class="mdl-navigation__link" href="<?php echo App::getUrl(); ?>/users.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">group</i>Administrar usuarios</a>
					<?php } ?>

					<hr>
					<a class="mdl-navigation__link" href="<?php echo App::getUrl(); ?>/profile.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">person</i>Mi perfil</a>
					<a class="mdl-navigation__link" href="<?php echo App::getUrl(); ?>/logout.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">exit_to_app</i>Cerrar sesión</a>
				</nav>
			</div>
			<?php } ?>
			<main class="mdl-layout__content mdl-color--grey-100">
				<?php echo App::resultBlock(); ?>
				<div class="mdl-grid adoc-content">
