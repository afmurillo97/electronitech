<?php
	if (!$_REQUEST) {
		header('Location:articulos.php?pagina=1');
	}

	if ($_REQUEST['pagina']<1) {
		header('Location:articulos.php?pagina=1');
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
	<title>Corona · Articulos</title>
	<!-- HEAD -->
	<?php include_once '../layouts/head.php'; ?>
	<!-- END HEAD -->
	<script src="articulosUtils/functions.js"></script>
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
						<h3 class="page-title">Articulos</h3>
						<nav aria-label="breadcrumb">
						<?php
							echo '
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" '.permisosItem($_SESSION['idUsuario'], 'crear articulos').'>
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
										<input type="text" id="entrada" name="termino" class="form-control" placeholder="Ingrese Articulo">
									</form>

									<div id="resultado" class="table-responsive">
									<?php
										include '../../controllers/articulosController.php';

										$totalActivos=totalActivos();
										$paginas=ceil($totalActivos/10);
										$actual=$_REQUEST['pagina'];
										$cantPagina=10;
										$inicial=($actual-1)*$cantPagina;

										if (getArticulos($inicial, $cantPagina)) {
											$editar=permisosItem($_SESSION['idUsuario'], 'editar articulos');
											$anular=permisosItem($_SESSION['idUsuario'], 'anular articulos');

											echo '
												<table class="table table-hover">
												<tr>
													<th>Tipo Equipo</th>
													<th>Marca</th>
													<th>Modelo</th>
													<th>Ubicacion</th>
													<th>Guia</th>
													<th>Cliente</th>
													<th>Estado</th>
													<th>Acción</th>
												</tr>
											';

											foreach (getArticulos($inicial, $cantPagina) as $fila) {												
												echo '
													<tr>
														<input type="hidden" class="idArticulo" value="'.$fila['id'].'">
														<td>'.$fila['tipoEquipo'].'</td>
														<td>'.$fila['marca'].'</td>
														<td>'.$fila['modelo'].'</td>
														<td>'.$fila['ubicacion'].'</td>
														<td title="Descargar Guia">
															<a href="../../views/equipos/articulosUtils/exportarGuia.php?id='.$fila['id'].'" class="btn btn-primary btn-sm" target="_blank">
																<span class="mdi mdi-file-pdf"></span>
															</a>
														</td>
														<td>'.$fila['cliente'].'</td>
														<td>
															<div class="custom-control custom-switch" '.$anular.'>
																<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" checked>
																<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
															</div>
														</td>
														<td>
															<button type="button" class="btn btn-warning btn-sm formEditarArticulo" data-toggle="modal" data-target=".bd-example-modal-lg" title="Editar Articulo" '.$editar.'>
																<span class="mdi mdi-pencil"></span>
															</button>
														</td>
													</tr>
												';
											}
											echo '
												</table>
												<nav aria-label="Page navigation example">
													<ul class="pagination pagination-sm justify-content-center">
											';
											for ($i=1; $i<=$paginas; $i++) {
												$active=$actual==$i ? 'active' : '';
												echo '<li class="page-item '.$active.'"><a class="page-link" href="articulos.php?pagina='.$i.'">'.$i.'</a></li>';
											}
											echo '
													</ul>
												</nav>
											';
											
										}else{
											echo '<br>NO EXISTEN ARTICULOS CREADOS';
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
				<?php include_once 'articulosUtils/formModal.php'; ?>
				<!-- MODAL -->

				<!-- MODAL NOTIFY -->
				<?php include_once 'articulosUtils/modalNotify.php'; ?>
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