$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoGrupoServicio').click(nuevoGrupoServicio);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarGrupoServicio);
		$('.formEditarGrupoServicio').click(formEditarGrupoServicio);
	}

function nuevoGrupoServicio() {
	var nombre = $("#nombre").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'descripcion' : descripcion
	};

	$.ajax({
		url: '../../controllers/grupoServicioController.php',
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
			url: '../../controllers/grupoServicioController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarGrupoServicio);
				$('.formEditarGrupoServicio').click(formEditarGrupoServicio);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarGrupoServicio() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idGrupoServicio').val();
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
		url: '../../controllers/grupoServicioController.php',
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

function formEditarGrupoServicio() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idGrupoServicio').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/grupoServicioController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-grupoServicio').html('');
			$('.modal-grupoServicio').html(resultado);
			$('#editarGrupoServicio').click(editarGrupoServicio);
		}
	});
}

function editarGrupoServicio() {
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
		url: '../../controllers/grupoServicioController.php',
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