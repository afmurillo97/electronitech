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
	<title>Corona · Empresas</title>
	<!-- HEAD -->
	<?php include_once '../layouts/head.php'; ?>
	<!-- END HEAD -->
	<script src="empresasUtils/functions.js"></script>
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
						<h3 class="page-title">Empresa</h3>
					</div>
					<div class="row">
						<div class="col-xl-12 col-sm-12 grid-margin stretch-card">
							<div class="card">
								<div class="card-body">
									<?php 
										include '../../controllers/empresasController.php';

										if (getEmpresas()) {
											foreach (getEmpresas() as $fila) {
												echo '
													<form class="forms-sample">
														<input type="hidden" id="idEmpresa" value="'.$fila['id'].'">
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Nombre</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="nombre" placeholder="Nombre" value="'.$fila['nombre'].'">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Nit</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="nit" placeholder="Nit" value="'.$fila['nit'].'">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Dirección</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="direccion" placeholder="Dirección" value="'.$fila['direccion'].'">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Telefono</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="telefono" placeholder="Telefono" value="'.$fila['telefono'].'">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">E-mail</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="email" placeholder="E-mail" value="'.$fila['email'].'">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Resolución</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" id="resolucion" placeholder="Resolución" value="'.$fila['resolucion'].'">
															</div>
														</div>
														<button type="button" class="btn btn-primary mr-2" id="editarEmpresa" '.permisosItem($_SESSION['idUsuario'], 'editar empresa').'>Editar</button>
														<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
													</form>
												';
											}
										}else{
											echo 'NO EXISTEN EMPRESAS CREADAS';
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END BODY PAGE -->

				<!-- MODAL -->
				<?php include_once 'empresasUtils/modalNotify.php'; ?>
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