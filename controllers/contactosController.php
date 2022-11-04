<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM contactos WHERE fechaEliminacion IS NULL');
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

		function getContactos($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM contactos WHERE fechaEliminacion IS NULL');
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

		function getDescripcion() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM descripcionBiomedica WHERE fechaEliminacion IS NULL');
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

		function getProtocolo() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM protocolos WHERE fechaEliminacion IS NULL');
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
					$sql=$con->prepare('INSERT INTO contactos (nombre, email, asunto, mensaje) VALUES (:P1,:P2,:P3,:P4)');
					$resultado=$sql->execute(array('P1'=>$_POST['nombre'], 'P2'=>$_POST['email'], 'P3'=>$_POST['asunto'], 'P4'=>$_POST['mensaje']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT * FROM contactos WHERE fechaEliminacion IS NULL LIMIT :P1,:P2');
					$resultado=$sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar contactos');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular contactos');

						echo '
							<table class="table table-hover">
								<tr>
									<th>Nombre</th>
									<th>E-mail</th>
									<th>Asunto Biomedica</th>
									<th>Mensaje</th>
									<th>Estado</th>
									<th>Acción</th>
								</tr>
						';
						foreach ($resultado as $fila) {
							$checked=($fila['fechaEliminacion']==NULL) ? 'checked' : '';
							echo '
								<tr>
									<input type="hidden" class="idTipoEquipo" value="'.$fila['id'].'">
									<td>'.$fila['nombre'].'</td>
									<td>'.$fila['email'].'</td>
									<td>'.$fila['asunto'].'</td>
									<td>'.$fila['mensaje'].'</td>
									<td>
										<div class="custom-control custom-switch" '.$anular.'>
											<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" '.$checked.'>
											<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
										</div>
									</td>
									<td>
										<button type="button" class="btn btn-warning btn-sm formEditarContactos" data-toggle="modal" data-target="#exampleModal" title="Editar Contactos" '.$editar.'>
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
						$sql=$con->prepare('UPDATE contactos SET fechaEliminacion=NOW() WHERE id=:P1');
					}else{
						$sql=$con->prepare('UPDATE contactos SET fechaEliminacion=NULL WHERE id=:P1');
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
					$sql=$con->prepare('SELECT * FROM contactos WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Tipo de Equipo</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
				
								<div class="modal-body">
									<form class="forms-sample">
										<input type="hidden" id="id" value="'.$fila['id'].'">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Tipo de Equipo</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="nombre" value="'.$fila['nombre'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Nivel de Riesgo</label>
											<div class="col-sm-9">
												<select class="form-control" id="riesgo">
													<option value="'.$fila['riesgo'].'">'.$fila['riesgo'].'</option>
													<option value="noAplica">NO APLICA</option>
													<option value="I">I</option>
													<option value="IIA">IIA</option>
													<option value="IIB">IIB</option>
													<option value="III">III</option>
												</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Descripción Biomedica</label>
											<div class="col-sm-9">
												<select class="form-control" id="idDescripcionBiomedica">
													<option value="'.$fila['idDescripcionBiomedica'].'">'.$fila['descripcion'].'</option>';
														foreach (getDescripcion() as $fila) {
															echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
														}
												echo '</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Protocolo</label>
											<div class="col-sm-9">
												<select class="form-control" id="idProtocolo">
													<option value="'.$idProtocolo.'">'.$protocolo.'</option>';
														foreach (getProtocolo() as $fila) {
															echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
														}
												echo '</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Validación</label>
											<div class="col-sm-9">
												<select class="form-control" id="validacion">
													<option value="'.$validacion.'">'.$validacion.'</option>
													<option value="si">SI</option>
													<option value="no">NO</option>
												</select>
											</div>
										</div>
										<button type="button" class="btn btn-primary mr-2" id="editarTipoEquipo" data-dismiss="modal">Guardar</button>
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
					$sql=$con->prepare('UPDATE tipoEquipo SET nombre=:P2, riesgo=:P3, idDescripcionBiomedica=:P4, idProtocolo=:P5, validacion=:P6 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['nombre'], 'P3'=>$_POST['riesgo'], 'P4'=>$_POST['idDescripcionBiomedica'], 'P5'=>$_POST['idProtocolo'], 'P6'=>$_POST['validacion']));
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