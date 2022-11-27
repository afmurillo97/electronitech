<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM variablesMetrologicas WHERE fechaEliminacion IS NULL');
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

		function getVariables($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT variablesMetrologicas.*, tipoVariable.nombre AS tipoVariable FROM variablesMetrologicas INNER JOIN tipoVariable ON tipoVariable.id=variablesMetrologicas.idTipoVariable WHERE variablesMetrologicas.fechaEliminacion IS NULL ORDER BY nombre LIMIT :P1,:P2');
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

		function getTipoVariable() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM tipoVariable WHERE fechaEliminacion IS NULL');
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
					$sql=$con->prepare('INSERT INTO variablesMetrologicas (nombre, unidadTexto, unidadSigno, idTipoVariable) VALUES (:P1,:P2,:P3,:P4)');
					$resultado=$sql->execute(array('P1'=>$_POST['nombre'], 'P2'=>$_POST['unidadTexto'], 'P3'=>$_POST['unidadSigno'], 'P4'=>$_POST['idTipoVariable']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT variablesMetrologicas.*, tipoVariable.nombre AS tipoVariable FROM variablesMetrologicas INNER JOIN tipoVariable ON tipoVariable.id=variablesMetrologicas.idTipoVariable WHERE variablesMetrologicas.nombre LIKE "%":P1"%"');
					$resultado=$sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar variables');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular variables');

						echo '
							<table class="table table-hover">
								<tr>
									<th>Variable</th>
									<th>Unidad Texto</th>
									<th>Signo</th>
									<th>Tipo de Variable</th>
									<th>Estado</th>
									<th>Acción</th>
								</tr>
						';
						foreach ($resultado as $fila) {
							$checked=($fila['fechaEliminacion']==NULL) ? 'checked' : '';
							echo '
								<tr>
									<input type="hidden" class="idVariable" value="'.$fila['id'].'">
									<td>'.$fila['nombre'].'</td>
									<td>'.$fila['unidadTexto'].'</td>
									<td>'.$fila['unidadSigno'].'</td>
									<td>'.$fila['tipoVariable'].'</td>
									<td>
										<div class="custom-control custom-switch" '.$anular.'>
											<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" '.$checked.'>
											<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
										</div>
									</td>
									<td>
										<button type="button" class="btn btn-warning btn-sm formEditarVariable" data-toggle="modal" data-target="#exampleModal" title="Editar Variable" '.$editar.'>
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
						$sql=$con->prepare('UPDATE variablesMetrologicas SET fechaEliminacion=NOW() WHERE id=:P1');
					}else{
						$sql=$con->prepare('UPDATE variablesMetrologicas SET fechaEliminacion=NULL WHERE id=:P1');
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
					$sql=$con->prepare('SELECT variablesMetrologicas.*, tipoVariable.nombre AS tipoVariable FROM variablesMetrologicas INNER JOIN tipoVariable ON tipoVariable.id=variablesMetrologicas.idTipoVariable WHERE variablesMetrologicas.id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Variable</h5>
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
											<label class="col-sm-3 col-form-label">Unidad Texto</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="unidadTexto" value="'.$fila['unidadTexto'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Unidad Signo</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="unidadSigno" value="'.$fila['unidadSigno'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Tipo de Variable</label>
											<div class="col-sm-9">
												<select class="form-control" id="idTipoVariable">
													<option value="'.$fila['idTipoVariable'].'">'.$fila['tipoVariable'].'</option>';
														foreach (getTipoVariable() as $fila) {
															echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
														}
												echo '</select>
											</div>
										</div>
										<button type="button" class="btn btn-primary mr-2" id="editarVariable" data-dismiss="modal">Guardar</button>
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
					$sql=$con->prepare('UPDATE variablesMetrologicas SET nombre=:P2, unidadTexto=:P3, unidadSigno=:P4, idTipoVariable=:P5 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['nombre'], 'P3'=>$_POST['unidadTexto'], 'P4'=>$_POST['unidadSigno'], 'P5'=>$_POST['idTipoVariable']));
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