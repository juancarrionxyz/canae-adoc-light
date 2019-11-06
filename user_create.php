<?php

/**
 * Canae Adoc Light user edit page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main.php");

App::requireAdmin();

if (! empty($_POST)) {
	$user_create_name = $_POST["user_create_name"];
	$user_create_email = $_POST["user_create_email"];
	if (isset($_POST["user_create_is_admin"])) {
		$user_create_is_admin = 1;
	} else {
		$user_create_is_admin = 0;
	}
	$user_create_raw_password = $_POST["user_create_raw_password"];

	if (User::emailExists($user_create_email)) {
		App::enqueueError("Ya existe un usuario con la dirección de correo electrónico especificada.");
	}

	if (App::emptyErrors()) {
		if (User::create($user_create_name, $user_create_email, App::generateHash($user_create_raw_password), $user_create_is_admin)) {
			App::enqueueSuccess("Usuario creado correctamente.");
		} else {
			App::enqueueError("Hubo un problema al creado el usuario.");
		}
	}
}

App::setPageTitle("Nuevo usuario");
App::getThemeHeader();

?>
				<div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--5-col">
					<div class="mdl-card__supporting-text">
						<form action="<?php echo App::getUrl(); ?>/user_create.php" method="post">

							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" name="user_create_name" required="required" type="text" id="user_create_name" />
									<label class="mdl-textfield__label" for="user_create_name">Nombre</label>
								</div>
							</div>

							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" name="user_create_email" required="required" type="email" id="user_create_email" />
									<label class="mdl-textfield__label" for="user_create_email">Dirección de correo electrónico</label>
								</div>
							</div>

							<div class="adoc-form__row">
								<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="user_create_is_admin">
									<input type="checkbox" id="user_create_is_admin" name="user_create_is_admin" value="1" class="mdl-checkbox__input">
									<span class="mdl-checkbox__label">Rol administrador</span>
								</label>
							</div>

							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" name="user_create_raw_password" type="password" id="user_create_raw_password" value="cambiame" />
									<label class="mdl-textfield__label" for="user_create_raw_password">Nueva contraseña (por defecto es <i>cambiame</i>)</label>
								</div>
							</div>

							<div class="adoc-form__actions">
								<a href="<?php echo App::getUrl(); ?>/users.php" class="mdl-button mdl-js-button mdl-js-ripple-effect">Cancelar</a>
								<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit">Guardar</button>
							</div>
						</form>
					</div>
				</div>
<?php

App::getThemeFooter();

?>