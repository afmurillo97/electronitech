<?php
	include '../../../libs/htmlPdf/autoload.php';
	include '../../../login/conexion.php';

	use Spipu\Html2Pdf\Html2Pdf;

	function getDescripcionBiomedica($con, $id){
		$sql="SELECT * FROM descripcionbiomedica WHERE (id=\"$id\")";
		$query=$con->query($sql);
		$resultado=$query->fetch_all(MYSQLI_ASSOC);
		$num=$query->num_rows;

		if ($num>=1) {
			foreach ($resultado as $fila) {
				return ['nombre'=>$fila['nombre'], 'descripcion'=>$fila['descripcion']];
			}
		}else{
			return false;
		}
	}

	$id=$_REQUEST['id'];

	$sql="SELECT * FROM articulosView WHERE (id=\"$id\")";
	$query=$con->query($sql);
	$resultado=$query->fetch_all(MYSQLI_ASSOC);
	$num=$query->num_rows;

	if ($num>=1) {
		foreach ($resultado as $fila) {
			$cliente = $fila['cliente'];
			$codDoc=$fila['codDoc'];
			$fechaCreacion = $fila['fechaCreacion'];
			$direccion = explode('@', $fila['direccion']);
			$tipoEquipo = $fila['tipoEquipo'];
			$serie = $fila['serie'];
			$marca = $fila['marca'];
			$modelo = $fila['modelo'];
			$ubicacion = $fila['ubicacion'];
			$riesgo = $fila['riesgo'];
			$descripcionBiomedica = getDescripcionBiomedica($con, $fila['idDescripcionBiomedica']);

			switch ($riesgo) {
				case 'I':
					$colorRiesgo = 'green';
					break;
				case 'IIA':
					$colorRiesgo = 'yellow';
					break;
				case 'IIB':
					$colorRiesgo = 'red';
					break;
				case 'III':
					$colorRiesgo = 'purple';
					break;
				
				default:
					$colorRiesgo = 'white';
					break;
			}
			
			
		}

		$sql2="SELECT * FROM reportes WHERE (idArticulo=\"$id\")";
		$query2=$con->query($sql2);
		$resultado2=$query2->fetch_all(MYSQLI_ASSOC);
		$num2=$query2->num_rows;
	
		if ($num2>=1) {
			foreach ($resultado2 as $fila) {
				$contacto=$fila['contacto'];
				$inspeccionInicial = json_decode($fila['inspeccionInicial']);
				$sistemaElectrico = json_decode($fila['sistemaElectrico']);
				$sistemaElectronico = json_decode($fila['sistemaElectronico']);
				$sistemaMecanico = json_decode($fila['sistemaMecanico']);
				$sistemaNeumatico = json_decode($fila['sistemaNeumatico']);
				$sistemaVentilacion = json_decode($fila['sistemaVentilacion']);
				$inspeccionFinal = json_decode($fila['inspeccionFinal']);
				
				$G = $C = $F = $O = '';
				switch ($fila['servicioPor']) {
					case 'GARANTIA':
						$G = 'X';
						break;
					case 'CONTRATO':
						$C = 'X';
						break;
					case 'FACTURA':
						$F = 'X';
						break;
					default:
						$O = 'X';
						break;
				}

				$I = $P = $C2 = $O2 ='';
				switch ($fila['tipoServicio']) {
					case 'INSTALACION':
						$I = 'X';
						break;
					case 'PREVENTIVO':
						$P = 'X';
						break;
					case 'CORRECTIVO':
						$C2 = 'X';
						break;
					default:
						$O2 = 'X';
						break;
				}

			}
			
			$cuerpo = '

			<!-- ENCABEZADO 1 PAG -->
			<div> 
				<table border="none" style="width: 100%;">
					<tr>	
						<td style="width: 25%; text-align: center;" ><strong>CÓDIGO:</strong> '.$codDoc.'</td>
						<td rowspan="2" style="width: 45%;"><h4 style="text-align: center;">'.$cliente.'</h4></td>
						<td rowspan="4" style="width: 30%;"> <img src="../../../assets/images/template/electronitech.jpg" alt="" width="220" height="110"> </td>
					</tr>
					<tr>
						<td style="text-align: center;"><strong>VERSIÓN:</strong> 1.0.0</td>
					</tr>
					<tr>
						<td style="width: 25%; text-align: center;"><strong>FECHA:</strong> '.date('d-m-Y').'</td>
					</tr>
					<tr>
						<th style="text-align: center;">Reporte No. RD'.$id.'</th>
						<td ><h4 style="text-align: center; ">HOJA DE VIDA DE EQUIPO MEDICO</h4></td>
					</tr>
				</table>
			</div>	
				
			<h5><div style="text-align: center; background-color:#d9d9d9;">1. INFORMACION DEL CLIENTE</div></h5>
			<div>
				
				<table border="none" style="width: 100%;">
					<tr>
						<th style="width: 20%;">CLIENTE:</th>
						<td style="width: 30%;">'.$cliente.'</td>
						<th style="width: 24%;">FECHA DE REALIZACION:</th>
						<td style="width: 26%;">'.$fechaCreacion.'</td>
					</tr>
					<tr>
						<th style="width: 20%;">DIRECCIÓN:</th>
						<td style="width: 30%;">'.$direccion[0].'</td>
						<th style="width: 24%;">CIUDAD:</th>
						<td style="width: 26%;">'.$direccion[1].'</td>
					</tr>
				</table>				
			</div>

			<!-- SECCION SERVICIO POR Y TIPO DE SERVICIO -->
			<div>
				<table border="none" style="width: 100%;">
					<tr>
						<th style="width: 20%;">SERVICIO POR:</th>
						<th style="width: 5%; text-align: center; background-color:#d9d9d9;">'.$G.'</th>
						<td style="width: 15%;">GARANTIA</td>
						<th style="width: 5%; text-align: center; background-color:#d9d9d9;">'.$C.'</th>
						<td style="width: 15%;">CONTRATO</td>
						<th style="width: 5%; text-align: center; background-color:#d9d9d9;">'.$F.'</th>
						<td style="width: 15%;">FACTURA</td>
						<th style="width: 5%; text-align: center; background-color:#d9d9d9;">'.$O.'</th>
						<td style="width: 15%;">OTRO</td>
					</tr>
					<tr>
						<th style="width: 20%;">TIPO DE SERVICIO:</th>
						<th style="width: 5%; text-align: center; background-color:#d9d9d9;">'.$I.'</th>
						<td style="width: 15%;">INSTALACION</td>
						<th style="width: 5%; text-align: center; background-color:#d9d9d9;">'.$P.'</th>
						<td style="width: 15%;">PREVENTIVO</td>
						<th style="width: 5%; text-align: center; background-color:#d9d9d9;">'.$C2.'</th>
						<td style="width: 15%;">CORRECTIVO</td>
						<th style="width: 5%; text-align: center; background-color:#d9d9d9;">'.$O2.'</th>
						<td style="width: 15%;">OTRO</td>
					</tr>
				</table>
			</div>

			<h5><div style="text-align: center; background-color:#d9d9d9;">2. INFORMACION DEL EQUIPO</div></h5>	

			<div>
				<table border="none" style="width: 100%;">
					<tr>
						<th style="width: 20%;">NOMBRE:</th>
						<td style="width: 30%;">'.$tipoEquipo.'</td>
						<th style="width: 15%;">SERIE:</th>
						<td style="width: 35%;">'.$serie.'</td>
					</tr>
					<tr>
						<th style="width: 20%;">MARCA / MODELO:</th>
						<td style="width: 30%;">'.$marca.' /'.$modelo.'</td>
						<th style="width: 15%;">UBICACION:</th>
						<td style="width: 35%;">'.$ubicacion.'</td>
					</tr>
				</table>				
			</div>

			<h5><div style="text-align: center; background-color:#d9d9d9;">3. CLASIFICACION DEL EQUIPO</div></h5>	

			<div>
				<table border="none" style="width: 100%;">
					<tr>
						<th style="width: 28%;">CLASIFICACION BIOMEDICA:</th>
						<td style="width: 22%;">'.$descripcionBiomedica['nombre'].'</td>
						<th style="width: 28%;">CLASIFICACION DE RIESGO:</th>
						<th style="width: 22%; text-align: center; background-color:'.$colorRiesgo.';">'.$riesgo.'</th>
					</tr>
				</table>				
			</div>

			<h5><div style="text-align: center; background-color:#d9d9d9;">4. PUNTOS DE INSPECCIÓN Y MANTENIMIENTO <br/> PROTOCOLO: GENERAL </div></h5>
			
			<div>

				<table border="1" style="width: 100%;">
					<tr>
						<th style="width: 60%; text-align: center; background-color:#d9d9d9;">DESCRIPCION</th>
						<th style="width: 10%; text-align: center; background-color:#d9d9d9;">ESTADO</th>
						<th style="width: 30%; text-align: center; background-color:#d9d9d9;">OBSERVACIONES</th>
					</tr>

					

			';

			// SECCION INSPECCION INICIAL
			if ($inspeccionInicial[0]->valores->estado === 'N/A') {
				if ($inspeccionInicial[1]->valores->estado === 'N/A') {
					if ($inspeccionInicial[2]->valores->estado === 'N/A') {
						if ($inspeccionInicial[3]->valores->estado === 'N/A') {
							$cuerpo .= '';
						}else {
							$cuerpo .= '
								<tr>
									<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">INSPECCION INICIAL</th>
								</tr>
							';
						}
					}else {
						$cuerpo .= '
							<tr>
								<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">INSPECCION INICIAL</th>
							</tr>
						';
					}
				}else {
					$cuerpo .= '
						<tr>
							<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">INSPECCION INICIAL</th>
						</tr>
					';
				}
			}else {
				$cuerpo .= '
					<tr>
						<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">INSPECCION INICIAL</th>
					</tr>
				';
			}

			switch ($inspeccionInicial[0]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">VERIFICACION DE ESTADO FISICO GENERAL</td>
						<td style="width: 10%; text-align: center;">'.$inspeccionInicial[0]->valores->estado.'</td>
						<td style="width: 30%;">'.$inspeccionInicial[0]->valores->observacion.'</td>
					</tr>
				';
				break;
			}
			
			switch ($inspeccionInicial[1]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">VERIFICACION DE FUNCIONAMIENTO</td>
						<td style="width: 10%; text-align: center;">'.$inspeccionInicial[1]->valores->estado.'</td>
						<td style="width: 30%;">'.$inspeccionInicial[1]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($inspeccionInicial[2]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">VERIFICACION DE ACCESORIOS</td>
						<td style="width: 10%; text-align: center;">'.$inspeccionInicial[2]->valores->estado.'</td>
						<td style="width: 30%;">'.$inspeccionInicial[2]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($inspeccionInicial[3]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">VERIFICACION DE FUNCIONAMIENTO</td>
						<td style="width: 10%; text-align: center;">'.$inspeccionInicial[3]->valores->estado.'</td>
						<td style="width: 30%;">'.$inspeccionInicial[3]->valores->observacion.'</td>
					</tr>
				';
				break;
			}
			
			$cuerpo .= '	
						</table>						
					</div>
				';
			

			// SECCION SISTEMA ELECTRICO
			$state1 = false;
			if ($sistemaElectrico[0]->valores->estado === 'N/A') {
				if ($sistemaElectrico[1]->valores->estado === 'N/A') {
					if ($sistemaElectrico[2]->valores->estado === 'N/A') {
						$state1 = true;
						$cuerpo .= '';	
					}else {
						$cuerpo .= '
						<div>
							<table border="1" style="width: 100%;">
								<tr>
									<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA ELECTRICO</th>
								</tr>
						';
					}
				}else {
					$cuerpo .= '
					<div>
						<table border="1" style="width: 100%;">
							<tr>
								<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA ELECTRICO</th>
							</tr>
					
					';
				}
			}else {
				$cuerpo .= '
				<div>
					<table border="1" style="width: 100%;">
						<tr>
							<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA ELECTRICO</th>
						</tr>
				';
			}
	
			switch ($sistemaElectrico[0]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">ALIMENTACION RED ELECTRICA Y/O REGULACION</td>
						<td style="width: 10%; text-align: center;">'.$sistemaElectrico[0]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaElectrico[0]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaElectrico[1]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;;">ALIMENTACION SUPLEMENTARIA Y/O BATERIAS</td>
						<td style="width: 10%;; text-align: center;">'.$sistemaElectrico[1]->valores->estado.'</td>
						<td style="width: 30%;;">'.$sistemaElectrico[1]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaElectrico[2]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">PROTECCIONES (FUSIBLES, TERMICOS, ETC)</td>
						<td style="width: 10%; text-align: center;">'.$sistemaElectrico[2]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaElectrico[2]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			if ($state1) {
				$cuerpo .= '';
			}else {
				$cuerpo .= '	
						</table>									
					</div>
				';
			}


			// SECCION SISTEMA ELECTRONICO
			$state2 = false;
			if ($sistemaElectronico[0]->valores->estado === 'N/A') {
				if ($sistemaElectronico[1]->valores->estado === 'N/A') {
					if ($sistemaElectronico[2]->valores->estado === 'N/A') {
						if ($sistemaElectronico[3]->valores->estado === 'N/A') {
							if ($sistemaElectronico[4]->valores->estado === 'N/A') {
								$state2 = true;
								$cuerpo .= '';
							}else {
								$cuerpo .= '
								<div>
									<table border="1" style="width: 100%;">
										<tr>
											<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA ELECTRONICO</th>
										</tr>
								';
							}
						}else {
							$cuerpo .= '
							<div>
								<table border="1" style="width: 100%;">
									<tr>
										<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA ELECTRONICO</th>
									</tr>
							';
						}
					}else {
						$cuerpo .= '
						<div>
							<table border="1" style="width: 100%;">
								<tr>
									<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA ELECTRONICO</th>
								</tr>
						';
					}
				}else {
					$cuerpo .= '
					<div>
						<table border="1" style="width: 100%;">
							<tr>
								<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA ELECTRONICO</th>
							</tr>
					';
				}
			}else {
				$cuerpo .= '
				<div>
					<table border="1" style="width: 100%;">
						<tr>
							<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA ELECTRONICO</th>
						</tr>
				';
			}

			switch ($sistemaElectronico[0]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">TARJETA PRINCIPAL DE CONTROL Y/O POTENCIA</td>
						<td style="width: 10%; text-align: center;">'.$sistemaElectronico[0]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaElectronico[0]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaElectronico[1]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">CONECTORES Y PUERTOS DE COMUNICACION</td>
						<td style="width: 10%; text-align: center;">'.$sistemaElectronico[1]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaElectronico[1]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaElectronico[2]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">MANDOS DE CONTROL, TECLADOS</td>
						<td style="width: 10%; text-align: center;">'.$sistemaElectronico[2]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaElectronico[2]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaElectronico[3]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">MODULOS DE MONITOREO (EKG,SPO2,NIBP,TEMP, ETC)</td>
						<td style="width: 10%; text-align: center;">'.$sistemaElectronico[3]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaElectronico[3]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaElectronico[4]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">PANTALLAS E INDICADORES VISUALES/AUDITIVOS</td>
						<td style="width: 10%; text-align: center;">'.$sistemaElectronico[4]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaElectronico[4]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			if ($state2) {
				$cuerpo .= '';
			}else {
				$cuerpo .= '	
						</table>									
					</div>
				';
			}

			// SECCION SISTEMA MECANICO
			$state3 = false;
			if ($sistemaMecanico[0]->valores->estado === 'N/A') {
				if ($sistemaMecanico[1]->valores->estado === 'N/A') {
					if ($sistemaMecanico[2]->valores->estado === 'N/A') {
						$state3 = true;
						$cuerpo .= '';	
					}else {
						$cuerpo .= '
						<div>
							<table border="1" style="width: 100%;">
								<tr>
									<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA MECANICO</th>
								</tr>
						';
					}
				}else {
					$cuerpo .= '
					<div>
						<table border="1" style="width: 100%;">
							<tr>
								<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA MECANICO</th>
							</tr>
					
					';
				}
			}else {
				$cuerpo .= '
				<div>
					<table border="1" style="width: 100%;">
						<tr>
							<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA MECANICO</th>
						</tr>
				';
			}
	
			switch ($sistemaMecanico[0]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">AJUSTE DE PIEZAS MOVILES</td>
						<td style="width: 10%; text-align: center;">'.$sistemaMecanico[0]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaMecanico[0]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaMecanico[1]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">LUBRICACION Y AJUSTE DE PIEZAS</td>
						<td style="width: 10%; text-align: center;">'.$sistemaMecanico[1]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaMecanico[1]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaMecanico[2]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">ACTUADORES MECANICOS</td>
						<td style="width: 10%; text-align: center;">'.$sistemaMecanico[2]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaMecanico[2]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			if ($state3) {
				$cuerpo .= '';
			}else {
				$cuerpo .= '	
						</table>									
					</div>
				';
			}

			// SECCION SISTEMA NEUMATICO/HIDRAULICO
			$state4 = false;
			if ($sistemaNeumatico[0]->valores->estado === 'N/A') {
				if ($sistemaNeumatico[1]->valores->estado === 'N/A') {
					if ($sistemaNeumatico[2]->valores->estado === 'N/A') {
						if ($sistemaNeumatico[3]->valores->estado === 'N/A') {
							$state4 = true;
							$cuerpo .= '';
						}else {
							$cuerpo .= '
							<div>
								<table border="1" style="width: 100%;">
									<tr>
										<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA NEUMATICO/HIDRAULICO</th>
									</tr>
							';
						}
					}else {
						$cuerpo .= '
						<div>
							<table border="1" style="width: 100%;">
								<tr>
									<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA NEUMATICO/HIDRAULICO</th>
								</tr>
						';
					}
				}else {
					$cuerpo .= '
					<div>
						<table border="1" style="width: 100%;">
							<tr>
								<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA NEUMATICO/HIDRAULICO</th>
							</tr>
					';
				}
			}else {
				$cuerpo .= '
				<div>
					<table border="1" style="width: 100%;">
						<tr>
							<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA NEUMATICO/HIDRAULICO</th>
						</tr>
				';
			}

			switch ($sistemaNeumatico[0]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">VALVULAS, CONTROLES Y REGULADORES DE PRESION Y/O FLUJO</td>
						<td style="width: 10%; text-align: center;">'.$sistemaNeumatico[0]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaNeumatico[0]->valores->observacion.'</td>
					</tr>
				';
				break;
			}
			
			switch ($sistemaNeumatico[1]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">COMPRESOR Y/O TURBINA</td>
						<td style="width: 10%; text-align: center;">'.$sistemaNeumatico[1]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaNeumatico[1]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaNeumatico[2]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">MANGUERAS, TUBERIAS, ACOPLES Y EMPAQUES</td>
						<td style="width: 10%; text-align: center;">'.$sistemaNeumatico[2]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaNeumatico[2]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaNeumatico[3]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">FILTROS, TRAMPAS DE AGUA, EMPAQUES, ACOPLES</td>
						<td style="width: 10%; text-align: center;">'.$sistemaNeumatico[3]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaNeumatico[3]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			if ($state4) {
				$cuerpo .= '';
			}else {
				$cuerpo .= '	
						</table>									
					</div>
				';
			}

			// SECCION SISTEMA DE VENTILACION MECANICA
			$state5 = false;
			if ($sistemaVentilacion[0]->valores->estado === 'N/A') {
				if ($sistemaVentilacion[1]->valores->estado === 'N/A') {
					if ($sistemaVentilacion[2]->valores->estado === 'N/A') {
						$state5 = true;
						$cuerpo .= '';	
					}else {
						$cuerpo .= '
						<div>
							<table border="1" style="width: 100%;">
								<tr>
									<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA DE VENTILACION MECANICA</th>
								</tr>
						';
					}
				}else {
					$cuerpo .= '
					<div>
						<table border="1" style="width: 100%;">
							<tr>
								<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA DE VENTILACION MECANICA</th>
							</tr>
					
					';
				}
			}else {
				$cuerpo .= '
				<div>
					<table border="1" style="width: 100%;">
						<tr>
							<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">SISTEMA DE VENTILACION MECANICA</th>
						</tr>
				';
			}
	
			switch ($sistemaVentilacion[0]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">PARAMETROS Y MODULOS DE VENTILACION</td>
						<td style="width: 10%; text-align: center;">'.$sistemaVentilacion[0]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaVentilacion[0]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaVentilacion[1]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">LUBRICACION Y AJUSTE DE PIEZAS</td>
						<td style="width: 10%; text-align: center;">'.$sistemaMecanico[1]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaMecanico[1]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($sistemaVentilacion[2]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">ACUMULADORES Y/O ACTUADORES NEUMATICOS</td>
						<td style="width: 10%; text-align: center;">'.$sistemaVentilacion[2]->valores->estado.'</td>
						<td style="width: 30%;">'.$sistemaVentilacion[2]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			if ($state5) {
				$cuerpo .= '';
			}else {
				$cuerpo .= '	
						</table>									
					</div>
				';
			}

			// SECCION INSPECCION FINAL
			$state6 = false;
			if ($inspeccionFinal[0]->valores->estado === 'N/A') {
				if ($inspeccionFinal[1]->valores->estado === 'N/A') {
					if ($inspeccionFinal[2]->valores->estado === 'N/A') {
						$state6 = true;
						$cuerpo .= '';	
					}else {
						$cuerpo .= '
						<div>
							<table border="1" style="width: 100%;">
								<tr>
									<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">INSPECCION FINAL</th>
								</tr>
						';
					}
				}else {
					$cuerpo .= '
					<div>
						<table border="1" style="width: 100%;">
							<tr>
								<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">INSPECCION FINAL</th>
							</tr>
					
					';
				}
			}else {
				$cuerpo .= '
				<div>
					<table border="1" style="width: 100%;">
						<tr>
							<th colspan="3" style="width: 100%; text-align: center; background-color:#d9d9d9;">INSPECCION FINAL</th>
						</tr>
				';
			}
	
			switch ($inspeccionFinal[0]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">ESTADO GENERAL</td>
						<td style="width: 10%; text-align: center;">'.$inspeccionFinal[0]->valores->estado.'</td>
						<td style="width: 30%;">'.$inspeccionFinal[0]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($inspeccionFinal[1]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">PRUEBAS FUNCIONALES</td>
						<td style="width: 10%; text-align: center;">'.$inspeccionFinal[1]->valores->estado.'</td>
						<td style="width: 30%;">'.$inspeccionFinal[1]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			switch ($inspeccionFinal[2]->valores->estado) {
				case 'N/A':
				$cuerpo .= '';
				break;
				
				default:
				$cuerpo .= '
					<tr>
						<td style="width: 60%;">SE ENTREGA FUNCIONANDO EN COMPAÑIA DEL OPERADOR</td>
						<td style="width: 10%; text-align: center;">'.$inspeccionFinal[2]->valores->estado.'</td>
						<td style="width: 30%;">'.$inspeccionFinal[2]->valores->observacion.'</td>
					</tr>
				';
				break;
			}

			if ($state6) {
				$cuerpo .= '';
			}else {
				$cuerpo .= '	
						</table>									
					</div>
				';
			}

			$cuerpo .= '						
			<br><br><br><br>

			<!-- SECCION OBSERVACIONES GENERALES -->
			<div>
				<table border="1" style="width: 100%;">
					<tr>
						<th style="width: 100%; text-align: center; background-color:#d9d9d9;">OBSERVACIONES GENERALES</th>
					</tr>
					<tr>
						<td style="width: 100%;">'.$fila['observaciones'].' <br><br><br><br><br><br><br> </td>
					</tr>
				</table>				
			</div>

			<!-- SECCION FINAL DE FIRMAS -->
			<div style="position: absolute; bottom: 8px;">
				<table border="1" style="width: 100%;">
					<tr>
						<th style="width: 50%;"> <br/><br/><br/><br/> </th>
						<td style="width: 50%;"> <br/><br/><br/><br/> </td>
					</tr>
					<tr>
						<td style="width: 50%;">Realizado por: <strong>JUAN LEONARDO SALAZAR ARIAS</strong> </td>
						<td style="width: 50%;">Recibido por: <strong>JEFE DEL SERVICIO</strong> </td>
					</tr>
				</table>				
			</div>

		';
		}
		
		$html2pdf = new Html2Pdf();
		$html2pdf->writeHTML($cuerpo);
		// $html2pdf->output('Reporte_'.$id.'.pdf', 'D');
		$html2pdf->output('Reporte_'.$id.'.pdf');
	}
?>