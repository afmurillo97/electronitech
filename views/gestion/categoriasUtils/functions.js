$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevaCategoria').click(nuevaCategoria);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarCategoria);
		$('.formEditarCategoria').click(formEditarCategoria);
	}

function nuevaCategoria() {
	var nivel = $("#nivel").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'ingresar',
		'nivel' : nivel,
		'descripcion' : descripcion
	};

	$.ajax({
		url: '../../controllers/categoriasController.php',
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
			url: '../../controllers/categoriasController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarCategoria);
				$('.formEditarCategoria').click(formEditarCategoria);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarCategoria() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idCategoria').val();
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
		url: '../../controllers/categoriasController.php',
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

function formEditarCategoria() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idCategoria').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/categoriasController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-categorias').html('');
			$('.modal-categorias').html(resultado);
			$('#editarCategoria').click(editarCategoria);
		}
	});
}

function editarCategoria() {
	var id = $("#id").val();
	var nivel = $("#nivel").val();
	var descripcion = $("#descripcion").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'nivel' : nivel,
		'descripcion' : descripcion
	};

	$.ajax({
		url: '../../controllers/categoriasController.php',
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