$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevaPregunta').click(nuevaPregunta);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarPregunta);
		$('.formEditarPregunta').click(formEditarPregunta);
	}

function nuevaPregunta() {
	var pregunta = $("#pregunta").val();
	var respuesta = $("#respuesta").val();

	var json = {
		'accion' : 'ingresar',
		'pregunta' : pregunta,
		'respuesta' : respuesta
	};

	$.ajax({
		url: '../../controllers/preguntasController.php',
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
			url: '../../controllers/preguntasController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarPregunta);
				$('.formEditarPregunta').click(formEditarPregunta);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarPregunta() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idPregunta').val();
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
		url: '../../controllers/preguntasController.php',
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

function formEditarPregunta() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idPregunta').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/preguntasController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-preguntas').html('');
			$('.modal-preguntas').html(resultado);
			$('#editarPregunta').click(editarPregunta);
		}
	});
}

function editarPregunta() {
	var id = $("#id").val();
	var pregunta = $("#pregunta").val();
	var respuesta = $("#respuesta").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'pregunta' : pregunta,
		'respuesta' : respuesta
	};

	$.ajax({
		url: '../../controllers/preguntasController.php',
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