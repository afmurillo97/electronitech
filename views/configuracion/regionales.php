<?php
	session_start();
	if (!isset($_SESSION['idUsuario']) || $_SESSION['idUsuario'] == NULL) {
		print "<script>alert(\"Acceso invalido!\"); window.location='../../index.php';</script>";
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Corona · Regionales</title>
	<!-- HEAD -->
	<?php include_once '../layouts/head.php'; ?>
	<!-- END HEAD -->
	<script src="regionalesUtils/functions.js"></script>
</head>
<body>
	<div class="container-scroller">
		<!-- MENU -->
		<?php include_once '../layouts/menu.php'; ?>
		<!-- END MENU -->

		<!-- CONTENEDOR -->
		<div class="container-fluid page-body-wrapper">
			<!-- HEADER -->
			<?php include_once '../layouts/header.php'; ?>
			<!-- END HEADER -->

			<!-- BODY PAGE -->
			<div class="main-panel">
				<div class="content-wrapper">
					<div class="page-header">
						<h3 class="page-title">Regionales</h3>
						<nav aria-label="breadcrumb">
						<?php
							echo '
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" '.permisosItem($_SESSION['idUsuario'], 'crear regionales').'>
									<span class="mdi mdi-plus"></span>
								</button>
							';
						?>
						</nav>
					</div>
					<div class="row">
						<div class="col-xl-12 col-sm-12 grid-margin stretch-card">
							<div class="card">
								<div class="card-body">
									<?php
										include '../../controllers/regionalesController.php';

										if (getRegionales()) {
											$editar=permisosItem($_SESSION['idUsuario'], 'editar regionales');
											$anular=permisosItem($_SESSION['idUsuario'], 'anular regionales');

											echo '
												<table class="table table-hover">
													<tr>
														<th>Nombre</th>
														<th>Descripción</th>
														<th>Acción</th>
													</tr>
											';

											foreach (getRegionales() as $fila) {
												echo '
													<tr>
														<input type="hidden" class="idRegional" value="'.$fila['id'].'">
														<td>'.$fila['nombre'].'</td>
														<td>'.$fila['descripcion'].'</td>
														<td>
															<button type="button" class="btn btn-warning btn-sm formEditarRegional" data-toggle="modal" data-target="#exampleModal" title="Editar Regional" '.$editar.'>
																<span class="mdi mdi-pencil"></span>
															</button>

															<button type="button" class="btn btn-danger btn-sm formEliminarRegional" data-toggle="modal" data-target=".modalWarning" title="Eliminar Regional" '.$anular.'>
																<span class="mdi mdi-delete"></span>
															</button>
														</td>	
													</tr>
												';
											}
											echo '
												</table>	
											';
										}else{
											echo 'NO EXISTEN REGIONALES CREADAS';
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END BODY PAGE -->
				
				<!-- MODAL -->
				<?php include_once 'regionalesUtils/formModal.php'; ?>
				<!-- MODAL -->

				<!-- MODAL NOTIFY -->
				<?php include_once 'regionalesUtils/modalNotify.php'; ?>
				<!-- END MODAL NOTIFY -->

				<!-- FOOTER -->
				<?php include_once '../layouts/footer.php'; ?>
				<!-- END FOOTER -->
			</div>
		</div>
		<!-- END CONTENEDOR -->
	</div>
</body>
</html>