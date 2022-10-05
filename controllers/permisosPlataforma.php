<?php
	try{
		function permisosItem($idUsuario, $permiso) {
			require 'conexion.php';

			$sql=$con->prepare('SELECT habilitado FROM permisos_usuarios INNER JOIN permisos ON permisos.id=permisos_usuarios.idPermiso WHERE idUsuario = :P1 AND nombre = :P2');
			$resultado=$sql->execute(array('P1'=>$idUsuario, 'P2'=>$permiso));
			$resultado=$sql->fetchAll();
			$num=$sql->rowCount();

			if ($num>=1) {
				foreach ($resultado as $fila) {
					if ($fila['habilitado']!=1) {
						return 'hidden';
					}
				}
			}else{
				return 'hidden';
			}
			$con=null;
		}
	}catch(PDOException $error){
		echo "ERROR: ".$error->getMessage();
		exit();
	}
?>