<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM servicios WHERE fechaEliminacion IS NULL');
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

		function getServicios($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT servicios.*, grupoServicio.nombre AS grupoServicio FROM servicios INNER JOIN grupoServicio ON grupoServicio.id=servicios.idGrupoServicio WHERE servicios.fechaEliminacion IS NULL LIMIT :P1,:P2');
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

		function getGrupoServicio() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM grupoServicio WHERE fechaEliminacion IS NULL');
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
					$sql=$con->prepare('INSERT INTO servicios (codigo, idGrupoServicio, descripcion) VALUES (:P1,:P2,:P3)');
					$resultado=$sql->execute(array('P1'=>$_POST['codigo'], 'P2'=>$_POST['idGrupoServicio'], 'P3'=>$_POST['descripcion']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT servicios.*, grupoServicio.nombre AS grupoServicio FROM servicios INNER JOIN grupoServicio ON grupoServicio.id=servicios.idGrupoServicio WHERE servicios.codigo LIKE "%":P1"%"');
					$resultado=$sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar servicios');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular servicios');

						echo '
							<table class="table table-hover">
								<tr>
									<th>Codigo</th>
									<th>Grupo Servicio</th>
									<th>Descripción</th>
									<th>Estado</th>
									<th>Acción</th>
								</tr>
						';
						foreach ($resultado as $fila) {
							$checked=($fila['fechaEliminacion']==NULL) ? 'checked' : '';
							echo '
								<tr>
									<input type="hidden" class="idServicio" value="'.$fila['id'].'">
									<td>'.$fila['codigo'].'</td>
									<td>'.$fila['grupoServicio'].'</td>
									<td>'.$fila['descripcion'].'</td>
									<td>
										<div class="custom-control custom-switch" '.$anular.'>
											<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" '.$checked.'>
											<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
										</div>
									</td>
									<td>
										<button type="button" class="btn btn-warning btn-sm formEditarServicio" data-toggle="modal" data-target="#exampleModal" title="Editar Protocolo" '.$editar.'>
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
						$sql=$con->prepare('UPDATE servicios SET fechaEliminacion=NOW() WHERE id=:P1');
					}else{
						$sql=$con->prepare('UPDATE servicios SET fechaEliminacion=NULL WHERE id=:P1');
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
					$sql=$con->prepare('SELECT servicios.*, grupoServicio.nombre AS grupoServicio FROM servicios INNER JOIN grupoServicio ON grupoServicio.id=servicios.idGrupoServicio WHERE servicios.id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							$descripcion=$fila['descripcion'];
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Servicio</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
				
								<div class="modal-body">
									<form class="forms-sample">
										<input type="hidden" id="id" value="'.$fila['id'].'">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Codigo</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="codigo" value="'.$fila['codigo'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Grupo Servicio</label>
											<div class="col-sm-9">
												<select class="form-control" id="idGrupoServicio">
													<option value="'.$fila['idGrupoServicio'].'">'.$fila['grupoServicio'].'</option>';
														foreach (getGrupoServicio() as $fila) {
															echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
														}
												echo '</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Descripción</label>
											<div class="col-sm-9">
												<textarea class="form-control" id="descripcion" rows="4">'.$descripcion.'</textarea>
											</div>
										</div>
										<button type="button" class="btn btn-primary mr-2" id="editarServicio" data-dismiss="modal">Guardar</button>
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
					$sql=$con->prepare('UPDATE servicios SET codigo=:P2, idGrupoServicio=:P3, descripcion=:P4 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['codigo'], 'P3'=>$_POST['idGrupoServicio'], 'P4'=>$_POST['descripcion']));
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