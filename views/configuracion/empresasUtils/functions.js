$(document).on('ready', iniciar);
	function iniciar(){
		$('#editarEmpresa').click(editarEmpresa);
	}

function editarEmpresa() {
	var idEmpresa = $("#idEmpresa").val();
	var nombre = $("#nombre").val();
	var nit = $("#nit").val();
	var direccion = $("#direccion").val();
	var telefono = $("#telefono").val();
	var email = $("#email").val();
	var resolucion = $("#resolucion").val();

	var json = {
		'accion' : 'editar',
		'idEmpresa' : idEmpresa,
		'nombre' : nombre,
		'nit' : nit,
		'direccion' : direccion,
		'telefono' : telefono,
		'email' : email,
		'resolucion' : resolucion
	};

	$.ajax({
		url: "../../controllers/empresasController.php",
		type: "POST",
		data: json,
		success: function(resultado) {
			if (resultado) {
				jQuery.noConflict();
				$('#modalEditSuccess').modal('show');
			}else{
				$('#modalDanger').modal('show');
			}
		}
	});
}