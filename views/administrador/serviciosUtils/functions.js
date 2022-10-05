$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoServicio').click(nuevoServicio);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarServicio);
		$('.formEditarServicio').click(formEditarServicio);
	}

function nuevoServicio() {
 	var codigo = $("#codigo").val();
	var idGrupoServicio = $("#idGrupoServicio").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'ingresar',
		'codigo' : codigo,
		'idGrupoServicio' : idGrupoServicio,
		'descripcion' : descripcion
	};

	$.ajax({
		url: '../../controllers/serviciosController.php',
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
			url: '../../controllers/serviciosController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarServicio);
				$('.formEditarServicio').click(formEditarServicio);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarServicio() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idServicio').val();
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
		url: '../../controllers/serviciosController.php',
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

function formEditarServicio() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idServicio').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/serviciosController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-servicios').html('');
			$('.modal-servicios').html(resultado);
			$('#editarServicio').click(editarServicio);
		}
	});
}

function editarServicio() {
	var id = $("#id").val();
	var codigo = $("#codigo").val();
	var idGrupoServicio = $("#idGrupoServicio").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'codigo' : codigo,
		'idGrupoServicio' : idGrupoServicio,
		'descripcion' : descripcion
	};

	$.ajax({
		url: '../../controllers/serviciosController.php',
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