<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM articulosView WHERE fechaEliminacion IS NULL');
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
		function getArticulos($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM articulosView WHERE fechaEliminacion IS NULL ORDER BY id DESC LIMIT :P1,:P2');
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

		function getClientes() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM clientes WHERE fechaEliminacion IS NULL ORDER BY nombre');
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

		function getTipoEquipo() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT tipoequipo.id AS id, ecri.codigo AS codigo, ecri.nombre AS nombre, descripcionbiomedica.nombre AS descripcion FROM tipoequipo INNER JOIN ecri ON ecri.id=tipoequipo.idEcri INNER JOIN descripcionbiomedica ON descripcionbiomedica.id=tipoequipo.idDescripcionBiomedica WHERE tipoequipo.fechaEliminacion IS NULL ORDER BY ecri.nombre');
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

		function getRegistros() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM registros WHERE fechaEliminacion IS NULL ORDER BY nombre');
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

		function getEquipos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT equipos.id, marcas.nombre AS marca, modelos.nombre AS modelo FROM equipos INNER JOIN marcas ON marcas.id=equipos.idMarca INNER JOIN modelos ON modelos.id=equipos.idModelo WHERE equipos.fechaEliminacion IS NULL ORDER BY marcas.nombre');
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

		function getManifiestos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM manifiestos WHERE fechaEliminacion IS NULL');
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

		function getFullServicios($idCliente, $direccion) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT servicios.id, servicios.descripcion FROM asignarServicios INNER JOIN servicios ON servicios.id=asignarServicios.idServicio WHERE asignarServicios.idCliente = :P1 AND asignarServicios.direccion = :P2');
			$resultado=$sql->execute(array('P1'=>$idCliente, 'P2'=>$direccion));
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();

			if ($num>=1) {
				return $resultado;
			}else{
				return NULL;
			}
			$con=null;
		}

		function getDireccionesCliente($id) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM clientes WHERE id = :P1');
			$resultado=$sql->execute(array('P1'=>$id));
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();

			if ($num>=1) {
				foreach ($resultado as $fila) {
					$cantidad=count(json_decode($fila['direccion']));
					$direccion=json_decode($fila['direccion']);

					return array($cantidad, $direccion);
				}
			}else{
				return NULL;
			}
			$con=null;
		}

		function getFullRegistros($id) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM relaciones WHERE idPrincipal = :P1 AND nombre = :P2');
			$resultado=$sql->execute(array('P1'=>$id, 'P2'=>'invima'));
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();

			if ($num>=1) {
				return $resultado;
			}else{
				return NULL;
			}
			$con=null;
		}

		function manifiestosName($id) {
			require 'conexion.php';
		
			$sql=$con->prepare('SELECT * FROM manifiestos WHERE id = :P1');
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

		function getTemporal() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM temporal ORDER BY id DESC LIMIT 1');
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

		function clientesName($id) {
			require 'conexion.php';
		
			$sql=$con->prepare('SELECT * FROM clientes WHERE id = :P1');
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

		function validacionReporte($id){
			require 'conexion.php';
		
			$sql=$con->prepare('SELECT * FROM reportes WHERE id = :P1');
			$resultado=$sql->execute(array('P1'=>$id));
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();
		
			if ($num>=1) {
				return TRUE;
			}else{
				return NULL;
			}
			$con=null;
		}

		require 'conexion.php';

		if(isset($_POST['accion'])) {
			switch ($_POST['accion']) {
				case 'ingresar':
					$sql=$con->prepare('INSERT INTO articulos (idCliente, direccion, idServicio, serie, tipo, inventario, idTipoEquipo, idEquipo, idRegistro, ubicacion, codDoc) VALUES (:P1,:P2,:P3,:P4,:P5,:P6,:P7,:P8,:P9,:P10,:P11)');
					$resultado=$sql->execute(array('P1'=>$_POST['idCliente'], 'P2'=>$_POST['direccion'], 'P3'=>$_POST['idServicio'], 'P4'=>$_POST['serie'], 'P5'=>$_POST['tipo'], 'P6'=>$_POST['inventario'], 'P7'=>$_POST['idTipoEquipo'], 'P8'=>$_POST['idEquipo'], 'P9'=>$_POST['idRegistro'], 'P10'=>$_POST['ubicacion'], 'P11'=>$_POST['codDoc']));
					$num=$sql->rowCount();
					$id=$con->lastInsertId();

					if ($num>=1) {
						foreach (json_decode($_POST['items']) as $item) {
							$sql2=$con->prepare('INSERT INTO relaciones (modulo, pestana, nombre, valores, idPrincipal) VALUES (:P1,:P2,:P3,:P4,:P5)');
							$resultado2=$sql2->execute(array('P1'=>'articulos', 'P2'=>$item->pestana, 'P3'=>$item->nombre, 'P4'=>json_encode($item->valores), 'P5'=>$id));
						}
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				case 'buscador':
					$sql=$con->prepare('SELECT * FROM articulosView WHERE tipoEquipo LIKE "%":P1"%"');
					$resultado=$sql->execute(array('P1'=>$_POST['termino']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
					$totalActivos=totalActivos();

					if ($num>=1) {
						$editar=permisosItem($_SESSION['idUsuario'], 'editar equipos');
						$anular=permisosItem($_SESSION['idUsuario'], 'anular equipos');

						echo '
							<table class="table table-hover">
									<tr>
										<th>Tipo Equipo</th>
										<th>Marca</th>
										<th>Modelo</th>
										<th>Ubicacion</th>
										<th class="no-sort">Guia</th>
										<th class="no-sort">Reporte</th>
										<th class="no-sort">PDF Reporte</th>
										<th>Cliente</th>
										<th class="no-sort">Estado</th>
										<th class="no-sort">Acción</th>
									</tr>
						';
						foreach ($resultado as $fila) {
							$checked=($fila['fechaEliminacion']==NULL) ? 'checked' : '';
							$reporte = !validacionReporte($fila['id']) ? 'style="pointer-events: none"':'';

							echo '
									<tr>
										<input type="hidden" class="idArticulo" value="'.$fila['id'].'">
										<td>'.$fila['tipoEquipo'].'</td>
										<td>'.$fila['marca'].'</td>
										<td>'.$fila['modelo'].'</td>
										<td>'.$fila['ubicacion'].'</td>
										<td title="Descargar Guia">
											<a href="../../views/equipos/articulosUtils/exportarGuia.php?id='.$fila['id'].'" class="btn btn-primary btn-sm" target="_blank">
												<span class="mdi mdi-file-pdf"></span>
											</a>
										</td>
										<td title="Crear Reporte">
											<button type="button" class="btn btn-success btn-sm formEditarReporte" data-toggle="modal" data-target=".bd-example-modal-lg2" title="Generar Reporte" '.$editar.'>
												<span class="mdi mdi-book-open-page-variant"></span>
											</button>
										</td>
										<td title="Descargar Reporte">
											<a href="../../views/equipos/articulosUtils/exportarReporte.php?id='.$fila['id'].'" class="btn btn-dark btn-sm " target="_blank" '.$reporte.'>
												<span class="mdi mdi-file-pdf outline"></span>
											</a>
										</td>
										<td>'.$fila['cliente'].'</td>
										<td>
											<div class="custom-control custom-switch" '.$anular.'>
												<input type="checkbox" class="custom-control-input checkbox" id="customSwitch'.$fila['id'].'" checked>
												<label class="custom-control-label" for="customSwitch'.$fila['id'].'"></label>
											</div>
										</td>
										<td>
											<button type="button" class="btn btn-warning btn-sm formEditarArticulo" data-toggle="modal" data-target=".bd-example-modal-lg" title="Editar Articulo" '.$editar.'>
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
					$sql=$con->prepare('UPDATE articulos SET idCliente=:P2, direccion=:P3, idServicio=:P4, serie=:P5, tipo=:P6, inventario=:P7, idTipoEquipo=:P8, idEquipo=:P9, idRegistro=:P10, ubicacion=:P11, codDoc=:P12 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['idArticulo'], 'P2'=>$_POST['idCliente'], 'P3'=>$_POST['direccion'], 'P4'=>$_POST['idServicio'], 'P5'=>$_POST['serie'], 'P6'=>$_POST['tipo'], 'P7'=>$_POST['inventario'], 'P8'=>$_POST['idTipoEquipo'], 'P9'=>$_POST['idEquipo'], 'P10'=>$_POST['idRegistro'], 'P11'=>$_POST['ubicacion'], 'P12'=>$_POST['codDoc']));

					foreach (json_decode($_POST['items']) as $item) {
						$sql2=$con->prepare('UPDATE relaciones SET modulo=:P2, pestana=:P3, nombre=:P4, valores=:P5 WHERE id=:P1');
						$resultado2=$sql2->execute(array('P1'=>$item->id, 'P2'=>'articulos', 'P3'=>$item->pestana, 'P4'=>$item->nombre, 'P5'=>json_encode($item->valores)));
					}
					break;
				case 'habilitar':
					if ($_POST['habilitado']==0) {
						$sql=$con->prepare('UPDATE articulos SET fechaEliminacion=NOW() WHERE id=:P1');
					}else{
						$sql=$con->prepare('UPDATE articulos SET fechaEliminacion=NULL WHERE id=:P1');
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
					$sql=$con->prepare('SELECT * FROM articulosView WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							
						echo '
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Editar Articulo</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
			
						<div class="modal-body">
							<form>
								<ul class="nav nav-tabs" id="myTab" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" style="font-size: 0.8em;">Articulo</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="historico-tab" data-toggle="tab" href="#historico" role="tab" aria-controls="historico" aria-selected="false" style="font-size: 0.8em;">Reg Historico</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="monitoreo-tab" data-toggle="tab" href="#monitoreo" role="tab" aria-controls="monitoreo" aria-selected="false" style="font-size: 0.8em;">Monitoreo</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="notas-tab" data-toggle="tab" href="#notas" role="tab" aria-controls="notas" aria-selected="false" style="font-size: 0.8em;">Notas</a>
									</li>
								</ul>
			
								<div class="tab-content" id="myTabContent">
									<!-- HOME -->
									<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
										<h4 class="card-title text-center">Articulo</h4>
										<input type="hidden" id="idArticulo" value="'.$fila['id'].'">
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Cliente</label>
											<div class="col-sm-9">
												<select class="form-control form-control-sm" id="idCliente">
													<option value="'.$fila['idCliente'].'">'.$fila['cliente'].'</option>';
													foreach (getClientes() as $data) {
														echo '<option value="'.$data['id'].'">'.$data['nombre'].'</option>';
													}
											echo '</select>
											</div>
										</div>
			
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Dirección</label>
											<div class="col-sm-9">
												<select class="form-control form-control-sm" id="direccion">
													<option value="'.$fila['direccion'].'">'.$fila['direccion'].'</option>';
													$cantidad = getDireccionesCliente($fila['idCliente'])[0];
													$direccion = getDireccionesCliente($fila['idCliente'])[1];

													for ($i=0; $i<$cantidad; $i++) {
														$direccionGuion=str_replace("@", " - ", $direccion[$i]);

														echo '<option value="'.$direccion[$i].'">'.$direccionGuion.'</option>';
													}
											echo '</select>
											</div>
										</div>
			
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Servicio Hospitalario</label>
											<div class="col-sm-9">
												<select class="form-control form-control-sm" id="idServicio">
													<option value="'.$fila['idServicio'].'">'.$fila['servicio'].'</option>';
													foreach (getFullServicios($fila['idCliente'], $fila['direccion']) as $data) {
														echo '<option value="'.$data['id'].'">'.$data['descripcion'].'</option>';
													}
											echo '</select>
											</div>
										</div>
			
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Serie</label>
											<div class="col-sm-9">
												<input type="text" class="form-control form-control-sm" id="serie" value="'.$fila['serie'].'">
											</div>
										</div>
			
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Tipo</label>
											<div class="col-sm-9">
												<input type="text" class="form-control form-control-sm" id="tipo" value="'.$fila['tipo'].'">
											</div>
										</div>
			
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">No. Inventario</label>
											<div class="col-sm-9">
												<input type="text" class="form-control form-control-sm" id="nInventario" value="'.$fila['inventario'].'">
											</div>
										</div>
			
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Tipo de Equipo</label>
											<div class="col-sm-9">
												<select class="form-control form-control-sm" id="idTipoEquipo">
													<option value="'.$fila['idTipoEquipo'].'">'.$fila['tipoEquipo'].'</option>';
													foreach (getTipoEquipo() as $data) {
														echo '<option value="'.$data['id'].'">'.$data['nombre'].'</option>';
													}
											echo '</select>
											</div>
										</div>
			
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Equipo</label>
											<div class="col-sm-9">
												<select class="form-control form-control-sm" id="idEquipo">
													<option value="'.$fila['idEquipo'].'">'.$fila['marca'].' - '.$fila['modelo'].' </option>';
													foreach (getEquipos() as $data) {
														echo '<option value="'.$data['id'].'">'.$data['marca'].' - '.$data['modelo'].'</option>';
													}
											echo '</select>
											</div>
										</div>
			
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Registro</label>
											<div class="col-sm-9">
												<select class="form-control form-control-sm" id="idRegistro">
													<option value="'.$fila['idRegistro'].'">'.$fila['registro'].'</option>';
													foreach (getFullRegistros($fila['id']) as $data) {
														echo '<option value="'.json_decode($data['valores'])->val1.'">'.getNameInvima(json_decode($data['valores'])->val1).'</option>';
													}
												echo '</select>
											</div>
										</div>
			
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Ubicación</label>
											<div class="col-sm-9">
												<input type="text" class="form-control form-control-sm" id="ubicacion" value="'.$fila['ubicacion'].'">
											</div>
										</div>

										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Código Documento</label>
											<div class="col-sm-9">
												<input type="text" class="form-control form-control-sm" id="codDoc" value="'.$fila['codDoc'].'">
											</div>
										</div>
									</div>
									<!-- END HOME -->
								';
						}

						$sql=$con->prepare('SELECT * FROM relaciones WHERE modulo=:P1 AND idPrincipal=:P2 ORDER BY id');
						$resultado=$sql->execute(array('P1'=>'articulos', 'P2'=>$_POST['id']));
						$resultado=$sql->fetchAll();
						$num=$sql->rowCount();

						if ($num>=1) {							
							echo '
								<!-- HISTORICO -->
								<div class="tab-pane fade" id="historico" role="tabpanel" aria-labelledby="historico-tab">
									<h4 class="card-title text-center">Registro Historico</h4>

									<table class="table table-borderless table-hover table-sm">								
								';
							foreach ($resultado as $fila) {
								if ($fila['pestana']=='historico') {									
									switch ($fila['nombre']) {										
										case 'formaAdquisicion':
											echo '
												<tr class="formaAdquisicion">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Forma de Adquisición</td>
													<td>
														<select class="form-control form-control-sm" id="val1">
															<option value="'.json_decode($fila['valores'])->val1.'">'.json_decode($fila['valores'])->val1.'</option>
															<option value="COMPRA DIRECTA">COMPRA DIRECTA</option>
															<option value="DONACIÓN">DONACIÓN</option>
															<option value="ASIGNACIÓN">ASIGNACIÓN</option>
															<option value="ALQUILER">ALQUILER</option>
															<option value="DEMO">DEMO</option>
															<option value="COMO DATO">COMO DATO</option>
														</select>
													</td>
												</tr>
											';
											break;

										case 'documentoAdquisicion':
											echo '
												<tr class="documentoAdquisicion">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Documento de Referencia de la Adquisición</td>
													<td><input type="text" class="form-control form-control-sm" id="val1" value="'.json_decode($fila['valores'])->val1.'"></td>
												</tr>
											';
											break;

										case 'fechaAdquisicion':
											echo '
												<tr class="fechaAdquisicion">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Fecha de Adquisición</td>
													<td><input type="date" class="form-control form-control-sm" id="val1" value="'.json_decode($fila['valores'])->val1.'"></td>
												</tr>
											';
											break;

										case 'costoSinIVA':
											echo '
												<tr class="costoSinIVA">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Costo sin IVA</td>
													<td><input type="text" class="form-control form-control-sm" id="val1" value="'.json_decode($fila['valores'])->val1.'"></td>
												</tr>												
											';
											break;

										case 'fechaEntrega':
											echo '
												<tr class="fechaEntrega">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Fecha Entrega / Instalación</td>
													<td><input type="date" class="form-control form-control-sm" id="val1" value="'.json_decode($fila['valores'])->val1.'"></td>
												</tr>
											';
											break;

										case 'numeroActa':
											echo '
												<tr class="numeroActa">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Número de Acta de Entrega</td>
													<td><input type="text" class="form-control form-control-sm" id="val1" value="'.json_decode($fila['valores'])->val1.'"></td>
												</tr>
											';
											break;
										case 'fechaInicio':
											echo '
												<tr class="fechaInicio">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Fecha Inicio de Operación</td>
													<td><input type="date" class="form-control form-control-sm" id="val1" value="'.json_decode($fila['valores'])->val1.'"></td>
												</tr>
											';
											break;
										case 'fechaVencimiento':
											echo '
												<tr class="fechaVencimiento">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Fecha Vencimiento de la Garantía</td>
													<td><input type="date" class="form-control form-control-sm" id="val1" value="'.json_decode($fila['valores'])->val1.'"></td>
												</tr>
											';
											break;
										case 'fechaFabricacion':
											echo '
												<tr class="fechaFabricacion">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<td>Fecha de Fabricación</td>
													<td><input type="date" class="form-control form-control-sm" id="val1" value="'.json_decode($fila['valores'])->val1.'"></td>
												</tr>
											';
											break;
										case 'registroImportacion':
											echo '
												<tr class="registroImportacion">
													<td>Registro de Importación</td>
													<td>
														<select class="form-control form-control-sm" id="val1">
															<option value="'.json_decode($fila['valores'])->val1.'">'.manifiestosName(json_decode($fila['valores'])->val1).'</option>';
																foreach (getManifiestos() as $fila) {
																	echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
																}															
													echo '</select>
													</td>
												</tr>												
											';
											break;
										case 'proveedor':
											echo '
												<tr class="proveedor">
													<td>Proveedor</td>
													<td>
														<select class="form-control form-control-sm" id="val1">
															<option value="'.json_decode($fila['valores'])->val1.'">'.proveedoresName(json_decode($fila['valores'])->val1).'</option>';
															foreach (getProveedores() as $fila) {
																echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
															}
													echo '</select>
													</td>
												</tr>
											';
											break;
										case 'fabricante':
											echo '
												<tr class="fabricante">
													<td>Fabricante</td>
													<td>
														<select class="form-control form-control-sm" id="val1">
															<option value="'.json_decode($fila['valores'])->val1.'">'.fabricantesName(json_decode($fila['valores'])->val1).'</option>';
															foreach (getFabricantes() as $fila) {
																echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
															}
													echo '</select>
													</td>
												</tr>
											';
											break;
									}
								}
							}
							echo '
									</table>
								</div>
								<!-- END HISTORICO -->

								<!-- MONITOREO -->
								<div class="tab-pane fade" id="monitoreo" role="tabpanel" aria-labelledby="monitoreo-tab">
									<h4 class="card-title text-center">Caracteristicas de Monitoreo</h4>

									<table class="table table-borderless table-hover table-sm">										
							';
							foreach ($resultado as $fila) {
								if ($fila['pestana']=='monitoreo') {
									switch ($fila['nombre']) {										
										case 'dioxidoCarbono':
											echo '
											<tr>
												<td class="dioxidoCarbono">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_1">
														<label class="custom-control-label" for="customSwitch_1">Dióxido de Carbono</label>
													</div>
												</td>
											';
											break;
										case 'frecuenciaCardiaca':
											echo '
												<td class="frecuenciaCardiaca">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_2">
														<label class="custom-control-label" for="customSwitch_2">Frecuencia Cardíaca</label>
													</div>
												</td>
											';
											break;
										case 'temperatura':
											echo '
												<td class="temperatura">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_3">
														<label class="custom-control-label" for="customSwitch_3">Temperatura</label>
													</div>
												</td>
											';
											break;
										case 'gasesAnestesicos':
											echo '
												<td class="gasesAnestesicos">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_4">
														<label class="custom-control-label" for="customSwitch_4">Gases Anestesicos</label>
													</div>
												</td>
											</tr>
											';
											break;

										case 'electroCardiografia':
											echo '
											<tr>
												<td class="electroCardiografia">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_5">
														<label class="custom-control-label" for="customSwitch_5">Electro-Cardiografía</label>
													</div>
												</td>
											';
											break;
										case 'presionNoInvasiva':
											echo '
												<td class="presionNoInvasiva">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_6">
														<label class="custom-control-label" for="customSwitch_6">Presión NO Invasiva</label>
													</div>
												</td>												
											';
											break;
										case 'oximetriaPulso':
											echo '
												<td class="oximetriaPulso">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_7">
														<label class="custom-control-label" for="customSwitch_7">Oximetría de Pulso</label>
													</div>
												</td>
											';
											break;
										case 'gastoCardiaco':
											echo '
												<td class="gastoCardiaco">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_8">
														<label class="custom-control-label" for="customSwitch_8">Gasto Cardíaco</label>
													</div>
												</td>
											</tr>
											';
											break;

										case 'electroMiografia':
											echo '
											<tr>
												<td class="electroMiografia">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_9">
														<label class="custom-control-label" for="customSwitch_9">Electro-Miografía</label>
													</div>
												</td>
											';
											break;
										case 'presionInvasiva':
											echo '
												<td class="presionInvasiva">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_10">
														<label class="custom-control-label" for="customSwitch_10">Presión Invasiva</label>
													</div>
												</td>
											';
											break;											
										case 'indiceBispectral':										
											echo '
												<td class="indiceBispectral">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_11">
														<label class="custom-control-label" for="customSwitch_11">Índice Bispectral</label>
													</div>
												</td>
											';
											break;
										case 'glucosa':
											echo '
												<td class="glucosa">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_12">
														<label class="custom-control-label" for="customSwitch_12">Glucosa</label>
													</div>
												</td>
											</tr>
											';
											break;

										case 'electroOculografia':
											echo '
											<tr>
												<td class="electroOculografia">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_13">
														<label class="custom-control-label" for="customSwitch_13">Electro-Oculografía</label>
													</div>
												</td>
											';
											break;
										case 'respiracion':
											echo '
												<td class="respiracion">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_14">
														<label class="custom-control-label" for="customSwitch_14">Respiración</label>
													</div>
												</td>
											';
											break;
										case 'Electroencefalografia':
											echo '
												<td class="Electroencefalografia">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_15">
														<label class="custom-control-label" for="customSwitch_15">Electroencefalografía</label>
													</div>
												</td>
											';
											break;
										case 'ultrasonido':
											echo '
												<td class="ultrasonido">
													<input type="hidden" id="idItem" value="'.$fila['id'].'">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input val1" '.json_decode($fila['valores'])->val1.' id="customSwitch_16">
														<label class="custom-control-label" for="customSwitch_16">Ultrasonido</label>
													</div>
												</td>
											</tr>
											';
											break;
									}
								}
							}
							echo '
									</table>
								</div>
								<!-- END MONITOREO -->

								<!-- NOTAS -->
								<div class="tab-pane fade" id="notas" role="tabpanel" aria-labelledby="notas-tab">
									<h4 class="card-title text-center">Notas</h4>

									<table class="table table-borderless table-hover table-sm">
							';
							foreach ($resultado as $fila) {
								if ($fila['pestana']=='notas') {
									echo '
										<tr class="notas">
											<td>
												<textarea class="form-control" id="val1" rows="4">'.json_decode($fila['valores'])->val1.'</textarea>
											</td>
										</tr>
									';
								}
							}
							echo '
									</table>
								</div>
								<!-- END NOTAS -->
							</div><br>

							<button type="button" class="btn btn-primary mr-2" id="editarArticulo" data-dismiss="modal">Guardar</button>
							<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
						</form>
							';
						}
					}
					break;
				
					$sql=$con->prepare('SELECT * FROM reportes WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
						echo '
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Editar Reporte de Mantenimiento</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<input type="hidden" id="idArticulo" value="'.$fila['id'].'">				
							<form>
								<div class="header">
									<table class="table table-sm">
										<tr>
											<th>CLIENTEEEEEEEEEEE:</th>
											<td>'.$fila['cliente'].'</td>
											<th>CONTACTO:</th>
											<td><input type="text" class="form-control form-control-sm" placeholder="Contacto"></td>
										</tr>
										<tr>
											<th>DIRECCION:</th>
											<td>CR 28 # 81-76 LAS AMERICAS </td>
											<th>CIUDAD:</th>
											<td>MANZANA 36 LOTE 38</td>
										</tr>
										<tr>
											<th colspan="2">FECHA DEL SERVICIO:</th>
											<td colspan="2"><input type="date" class="form-control form-control-sm"></td>
										</tr>
									</table>
								</div>
								<br>
								<!-- SERVICIO POR // TIPO DE SERVICIO -->
								<table class="table table-sm">
									<tr class="serviciPorTR">
										<th>SERVICIO POR:</th>
										<td>
											<select class="form-control form-control-sm servicioPor">
												<option value="GARANTIA">GARANTIA</option>
												<option value="CONTRATO">CONTRATO</option>
												<option value="FACTURA">FACTURA</option>
												<option value="OTRO">OTRO</option>
											</select>
										</td>
									</tr>
									<tr class="tipoServicioTR">
										<th>TIPO DE SERVICIO:</th>
										<td>
											<select class="form-control form-control-sm tipoServicio">
												<option value="INSTALACIÓN">INSTALACIÓN</option>
												<option value="PREVENTIVO">PREVENTIVO</option>
												<option value="CORRECTIVO">CORRECTIVO</option>
												<option value="OTRO">OTRO</option>
											</select>
										</td>
									</tr>
								</table><br>
								<!-- MANTENIMIENTO DE EQUIPO  -->
								<h5 class="text-center">MANTENIMIENTO DE EQUIPO Y/O DISPOSITIVO BIOMEDICO</h5>
								<h5 class="text-center">PROTOCOLO: GENERAL</h5>
								<h6 class="text-center">INSPECCION INICIAL</h6>
								<table class="table table-sm">
									<tr>
										<th>DESCRIPCIÓN</th>
										<th>ESTADO</th>
										<th>OBSERVACIONES</th>
									</tr>
									<tr class="inspeccionInicial-item_1">
										<td>VERIFICACION DE ESTADO FISICO GENERAL</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="inspeccionInicial-item_2">
										<td>VERIFICACION DE FUNCIONAMIENTO</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="inspeccionInicial-item_3">
										<td>VERIFICACION DE ACCESORIOS</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="inspeccionInicial-item_4">
										<td>VERIFICACION DE INDICADORES VISUALES/AUDITIVOS</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr>
										<td colspan="5"><h6 class="text-center">SISTEMA ELECTRICO</h6></td>
									</tr>
									<tr class="sistemaElectrico-item_1">
										<td>ALIMENTACION RED ELECTRICA Y/O REGULACION</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaElectrico-item_2">
										<td>ALIMENTACION SUPLEMENTARIA Y/O BATERIAS</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaElectrico-item_3">
										<td>PROTECCIONES (FUSIBLES, TERMICOS, ETC)</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr>
										<td colspan="5"><h6 class="text-center">SISTEMA ELECTRONICO</h6></td>
									</tr>
									<tr class="sistemaElectronico-item_1">
										<td>TARJETA PRINCIPAL DE CONTROL Y/O POTENCIA</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaElectronico-item_2">
										<td>CONECTORES Y PUERTOS DE COMUNICACION</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaElectronico-item_3">
										<td>MANDOS DE CONTROL, TECLADOS</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaElectronico-item_4">
										<td>MODULOS DE MONITOREO (EKG,SPO2,NIBP,TEMP, ETC)</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaElectronico-item_5">
										<td>PANTALLAS E INDICADORES VISUALES/AUDITIVOS</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr>
										<td colspan="5"><h6 class="text-center">SISTEMA MECANICO</h6></td>
									</tr>
									<tr class="sistemaMecanico-item_1">
										<td>AJUSTE DE PIEZAS MOVILES</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaMecanico-item_2">
										<td>LUBRICACION Y AJUSTE DE PIEZAS</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaMecanico-item_3">
										<td>ACTUADORES MECANICOS</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr>
										<td colspan="5"><h6 class="text-center">SISTEMA NEUMATICO/HIDRAULICO</h6></td>
									</tr>
									<tr class="sistemaNeumatico-item_1">
										<td>VALVULAS, CONTROLES Y REGULADORES DE PRESION Y/O FLUJO</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaNeumatico-item_2">
										<td>COMPRESOR Y/O TURBINA</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaNeumatico-item_3">
										<td>MANGUERAS, TUBERIAS, ACOPLES Y EMPAQUES</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaNeumatico-item_4">
										<td>FILTROS, TRAMPAS DE AGUA, EMPAQUES, ACOPLES</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr>
										<td colspan="5"><h6 class="text-center">SISTEMA DE VENTILACION MECANICA</h6></td>
									</tr>
									<tr class="sistemaVentilacion-item_1">
										<td>PARAMETROS Y MODULOS DE VENTILACION</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaVentilacion-item_2">
										<td>ABSORBEDOR, FLUELLE Y APL</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="sistemaVentilacion-item_3">
										<td>ACUMULADORES Y/O ACTUADORES NEUMATICOS</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr>
										<td colspan="5"><h6 class="text-center">INSPECCION FINAL</h6></td>
									</tr>
									<tr class="inspeccionFinal-item_1">
										<td>ESTADO GENERAL</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="inspeccionFinal-item_2">
										<td>PRUEBAS FUNCIONALES</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr class="inspeccionFinal-item_3">
										<td>SE ENTREGA FUNCIONANDO EN COMPAÑIA DEL OPERADOR</td>
										<td>
											<select class="form-control form-control-sm estado">
												<option value="PASA">PASA</option>
												<option value="FALLA">FALLA</option>
												<option value="N/A">N/A</option>				
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm observacion" placeholder="Observaciones">
										</td>
									</tr>
									<tr>
										<td colspan="5"><h6 class="text-center">OBSERVACIONES GENERALES</h6></td>
									</tr>
									<tr>
										<td colspan="5"><textarea rows="2" class="form-control observacionesGenerales"></textarea></td>
									</tr>
									<!-- // -->
								</table>
								<br>
								<button type="button" class="btn btn-primary mr-2" id="guardarReporte" data-dismiss="modal">Guardar</button>
								<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
							</form>
						</div>
						
						';
						}
					
					}
					break;
				case 'getDireccion':
					$sql=$con->prepare('SELECT * FROM clientes WHERE id = :P1 AND fechaEliminacion IS NULL');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						echo '<option value="NaN">Seleccione</option>';
						foreach ($resultado as $fila) {
							$cantidad=count(json_decode($fila['direccion']));
							$direccion = json_decode($fila['direccion']);

							for ($i=0; $i<$cantidad; $i++) {
								$direccionGuion=str_replace("@", " - ", $direccion[$i]);

								echo '<option value="'.$direccion[$i].'">'.$direccionGuion.'</option>';
							}
						}
					}else{
						echo '<option disabled>NO EXISTEN DIRECCIONES PARA ESTE CLIENTE</option>';
					}	
					break;
				case 'getServicios':
					$sql=$con->prepare('SELECT servicios.id, servicios.descripcion FROM asignarServicios INNER JOIN servicios ON servicios.id=asignarServicios.idServicio WHERE asignarServicios.idCliente = :P1 AND asignarServicios.direccion = :P2');
					$resultado=$sql->execute(array('P1'=>$_POST['idCliente'], 'P2'=>$_POST['direccion']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '<option value="'.$fila['id'].'">'.$fila['descripcion'].'</option>';
						}
					}else{
						echo '<option disabled>NO EXISTEN SERVICIOS PARA ESTE CLIENTE EN ESTA DIRECCIÓN</option>';	
					}

					break;
				case 'getRegistros':
					$sql=$con->prepare('SELECT * FROM relaciones WHERE idPrincipal = :P1 AND nombre = :P2');
					$resultado=$sql->execute(array('P1'=>$_POST['idEquipo'], 'P2'=>'invima'));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();
	
					if ($num>=1) {
						foreach ($resultado as $fila) {
							echo '<option value="'.json_decode($fila['valores'])->val1.'">'.getNameInvima(json_decode($fila['valores'])->val1).'</option>';
						}
					}else{
						echo '<option disabled>NO EXISTEN REGISTROS PARA ESTE CLIENTE EN ESTA DIRECCIÓN</option>';	
					}

					break;
				case 'aplicar':					
					$sql=$con->prepare('INSERT INTO temporal (valores) VALUES (:P1)');
					$resultado=$sql->execute(array('P1'=>json_encode($_POST)));
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