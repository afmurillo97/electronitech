$(document).on('ready', iniciar);
	function iniciar(){
		$('#editarDatos').click(editarDatos);
	}

function editarDatos() {
	var idDatos = $("#idDatos").val();
	var ubicacion = $("#ubicacion").val();
	var email = $("#email").val();
	var telefono = $("#telefono").val();
	var mapa = $("#mapa").val();
	var facebook = $("#facebook").val();
	var instagram = $("#instagram").val();
	var whatsapp = $("#whatsapp").val();

	var json = {
		'accion' : 'editar',
		'idDatos' : idDatos,
		'ubicacion' : ubicacion,
		'email' : email,
		'telefono' : telefono,
		'mapa' : mapa,
		'facebook' : facebook,
		'instagram' : instagram,
		'whatsapp' : whatsapp,
	};

	$.ajax({
		url: "../../controllers/datosController.php",
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