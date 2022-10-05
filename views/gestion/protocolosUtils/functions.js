$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoProtocolo').click(nuevoProtocolo);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarProtocolo);
		$('.formEditarProtocolo').click(formEditarProtocolo);
	}

function nuevoProtocolo() {
	var nombre = $("#nombre").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'descripcion' : descripcion
	};

	$.ajax({
		url: '../../controllers/protocolosController.php',
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
			url: '../../controllers/protocolosController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarProtocolo);
				$('.formEditarProtocolo').click(formEditarProtocolo);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarProtocolo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idProtocolo').val();
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
		url: '../../controllers/protocolosController.php',
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

function formEditarProtocolo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idProtocolo').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/protocolosController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-protocolos').html('');
			$('.modal-protocolos').html(resultado);
			$('#editarProtocolo').click(editarProtocolo);
		}
	});
}

function editarProtocolo() {
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
		url: '../../controllers/protocolosController.php',
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