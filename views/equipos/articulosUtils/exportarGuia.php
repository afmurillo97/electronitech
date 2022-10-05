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

	$id=$_REQUEST['id'];

	$sql="SELECT * FROM articulosView WHERE (id=\"$id\")";
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

			$cuerpo = '
				<h4><div style="text-align: center;">PRESTADOR DE SERVICIOS DE SALUD</div></h4>
				<table border="1" style="width: 100%;">
					<tr>
						<th style="width: 20%;">NOMBRE:</th>
						<td style="width: 30%;">'.$fila['cliente'].'</td>
						<th style="width: 20%;">REPS:</th>
						<td style="width: 30%;">'.$fila['codigoCliente'].'</td>
					</tr>
					<tr>
						<th style="width: 20%;">DIRECCIÓN:</th>
						<td style="width: 30%;">'.$fila['direccion'].'</td>
						<th style="width: 20%;">LOCALIZACIÓN:</th>
						<td style="width: 30%;">'.$fila['direccion'].'</td>
					</tr>
					<tr>
						<th style="width: 20%;">TELEFONO:</th>
						<td style="width: 30%;">'.$fila['telefono'].'</td>
						<th style="width: 20%;">DISTINTIVO:</th>
						<td style="width: 30%;">npi</td>
					</tr>
					<tr>
						<th style="width: 20%;">E-MAIL:</th>
						<td style="width: 30%;">'.$fila['email'].'</td>
						<th style="width: 20%;">UBICACIÓN:</th>
						<td style="width: 30%;">'.$fila['ubicacion'].'</td>
					</tr>
				</table>
			';
		}

		$sql2="SELECT * FROM equipos WHERE (id=\"$idEquipo\")";
		$query2=$con->query($sql2);
		$resultado2=$query2->fetch_all(MYSQLI_ASSOC);
		$num2=$query2->num_rows;

		if ($num2>=1) {
			foreach ($resultado2 as $fila) {
				$cuerpo .= '
					<h4><div style="text-align: center;">EQUIPO BIOMEDICO</div></h4>
					<table border="1" style="width: 100%;">
						<tr>
							<th style="width: 20%;">NOMBRE:</th>
							<td style="width: 46%;">'.$tipoEquipo.'</td>
							<td rowspan="13" style="width: 33%;">img</td>
						</tr>
						<tr>
							<th width="20%"> MARCA:</th>
							<td width="46%">'.$marca.'</td>
						</tr>
						<tr>
							<th width="20%"> MODELO:</th>
							<td width="46%">'.$modelo.'</td>
						</tr>
						<tr>
							<th width="20%"> SERIE (S/N):</th>
							<td width="46%">'.$serie.'</td>
						</tr>
						<tr>
							<th width="20%"> CÓDIGO ECRI:</th>
							<td width="46%">'.$codigoEcri.'</td>
						</tr>
						<tr>
							<th width="20%"> REGISTRO INVIMA:</th>
							<td width="46%">'.$fila['registro'].'</td>
						</tr>
						<tr>
							<th width="20%"> SERVICIO:</th>
							<td width="46%">'.$servicio.'</td>
						</tr>
					</table>
				';

			}
		}

		$sql3="SELECT * FROM relaciones WHERE (idPrincipal=\"$idEquipo\" AND modulo='equipos')";
		$query3=$con->query($sql3);
		$resultado3=$query3->fetch_all(MYSQLI_ASSOC);
		$num3=$query3->num_rows;

		if ($num3>=1) {
			$cuerpo .= '
					<h4><div style="text-align: center;">REGISTRO TECNICO DE INSTALACIÓN</div></h4>
					<div style="width: 100%; display: inline-block;">
						<table border="1" style="width: 100%;">
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
								<th style="width: 40%;"> VOLTAJE DE ALIMENTACIÓN [V]:</th>
								<td style="width: 60%;">MAX: '.json_decode($fila['valores'])->max.' MIN: '.json_decode($fila['valores'])->min.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'consumoDeCorriente':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> CONSUMO DE CORRIENTE [A]:</th>								
								<td style="width: 60%;">'.json_decode($fila['valores'])->max.' - '.json_decode($fila['valores'])->min.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'potenciaDisipada':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> POTENCIA DISCIPADA [W]:</th>								
								<td style="width: 60%;">'.json_decode($fila['valores'])->val1.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'frecuenciaElectrica':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> FRECUENCIA DE TRABAJO [Hz]:</th>								
								<td style="width: 60%;">'.json_decode($fila['valores'])->val1.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
					case 'velocidadFlujo':
						$cuerpo .='
							<tr>
								<th style="width: 40%;"> VELOCIDAD [RPM]:</th>								
								<td style="width: 60%;">'.json_decode($fila['valores'])->val1.' '.json_decode($fila['valores'])->unidad.'</td>
							</tr>
						';
						break;
				}
			}
			$cuerpo .= '
						</table>
					</div>
					<h4><div style="text-align: center;">REGISTRO TECNICO DE FUNCIONAMIENTO</div></h4>
					<div style="width: 100%; display: inline-block;">
						<table border="1" style="width: 100%;">
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
						</table>
					</div>
			';
		}

		$sql4="SELECT * FROM relaciones WHERE (idPrincipal=\"$id\" AND modulo='articulos' AND pestana='monitoreo')";
		$query4=$con->query($sql4);
		$resultado4=$query4->fetch_all(MYSQLI_ASSOC);
		$num4=$query4->num_rows;

		if ($num4>=1) {
			$cuerpo .= '
					<h4><div style="text-align: center;">CARACTERISTICAS DE MONITOREO EN EL PACIENTE</div></h4>
					<div style="width: 100%; display: inline-block;">
						<table border="1" style="width: 100%;">
			';
			$cuerpo .= '<tr>';
			foreach ($resultado4 as $fila) {				
				switch ($fila['nombre']) {
					case 'dioxidoCarbono':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">DC:</th>
								<td  style="width: 15%;">SI</td>
							';
						}
						break;
					case 'frecuenciaCardiaca':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">FC:</th>
								<td  style="width: 15%;">SI</td>
							';
						}
						break;
					case 'temperatura':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">T:</th>
								<td  style="width: 15%;">SI</td>
							';
						}
						break;
					case 'gasesAnestesicos':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">GA:</th>
								<td  style="width: 15%;">SI</td>
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
								<th style="width: 10%;">EC:</th>
								<td style="width: 15%;">SI</td>
							';
						}
						break;
					case 'presionNoInvasiva':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">PNI:</th>
								<td  style="width: 15%;">SI</td>
							';
						}
						break;
					case 'oximetriaPulso':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">OP:</th>
								<td  style="width: 15%;">SI</td>
							';
						}
						break;
					case 'gastoCardiaco':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">GC:</th>
								<td  style="width: 15%;">SI</td>
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
						}
						break;
					case 'glucosa':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">G:</th>
								<td  style="width: 15%;">SI</td>
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
						}
						break;
					case 'respiracion':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">R:</th>
								<td  style="width: 15%;">SI</td>
							';
						}
						break;
					case 'Electroencefalografia':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">EE:</th>
								<td  style="width: 15%;">SI</td>
							';
						}
						break;
					case 'ultrasonido':
						if ((json_decode($fila['valores'])->val1) === 'checked') {
							$cuerpo .= '
								<th style="width: 10%;">US:</th>
								<td  style="width: 15%;">SI</td>
							';
						}
						break;
				}
			}
			$cuerpo .= '
							</tr>
						</table>
					</div>
			';
		}

		// CONSULTA 3
		if ($num3>=1) {
			$cuerpo .= '
					<h4><div style="text-align: center;">VARIABLES METROLOGICAS</div></h4>
					<div style="width: 100%; display: inline-block;">
						<table border="1" style="width: 100%;">
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
							<td style="width: 33%;">'.$unidad.'</td>
						</tr>
					';
				}
			}
			$cuerpo .= '
						</table>
					</div>
			';
		}
		
		$html2pdf = new Html2Pdf();
		$html2pdf->writeHTML($cuerpo);
		$html2pdf->output('Guia_'.$id.'.pdf', 'D');
		// $html2pdf->output('Guia_'.$id.'.pdf');
	}
?>