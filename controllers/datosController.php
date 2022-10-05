<?php
	try{
		function getDatos() {
			require 'conexion.php';

			$sql=$con->prepare('SELECT * FROM datos');
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
					$sql=$con->prepare('INSERT INTO datos (ubicacion, email, telefono, mapa, facebook, instagram, whatsapp) VALUES (:P1,:P2,:P3,:P4,:P5,:P6,:P7)');
					$resultado=$sql->execute(array('P1'=>$_POST['ubicacion'], 'P2'=>$_POST['email'], 'P3'=>$_POST['telefono'], 'P4'=>$_POST['mapa'], 'P5'=>$_POST['facebook'], 'P6'=>$_POST['instagram'], 'P7'=>$_POST['whatsapp']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;
				
				case 'editar':
					$sql=$con->prepare('UPDATE datos SET ubicacion=:P2, email=:P3, telefono=:P4, mapa=:P5, facebook=:P6, instagram=:P7, whatsapp=:P8 WHERE id=:P1');
					$resultado=$sql->execute(array('P1'=>$_POST['idDatos'], 'P2'=>$_POST['ubicacion'], 'P3'=>$_POST['email'], 'P4'=>$_POST['telefono'], 'P5'=>$_POST['mapa'], 'P6'=>$_POST['facebook'], 'P7'=>$_POST['instagram'], 'P8'=>$_POST['whatsapp']));
					$num=$sql->rowCount();

					if ($num>=1) {
						echo TRUE;
					}else{
						echo FALSE;
					}
					break;

				case 'eliminar':
					$sql=$conn->prepare('UPDATE datos SET fechaEliminacion=NOW() WHERE id=:P1');
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