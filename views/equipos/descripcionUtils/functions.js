$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevaDescripcion').click(nuevaDescripcion);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarDescripcion);
		$('.formEditarDescripcion').click(formEditarDescripcion);
	}

function nuevaDescripcion() {
	var nombre = $("#nombre").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'descripcion' : descripcion
	};

	$.ajax({
		url: '../../controllers/descripcionController.php',
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
			url: '../../controllers/descripcionController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarDescripcion);
				$('.formEditarDescripcion').click(formEditarDescripcion);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarDescripcion() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idDescripcion').val();
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
		url: '../../controllers/descripcionController.php',
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

function formEditarDescripcion() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idDescripcion').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/descripcionController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-descripcion').html('');
			$('.modal-descripcion').html(resultado);
			$('#editarDescripcion').click(editarDescripcion);
		}
	});
}

function editarDescripcion() {
	var id = $("#id").val();
	var nombre = $("#nombre").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'nombre' : nombre,
		'descripcion' : descripcion
	};

	$.ajax({
		url: '../../controllers/descripcionController.php',
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