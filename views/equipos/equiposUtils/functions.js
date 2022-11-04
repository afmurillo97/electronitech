$(document).on('ready', iniciar);
	function iniciar(){
		$('#idMarca').on('change', cargarModelo);
		$('.nuevaInstalacion').click(nuevaInstalacion);
		$('.nuevoFuncionamiento').click(nuevoFuncionamiento);
		$('.nuevoInvima').click(nuevoInvima);
		$('.nuevoProveedor').click(nuevoProveedor);
		$('.nuevoFabricante').click(nuevoFabricante);
		$('.nuevaVariable').click(nuevaVariable);		
		$('.nuevoAccesorio').click(nuevoAccesorio);
		$('#nuevoEquipo').click(nuevoEquipo);
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarEquipo);
		$('.formEditarEquipo').click(formEditarEquipo);
	}

function cargarModelo() {
	var idMarca = $('#idMarca').val();

	var json = {
		'accion': 'getModelo',
		'idMarca': idMarca
	}

	$.ajax({
		url: '../../controllers/equiposController.php',
		type: 'POST',
		data: json,
		success: function(resultado){
			$('#idModelo').html(resultado);
		}
	});
}

function nuevaInstalacion() {
	var numero = $('.nuevaInstalacion').data('instalacion');
	numero = numero+1;
	$('.nuevaInstalacion').data('instalacion', numero);

	var html = '<tr class="nuevoItemInstalacion nuevoItemInstalacion_'+numero+'"><td><input type="text" class="form-control form-control-sm nombre"></td><td>MAX</td><td><input type="text" class="form-control form-control-sm max"></td><td>MIN</td><td><input type="text" class="form-control form-control-sm min"></td><td>Unidad</td><td><input type="text" class="form-control form-control-sm unidad"></td><td><button type="button" onclick="eliminarFila(\'nuevaInstalacion\', \'instalacion\')" class="btn btn-sm btn-danger"><span class="mdi mdi-close"></span></button></td></tr>';
	$('#instalacion table').append(html);
}

function nuevoFuncionamiento() {
	var numero = $('.nuevoFuncionamiento').data('funcionamiento');
	numero = numero+1;
	$('.nuevoFuncionamiento').data('funcionamiento', numero);

	var html = '<tr class="nuevoItemFuncionamiento nuevoItemFuncionamiento_'+numero+'"><td><input type="text" class="form-control form-control-sm nombre"></td><td><input type="number" class="form-control form-control-sm max"></td><td><input type="number" class="form-control form-control-sm min"></td><td><input type="text" class="form-control form-control-sm unidad"></td><td><button type="button" onclick="eliminarFila(\'nuevoFuncionamiento\', \'funcionamiento\')" class="btn btn-sm btn-danger"><span class="mdi mdi-close"></span></button></td></tr>'
	$('#funcionamiento table').append(html);
}

function nuevoInvima() {
	var numero = $('.nuevoInvima').data('invima');
	numero = numero+1;
	$('.nuevoInvima').data('invima', numero);

	var json = {
		'accion': 'getInvima',
		'numero': numero
	}

	$.ajax({
		url: '../../controllers/equiposController.php',
		type: 'POST',
		data: json,
		success: function(resultado){
			$('.nuevoItemInvima_'+(numero-1)).after(resultado);
		}
	});
}

function nuevoProveedor() {
	var numero = $('.nuevoProveedor').data('prove');
	numero = numero+1;
	$('.nuevoProveedor').data('prove', numero);

	var json = {
		'accion': 'getProveedores',
		'numero': numero
	}

	$.ajax({
		url: '../../controllers/equiposController.php',
		type: 'POST',
		data: json,
		success: function(resultado){
			$('.nuevoItemProveedor_'+(numero-1)).after(resultado);
		}
	});	
}

function nuevoFabricante() {
	var numero = $('.nuevoFabricante').data('fabricante');
	numero = numero+1;
	$('.nuevoFabricante').data('fabricante', numero);

	var json = {
		'accion': 'getFabricantes',
		'numero': numero
	}

	$.ajax({
		url: '../../controllers/equiposController.php',
		type: 'POST',
		data: json,
		success: function(resultado){
			$('.nuevoItemFabricante_'+(numero-1)).after(resultado);
		}
	});
}

