$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevaVariable').click(nuevaVariable);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarVariable);
		$('.formEditarVariable').click(formEditarVariable);
	}

function nuevaVariable() {
 	var nombre = $("#nombre").val();
	var unidadTexto = $("#unidadTexto").val();
	var unidadSigno = $("#unidadSigno").val();
	var idTipoVariable = $("#idTipoVariable").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'unidadTexto' : unidadTexto,
		'unidadSigno' : unidadSigno,
		'idTipoVariable' : idTipoVariable
	};

	$.ajax({
		url: '../../controllers/variablesController.php',
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
			url: '../../controllers/variablesController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarVariable);
				$('.formEditarVariable').click(formEditarVariable);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarVariable() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idVariable').val();
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
		url: '../../controllers/variablesController.php',
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

function formEditarVariable() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idVariable').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/variablesController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-variables').html('');
			$('.modal-variables').html(resultado);
			$('#editarVariable').click(editarVariable);
		}
	});
}

function editarVariable() {
	var id = $("#id").val();
	var nombre = $("#nombre").val();
	var unidadTexto = $("#unidadTexto").val();
	var unidadSigno = $("#unidadSigno").val();
	var idTipoVariable = $("#idTipoVariable").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'nombre' : nombre,
		'unidadTexto' : unidadTexto,
		'unidadSigno' : unidadSigno,
		'idTipoVariable' : idTipoVariable,
	};

	$.ajax({
		url: '../../controllers/variablesController.php',
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