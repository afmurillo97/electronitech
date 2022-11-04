$(document).on('ready', iniciar);
	function iniciar(){
		$('.nuevaDireccion').click(nuevaDireccion);
		$('#nuevoCliente').click(nuevoCliente);
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarCliente);
		$('.formEditarCliente').click(formEditarCliente);
		$('.asignarServicio').click(asignarServicio);		
	}

function nuevaDireccion() {
	var numeroReal = $('.nuevaDireccion').data('numero');
	numero = numeroReal+1;
	$('.nuevaDireccion').data('numero', numero);

	var html = '<div class="form-row"><div class="form-group col-sm-6"><label for="">&nbsp;</label><input type="text" class="form-control col-sm-12" id="direccion_'+numero+'" placeholder="Dirección"></div><div class="form-group col-sm-5"><label for="">&nbsp;</label><input type="text" class="form-control col-sm-12" id="ciudad_'+numero+'" placeholder="Ciudad"></div><div class="form-group col-sm-1"><button type="button" class="btn btn-danger eliminarFila" id="'+numeroReal+'">x</button></div></div>';
	$('.direcciones .form-inline').append(html);
	$('.eliminarFila').click(eliminarFila);
}

function eliminarFila() {
	var arreglo =$('.arreglo').val();
	let posicion = this.id;

	var json = {
		'accion' : 'alterar-direccion',
		'arreglo' : arreglo,
		'posicion' : posicion
	};
	
	$.ajax({
		url: '../../controllers/clientesController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.direcciones .form-inline').html('');
			$('.direcciones .form-inline').html(resultado);
			$('.nuevaDireccion').click(nuevaDireccion);
			$('.eliminarFila').click(eliminarFila);
		}
	});
}

function nuevoCliente() {
	var contenedor = $('.direcciones .form-inline .form-row').length;
	var direccion = [];
	
	for(var i=1; i<=contenedor; i++){
		direccion.push($('#direccion_'+i).val()+'@'+$('#ciudad_'+i).val());
	}

	var form_data = new FormData();
	form_data.append('accion', 'ingresar');
	form_data.append('nombre', $("#nombre").val());
	form_data.append('nit', $("#nit").val());
	form_data.append('codigo', $("#codigo").val());
	form_data.append('juridica', $("#juridica").val());
	form_data.append('representante', $("#representante").val());	
	form_data.append('telefono', $("#telefono").val());
	form_data.append('celular', $("#celular").val());
	form_data.append('direccion', JSON.stringify(direccion));
	form_data.append('email', $("#email").val().toLowerCase());
	form_data.append('observacion', $("#observacion").val());
	form_data.append('logo', $('#logo')[0].files[0]);
	form_data.append('encabezado', $("#encabezado").val());
	
	$.ajax({
		url: '../../controllers/clientesController.php',
		type: 'POST',
		data: form_data,
		contentType: false,
		processData: false,
		success: function(resultado) {
			jQuery.noConflict();

			if (resultado==1) {
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
			url: '../../controllers/clientesController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarCliente);
				$('.formEditarCliente').click(formEditarCliente);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarCliente() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idCliente').val();
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
		url: '../../controllers/clientesController.php',
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

function formEditarCliente() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idCliente').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/clientesController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-clientes').html('');
			$('.modal-clientes').html(resultado);
			$('#editarCliente').click(editarCliente);
			$('.nuevaDireccion').click(nuevaDireccion);
			$('.eliminarFila').click(eliminarFila);
		}
	});
}

function editarCliente() {
	var contenedor = $('.direcciones .form-inline .form-row').length;
	var direccion = [];

	for(var i=1; i<=contenedor; i++){
		direccion.push($('#direccion_'+i).val()+'@'+$('#ciudad_'+i).val());
	}

	var form_data = new FormData();
	form_data.append('accion', 'editar');
	form_data.append('id', $("#id").val());
	form_data.append('nombre', $("#nombre").val());
	form_data.append('nit', $("#nit").val());
	form_data.append('codigo', $("#codigo").val());
	form_data.append('juridica', $("#juridica").val());
	form_data.append('representante', $("#representante").val());	
	form_data.append('telefono', $("#telefono").val());
	form_data.append('celular', $("#celular").val());
	form_data.append('direccion', JSON.stringify(direccion));
	form_data.append('email', $("#email").val());
	form_data.append('observacion', $("#observacion").val());
	form_data.append('logo', $('#logo')[0].files[0]);
	form_data.append('encabezado', $("#encabezado").val());

	$.ajax({
		url: '../../controllers/clientesController.php',
		type: 'POST',
		data: form_data,
		contentType: false,
		processData: false,
		success: function(resultado) {
			jQuery.noConflict();

			if (resultado==1) {
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

function asignarServicio() {
	var json = {
		'accion' : 'asignarServicio'
	};

	$.ajax({
		url: '../../controllers/clientesController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-clientes').html('');
			$('.modal-clientes').html(resultado);
			$('#idCliente').on('change', cargarDireccion);
			$('#nuevoAsignarServicio').click(nuevoAsignarServicio);
		}
	});
}

function cargarDireccion() {
	var json = {
		'accion' : 'cargarDireccion',
		'id' : $('#idCliente').val()
	};

	$.ajax({
		url: '../../controllers/clientesController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('#direccion').html('');
			$('#direccion').html(resultado);
		}
	});	
}

function nuevoAsignarServicio() {
	var json = {
		'accion' : 'nuevoAsignarServicio',
		'idCliente' : $('#idCliente').val(),
		'direccion' : $('#direccion').val(),
		'servicio' : $('#servicio').val(),
		'codigo' : $('#codigo').val()
	};

	$.ajax({
		url: '../../controllers/clientesController.php',
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