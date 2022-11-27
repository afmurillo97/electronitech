<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM registros WHERE fechaEliminacion IS NULL');
			$resultado=$sql->execute();
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();

			if ($num>=1) {
				foreach ($resultado as $fila) {
					return $fila['COUNT(*)'];
				}
			}else{
				return NULL;
			}
			$con=null;
		}

		function getRegistros($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM registros WHERE fechaEliminacion IS NULL ORDER BY id LIMIT :P1,:P2');
			$sql->bindParam(':P1', $inicio, PDO::PARAM_INT);
			$sql->bindParam(':P2', $fin, PDO::PARAM_INT);
			$resultado=$sql->execute();
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();

			if ($num>=1) {
				return $resultado;
			}else{
				return NULL;
			}
			$con=null;
		}	

		require 'conexion.php';

		if(isset($_POST['accion'])) {
			switch ($_POST['accion']) {
				case 'ingresar':
					if(isset($_FILES['documento'])){
						$filename = $_FILES['documento']['name'];
						$base = 'assets/images/registrosInvima/registro_'.uniqid().'.'.pathinfo($filename, PATHINFO_EXTENSION);
						$urlBD = ($_SERVER['SERVER_NAME'] == '127.0.0.1') ? '127.0.0.1/electronitech/'.$base : $_SERVER['SERVER_NAME'].'/'.$base;
						$urlUpload = '../'.$base;
						$tmp_name = $_FILES['documento']['tmp_name'];

						if(move_uploaded_file($tmp_name, $urlUpload)) {
							$sql=$con->prepare('INSERT INTO registros (nombre, tipoRegistro, documento, descripcion) VALUES (:P1,:P2,:P3,:P4)');
							$resultado=$sql->execute(array('P1'=>$_POST['nombre'], 'P2'=>$_POST['tipoRegistro'], 'P3'=>$urlBD, 'P4'=>$_POST['descripcion']));
							$num=$sql->rowCount();

							if ($num>=1) {
								echo TRUE;
							}else{
								echo FALSE;
							}
						}else{
							echo FALSE;
						}
					}else {
						$sql=$con->prepare('INSERT INTO registros (nombre, tipoRegistro, descripcion) VALUES (:P1,:P2,:P3)');
						$resultado=$sql->execute(array('P1'=>$_POST['nombre'], 'P2'=>$_POST['tipoRegistro'], 'P3'=>$_POST['descripcion']));
						$num=$sql->rowCount();
						if ($num>=1) {
							echo TRUE;
						}else{
							echo FALSE;
						}
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT * FROM registros WHERE nombre LIKE "%":P1"%"');
					$resultado=$sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar registros');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular registros');

						echo '
							<table class="table table-hover">
								<tr>
									<th>Nombre</th>
									<th>Tipo Registro</th>
									<th>Documento</th>
									<th>Descripción</th>
									<th>Estado</th>
									<th>Acción</th>
								</tr>
						';
						foreach ($resultado as $fila) {
							$checked=($fila['fechaEliminacion']==NULL) ? 'checked' : '';
							echo '
								<tr>
									<input type="hidden" class="idRegistro" value="'.$fila['id'].'">
									<td>'.$fila['nombre'].'</td>
									<td>'.$fila['tipoRegistro'].'</td>
									<td><a href="'.$fila['documento'].'"><span class="mdi mdi-file-pdf"></span></a></td>
									<td>'.$fila['descripcion'].'</td>
									<td>
										<div class="custom-control custom-switch" '.$anular.'>
											<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" '.$checked.'>
											<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
										</div>
									</td>
									<td>
										<button type="button" class="btn btn-warning btn-sm formEditarRegistro" data-toggle="modal" data-target="#exampleModal" title="Editar Registro" '.$editar.'>
											<span class="mdi mdi-pencil"></span>
										</button>
									</td>
								</tr>
							';
						}
						echo '</table>';
					}else{
						echo FALSE;
					}
					break;

				case 'habilitar':
					if ($_POST['habilitado']==0) {
						$sql=$con->prepare('UPDATE registros SET fechaEliminacion=NOW() WHERE id=:P1');
					}else{
						$sql=$con->prepare('UPDATE registros SET fechaEliminacion=NULL WHERE id=:P1');
					}
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				case 'especifico':
					$sql=$con->prepare('SELECT * FROM registros WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Registros</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
				
								<div class="modal-body">
									<form class="forms-sample">
										<input type="hidden" id="id" value="'.$fila['id'].'">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Tipo de Registro</label>
											<div class="col-sm-9">
												<select class="form-control" id="tipoRegistro">
													<option value="'.$fila['tipoRegistro'].'">'.$fila['tipoRegistro'].'</option>
													<option value="REGISTRO SANITARIO">REGISTRO SANITARIO</option>
													<option value="PERMISO COMERCIALIZACION">PERMISO COMERCIALIZACION</option>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Registro INVIMA</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="nombre" value="'.$fila['nombre'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Documento</label>
											<div class="col-sm-9">
												<input type="file" class="form-control" id="documento">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Descripción</label>
											<div class="col-sm-9">
												<textarea class="form-control" id="descripcion" rows="4">'.$fila['descripcion'].'</textarea>
											</div>
										</div>

										<button type="button" class="btn btn-primary mr-2" id="editarRegistro" data-dismiss="modal">Guardar</button>
										<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
									</form>
								</div>
							';
						}
					}else{
						echo FALSE;
					}
					break;
				case 'editar':
					$filename = $_FILES['documento']['name'];
					$base = 'assets/images/registrosInvima/registro_'.uniqid().'.'.pathinfo($filename, PATHINFO_EXTENSION);
					$urlBD = ($_SERVER['SERVER_NAME'] == '127.0.0.1') ? '127.0.0.1/electronitech/'.$base : $_SERVER['SERVER_NAME'].'/'.$base;
					$urlUpload = '../'.$base;
					$tmp_name = $_FILES['documento']['tmp_name'];

					if(move_uploaded_file($tmp_name, $urlUpload)){
						$sql=$con->prepare('UPDATE registros SET nombre=:P2, tipoRegistro=:P3, documento=:P4, descripcion=:P5 WHERE id=:P1');
						$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['nombre'], 'P3'=>$_POST['tipoRegistro'], 'P4'=>$urlBD, 'P5'=>$_POST['descripcion']));
						$num=$sql->rowCount();

						if ($num>=1) {
							echo TRUE;
						}else{
							echo FALSE;
						}
					}else {
						$sql=$con->prepare('UPDATE registros SET nombre=:P2, tipoRegistro=:P3, descripcion=:P4 WHERE id=:P1');
						$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['nombre'], 'P3'=>$_POST['tipoRegistro'], 'P4'=>$_POST['descripcion']));
						$num=$sql->rowCount();

						if ($num>=1) {
							echo TRUE;
						}else{
							echo FALSE;
						}
					}
					break;

			}
		}
		$con=null;	
	}catch(PDOException $error){
		echo "ERROR: ".$error->getMessage();
		exit();
	}
?>