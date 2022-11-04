<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM equipos WHERE fechaEliminacion IS NULL');
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

		// PRINCIPAL
		function getEquipos($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT marcas.nombre AS marca, modelos.nombre AS modelo, equipos.* FROM equipos INNER JOIN marcas ON marcas.id=equipos.idMarca INNER JOIN modelos ON modelos.id=equipos.idModelo WHERE equipos.fechaEliminacion IS NULL LIMIT :P1,:P2');
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

		function getMarcas() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM marcas WHERE fechaEliminacion IS NULL');
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

		function getModelos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM modelos WHERE fechaEliminacion IS NULL');
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
		
		function getInvima() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM registros WHERE fechaEliminacion IS NULL');
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

		function getProveedores() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM proveedores WHERE fechaEliminacion IS NULL');
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

		function getFabricantes() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM fabricantes WHERE fechaEliminacion IS NULL');
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

		function getVariables() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM variablesMetrologicas WHERE fechaEliminacion IS NULL');
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

		function getNameInvima($nombre) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM registros WHERE id = :P1');
			$resultado=$sql->execute(array('P1'=>$nombre));
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();

			if ($num>=1) {
				foreach ($resultado as $fila) {
					return $fila['nombre'];
				}
			}else{
				return NULL;
			}
			$con=null;
		}

		function proveedoresName($id) {
			require 'conexion.php';
		
			$sql=$con->prepare('SELECT * FROM proveedores WHERE id = :P1');
			$resultado=$sql->execute(array('P1'=>$id));
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();
		
			if ($num>=1) {
				foreach ($resultado as $fila) {
					return $fila['nombre'];
				}
			}else{
				return NULL;
			}
			$con=null;
		}
		
		function fabricantesName($id) {
			require 'conexion.php';
		
			$sql=$con->prepare('SELECT * FROM fabricantes WHERE id = :P1');
			$resultado=$sql->execute(array('P1'=>$id));
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();
		
			if ($num>=1) {
				foreach ($resultado as $fila) {
					return $fila['nombre'];
				}
			}else{
				return NULL;
			}
			$con=null;
		}

		function variablesName($id) {
			require 'conexion.php';
		
			$sql=$con->prepare('SELECT * FROM variablesMetrologicas WHERE id = :P1');
			$resultado=$sql->execute(array('P1'=>$id));
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();
		
			if ($num>=1) {
				foreach ($resultado as $fila) {
					return $fila['nombre'];
				}
			}else{
				return NULL;
			}
			$con=null;
		}

		require 'conexion.php';		

		if(isset($_POST['accion'])) {
			switch ($_POST['accion']) {
				case 'ingresar':
					if(isset($_FILES['foto'])){
						$filename = $_FILES['foto']['name'];
						$base = 'assets/images/equipos/equipo'.uniqid().'.'.pathinfo($filename, PATHINFO_EXTENSION);
						$urlBD = ($_SERVER['SERVER_NAME'] == '127.0.0.1') ? '127.0.0.1/electronitech/'.$base : $_SERVER['SERVER_NAME'].'/'.$base;
						$urlUpload = '../'.$base;
						$tmp_name = $_FILES['foto']['tmp_name'];

						if(move_uploaded_file($tmp_name, $urlUpload)) {
							$sql=$con->prepare('INSERT INTO equipos (idMarca, idModelo, registro, vidaUtil, documento) VALUES (:P1,:P2,:P3,:P4,:P5)');
							$resultado=$sql->execute(array('P1'=>$_POST['idMarca'], 'P2'=>$_POST['idModelo'], 'P3'=>$_POST['idRegistro'], 'P4'=>$_POST['vidaUtil'], 'P5'=>$urlBD));
							$num=$sql->rowCount();
							$id=$con->lastInsertId();

							if ($num>=1) {						
								foreach (json_decode($_POST['items']) as $item) {
									$sql2=$con->prepare('INSERT INTO relaciones (modulo, pestana, nombre, valores, idPrincipal) VALUES (:P1,:P2,:P3,:P4,:P5)');
									$resultado2=$sql2->execute(array('P1'=>'equipos', 'P2'=>$item->pestana, 'P3'=>$item->nombre, 'P4'=>json_encode($item->valores), 'P5'=>$id));
								}
							}else{
								echo FALSE;
							}
						}else{
							echo FALSE;
						}
					}else {
						$sql=$con->prepare('INSERT INTO equipos (idMarca, idModelo, registro, vidaUtil) VALUES (:P1,:P2,:P3,:P4)');
						$resultado=$sql->execute(array('P1'=>$_POST['idMarca'], 'P2'=>$_POST['idModelo'], 'P3'=>$_POST['idRegistro'], 'P4'=>$_POST['vidaUtil']));
						$num=$sql->rowCount();
						$id=$con->lastInsertId();

						if ($num>=1) {						
							foreach (json_decode($_POST['items']) as $item) {
								$sql2=$con->prepare('INSERT INTO relaciones (modulo, pestana, nombre, valores, idPrincipal) VALUES (:P1,:P2,:P3,:P4,:P5)');
								$resultado2=$sql2->execute(array('P1'=>'equipos', 'P2'=>$item->pestana, 'P3'=>$item->nombre, 'P4'=>json_encode($item->valores), 'P5'=>$id));
							}
						}else{
							echo FALSE;
						}
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT marcas.nombre AS marca, modelos.nombre AS modelo, equipos.* FROM equipos INNER JOIN marcas ON marcas.id=equipos.idMarca INNER JOIN modelos ON modelos.id=equipos.idModelo WHERE marcas.nombre LIKE "%":P1"%"');
					$resultado=$sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar equipos');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular equipos');

						echo '
							<table class="table table-hover">
								<tr>
									<th>Foto</th>
									<th>Marca</th>
									<th>Modelo</th>
									<th>Registro</th>
									<th>Estado</th>
									<th>Acción</th>
								</tr>
						';
						foreach ($resultado as $fila) {
							$checked=($fila['fechaEliminacion']==NULL) ? 'checked' : '';
							echo '
								<tr>
									<input type="hidden" class="idEquipo" value="'.$fila['id'].'">
									<td><a href="'.$fila['documento'].'"><span class="mdi mdi-file-pdf"></span></a></td>
									<td>'.$fila['marca'].'</td>
									<td>'.$fila['modelo'].'</td>
									<td>'.$fila['registro'].'</td>
									<td>
										<div class="custom-control custom-switch" '.$anular.'>
											<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" '.$checked.'>
											<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
										</div>
									</td>
									<td>
										<button type="button" class="btn btn-warning btn-sm formEditarEquipo" data-toggle="modal" data-target=".bd-example-modal-lg" title="Editar Equipo" '.$editar.'>
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
				case 'editar':
					$filename = $_FILES['foto']['name'];
					$base = 'assets/images/equipos/equipo'.uniqid().'.'.pathinfo($filename, PATHINFO_EXTENSION);
					$urlBD = ($_SERVER['SERVER_NAME'] == '127.0.0.1') ? '127.0.0.1/electronitech/'.$base : $_SERVER['SERVER_NAME'].'/'.$base;
					$urlUpload = '../'.$base;
					$tmp_name = $_FILES['foto']['tmp_name'];

					if(move_uploaded_file($tmp_name, $urlLogo)) {
						$sql=$con->prepare('UPDATE equipos SET idMarca=:P2, idModelo=:P3, registro=:P4, vidaUtil=:P5, documento=:P6 WHERE id=:P1');
						$resultado=$sql->execute(array('P1'=>$_POST['idEquipo'], 'P2'=>$_POST['idMarca'], 'P3'=>$_POST['idModelo'], 'P4'=>$_POST['idRegistro'], 'P5'=>$_POST['vidaUtil'], 'P6'=>$urlBD));

						foreach (json_decode($_POST['items']) as $item) {
							if (isset($item->id)) {
								$sql2=$con->prepare('UPDATE relaciones SET modulo=:P2, pestana=:P3, nombre=:P4, valores=:P5 WHERE id=:P1');
								$resultado2=$sql2->execute(array('P1'=>$item->id, 'P2'=>'equipos', 'P3'=>$item->pestana, 'P4'=>$item->nombre, 'P5'=>json_encode($item->valores)));
							}else{
								$sql2=$con->prepare('INSERT INTO relaciones (modulo, pestana, nombre, valores, idPrincipal) VALUES (:P1,:P2,:P3,:P4,:P5)');
								$resultado2=$sql2->execute(array('P1'=>'equipos', 'P2'=>$item->pestana, 'P3'=>$item->nombre, 'P4'=>json_encode($item->valores), 'P5'=>$_POST['idEquipo']));
							}
						}
					}else {
						$sql=$con->prepare('UPDATE equipos SET idMarca=:P2, idModelo=:P3, registro=:P4, vidaUtil=:P5 WHERE id=:P1');
						$resultado=$sql->execute(array('P1'=>$_POST['idEquipo'], 'P2'=>$_POST['idMarca'], 'P3'=>$_POST['idModelo'], 'P4'=>$_POST['idRegistro'], 'P5'=>$_POST['vidaUtil']));

						foreach (json_decode($_POST['items']) as $item) {
							if (isset($item->id)) {
								$sql2=$con->prepare('UPDATE relaciones SET modulo=:P2, pestana=:P3, nombre=:P4, valores=:P5 WHERE id=:P1');
								$resultado2=$sql2->execute(array('P1'=>$item->id, 'P2'=>'equipos', 'P3'=>$item->pestana, 'P4'=>$item->nombre, 'P5'=>json_encode($item->valores)));
							}else{
								$sql2=$con->prepare('INSERT INTO relaciones (modulo, pestana, nombre, valores, idPrincipal) VALUES (:P1,:P2,:P3,:P4,:P5)');
								$resultado2=$sql2->execute(array('P1'=>'equipos', 'P2'=>$item->pestana, 'P3'=>$item->nombre, 'P4'=>json_encode($item->valores), 'P5'=>$_POST['idEquipo']));
							}
						}
					}
					break;

				case 'habilitar':
					if ($_POST['habilitado']==0) {
						$sql=$con->prepare('UPDATE equipos SET fechaEliminacion=NOW() WHERE id=:P1');
					}else{
						$sql=$con->prepare('UPDATE equipos SET fechaEliminacion=NULL WHERE id=:P1');
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
					$sql=$con->prepare('SELECT marcas.nombre AS marca, modelos.nombre AS modelo, equipos.* FROM equipos INNER JOIN marcas ON marcas.id=equipos.idMarca INNER JOIN modelos ON modelos.id=equipos.idModelo WHERE equipos.id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Equipo</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
					
								<div class="modal-body">
									<form>
										<ul class="nav nav-tabs" id="myTab" role="tablist">
											<li class="nav-item">
												<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" style="font-size: 0.8em;">Equipo</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="instalacion-tab" data-toggle="tab" href="#instalacion" role="tab" aria-controls="instalacion" aria-selected="false" style="font-size: 0.8em;">Reg Instalación</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="funcionamiento-tab" data-toggle="tab" href="#funcionamiento" role="tab" aria-controls="funcionamiento" aria-selected="false" style="font-size: 0.8em;">Reg Funcionamiento</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="invima-tab" data-toggle="tab" href="#invima" role="tab" aria-controls="invima" aria-selected="false" style="font-size: 0.8em;">Reg Invima</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="prove-tab" data-toggle="tab" href="#prove" role="tab" aria-controls="prove" aria-selected="false" style="font-size: 0.8em;">Proveedores</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="fabricantes-tab" data-toggle="tab" href="#fabricantes" role="tab" aria-controls="fabricantes" aria-selected="false" style="font-size: 0.8em;">Fabricantes</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="variables-tab" data-toggle="tab" href="#variables" role="tab" aria-controls="variables" aria-selected="false" style="font-size: 0.8em;">Variables Metrologicas</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="accesorios-tab" data-toggle="tab" href="#accesorios" role="tab" aria-controls="accesorios" aria-selected="false" style="font-size: 0.8em;">Accesorios</a>
											</li>
										</ul>
					
										<div class="tab-content" id="myTabContent">
											<!-- HOME -->
											<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
												<h4 class="card-title text-center">Equipo</h4>
												<input type="hidden" id="idEquipo" value="'.$fila['id'].'">
												<div class="form-group row">
													<label class="col-sm-3 col-form-label">Marca</label>
													<div class="col-sm-9">
														<select class="form-control form-control-sm" id="idMarca">
															<option value="'.$fila['idMarca'].'">'.$fila['marca'].'</option>';
																foreach (getMarcas() as $data) {
																	echo '<option value="'.$data['id'].'">'.$data['nombre'].'</option>';
																}
													echo '</select>
													</div>
												</div>
					
												<div class="form-group row">
													<label class="col-sm-3 col-form-label">Modelo</label>
													<div class="col-sm-9">
														<select class="form-control form-control-sm" id="idModelo">
															<option value="'.$fila['idModelo'].'">'.$fila['modelo'].'</option>'; 
																foreach (getModelos() as $data) {
																	echo '<option value="'.$data['id'].'">'.$data['nombre'].'</option>';
																}
														echo '</select>
													</div>
												</div>
					
												<div class="form-group row">
													<label class="col-sm-3 col-form-label">Tipo Registro Invima</label>
													<div class="col-sm-9">
														<select class="form-control form-control-sm" id="idRegistro">
															<option value="'.$fila['registro'].'">'.$fila['registro'].'</option>
															<option value="RS">REGISTRO SANITARIO</option>
															<option value="PC">PERMISO DE COMERCIALIZACIÓN</option>
															<option value="NR">NO REGISTRA</option>
														</select>
													</div>
												</div>
					
												<div class="form-group row">
													<label class="col-sm-3 col-form-label">Vida Util</label>
													<div class="col-sm-9">
														<input type="text" class="form-control form-control-sm" id="vidaUtil" value="'.$fila['vidaUtil'].'">
													</div>
												</div>
					
												<div class="form-group row">
													<label class="col-sm-3 col-form-label">Registro Fotografico</label>
													<div class="col-sm-9">
														<input type="file" class="form-control form-control-sm" id="foto">
													</div>									
												</div>
											</div>
											<!-- END HOME -->
							';
						}

						$sql=$con->prepare('SELECT * FROM relaciones WHERE modulo=:P1 AND idPrincipal=:P2 ORDER BY id');
						$resultado=$sql->execute(array('P1'=>'equipos', 'P2'=>$_POST['id']));
						$resultado=$sql->fetchAll();
						$num=$sql->rowCount();

						if ($num>=1) {
							echo '
								<!-- INSTALACIÓN -->
								<div class="tab-pane fade" id="instalacion" role="tabpanel" aria-labelledby="instalacion-tab">
									<h4 class="card-title text-center">Registro de Instalación</h4>
		
									<table class="table table-borderless table-hover table-sm">										
								';
							$a=1;
							foreach ($resultado as $fila) {
								if ($fila['pestana']=='instalacion') {									
									switch ($fila['nombre']) {										
										case 'fuenteAlimentacion':
											echo '
												<tr>
													<td>Fuente de Alimentación</td>
													<td></td>
													<td class="fuenteAlimentacion">
														<input type="hidden" id="idItem" value="'.$fila['id'].'">
														<select class="form-control form-control-sm" id="val1">															
															<option value="'.json_decode($fila['valores'])->val1.'">'.json_decode($fila['valores'])->val1.'</option>
															<option value="agua">Agua</option>
															<option value="gas">Gas</option>
															<option value="aire">Aire</option>
															<option value="vapor">Vapor</option>
															<option value="combustible">Combustible</option>
															<option value="electricidad">Electricidad</option>
															<option value="bacterias">Bacterias</option>
															<option value="energia solar">Energia Solar</option>
														</select>
													</td>
													<td></td>
													<td></td>
											';
											break;

										case 'tecnologiaDominante':
											echo '
													<td>Tecnologia Dominante</td>
													<td class="tecnologiaDominante">
														<input type="hidden" id="idItem" value="'.$fila['id'].'">
														<select class="form-control form-control-sm" id="val1">
															<option value="'.json_decode($fila['valores'])->val1.'">'.json_decode($fila['valores'])->val1.'</option>
															<option value="electrica">Electrica</option>
															<option value="electronica">Electronica</option>
															<option value="electromecanica">Electromecanica</option>
															<option value="mecanica">Mecanica</option>
															<option value="hidraulica">Hidraulica</option>
															<option value="neumatica">Neumatica</option>
														</select>
													</td>
												</tr>
											';
											break;

										case 'voltajeDeAlimentacion':
											echo '
												<tr class="voltajeDeAlimentacion">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Voltaje de Alimentación</td>
													<td>MAX</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td>MIN</td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>Unidad</td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="VAC">VAC</option>
															<option value="VDC">VDC</option>
														</select>
													</td>
												</tr>
											';
											break;

										case 'consumoDeCorriente':
											echo '
												<tr class="consumoDeCorriente">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Consumo de Corriente</td>
													<td>MAX</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td>MIN</td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>Unidad</td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="A">A</option>
															<option value="mA">mA</option>
														</select>
													</td>
												</tr>
											';
											break;

										case 'potenciaDisipada':
											echo '
												<tr class="potenciaDisipada">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Potencia Disipada</td>
													<td></td>
													<td><input type="text" class="form-control form-control-sm val1" value="'.json_decode($fila['valores'])->val1.'"></td>
													<td></td>
													<td></td>
													<td>Unidad</td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="VA">VA</option>
															<option value="W">W</option>
														</select>
													</td>
												</tr>
											';
											break;

										case 'frecuenciaElectrica':
											echo '
												<tr class="frecuenciaElectrica">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Frecuencia Eléctrica</td>
													<td></td>
													<td><input type="text" class="form-control form-control-sm val1" value="'.json_decode($fila['valores'])->val1.'"></td>
													<td></td>
													<td></td>
													<td>Unidad</td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="Hz">Hz</option>
														</select>
													</td>
												</tr>
											';
											break;
										case 'pesoEquipo':
											echo '
												<tr class="pesoEquipo">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Peso del Equipo</td>
													<td></td>
													<td><input type="text" class="form-control form-control-sm val1" value="'.json_decode($fila['valores'])->val1.'"></td>
													<td></td>
													<td></td>
													<td>Unidad</td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="g">g</option>
															<option value="Kg">Kg</option>
														</select>
													</td>
												</tr>
											';
											break;
										case 'presionAmbiente':
											echo '
												<tr class="presionAmbiente">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Presión Ambiente</td>
													<td></td>
													<td><input type="text" class="form-control form-control-sm val1" value="'.json_decode($fila['valores'])->val1.'"></td>
													<td></td>
													<td></td>
													<td>Unidad</td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="bar">bar</option>
															<option value="Pa">Pa</option>
															<option value="kPa">kPa</option>
															<option value="PSI">PSI</option>
															<option value="mmHg">mmHg</option>
															<option value="cmH2O">cmH2O</option>
														</select>
													</td>
												</tr>
											';
											break;
										case 'temperaturaOperativa':
											echo '
												<tr class="temperaturaOperativa">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Temperatura Operativa</td>
													<td>MAX</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td>MIN</td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>Unidad</td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="C">°C</option>
															<option value="F">°F</option>
															<option value="K">K</option>
														</select>
													</td>
												</tr>
											';
											break;
										case 'velocidadFlujo':
											echo '
												<tr class="velocidadFlujo">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Velocidad / Flujo Máximo</td>
													<td></td>
													<td><input type="text" class="form-control form-control-sm val1" value="'.json_decode($fila['valores'])->val1.'"></td>
													<td></td>
													<td></td>
													<td>Unidad</td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="RPM">RPM</option>
															<option value="L/m">L/m</option>
															<option value="L/h">L/h</option>
														</select>
													</td>
												</tr>
											';
											break;
										default:
											echo '
												<tr class="nuevoItemInstalacion nuevoItemInstalacion_'.$a.'">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td><input type="text" class="form-control form-control-sm nombre" value="'.$fila['nombre'].'"></td>
													<td>MAX</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td>MIN</td>
													<td><input type="text" class="form-control form-control-sm min"  value="'.json_decode($fila['valores'])->min.'"></td>
													<td>Unidad</td>
													<td><input type="text" class="form-control form-control-sm unidad"  value="'.json_decode($fila['valores'])->unidad.'"></td>
												</tr>
											';
											$a++;
											break;
									}
								}
							}
							echo '
									</table>
								</div>
								<!-- END INSTALACIÓN -->

								<!-- FUNCIONAMIENTO -->
								<div class="tab-pane fade" id="funcionamiento" role="tabpanel" aria-labelledby="funcionamiento-tab">
									<h4 class="card-title text-center">Registro Funcionamiento</h4>
		
									<table class="table table-borderless table-hover table-sm">
										<tr>
											<th>Descripción</th>
											<th>MAX</th>
											<th>MIN</th>
											<th>Unidad</th>
										</tr>
							';
							$b=1;
							foreach ($resultado as $fila) {
								if ($fila['pestana']=='funcionamiento') {
									$cont=0;
									switch ($fila['nombre']) {										
										case 'voltajeGenerado':
											echo '
												<tr class="voltajeGenerado">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Voltaje Generado</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="mV">mV</option>
															<option value="uV">uV</option>
														</select>
													</td>
												</tr>
											';
											break;

										case 'corrienteFuga':
											echo '
												<tr class="corrienteFuga">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Corriente de Fuga (Paciente)</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="mV">mV</option>
															<option value="uV">uV</option>
															<option value="nA">nA</option>
														</select>
													</td>
												</tr>
											';
											break;

										case 'potenciaIrradiada':
											echo '
												<tr class="potenciaIrradiada">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Potencia Irradiada</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="W">W</option>
															<option value="VA">VA</option>
															<option value="Lux">Lux</option>
														</select>
													</td>
												</tr>
											';
											break;

										case 'frecuenciaOperacion':
											echo '
												<tr class="frecuenciaOperacion">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Frecuencia de Operación/Ritmo/Ecg</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="ppm">ppm</option>
															<option value="bpm">bpm</option>
															<option value="ipm">ipm</option>
															<option value="Hz">Hz</option>
															<option value="kHz">kHz</option>
														</select>
													</td>
												</tr>
											';
											break;

										case 'controlPresion':
											echo '
												<tr class="controlPresion">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Control de Presión</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="bar">bar</option>
															<option value="Pa">Pa</option>
															<option value="kPa">kPa</option>
															<option value="PSI">PSI</option>
															<option value="mmHg">mmHg</option>
															<option value="cmH2O">cmH2O</option>
														</select>
													</td>
												</tr>
											';
											break;

										case 'controlVelocidad':
											echo '
												<tr class="controlVelocidad">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Control de Velocidad/Flujo</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="RPPM">RPPM</option>
															<option value="L/m">L/m</option>
															<option value="L/h">L/h</option>
														</select>
													</td>
												</tr>
											';
											break;
										case 'pesoSoportado':
											echo '
												<tr class="pesoSoportado">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Peso Soportado</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="Kg">Kg</option>
														</select>
													</td>
												</tr>
											';
											break;
										case 'controlTemperatura':
											echo '
												<tr class="controlTemperatura">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Control de Temperatura</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="C">°C</option>
															<option value="F">°F</option>
															<option value="K">K</option>
														</select>
													</td>
												</tr>
											';
											break;
										case 'controlHumedad':
											echo '
												<tr class="controlHumedad">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Control de Humedad</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="%">%</option>
														</select>
													</td>
												</tr>
											';
											break;
										case 'controlEnergia':
											echo '
												<tr class="controlEnergia">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Control de Energía</td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td><input type="text" class="form-control form-control-sm min" value="'.json_decode($fila['valores'])->min.'"></td>
													<td>
														<select class="form-control form-control-sm unidad">
															<option value="'.json_decode($fila['valores'])->unidad.'">'.json_decode($fila['valores'])->unidad.'</option>
															<option value="J">J</option>
														</select>
													</td>
												</tr>
											';
											break;											
										default:											
											echo '
												<tr class="nuevoItemFuncionamiento nuevoItemFuncionamiento_'.$b.'">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td><input type="text" class="form-control form-control-sm nombre" value="'.$fila['nombre'].'"></td>
													<td><input type="text" class="form-control form-control-sm max" value="'.json_decode($fila['valores'])->max.'"></td>
													<td><input type="text" class="form-control form-control-sm min"  value="'.json_decode($fila['valores'])->min.'"></td>
													<td><input type="text" class="form-control form-control-sm unidad"  value="'.json_decode($fila['valores'])->unidad.'"></td>
												</tr>
											';
											$b++;
											break;
									}
								}
							}
							echo '
									</table>
								</div>
								<!-- END FUNCIONAMIENTO -->

								<!-- INVIMA -->
								<div class="tab-pane fade" id="invima" role="tabpanel" aria-labelledby="invima-tab">
									<h4 class="card-title text-center">Registro Invima</h4>

									<table class="table table-borderless table-hover table-sm">
							';
							$c=1;
							foreach ($resultado as $fila) {
								if ($fila['pestana']=='invima') {
									echo '
										<tr class="nuevoItemInvima nuevoItemInvima_'.$c.'">
											<input type="hidden" id="idItem" value="'.$fila['id'].'">
											<td>
												<select class="form-control form-control-sm" id="val1">
													<option value="'.json_decode($fila['valores'])->val1.'">'.getNameInvima(json_decode($fila['valores'])->val1).'</option>';
													foreach (getInvima() as $data) {
														echo '<option value="'.$data['id'].'">'.$data['nombre'].'</option>';
													}
												echo '</select>
											</td>
										</tr>
									';		
									$c++;
								}
							}
							echo '
									</table><br>
									<div class="col text-center">
										<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevoInvima" data-invima="'.($c-1).'"><span class="mdi mdi-plus"></span> Agregar Item</button>
									</div>
								</div>
								<!-- END INVIMA -->

								<!-- PROVEEDORES -->
								<div class="tab-pane fade" id="prove" role="tabpanel" aria-labelledby="prove-tab">
									<h4 class="card-title text-center">Proveedores</h4>

									<table class="table table-borderless table-hover table-sm">
							';
							$d=1;
							foreach ($resultado as $fila) {
								if ($fila['pestana']=='proveedores') {
									echo '
										<tr class="nuevoItemProveedor nuevoItemProveedor_'.$d.'">
											<input type="hidden" id="idItem" value="'.$fila['id'].'">
											<td>
												<select class="form-control form-control-sm" id="val1">
													<option value="'.json_decode($fila['valores'])->val1.'">'.proveedoresName(json_decode($fila['valores'])->val1).'</option>';
													foreach (getProveedores() as $data) {
														echo '<option value="'.$data['id'].'">'.$data['nombre'].'</option>';
													}
												echo '</select>
											</td>
										</tr>
									';
									$d++;
								}
							}
							echo '
									</table><br>
									<div class="col text-center">
										<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevoProveedor" data-prove="'.($d-1).'"><span class="mdi mdi-plus"></span> Agregar Item</button>
									</div>
								</div>
								<!-- END PROVEEDORES -->

								<!-- FABRICANTES -->
								<div class="tab-pane fade" id="fabricantes" role="tabpanel" aria-labelledby="fabricantes-tab">
									<h4 class="card-title text-center">Fabricantes</h4>
		
									<table class="table table-borderless table-hover table-sm">
							';
							$e=1;
							foreach ($resultado as $fila) {
								if ($fila['pestana']=='fabricantes') {
									echo '
										<tr class="nuevoItemFabricante nuevoItemFabricante_'.$e.'">
											<input type="hidden" id="idItem" value="'.$fila['id'].'">
											<td>
												<select class="form-control form-control-sm" id="val1">
													<option value="'.json_decode($fila['valores'])->val1.'">'.fabricantesName(json_decode($fila['valores'])->val1).'</option>';
													foreach (getFabricantes() as $data) {
														echo '<option value="'.$data['id'].'">'.$data['nombre'].'</option>';
													}
												echo '</select>
											</td>
										</tr>
									';
									$e++;
								}
							}
							echo '
									</table><br>
									<div class="col text-center">
										<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevoFabricante" data-fabricante="'.($e-1).'"><span class="mdi mdi-plus"></span> Agregar Item</button>
									</div>
								</div>
								<!-- END FABRICANTES -->

								<!-- VARIABLES METROLOGICAS -->
								<div class="tab-pane fade" id="variables" role="tabpanel" aria-labelledby="variables-tab">
									<h4 class="card-title text-center">Variable Metrologicas</h4>
		
									<table class="table table-borderless table-hover table-sm">
										<tr>
											<th>Variable</th>
											<th>Precision / Exactitud</th>
											<th>Unidad</th>
										</tr>
							';
							$f=1;
							foreach ($resultado as $fila) {
								if ($fila['pestana']=='variables') {
									echo '
										<tr class="nuevoItemVariable nuevoItemVariable_'.$f.'">
											<input type="hidden" id="idItem" value="'.$fila['id'].'">
											<td>
												<select class="form-control form-control-sm" id="idVariable">
												<option value="'.json_decode($fila['valores'])->val1.'">'.variablesName(json_decode($fila['valores'])->val1).'</option>';
														foreach (getVariables() as $data) {
															echo '<option value="'.$data['id'].'">'.$data['nombre'].'</option>';
														}
											echo '</select>
											</td>
											<td><input type="number" class="form-control form-control-sm" id="presicion" value="'.json_decode($fila['valores'])->val2.'" ></td>
											<td>
												<select class="form-control form-control-sm" id="unidad">
													<option value="'.json_decode($fila['valores'])->val3.'">'.json_decode($fila['valores'])->val3.'</option>
													<option value="porcentaje">Porcentaje</option>
													<option value="numerico">Numerico</option>
												</select>
											</td>
										</tr>
									';
									$f++;
								}
							}
							echo '
									</table><br>
									<div class="col text-center">
										<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevaVariable" data-variable="'.($f-1).'"><span class="mdi mdi-plus"></span> Agregar Item</button>
									</div>
								</div>
								<!-- END VARIABLES METROLOGICAS -->

								<!-- ACCESORIOS -->
								<div class="tab-pane fade" id="accesorios" role="tabpanel" aria-labelledby="accesorios-tab">
									<h4 class="card-title text-center">Accesorios</h4>

									<table class="table table-borderless table-hover table-sm">
										<tr>
											<th>Descripción</th>
											<th>Marca / Referencia</th>
										</tr>
							';
							$g=1;
							foreach ($resultado as $fila) {
								if ($fila['pestana']=='accesorios') {
									echo '
										<tr class="nuevoItemAccesorio nuevoItemAccesorio_'.$g.'">
											<input type="hidden" id="idItem" value="'.$fila['id'].'">	
											<td><input type="text" class="form-control form-control-sm" id="descripcion" value="'.json_decode($fila['valores'])->val1.'"></td>
											<td><input type="text" class="form-control form-control-sm" id="referencia" value="'.json_decode($fila['valores'])->val2.'"></td>
										</tr>
									';
									$g++;
								}
							}
							echo '
									</table><br>
									<div class="col text-center">
										<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevoAccesorio" data-accesorio="'.($g-1).'"><span class="mdi mdi-plus"></span> Agregar Item</button>
									</div>
								</div>
								<!-- END ACCESORIOS -->
							</div><br>

							<button type="button" class="btn btn-primary mr-2" id="editarEquipo" data-dismiss="modal">Guardar</button>
							<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
						</form>
							';
						}
					}
					break;

				case 'getModelo':
					$sql=$con->prepare('SELECT * FROM modelos WHERE idMarca = :P1 AND fechaEliminacion IS NULL');
					$resultado=$sql->execute(array('P1'=>$_POST['idMarca']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
						}
					}else{
						echo '<option disabled>NO EXISTEN MODELOS DE ESTA MARCA</option>';
					}	
					break;
				case 'getInvima':
					$sql=$con->prepare('SELECT * FROM registros WHERE fechaEliminacion IS NULL');
					$resultado=$sql->execute();
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						echo '
							<tr class="nuevoItemInvima nuevoItemInvima_'.$_POST['numero'].'">
								<td>
									<select class="form-control form-control-sm" id="val1">
										<option value="NaN">Seleccione</option>
						';
						foreach ($resultado as $fila) {
							echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
						}
						echo '
									</select>
								</td>
								<td>
									<button type="button" onclick="eliminarFila(\'nuevoInvima\', \'invima\')" class="btn btn-sm btn-danger"><span class="mdi mdi-close"></span></button>
								</td>
							</tr>
						';
					}else{
						echo '<option disabled>NO EXISTEN REGISTROS INVIMA</option>';
					}	
					break;
				case 'getProveedores':
					$sql=$con->prepare('SELECT * FROM proveedores WHERE fechaEliminacion IS NULL');
					$resultado=$sql->execute();
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						echo '
							<tr class="nuevoItemProveedor nuevoItemProveedor_'.$_POST['numero'].'">
								<td>
									<select class="form-control form-control-sm" id="val1">
										<option value="NaN">Seleccione</option>
						';
						foreach ($resultado as $fila) {
							echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
						}
						echo '
									</select>
								</td>
								<td>
									<button type="button" onclick="eliminarFila(\'nuevoProveedor\', \'prove\')" class="btn btn-sm btn-danger"><span class="mdi mdi-close"></span></button>
								</td>
							</tr>
						';
					}else{
						echo '<option disabled>NO EXISTEN PROVEEDORES</option>';
					}	
					break;
				case 'getFabricantes':
					$sql=$con->prepare('SELECT * FROM fabricantes WHERE fechaEliminacion IS NULL');
					$resultado=$sql->execute();
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						echo '
							<tr class="nuevoItemFabricante nuevoItemFabricante_'.$_POST['numero'].'">
								<td>
									<select class="form-control form-control-sm" id="val1">
										<option value="NaN">Seleccione</option>
						';
						foreach ($resultado as $fila) {
							echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
						}
						echo '
									</select>
								</td>
								<td>
									<button type="button" onclick="eliminarFila(\'nuevoFabricante\', \'fabricante\')" class="btn btn-sm btn-danger"><span class="mdi mdi-close"></span></button>
								</td>
							</tr>
						';
					}else{
						echo '<option disabled>NO EXISTEN FABRICANTES</option>';
					}
					break;
				case 'getVariables':
					$sql=$con->prepare('SELECT * FROM variablesMetrologicas WHERE fechaEliminacion IS NULL');
					$resultado=$sql->execute();
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						echo '
							<tr class="nuevoItemVariable nuevoItemVariable_'.$_POST['numero'].'">
								<td>
									<select class="form-control form-control-sm" id="idVariable">
										<option value="NaN">Seleccione</option>
						';
						foreach ($resultado as $fila) {
							echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
						}
						echo '
									</select>
								</td>
								<td><input type="text" class="form-control form-control-sm" value="0" id="presicion"></td>
								<td>
									<select class="form-control form-control-sm" id="unidad">
										<option value="NaN">Seleccione</option>
										<option value="porcentaje">Porcentaje</option>
										<option value="numerico">Numerico</option>
									</select>
								</td>
								<td>
									<button type="button" onclick="eliminarFila(\'nuevaVariable\', \'variable\')" class="btn btn-sm btn-danger"><span class="mdi mdi-close"></span></button>
								</td>
							</tr>
						';
					}else{
						echo '<option disabled>NO EXISTEN FABRICANTES</option>';
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