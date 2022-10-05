$(document).on('ready', iniciar);
	function iniciar(){
		$('#nuevoUsuario').click(nuevoUsuario);
		$('#entrada').on('keyup', buscar);
		$('.formEditarUsuario').click(formEditarUsuario);
		$('.formEliminarUsuario').click(formEliminarUsuario);
		$('.formEditarPermisos').click(formEditarPermisos);
	}

	function nuevoUsuario() {
		var form_data = new FormData();
		form_data.append('accion', 'ingresar');
		form_data.append('nombres', $("#nombres").val());
		form_data.append('apellidos', $("#apellidos").val());
		form_data.append('identificacion', $("#identificacion").val());
		form_data.append('username', $("#username").val());
		form_data.append('password', $("#password").val());
		form_data.append('email', $("#email").val());
		form_data.append('cargo', $("#cargo").val());
		form_data.append('celular', $("#celular").val());
		form_data.append('firma', $('#firmaDigital')[0].files[0]);

		$.ajax({
			url: '../../controllers/usuariosController.php',
			type: 'POST',
			data: form_data,
			contentType: false,
            processData: false,
			success: function(resultado) {
				if (resultado) {
					console.log(resultado)
				
					jQuery.noConflict();
					$('#modalCreateSuccess').modal('show');
	
					setTimeout(() => {
						// location.reload();					
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
			url: '../../controllers/usuariosController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.formEditarUsuario').click(formEditarUsuario);
				$('.formEliminarUsuario').click(formEliminarUsuario);
				$('.formEditarPermisos').click(formEditarPermisos);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function formEditarUsuario() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idUsuario').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/usuariosController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-usuarios').html('');
			$('.modal-usuarios').html(resultado);
			$('#editarUsuario').click(editarUsuario);
		}
	});
}

function editarUsuario() {

	var form_data = new FormData();
	form_data.append('accion', 'editar');
	form_data.append('id', $("#id").val());
	form_data.append('nombres', $("#nombres").val());
	form_data.append('apellidos', $("#apellidos").val());
	form_data.append('identificacion', $("#identificacion").val());
	form_data.append('username', $("#username").val());
	form_data.append('password', $("#password").val());
	form_data.append('email', $("#email").val());
	form_data.append('cargo', $("#cargo").val());
	form_data.append('celular', $("#celular").val());
	form_data.append('firma', $('#firmaDigital')[0].files[0]);

	$.ajax({
		url: '../../controllers/usuariosController.php',
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

function formEliminarUsuario() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idUsuario').val();
	$('.modal-delete').prepend('<input type="hidden" id="id" value="'+id+'">');
	$('#eliminarUsuario').click(eliminarUsuario);
}

function eliminarUsuario() {
	var id = $("#id").val();

	var json = {
		'accion' : 'eliminar',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/usuariosController.php',
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

function formEditarPermisos() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idUsuario').val();

	var json = {
		'accion' : 'permisos',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/usuariosController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-usuarios').html('');
			$('.modal-usuarios').html(resultado);
			$('#editarPermiso').click(editarPermiso);
		}
	});
}

function editarPermiso() {
	var contenedor = $('.permisos').length;
	var form = [];

	for(var i=1; i<=contenedor; i++){
		var data = {
			'idPermiso': $('.filasResultado'+i).find('input[id=idPermiso]').val(),
			'idUsuario': $('.filasResultado'+i).find('input[id=idUsuario]').val(),
			'check': $('.filasResultado'+i).find('input[type=checkbox]').prop('checked') ? 1 : 0,
		}
		form.push(data);
	}

	var json = {
		'accion' : 'permisos-usuarios',
		'formulario' : form
	};

	$.ajax({
		url: '../../controllers/usuariosController.php',
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