<?php
	if (!$_REQUEST) {
		header('Location:pqrf.php?pagina=1');
	}

	if ($_REQUEST['pagina']<1) {
		header('Location:pqrf.php?pagina=1');
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
	<title>PQRF's</title>
	<!-- HEAD -->
	<?php include_once '../layouts/head.php'; ?>
	<!-- END HEAD -->
	<script src="pqrfUtils/functions.js"></script>
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
						<h3 class="page-title">Peticiones, Quejas, Reclamos y Felicitaciones</h3>
						<nav aria-label="breadcrumb">
						<?php
							echo '
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" '.permisosItem($_SESSION['idUsuario'], 'crear pqrf').'>
									<span class="mdi mdi-plus"></span>
								</button>
							';
						?>
						</nav>
			  		</div>
					<div class="row">
						<div class="col-xl-12 col-sm-12 grid-margin stretch-card">
							<div class="card">
								<div class="card-body table-responsive" >
									<form class="nav-link" id="buscar" action="#" method="POST">
										<input type="hidden" name="accion" value="buscador">
										<input type="text" id="entrada" name="termino" class="form-control" placeholder="Ingrese PQRF">
									</form>

									<table class="table table-hover table-dark">
  										<thead>
  										  <tr >
  										    <th scope="col">Tipo</th>
  										    <th scope="col">Nombre</th>
  										    <th scope="col">Documento</th>
  										    <th scope="col">Teléfono</th>
											<th scope="col">Correo</th>
											<th scope="col">Asunto</th>
											<th scope="col">Descripción</th>
											<th scope="col">Acción</th>
  										  </tr>
  										</thead>
  										<tbody>
  										  <tr class="bg-primary">
  										    <th scope="row">Petición</th>
  										    <td>Mark</td>
  										    <td>Otto</td>
  										    <td>@mdo</td>
											<td>Mark</td>
  										    <td>Otto</td>
  										    <td>@mdo</td>
											<th scope="col">
												<button type="button" class="btn btn-light btn-sm">
													<span class="mdi mdi-pencil"></span>
												</button>
											</th>
  										  </tr>
  										  <tr class="bg-danger">
  										    <th scope="row">Queja</th>
  										    <td>Jacob</td>
  										    <td>Thornton</td>
  										    <td>@fat</td>
											<td>Mark</td>
  										    <td>Otto</td>
  										    <td>@mdo</td>
											<th scope="col">
												<button type="button" class="btn btn-light btn-sm">
													<span class="mdi mdi-pencil"></span>
												</button>
											</th>
  										  </tr>
  										  <tr class="bg-warning">
  										    <th scope="row">Reclamo</th>
  										    <td colspan="2">Larry the Bird</td>
  										    <td>@twitter</td>
											<td>Mark</td>
  										    <td>Otto</td>
  										    <td>@mdo</td>
											<th scope="col">
												<button type="button" class="btn btn-light btn-sm">
													<span class="mdi mdi-pencil"></span>
												</button>
											</th>
  										  </tr>
										  <tr class="bg-success">
  										    <th scope="row">Felicitación</th>
  										    <td colspan="2">Larry the Bird</td>
  										    <td>@twitter</td>
											<td>Mark</td>
  										    <td>Otto</td>
  										    <td>@mdo</td>
											<th scope="col">
												<button type="button" class="btn btn-light btn-sm">
													<span class="mdi mdi-pencil"></span>
												</button>
											</th>
  										  </tr>
  										</tbody>
									</table>

								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END BODY PAGE -->

				<!-- MODAL -->
				<?php include_once 'protocolosUtils/formModal.php'; ?>
				<!-- MODAL -->

				<!-- MODAL NOTIFY -->
				<?php include_once 'protocolosUtils/modalNotify.php'; ?>
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


