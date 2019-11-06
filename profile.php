<?php

/**
 * Canae Adoc Light user profile page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main.php");

App::requireLogged();

if (! empty($_POST)) {
	if (! isset($_POST["user_edit_raw_password"])) {
		App::enqueueError("Hubo un error al procesar el formulario.");
	} else {
		$user_edit_raw_password = $_POST["user_edit_raw_password"];

		if ($user_edit_raw_password != "") {
			if (User::updatePassword($loggedInUser->getId(), App::generateHash($user_edit_raw_password))) {
				App::enqueueSuccess("Contraseña del usuario actualizada correctamente.");
			} else {
				App::enqueueError("Hubo un error al actualizar la contraseña del usuario.");
			}
		} else {
			App::enqueueError("Tu contraseña no puede estar vacía.");
		}
	}
}

App::setPageTitle("Editar usuario");
App::getThemeHeader();

?>
				<div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--5-col">
					<div class="mdl-card__supporting-text">
						<form action="<?php echo App::getUrl(); ?>/profile.php" method="post">
							<div>
								<p>Solo puedes actualizar tu contraseña. Si necesitas cambiar tu nombre o tu correo electrónico, contacta con el administrador.</p>
								<p>Al modificar la contraseña, tendrás que volver a iniciar sesión.</p>
							</div>

							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" disabled="disabled" id="user_edit_name" value="<?php echo $loggedInUser->getName(); ?>" />
									<label class="mdl-textfield__label" for="user_edit_name">Nombre</label>
								</div>
							</div>

							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" disabled="disabled" id="user_edit_email" value="<?php echo $loggedInUser->getEmail(); ?>" />
									<label class="mdl-textfield__label" for="user_edit_email">Dirección de correo electrónico</label>
								</div>
							</div>

							<div class="adoc-form__row">
								<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="user_edit_is_admin">
									<input type="checkbox" id="user_edit_is_admin" disabled="disabled" class="mdl-checkbox__input" <?php if ($loggedInUser->isAdmin()) { ?>checked="checked"<?php } ?>>
									<span class="mdl-checkbox__label">Rol administrador</span>
								</label>
							</div>

							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" name="user_edit_raw_password" type="password" id="user_edit_raw_password" />
									<label class="mdl-textfield__label" for="user_edit_raw_password">Nueva contraseña</label>
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