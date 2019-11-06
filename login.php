<?php

/**
 * Canae Adoc Light login page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main.php");

App::requireNotLogged();

if (! empty($_POST)) {
	$adoc_errors = array();
	$form_email = $_POST["form_email"];
	$form_password = $_POST["form_password"];

	if (! User::emailExists($form_email)) {
		$adoc_errors[] = "La dirección de correo electrónico introducida no pertenece a ningún usuario.";
	} else {
		$user = User::retrieve(User::idByEmail($form_email));
		
		$hashed_password = App::generateHash($form_password, $user->getPassword());
		
		if($hashed_password != $user->getPassword()) {
			$adoc_errors[] = "La contraseña introducida es incorrecta.";
		} else {
			$loggedInUser = $user;
			$_SESSION["canae_adoc_logged_in_user"] = $loggedInUser;

			header("Location: " . App::getUrl());
			die();
		}
	}
}

App::setPageTitle("Iniciar sesión");
App::getThemeHeader();

?>
				<div class="mdl-layout-spacer"></div>
				<div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--4-col">
					<div class="mdl-card__supporting-text">
						<h3 class="adoc-login-page__app-title">Canae Adoc Light</h3>
						<p><img src="<?php echo App::getUrl(); ?>/thm/aboutme-scene.png"></p>
						<p>Bienvenido a la aplicación de documentación de asambleas de Canae Confederación Estatal de Asociaciones de Estudiantes, <strong>Adoc Light</strong>.</p>
						<p>Para obtener o recuperar tus credenciales, contacta con la persona de referencia de la organización.</p>
					</div>
				</div>
				<div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--4-col">
					<div class="mdl-card__supporting-text">
						<form action="<?php echo App::getUrl(); ?>/login.php" method="post">
							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield">
									<input class="mdl-textfield__input" name="form_email" required="required" type="email" id="form_email"/>
									<label class="mdl-textfield__label" for="form_email">Dirección de correo electrónico</label>
								</div>
							</div>
							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield">
									<input class="mdl-textfield__input" name="form_password" required="required" type="password" id="form_password"/>
									<label class="mdl-textfield__label" for="form_password">Contraseña</label>
								</div>
							</div>
							<div class="adoc-form__row">
								<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit">Iniciar sesión</button>
							</div>
						</form>
					</div>
				</div>
				<div class="mdl-layout-spacer"></div>
<?php

App::getThemeFooter();

?>
