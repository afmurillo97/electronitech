$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoPermiso').click(nuevoPermiso);
		$('#entrada').on('keyup', buscar);
		$('.formEditarPermiso').click(formEditarPermiso);
		$('.formEliminarPermiso').click(formEliminarPermiso);
	}

function nuevoPermiso() {
	var nombre = $("#nombre").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'descripcion' : descripcion,
	};

	$.ajax({
		url: '../../controllers/permisosController.php',
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
	if ($('#entrada').val().length>0 || $('#entrada').val() == '') {
		$.ajax({
			url: '../../controllers/permisosController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.formEditarPermiso').click(formEditarPermiso);
				$('.formEliminarPermiso').click(formEliminarPermiso);
			}
		 });
	}
	// 	$('#resultado').html('');
	// }
}

function formEditarPermiso() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idPermiso').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/permisosController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-permisos').html('');
			$('.modal-permisos').html(resultado);
			$('#editarPermiso').click(editarPermiso);
		}
	});
}

function editarPermiso() {
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
		url: '../../controllers/permisosController.php',
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

function formEliminarPermiso() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idPermiso').val();
	$('.modal-delete').prepend('<input type="hidden" id="id" value="'+id+'">');
	$('#eliminarPermiso').click(eliminarPermiso);
}

function eliminarPermiso() {
	var id = $("#id").val();

	var json = {
		'accion' : 'eliminar',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/permisosController.php',
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