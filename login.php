<?php

/**
 * Canae Adoc Light login page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main_setup.php");

if (User::isLoggedIn()) {
	header("Location: " . $adoc_url);
	die();
}

if (! empty($_POST)) {
	$adoc_errors = array();
	$form_email = $_POST["form_email"];
	$form_password = $_POST["form_password"];

	if (! User::mailExists($form_email)) {
		$adoc_errors[] = "La dirección de correo electrónico introducida no existe.";
	} else {
		$user_data = User::getData(User::idByEmail($form_email));
		
		$hashed_password = generateHash($form_password, $user_data["user_password"]);
		
		if($hashed_password != $user_data["user_password"]) {
			$adoc_errors[] = "La contraseña introducida es incorrecta.";
		} else {
			$loggedInUser = new loggedInUser($user_data);
			$_SESSION["canae_adoc_user"] = $loggedInUser;
			header("Location: " . $adoc_url);
			die();
		}
	}
}

$adoc_pagetitle = "Iniciar sesión";
require_once($adoc_path . "/thm/header.php");

?>
	<div>
		<h1>Iniciar sesión</h1>
		<form action="<?php echo $adoc_url; ?>/login.php" method="post">
			<label for="form_email">Dirección de correo electrónico</label>
			<input id="form_email" name="form_email" required="required" type="email">
			<label for="form_password">Contraseña</label>
			<input id="form_password" name="form_password" required="required" type="password">
			<button type="submit">Iniciar sesión</button>
		</form>
	</div>
<?php

require_once($adoc_path . "/thm/footer.php");

?>
