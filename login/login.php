<?php
	if(!empty($_POST)){
		if(isset($_POST['username']) && isset($_POST['password'])) {
			if($_POST['username']!='' && $_POST["password"]!='') {

				include "conexion.php";

				$username = $_POST['username'];
				$passwordLimpia = $_POST['password'];
				
				$password = base64_encode($passwordLimpia);

				$sql = "select * from usuarios where (username=\"$username\") and password=\"$password\" AND fechaEliminacion IS NULL";
				$query = $con->query($sql);

				while ($row = $query->fetch_array()) {
					$idUsuario = $row['id'];
					$nombre = $row['nombres'];
					$apellido = $row['apellidos'];
					$username = $row['username'];
					break;
				}
				if($idUsuario==null){
					print "<script>alert('Acceso Invalido'); window.location='../index.php';</script>";
				}else{
					session_start();
					$_SESSION['idUsuario'] = $idUsuario;
					$_SESSION['nombre'] = $nombre;
					$_SESSION['apellido'] = $apellido;
					$_SESSION['username'] = $username;
					
					print "<script>window.location='../views/dashboard/index.php';</script>";
				}
			}
		}
	}
?>