function nuevaVariable() {
	var numero = $('.nuevaVariable').data('variable');
	numero = numero+1;
	$('.nuevaVariable').data('variable', numero);

	var json = {
		'accion': 'getVariables',
		'numero': numero
	}

	$.ajax({
		url: '../../controllers/equiposController.php',
		type: 'POST',
		data: json,
		success: function(resultado){
			$('.nuevoItemVariable_'+(numero-1)).after(resultado);
		}
	});
}

function nuevoAccesorio() {
	var numero = $('.nuevoAccesorio').data('accesorio');
	numero = numero+1;
	$('.nuevoAccesorio').data('accesorio', numero);

	var html = '<tr class="nuevoItemAccesorio nuevoItemAccesorio_'+numero+'""><td><input type="text" class="form-control form-control-sm" id="descripcion"></td><td><input type="text" class="form-control form-control-sm" id="referencia"></td><td><button type="button" onclick="eliminarFila(\'nuevoAccesorio\', \'accesorio\')" class="btn btn-sm btn-danger"><span class="mdi mdi-close"></span></button></td></tr>';
	$('.nuevoItemAccesorio_'+(numero-1)).after(html);
}

function eliminarFila(clase, data) {
	var numero = $('.'+clase).data(data);
	numero = numero-1;
	$('.'+clase).data(data, numero);
	
	var fila = $(event.target);
	fila.parents('tr').remove();
}

function arreglo(clase, pestana, tipo) {
	if (tipo==1) {
		// ITEM CON VALORES MAX Y MIN
		var data = {
			'nombre': clase,
			'pestana': pestana,
			'valores': {
				'max': $('.'+clase+' .max').val().length>0 ? $('.'+clase+' .max').val() : 'NaN',
				'min': $('.'+clase+' .min').val().length>0 ? $('.'+clase+' .min').val() : 'NaN',
				'unidad': $('.'+clase+' .unidad').val().length>0 ? $('.'+clase+' .unidad').val() : 'NaN'
			}
		}		
	}else if (tipo==2) {
		// ITEM CON UNIDAD
		var data = {
			'nombre': clase,
			'pestana': pestana,
			'valores': {
				'val1': $('.'+clase+' .val1').val().length>0 ? $('.'+clase+' .val1').val() : 'NaN',
				'unidad': $('.'+clase+' .unidad').val().length>0 ? $('.'+clase+' .unidad').val() : 'NaN'
			}
		}
	}else if (tipo==3) {
		// ITEM NUEVO
		var data = {
			'nombre': $('.'+clase+' .nombre').val().length>0 ? $('.'+clase+' .nombre').val() : 'NaN',
			'pestana': pestana,
			'valores': {
				'max': $('.'+clase+' .max').val().length>0 ? $('.'+clase+' .max').val() : 'NaN',
				'min': $('.'+clase+' .min').val().length>0 ? $('.'+clase+' .min').val() : 'NaN',
				'unidad': $('.'+clase+' .unidad').val().length>0 ? $('.'+clase+' .unidad').val() : 'NaN'
			}
		}
	}else if (tipo==4) {
		// INVIMA, PROVEEDOR, FABRICANTE
		var data = {
			'nombre': pestana,
			'pestana': pestana,
			'valores': {
				'val1': $('.'+clase+' #val1').val().length>0 ? $('.'+clase+' #val1').val() : 'NaN',
			}
		}
	}else if (tipo==5) {
		// VARIABLES
		var data = {
			'nombre': pestana,
			'pestana': pestana,
			'valores': {
				'val1': $('.'+clase+' #idVariable').val().length>0 ? $('.'+clase+' #idVariable').val() : 'NaN',
				'val2': $('.'+clase+' #presicion').val().length>0 ? $('.'+clase+' #presicion').val() : 'NaN',
				'val3': $('.'+clase+' #unidad').val().length>0 ? $('.'+clase+' #unidad').val() : 'NaN'
			}
		}
	}else if (tipo==6) {
		// ACCESORIOS
		var data = {
			'nombre': pestana,
			'pestana': pestana,
			'valores': {
				'val1': $('.'+clase+' #descripcion').val().length>0 ? $('.'+clase+' #descripcion').val() : 'NaN',
				'val2': $('.'+clase+' #referencia').val().length>0 ? $('.'+clase+' #referencia').val() : 'NaN'
			}
		}
	}else if (tipo==7) {
		// INSTALACIÓN
		var data = {
			'nombre': clase,
			'pestana': pestana,
			'valores': {
				'val1': $('.'+clase+' #val1').val().length>0 ? $('.'+clase+' #val1').val() : 'NaN'
			}
		}
	}

	if($('.'+clase+' #idItem').length>0){
		data['id']=$('.'+clase+' #idItem').val();
	}

	return data;
}

