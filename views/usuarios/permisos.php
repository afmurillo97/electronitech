<?php
	if (!$_REQUEST) {
		header('Location:permisos.php?pagina=1');
	}

	if ($_REQUEST['pagina']<1) {
		header('Location:permisos.php?pagina=1');
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
	<title>Permisos</title>
	<!-- HEAD -->
	<?php include_once '../layouts/head.php'; ?>
	<!-- END HEAD -->
	<script src="permisosUtils/functions.js"></script>	
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
						<h3 class="page-title">Permisos</h3>
						<nav aria-label="breadcrumb">
						<?php
							echo '
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" '.permisosItem($_SESSION['idUsuario'], 'crear permisos').'>
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
										<input type="text" id="entrada" name="termino" class="form-control" placeholder="Ingrese Permiso">
									</form>

									<div id="resultado">
									<?php
										include '../../controllers/permisosController.php';

										$totalActivos=totalActivos();
										$paginas=ceil($totalActivos/10);
										$actual=$_REQUEST['pagina'];
										$cantPagina=10;
										$inicial=($actual-1)*$cantPagina;

										if (getPermisos($inicial, $cantPagina)) {
											$editar=permisosItem($_SESSION['idUsuario'], 'editar permisos');
											$anular=permisosItem($_SESSION['idUsuario'], 'anular permisos');

											echo '
												<table class="table table-hover sort">
													<thead>
														<tr>
															<th>Nombre</th>
															<th>Descripción</th>
															<th class="no-sort">Acción</th>
														</tr>
													</thead>
											';
											foreach (getPermisos($inicial, $cantPagina) as $fila) {
												echo '
													<tr>
														<input type="hidden" class="idPermiso" value="'.$fila['id'].'">
														<td>'.$fila['nombre'].'</td>
														<td>'.$fila['descripcion'].'</td>
														<td>
															<button type="button" class="btn btn-warning btn-sm formEditarPermiso" data-toggle="modal" data-target="#exampleModal" title="Editar Permiso" '.$editar.'>
																<span class="mdi mdi-pencil"></span>
															</button>

															<button type="button" class="btn btn-danger btn-sm formEliminarPermiso" data-toggle="modal" data-target=".modalWarning" title="Eliminar Permiso" '.$anular.'>
																<span class="mdi mdi-delete"></span>
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
												echo '<li class="page-item '.$active.'"><a class="page-link" href="permisos.php?pagina='.$i.'">'.$i.'</a></li>';
											}
											echo '
													</ul>
												</nav>
											';
											
										}else{
											echo '<br>NO EXISTEN PERMISOS CREADOS';
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
				<?php include_once 'permisosUtils/formModal.php'; ?>
				<!-- MODAL -->

				<!-- MODAL NOTIFY -->
				<?php include_once 'permisosUtils/modalNotify.php'; ?>
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