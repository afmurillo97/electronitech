$(document).on('ready', iniciar);
	function iniciar(){
		$('.selectSearch').selectize({
			sortField: 'text'
		});
		
		$('#idEcri-selectized').on('keyup', loadData);
		$('#nuevoTipoEquipo').click(nuevoTipoEquipo);	
		$('#entrada').on('keyup', buscar);
		$('.checkbox').click(habilitarTipoEquipo);
		$('.formEditarTipoEquipo').click(formEditarTipoEquipo);
	}
	
function loadData() {
	var nombre = $('#idEcri-selectized').val();

	if (nombre.length>3) {
		var json = {
			'accion' : 'searchTypes',
			'nombre' : nombre
		};

		$.ajax({
			url: '../../controllers/tipoEquipoController.php',
			type: 'POST',
			data: json,
			success: function(resultado) {
				$('.selectSearch').each(function() {
					resultado = JSON.parse(resultado)

					this.selectize.clearOptions();

					for (let i=0; i<resultado.length; i++) {
						this.selectize.addOption({value: resultado[i].id, text: resultado[i].nombre+' ('+resultado[i].codigo+')'});		
					}
					this.selectize.refreshOptions();
				});
			}
		});
	}
}

function nuevoTipoEquipo() {
 	var idEcri = $("#idEcri").val();
	var riesgo = $("#riesgo").val();
	var idDescripcionBiomedica = $("#idDescripcionBiomedica").val();
	var idProtocolo = $("#idProtocolo").val();
	var validacion = $("#validacion").val();

	var json = {
		'accion' : 'ingresar',
		'idEcri' : idEcri,
		'riesgo' : riesgo,
		'idDescripcionBiomedica' : idDescripcionBiomedica,
		'idProtocolo' : idProtocolo,
		'validacion' : validacion
	};

	$.ajax({
		url: '../../controllers/tipoEquipoController.php',
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
			url: '../../controllers/tipoEquipoController.php',
			type:'POST',
			data: $("#buscar").serialize(), 
			success: function(resultado){
				$('#resultado').html('');
				$('#resultado').html(resultado);
				$('.checkbox').click(habilitarTipoEquipo);
				$('.formEditarTipoEquipo').click(formEditarTipoEquipo);				
			}
		});
	}else{
		$('#resultado').html('');
	}
}

function habilitarTipoEquipo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idTipoEquipo').val();
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
		url: '../../controllers/tipoEquipoController.php',
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

function formEditarTipoEquipo() {
	var fila = $(event.target);
	var id = fila.parents('tr').find('.idTipoEquipo').val();

	var json = {
		'accion' : 'especifico',
		'id' : id
	};

	$.ajax({
		url: '../../controllers/tipoEquipoController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('.modal-tipoEquipo').html('');
			$('.modal-tipoEquipo').html(resultado);
			$('#editarTipoEquipo').click(editarTipoEquipo);
			$('#idEcri-selectized').on('keyup', loadData);
		}
	});
}

function editarTipoEquipo() {
	var id = $("#id").val();	
	var riesgo = $("#riesgo").val();

	if (typeof $("#idEcri").val() === 'number') {
		var idEcri = $("#idEcri").val();
	}else{
		var idEcri = $("#idEcri").data("idecri");
	}
	var idDescripcionBiomedica = $("#idDescripcionBiomedica").val();
	var idProtocolo = $("#idProtocolo").val();
	var validacion = $("#validacion").val();

	var json = {
		'accion' : 'editar',
		'id' : id,
		'idEcri' : idEcri,
		'riesgo' : riesgo,
		'idDescripcionBiomedica' : idDescripcionBiomedica,
		'idProtocolo' : idProtocolo,
		'validacion' : validacion
	};

	$.ajax({
		url: '../../controllers/tipoEquipoController.php',
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