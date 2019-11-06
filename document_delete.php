<?php

/**
 * Canae Adoc Light document delete confirmation page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main.php");

App::requireAdmin();

// Check document id

if (! isset($_GET["id"])) {
	die("Need id");
}

$document_id = $_GET["id"];

if (! Document::idExists($document_id)) {
	die("File does not exist");
}

App::setPageTitle("Eliminar documento");

if (! empty($_POST)) {
	if (Document::delete($document_id)) {
		App::enqueueSuccess("Documento eliminado correctamente.");
		App::getThemeHeader();
		App::getThemeFooter();

		die();
	} else {
		App::enqueueError("Hubo un error al eliminar el documento.");
	}
}

App::getThemeHeader();

if (App::emptySuccesses()) {
	$d = Document::retrieve($document_id);

?>
				<div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
					<div class="mdl-card__supporting-text">
						<form action="<?php echo App::getUrl(); ?>/document_delete.php?id=<?php echo $document_id; ?>" method="post" enctype="multipart/form-data">
							<div class="adoc-form__row">
								<p>¿Está seguro de que desea eliminar el documento <strong><?php echo $d->getTitle(); ?></strong>?</p>
							</div>

							<div class="adoc-form__row">
								<a href="<?php echo App::getUrl(); ?>/index.php" class="mdl-button mdl-js-button mdl-js-ripple-effect">Cancelar</a>
								<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit" name="delete">Eliminar</button>
							</div>
						</form>
					</div>
				</div>
<?php

}

App::getThemeFooter();

?>