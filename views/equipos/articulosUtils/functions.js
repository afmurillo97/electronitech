$(document).on('ready', iniciar);
	function iniciar() {
		$('#idCliente').on('change', cargarDireccion);
		$('#direccion').on('change', cargarServicios);
		$('#idEquipo').on('change', cargarRegistros);
		$('#nuevoArticulo').click(nuevoArticulo);
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarArticulo);
		$('.formEditarArticulo').click(formEditarArticulo);
		$('.formEditarReporte').click(formEditarReporte);
		$('#aplicar').click(aplicar);
	}

function cargarDireccion() {
	var idCliente = $('#idCliente').val();

	var json = {
		'accion': 'getDireccion',
		'id': idCliente
	}

	$.ajax({
		url: '../../controllers/articulosController.php',
		type: 'POST',
		data: json,
		success: function(resultado){
			$('#direccion').html(resultado);
		}
	});
}

function cargarServicios() {
	var idCliente = $('#idCliente').val();
	var direccion = $('#direccion').val();

	var json = {
		'accion': 'getServicios',
		'idCliente': idCliente,
		'direccion': direccion
	}

	$.ajax({
		url: '../../controllers/articulosController.php',
		type: 'POST',
		data: json,
		success: function(resultado){
			$('#idServicio').html(resultado);
		}
	});
}

function cargarRegistros() {
	var idEquipo = $('#idEquipo').val();

	var json = {
		'accion': 'getRegistros',
		'idEquipo': idEquipo
	}

	$.ajax({
		url: '../../controllers/articulosController.php',
		type: 'POST',
		data: json,
		success: function(resultado){
			$('#idRegistro').html(resultado);
		}
	});
}

function arreglo(clase, pestana, tipo) {
	if (tipo == 1) {
		var data = {
			'nombre': clase,
			'pestana': pestana,
			'valores': {
				'val1': $('.'+clase+' #val1').val().length>0 ? $('.'+clase+' #val1').val() : 'NaN',
			}
		}
	}else if (tipo == 2) {
		var data = {
			'nombre': clase,
			'pestana': pestana,
			'valores': {
				'val1': $('.'+clase+' .val1').prop('checked') ? 'checked' : 0,
				
			}
		}
	}

	if($('.'+clase+' #idItem').length>0){
		data['id']=$('.'+clase+' #idItem').val();
	}

	return data;
}

function nuevoArticulo() {
	var form_data = new FormData();
	form_data.append('accion', 'ingresar');
	form_data.append('idCliente', $('#idCliente').val());
	form_data.append('direccion', $('#direccion').val());
	form_data.append('idServicio', $('#idServicio').val());
	form_data.append('serie', $('#serie').val());
	form_data.append('tipo', $('#tipo').val());
	form_data.append('inventario', $('#nInventario').val());
	form_data.append('idTipoEquipo', $('#idTipoEquipo').val());
	form_data.append('idEquipo', $('#idEquipo').val());
	form_data.append('idRegistro', $('#idRegistro').val());
	form_data.append('ubicacion', $('#ubicacion').val());
	form_data.append('codDoc', $('#codDoc').val());

	var items = [];
	// HISTORICO
	items.push(arreglo('formaAdquisicion', 'historico', 1));
	items.push(arreglo('documentoAdquisicion', 'historico', 1));
	items.push(arreglo('fechaAdquisicion', 'historico', 1));
	items.push(arreglo('costoSinIVA', 'historico', 1));
	items.push(arreglo('fechaEntrega', 'historico', 1));
	items.push(arreglo('numeroActa', 'historico', 1));
	items.push(arreglo('fechaInicio', 'historico', 1));
	items.push(arreglo('fechaVencimiento', 'historico', 1));
	items.push(arreglo('fechaFabricacion', 'historico', 1));
	items.push(arreglo('registroImportacion', 'historico', 1));
	items.push(arreglo('proveedor', 'historico', 1));
	items.push(arreglo('fabricante', 'historico', 1));
	// MONITOREO
	items.push(arreglo('dioxidoCarbono', 'monitoreo', 2));
	items.push(arreglo('frecuenciaCardiaca', 'monitoreo', 2));
	items.push(arreglo('temperatura', 'monitoreo', 2));
	items.push(arreglo('gasesAnestesicos', 'monitoreo', 2));
	items.push(arreglo('electroCardiografia', 'monitoreo', 2));
	items.push(arreglo('presionNoInvasiva', 'monitoreo', 2));
	items.push(arreglo('oximetriaPulso', 'monitoreo', 2));
	items.push(arreglo('gastoCardiaco', 'monitoreo', 2));
	items.push(arreglo('electroMiografia', 'monitoreo', 2));
	items.push(arreglo('presionInvasiva', 'monitoreo', 2));
	items.push(arreglo('indiceBispectral', 'monitoreo', 2));
	items.push(arreglo('glucosa', 'monitoreo', 2));
	items.push(arreglo('electroOculografia', 'monitoreo', 2));
	items.push(arreglo('respiracion', 'monitoreo', 2));
	items.push(arreglo('Electroencefalografia', 'monitoreo', 2));
	items.push(arreglo('ultrasonido', 'monitoreo', 2));
	// NOTAS
	items.push(arreglo('notas', 'notas', 1));

	form_data.append('items', JSON.stringify(items));

	$.ajax({
		url: '../../controllers/articulosController.php',
		type: 'POST',
		data: form_data,
		contentType: false,
		processData: false,
		success: function(resultado) {
			jQuery.noConflict();
			if (resultado) {
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
			url: '../../controllers/articulosController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarArticulo);
				$('.formEditarArticulo').click(formEditarArticulo);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarArticulo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idArticulo').val();
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
		url: '../../controllers/articulosController.php',
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

function formEditarArticulo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idArticulo').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/articulosController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-articulos').html('');
			$('.modal-articulos').html(resultado);
			$('#editarArticulo').click(editarArticulo);
		}
	});
}

