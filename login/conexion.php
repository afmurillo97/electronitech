<?php
	// HOST, USUARIO, CONTRASEÑA, DDBB
	$con = new mysqli('localhost', 'root', '', 'electronitech');

	// function recoge_para_consulta($db, $var, $var2 = '') {
	// 	$var = (isset($_POST[$var])) ? trim(strip_tags($_POST[$var])) : $var2;
	// 	if (get_magic_quotes_gpc()) {
	// 		$var = stripslashes($var);
	// 	}
	// 	if (!is_numeric($var)) {
	// 		$var = mysqli_real_escape_string($db, $var);
	// 	}
	// 	return $var;
	// }
?>