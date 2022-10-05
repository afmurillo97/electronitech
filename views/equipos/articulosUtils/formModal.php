<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-articulos">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear Articulo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<?php 
					foreach (getTemporal() as $fila) {
						$valores=json_decode($fila['valores']);
						$idCliente = $valores->idCliente;
					}
				?>
				<form>
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" style="font-size: 0.8em;">Articulo</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="historico-tab" data-toggle="tab" href="#historico" role="tab" aria-controls="historico" aria-selected="false" style="font-size: 0.8em;">Reg Historico</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="monitoreo-tab" data-toggle="tab" href="#monitoreo" role="tab" aria-controls="monitoreo" aria-selected="false" style="font-size: 0.8em;">Monitoreo</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="notas-tab" data-toggle="tab" href="#notas" role="tab" aria-controls="notas" aria-selected="false" style="font-size: 0.8em;">Notas</a>
						</li>
					</ul>

					<div class="tab-content" id="myTabContent">
						<!-- HOME -->
						<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
							<h4 class="card-title text-center">Articulo</h4>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Cliente</label>
								<div class="col-sm-9">
									<select class="form-control form-control-sm" id="idCliente">
										<option value="NaN">Seleccione</option>
										<?php
											if (isset($idCliente)) {
												echo '<option value="'.$idCliente.'" selected>'.clientesName($idCliente).'</option>';
											}
											foreach (getClientes() as $fila) {
												echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
											}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Dirección</label>
								<div class="col-sm-9">
									<select class="form-control form-control-sm" id="direccion"></select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Servicio Hospitalario</label>
								<div class="col-sm-9">
									<select class="form-control form-control-sm" id="idServicio"></select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Serie</label>
								<div class="col-sm-9">
									<input type="text" class="form-control form-control-sm" id="serie">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Tipo</label>
								<div class="col-sm-9">
									<input type="text" class="form-control form-control-sm" id="tipo">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">No. Inventario</label>
								<div class="col-sm-9">
									<input type="text" class="form-control form-control-sm" id="nInventario">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Tipo de Equipo</label>
								<div class="col-sm-9">
									<select class="form-control form-control-sm" id="idTipoEquipo">
										<option value="NaN">Seleccione</option>
										<?php 
											foreach (getTipoEquipo() as $fila) {
												echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
											}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Equipo</label>
								<div class="col-sm-9">
									<select class="form-control form-control-sm" id="idEquipo">
										<option value="NaN">Seleccione</option>
										<?php 
											foreach (getEquipos() as $fila) {
												echo '<option value="'.$fila['id'].'">'.$fila['marca'].' - '.$fila['modelo'].'</option>';
											}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Registro</label>
								<div class="col-sm-9">
									<select class="form-control form-control-sm" id="idRegistro"></select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Ubicación</label>
								<div class="col-sm-9">
									<input type="text" class="form-control form-control-sm" id="ubicacion">
								</div>
							</div>
						</div>
						<!-- END HOME -->
						
						<!-- HISTORICO -->
						<div class="tab-pane fade" id="historico" role="tabpanel" aria-labelledby="historico-tab">
							<h4 class="card-title text-center">Registro Historico</h4>

							<table class="table table-borderless table-hover table-sm">
								<tr class="formaAdquisicion">
									<td>Forma de Adquisición</td>
									<td>
										<select class="form-control form-control-sm" id="val1">
											<option value="NaN">Seleccione</option>
											<option value="COMPRA DIRECTA">COMPRA DIRECTA</option>
											<option value="DONACIÓN">DONACIÓN</option>
											<option value="ASIGNACIÓN">ASIGNACIÓN</option>
											<option value="ALQUILER">ALQUILER</option>
											<option value="DEMO">DEMO</option>
											<option value="COMO DATO">COMO DATO</option>
										</select>
									</td>
								</tr>

								<tr class="documentoAdquisicion">
									<td>Documento de Referencia de la Adquisición</td>
									<td><input type="text" class="form-control form-control-sm" id="val1"></td>
								</tr>

								<tr class="fechaAdquisicion">
									<td>Fecha de Adquisición</td>
									<td><input type="date" class="form-control form-control-sm" id="val1"></td>
								</tr>

								<tr class="costoSinIVA">
									<td>Costo sin IVA</td>
									<td><input type="text" class="form-control form-control-sm" id="val1"></td>
								</tr>

								<tr class="fechaEntrega">
									<td>Fecha Entrega / Instalación</td>
									<td><input type="date" class="form-control form-control-sm" id="val1"></td>
								</tr>

								<tr class="numeroActa">
									<td>Número de Acta de Entrega</td>
									<td><input type="text" class="form-control form-control-sm" id="val1"></td>
								</tr>

								<tr class="fechaInicio">
									<td>Fecha Inicio de Operación</td>
									<td><input type="date" class="form-control form-control-sm" id="val1"></td>
								</tr>

								<tr class="fechaVencimiento">
									<td>Fecha Vencimiento de la Garantía</td>
									<td><input type="date" class="form-control form-control-sm" id="val1"></td>
								</tr>

								<tr class="fechaFabricacion">
									<td>Fecha de Fabricación</td>
									<td><input type="date" class="form-control form-control-sm" id="val1"></td>
								</tr>

								<tr class="registroImportacion">
									<td>Registro de Importación</td>
									<td>
										<select class="form-control form-control-sm"  id="val1">
											<option value="NaN">Seleccione</option>
											<?php 
												foreach (getManifiestos() as $fila) {
													echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
												}
											?>
										</select>
									</td>
								</tr>

								<tr class="proveedor">
									<td>Proveedor</td>
									<td>
										<select class="form-control form-control-sm" id="val1">
											<option value="NaN">Seleccione</option>
											<?php 
												foreach (getProveedores() as $fila) {
													echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
												}
											?>
										</select>
									</td>
								</tr>

								<tr class="fabricante">
									<td>Fabricante</td>
									<td>
										<select class="form-control form-control-sm" id="val1">
											<option value="NaN">Seleccione</option>
											<?php 
												foreach (getFabricantes() as $fila) {
													echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
												}
											?>
										</select>
									</td>
								</tr>
							</table>
						</div>
						<!-- END HISTORICO -->

						<!-- MONITOREO -->
						<div class="tab-pane fade" id="monitoreo" role="tabpanel" aria-labelledby="monitoreo-tab">
							<h4 class="card-title text-center">Caracteristicas de Monitoreo</h4>

							<table class="table table-borderless table-hover table-sm">
								<tr>
									<td class="dioxidoCarbono">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_1">
											<label class="custom-control-label" for="customSwitch_1">Dióxido de Carbono</label>
										</div>
									</td>
									<td class="frecuenciaCardiaca">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_2">
											<label class="custom-control-label" for="customSwitch_2">Frecuencia Cardíaca</label>
										</div>
									</td>
									<td class="temperatura">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_3">
											<label class="custom-control-label" for="customSwitch_3">Temperatura</label>
										</div>
									</td>
									<td class="gasesAnestesicos">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_4">
											<label class="custom-control-label" for="customSwitch_4">Gases Anestesicos</label>
										</div>
									</td>
								</tr>

								<tr>
									<td class="electroCardiografia">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_5">
											<label class="custom-control-label" for="customSwitch_5">Electro-Cardiografía</label>
										</div>
									</td>
									<td class="presionNoInvasiva">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_6">
											<label class="custom-control-label" for="customSwitch_6">Presión NO Invasiva</label>
										</div>
									</td>
									<td class="oximetriaPulso">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_7">
											<label class="custom-control-label" for="customSwitch_7">Oximetría de Pulso</label>
										</div>
									</td>
									<td class="gastoCardiaco">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_8">
											<label class="custom-control-label" for="customSwitch_8">Gasto Cardíaco</label>
										</div>
									</td>
								</tr>

								<tr>
									<td class="electroMiografia">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_9">
											<label class="custom-control-label" for="customSwitch_9">Electro-Miografía</label>
										</div>
									</td>
									<td class="presionInvasiva">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_10">
											<label class="custom-control-label" for="customSwitch_10">Presión Invasiva</label>
										</div>
									</td>
									<td class="indiceBispectral">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_11">
											<label class="custom-control-label" for="customSwitch_11">Índice Bispectral</label>
										</div>
									</td>
									<td class="glucosa">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_12">
											<label class="custom-control-label" for="customSwitch_12">Glucosa</label>
										</div>
									</td>
								</tr>

								<tr>
									<td class="electroOculografia">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_13">
											<label class="custom-control-label" for="customSwitch_13">Electro-Oculografía</label>
										</div>
									</td>
									<td class="respiracion">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_14">
											<label class="custom-control-label" for="customSwitch_14">Respiración</label>
										</div>
									</td>
									<td class="Electroencefalografia">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_15">
											<label class="custom-control-label" for="customSwitch_15">Electroencefalografía</label>
										</div>
									</td>
									<td class="ultrasonido">
										<div class="custom-control custom-switch">
											<input type="checkbox" class="custom-control-input val1" id="customSwitch_16">
											<label class="custom-control-label" for="customSwitch_16">Ultrasonido</label>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<!-- END MONITOREO -->

						<!-- NOTAS -->
						<div class="tab-pane fade" id="notas" role="tabpanel" aria-labelledby="notas-tab">
							<h4 class="card-title text-center">Notas</h4>

							<table class="table table-borderless table-hover table-sm">
								<tr class="notas">
									<td>
										<textarea class="form-control" id="val1" rows="4"></textarea>
									</td>
								</tr>
							</table>
						</div>
						<!-- END NOTAS -->
					</div><br>

					<button type="button" class="btn btn-primary mr-2" id="nuevoArticulo" data-dismiss="modal">Guardar</button>
					<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
					<button type="button" class="btn btn-outline-primary" id="aplicar">Aplicar</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-reportes">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear Reporte de Mantenimiento</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form>

					<div class="row">

						<div class="col">
							<div class="form-group">
								<label class="col-sm-12 col-form-label">Cliente</label>
								<div class="col-sm-9">
									<select class="form-control form-control-sm" id="idCliente">
										<option value="NaN">Seleccione</option>
										<?php
											foreach (getClientes() as $fila) {
												echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
											}
										?>
									</select>
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-12 col-form-label">Contacto</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="contacto" placeholder="Contacto">
								</div>
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col">
							<div class="form-group">
								<label class="col-sm-12 col-form-label">Dirección</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="direccion" placeholder="Dirección">
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-12 col-form-label">Ciudad</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="ciudad" placeholder="Ciudad">
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-12 col-form-label">Fecha del Servicio</label>
								<div class="col-sm-12">
									<input type="date" class="form-control" id="fecha" placeholder="Fecha del Servicio">
								</div>
							</div>
						</div>

					</div>

					<table class="table table-borderless table-sm">

						<label class="col-sm-2 col-form-label">Servicio Por</label>

						<tr>
							<td class="col-sm-3">
								<div class="form-check">
									<input type="radio" class="form-check-input" name="optionsRadios" id="" value="" checked="">
									<label class="form-check-label">Garantía</label>
								</div>
							</td>
							<td class="col-sm-3">
								<div class="form-check">
									<input type="radio" class="form-check-input" name="optionsRadios" id="" value="">
									<label class="form-check-label">Contrato</label>
								</div>
							</td>
							<td class="col-sm-3">
								<div class="form-check">
									<input type="radio" class="form-check-input" name="optionsRadios" id="" value="">
									<label class="form-check-label">Factura</label>
								</div>
							</td>
							<td class="col-sm-9 d-flex flex-row align-items-center">
								<div class="form-check">
									<input type="radio" class="form-check-input" name="optionsRadios" id="" value="">
									<label class="form-check-label">Otro</label>
								</div>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="otro">
								</div>
							</td>
						</tr>

					</table>

					<table class="table table-borderless table-sm">

						<label class="col-sm-2 col-form-label"> Tipo de Servicio</label>

						<tr>
							<td class="col-sm-3">
								<div class="form-check">
									<input type="radio" class="form-check-input" name="optionsRadios2" id="" value="" checked="">
									<label class="form-check-label">Instalación</label>
								</div>
							</td>
							<td class="col-sm-3">
								<div class="form-check">
									<input type="radio" class="form-check-input" name="optionsRadios2" id="" value="">
									<label class="form-check-label">Preventivo</label>
								</div>
							</td>
							<td class="col-sm-3">
								<div class="form-check">
									<input type="radio" class="form-check-input" name="optionsRadios2" id="" value="">
									<label class="form-check-label">Correctivo</label>
								</div>
							</td>
							<td class="col-sm-9 d-flex flex-row align-items-center">
								<div class="form-check">
									<input type="radio" class="form-check-input" name="optionsRadios2" id="" value="">
									<label class="form-check-label">Otro</label>
								</div>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="otro">
								</div>
							</td>
						</tr>

					</table>

					<div class="row">
						<div class="col">
							<div class="form-group">
								<label class="col-sm-12 col-form-label">Equipo</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="equipo" placeholder="Equipo">
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-12 col-form-label">Marca / Modelo</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="marcaModelo" placeholder="Marca / Modelo">
								</div>
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col">
							<div class="form-group">
								<label class="col-sm-12 col-form-label">Serial (S/N)</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="serial" placeholder="Serial">
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-12 col-form-label">Ubicación / No INV</label>
								<div class="col-sm-12">
									<input type="text" class="form-control" id="ubicacionInvima" placeholder="Ubicación / No INV">
								</div>
							</div>
						</div>

					</div>


					<div class="col-lg-12 grid-margin stretch-card">

                		<div class="card">
                		  <div class="card-body">
						  	<h4 class="card-title text-center">MANTENIMIENTO DE EQUIPO Y/O DISPOSITIVO BIOMEDICO</h4>
							<h4 class="card-title text-center">PROTOCOLO: GENERAL</h4>
							<hr>
								<h6 class="card-title text-center">INSPECCION INICIAL</h6>
							<hr>

                		    <div class="table-responsive">
                		      <table class="table table-bordered">
                		        <thead>

                		          <tr class="text-center">
								  	<th class="text-white">DESCRIPCIÓN</th>
									<th class="text-white">PASA</th>
									<th class="text-white">FALLA</th>
									<th class="text-white">N / A</th>
									<th class="text-white">OBSERVACIONES</th>
                		          </tr>

                		        </thead>

                		        <tbody>

                		          <tr>
                		            <td>VERIFICACION DE ESTADO FISICO GENERAL</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios3" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios3" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios3" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>VERIFICACION DE FUNCIONAMIENTO</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios4" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios4" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios4" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>VERIFICACION DE ACCESORIOS</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios5" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios5" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios5" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td> VERIFICACION DE INDICADORES VISUALES/AUDITIVOS</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios6" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios6" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios6" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		        </tbody>
                		      </table>
                		    </div>

							<hr>
								<h6 class="card-title text-center">SISTEMA ELECTRICO</h6>
							<hr>

                		    <div class="table-responsive">
                		      <table class="table table-bordered">
                		        <thead>

                		          <tr class="text-center">
								  	<th class="text-white">DESCRIPCIÓN</th>
									<th class="text-white">PASA</th>
									<th class="text-white">FALLA</th>
									<th class="text-white">N / A</th>
									<th class="text-white">OBSERVACIONES</th>
                		          </tr>

                		        </thead>

                		        <tbody>

                		          <tr>
                		            <td>ALIMENTACION RED ELECTRICA Y/O REGULACION</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios7" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios7" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios7" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>ALIMENTACION SUPLEMENTARIA Y/O BATERIAS</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios8" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios8" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios8" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>PROTECCIONES (FUSIBLES, TERMICOS, ETC)</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios9" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios9" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios9" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		        </tbody>
                		      </table>
                		    </div>

							<hr>
								<h6 class="card-title text-center">SISTEMA ELECTRONICO</h6>
							<hr>

                		    <div class="table-responsive">
                		      <table class="table table-bordered">
                		        <thead>

                		          <tr class="text-center">
								  	<th class="text-white">DESCRIPCIÓN</th>
									<th class="text-white">PASA</th>
									<th class="text-white">FALLA</th>
									<th class="text-white">N / A</th>
									<th class="text-white">OBSERVACIONES</th>
                		          </tr>

                		        </thead>

                		        <tbody>

                		          <tr>
                		            <td>TARJETA PRINCIPAL DE CONTROL Y/O POTENCIA</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios10" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios10" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios10" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>CONECTORES Y PUERTOS DE COMUNICACION</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios11" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios11" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios11" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>MANDOS DE CONTROL, TECLADOS</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios12" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios12" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios12" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

								  <tr>
                		            <td>MODULOS DE MONITOREO (EKG,SPO2,NIBP,TEMP, ETC)</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios13" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios13" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios|3" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

								  <tr>
                		            <td>PANTALLAS E INDICADORES VISUALES/AUDITIVOS</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios14" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios14" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios14" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>


                		        </tbody>
                		      </table>
                		    </div>

							<hr>
								<h6 class="card-title text-center">SISTEMA MECANICO</h6>
							<hr>

                		    <div class="table-responsive">
                		      <table class="table table-bordered">
                		        <thead>

                		          <tr class="text-center">
								  	<th class="text-white">DESCRIPCIÓN</th>
									<th class="text-white">PASA</th>
									<th class="text-white">FALLA</th>
									<th class="text-white">N / A</th>
									<th class="text-white">OBSERVACIONES</th>
                		          </tr>

                		        </thead>

                		        <tbody>

                		          <tr>
                		            <td>AJUSTE DE PIEZAS MOVILES</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios15" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios15" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios15" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>LUBRICACION Y AJUSTE DE PIEZAS</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios16" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios16" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios16" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>ACTUADORES MECANICOS</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios17" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios17" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios17" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		        </tbody>
                		      </table>
                		    </div>

							<hr>
								<h6 class="card-title text-center">SISTEMA NEUMATICO / HIDRAULICO</h6>
							<hr>

                		    <div class="table-responsive">
                		      <table class="table table-bordered">
                		        <thead>

                		          <tr class="text-center">
								  	<th class="text-white">DESCRIPCIÓN</th>
									<th class="text-white">PASA</th>
									<th class="text-white">FALLA</th>
									<th class="text-white">N / A</th>
									<th class="text-white">OBSERVACIONES</th>
                		          </tr>

                		        </thead>

                		        <tbody>

                		          <tr>
                		            <td>VALVULAS, CONTROLES Y REGULADORES DE PRESION Y/O FLUJO</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios18" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios18" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios18" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>COMPRESOR Y/O TURBINA</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios19" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios19" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios19" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>MANGUERAS, TUBERIAS, ACOPLES Y EMPAQUES</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios20" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios20" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios20" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>FILTROS, TRAMPAS DE AGUA, EMPAQUES, ACOPLES</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios21" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios21" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios21" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		        </tbody>
                		      </table>
                		    </div>

							<hr>
								<h6 class="card-title text-center">SISTEMA DE VENTILACION MECANICA</h6>
							<hr>

                		    <div class="table-responsive">
                		      <table class="table table-bordered">
                		        <thead>

                		          <tr class="text-center">
								  	<th class="text-white">DESCRIPCIÓN</th>
									<th class="text-white">PASA</th>
									<th class="text-white">FALLA</th>
									<th class="text-white">N / A</th>
									<th class="text-white">OBSERVACIONES</th>
                		          </tr>

                		        </thead>

                		        <tbody>

                		          <tr>
                		            <td>PARAMETROS Y MODULOS DE VENTILACION</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios22" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios22" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios22" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td>ABSORBEDOR, FLUELLE Y APL</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios23" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios23" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios23" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		          <tr>
                		            <td> ACUMULADORES Y/O ACTUADORES NEUMATICOS </td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios24" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios24" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios24" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		        </tbody>
                		      </table>
                		    </div>

							<hr>
								<h6 class="card-title text-center">INSPECCION FINAL</h6>
							<hr>

                		    <div class="table-responsive">
                		      <table class="table table-bordered">
                		        <thead>

                		          <tr class="text-center">
								  	<th class="text-white">DESCRIPCIÓN</th>
									<th class="text-white">PASA</th>
									<th class="text-white">FALLA</th>
									<th class="text-white">N / A</th>
									<th class="text-white">OBSERVACIONES</th>
                		          </tr>

                		        </thead>

                		        <tbody>

                		          <tr>
                		            <td>ESTADO GENERAL</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios25" id="" value="" checked="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios25" id="" value="">
										</div>
									</td>
									<td>
										<div class="form-check text-center">
											<input type="radio" class="form-check-input" name="optionsRadios25" id="" value="">
										</div>
									</td>
									<td>
										<textarea class="form-control" id="obsercaciones" rows="2"></textarea>
									</td>
                		          </tr>

                		        </tbody>
                		      </table>
                		    </div>
							
							<br>
							<h4 class="card-title text-center">OBSERVACIONES GENERALES</h4>

							<textarea class="col-sm-12 form-control" id="obsercaciones" rows="6"></textarea>

							<br>
							<div class="form-group row">
								<label class="col-sm-6 col-form-label"> Seleccione el Ingeniero encargado del soporte:</label>
								<div class="col-sm-6">
									<select class="form-control form-control-sm" id="idCliente">
										<option value="NaN">Seleccione</option>
										<option value="NaN">Juan Leonardo Salasar Arias</option>
									</select>
								</div>
							</div>

                		  </div>
                		</div>
              		</div>


					<button type="button" class="btn btn-primary mr-2" id="nuevoCliente" data-dismiss="modal">Guardar</button>
					<button class="btn btn-dark" onClick="history.back();">Cancelar</button>

				</form>
			</div>
		</div>
	</div>
</div>