<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM rutinas WHERE fechaEliminacion IS NULL');
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

		function getRutinas($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT rutinas.*, categorias.descripcion AS categoria FROM rutinas INNER JOIN categorias ON categorias.id=rutinas.idCategoria WHERE rutinas.fechaEliminacion IS NULL ORDER BY descripcion LIMIT :P1,:P2');
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

		function getCategorias() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM categorias WHERE fechaEliminacion IS NULL');
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
					$sql=$con->prepare('INSERT INTO rutinas (idCategoria, descripcion) VALUES (:P1,:P2)');
					$resultado=$sql->execute(array('P1'=>$_POST['idCategoria'], 'P2'=>$_POST['descripcion']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT rutinas.*, categorias.descripcion AS categoria FROM rutinas INNER JOIN categorias ON categorias.id=rutinas.idCategoria WHERE rutinas.descripcion LIKE "%":P1"%" OR categorias.descripcion LIKE "%":P1"%"');
					$resultado=$sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar categorias');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular categorias');

						echo '
							<table class="table table-hover">
								<tr>
									<th>Categoria</th>
									<th>Descripción</th>
									<th>Estado</th>
									<th>Acción</th>
								</tr>
						';
						foreach ($resultado as $fila) {
							$checked=($fila['fechaEliminacion']==NULL) ? 'checked' : '';
							echo '
								<tr>
									<input type="hidden" class="idRutina" value="'.$fila['id'].'">
									<td>'.$fila['categoria'].'</td>
									<td>'.$fila['descripcion'].'</td>
									<td>
										<div class="custom-control custom-switch" '.$anular.'>
											<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" '.$checked.'>
											<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
										</div>
									</td>
									<td>
										<button type="button" class="btn btn-warning btn-sm formEditarRutina" data-toggle="modal" data-target="#exampleModal" title="Editar Rutina" '.$editar.'>
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
						$sql=$con->prepare('UPDATE rutinas SET fechaEliminacion=NOW() WHERE id=:P1');
					}else{
						$sql=$con->prepare('UPDATE rutinas SET fechaEliminacion=NULL WHERE id=:P1');
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
					$sql=$con->prepare('SELECT rutinas.*, categorias.descripcion AS categoria FROM rutinas INNER JOIN categorias ON categorias.id=rutinas.idCategoria WHERE rutinas.id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							$descripcion=$fila['descripcion'];
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Rutina</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
				
								<div class="modal-body">
									<form class="forms-sample">
										<input type="hidden" id="id" value="'.$fila['id'].'">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Categoria</label>
											<div class="col-sm-9">
												<select class="form-control" id="idCategoria">
													<option value="'.$fila['idCategoria'].'">'.$fila['categoria'].'</option>';
													foreach (getCategorias() as $fila) {
														echo '<option value="'.$fila['id'].'">'.$fila['descripcion'].'</option>';
													}
												echo '</select>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Descripcion:</label>
											<div class="col-sm-9">
												<textarea class="form-control" id="descripcion" rows="4">'.$descripcion.'</textarea>
											</div>
										</div>
										<button type="button" class="btn btn-primary mr-2" id="editarRutina" data-dismiss="modal">Guardar</button>
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
					$sql=$con->prepare('UPDATE rutinas SET idCategoria=:P2, descripcion=:P3 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['idCategoria'], 'P3'=>$_POST['descripcion']));
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