<?php

/**
 * Canae Adoc Light document creation page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main.php");

App::requireAdmin();

if (! empty($_POST)) {
	$document_create_title = $_POST["document_create_title"];
	$document_create_description = $_POST["document_create_description"];
	$document_create_file = $_FILES["document_create_file"];

    $file_name = $document_create_file["name"];
    $file_size = $document_create_file["size"];
    $file_tmp_name = $document_create_file["tmp_name"];
    $file_type = $document_create_file["type"];
    $tmp = explode('.', $file_name);
    $file_extension = strtolower(end($tmp));

	$upload_path_name = "f_" . time() . "_" . mt_rand(1000, 9999);
    $upload_path_full = $adoc_app_path . $adoc_dir_separator . $adoc_app_upload_dir . $adoc_dir_separator . $upload_path_name;

    // TODO Check allowed file types
    // TODO Check allowed file sizes

    $move_tmp = move_uploaded_file($file_tmp_name, $upload_path_full);

    if ($move_tmp) {
    	$db_create = Document::create($document_create_title, $document_create_description, $file_type, $upload_path_name, basename($file_name));
    	if ($db_create) {
    		$adoc_successes[] = "Documento <strong>" . $document_create_title . "</strong> creado correctamente.";
    	} else {
    		$adoc_errors[] = "Hubo un error al insertar el documento en la base de datos.";
    	}
    } else {
    	$adoc_errors[] = "Hubo un error al procesar el archivo en el servidor.";
    }
}

App::setPageTitle("Nuevo documento");
App::getThemeHeader();

?>
				<div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--5-col">
					<div class="mdl-card__supporting-text">
						<form action="<?php echo App::getUrl(); ?>/document_create.php" method="post" enctype="multipart/form-data">
							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<input class="mdl-textfield__input" name="document_create_title" required="required" type="text" id="document_create_title"/>
									<label class="mdl-textfield__label" for="document_create_title">Título</label>
								</div>
							</div>

							<div class="adoc-form__row">
								<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
									<textarea class="mdl-textfield__input" name="document_create_description" type="email" id="document_create_description"></textarea>
									<label class="mdl-textfield__label" for="document_create_description">Descripción</label>
								</div>
							</div>

							<div class="adoc-form__row">
								<p><label for="document_create_file">Archivo</label></p>
								<input type="file" name="document_create_file" id="document_create_file">
							</div>

							<div class="adoc-form__actions">
								<a href="<?php echo App::getUrl(); ?>/index.php" class="mdl-button mdl-js-button mdl-js-ripple-effect">Cancelar</a>
								<button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit">Guardar</button>
							</div>
						</form>
					</div>
				</div>
<?php

App::getThemeFooter();

?>