function editarArticulo() {
	var form_data = new FormData();
	form_data.append('accion', 'editar');
	form_data.append('idArticulo', $('#idArticulo').val());
	form_data.append('idCliente', $('#idCliente').val());
	form_data.append('direccion', $('#direccion').val());
	form_data.append('idServicio', $('#idServicio').val());
	form_data.append('serie', $('#serie').val());
	form_data.append('tipo', $('#tipo').val());
	form_data.append('inventario', $('#nInventario').val());
	form_data.append('idTipoEquipo', $('#idTipoEquipo').val());
	form_data.append('idEquipo', $('#idEquipo').val());
	form_data.append('idRegistro', $('#idRegistro').val());
	form_data.append('ubicacion', $('#ubicacion').val());
	form_data.append('codDoc', $('#codDoc').val());

	var items = [];
	// HISTORICO
	items.push(arreglo('formaAdquisicion', 'historico', 1));
	items.push(arreglo('documentoAdquisicion', 'historico', 1));
	items.push(arreglo('fechaAdquisicion', 'historico', 1));
	items.push(arreglo('costoSinIVA', 'historico', 1));
	items.push(arreglo('fechaEntrega', 'historico', 1));
	items.push(arreglo('numeroActa', 'historico', 1));
	items.push(arreglo('fechaInicio', 'historico', 1));
	items.push(arreglo('fechaVencimiento', 'historico', 1));
	items.push(arreglo('fechaFabricacion', 'historico', 1));
	items.push(arreglo('registroImportacion', 'historico', 1));
	items.push(arreglo('proveedor', 'historico', 1));
	items.push(arreglo('fabricante', 'historico', 1));
	// MONITOREO
	items.push(arreglo('dioxidoCarbono', 'monitoreo', 2));
	items.push(arreglo('frecuenciaCardiaca', 'monitoreo', 2));
	items.push(arreglo('temperatura', 'monitoreo', 2));
	items.push(arreglo('gasesAnestesicos', 'monitoreo', 2));
	items.push(arreglo('electroCardiografia', 'monitoreo', 2));
	items.push(arreglo('presionNoInvasiva', 'monitoreo', 2));
	items.push(arreglo('oximetriaPulso', 'monitoreo', 2));
	items.push(arreglo('gastoCardiaco', 'monitoreo', 2));
	items.push(arreglo('electroMiografia', 'monitoreo', 2));
	items.push(arreglo('presionInvasiva', 'monitoreo', 2));
	items.push(arreglo('indiceBispectral', 'monitoreo', 2));
	items.push(arreglo('glucosa', 'monitoreo', 2));
	items.push(arreglo('electroOculografia', 'monitoreo', 2));
	items.push(arreglo('respiracion', 'monitoreo', 2));
	items.push(arreglo('Electroencefalografia', 'monitoreo', 2));
	items.push(arreglo('ultrasonido', 'monitoreo', 2));
	// NOTAS
	items.push(arreglo('notas', 'notas', 1));

	form_data.append('items', JSON.stringify(items));

	$.ajax({
		url: '../../controllers/articulosController.php',
		type: 'POST',
		data: form_data,
		contentType: false,
		processData: false,
		success: function(resultado) {
			jQuery.noConflict();
			if (resultado) {
				$('#modalEditSuccess').modal('show');

				setTimeout(() => {
					location.reload();
				}, 1050);
			}else{
				$('#modalDanger').modal('show');
			}
			console.log(resultado);
		}
	});
}

