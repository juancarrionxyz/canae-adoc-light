<?php

/**
 * Canae Adoc Light user edit page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main.php");

App::requireAdmin();

if (! isset($_GET["id"])) {
	header("Location: " . $adoc_url . "/users.php"); /* #TODO Show reason of redirection: no specified user */
	die();
} else {
	$get_id = $_GET["id"];

	if (! User::idExists($get_id)) {
		header("Location: " . $adoc_url . "/users.php"); /* #TODO Show reason of redirection: specified user does not exist */
		die();
	}
}

if (! empty($_POST)) {
	$user_id_hidden = $_POST["user_id_hidden"];
	$user_edit_name = $_POST["user_edit_name"];
	$user_edit_email = $_POST["user_edit_email"];
	if (isset($_POST["user_edit_is_admin"])) {
		$user_edit_is_admin = 1;
	} else {
		$user_edit_is_admin = 0;
	}
	$user_edit_raw_password = $_POST["user_edit_raw_password"];

	if ($user_id_hidden != $get_id) {
		die("Integrity error");
	} else {
		if (User::update($user_id_hidden, $user_edit_name, $user_edit_email, $user_edit_is_admin)) {
			App::enqueueSuccess("Usuario actualizado correctamente.");
		} else {
			App::enqueueError("Hubo un problema al actualizar el usuario.");
		}

		if ($user_edit_raw_password != "") {
			if (User::updatePassword($user_id_hidden, App::generateHash($user_edit_raw_password))) {
				App::enqueueSuccess("Contraseña del usuario actualizada correctamente.");
			} else {
				App::enqueueError("Hubo un error al actualizar la contraseña del usuario.");
			}
		}
	}
}

$u = User::retrieve($get_id);

App::setPageTitle("Editar usuario");
App::getThemeHeader();

?>
				<div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--5-col">
					<div class="mdl-card__supporting-text">
						<form action="<?php echo App::getUrl(); ?>/user_edit.php?id=<?php echo $u->getId(); ?>" method="post">
							<input type="hidden" name="user_id_hidden" value="<?php echo $u->getId(); ?>">

							<div>
								<p>Estás editando el usuario <strong><?php echo $u->getName(); ?></strong> (<?php echo $u->getId(); ?>).</p>
							</div>

							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" name="user_edit_name" required="required" type="text" id="user_edit_name" value="<?php echo $u->getName(); ?>" />
									<label class="mdl-textfield__label" for="user_edit_name">Nombre</label>
								</div>
							</div>

							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" name="user_edit_email" required="required" type="email" id="user_edit_email" value="<?php echo $u->getEmail(); ?>" />
									<label class="mdl-textfield__label" for="user_edit_email">Dirección de correo electrónico</label>
								</div>
							</div>

							<div class="adoc-form__row">
								<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="user_edit_is_admin">
									<input type="checkbox" id="user_edit_is_admin" name="user_edit_is_admin" value="1" class="mdl-checkbox__input" <?php if ($u->isAdmin()) { ?>checked="checked"<?php } ?>>
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