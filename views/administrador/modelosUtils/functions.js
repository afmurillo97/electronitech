$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoModelo').click(nuevoModelo);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarModelo);
		$('.formEditarModelo').click(formEditarModelo);
	}

function nuevoModelo() {
 	var nombre = $("#nombre").val();
	var idMarca = $("#idMarca").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'idMarca' : idMarca,
		'descripcion' : descripcion
	};

	$.ajax({
		url: '../../controllers/modelosController.php',
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
			url: '../../controllers/modelosController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarModelo);
				$('.formEditarModelo').click(formEditarModelo);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarModelo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idModelo').val();
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
		url: '../../controllers/modelosController.php',
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

function formEditarModelo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idModelo').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/modelosController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-modelos').html('');
			$('.modal-modelos').html(resultado);
			$('#editarModelo').click(editarModelo);
		}
	});
}

function editarModelo() {
	var id = $("#id").val();
	var nombre = $("#nombre").val();
	var idMarca = $("#idMarca").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'nombre' : nombre,
		'idMarca' : idMarca,
		'descripcion' : descripcion
	};

	$.ajax({
		url: '../../controllers/modelosController.php',
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