function aplicar() {
	var form_data = new FormData();
	form_data.append('accion', 'aplicar');
	form_data.append('idCliente', $('#idCliente').val());
	form_data.append('direccion', $('#direccion').val());
	form_data.append('idServicio', $('#idServicio').val());
	form_data.append('serie', $('#serie').val());
	form_data.append('tipo', $('#tipo').val());
	form_data.append('inventario', $('#nInventario').val());
	form_data.append('idTipoEquipo', $('#idTipoEquipo').val());
	form_data.append('idEquipo', $('#idEquipo').val());
	form_data.append('idRegistro', $('#idRegistro').val());
	form_data.append('ubicacion', $('#ubicacion').val());
	form_data.append('codDoc', $('#codDoc').val());

	var items = [];
	// HISTORICO
	items.push(arreglo('formaAdquisicion', 'historico', 1));
	items.push(arreglo('documentoAdquisicion', 'historico', 1));
	items.push(arreglo('fechaAdquisicion', 'historico', 1));
	items.push(arreglo('costoSinIVA', 'historico', 1));
	items.push(arreglo('fechaEntrega', 'historico', 1));
	items.push(arreglo('numeroActa', 'historico', 1));
	items.push(arreglo('fechaInicio', 'historico', 1));
	items.push(arreglo('fechaVencimiento', 'historico', 1));
	items.push(arreglo('fechaFabricacion', 'historico', 1));
	items.push(arreglo('registroImportacion', 'historico', 1));
	items.push(arreglo('proveedor', 'historico', 1));
	items.push(arreglo('fabricante', 'historico', 1));
	// MONITOREO
	items.push(arreglo('dioxidoCarbono', 'monitoreo', 2));
	items.push(arreglo('frecuenciaCardiaca', 'monitoreo', 2));
	items.push(arreglo('temperatura', 'monitoreo', 2));
	items.push(arreglo('gasesAnestesicos', 'monitoreo', 2));
	items.push(arreglo('electroCardiografia', 'monitoreo', 2));
	items.push(arreglo('presionNoInvasiva', 'monitoreo', 2));
	items.push(arreglo('oximetriaPulso', 'monitoreo', 2));
	items.push(arreglo('gastoCardiaco', 'monitoreo', 2));
	items.push(arreglo('electroMiografia', 'monitoreo', 2));
	items.push(arreglo('presionInvasiva', 'monitoreo', 2));
	items.push(arreglo('indiceBispectral', 'monitoreo', 2));
	items.push(arreglo('glucosa', 'monitoreo', 2));
	items.push(arreglo('electroOculografia', 'monitoreo', 2));
	items.push(arreglo('respiracion', 'monitoreo', 2));
	items.push(arreglo('Electroencefalografia', 'monitoreo', 2));
	items.push(arreglo('ultrasonido', 'monitoreo', 2));
	// NOTAS
	items.push(arreglo('notas', 'notas', 1));

	form_data.append('items', JSON.stringify(items));

	$.ajax({
		url: '../../controllers/articulosController.php',
		type: 'POST',
		data: form_data,
		contentType: false,
		processData: false,
		success: function(resultado) {}
	});
}

function formEditarReporte() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idArticulo').val();

	var json = {
		'accion' : 'form-reporte',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/reportesController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-reportes').html(resultado);
			$('.servicioPor').on('change', servicioPor);
			$('.tipoServicio').on('change', tipoServicio);
			$('#guardarReporte').click(guardarReporte);
			$('#editarReporte').click(editarReporte);			
		}
	});
}

