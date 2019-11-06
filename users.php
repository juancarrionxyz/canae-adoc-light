<?php

/**
 * Canae Adoc Light users management page
 *
 * @package canae-adoc-light
 */

require_once("./sys/main.php");

App::requireAdmin();

/* #TODO Check that the currently logged in user has permission to manage users */

App::setPageTitle("Administrar usuarios");
App::getThemeHeader();

?>
				<div class="mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
					<div class="mdl-card__supporting-text">
						<div><a href="<?php echo App::getUrl(); ?>/user_create.php" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"><i class="material-icons">add</i>Nuevo usuario</a></div>
						<div class="adoc-data-table-container">
							<table class="mdl-data-table mdl-js-data-table <?php if ($loggedInUser->isAdmin()) { ?> mdl-data-table--selectable<?php } ?>" id="documents-table">
								<thead>
									<tr>
										<th class="mdl-data-table__cell--non-numeric">Id</th>
										<th class="mdl-data-table__cell--non-numeric">Nombre</th>
										<th class="mdl-data-table__cell--non-numeric">Dirección de correo electrónico</th>
										<th class="mdl-data-table__cell--non-numeric">Rol</th>
										<th class="mdl-data-table__cell--non-numeric">Acciones</th>
									</tr>
								</thead>
								<tbody>
									<?php

$users = User::getAll();

foreach ($users as $u) {
									?>
									<tr>
										<td class="mdl-data-table__cell--non-numeric"><?php echo $u->getId(); ?></td>
										<td class="mdl-data-table__cell--non-numeric"><?php echo $u->getName(); ?></td>
										<td class="mdl-data-table__cell--non-numeric"><?php echo $u->getEmail(); ?></td>
										<td class="mdl-data-table__cell--non-numeric"><?php if ($u->isAdmin()) { echo "Administrador"; } ?></td>
										<td class="mdl-data-table__cell--non-numeric">
											<a href="<?php echo App::getUrl(); ?>/user_edit.php?id=<?php echo $u->getId(); ?>">Editar</a>
											<?php

											/* Prevent logged in user from deleting itself */
											
											if ($u->getId() != $loggedInUser->getId()) {
												?><a href="<?php echo App::getUrl(); ?>/user_delete.php?id=<?php echo $u->getId(); ?>">Eliminar</a><?php
											} else {
												?>(No puedes eliminarte a ti mismo.)<?php
											}

											?>
										</td>
									</tr>
									<?php
}

									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
<?php

App::getThemeFooter();

?>
