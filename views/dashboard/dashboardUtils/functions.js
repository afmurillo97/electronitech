$(document).on('ready', iniciar);
	function iniciar(){
		$('#idCliente').on('change', cargarDireccion);
		$('#fechaFinal').on('change', condicionesFechas);
		$('#nuevoCronograma').on('click', nuevoCronograma);
	}

function nuevoCronograma() {
	var selected = [];
	$(":checkbox[name=articulos]").each(function() {
		if (this.checked) {
			selected.push($(this).val());
		}
	});

	var json = {
		'accion' : 'ingresar',
		'idCliente' : $('#idCliente').val(),
		'direccion' : $('#direccion').val(),
		'fechaInicial' : $('#fechaInicial').val(),
		'fechaFinal' : $('#fechaFinal').val(),
		'frecuencia' : $('#frecuencia').val(),
		'articulos' : selected
	};

	$.ajax({
		url: '../../controllers/dashboardController.php',
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

function cargarDireccion() {
	var json = {
		'accion' : 'cargarDireccion',
		'id' : $('#idCliente').val()
	};

	$.ajax({
		url: '../../controllers/dashboardController.php',
		type: 'POST',
		data: json,
		success: function(resultado) {
			$('#direcciones').html('');
			$('#direcciones').html(resultado);
			cargarArticulos();
		}
	});	
}

function condicionesFechas() {
	var fechaInicial = $('#fechaInicial').val();
	var fechaFinal = $('#fechaFinal').val();

	if(fechaFinal < fechaInicial) {
		$('#fechaFinal').val(fechaInicial);
		$('#modalFechas').modal('show');
	}
}

function cargarArticulos() {
	var idCliente = $('#idCliente').val();
	var direccion = $('#direccion').val();	

	if(idCliente != 'NaN' && direccion.length>0) {
		var json = {
			'accion' : 'cargarArticulos',
			'idCliente' : $('#idCliente').val(),
			'direccion' : $('#direccion').val()
		};

		$.ajax({
			url: '../../controllers/dashboardController.php',
			type: 'POST',
			data: json,
			success: function(resultado) {
				$('#articulos').html('');
				$('#articulos').html(resultado);
				$('.selTodo').on('click', selTodo);
			}
		});	
	}
}

function selTodo(){
	if (this.checked) {
		$(":checkbox[name=articulos]").prop('checked', true);
	}else{
		$(":checkbox[name=articulos]").prop('checked', false);
	}
}







