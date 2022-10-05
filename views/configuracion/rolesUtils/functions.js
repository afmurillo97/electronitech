$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoRol').click(nuevoRol);
		$('.formEditarRol').click(formEditarRol);
		$('.formEliminarRol').click(formEliminarRol);
	}

function nuevoRol() {
	var nombre = $("#nombre").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'descripcion' : descripcion,
	};

	$.ajax({
		url: '../../controllers/rolesController.php',
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

function formEditarRol() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idRol').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/rolesController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-roles').html('');
			$('.modal-roles').html(resultado);
			$('#editarRol').click(editarRol);
		}
	});
}

function editarRol() {
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
		url: '../../controllers/rolesController.php',
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

function formEliminarRol() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idRol').val();
	$('.modal-delete').prepend('<input type="hidden" id="id" value="'+id+'">');
	$('#eliminarRol').click(eliminarRol);
}

function eliminarRol() {
	var id = $("#id").val();

	var json = {
		'accion' : 'eliminar',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/rolesController.php',
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