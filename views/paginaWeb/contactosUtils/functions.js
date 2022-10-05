$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoTipoEquipo').click(nuevoTipoEquipo);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarTipoEquipo);
		$('.formEditarTipoEquipo').click(formEditarTipoEquipo);
	}

function nuevoTipoEquipo() {
 	var nombre = $("#nombre").val();
	var riesgo = $("#riesgo").val();
	var idDescripcionBiomedica = $("#idDescripcionBiomedica").val();
	var idProtocolo = $("#idProtocolo").val();
	var validacion = $("#validacion").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'riesgo' : riesgo,
		'idDescripcionBiomedica' : idDescripcionBiomedica,
		'idProtocolo' : idProtocolo,
		'validacion' : validacion
	};

	$.ajax({
		url: '../../controllers/tipoEquipoController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			if (resultado) {
				jQuery.noConflict();
				$('#modalCreateSuccess').modal('show');

				setTimeout(() => {
					location.reload();					
				}, 1050);
			}else{
				$('#modalDanger').modal('show');
			}
		}
	});
}

function buscar(){
	if ($('#entrada').val().length>0) {
		$.ajax({
			url: '../../controllers/tipoEquipoController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarTipoEquipo);
				$('.formEditarTipoEquipo').click(formEditarTipoEquipo);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarTipoEquipo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idTipoEquipo').val();
	var checkbox = fila.parents('.custom-switch').find('.checkbox').prop('checked');

	if (checkbox) {
		var checkbox = 1;
	}else{
		var checkbox = 0;
	}

	var json = {
		'accion' : 'habilitar',
		'id' : id,
		'habilitado' : checkbox
	};

	$.ajax({
		url: '../../controllers/tipoEquipoController.php',
		type: 'POST',
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

function formEditarTipoEquipo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idTipoEquipo').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/tipoEquipoController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-tipoEquipo').html('');
			$('.modal-tipoEquipo').html(resultado);
			$('#editarTipoEquipo').click(editarTipoEquipo);
		}
	});
}

function editarTipoEquipo() {
	var id = $("#id").val();
	var nombre = $("#nombre").val();
	var riesgo = $("#riesgo").val();
	var idDescripcionBiomedica = $("#idDescripcionBiomedica").val();
	var idProtocolo = $("#idProtocolo").val();
	var validacion = $("#validacion").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'nombre' : nombre,
		'riesgo' : riesgo,
		'idDescripcionBiomedica' : idDescripcionBiomedica,
		'idProtocolo' : idProtocolo,
		'validacion' : validacion
	};

	$.ajax({
		url: '../../controllers/tipoEquipoController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			if (resultado) {
				jQuery.noConflict();
				$('#modalEditSuccess').modal('show');

				setTimeout(() => {
					location.reload();
				}, 1050);
			}else{
				$('#modalDanger').modal('show');
			}
		}
	});
}