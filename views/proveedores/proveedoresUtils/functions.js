$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoProveedor').click(nuevoProveedor);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarProveedor);
		$('.formEditarProveedor').click(formEditarProveedor);
	}

function nuevoProveedor() {
	var nombre = $("#nombre").val();
	var nit = $("#nit").val();
	var representante = $("#representante").val();
	var direccion = $("#direccion").val();
	var celular = $("#celular").val();
	var email = $("#email").val();
	var ciudad = $("#ciudad").val();
	var regimen = $("#regimen").val();

	var json = {
		'accion' : 'ingresar',
		'nombre' : nombre,
		'nit' : nit,
		'representante' : representante,
		'direccion' : direccion,
		'celular' : celular,
		'email' : email,
		'ciudad' : ciudad,
		'regimen' : regimen
	};

	$.ajax({
		url: '../../controllers/proveedoresController.php',
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
			url: '../../controllers/proveedoresController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarProveedor);
				$('.formEditarProveedor').click(formEditarProveedor);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarProveedor() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idProveedor').val();
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
		url: '../../controllers/proveedoresController.php',
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

function formEditarProveedor() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idProveedor').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/proveedoresController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-proveedores').html('');
			$('.modal-proveedores').html(resultado);
			$('#editarProveedor').click(editarProveedor);
		}
	});
}

function editarProveedor() {
	var id = $("#id").val();
	var nombre = $("#nombre").val();
	var nit = $("#nit").val();
	var representante = $("#representante").val();
	var direccion = $("#direccion").val();
	var celular = $("#celular").val();
	var email = $("#email").val();
	var ciudad = $("#ciudad").val();
	var regimen = $("#regimen").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'nombre' : nombre,
		'nit' : nit,
		'representante' : representante,
		'direccion' : direccion,
		'celular' : celular,
		'email' : email,
		'ciudad' : ciudad,
		'regimen' : regimen
	};

	$.ajax({
		url: '../../controllers/proveedoresController.php',
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