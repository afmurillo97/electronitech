<?php
	include '../../../libs/htmlPdf/autoload.php';
	include '../../../login/conexion.php';

	use Spipu\Html2Pdf\Html2Pdf;

	function getVariables($con, $id){
		$sql="SELECT * FROM variablesMetrologicas WHERE (id=\"$id\")";
		$query=$con->query($sql);
		$resultado=$query->fetch_all(MYSQLI_ASSOC);
		$num=$query->num_rows;

		if ($num>=1) {
			foreach ($resultado as $fila) {
				return $fila['nombre'];
			}
		}else{
			return false;
		}
	}

	function getProveedor($con, $id){
		$sql="SELECT * FROM proveedores WHERE (id=\"$id\")";
		$query=$con->query($sql);
		$resultado=$query->fetch_all(MYSQLI_ASSOC);
		$num=$query->num_rows;

		if ($num>=1) {
			foreach ($resultado as $fila) {
				return ['nombre'=>$fila['nombre'], 'representante'=>$fila['representante'], 'ciudad'=>$fila['ciudad'], 'email'=>$fila['email']];
			}
		}else{
			return false;
		}
	}

	function getFabricante($con, $id){
		$sql="SELECT * FROM fabricantes WHERE (id=\"$id\")";
		$query=$con->query($sql);
		$resultado=$query->fetch_all(MYSQLI_ASSOC);
		$num=$query->num_rows;

		if ($num>=1) {
			foreach ($resultado as $fila) {
				return ['nombre'=>$fila['nombre'], 'ciudad'=>$fila['ciudad'], 'email'=>$fila['email']];
			}
		}else{
			return false;
		}
	}

	$id=$_REQUEST['id'];

	$sql="SELECT articulosView.*, descripcionBiomedica.nombre AS descripcionBiomedica FROM articulosView INNER JOIN descripcionBiomedica ON descripcionBiomedica.id=articulosView.idDescripcionBiomedica WHERE (articulosView.id=\"$id\")";
	$query=$con->query($sql);
	$resultado=$query->fetch_all(MYSQLI_ASSOC);
	$num=$query->num_rows;

	if ($num>=1) {
		foreach ($resultado as $fila) {
			$idEquipo=$fila['idEquipo'];
			$marca=$fila['marca'];
			$modelo=$fila['modelo'];
			$serie=$fila['serie'];
			$servicio=$fila['servicio'];
			$tipoEquipo=$fila['tipoEquipo'];
			$codigoEcri=$fila['codigoEcri'];
			$cliente=$fila['cliente'];
			$registro=$fila['registro'];
			$inventario=$fila['inventario'];
			$codDoc=$fila['codDoc'];
			$riesgo=$fila['riesgo'];
			$descripcionBiomedica=$fila['descripcionBiomedica'];
			$direccion = explode('@', $fila['direccion']);


			$cuerpo = '
				<!-- ENCABEZADO 1 PAG -->
				<table border="1" style="width: 100%;">
					<tr>	
						<td rowspan="3" style="width: 30%;"> <img src="../../../assets/images/template/Login_bg.jpg" alt="" width="220" height="120"> </td>
						<td rowspan="2" style="width: 45%;"><h4 style="text-align: center;">'.$cliente.'</h4></td>
						<td style="width: 25%;"><strong>CÓDIGO:</strong> '.$codDoc.'</td>
					</tr>
					<tr>
						<td><strong>VERSIÓN:</strong> 1.0.0</td>
					</tr>
					<tr>
						<td><h4 style="text-align: center;">HOJA DE VIDA DE EQUIPO MEDICO</h4></td>
						<td><strong>FECHA:</strong> '.date('d-m-Y').'</td>
					</tr>
				</table><br>

				<!-- SECCION PRESTADOR DE SERVICIOS DE SALUD 1 PAG -->
				<table cellspacing="10" style="width: 100%; border: 4px double black;">
					<tr>
						<th colspan="4" style="text-align: center; font-size: 16px;">PRESTADOR DE SERVICIOS DE SALUD</th>
					</tr>
					<tr>
						<th style="width: 20%;">NOMBRE:</th>
						<td style="width: 30%;">'.$cliente.'</td>
						<th style="width: 20%;">REPS:</th>
						<td style="width: 30%;">'.$fila['codigoCliente'].'</td>
					</tr>
					<tr>
						<th style="width: 20%;">DIRECCIÓN:</th>
						<td style="width: 30%;">'.$direccion[0].'</td>
						<th style="width: 20%;">LOCALIZACIÓN:</th>
						<td style="width: 30%;">'.$direccion[1].'</td>
					</tr>
					<tr>
						<th style="width: 20%;">TELEFONO:</th>
						<td style="width: 30%;">'.$fila['telefono'].'</td>
						<th style="width: 20%;">DISTINTIVO:</th>
						<td style="width: 30%;">DHS'.$fila['codigoCliente'].'</td>
					</tr>
					<tr>
						<th style="width: 20%;">E-MAIL:</th>
						<td style="width: 30%;">'.$fila['email'].'</td>
						<th style="width: 20%;">UBICACIÓN:</th>
						<td style="width: 30%;">'.$fila['ubicacion'].'</td>
					</tr>
				</table><br>
				
			';
		}

		$sql2="SELECT * FROM equipos WHERE (id=\"$idEquipo\")";
		$query2=$con->query($sql2);
		$resultado2=$query2->fetch_all(MYSQLI_ASSOC);
		$num2=$query2->num_rows;
		
		if ($num2>=1) {
			foreach ($resultado2 as $fila) {
				$vidaUtil=$fila['vidaUtil'];
				$tipoRegistro=$fila['registro'];
				$documento=$fila['documento'];
				$urlFotoEquipo = explode('electronitech/', $documento);

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

			$cuerpo .= '
				<!-- SECCION EQUIPO BIOMEDICO 1 PAG -->
				<table cellspacing="10" style="width: 100%; border: 4px double black;">
					<tr>
						<th colspan="3" style="text-align: center; font-size: 16px;">EQUIPO BIOMEDICO</th>
					</tr>
					<tr>
						<th style="width: 30%;">NOMBRE:</th>
						<td style="width: 46%;">'.$tipoEquipo.'</td>
						<td rowspan="13" style="width: 24%;"> <img src="../../../'.$urlFotoEquipo[1].'" alt="" width="160" height="300"> </td>
					</tr>
					<tr>
						<th width="30%"> MARCA:</th>
						<td width="46%">'.$marca.'</td>
					</tr>
					<tr>
						<th width="30%"> MODELO:</th>
						<td width="46%">'.$modelo.'</td>
					</tr>
					<tr>
						<th width="30%"> SERIE (S/N):</th>
						<td width="46%">'.$serie.'</td>
					</tr>
					<tr>
						<th width="30%"> CÓDIGO ECRI:</th>
						<td width="46%">'.$codigoEcri.'</td>
					</tr>
					<tr>
						<th width="30%"> No. INVENTARIO:</th>
						<td width="46%">'.$inventario.'</td>
					</tr>
				';

				switch ($tipoRegistro) {
					case 'RS':
				$cuerpo .= '
					<tr>
						<th width="30%"> REGISTRO INVIMA:</th>
						<td width="46%">RS:&nbsp;&nbsp;X&nbsp;&nbsp;PC:____NR:____</td>
					</tr>
				';
						break;
					case 'PC':
				$cuerpo .= '
					<tr>
						<th width="30%"> REGISTRO INVIMA:</th>
						<td width="46%">RS:____PC:&nbsp;&nbsp;X&nbsp;&nbsp;NR:____</td>
					</tr>
				';
						break;
					
					default:
				$cuerpo .= '
					<tr>
						<th width="30%"> REGISTRO INVIMA:</th>
						<td width="46%">RS:____PC:____NR:&nbsp;&nbsp;X&nbsp;&nbsp;</td>
					</tr>
				';
						break;
				}

				$cuerpo .= '
					<tr>
						<th width="30%"> No. REGISTRO:</th>
						<td width="46%">'.$registro.'</td>
					</tr>
					<tr>
						<th width="30%"> CONDICION:</th>
						<td width="46%">____________________________________________</td>
					</tr>
			
					<tr>
						<th width="30%"> CLASIFICACION DE RIESGO:</th>
						<td width="46%" style="background-color: '.$colorRiesgo.'; text-align: center; "> '.$riesgo.' </td>
					</tr>
					<tr>
						<th width="30%"> SERVICIO:</th>
						<td width="46%">'.$servicio.'</td>
					</tr>
					<tr>
						<th width="30%"> CLASIFICACION BIOMEDICA:</th>
						<td width="46%">'.$descripcionBiomedica.'</td>
					</tr>
				</table><br>
				<span style="position: absolute; bottom: 8px;">NR*: No Registra. NA*: No Aplica.</span>

				

			';

			}
		}

		$sql5="SELECT * FROM relaciones WHERE (idPrincipal=\"$id\" AND modulo='articulos' AND pestana='historico')";
		$query5=$con->query($sql5);
		$resultado5=$query5->fetch_all(MYSQLI_ASSOC);
		$num5=$query5->num_rows;

		if ($num5>=1) {
			foreach ($resultado5 as $fila) {
				switch ($fila['nombre']) {
					case 'fechaAdquisicion':
						$fechaAdquisicion=json_decode($fila['valores'])->val1;
						break;
					case 'fechaEntrega':
						$fechaEntrega=json_decode($fila['valores'])->val1;
						break;
					case 'fechaInicio':
						$fechaInicio=json_decode($fila['valores'])->val1;
						break;
					case 'fechaFabricacion':
						$fechaFabricacion=json_decode($fila['valores'])->val1;
						break;
					case 'fechaVencimiento':
						$fechaVencimiento=json_decode($fila['valores'])->val1;
						break;
					case 'proveedor':
						$proveedor=getProveedor($con, json_decode($fila['valores'])->val1);
						break;
					case 'fabricante':
						$fabricante=getFabricante($con, json_decode($fila['valores'])->val1);
						break;
					case 'formaAdquisicion':
						$formaAdquisicion=json_decode($fila['valores'])->val1;
						break;
					case 'costoSinIVA':
						$costoSinIVA=json_decode($fila['valores'])->val1;
						break;
					case 'documentoAdquisicion':
						$documentoAdquisicion=json_decode($fila['valores'])->val1;
						break;						
				}
			}

			$cuerpo .= '
			<!-- SECCION REGISTRO HISTORICO DEL EQUIPO 1 PAG -->
			<br><table cellspacing="10" style="width: 100%; border: 4px double black;">
				<tr>
					<th colspan="4" style="text-align: center; font-size: 16px;">REGISTRO HISTORICO DEL EQUIPO</th>
				</tr>
				<tr>
					<th style="width: 17%;">COMPRA:</th>
					<td style="width: 34%;">'.$fechaAdquisicion.'</td>
					<th style="width: 13%;">ENTREGA:</th>
					<td style="width: 36%;">'.$fechaEntrega.'</td>
				</tr>
				<tr>
					<th style="width: 17%;">INSTALACION:</th>
					<td style="width: 34%;">'.$fechaAdquisicion.'</td>
					<th style="width: 13%;">INICIO OPERACION:</th>
					<td style="width: 36%;">'.$fechaInicio.'</td>
				</tr>
				<tr>
					<th style="width: 17%;">FABRICACION:</th>
					<td style="width: 34%;">'.$fechaFabricacion.'</td>
					<th style="width: 13%;">VENC. GARANTIA:</th>
					<td style="width: 36%;">'.$fechaVencimiento.'</td>
				</tr>
				<tr>
					<th colspan="2" style="width: auto;">PROVEEDOR:</th>
					<td colspan="2" style="width: auto;">'.$proveedor['nombre'].'</td>
				</tr>
				<tr>
					<th style="width: 17%;">REPRESENTANTE:</th>
					<td style="width: 34%;">'.$proveedor['representante'].'</td>
					<th style="width: 13%;">FABRICANTE:</th>
					<td style="width: 36%;">'.$fabricante['nombre'].'</td>
				</tr>
				<tr>
					<th style="width: 17%;">E-MAIL PROV:</th>
					<td style="width: 34%;">'.$proveedor['email'].'</td>
					<th style="width: 13%;">E-MAIL FAB:</th>
					<td style="width: 36%;">'.$fabricante['email'].'</td>
				</tr>
				<tr>
					<th style="width: 17%;">CIUDAD/PAIS:</th>
					<td style="width: 34%;">'.$proveedor['ciudad'].'</td>
					<th style="width: 13%;">CIUDAD/PAIS:</th>
					<td style="width: 36%;">'.$fabricante['ciudad'].'</td>
				</tr>
				<tr>
					<th style="width: 17%;">FORMA DE ADQUISICION:</th>
					<td style="width: 34%;">'.$formaAdquisicion.'</td>
					<th style="width: 13%;">VIDA UTIL[AÑOS]:</th>
					<td style="width: 36%;">'.$vidaUtil.'</td>
				</tr>
				<tr>
					<th style="width: 17%;">REFERENCIA DE ADQUISICION:</th>
					<td style="width: 34%;">'.$documentoAdquisicion.'</td>
					<th style="width: 13%;">COSTO:</th>
					<td style="width: 36%;">$ '.number_format($costoSinIVA).'</td>
				</tr>
			</table><br>';	
		}

		$sql3="SELECT * FROM relaciones WHERE (idPrincipal=\"$idEquipo\" AND modulo='equipos')";
		$query3=$con->query($sql3);
		$resultado3=$query3->fetch_all(MYSQLI_ASSOC);
		$num3=$query3->num_rows;

		if ($num3>=1) {
			$cuerpo .= '
					<div style="width: 100%; display: inline-block;">
						<!-- ENCABEZADO 2 PAG -->
						<table border="1" style="width: 100%;">
							<tr>	
								<td rowspan="3" style="width: 30%;"> <img src="../../../assets/images/template/Login_bg.jpg" alt="" width="220" height="120"> </td>
								<td rowspan="2" style="width: 45%;"><h4 style="text-align: center;">'.$cliente.'</h4></td>
								<td style="width: 25%;"><strong>CÓDIGO:</strong> '.$codDoc.'</td>
							</tr>
							<tr>
								<td><strong>VERSIÓN:</strong> 1.0.0</td>
							</tr>
							<tr>
								<td><h4 style="text-align: center;">HOJA DE VIDA DE EQUIPO MEDICO</h4></td>
								<td><strong>FECHA:</strong> '.date('d-m-Y').'</td>
							</tr>
						</table><br>

						<!-- REGISTRO TECNICO DE INSTALACION 2 PAG -->
						<table cellspacing="10" style="width: 100%; border: 4px double black;">
							<tr>
								<th colspan="2" style="text-align: center; font-size: 16px;">REGISTRO TECNICO DE INSTALACION</th>
							</tr>
			';
			foreach ($resultado3 as $fila) {
				switch ($fila['nombre']) {
					case 'fuenteAlimentacion':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> FUENTE DE ALIMENTACIÓN:</th>
								<td style="width: 60%;">'.json_decode($fila['valores'])->val1.'</td>
							</tr>
						';
						break;
					case 'tecnologiaDominante':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> TECNOLOGIA PREDOMINANTE:</th>
								<td style="width: 60%;">'.json_decode($fila['valores'])->val1.'</td>
							</tr>
						';
						break;
					case 'voltajeDeAlimentacion':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> VOLTAJE DE ALIMENTACIÓN ['.json_decode($fila['valores'])->unidad.']:</th>
								<td style="width: 60%;">MAX: '.json_decode($fila['valores'])->max.' MIN: '.json_decode($fila['valores'])->min.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'consumoDeCorriente':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> CONSUMO DE CORRIENTE ['.json_decode($fila['valores'])->unidad.']:</th>								
								<td style="width: 60%;">MAX: '.json_decode($fila['valores'])->max.' MIN: '.json_decode($fila['valores'])->min.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'temperaturaOperativa':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> TEMPERATURA OPERATIVA['.json_decode($fila['valores'])->unidad.']:</th>								
								<td style="width: 60%;">MAX: '.json_decode($fila['valores'])->max.' MIN: '.json_decode($fila['valores'])->min.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'potenciaDisipada':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> POTENCIA DISCIPADA ['.json_decode($fila['valores'])->unidad.']:</th>								
								<td style="width: 60%;">'.json_decode($fila['valores'])->val1.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'frecuenciaElectrica':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> FRECUENCIA DE TRABAJO ['.json_decode($fila['valores'])->unidad.']:</th>								
								<td style="width: 60%;">'.json_decode($fila['valores'])->val1.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'velocidadFlujo':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> VELOCIDAD ['.json_decode($fila['valores'])->unidad.']:</th>								
								<td style="width: 60%;">'.json_decode($fila['valores'])->val1.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
				}
			}
			$cuerpo .= '
						</table><br>
					</div>
					
					<div style="width: 100%; display: inline-block;">

						<!-- REGISTRO TECNICO DE FUNCIONAMIENTO 2 PAG -->
						<table cellspacing="10" style="width: 100%; border: 4px double black;">

							<tr>
								<th colspan="2" style="text-align: center; font-size: 16px;">REGISTRO TECNICO DE FUNCIONAMIENTO</th>
							</tr>
			';
			foreach ($resultado3 as $fila) {
				switch ($fila['nombre']) {
					case 'controlPresion':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> PRESION:</th>
								<td style="width: 60%;">'.json_decode($fila['valores'])->max.' - '.json_decode($fila['valores'])->min.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'controlTemperatura':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> TEMPERATURA:</th>
								<td style="width: 60%;">MAX: '.json_decode($fila['valores'])->max.' MIN: '.json_decode($fila['valores'])->min.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'controlEnergia':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> ENERGIA:</th>
								<td style="width: 60%;">MAX: '.json_decode($fila['valores'])->max.' MIN: '.json_decode($fila['valores'])->min.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'pesoSoportado':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> PESO:</th>
								<td style="width: 60%;">MAX: '.json_decode($fila['valores'])->max.' MIN: '.json_decode($fila['valores'])->min.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'controlVelocidad':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> VELOCIDAD:</th>								
								<td style="width: 60%;">MAX: '.json_decode($fila['valores'])->max.' MIN: '.json_decode($fila['valores'])->min.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'potenciaIrradiada':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> POTENCIA RADIADA:</th>
								<td style="width: 60%;">MAX: '.json_decode($fila['valores'])->max.' MIN: '.json_decode($fila['valores'])->min.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
				}
			}
			$cuerpo .= '
						</table><br>
					</div>
			';
		}

		$sql4="SELECT * FROM relaciones WHERE (idPrincipal=\"$id\" AND modulo='articulos' AND pestana='monitoreo')";
		$query4=$con->query($sql4);
		$resultado4=$query4->fetch_all(MYSQLI_ASSOC);
		$num4=$query4->num_rows;

		if ($num4>=1) {
			$cuerpo .= '
					
					<div style="width: 100%; display: inline-block;">

						<!-- CARACTERISTICAS DE MONITOREO EN EL PACIENTE 2 PAG -->
						<table cellspacing="10" style="width: 100%; border: 4px double black;">
							<tr>
								<th colspan="8" style="text-align: center; font-size: 16px;">CARACTERISTICAS DE MONITOREO EN EL PACIENTE</th>
							</tr>
			';
			$cuerpo .= '<tr>';
			foreach ($resultado4 as $fila) {
				switch ($fila['nombre']) {
					case 'dioxidoCarbono':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">CO<sub>2</sub>:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">CO<sub>2</sub>:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
					case 'frecuenciaCardiaca':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">FC:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">FC:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
					case 'temperatura':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">TEMP:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">TEMP:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
					case 'gasesAnestesicos':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">GA:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">GA:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
				}				
			}	
 			$cuerpo .= '
						</tr>
						<tr>
			';
			foreach ($resultado4 as $fila) {
				switch ($fila['nombre']) {
					case 'electroCardiografia':						
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">ECF:</th>
								<td style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">ECF:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
					case 'presionNoInvasiva':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">PNI:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">PNI:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
					case 'oximetriaPulso':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">SPO<sub>2</sub>:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">SPO<sub>2</sub>:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
					case 'gastoCardiaco':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">GC:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">GC:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
				}
			}
			$cuerpo .= '
						</tr>
						<tr>
			';
			foreach ($resultado4 as $fila) {
				switch ($fila['nombre']) {
					case 'electroMiografia':						
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">EM:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">EM:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
					case 'presionInvasiva':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">PI:</th>
								<td  style="width: 15%;">SI</td>
							';
						}
						break;
					case 'indiceBispectral':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">IB:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">IB:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
					case 'glucosa':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">GLC:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">GLC:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
				}
			}
			$cuerpo .= '
						</tr>
						<tr>
			';
			foreach ($resultado4 as $fila) {
				switch ($fila['nombre']) {
					case 'electroOculografia':						
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">EO:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">EO:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
					case 'respiracion':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">RES:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">RES:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
					case 'Electroencefalografia':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">EEG:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">EEG:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
					case 'ultrasonido':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">US:</th>
								<td  style="width: 15%;">SI</td>
							';
						} else {
							$cuerpo .= '
								<th style="width: 10%;">US:</th>
								<td  style="width: 15%;">NA</td>
							';
						}
						break;
				}
			}
			$cuerpo .= '
							</tr>
						</table>
					</div><br>
			';
		}

		// CONSULTA 3
		if ($num3>=1) {
			$cuerpo .= '
					
					<div style="width: 100%; display: inline-block;">

						<!-- VARIABLES METROLOGICAS 2 PAG -->
						<table cellspacing="10" style="width: 100%; border: 4px double black;">
							<tr>
								<th colspan="3" style="text-align: center; font-size: 16px;">VARIABLES METROLOGICAS</th>
							</tr>
							<tr>
								<th>VARIABLE</th>
								<th>EXACTITUD</th>
								<th>UNIDAD</th>
							</tr>
			';
			foreach ($resultado3 as $fila) {
				if ($fila['pestana']==='variables') {
					$unidad = (json_decode($fila['valores'])->val3==='porcentaje') ? '%' : 'N';
					$cuerpo .= '
						<tr>
							<td style="width: 33%;">'.getVariables($con, json_decode($fila['valores'])->val1).'</td>
							<td style="width: 33%;">(+|-) '.json_decode($fila['valores'])->val2.' '.$unidad.'</td>
							<td style="width: 34%;">'.$unidad.'</td>
						</tr>
					';
				} else if ($fila['pestana']==='accesorios') {
					$descripcion=json_decode($fila['valores'])->val1;
					$marcaRef=json_decode($fila['valores'])->val2;
					$cuerpo .= '
						</table><br>
						
						<!-- REGISTROS TECNICOS, MANUALES, COMPONENTES Y/O ACCESORIOS 2 PAG -->
						<table cellspacing="10" style="width: 100%; border: 4px double black;">
							<tr>
								<th colspan="2" style="text-align: center; font-size: 16px;">REGISTROS TECNICOS, MANUALES, COMPONENTES Y/O ACCESORIOS</th>
							</tr>
							<tr>
								<th style="width: 70%;">DESCRIPCION:</th>
								<th style="width: 30%;">MARCA / REF:</th>
							</tr>
							<tr>
								<td style="width: 70%;">'.$descripcion.'</td>
								<td style="width: 30%;">'.$marcaRef.'</td>
							</tr>


						</table><br><br><br>

						<span style="">NR*: No Registra. NA*: No Aplica.</span>
						

					</div>
			';
				}
			}
			
		}

		$html2pdf = new Html2Pdf();
		$html2pdf->writeHTML($cuerpo);
		// $html2pdf->output('Guia_'.$id.'.pdf', 'D');
		$html2pdf->output('Guia_'.$id.'.pdf');
	}
?>