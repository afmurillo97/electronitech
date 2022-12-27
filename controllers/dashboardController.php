<?php
	try{
		@session_start();
		include_once 'permisosPlataforma.php';

		function totalActivos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT COUNT(*) FROM cronogramaview WHERE fechaEliminacion IS NULL');
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

		function getCronogramas($inicio, $fin) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM cronogramaview WHERE fechaEliminacion IS NULL LIMIT :P1,:P2');
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

		require 'conexion.php';

		if(isset($_POST['accion'])) {
			switch ($_POST['accion']) {
				case 'ingresar':					
					for ($i=0; $i<count($_POST['articulos']); $i++) { 
						$sql=$con->prepare('INSERT INTO cronograma (idCliente, direccion, idArticulo, idUsuario, fechaInicial, fechaFinal, frecuencia) VALUES (:P1,:P2,:P3,:P4,:P5,:P6,:P7)');
						$resultado=$sql->execute(array('P1'=>$_POST['idCliente'], 'P2'=>$_POST['direccion'], 'P3'=>$_POST['articulos'][$i], 'P4'=>$_SESSION['idUsuario'], 'P5'=>$_POST['fechaInicial'], 'P6'=>$_POST['fechaFinal'], 'P7'=>$_POST['frecuencia']));
						$num=$sql->rowCount();
					}
					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				
				case 'cargarDireccion':
					$sql=$con->prepare('SELECT * FROM clientes WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
					$resultado=$sql->fetchAll();
					$num=$sql->rowCount();

					if ($num>=1) {
						echo '
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Dirección</label>
								<div class="col-sm-9">
									<select class="form-control form-control-sm" id="direccion">
						';
						foreach ($resultado as $fila) {
							$cantidad=count(json_decode($fila['direccion']));
							$direccion = json_decode($fila['direccion']);

							for ($i=0; $i<$cantidad; $i++) {
								$direccionGuion=str_replace("@", " - ", $direccion[$i]);

								echo '<option value="'.$direccion[$i].'">'.$direccionGuion.'</option>';
							}							
						}
						echo '
									</select>
								</div>
							</div>
						';
					}
					break;
				case 'cargarArticulos':		
						$sql=$con->prepare('SELECT * FROM articulosView WHERE idCliente = :P1 AND direccion = :P2');
						$resultado=$sql->execute(array('P1'=>$_POST['idCliente'], 'P2'=>$_POST['direccion']));
						$resultado=$sql->fetchAll();
						$num=$sql->rowCount();
			
						if ($num>=1) {
							echo '
								<table class="table">
									<tr>
										<th><input type="checkbox" class="selTodo"></th>
										<th>Tipo Equipo</th>
										<th>Marca / Modelo</th>
										<th>Serie</th>
										<th>Riesgo</th>
									<tr>
							';
							foreach ($resultado as $fila) {
								echo '
									<tr>
										<input type="hidden" id="idArticulo">
										<td><input type="checkbox" name="articulos" value="'.$fila['id'].'"></td>
										<td>'.$fila['tipoEquipo'].'</td>
										<td>'.$fila['marca'].' / '.$fila['modelo'].'</td>
										<td>'.$fila['serie'].'</td>
										<td>'.$fila['riesgo'].'</td>
									</tr>
								';
							}
							echo '
								</table>
							';
						}else{
							return NULL;
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