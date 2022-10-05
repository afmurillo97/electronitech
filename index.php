<?php
	session_start();
	if (isset($_SESSION['idUsuario'])) {
		print "<script>window.location='views/dashboard/index.php';</script>";
	}
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Iniciar sesion | Corona</title>
	<!-- Layout styles -->
	<link rel="stylesheet" href="assets/css/style.css">
	<!-- Favicon -->
	<link rel="shortcut icon" href="assets/images/template/favicon.png" />
</head>
<body>
	<div class="container-scroller">
		<div class="container-fluid page-body-wrapper full-page-wrapper">
			<div class="row w-100 m-0">
				<div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
					<div class="card col-lg-4 mx-auto">
						<div class="card-body px-5 py-5">
							<h3 class="card-title text-left mb-3">Bienvenido</h3>
							<form action="login/login.php" method="POST">
								<div class="form-group">
									<label>Usuario *</label>
									<input type="text" class="form-control p_input" name="username">
								</div>
								<div class="form-group">
									<label>Contraseña *</label>
									<input type="password" class="form-control p_input" name="password">
								</div>
								<div class="text-center">
									<button type="submit" class="btn btn-primary btn-block enter-btn">Iniciar sesion</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- content-wrapper ends -->
			</div>
			<!-- row ends -->
		</div>
		<!-- page-body-wrapper ends -->
	</div>
	<!-- container-scroller -->
</body>
</html>