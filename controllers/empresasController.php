<?php
	try{
		function getEmpresas() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM empresas');
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
					$sql=$con->prepare('INSERT INTO empresas (nombre, nit, direccion, telefono, email, resolucion) VALUES (:P1,:P2,:P3,:P4,:P5,:P6)');
					$resultado=$sql->execute(array('P1'=>$_POST['nombre'], 'P2'=>$_POST['nit'], 'P3'=>$_POST['direccion'], 'P4'=>$_POST['telefono'], 'P5'=>$_POST['email'], 'P6'=>$_POST['resolucion']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				
				case 'editar':
					$sql=$con->prepare('UPDATE empresas SET nombre=:P2, nit=:P3, direccion=:P4, telefono=:P5, email=:P6, resolucion=:P7 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['idEmpresa'], 'P2'=>$_POST['nombre'], 'P3'=>$_POST['nit'], 'P4'=>$_POST['direccion'], 'P5'=>$_POST['telefono'], 'P6'=>$_POST['email'], 'P7'=>$_POST['resolucion']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;

				case 'eliminar':
					$sql=$conn->prepare('UPDATE empresas SET fechaEliminacion=NOW() WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['id']));
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