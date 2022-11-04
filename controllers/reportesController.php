<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		require 'conexion.php';

		if(isset($_POST['accion'])) {
			switch ($_POST['accion']) {
				case 'nuevoReporte':
					$sql=$con->prepare('INSERT INTO reportes (idArticulo, contacto, fechaServicio, servicioPor, tipoServicio, inspeccionInicial, sistemaElectrico, sistemaElectronico, sistemaMecanico, sistemaNeumatico, sistemaVentilacion, inspeccionFinal, observaciones) VALUES (:P1,:P2,:P3,:P4,:P5,:P6,:P7,:P8,:P9,:P10,:P11,:P12,:P13)');
					$resultado=$sql->execute(array('P1'=>$_POST['idArticulo'], 'P2'=>$_POST['contacto'], 'P3'=>$_POST['fechaServicio'], 'P4'=>$_POST['servicioPor'], 'P5'=>$_POST['tipoServicio'], 'P6'=>$_POST['inspeccionInicial'], 'P7'=>$_POST['sistemaElectrico'], 'P8'=>$_POST['sistemaElectronico'], 'P9'=>$_POST['sistemaMecanico'], 'P10'=>$_POST['sistemaNeumatico'], 'P11'=>$_POST['sistemaVentilacion'], 'P12'=>$_POST['inspeccionFinal'], 'P13'=>$_POST['observaciones']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				case 'form-reporte':
					$sql=$con->prepare('SELECT * FROM articulosView WHERE id = :P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						foreach ($resultado as $fila) {
							$id = $fila['id'];
							$cliente = $fila['cliente'];
							$direccion = explode('@', $fila['direccion']);
							$ciudad=$direccion[1];
							$direccion=$direccion[0];
							$tipoEquipo = $fila['tipoEquipo'];
							$marca = $fila['marca'];
							$modelo = $fila['modelo'];
							$serie = $fila['serie'];
						}

						$sql2=$con->prepare('SELECT * FROM reportes WHERE idArticulo = :P1');
						$resultado2=$sql2->execute(array('P1'=>$_POST['id']));
						$resultado2=$sql2->fetchAll();
						$num2=$sql2->rowCount();						

						if ($num2>=1) {
							foreach ($resultado2 as $fila) {
								$contacto=$fila['contacto'];
								$fechaServicio=$fila['fechaServicio'];

								$inspeccionInicial = json_decode($fila['inspeccionInicial']);
								$sistemaElectrico = json_decode($fila['sistemaElectrico']);
								$sistemaElectronico = json_decode($fila['sistemaElectronico']);
								$sistemaMecanico = json_decode($fila['sistemaMecanico']);
								$sistemaNeumatico = json_decode($fila['sistemaNeumatico']);
								$sistemaVentilacion = json_decode($fila['sistemaVentilacion']);
								$inspeccionFinal = json_decode($fila['inspeccionFinal']);

								echo '
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Editar Reporte de Mantenimiento</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<div class="modal-body">
										<input type="hidden" class="idReporte" value="'.$fila['id'].'">

										<table class="table table-sm">
											<tr>
												<td>CLIENTE: '.$cliente.'</td>
												<td>
													<div class="form-inline">
														<label class="my-1 mr-2" for="">CONTACTO:</label>
														<input type="text" class="form-control form-control-sm my-1 mr-sm-2 contacto" value="'.$contacto.'">
													</div>
												</td>
											</tr>
										</table>

										<table class="table table-sm">
											<tr>
												<td>DIRECCIÓN: '.$direccion.'</td>
												<td>CIUDAD: '.$ciudad.'</td>
												<td>
													<div class="form-inline">
														<label class="my-1 mr-2" for="">FECHA SERVICIO:</label>
														<input type="date" class="form-control form-control-sm my-1 mr-sm-2 fechaServicio" value="'.$fechaServicio.'">
													</div>
												</td>
											</tr>
											<tr>
												<td>EQUIPO: '.$tipoEquipo.'</td>
												<td>MARCA / MODELO: '.$marca.' / '.$modelo.'</td>
												<td>SERIAL(S/N): '.$serie.'</td>										
											</tr>									
										</table>

										<!-- SERVICIO POR // TIPO DE SERVICIO -->
										<table class="table table-sm">
											<tr class="serviciPorTR">
												<th>SERVICIO POR:</th>
												<td>
													<select class="form-control form-control-sm servicioPor">
														<option value="'.$fila['servicioPor'].'" style="color: white; ">'.$fila['servicioPor'].'</option>
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
														<option value="'.$fila['tipoServicio'].'" style="color: white; ">'.$fila['tipoServicio'].'</option>
														<option value="INSTALACION">INSTALACION</option>
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

										<!-- SECCION DE VERIFICACIONES -->
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
														<option value="'.$inspeccionInicial[0]->valores->estado.'" style="color: white; ">'.$inspeccionInicial[0]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$inspeccionInicial[0]->valores->observacion.'">
												</td>
											</tr>

											<tr class="inspeccionInicial-item_2">
												<td>VERIFICACION DE FUNCIONAMIENTO</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$inspeccionInicial[1]->valores->estado.'" style="color: white; ">'.$inspeccionInicial[1]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$inspeccionInicial[1]->valores->observacion.'">
												</td>
											</tr>

											<tr class="inspeccionInicial-item_3">
												<td>VERIFICACION DE ACCESORIOS</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$inspeccionInicial[2]->valores->estado.'" style="color: white; ">'.$inspeccionInicial[2]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$inspeccionInicial[2]->valores->observacion.'">
												</td>
											</tr>

											<tr class="inspeccionInicial-item_4">
												<td>VERIFICACION DE INDICADORES VISUALES/AUDITIVOS</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$inspeccionInicial[3]->valores->estado.'" style="color: white; ">'.$inspeccionInicial[3]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$inspeccionInicial[3]->valores->observacion.'">
												</td>
											</tr>

											<tr>
												<td colspan="5"><h6 class="text-center">SISTEMA ELECTRICO</h6></td>
											</tr>

											<tr class="sistemaElectrico-item_1">
												<td>ALIMENTACION RED ELECTRICA Y/O REGULACION</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaElectrico[0]->valores->estado.'" style="color: white; ">'.$sistemaElectrico[0]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaElectrico[0]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaElectrico-item_2">
												<td>ALIMENTACION SUPLEMENTARIA Y/O BATERIAS</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaElectrico[1]->valores->estado.'" style="color: white; ">'.$sistemaElectrico[1]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaElectrico[1]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaElectrico-item_3">
												<td>PROTECCIONES (FUSIBLES, TERMICOS, ETC)</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaElectrico[2]->valores->estado.'" style="color: white; ">'.$sistemaElectrico[2]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaElectrico[2]->valores->observacion.'">
												</td>
											</tr>

											<tr>
												<td colspan="5"><h6 class="text-center">SISTEMA ELECTRONICO</h6></td>
											</tr>

											<tr class="sistemaElectronico-item_1">
												<td>TARJETA PRINCIPAL DE CONTROL Y/O POTENCIA</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaElectronico[0]->valores->estado.'" style="color: white; ">'.$sistemaElectronico[0]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaElectronico[0]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaElectronico-item_2">
												<td>CONECTORES Y PUERTOS DE COMUNICACION</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaElectronico[1]->valores->estado.'" style="color: white; ">'.$sistemaElectronico[1]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaElectronico[1]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaElectronico-item_3">
												<td>MANDOS DE CONTROL, TECLADOS</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaElectronico[2]->valores->estado.'" style="color: white; ">'.$sistemaElectronico[2]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaElectronico[2]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaElectronico-item_4">
												<td>MODULOS DE MONITOREO (EKG,SPO2,NIBP,TEMP, ETC)</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaElectronico[3]->valores->estado.'" style="color: white; ">'.$sistemaElectronico[3]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaElectronico[3]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaElectronico-item_5">
												<td>PANTALLAS E INDICADORES VISUALES/AUDITIVOS</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaElectronico[4]->valores->estado.'" style="color: white; ">'.$sistemaElectronico[4]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaElectronico[4]->valores->observacion.'">
												</td>
											</tr>

											<tr>
												<td colspan="5"><h6 class="text-center">SISTEMA MECANICO</h6></td>
											</tr>

											<tr class="sistemaMecanico-item_1">
												<td>AJUSTE DE PIEZAS MOVILES</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaMecanico[0]->valores->estado.'" style="color: white; ">'.$sistemaMecanico[0]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaMecanico[0]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaMecanico-item_2">
												<td>LUBRICACION Y AJUSTE DE PIEZAS</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaMecanico[1]->valores->estado.'" style="color: white; ">'.$sistemaMecanico[1]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaMecanico[1]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaMecanico-item_3">
												<td>ACTUADORES MECANICOS</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaMecanico[2]->valores->estado.'" style="color: white; ">'.$sistemaMecanico[2]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaMecanico[2]->valores->observacion.'">
												</td>
											</tr>

											<tr>
												<td colspan="5"><h6 class="text-center">SISTEMA NEUMATICO/HIDRAULICO</h6></td>
											</tr>

											<tr class="sistemaNeumatico-item_1">
												<td>VALVULAS, CONTROLES Y REGULADORES DE PRESION Y/O FLUJO</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaNeumatico[0]->valores->estado.'" style="color: white; ">'.$sistemaNeumatico[0]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaNeumatico[0]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaNeumatico-item_2">
												<td>COMPRESOR Y/O TURBINA</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaNeumatico[1]->valores->estado.'" style="color: white; ">'.$sistemaNeumatico[1]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaNeumatico[1]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaNeumatico-item_3">
												<td>MANGUERAS, TUBERIAS, ACOPLES Y EMPAQUES</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaNeumatico[2]->valores->estado.'" style="color: white; ">'.$sistemaNeumatico[2]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaNeumatico[2]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaNeumatico-item_4">
												<td>FILTROS, TRAMPAS DE AGUA, EMPAQUES, ACOPLES</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaNeumatico[3]->valores->estado.'" style="color: white; ">'.$sistemaNeumatico[3]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaNeumatico[3]->valores->observacion.'">
												</td>
											</tr>

											<tr>
												<td colspan="5"><h6 class="text-center">SISTEMA DE VENTILACION MECANICA</h6></td>
											</tr>

											<tr class="sistemaVentilacion-item_1">
												<td>PARAMETROS Y MODULOS DE VENTILACION</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaVentilacion[0]->valores->estado.'" style="color: white; ">'.$sistemaVentilacion[0]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaVentilacion[0]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaVentilacion-item_2">
												<td>ABSORBEDOR, FLUELLE Y APL</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaVentilacion[1]->valores->estado.'" style="color: white; ">'.$sistemaVentilacion[1]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaVentilacion[1]->valores->observacion.'">
												</td>
											</tr>

											<tr class="sistemaVentilacion-item_3">
												<td>ACUMULADORES Y/O ACTUADORES NEUMATICOS</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$sistemaVentilacion[2]->valores->estado.'" style="color: white; ">'.$sistemaVentilacion[2]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$sistemaVentilacion[2]->valores->observacion.'">
												</td>
											</tr>

											<tr>
												<td colspan="5"><h6 class="text-center">INSPECCION FINAL</h6></td>
											</tr>

											<tr class="inspeccionFinal-item_1">
												<td>ESTADO GENERAL</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$inspeccionFinal[0]->valores->estado.'" style="color: white; ">'.$inspeccionFinal[0]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$inspeccionFinal[0]->valores->observacion.'">
												</td>
											</tr>

											<tr class="inspeccionFinal-item_2">
												<td>PRUEBAS FUNCIONALES</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$inspeccionFinal[1]->valores->estado.'" style="color: white; ">'.$inspeccionFinal[1]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$inspeccionFinal[1]->valores->observacion.'">
												</td>
											</tr>

											<tr class="inspeccionFinal-item_3">
												<td>SE ENTREGA FUNCIONANDO EN COMPAÑIA DEL OPERADOR</td>
												<td>
													<select class="form-control form-control-sm estado">
														<option value="'.$inspeccionFinal[2]->valores->estado.'" style="color: white; ">'.$inspeccionFinal[2]->valores->estado.'</option>
														<option value="PASA">PASA</option>
														<option value="FALLA">FALLA</option>
														<option value="N/A">N/A</option>				
													</select>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm observacion" value="'.$inspeccionFinal[2]->valores->observacion.'">
												</td>
											</tr>

											<tr>
												<td colspan="5"><h6 class="text-center">OBSERVACIONES GENERALES</h6></td>
											</tr>

											<tr>
												<td colspan="5"><textarea rows="2" class="form-control observacionesGenerales">'.$fila['observaciones'].'</textarea></td>
											</tr>
										</table><br>
									</div>

									<div class="modal-footer">
										<button type="button" class="btn btn-primary mr-2" id="editarReporte" data-dismiss="modal">Guardar</button>
										<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
									</div>
								';
							}
						}else{
							echo '
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Reporte de Mantenimiento</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>

								<div class="modal-body">
									<input type="hidden" class="idArticulo" value="'.$id.'">

									<table class="table table-sm">
										<tr>
											<td>CLIENTE: '.$cliente.'</td>
											<td>
												<div class="form-inline">
													<label class="my-1 mr-2" for="">CONTACTO:</label>
													<input type="text" class="form-control form-control-sm my-1 mr-sm-2 contacto" placeholder="Contacto">
												</div>
											</td>
										</tr>
									</table>

									<table class="table table-sm">
										<tr>
											<td>DIRECCIÓN: '.$direccion.'</td>
											<td>CIUDAD: '.$ciudad.'</td>
											<td>
												<div class="form-inline">
													<label class="my-1 mr-2" for="">FECHA SERVICIO:</label>
													<input type="date" class="form-control form-control-sm my-1 mr-sm-2 fechaServicio">
												</div>
											</td>
										</tr>
										<tr>
											<td>EQUIPO: '.$tipoEquipo.'</td>
											<td>MARCA / MODELO: '.$marca.' / '.$modelo.'</td>
											<td>SERIAL(S/N): '.$serie.'</td>										
										</tr>									
									</table>

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
													<option value="INSTALACION">INSTALACION</option>
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
											</td>
										</tr>

										<tr class="sistemaElectronico-item_4">
											<td>MODULOS DE MONITOREO (EKG,SPO2,NIBP,TEMP, ETC)</td>
											<td>
												<select class="form-control form-control-sm estado">s
													<option value="PASA">PASA</option>
													<option value="FALLA">FALLA</option>
													<option value="N/A">N/A</option>				
												</select>
											</td>
											<td>
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
											</td>
										</tr>

										<tr>
											<td colspan="5"><h6 class="text-center">INSPECCION FINAL</h6></td>
										</tr>

										<tr class="inspeccionFinal-item_1">
											<td>ESTADO GENERAL</td>
											<td>
												<select class="form-control form-control-sm estado">s
													<option value="PASA">PASA</option>
													<option value="FALLA">FALLA</option>
													<option value="N/A">N/A</option>				
												</select>
											</td>
											<td>
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
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
												<input type="text" class="form-control form-control-sm observacion" placeholder="Observación">
											</td>
										</tr>

										<tr>
											<td colspan="5"><h6 class="text-center">OBSERVACIONES GENERALES</h6></td>
										</tr>

										<tr>
											<td colspan="5"><textarea rows="2" class="form-control observacionesGenerales">Observaciones</textarea></td>
										</tr>
									</table><br>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-primary mr-2" id="guardarReporte" data-dismiss="modal">Guardar</button>
									<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
								</div>
							';
						}
					}else{
						echo FALSE;
					}
					break;
				case 'editarReporte':
					$sql=$con->prepare('UPDATE reportes SET contacto=:P2, fechaServicio=:P3, servicioPor=:P4, tipoServicio=:P5, inspeccionInicial=:P6, sistemaElectrico=:P7, sistemaElectronico=:P8, sistemaMecanico=:P9, sistemaNeumatico=:P10, sistemaVentilacion=:P11, inspeccionFinal=:P12, observaciones=:P13 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id'], 'P2'=>$_POST['contacto'], 'P3'=>$_POST['fechaServicio'], 'P4'=>$_POST['servicioPor'], 'P5'=>$_POST['tipoServicio'], 'P6'=>$_POST['inspeccionInicial'], 'P7'=>$_POST['sistemaElectrico'], 'P8'=>$_POST['sistemaElectronico'], 'P9'=>$_POST['sistemaMecanico'], 'P10'=>$_POST['sistemaNeumatico'], 'P11'=>$_POST['sistemaVentilacion'], 'P12'=>$_POST['inspeccionFinal'], 'P13'=>$_POST['observaciones']));
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