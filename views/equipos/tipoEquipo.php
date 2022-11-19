<?php
	if (!$_REQUEST) {
		header('Location:tipoEquipo.php?pagina=1');
	}

	if ($_REQUEST['pagina']<1) {
		header('Location:tipoEquipo.php?pagina=1');
	}

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
	<title>Tipo de Equipo</title>
	<!-- HEAD -->
	<?php include_once '../layouts/head.php'; ?>
	<!-- END HEAD -->
	<script src="tipoEquipoUtils/functions.js"></script>

	<!-- SELECTIZE LIBRARY -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
	<!-- END SELECTIZE LIBRARY -->

	<!-- ESTILOS SELECTIZE -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
	<!-- END ESTILOS SELECTIZE -->
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
						<h3 class="page-title">Tipo de Equipos</h3>
						<nav aria-label="breadcrumb">
						<?php
							echo '
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" '.permisosItem($_SESSION['idUsuario'], 'crear tipoEquipo').'>
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
									<form class="nav-link" id="buscar" action="#" method="POST">
										<input type="hidden" name="accion" value="buscador">
										<input type="text" id="entrada" name="termino" class="form-control" placeholder="Ingrese Tipo de Equipo">
									</form>

									<div id="resultado" class="table-responsive">
									<?php
										include '../../controllers/tipoEquipoController.php';

										$totalActivos=totalActivos();
										$paginas=ceil($totalActivos/10);
										$actual=$_REQUEST['pagina'];
										$cantPagina=10;
										$inicial=($actual-1)*$cantPagina;

										if (getTipoEquipo($inicial, $cantPagina)) {
											$editar=permisosItem($_SESSION['idUsuario'], 'editar tipoEquipo');
											$anular=permisosItem($_SESSION['idUsuario'], 'anular tipoEquipo');

											echo '
												<table class="table table-hover sort">
													<thead>
														<tr>
															<th colspan="7"><label style="font-size: 20px;">'.$totalActivos.' Tipos de Equipo encontrados </label></th>
														</tr>
														<tr>
															<th>Tipo Equipo</th>
															<th>Riesgo</th>
															<th>Descripción Biomedica</th>
															<th>Protocolo</th>
															<th class="no-sort">Validación</th>
															<th class="no-sort">Estado</th>
															<th class="no-sort">Acción</th>
														</tr>
													</thead>
											';

											foreach (getTipoEquipo($inicial, $cantPagina) as $fila) {
												echo '
													<tr>
														<input type="hidden" class="idTipoEquipo" value="'.$fila['id'].'">
														<td>'.$fila['ecri'].'</td>
														<td>'.$fila['riesgo'].'</td>
														<td>'.$fila['descripcion'].'</td>
														<td>'.$fila['protocolo'].'</td>
														<td>'.$fila['validacion'].'</td>
														<td>
															<div class="custom-control custom-switch" '.$anular.'>
																<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" checked>
																<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
															</div>
														</td>
														<td>
															<button type="button" class="btn btn-warning btn-sm formEditarTipoEquipo" data-toggle="modal" data-target="#exampleModal" title="Editar Tipo de Equipo" '.$editar.'>
																<span class="mdi mdi-pencil"></span>
															</button>
														</td>
													</tr>
												';
											}
											echo '
												</table>
												<nav aria-label="Page navigation example">
													<ul class="pagination pagination-sm">
											';
											for ($i=1; $i<=$paginas; $i++) {
												$active=$actual==$i ? 'active' : '';
												echo '<li class="page-item '.$active.'"><a class="page-link" href="tipoEquipo.php?pagina='.$i.'">'.$i.'</a></li>';
											}
											echo '
													</ul>
												</nav>
											';
											
										}else{
											echo '<br>NO EXISTEN TIPO DE EQUIPOS CREADOS';
										}
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END BODY PAGE -->

				<!-- MODAL -->
				<?php include_once 'tipoEquipoUtils/formModal.php'; ?>
				<!-- MODAL -->

				<!-- MODAL NOTIFY -->
				<?php include_once 'tipoEquipoUtils/modalNotify.php'; ?>
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