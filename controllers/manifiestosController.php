<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM manifiestos WHERE fechaEliminacion IS NULL');
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

		function getManifiestos($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM manifiestos WHERE fechaEliminacion IS NULL LIMIT :P1,:P2');
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
					$filename = $_FILES['documento']['name'];
					$urlDocumento = $_SERVER['SERVER_NAME'].'/electronitech/assets/images/documentos/'.$filename;
					// $urlFirma = $_SERVER['SERVER_NAME'].'/assets/images/documentos/'.$filename;
					$urlUpload = '../assets/images/documentos/'.basename($filename);
					$tmp_name = $_FILES['documento']['tmp_name'];

					$sql=$con->prepare('INSERT INTO manifiestos (nombre, documento, descripcion) VALUES (:P1,:P2,:P3)');
					$resultado=$sql->execute(array('P1'=>$_POST['nombre'], 'P2'=>$urlDocumento, 'P3'=>$_POST['descripcion']));
					$num=$sql->rowCount();

					if ($num>=1) {
						if(move_uploaded_file($tmp_name, $urlUpload)) {
							echo TRUE;
						}else{
							echo FALSE;
						}
					}else{
						echo FALSE;
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT * FROM manifiestos WHERE nombre LIKE "%":P1"%"');
					$resultado=$sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar manifiestos');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular manifiestos');

						echo '
							<table class="table table-hover">
								<tr>
									<th>Manifiesto</th>
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
									<input type="hidden" class="idManifiesto" value="'.$fila['id'].'">
									<td>'.$fila['nombre'].'</td>
									<td><a href="'.$fila['documento'].'"><span class="mdi mdi-file-pdf"></span></a></td>
									<td>'.$fila['descripcion'].'</td>
									<td>
										<div class="custom-control custom-switch" '.$anular.'>
											<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" '.$checked.'>
											<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
										</div>
									</td>
									<td>
										<button type="button" class="btn btn-warning btn-sm formEditarManifiesto" data-toggle="modal" data-target="#exampleModal" title="Editar Manifiesto" '.$editar.'>
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
						$sql=$con->prepare('UPDATE manifiestos SET fechaEliminacion=NOW() WHERE id=:P1');
					}else{
						$sql=$con->prepare('UPDATE manifiestos SET fechaEliminacion=NULL WHERE id=:P1');
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
					$sql=$con->prepare('SELECT * FROM manifiestos WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Manifiestos</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
				
								<div class="modal-body">
									<form class="forms-sample">
										<input type="hidden" id="id" value="'.$fila['id'].'">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Manifiesto* (Nombre Documento)</label>
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

										<button type="button" class="btn btn-primary mr-2" id="editarManifiesto" data-dismiss="modal">Guardar</button>
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
					$urlDocumento = $_SERVER['SERVER_NAME'].'/electronitech/assets/images/documentos/'.$filename;
					// $urlFirma = $_SERVER['SERVER_NAME'].'/assets/images/documentos/'.$filename;
					$urlUpload = '../assets/images/documentos/'.basename($filename);
					$tmp_name = $_FILES['documento']['tmp_name'];

					$sql=$con->prepare('UPDATE manifiestos SET nombre=:P2, documento=:P3, descripcion=:P4 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['nombre'], 'P3'=>$_POST['documento'], 'P4'=>$_POST['descripcion']));
					$num=$sql->rowCount();

					if ($num>=1) {
						if(move_uploaded_file($tmp_name, $urlUpload)) {
							echo TRUE;
						}else{
							echo FALSE;
						}
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