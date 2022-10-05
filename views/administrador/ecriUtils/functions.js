$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevaEcri').click(nuevaEcri);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarEcri);
		$('.formEditarEcri').click(formEditarEcri);
	}

function nuevaEcri() {
	var nombre = $("#nombre").val();
	var codigo = $("#codigo").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'codigo' : codigo
	};

	$.ajax({
		url: '../../controllers/ecriController.php',
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
			url: '../../controllers/ecriController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarEcri);
				$('.formEditarEcri').click(formEditarEcri);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarEcri() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idEcri').val();
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
		url: '../../controllers/ecriController.php',
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

function formEditarEcri() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idEcri').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/ecriController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-ecri').html('');
			$('.modal-ecri').html(resultado);
			$('#editarEcri').click(editarEcri);
		}
	});
}

function editarEcri() {
	var id = $("#id").val();
	var nombre = $("#nombre").val();
	var codigo = $("#codigo").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'nombre' : nombre,
		'codigo' : codigo
	};

	$.ajax({
		url: '../../controllers/ecriController.php',
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