function servicioPor() {
	if ($('.servicioPor').val() == 'OTRO') {
		$('.serviciPorTR').append('<td><input type="text" class="form-control form-control-sm descripcion" placeholder="Ejemplo: Otro"></td>');
	}
}
	
function tipoServicio() {
	if ($('.tipoServicio').val() == 'OTRO') {
		$('.tipoServicioTR').append('<td><input type="text" class="form-control form-control-sm descripcion" placeholder="Ejemplo: Otro"></td>');
	}
}

function guardarReporte() {
	var idArticulo = $(".idArticulo").val();
	var contacto = $(".contacto").val();
	var fechaServicio = $(".fechaServicio").val();
	var servicioPor = ($('.servicioPor').val()=='OTRO') ? $('.serviciPorTR .descripcion').val() : $('.servicioPor').val();
	var tipoServicio = ($('.tipoServicio').val()=='OTRO') ? $('.tipoServicioTR .descripcion').val() : $('.tipoServicio').val();
	var observacionesGenerales = $(".observacionesGenerales").val();

	var json = {
		'accion' : 'nuevoReporte',
		'idArticulo' : idArticulo,
		'contacto' : contacto,
		'fechaServicio' : fechaServicio,
		'servicioPor' : servicioPor,
		'tipoServicio' : tipoServicio,
		'inspeccionInicial' : JSON.stringify(arregloReporte('inspeccionInicial', 4)),
		'sistemaElectrico' : JSON.stringify(arregloReporte('sistemaElectrico', 3)),
		'sistemaElectronico' : JSON.stringify(arregloReporte('sistemaElectronico', 5)),
		'sistemaMecanico' : JSON.stringify(arregloReporte('sistemaMecanico', 3)),
		'sistemaNeumatico' : JSON.stringify(arregloReporte('sistemaNeumatico', 4)),
		'sistemaVentilacion' : JSON.stringify(arregloReporte('sistemaVentilacion', 3)),
		'inspeccionFinal' : JSON.stringify(arregloReporte('inspeccionFinal', 3)),
		'observaciones' :  observacionesGenerales
	};

	$.ajax({
		url: '../../controllers/reportesController.php',
		type: 'POST',
		data: json,
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

function arregloReporte(clase, cantidad) {
	var data = [];

	for (let i = 1; i<=cantidad; i++) {		
		var item = {
			'item': i,
			'valores': {
				'estado': $('.'+clase+'-item_'+i+' .estado').val(),
				'observacion': $('.'+clase+'-item_'+i+' .observacion').val(),
			}
		}
		data.push(item);
	}

	return data;
}

function editarReporte() {
	var idReporte = $(".idReporte").val();
	var contacto = $(".contacto").val();
	var fechaServicio = $(".fechaServicio").val();
	var servicioPor = ($('.servicioPor').val()=='OTRO') ? $('.serviciPorTR .descripcion').val() : $('.servicioPor').val();
	var tipoServicio = ($('.tipoServicio').val()=='OTRO') ? $('.tipoServicioTR .descripcion').val() : $('.tipoServicio').val();
	var observacionesGenerales = $(".observacionesGenerales").val();

	var json = {
		'accion' : 'editarReporte',
		'id' : idReporte,
		'contacto' : contacto,
		'fechaServicio' : fechaServicio,
		'servicioPor' : servicioPor,
		'tipoServicio' : tipoServicio,
		'inspeccionInicial' : JSON.stringify(arregloReporte('inspeccionInicial', 4)),
		'sistemaElectrico' : JSON.stringify(arregloReporte('sistemaElectrico', 3)),
		'sistemaElectronico' : JSON.stringify(arregloReporte('sistemaElectronico', 5)),
		'sistemaMecanico' : JSON.stringify(arregloReporte('sistemaMecanico', 3)),
		'sistemaNeumatico' : JSON.stringify(arregloReporte('sistemaNeumatico', 4)),
		'sistemaVentilacion' : JSON.stringify(arregloReporte('sistemaVentilacion', 3)),
		'inspeccionFinal' : JSON.stringify(arregloReporte('inspeccionFinal', 3)),
		'observaciones' :  observacionesGenerales
	};

	$.ajax({
		url: '../../controllers/reportesController.php',
		type: 'POST',
		data: json,
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