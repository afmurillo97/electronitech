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
	<title>Datos de la Página</title>
	<!-- HEAD -->
	<?php include_once '../layouts/head.php'; ?>
	<!-- END HEAD -->
	<script src="datosUtils/functions.js"></script>
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
						<h3 class="page-title">Datos de la Página</h3>
					</div>
					<div class="row">
						<div class="col-xl-12 col-sm-12 grid-margin stretch-card">
							<div class="card">
								<div class="card-body">
									<?php 
										include '../../controllers/datosController.php';

										if (getDatos()) {
											foreach (getDatos() as $fila) {
												echo '
													<form class="forms-sample">
														<input type="hidden" id="idDatos" value="'.$fila['id'].'">
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Ubicación</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="ubicacion" placeholder="Ubicación" value="'.$fila['ubicacion'].'">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Email</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="email" placeholder="Email" value="'.$fila['email'].'">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Teléfono</label>
															<div class="col-sm-9">
																<input type="number" class="form-control" id="telefono" placeholder="Teléfono" value="'.$fila['telefono'].'">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Mapa del Sitio</label>
															<div class="col-sm-9">
																<textarea class="form-control" id="mapa" rows="4" placeholder="<iframe>Aquí va la ruta del mapa...</iframe>" value="'.$fila['mapa'].'"></textarea>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Facebook</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="facebook" placeholder="Facebook" value="'.$fila['facebook'].'">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Instagram</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="instagram" placeholder="Instagram" value="'.$fila['instagram'].'">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Whatsapp</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="whatsapp" placeholder="Whatsapp" value="'.$fila['whatsapp'].'">
															</div>
														</div>
														<button type="button" class="btn btn-primary mr-2" id="editarDatos" '.permisosItem($_SESSION['idUsuario'], 'editar datos').'>Editar</button>
														<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
													</form>
												';
											}
										}else{
											echo 'NO EXISTEN DATOS CREADOS';
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END BODY PAGE -->

				<!-- MODAL -->
				<?php include_once 'datosUtils/modalNotify.php'; ?>
				<!-- END MODAL -->

				<!-- FOOTER -->
				<?php include_once '../layouts/footer.php'; ?>
				<!-- END FOOTER -->
			</div>
		</div>
		<!-- END CONTENEDOR -->
	</div>
</body>
</html>