function nuevoEquipo() {
	var form_data = new FormData();
	form_data.append('accion', 'ingresar');
	form_data.append('idMarca', $('#idMarca').val());
	form_data.append('idModelo', $('#idModelo').val());
	form_data.append('idRegistro', $('#idRegistro').val());
	form_data.append('vidaUtil', $('#vidaUtil').val());
	form_data.append('foto', $('#foto')[0].files[0]);
	
	var items = [];
	// INSTALACIÓN
	items.push(arreglo('fuenteAlimentacion', 'instalacion', 7));
	items.push(arreglo('tecnologiaDominante', 'instalacion', 7));
	items.push(arreglo('voltajeDeAlimentacion', 'instalacion', 1));
	items.push(arreglo('consumoDeCorriente', 'instalacion', 1));
	items.push(arreglo('potenciaDisipada', 'instalacion', 2));
	items.push(arreglo('frecuenciaElectrica', 'instalacion', 2));
	items.push(arreglo('pesoEquipo', 'instalacion', 2));
	items.push(arreglo('presionAmbiente', 'instalacion', 2));
	items.push(arreglo('temperaturaOperativa', 'instalacion', 1));
	items.push(arreglo('velocidadFlujo', 'instalacion', 2));
	// FUNCIONAMIENTO
	items.push(arreglo('voltajeGenerado', 'funcionamiento', 1));
	items.push(arreglo('corrienteFuga', 'funcionamiento', 1));
	items.push(arreglo('potenciaIrradiada', 'funcionamiento', 1));
	items.push(arreglo('frecuenciaOperacion', 'funcionamiento', 1));
	items.push(arreglo('controlPresion', 'funcionamiento', 1));
	items.push(arreglo('controlVelocidad', 'funcionamiento', 1));
	items.push(arreglo('pesoSoportado', 'funcionamiento', 1));
	items.push(arreglo('controlTemperatura', 'funcionamiento', 1));
	items.push(arreglo('controlHumedad', 'funcionamiento', 1));
	items.push(arreglo('controlEnergia', 'funcionamiento', 1));

	var contInstalacion = $('.nuevoItemInstalacion').length;
	for(var i=1; i<=contInstalacion; i++){
		items.push(arreglo('nuevoItemInstalacion_'+i, 'instalacion', 3));
	}

	var contFuncionamiento = $('.nuevoItemFuncionamiento').length;
	for(var i=1; i<=contFuncionamiento; i++){
		items.push(arreglo('nuevoItemFuncionamiento_'+i, 'funcionamiento', 3));
	}	

	var contInvima = $('#invima .nuevoItemInvima').length;
	for(var i=1; i<=contInvima; i++){
		items.push(arreglo('nuevoItemInvima_'+i, 'invima', 4));
	}

	var contProveedor = $('#prove .nuevoItemProveedor').length;
	for(var i=1; i<=contProveedor; i++){
		items.push(arreglo('nuevoItemProveedor_'+i, 'proveedores', 4));
	}

	var contFabricante = $('#fabricantes .nuevoItemFabricante').length;
	for(var i=1; i<=contFabricante; i++){
		items.push(arreglo('nuevoItemFabricante_'+i, 'fabricantes', 4));
	}

	var contVariables = $('#variables .nuevoItemVariable').length;
	for(var i=1; i<=contVariables; i++){
		items.push(arreglo('nuevoItemVariable_'+i, 'variables', 5));
	}

	var contAccesorios = $('#accesorios .nuevoItemAccesorio').length;
	for(var i=1; i<=contAccesorios; i++){
		items.push(arreglo('nuevoItemAccesorio_'+i, 'accesorios', 6));
	}

	form_data.append('items', JSON.stringify(items));

	$.ajax({
		url: '../../controllers/equiposController.php',
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
			url: '../../controllers/equiposController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarEquipo);
				$('.formEditarEquipo').click(formEditarEquipo);
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarEquipo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idEquipo').val();
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
		url: '../../controllers/equiposController.php',
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

function formEditarEquipo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idEquipo').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/equiposController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-equipos').html('');
			$('.modal-equipos').html(resultado);
			$('#editarEquipo').click(editarEquipo);
			$('.nuevoInvima').click(nuevoInvima);
			$('.nuevoProveedor').click(nuevoProveedor);
			$('.nuevoFabricante').click(nuevoFabricante);
			$('.nuevaVariable').click(nuevaVariable);		
			$('.nuevoAccesorio').click(nuevoAccesorio);

		}
	});
}

