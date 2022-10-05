$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevaRutina').click(nuevaRutina);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarRutina);
		$('.formEditarRutina').click(formEditarRutina);
	}

function nuevaRutina() {
	var idCategoria = $("#idCategoria").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'ingresar',
		'idCategoria' : idCategoria,
		'descripcion' : descripcion,
	};

	$.ajax({
		url: '../../controllers/rutinasController.php',
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
			url: '../../controllers/rutinasController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarRutina);
				$('.formEditarRutina').click(formEditarRutina);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarRutina() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idRutina').val();
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
		url: '../../controllers/rutinasController.php',
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

function formEditarRutina() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idRutina').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/rutinasController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-rutinas').html('');
			$('.modal-rutinas').html(resultado);
			$('#editarRutina').click(editarRutina);
		}
	});
}

function editarRutina() {
	var id = $("#id").val();
	var idCategoria = $("#idCategoria").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'idCategoria' : idCategoria,
		'descripcion' : descripcion,
	};

	$.ajax({
		url: '../../controllers/rutinasController.php',
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