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

	$sql="SELECT articulosView.*, descripcionBiomedica.nombre AS descripcionBiomedica, clientes.logo AS logo FROM articulosView INNER JOIN clientes ON clientes.id=articulosView.idCliente INNER JOIN descripcionBiomedica ON descripcionBiomedica.id=articulosView.idDescripcionBiomedica WHERE (articulosView.id=\"$id\")";
	$query=$con->query($sql);
	$resultado=$query->fetch_all(MYSQLI_ASSOC);
	$num=$query->num_rows;

	if ($num>=1) {
		foreach ($resultado as $fila) {
			$idEquipo=$fila['idEquipo'];
			$marca=$fila['marca'];
			$modelo=$fila['modelo'];
			$serie= (!empty($fila['serie'])) ? $fila['serie'] : 'NR';
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
			$logo = (!empty($fila['logo'])) ? $fila['logo'] : '127.0.0.1/electronitech/assets/images/logosClientes/electronitech.jpg';
			$logoCliente = explode('electronitech/', $logo);
			$fechaCreacion = $fila['fechaCreacion'];

			$cuerpo = '
				<!-- ENCABEZADO 1 PAG -->
				<table border="1" style="width: 100%;  page-break-before: always;">
					<tr>	
						<td rowspan="3" style="width: 30%;"> <img src="../../../'.$logoCliente[1].'" alt="" width="220" height="120"> </td>
						<td rowspan="2" style="width: 45%;"><h4 style="text-align: center;">'.$cliente.'</h4></td>
						<td style="width: 25%;"><strong>CÓDIGO:</strong> '.$codDoc.'</td>
					</tr>
					<tr>
						<td><strong>VERSIÓN:</strong> 1.0.0</td>
					</tr>
					<tr>
						<td><h4 style="text-align: center;">HOJA DE VIDA DE EQUIPO MEDICO</h4></td>
						<td><strong>FECHA:</strong>'.$fechaCreacion.'</td>
					</tr>
				</table><br>';
				
			$cuerpo .='
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

				$rs = $pc = $nr = '____';
				switch ($tipoRegistro) {
					case 'REGISTRO SANITARIO':
						$rs = '&nbsp;&nbsp;X&nbsp;&nbsp;';
						break;
					case 'PERMISO COMERCIALIZACION':
						$pc = '&nbsp;&nbsp;X&nbsp;&nbsp;';
						break;
					default:
						$nr = '&nbsp;&nbsp;X&nbsp;&nbsp;';
						break;
				}

			$cuerpo .= '
				<!-- SECCION EQUIPO BIOMEDICO 1 PAG -->
				<table cellspacing="10" style="width: 100%; border: 4px double black;">
					<tr>
						<th colspan="3" style="text-align: center; font-size: 16px;">EQUIPO BIOMEDICO</th>
					</tr>
					<tr>
						<th style="width: 25%;">NOMBRE:</th>
						<td style="width: 35%;">'.$tipoEquipo.'</td>
						<td rowspan="11" style="width: 38%;" align="center"> <img src="../../../'.$urlFotoEquipo[1].'" alt="" width="160" height="300"> </td>
					</tr>
					<tr>
						<th width="25%"> MARCA:</th>
						<td width="35%">'.$marca.'</td>
					</tr>
					<tr>
						<th width="25%"> MODELO:</th>
						<td width="35%">'.$modelo.'</td>
					</tr>
					<tr>
						<th width="25%"> SERIE (S/N):</th>
						<td width="35%">'.$serie.'</td>
					</tr>
					<tr>
						<th width="25%"> CÓDIGO ECRI:</th>
						<td width="35%">'.$codigoEcri.'</td>
					</tr>
					<tr>
						<th width="25%"> No. INVENTARIO:</th>
						<td width="35%">'.$inventario.'</td>
					</tr>
					<tr>
						<th width="25%"> REGISTRO INVIMA:</th>
						<td width="35%">RS:'.$rs.'PC:'.$pc.'NR:'.$nr.'</td>
					</tr>
					<tr>
						<th width="25%"> No. REGISTRO:</th>
						<td width="35%">'.$registro.'</td>
					</tr>
					<tr>
						<th width="25%"> CONDICION:</th>
						<td width="35%">_________________________________</td>
					</tr>
			
					<tr>
						<th width="25%"> CLASIFICACION DE RIESGO:</th>
						<td width="35%" style="background-color: '.$colorRiesgo.'; text-align: center; "> '.$riesgo.' </td>
					</tr>
					<tr>
						<th width="25%"> CLASIFICACION BIOMEDICA:</th>
						<td width="35%">'.$descripcionBiomedica.'</td>
					</tr>
					<tr>
						<th width="25%"> SERVICIO:</th>
						<td colspan="2" width="75%">'.$servicio.'</td>
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
						$costoSinIVA=(json_decode($fila['valores'])->val1 === 'NaN') ? 0 : json_decode($fila['valores'])->val1;
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
					<th  style="width: auto;">PROVEEDOR:</th>
					<td colspan="3" style="width: auto;">'.$proveedor['nombre'].'</td>
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
			foreach ($resultado3 as $fila) {
				switch ($fila['nombre']) {
					case 'fuenteAlimentacion':
						$fuenteAlimentacion = json_decode($fila['valores'])->val1;
						break;
					case 'tecnologiaDominante':
						$tecnologiaDominante = json_decode($fila['valores'])->val1;
						break;
					case 'voltajeDeAlimentacion':
						$voltajeDeAlimentacionUnidad = json_decode($fila['valores'])->unidad;
						$voltajeDeAlimentacionMax = json_decode($fila['valores'])->max;
						$voltajeDeAlimentacionMin = json_decode($fila['valores'])->min;
						break;
					case 'consumoDeCorriente':
						$consumoDeCorrienteUnidad = json_decode($fila['valores'])->unidad;
						$consumoDeCorrienteMax = json_decode($fila['valores'])->max;
						$consumoDeCorrienteMin = json_decode($fila['valores'])->min;
						break;
					case 'temperaturaOperativa':
						$temperaturaOperativaUnidad = json_decode($fila['valores'])->unidad;
						$temperaturaOperativaMax = json_decode($fila['valores'])->max;
						$temperaturaOperativaMin = json_decode($fila['valores'])->min;
						break;
					case 'potenciaDisipada':
						$potenciaDisipada = json_decode($fila['valores'])->val1;
						$potenciaDisipadaUnidad = json_decode($fila['valores'])->unidad;
						break;
					case 'frecuenciaElectrica':
						$frecuenciaDeTrabajo = json_decode($fila['valores'])->val1;
						$frecuenciaDeTrabajoUnidad = json_decode($fila['valores'])->unidad;
						break;
					case 'velocidadFlujo':
						$velocidadFlujo = json_decode($fila['valores'])->val1;
						$velocidadFlujoUnidad = json_decode($fila['valores'])->unidad;
						break;
				}
			}

			$cuerpo .= '
				<!-- ENCABEZADO 2 PAG -->
				<div style="page-break-before: always;">
					<table border="1" style="width: 100%;">
						<tr>	
							<td rowspan="3" style="width: 30%;"> <img src="../../../'.$logoCliente[1].'" alt="" width="220" height="120"> </td>
							<td rowspan="2" style="width: 45%;"><h4 style="text-align: center;">'.$cliente.'</h4></td>
							<td style="width: 25%;"><strong>CÓDIGO:</strong> '.$codDoc.'</td>
						</tr>
						<tr>
							<td><strong>VERSIÓN:</strong> 1.0.0</td>
						</tr>
						<tr>
							<td><h4 style="text-align: center;">HOJA DE VIDA DE EQUIPO MEDICO</h4></td>
							<td><strong>FECHA:</strong>'.$fechaCreacion.'</td>
						</tr>
					</table>
				</div>
				<br>
				';
			$cuerpo .= '
				<!-- REGISTRO TECNICO DE INSTALACION 2 PAG -->
				<table cellspacing="10" style="width: 100%; border: 4px double black;">
					<tr>
						<th colspan="2" style="text-align: center; font-size: 16px;">REGISTRO TECNICO DE INSTALACION</th>
					</tr>
					<tr>
						<th style="width: 40%;"> FUENTE DE ALIMENTACIÓN:</th>
						<td style="width: 60%;">'.$fuenteAlimentacion.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> TECNOLOGIA PREDOMINANTE:</th>
						<td style="width: 60%;">'.$tecnologiaDominante.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> VOLTAJE DE ALIMENTACIÓN ['.$voltajeDeAlimentacionUnidad.']:</th>
						<td style="width: 60%;">MAX: '.$voltajeDeAlimentacionMax.' MIN: '.$voltajeDeAlimentacionMin.' '.$voltajeDeAlimentacionUnidad.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> CONSUMO DE CORRIENTE ['.$consumoDeCorrienteUnidad.']:</th>								
						<td style="width: 60%;">MAX: '.$consumoDeCorrienteMax.' MIN: '.$consumoDeCorrienteMin.' '.$consumoDeCorrienteUnidad.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> TEMPERATURA OPERATIVA['.$temperaturaOperativaUnidad.']:</th>								
						<td style="width: 60%;">MAX: '.$temperaturaOperativaMax.' MIN: '.$temperaturaOperativaMin.' '.$temperaturaOperativaUnidad.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> POTENCIA DISCIPADA ['.$potenciaDisipadaUnidad.']:</th>								
						<td style="width: 60%;">'.$potenciaDisipada.' '.$potenciaDisipadaUnidad.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> FRECUENCIA DE TRABAJO ['.$frecuenciaDeTrabajoUnidad.']:</th>								
						<td style="width: 60%;">'.$frecuenciaDeTrabajo.' '.$frecuenciaDeTrabajoUnidad.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> VELOCIDAD ['.$velocidadFlujoUnidad.']:</th>								
						<td style="width: 60%;">'.$velocidadFlujo.' '.$velocidadFlujoUnidad.'</td>
					</tr>
				</table><br>
			';

			foreach ($resultado3 as $fila) {
				switch ($fila['nombre']) {
					case 'controlPresion':
						$controlPresionUnidad = json_decode($fila['valores'])->unidad;
						$controlPresionMax = json_decode($fila['valores'])->max;
						$controlPresionMin = json_decode($fila['valores'])->min;
						break;
					case 'controlTemperatura':
						$controlTemperaturaUnidad = json_decode($fila['valores'])->unidad;
						$controlTemperaturaMax = json_decode($fila['valores'])->max;
						$controlTemperaturaMin = json_decode($fila['valores'])->min;
						break;
					case 'controlEnergia':
						$controlEnergiaUnidad = json_decode($fila['valores'])->unidad;
						$controlEnergiaMax = json_decode($fila['valores'])->max;
						$controlEnergiaMin = json_decode($fila['valores'])->min;
						break;
					case 'pesoSoportado':
						$pesoSoportadoUnidad = json_decode($fila['valores'])->unidad;
						$pesoSoportadoMax = json_decode($fila['valores'])->max;
						$pesoSoportadoMin = json_decode($fila['valores'])->min;
						break;
					case 'controlVelocidad':
						$controlVelocidadUnidad = json_decode($fila['valores'])->unidad;
						$controlVelocidadMax = json_decode($fila['valores'])->max;
						$controlVelocidadMin = json_decode($fila['valores'])->min;
						break;
					case 'potenciaIrradiada':
						$potenciaIrradiadaUnidad = json_decode($fila['valores'])->unidad;
						$potenciaIrradiadaMax = json_decode($fila['valores'])->max;
						$potenciaIrradiadaMin = json_decode($fila['valores'])->min;
						break;
				}
			}
			$cuerpo .= '
				<!-- REGISTRO TECNICO DE FUNCIONAMIENTO 2 PAG -->
				<table cellspacing="10" style="width: 100%; border: 4px double black;">
					<tr>
						<th colspan="2" style="text-align: center; font-size: 16px;">REGISTRO TECNICO DE FUNCIONAMIENTO</th>
					</tr>
					<tr>
						<th style="width: 40%;"> PRESION:</th>
						<td style="width: 60%;">'.$controlPresionMax.' - '.$controlPresionMin.' '.$controlPresionUnidad.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> TEMPERATURA:</th>
						<td style="width: 60%;">MAX: '.$controlTemperaturaMax.' MIN: '.$controlTemperaturaMin.' '.$controlTemperaturaUnidad.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> ENERGIA:</th>
						<td style="width: 60%;">MAX: '.$controlEnergiaMax.' MIN: '.$controlEnergiaMin.' '.$controlEnergiaUnidad.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> PESO:</th>
						<td style="width: 60%;">MAX: '.$pesoSoportadoMax.' MIN: '.$pesoSoportadoMin.' '.$pesoSoportadoUnidad.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> VELOCIDAD:</th>								
						<td style="width: 60%;">MAX: '.$controlVelocidadMax.' MIN: '.$controlVelocidadMin.' '.$controlVelocidadUnidad.'</td>
					</tr>
					<tr>
						<th style="width: 40%;"> POTENCIA RADIADA:</th>
						<td style="width: 60%;">MAX: '.$potenciaIrradiadaMax.' MIN: '.$potenciaIrradiadaMin.' '.$potenciaIrradiadaUnidad.'</td>
					</tr>
				</table><br>
			';
		}

		$sql4="SELECT * FROM relaciones WHERE (idPrincipal=\"$id\" AND modulo='articulos' AND pestana='monitoreo')";
		$query4=$con->query($sql4);
		$resultado4=$query4->fetch_all(MYSQLI_ASSOC);
		$num4=$query4->num_rows;

		if ($num4>=1) {
			foreach ($resultado4 as $fila) {
				switch ($fila['nombre']) {
					case 'dioxidoCarbono':
						$dioxidoCarbono = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'frecuenciaCardiaca':
						$frecuenciaCardiaca = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'temperatura':
						$temperatura = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'gasesAnestesicos':
						$gasesAnestesicos = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
				}				
			}	

			foreach ($resultado4 as $fila) {
				switch ($fila['nombre']) {
					case 'electroCardiografia':						
						$electroCardiografia = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'presionNoInvasiva':
						$presionNoInvasiva = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'oximetriaPulso':
						$oximetriaPulso = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'gastoCardiaco':
						$gastoCardiaco = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
				}
			}
			foreach ($resultado4 as $fila) {
				switch ($fila['nombre']) {
					case 'electroMiografia':						
						$electroMiografia = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'presionInvasiva':
						$presionInvasiva = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'indiceBispectral':
						$indiceBispectral = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'glucosa':
						$glucosa = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
				}
			}
			foreach ($resultado4 as $fila) {
				switch ($fila['nombre']) {
					case 'electroOculografia':						
						$electroOculografia = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'respiracion':
						$respiracion = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'Electroencefalografia':
						$Electroencefalografia = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
					case 'ultrasonido':
						$ultrasonido = ((json_decode($fila['valores'])->val1) === 'checked') ? 'SI' : 'NA';
						break;
				}
			}
		$cuerpo .= '
			<div style="width: 100%; display: inline-block;">
				<!-- CARACTERISTICAS DE MONITOREO EN EL PACIENTE 2 PAG -->
				<table cellspacing="10" style="width: 100%; border: 4px double black;">
					<tr>
						<th colspan="8" style="text-align: center; font-size: 16px;">CARACTERISTICAS DE MONITOREO EN EL PACIENTE</th>
					</tr>
					<tr>
						<th style="width: 10%;">CO<sub>2</sub>:</th>
						<td  style="width: 15%;">'.$dioxidoCarbono.'</td>
						<th style="width: 10%;">FC:</th>
						<td  style="width: 15%;">'.$frecuenciaCardiaca.'</td>
						<th style="width: 10%;">TEMP:</th>
						<td  style="width: 15%;">'.$temperatura.'</td>
						<th style="width: 10%;">GA:</th>
						<td  style="width: 15%;">'.$gasesAnestesicos.'</td>
					</tr>
			
					<tr>
						<th style="width: 10%;">ECF:</th>
						<td style="width: 15%;">'.$electroCardiografia.'</td>
						<th style="width: 10%;">PNI:</th>
						<td  style="width: 15%;">'.$presionNoInvasiva.'</td>
						<th style="width: 10%;">SPO<sub>2</sub>:</th>
						<td  style="width: 15%;">'.$oximetriaPulso.'</td>
						<th style="width: 10%;">GC:</th>
						<td  style="width: 15%;">'.$gastoCardiaco.'</td>
					</tr>

					<tr>
						<th style="width: 10%;">EM:</th>
						<td  style="width: 15%;">'.$electroMiografia.'</td>
						<th style="width: 10%;">PI:</th>
						<td  style="width: 15%;">'.$presionInvasiva.'</td>
						<th style="width: 10%;">IB:</th>
						<td  style="width: 15%;">'.$indiceBispectral.'</td>
						<th style="width: 10%;">GLC:</th>
						<td  style="width: 15%;">'.$glucosa.'</td>
					</tr>
					<tr>
						<th style="width: 10%;">EO:</th>
						<td  style="width: 15%;">'.$electroOculografia.'</td>
						<th style="width: 10%;">RES:</th>
						<td  style="width: 15%;">'.$respiracion.'</td>
						<th style="width: 10%;">EEG:</th>
						<td  style="width: 15%;">'.$Electroencefalografia.'</td>
						<th style="width: 10%;">US:</th>
						<td  style="width: 15%;">'.$ultrasonido.'</td>
					</tr>
				</table>
			</div><br>
			';
		}

		// CONSULTA 3
		if ($num3>=1) {
			foreach ($resultado3 as $fila) {
				if ($fila['pestana']==='variables') {
					$unidad = (json_decode($fila['valores'])->val3==='porcentaje') ? '%' : 'N';
					$variables = getVariables($con, json_decode($fila['valores'])->val1);
					$exactitud = json_decode($fila['valores'])->val2;
				} else if ($fila['pestana']==='accesorios') {
					$descripcion=json_decode($fila['valores'])->val1;
					$marcaRef=json_decode($fila['valores'])->val2;
				}
			}
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
					<tr>
						<td style="width: 33%;">'.$variables.'</td>
						<td style="width: 33%;">(+|-) '.$exactitud.' '.$unidad.'</td>
						<td style="width: 34%;">'.$unidad.'</td>
					</tr>
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
				</table>

				<span style="bottom: 5px;">NR*: No Registra. NA*: No Aplica.</span>

				
			</div>
			';
		}

		$html2pdf = new Html2Pdf();
		$html2pdf->writeHTML($cuerpo);
		// $html2pdf->output('Guia_'.$id.'.pdf', 'D');
		$html2pdf->output('GUIA_'.$marca.'_'.$modelo.'_'.$serie.'.pdf');

	}
?>