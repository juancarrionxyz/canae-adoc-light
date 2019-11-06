<?php

/**
 * Canae Adoc Light user delete page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main.php");

App::requireAdmin();

if (! empty($_POST)) {
	// TODO Check user id is specified correctly and exists

	$post_id = $_POST["user_delete_id_hidden"];

	if (User::delete($post_id)) {
		header("Location: " . App::getUrl() . "/users.php"); // TODO Show reason of redirection: success
	} else {
		header("Location: " . App::getUrl() . "/users.php"); // TODO Show reason of redirection: error
	}

	die();
}

if (! isset($_GET["id"])) {
	header("Location: " . App::getUrl() . "/users.php"); // TODO Show reason of redirection: no specified user
	die();
} else {
	$get_id = $_GET["id"];

	if (! User::idExists($get_id)) {
		header("Location: " . App::getUrl() . "/users.php"); // TODO Show reason of redirection: specified user does not exist
		die();
	} else {
		/* Prevent logged in user from deleting itself */

		if ($get_id == $loggedInUser->getId()) {
			header("Location: " . App::getUrl() . "/users.php"); // TODO Show reason of redirection: specified user is same as requesting user
			die();
		} else {
			$user = User::retrieve($get_id);
		}
	}
}

App::setPageTitle("Eliminar usuario");
App::getThemeHeader();

?>
				<div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
					<div class="mdl-card__supporting-text">
						<form action="<?php echo App::getUrl(); ?>/user_delete.php?id=<?php echo $user->getId(); ?>" method="post">
							<input type="hidden" name="user_delete_id_hidden" value="<?php echo $user->getId(); ?>">

							<div class="adoc-form__row">
								<p>¿Está seguro de que desea eliminar el usuario <strong><?php echo $user->getName(); ?></strong>?</p>
							</div>

							<div class="adoc-form__row">
								<a href="<?php echo App::getUrl(); ?>/users.php" class="mdl-button mdl-js-button mdl-js-ripple-effect">Cancelar</a>
								<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit" name="delete">Eliminar</button>
							</div>
						</form>
					</div>
				</div>
<?php

App::getThemeFooter();

?>