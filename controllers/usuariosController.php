<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function permisoExists($idUsuario, $idPermiso) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM permisos_usuarios WHERE idUsuario = :P1 AND idPermiso = :P2');
			$resultado=$sql->execute(array('P1'=>$idUsuario, 'P2'=>$idPermiso));
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();

			if ($num>=1) {
				return true;
			}else{
				return false;
			}
			$con=null;
		}

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM usuarios WHERE fechaEliminacion IS NULL');
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

		function getUsuarios($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM usuarios WHERE fechaEliminacion IS NULL LIMIT :P1,:P2');
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

		function individualPermiso($idUsuario, $idPermiso, $tipo) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM permisos_usuarios WHERE idUsuario = :P1 AND idPermiso = :P2 AND habilitado = 1');
			$resultado=$sql->execute(array('P1'=>$idUsuario, 'P2'=>$idPermiso));
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();

			if ($num>=1) {
				if ($tipo == 'checkbox') {
					return 'checked';
				}else{
					return TRUE;
				}
			}else{
				return FALSE;
			}
			$con=null;
		}

		require 'conexion.php';		

		if(isset($_POST['accion'])) {
			switch ($_POST['accion']) {
				case 'ingresar':
					if(isset($_FILES['firma'])){
						$filename = $_FILES['firma']['name'];
						$base = 'assets/images/firmasUsuarios/firma_'.uniqid().'.'.pathinfo($filename, PATHINFO_EXTENSION);
						$urlBD = ($_SERVER['SERVER_NAME'] == '127.0.0.1') ? '127.0.0.1/electronitech/'.$base : $_SERVER['SERVER_NAME'].'/'.$base;
						$urlUpload = '../'.$base;
						$tmp_name = $_FILES['firma']['tmp_name'];

						if(move_uploaded_file($tmp_name, $urlUpload)) {
							$sql=$con->prepare('INSERT INTO usuarios (nombres, apellidos, identificacion, username, password, email, cargo, celular, firmaDigital) VALUES (:P1,:P2,:P3,:P4,:P5,:P6,:P7,:P8,:P9)');
							$resultado=$sql->execute(array('P1'=>$_POST['nombres'], 'P2'=>$_POST['apellidos'], 'P3'=>$_POST['identificacion'], 'P4'=>$_POST['username'], 'P5'=>base64_encode($_POST['password']), 'P6'=>$_POST['email'], 'P7'=>$_POST['cargo'], 'P8'=>$_POST['celular'], 'P9'=>$urlBD));
							$num=$sql->rowCount();

							if ($num>=1) {
								echo TRUE;
							}else{
								echo FALSE;
							}
						}else{
							echo FALSE;
						}
					}else{
						$sql=$con->prepare('INSERT INTO usuarios (nombres, apellidos, identificacion, username, password, email, cargo, celular) VALUES (:P1,:P2,:P3,:P4,:P5,:P6,:P7,:P8)');
						$resultado=$sql->execute(array('P1'=>$_POST['nombres'], 'P2'=>$_POST['apellidos'], 'P3'=>$_POST['identificacion'], 'P4'=>$_POST['username'], 'P5'=>base64_encode($_POST['password']), 'P6'=>$_POST['email'], 'P7'=>$_POST['cargo'], 'P8'=>$_POST['celular']));
						$num=$sql->rowCount();

						if ($num>=1) {
							echo TRUE;
						}else{
							echo FALSE;
						}
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT * FROM usuarios WHERE (nombres LIKE "%":P1"%") OR (apellidos LIKE "%":P1"%") OR (identificacion LIKE "%":P1"%") OR (username LIKE "%":P1"%")');
					$resultado= $sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
					// var_dump($resultado);
					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar usuarios');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular usuarios');

						echo '
							
						<table class="table table-hover sort">
						<thead>
							<tr>
								<th>Nombressss</th>
								<th>Identificación</th>
								<th>Celular</th>
								<th>Username</th>
								<th>E-mail</th>
								<th>Cargo</th>
								<th class="no-sort">Firma</th>
								<th class="no-sort">Acción</th>
							</tr>
						</thead>
						';
						foreach ($resultado as $fila) {
							$firma = !empty($fila['firmaDigital']) ? '<a target="_blank" href="http://'.$fila['firmaDigital'].'"><span class="mdi mdi-file-pdf"></span></a>' : '';

							echo '
								<tr>
									<input type="hidden" class="idUsuario" value="'.$fila['id'].'">
									<td>'.$fila['nombres'].' '.$fila['apellidos'].'</td>
									<td>'.$fila['identificacion'].'</td>
									<td>'.$fila['celular'].'</td>
									<td>'.$fila['username'].'</td>
									<td>'.$fila['email'].'</td>
									<td>'.$fila['cargo'].'</td>
									<td>'.$firma.'</td>
									<td>
										<button type="button" class="btn btn-warning btn-sm formEditarUsuario" data-toggle="modal" data-target="#exampleModal" title="Editar Usuario" '.$editar.'>
											<span class="mdi mdi-pencil"></span>
										</button>

										<button type="button" class="btn btn-danger btn-sm formEliminarUsuario" data-toggle="modal" data-target=".modalWarning" title="Eliminar Usuario" '.$anular.'>
											<span class="mdi mdi-delete"></span>
										</button>

										<button type="button" class="btn btn-success btn-sm formEditarPermisos" data-toggle="modal" data-target="#exampleModal" title="Asignar Permisos" '.$editar.'>
											<span class="mdi mdi-key"></span>
										</button>
									</td>
								</tr>
							';
						}
						echo '</table>
								<label><a href="http://127.0.0.1/electronitech/views/usuarios/usuarios.php?pagina=1">VER TODOS</a></label>';
					}else{
						echo '<label><a href="http://127.0.0.1/electronitech/views/usuarios/usuarios.php?pagina=1">NO HAY RESULTADOS</a></label>';
						
					}
					break;	
				case 'editar':
					$filename = $_FILES['firma']['name'];
					$base = 'assets/images/firmasUsuarios/firma_'.uniqid().'.'.pathinfo($filename, PATHINFO_EXTENSION);
					$urlBD = ($_SERVER['SERVER_NAME'] == '127.0.0.1') ? '127.0.0.1/electronitech/'.$base : $_SERVER['SERVER_NAME'].'/'.$base;
					$urlUpload = '../'.$base;
					$tmp_name = $_FILES['firma']['tmp_name'];

					if(move_uploaded_file($tmp_name, $urlUpload)) {
						$sql=$con->prepare('UPDATE usuarios SET nombres=:P2, apellidos=:P3, identificacion=:P4, username=:P5, password=:P6, email=:P7, cargo=:P8, celular=:P9, firmaDigital=:P10 WHERE id=:P1');
						$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['nombres'], 'P3'=>$_POST['apellidos'], 'P4'=>$_POST['identificacion'], 'P5'=>$_POST['username'], 'P6'=>base64_encode($_POST['password']), 'P7'=>$_POST['email'], 'P8'=>$_POST['cargo'], 'P9'=>$_POST['celular'], 'P10'=>$urlBD));
						$num=$sql->rowCount();

						if ($num>=1) {
							echo TRUE;
						}else{
							echo FALSE;
						}
					}else{
						$sql=$con->prepare('UPDATE usuarios SET nombres=:P2, apellidos=:P3, identificacion=:P4, username=:P5, password=:P6, email=:P7, cargo=:P8, celular=:P9 WHERE id=:P1');
						$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['nombres'], 'P3'=>$_POST['apellidos'], 'P4'=>$_POST['identificacion'], 'P5'=>$_POST['username'], 'P6'=>base64_encode($_POST['password']), 'P7'=>$_POST['email'], 'P8'=>$_POST['cargo'], 'P9'=>$_POST['celular']));
						$num=$sql->rowCount();

						if ($num>=1) {
							echo TRUE;
						}else{
							echo FALSE;
						}
					}
					break;

				case 'eliminar':
					$sql=$con->prepare('UPDATE usuarios SET fechaEliminacion=NOW() WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				case 'especifico':
					$sql=$con->prepare('SELECT * FROM usuarios  WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
				
								<div class="modal-body">
									<form class="forms-sample">
										<input type="hidden" id="id" value="'.$fila['id'].'">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Nombres</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="nombres" placeholder="Nombres" value="'.$fila['nombres'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Apellidos</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="apellidos" placeholder="Apellidos" value="'.$fila['apellidos'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Identificación</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="identificacion" placeholder="Identificacion" value="'.$fila['identificacion'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Usuario</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="username" placeholder="Usuario" value="'.$fila['username'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Contraseña</label>
											<div class="col-sm-9">
												<input type="password" class="form-control" id="password" placeholder="Contraseña" value="'.base64_decode($fila['password']).'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">E-mail</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="email" placeholder="E-mail" value="'.$fila['email'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Cargo</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="cargo" value="'.$fila['cargo'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Celular</label>
											<div class="col-sm-9">
												<input type="text" class="form-control" id="celular" value="'.$fila['celular'].'">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Firma Digital</label>
											<div class="col-sm-9">
												<input type="file" class="form-control" id="firmaDigital">
											</div>
										</div>
										<button type="button" class="btn btn-primary mr-2" id="editarUsuario" data-dismiss="modal">Guardar</button>
										<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
									</form>
								</div>
							';
						}
					}else{
						echo FALSE;
					}
					break;

				case 'permisos':
					$sql=$con->prepare('SELECT * FROM permisos WHERE fechaEliminacion IS NULL');
					$resultado=$sql->execute(array());
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						$i=1;
						echo '
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Agregar Permiso</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							
							<div class="modal-body">			
								<table class="table table-hover">
									<tr>
										<th>Permiso</th>
										<th>Estado</th>
									</tr>
						';
						foreach ($resultado as $fila) {
							echo '
									<tr class="permisos filasResultado'.$i.'">
										<input type="hidden" id="idPermiso" value="'.$fila['id'].'">
										<input type="hidden" id="idUsuario" value="'.$_POST['id'].'">
										<td>'.$fila['nombre'].'</td>
										<td><input type="checkbox" '.individualPermiso($_POST['id'], $fila['id'], 'checkbox').'/></td>
									</tr>
							';
							$i++;
						}
						echo '
							</table><br>
							<button type="button" class="btn btn-primary mr-2" id="editarPermiso" data-dismiss="modal">Guardar</button>
							<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
						</div>
						';
					}else{
						echo FALSE;
					}
					break;
				case 'permisos-usuarios':
					$formulario=$_POST['formulario'];

					for ($i=0; $i<count($formulario); $i++) {
						if (permisoExists($formulario[$i]['idUsuario'], $formulario[$i]['idPermiso'])) {

							$sql=$con->prepare('UPDATE permisos_usuarios SET habilitado=:P3 WHERE idUsuario=:P1 AND idPermiso=:P2');
							$resultado=$sql->execute(array('P1'=>$formulario[$i]['idUsuario'], 'P2'=>$formulario[$i]['idPermiso'], 'P3'=>$formulario[$i]['check']));
							$num=$sql->rowCount();

							if ($num>=1) {
								echo TRUE;
							}else{
								echo FALSE;
							}
						}else{
							$sql=$con->prepare('INSERT INTO permisos_usuarios (idUsuario, idPermiso, habilitado) VALUES (:P1,:P2,:P3)');
							$resultado=$sql->execute(array('P1'=>$formulario[$i]['idUsuario'], 'P2'=>$formulario[$i]['idPermiso'], 'P3'=>$formulario[$i]['check']));
							$num=$sql->rowCount();

							if ($num>=1) {
								echo TRUE;
							}else{
								echo FALSE;
							}
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
