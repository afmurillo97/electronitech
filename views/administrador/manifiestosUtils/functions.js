$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoManifiesto').click(nuevoManifiesto);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarManifiesto);
		$('.formEditarManifiesto').click(formEditarManifiesto);
	}

function nuevoManifiesto() {
	var form_data = new FormData();
	form_data.append('accion', 'ingresar');
	form_data.append('nombre', $("#nombre").val());
	form_data.append('documento', $('#documento')[0].files[0]);
	form_data.append('descripcion', $("#descripcion").val());

	$.ajax({
		url: '../../controllers/manifiestosController.php',
		type: 'POST',
		data: form_data,
		contentType: false,
		processData: false,
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
			url: '../../controllers/manifiestosController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarManifiesto);
				$('.formEditarManifiesto').click(formEditarManifiesto);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarManifiesto() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idManifiesto').val();
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
		url: '../../controllers/manifiestosController.php',
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

function formEditarManifiesto() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idManifiesto').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/manifiestosController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-manifiestos').html('');
			$('.modal-manifiestos').html(resultado);
			$('#editarManifiesto').click(editarManifiesto);
		}
	});
}

function editarManifiesto() {
	var form_data = new FormData();
	form_data.append('accion', 'editar');
	form_data.append('id', $("#id").val());
	form_data.append('nombre', $("#nombre").val());
	form_data.append('documento', $('#documento')[0].files[0]);
	form_data.append('descripcion', $("#descripcion").val());

	$.ajax({
		url: '../../controllers/manifiestosController.php',
		type: 'POST',
		data: form_data,
		contentType: false,
		processData: false,
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