<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM proveedores WHERE fechaEliminacion IS NULL');
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

		function getProveedores($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM proveedores WHERE fechaEliminacion IS NULL LIMIT :P1,:P2');
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
					$sql=$con->prepare('INSERT INTO proveedores (nombre, nit, representante, direccion, celular, ciudad, email, regimen) VALUES (:P1,:P2,:P3,:P4,:P5,:P6,:P7,:P8)');
					$resultado=$sql->execute(array('P1'=>$_POST['nombre'], 'P2'=>$_POST['nit'], 'P3'=>$_POST['representante'], 'P4'=>$_POST['direccion'], 'P5'=>$_POST['celular'], 'P6'=>$_POST['ciudad'], 'P7'=>$_POST['email'], 'P8'=>$_POST['regimen']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT * FROM proveedores WHERE nombre LIKE "%":P1"%"');
					$resultado=$sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar proveedores');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular proveedores');

						echo '
							<table class="table table-hover">
								<tr>
									<th>Nombre</th>
									<th>Nit</th>
									<th>Representante</th>
									<th>Dirección</th>
									<th>Celular</th>
									<th>Ciudad</th>
									<th>E-mail</th>
									<th>Régimen</th>
									<th>Estado</th>
									<th>Acción</th>
								</tr>
						';
						foreach ($resultado as $fila) {
							$checked=($fila['fechaEliminacion']==NULL) ? 'checked' : '';
							echo '
								<tr>
									<input type="hidden" class="idProveedor" value="'.$fila['id'].'">
									<td>'.$fila['nombre'].'</td>
									<td>'.$fila['nit'].'</td>
									<td>'.$fila['representante'].'</td>
									<td>'.$fila['direccion'].'</td>
									<td>'.$fila['celular'].'</td>
									<td>'.$fila['ciudad'].'</td>
									<td>'.$fila['email'].'</td>
									<td>'.$fila['regimen'].'</td>
									<td>
										<div class="custom-control custom-switch" '.$anular.'>
											<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" '.$checked.'>
											<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
										</div>
									</td>
									<td>
										<button type="button" class="btn btn-warning btn-sm formEditarProveedor" data-toggle="modal" data-target="#exampleModal" title="Editar Proveedor" '.$editar.'>
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
						$sql=$con->prepare('UPDATE proveedores SET fechaEliminacion=NOW() WHERE id=:P1');
					}else{
						$sql=$con->prepare('UPDATE proveedores SET fechaEliminacion=NULL WHERE id=:P1');
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
					$sql=$con->prepare('SELECT * FROM proveedores WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Proveedor</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
				
								<div class="modal-body">
									<form class="forms-sample">
										<input type="hidden" id="id" value="'.$fila['id'].'">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Nombre</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="nombre" value="'.$fila['nombre'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Nit</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="nit" value="'.$fila['nit'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Representante Legal</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="representante" value="'.$fila['representante'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Dirección</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="direccion" value="'.$fila['direccion'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Celular</label>
											<div class="col-sm-9">
												<input type="number" class="form-control" id="Celular" value="'.$fila['celular'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">E-mail</label>
											<div class="col-sm-9">
												<input type="email" class="form-control" id="email" value="'.$fila['email'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Ciudad</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="ciudad" value="'.$fila['ciudad'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Tipo de Régimen</label>
											<div class="col-sm-9">
												<select class="form-control" id="regimen">
													<option value="'.$fila['regimen'].'">'.$fila['regimen'].'</option>
													<option value="comun">Régimen Común</option>
													<option value="simplificado">Régimen Simplificado</option>
													<option value="gran">Gran Contribuyente</option>
												</select>
											</div>
										</div>
										<button type="button" class="btn btn-primary mr-2" id="editarProveedor" data-dismiss="modal">Guardar</button>
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
					$sql=$con->prepare('UPDATE proveedores SET nombre=:P2, nit=:P3, representante=:P4, direccion=:P5, celular=:P6, ciudad=:P7, email=:P8, regimen=:P9 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['nombre'], 'P3'=>$_POST['nit'], 'P4'=>$_POST['representante'], 'P5'=>$_POST['direccion'], 'P6'=>$_POST['celular'], 'P7'=>$_POST['ciudad'], 'P8'=>$_POST['email'], 'P9'=>$_POST['regimen']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
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