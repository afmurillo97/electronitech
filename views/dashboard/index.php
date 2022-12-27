<?php
	if (!$_REQUEST) {
		header('Location:index.php?pagina=1');
	}

	if ($_REQUEST['pagina']<1) {
		header('Location:index.php?pagina=1');
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
	<title>Dashboard</title>
	<!-- HEAD -->
	<?php include_once '../layouts/head.php'; ?>
	<!-- END HEAD -->
	<script src="dashboardUtils/functions.js"></script>

	<!-- CALENDAR -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../../calendario/fonts/icomoon/style.css">
	<link href='../../calendario/fullcalendar/packages/core/main.css' rel='stylesheet' />
	<link href='../../calendario/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />
	<link rel="stylesheet" href="../../calendario/css/style.css">

	<script src="../../calendario/js/popper.min.js"></script>
    <script src="../../calendario/js/bootstrap.min.js"></script>
    <script src='../../calendario/fullcalendar/packages/core/main.js'></script>
    <script src='../../calendario/fullcalendar/packages/interaction/main.js'></script>
    <script src='../../calendario/fullcalendar/packages/daygrid/main.js'></script>
    <script src='../../calendario/fullcalendar/packages/timegrid/main.js'></script>
    <script src='../../calendario/fullcalendar/packages/list/main.js'></script>
	<!-- END CALENDAR -->
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
						<h3 class="page-title">Dashboard</h3>
						<nav aria-label="breadcrumb">
						<?php
							echo '
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" '.permisosItem($_SESSION['idUsuario'], 'crear cronograma').'>
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
										<input type="text" id="entrada" name="termino" class="form-control" placeholder="Ingrese Cliente">
									</form>

									<div id="resultado" class="table-responsive">
									<?php
										include '../../controllers/dashboardController.php';

										$totalActivos=totalActivos();
										$paginas=ceil($totalActivos/10);
										$actual=$_REQUEST['pagina'];
										$cantPagina=10;
										$inicial=($actual-1)*$cantPagina;

										if (getCronogramas($inicial, $cantPagina)) {
											$editar=permisosItem($_SESSION['idUsuario'], 'editar cronograma');
											$anular=permisosItem($_SESSION['idUsuario'], 'anular cronograma');

											echo '
												<table class="table table-hover sort">
													<thead>
														<tr>
															<th>Cliente</th>
															<th>Dirección</th>
															<th>Marca / Modelo</th>
															<th>Fecha Inicial</th>
															<th>Fecha Final</th>
															<th>Acción</th>
														</tr>
													</thead>
											';

											foreach (getCronogramas($inicial, $cantPagina) as $fila) {
												$direccionGuion=str_replace("@", " - ", $fila['direccion']);

												echo '
													<tr>
														<input type="hidden" class="idEquipo" value="'.$fila['id'].'">
														<td>'.$fila['cliente'].'</td>
														<td>'.$direccionGuion.'</td>
														<td>'.$fila['marca'].'/'.$fila['modelo'].'</td>
														<td>'.$fila['fechaInicial'].'</td>
														<td>'.$fila['fechaFinal'].'</td>
														<td>
															<button type="button" class="btn btn-warning btn-sm formEditarEquipo" data-toggle="modal" data-target=".bd-example-modal-lg" title="Editar Equipo" '.$editar.'>
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
												echo '<li class="page-item '.$active.'"><a class="page-link" href="equipos.php?pagina='.$i.'">'.$i.'</a></li>';
											}
											echo '
													</ul>
												</nav>
											';
											
										}else{
											echo '<br>NO EXISTEN MANTENIMIENTOS CREADOS';
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
				<?php include_once 'dashboardUtils/formModal.php'; ?>
				<!-- MODAL -->

				<!-- MODAL NOTIFY -->
				<?php include_once 'dashboardUtils/modalNotify.php'; ?>
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