function editarEquipo() {
	var form_data = new FormData();
	form_data.append('accion', 'editar');
	form_data.append('idEquipo', $('#idEquipo').val());
	form_data.append('idMarca', $('#idMarca').val());
	form_data.append('idModelo', $('#idModelo').val());
	form_data.append('idRegistro', $('#idRegistro').val());
	form_data.append('vidaUtil', $('#vidaUtil').val());
	form_data.append('foto', $('#foto')[0].files[0]);
	
	var items = [];
	// INSTALACIÓN
	items.push(arreglo('fuenteAlimentacion', 'instalacion', 7));
	items.push(arreglo('tecnologiaDominante', 'instalacion', 7));
	items.push(arreglo('voltajeDeAlimentacion', 'instalacion', 1));
	items.push(arreglo('consumoDeCorriente', 'instalacion', 1));
	items.push(arreglo('potenciaDisipada', 'instalacion', 2));
	items.push(arreglo('frecuenciaElectrica', 'instalacion', 2));
	items.push(arreglo('pesoEquipo', 'instalacion', 2));
	items.push(arreglo('presionAmbiente', 'instalacion', 2));
	items.push(arreglo('temperaturaOperativa', 'instalacion', 1));
	items.push(arreglo('velocidadFlujo', 'instalacion', 2));
	// FUNCIONAMIENTO
	items.push(arreglo('voltajeGenerado', 'funcionamiento', 1));
	items.push(arreglo('corrienteFuga', 'funcionamiento', 1));
	items.push(arreglo('potenciaIrradiada', 'funcionamiento', 1));
	items.push(arreglo('frecuenciaOperacion', 'funcionamiento', 1));
	items.push(arreglo('controlPresion', 'funcionamiento', 1));
	items.push(arreglo('controlVelocidad', 'funcionamiento', 1));
	items.push(arreglo('pesoSoportado', 'funcionamiento', 1));
	items.push(arreglo('controlTemperatura', 'funcionamiento', 1));
	items.push(arreglo('controlHumedad', 'funcionamiento', 1));
	items.push(arreglo('controlEnergia', 'funcionamiento', 1));

	var contInstalacion = $('.nuevoItemInstalacion').length;
	for(var i=1; i<=contInstalacion; i++){
		items.push(arreglo('nuevoItemInstalacion_'+i, 'instalacion', 3));
	}

	var contFuncionamiento = $('.nuevoItemFuncionamiento').length;
	for(var i=1; i<=contFuncionamiento; i++){
		items.push(arreglo('nuevoItemFuncionamiento_'+i, 'funcionamiento', 3));
	}	

	var contInvima = $('#invima .nuevoItemInvima').length;
	for(var i=1; i<=contInvima; i++){
		items.push(arreglo('nuevoItemInvima_'+i, 'invima', 4));
	}

	var contProveedor = $('#prove .nuevoItemProveedor').length;
	for(var i=1; i<=contProveedor; i++){
		items.push(arreglo('nuevoItemProveedor_'+i, 'proveedores', 4));
	}

	var contFabricante = $('#fabricantes .nuevoItemFabricante').length;
	for(var i=1; i<=contFabricante; i++){
		items.push(arreglo('nuevoItemFabricante_'+i, 'fabricantes', 4));
	}

	var contVariables = $('#variables .nuevoItemVariable').length;
	for(var i=1; i<=contVariables; i++){
		items.push(arreglo('nuevoItemVariable_'+i, 'variables', 5));
	}

	var contAccesorios = $('#accesorios .nuevoItemAccesorio').length;
	for(var i=1; i<=contAccesorios; i++){
		items.push(arreglo('nuevoItemAccesorio_'+i, 'accesorios', 6));
	}

	form_data.append('items', JSON.stringify(items));

	$.ajax({
		url: '../../controllers/equiposController.php',
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