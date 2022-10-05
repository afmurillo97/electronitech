<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM clientes WHERE fechaEliminacion IS NULL');
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

		function getClientes($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM clientes WHERE fechaEliminacion IS NULL LIMIT :P1,:P2');
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

		function getFullClientes() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM clientes WHERE fechaEliminacion IS NULL');
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

		function getServicios() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM servicios WHERE fechaEliminacion IS NULL');
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
					$filename = $_FILES['logo']['name'];
					$urlLogo = $_SERVER['SERVER_NAME'].'/electronitech/assets/images/logos/'.$filename;
					// $urlLogo = $_SERVER['SERVER_NAME'].'/assets/images/firmas/'.$filename;
					$urlUpload = '../assets/images/logos/'.basename($filename);
					$tmp_name = $_FILES['logo']['tmp_name'];

					$filename2 = $_FILES['imgEncabezado']['name'];
					$urlEncabezado = $_SERVER['SERVER_NAME'].'/electronitech/assets/images/encabezados/'.$filename2;
					// $urlEncabezado = $_SERVER['SERVER_NAME'].'/assets/images/firmas/'.$filename;
					$urlUpload2 = '../assets/images/encabezados/'.basename($filename2);
					$tmp_name2 = $_FILES['imgEncabezado']['tmp_name'];

					$sql=$con->prepare('INSERT INTO clientes (nombre, nit, codigo, juridica, representante, direccion, telefono, celular, email, observacion, logo, encabezado, imgEncabezado) VALUES (:P1,:P2,:P3,:P4,:P5,:P6,:P7,:P8,:P9,:P10,:P11,:P12,:P13)');
					$resultado=$sql->execute(array('P1'=>$_POST['nombre'], 'P2'=>$_POST['nit'], 'P3'=>$_POST['codigo'], 'P4'=>$_POST['juridica'], 'P5'=>$_POST['representante'], 'P6'=>$_POST['direccion'], 'P7'=>$_POST['telefono'], 'P8'=>$_POST['celular'], 'P9'=>$_POST['email'], 'P10'=>$_POST['observacion'], 'P11'=>$urlLogo, 'P12'=>$_POST['encabezado'], 'P13'=>$urlEncabezado));
					$num=$sql->rowCount();

					if ($num>=1) {
						if(move_uploaded_file($tmp_name, $urlLogo)) {
							if(move_uploaded_file($tmp_name2, $urlEncabezado)) {
								echo TRUE;
							}else{
								echo FALSE;
							}
						}else{
							echo FALSE;
						}
					}else{
						echo FALSE;
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT * FROM clientes WHERE nombre LIKE "%":P1"%"');
					$resultado=$sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar clientes');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular clientes');

						echo '
							<table class="table table-hover">
								<tr>
									<th>Nombre</th>
									<th>Nit</th>
									<th>Dirección</th>
									<th>Telefono</th>
									<th>E-mail</th>
									<th>Estado</th>
									<th>Acción</th>
								</tr>
						';
						foreach ($resultado as $fila) {
							$checked=($fila['fechaEliminacion']==NULL) ? 'checked' : '';
							echo '
								<tr>
									<input type="hidden" class="idCliente" value="'.$fila['id'].'">
									<td>'.$fila['nombre'].'</td>
									<td>'.$fila['nit'].'</td>
									<td>'.json_decode($fila['direccion'])[0].'</td>
									<td>'.$fila['telefono'].'</td>
									<td>'.$fila['email'].'</td>
									<td>
										<div class="custom-control custom-switch" '.$anular.'>
											<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" '.$checked.'>
											<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
										</div>
									</td>
									<td>
										<button type="button" class="btn btn-warning btn-sm formEditarCliente" data-toggle="modal" data-target=".bd-example-modal-lg" title="Editar Cliente" '.$editar.'>
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
						$sql=$con->prepare('UPDATE clientes SET fechaEliminacion=NOW() WHERE id=:P1');
					}else{
						$sql=$con->prepare('UPDATE clientes SET fechaEliminacion=NULL WHERE id=:P1');
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
					$sql=$con->prepare('SELECT * FROM clientes WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>

								<div class="modal-body">
									<form>
										<input type="hidden" id="id" value="'.$fila['id'].'">
										<div class="row">
											<div class="col">
												<div class="form-group">
													<label class="col-sm-3 col-form-label">Nombre</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="nombre" value="'.$fila['nombre'].'">
													</div>
												</div>
											</div>

											<div class="col">
												<div class="form-group">
													<label class="col-sm-3 col-form-label">Nit</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="nit" value="'.$fila['nit'].'">
													</div>
												</div>
											</div>

											<div class="col">
												<div class="form-group">
													<label class="col-sm-6 col-form-label">Código REPS</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="codigo" value="'.$fila['codigo'].'">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col">
												<div class="form-group">
													<label class="col-sm-6 col-form-label">Naturaleza Jurídica</label>
													<div class="col-sm-9">
														<select class="form-control" id="juridica">														
															<option value="'.$fila['juridica'].'">'.$fila['juridica'].'</option>
															<option value="publica">Publica</option>
															<option value="mixta">Mixta</option>
															<option value="privada">Privada</option>
														</select>
													</div>
												</div>
											</div>

											<div class="col">
												<div class="form-group">
													<label class="col-sm-3 col-form-label">Representante</label>
													<div class="col-sm-9">
														<input type="text" class="form-control" id="representante" value="'.$fila['representante'].'">
													</div>
												</div>
											</div>

											<div class="col">
												<div class="form-group">
													<label class="col-sm-3 col-form-label">Télefono</label>
													<div class="col-sm-9">
														<input type="number" class="form-control" id="telefono" value="'.$fila['telefono'].'">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col">
												<div class="form-group">
													<label class="col-sm-3 col-form-label">Celular</label>
													<div class="col-sm-9">
														<input type="number" class="form-control" id="celular" value="'.$fila['celular'].'">
													</div>
												</div>
											</div>

											<div class="col direcciones">
												<div class="form-group">
													<label class="col-sm-3 col-form-label">Dirección</label>
													<div class="col-sm-9 form-inline">';
														$cantidad=count(json_decode($fila['direccion']));
														$direccion = json_decode($fila['direccion']);

														echo '<input type="text" class="form-control" id="direccion_1" value="'.$direccion[0].'">&nbsp;
														<button type="button" class="btn btn-primary nuevaDireccion" data-numero="'.$cantidad.'">+</button>
													</div>
												</div>';

												for ($i=1; $i<$cantidad; $i++) {
													$j=$i+1;
													echo '<div class="form-group"><div class="col-sm-9 form-inline"><input type="text" class="form-control" id="direccion_'.$j.'" value="'.$direccion[$i].'"></div></div>';
												}
													
										echo '</div>

											<div class="col">
												<div class="form-group">
													<label class="col-sm-3 col-form-label">E-mail</label>
													<div class="col-sm-9">
														<input type="email" class="form-control" id="email" value="'.$fila['email'].'">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col">
												<div class="form-group">
													<label class="col-sm-3 col-form-label">Observación</label>
													<div class="col-sm-11">
														<textarea class="form-control" id="observacion" placeholder="Observación" rows="3">'.$fila['observacion'].'</textarea>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col">
												<div class="form-group">
													<label class="col-sm-3 col-form-label">Logo</label>
													<div class="col-sm-9">
														<input type="file" class="form-control" id="logo">
													</div>
												</div>
											</div>

											<div class="col">
												<div class="form-group">
													<label class="col-sm-3 col-form-label">Encabezado</label>
													<div class="col-sm-9">
														<select class="form-control" id="encabezado">
															<option value="'.$fila['encabezado'].'">'.$fila['encabezado'].'</option>
															<option value="si">Si</option>
															<option value="no">No</option>
														</select>
													</div>
												</div>
											</div>

											<div class="col">
												<div class="form-group">
													<label class="col-sm-6 col-form-label">Imagen Encabezado</label>
													<div class="col-sm-9">
														<input type="file" class="form-control" id="imgEncabezado">
													</div>
												</div>
											</div>
										</div>

										<button type="button" class="btn btn-primary mr-2" id="editarCliente" data-dismiss="modal">Guardar</button>
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
					if(!empty($_FILES['logo']['type'])){
						$filename = $_FILES['logo']['name'];
						$urlLogo = $_SERVER['SERVER_NAME'].'/electronitech/assets/images/logos/'.$filename;
						// $urlLogo = $_SERVER['SERVER_NAME'].'/assets/images/firmas/'.$filename;
						$urlUpload = '../assets/images/logos/'.basename($filename);
						$tmp_name = $_FILES['logo']['tmp_name'];
					}else{
						$urlLogo = '';
					}

					if(!empty($_FILES['imgEncabezado']['type'])){
						$filename2 = $_FILES['imgEncabezado']['name'];
						$urlEncabezado = $_SERVER['SERVER_NAME'].'/electronitech/assets/images/encabezados/'.$filename2;
						// $urlEncabezado = $_SERVER['SERVER_NAME'].'/assets/images/firmas/'.$filename;
						$urlUpload2 = '../assets/images/encabezados/'.basename($filename2);
						$tmp_name2 = $_FILES['imgEncabezado']['tmp_name'];
					}else{
						$urlEncabezado = '';
					}

					$sql=$con->prepare('UPDATE clientes SET nombre=:P2, nit=:P3, codigo=:P4, juridica=:P5, representante=:P6, direccion=:P7, telefono=:P8, celular=:P9, email=:P10, observacion=:P11, logo=:P12, encabezado=:P13, imgEncabezado=:P14 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['nombre'], 'P3'=>$_POST['nit'], 'P4'=>$_POST['codigo'], 'P5'=>$_POST['juridica'], 'P6'=>$_POST['representante'], 'P7'=>$_POST['direccion'], 'P8'=>$_POST['telefono'], 'P9'=>$_POST['celular'], 'P10'=>$_POST['email'], 'P11'=>$_POST['observacion'], 'P12'=>$urlLogo, 'P13'=>$_POST['encabezado'], 'P14'=>$urlEncabezado));
					$num=$sql->rowCount();

					if ($num>=1) {
						if(move_uploaded_file($tmp_name, $urlLogo)) {
							if(move_uploaded_file($tmp_name2, $urlEncabezado)) {
								echo TRUE;
							}else{
								echo FALSE;
							}
						}else{
							echo FALSE;
						}
					}else{
						echo FALSE;
					}
					break;
				case 'asignarServicio':
					echo '
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Asignar Servicios Hospitalarios</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">
							<form>
								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Clientes</label>
									<div class="col-sm-9">
										<select class="form-control" id="idCliente">
											<option value="-1">Seleccione</option>';
											foreach (getFullClientes() as $fila) {
												echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
											}
									echo '</select>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Dirección</label>
									<div class="col-sm-9">
										<select class="form-control" id="direccion"></select>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Servicio</label>
									<div class="col-sm-9">
										<select class="form-control" id="servicio">
											<option value="-1">Seleccione</option>';
											foreach (getServicios() as $fila) {
												echo '<option value="'.$fila['id'].'">'.$fila['descripcion'].'</option>';
											}
									echo '</select>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 col-form-label">Codigo Habilitación</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" placeholder="Codigo Habilitación" id="codigo">
									</div>
								</div>

								<button type="button" class="btn btn-primary mr-2" id="nuevoAsignarServicio" data-dismiss="modal">Guardar</button>
								<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
							</form>
						</div>
					';
					break;
				case 'cargarDireccion':
					$sql=$con->prepare('SELECT * FROM clientes WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						foreach ($resultado as $fila) {
							$cantidad=count(json_decode($fila['direccion']));
							$direccion = json_decode($fila['direccion']);

							for ($i=0; $i<$cantidad; $i++) {
								echo '<option value="'.$direccion[$i].'">'.$direccion[$i].'</option>';
							}							
						}
					}
					break;
				case 'nuevoAsignarServicio':
					$sql=$con->prepare('INSERT INTO asignarServicios (idCliente, direccion, idServicio, codigo) VALUES (:P1,:P2,:P3,:P4)');
					$resultado=$sql->execute(array('P1'=>$_POST['idCliente'], 'P2'=>$_POST['direccion'], 'P3'=>$_POST['servicio'], 'P4'=>$_POST['codigo']));
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