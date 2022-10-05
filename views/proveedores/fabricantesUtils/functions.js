$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoFabricante').click(nuevoFabricante);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarFabricante);
		$('.formEditarFabricante').click(formEditarFabricante);
	}

function nuevoFabricante() {
	var nombre = $("#nombre").val();
	var celular = $("#celular").val();
	var direccion = $("#direccion").val();
	var ciudad = $("#ciudad").val();
	var email = $("#email").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'celular' : celular,
		'direccion' : direccion,
		'ciudad' : ciudad,
		'email' : email
	};

	$.ajax({
		url: '../../controllers/fabricantesController.php',
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
			url: '../../controllers/fabricantesController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarFabricante);
				$('.formEditarFabricante').click(formEditarFabricante);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarFabricante() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idFabricante').val();
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
		url: '../../controllers/fabricantesController.php',
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

function formEditarFabricante() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idFabricante').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/fabricantesController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-fabricantes').html('');
			$('.modal-fabricantes').html(resultado);
			$('#editarFabricante').click(editarFabricante);
		}
	});
}

function editarFabricante() {
	var id = $("#id").val();
	var nombre = $("#nombre").val();
	var celular = $("#celular").val();
	var direccion = $("#direccion").val();
	var ciudad = $("#ciudad").val();
	var email = $("#email").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'nombre' : nombre,
		'celular' : celular,
		'direccion' : direccion,
		'ciudad' : ciudad,
		'email' : email
	};

	$.ajax({
		url: '../../controllers/fabricantesController.php',
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