<?php

/**
 * Canae Adoc Light main page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main.php");

App::requireLogged();

App::setPageTitle("Documentos de asamblea");
App::getThemeHeader();

?>
				<div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
					<div class="mdl-card__supporting-text">
						<?php if ($loggedInUser->isAdmin()) { ?>
						<div><a href="<?php echo App::getUrl(); ?>/document_create.php" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"><i class="material-icons">add</i>Nuevo documento</a></div>
						<?php } ?>
						<?php

if (Document::atLeastOneExists()) {

						?>
						<div class="adoc-data-table-container">
							<table class="mdl-data-table mdl-js-data-table <?php if ($loggedInUser->isAdmin()) { ?> mdl-data-table--selectable<?php } ?>" id="documents-table">
								<thead>
									<tr>
										<th class="mdl-data-table__cell--non-numeric">Título</th>
										<th class="mdl-data-table__cell--non-numeric">Descripción</th>
										<th class="mdl-data-table__cell--non-numeric">Tipo</th>
										<th class="mdl-data-table__cell--non-numeric">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php

	$documents = Document::getAll();

	foreach($documents as $d) {

									?>
									<tr>
										<td class="mdl-data-table__cell--non-numeric"><?php echo $d->getTitle(); ?></td>
										<td class="mdl-data-table__cell--non-numeric"><?php echo $d->getDescription(); ?></td>
										<td class="mdl-data-table__cell--non-numeric document-list-mime">
											<?php

			if ($d->getMime() == "application/pdf") {
				echo '<svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#757575" d="M13,9H18.5L13,3.5V9M6,2H14L20,8V20A2,2 0 0,1 18,22H6A2,2 0 0,1 4,20V4A2,2 0 0,1 6,2M10.1,11.4C10.08,11.44 9.81,13.16 8,16.09C8,16.09 4.5,17.91 5.33,19.27C6,20.35 7.65,19.23 9.07,16.59C9.07,16.59 10.89,15.95 13.31,15.77C13.31,15.77 17.17,17.5 17.7,15.66C18.22,13.8 14.64,14.22 14,14.41C14,14.41 12,13.06 11.5,11.2C11.5,11.2 12.64,7.25 10.89,7.3C9.14,7.35 9.8,10.43 10.1,11.4M10.91,12.44C10.94,12.45 11.38,13.65 12.8,14.9C12.8,14.9 10.47,15.36 9.41,15.8C9.41,15.8 10.41,14.07 10.91,12.44M14.84,15.16C15.42,15 17.17,15.31 17.1,15.64C17.04,15.97 14.84,15.16 14.84,15.16M7.77,17C7.24,18.24 6.33,19 6.1,19C5.87,19 6.8,17.4 7.77,17M10.91,10.07C10.91,10 10.55,7.87 10.91,7.92C11.45,8 10.91,10 10.91,10.07Z" /></svg><span>Documento PDF</span>';
			} else if ($d->getMime() == "text/plain") {
				echo '<svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#757575" d="M13,9H18.5L13,3.5V9M6,2H14L20,8V20A2,2 0 0,1 18,22H6C4.89,22 4,21.1 4,20V4C4,2.89 4.89,2 6,2M15,18V16H6V18H15M18,14V12H6V14H18Z" /></svg><span>Documento de texto plano</span>';
			} else if ($d->getMime() == "application/msword" || $d->getMime() == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
				echo '<svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#757575" d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M15.2,20H13.8L12,13.2L10.2,20H8.8L6.6,11H8.1L9.5,17.8L11.3,11H12.6L14.4,17.8L15.8,11H17.3L15.2,20M13,9V3.5L18.5,9H13Z" /></svg><span>Documento de Microsoft Word</span>';
			} else if ($d->getMime() == "application/vnd.ms-excel" || $d->getMime() == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
				echo '<svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#757575" d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M15.8,20H14L12,16.6L10,20H8.2L11.1,15.5L8.2,11H10L12,14.4L14,11H15.8L12.9,15.5L15.8,20M13,9V3.5L18.5,9H13Z" /></svg><span>Documento de Microsoft Excel</span>';
			} else if ($d->getMime() == "application/vnd.ms-powerpoint" || $d->getMime() == "application/vnd.openxmlformats-officedocument.presentationml.presentation") {
				echo '<svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#757575" d="M12.6,12.3H10.6V15.5H12.7C13.3,15.5 13.6,15.3 13.9,15C14.2,14.7 14.3,14.4 14.3,13.9C14.3,13.4 14.2,13.1 13.9,12.8C13.6,12.5 13.2,12.3 12.6,12.3M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M15.2,16C14.6,16.5 14.1,16.7 12.8,16.7H10.6V20H9V11H12.8C14.1,11 14.7,11.3 15.2,11.8C15.8,12.4 16,13 16,13.9C16,14.8 15.8,15.5 15.2,16M13,9V3.5L18.5,9H13Z" /></svg><span>Documento de Microsoft PowerPoint</span>';
			}
											?>
										</td>
										<td class="mdl-data-table__cell--non-numeric document-list-mime">
                                            <!-- View -->
											<a target="_blank" href="<?php echo $d->getViewUrl(); ?>"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#757575" d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"></path></svg></a>
											<!-- Download -->
                                            <a href="<?php echo $d->getDownloadUrl(); ?>"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#757575" d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z"></path></svg></a>
											<?php if ($loggedInUser->isAdmin()) { ?>
                                            <!-- Delete -->
                                            <a href="<?php echo $d->getDeleteUrl(); ?>"><svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="#757575" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"></path></svg></a>
                                            <?php } ?>
										</td>
									</tr>
									<?php

	}

									?>
								</tbody>
							</table>
						</div>
						<?php
} else {

						?><div><p>No existen documentos registrados</p></div><?php

}

						?>
					</div>
				</div>
<?php

App::getThemeFooter();

?>
