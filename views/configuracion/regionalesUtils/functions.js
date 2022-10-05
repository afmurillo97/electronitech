$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoRegional').click(nuevoRegional);
		$('.formEditarRegional').click(formEditarRegional);
		$('.formEliminarRegional').click(formEliminarRegional);
	}

function nuevoRegional() {
	var nombre = $("#nombre").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'descripcion' : descripcion,
	};

	$.ajax({
		url: '../../controllers/regionalesController.php',
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

function formEditarRegional() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idRegional').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/regionalesController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-regionales').html('');
			$('.modal-regionales').html(resultado);
			$('#editarRegional').click(editarRegional);
		}
	});
}

function editarRegional() {
	var id = $("#id").val();
	var nombre = $("#nombre").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'nombre' : nombre,
		'descripcion' : descripcion,
	};

	$.ajax({
		url: '../../controllers/regionalesController.php',
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

function formEliminarRegional() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idRegional').val();
	$('.modal-delete').prepend('<input type="hidden" id="id" value="'+id+'">');
	$('#eliminarRegional').click(eliminarRegional);
}

function eliminarRegional() {
	var id = $("#id").val();

	var json = {
		'accion' : 'eliminar',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/regionalesController.php',
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