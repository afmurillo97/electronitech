<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM permisos WHERE fechaEliminacion IS NULL');
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

		function getPermisos($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM permisos WHERE fechaEliminacion IS NULL LIMIT :P1,:P2');
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
					$sql=$con->prepare('INSERT INTO permisos (nombre, descripcion) VALUES (:P1,:P2)');
					$resultado=$sql->execute(array('P1'=>$_POST['nombre'], 'P2'=>$_POST['descripcion']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT * FROM permisos WHERE nombre LIKE "%":P1"%"');
					$resultado=$sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar permisos');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular permisos');

						echo '
							<table class="table table-hover">
								<tr>
									<th>Nombre</th>
									<th>Descripción</th>
									<th>Acción</th>
								</tr>
						';
						foreach ($resultado as $fila) {
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
						echo '</table>';
					}else{
						echo FALSE;
					}
					break;	
				case 'editar':
					$sql=$con->prepare('UPDATE permisos SET nombre=:P2, descripcion=:P3 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['nombre'], 'P3'=>$_POST['descripcion']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;

				case 'eliminar':
					$sql=$con->prepare('UPDATE permisos SET fechaEliminacion=NOW() WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				case 'especifico':
					$sql=$con->prepare('SELECT * FROM permisos  WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Permiso</h5>
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
												<input type="text" class="form-control" id="nombre" placeholder="Nombre" value="'.$fila['nombre'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Descripcion:</label>
											<div class="col-sm-9">
												<textarea class="form-control" id="descripcion" rows="4" placeholder="Descripción">'.$fila['descripcion'].'</textarea>
											</div>
										</div>
										<button type="button" class="btn btn-primary mr-2" id="editarPermiso" data-dismiss="modal">Guardar</button>
										<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
									</form>
								</div>
							';
						}
					}else{
						echo FALSE;
					}
					break;
			}
		}
	}catch(PDOException $error){
		echo "ERROR: ".$error->getMessage();
		exit();
	}
?>