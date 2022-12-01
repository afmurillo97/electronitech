<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-equipos">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear Equipo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form>
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" style="font-size: 0.8em;">Equipo</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="instalacion-tab" data-toggle="tab" href="#instalacion" role="tab" aria-controls="instalacion" aria-selected="false" style="font-size: 0.8em;">Reg Instalación</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="funcionamiento-tab" data-toggle="tab" href="#funcionamiento" role="tab" aria-controls="funcionamiento" aria-selected="false" style="font-size: 0.8em;">Reg Funcionamiento</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="invima-tab" data-toggle="tab" href="#invima" role="tab" aria-controls="invima" aria-selected="false" style="font-size: 0.8em;">Reg Invima</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="prove-tab" data-toggle="tab" href="#prove" role="tab" aria-controls="prove" aria-selected="false" style="font-size: 0.8em;">Proveedores</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="fabricantes-tab" data-toggle="tab" href="#fabricantes" role="tab" aria-controls="fabricantes" aria-selected="false" style="font-size: 0.8em;">Fabricantes</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="variables-tab" data-toggle="tab" href="#variables" role="tab" aria-controls="variables" aria-selected="false" style="font-size: 0.8em;">Variables Metrologicas</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="accesorios-tab" data-toggle="tab" href="#accesorios" role="tab" aria-controls="accesorios" aria-selected="false" style="font-size: 0.8em;">Accesorios</a>
						</li>
					</ul>

					<div class="tab-content" id="myTabContent">
						<!-- HOME -->
						<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
							<h4 class="card-title text-center">Equipo</h4>
							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Marca</label>
								<div class="col-sm-9">
									<select class="form-control form-control-sm" id="idMarca">
										<option value="NaN">Seleccione</option>
										<?php 
											foreach (getMarcas() as $fila) {
												echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
											}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Modelo</label>
								<div class="col-sm-9">
									<select class="form-control form-control-sm" id="idModelo"></select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Tipo Registro Invima</label>
								<div class="col-sm-9">
									<select class="form-control form-control-sm" id="idRegistro">
										<option value="NaN">Seleccione</option>
										<option value="REGISTRO SANITARIO">REGISTRO SANITARIO</option>
										<option value="PERMISO DE COMERCIALIZACION">PERMISO DE COMERCIALIZACIÓN</option>
										<option value="NO REGISTRA">NO REGISTRA</option>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Vida Util (Años)</label>
								<div class="col-sm-9">
									<input type="text" class="form-control form-control-sm" id="vidaUtil" placeholder="Vida Util">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 col-form-label">Registro Fotografico</label>
								<div class="col-sm-9">
									<input type="file" class="form-control form-control-sm" id="foto">
								</div>									
							</div>
						</div>
						<!-- END HOME -->
						
						<!-- INSTALACIÓN -->
						<div class="tab-pane fade" id="instalacion" role="tabpanel" aria-labelledby="instalacion-tab">
							<h4 class="card-title text-center">Registro de Instalación</h4>

							<table class="table table-borderless table-hover table-sm">
								<tr>
									<td>Fuente de Alimentación</td>
									<td></td>
									<td class="fuenteAlimentacion">
										<select class="form-control form-control-sm" id="val1">
											<option value="NaN">Seleccione</option>
											<option value="agua">Agua</option>
											<option value="gas">Gas</option>
											<option value="aire">Aire</option>
											<option value="vapor">Vapor</option>
											<option value="combustible">Combustible</option>
											<option value="electricidad">Electricidad</option>
											<option value="bacterias">Bacterias</option>
											<option value="energia solar">Energia Solar</option>
										</select>
									</td>
									<td></td>
									<td></td>
									<td>Tecnologia Dominante</td>
									<td class="tecnologiaDominante">
										<select class="form-control form-control-sm" id="val1">
											<option value="NaN">Seleccione</option>
											<option value="electrica">Electrica</option>
											<option value="electronica">Electronica</option>
											<option value="electromecanica">Electromecanica</option>
											<option value="mecanica">Mecanica</option>
											<option value="hidraulica">Hidraulica</option>
											<option value="neumatica">Neumatica</option>
										</select>
									</td>
								</tr>

								<tr class="voltajeDeAlimentacion">
									<td>Voltaje de Alimentación</td>
									<td>MAX</td>
									<td><input type="text" class="form-control form-control-sm max"></td>
									<td>MIN</td>
									<td><input type="text" class="form-control form-control-sm min"></td>
									<td>Unidad</td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="VAC">VAC</option>
											<option value="VDC">VDC</option>
										</select>
									</td>
								</tr>

								<tr class="consumoDeCorriente">
									<td>Consumo de Corriente</td>
									<td>MAX</td>
									<td><input type="text" class="form-control form-control-sm max"></td>
									<td>MIN</td>
									<td><input type="text" class="form-control form-control-sm min"></td>
									<td>Unidad</td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="A">A</option>
											<option value="mA">mA</option>
										</select>
									</td>
								</tr>

								<tr class="potenciaDisipada">
									<td>Potencia Disipada</td>
									<td></td>
									<td><input type="text" class="form-control form-control-sm val1"></td>
									<td></td>
									<td></td>
									<td>Unidad</td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="VA">VA</option>
											<option value="W">W</option>
										</select>
									</td>
								</tr>

								<tr class="frecuenciaElectrica">
									<td>Frecuencia Eléctrica</td>
									<td></td>
									<td><input type="text" class="form-control form-control-sm val1"></td>
									<td></td>
									<td></td>
									<td>Unidad</td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="Hz">Hz</option>
										</select>
									</td>
								</tr>

								<tr class="pesoEquipo">
									<td>Peso del Equipo</td>
									<td></td>
									<td><input type="text" class="form-control form-control-sm val1"></td>
									<td></td>
									<td></td>
									<td>Unidad</td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="G">g</option>
											<option value="Kg">Kg</option>
										</select>
									</td>
								</tr>

								<tr class="presionAmbiente">
									<td>Presión Ambiente</td>
									<td></td>
									<td><input type="text" class="form-control form-control-sm val1"></td>
									<td></td>
									<td></td>
									<td>Unidad</td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="bar">bar</option>
											<option value="Pa">Pa</option>
											<option value="kPa">kPa</option>
											<option value="PSI">PSI</option>
											<option value="mmHg">mmHg</option>
											<option value="cmH2O">cmH2O</option>
										</select>
									</td>
								</tr>

								<tr class="temperaturaOperativa">
									<td>Temperatura Operativa</td>
									<td>MAX</td>
									<td><input type="text" class="form-control form-control-sm max"></td>
									<td>MIN</td>
									<td><input type="text" class="form-control form-control-sm min"></td>
									<td>Unidad</td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="C">°C</option>
											<option value="F">°F</option>
											<option value="K">K</option>
										</select>
									</td>
								</tr>

								<tr class="velocidadFlujo">
									<td>Velocidad / Flujo Máximo</td>
									<td></td>
									<td><input type="text" class="form-control form-control-sm val1"></td>
									<td></td>
									<td></td>
									<td>Unidad</td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="RPM">RPM</option>
											<option value="L/m">L/m</option>
											<option value="L/h">L/h</option>
										</select>
									</td>
								</tr>
							</table><br>
							<div class="col text-center">
								<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevaInstalacion" data-instalacion="0"><span class="mdi mdi-plus"></span> Agregar Item</button>
							</div>
						</div>
						<!-- END INSTALACIÓN -->

						<!-- FUNCIONAMIENTO -->
						<div class="tab-pane fade" id="funcionamiento" role="tabpanel" aria-labelledby="funcionamiento-tab">
							<h4 class="card-title text-center">Registro Funcionamiento</h4>

							<table class="table table-borderless table-hover table-sm">
								<tr>
									<th>Descripción</th>
									<th>MAX</th>
									<th>MIN</th>
									<th>Unidad</th>
								</tr>

								<tr class="voltajeGenerado">
									<td>Voltaje Generado</td>
									<td><input type="number" class="form-control form-control-sm max"></td>
									<td><input type="number" class="form-control form-control-sm min"></td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="mV">mV</option>
											<option value="uV">uV</option>
										</select>
									</td>
								</tr>

								<tr class="corrienteFuga">
									<td>Corriente de Fuga (Paciente)</td>
									<td><input type="number" class="form-control form-control-sm max"></td>
									<td><input type="number" class="form-control form-control-sm min"></td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="mV">mV</option>
											<option value="uV">uV</option>
											<option value="nA">nA</option>
										</select>
									</td>
								</tr>

								<tr class="potenciaIrradiada">
									<td>Potencia Irradiada</td>
									<td><input type="number" class="form-control form-control-sm max"></td>
									<td><input type="number" class="form-control form-control-sm min"></td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="W">W</option>
											<option value="VA">VA</option>
											<option value="Lux">Lux</option>
										</select>
									</td>
								</tr>

								<tr class="frecuenciaOperacion">
									<td>Frecuencia de Operación/Ritmo/Ecg</td>
									<td><input type="number" class="form-control form-control-sm max"></td>
									<td><input type="number" class="form-control form-control-sm min"></td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="ppm">ppm</option>
											<option value="bpm">bpm</option>
											<option value="ipm">ipm</option>
											<option value="Hz">Hz</option>
											<option value="kHz">kHz</option>
										</select>
									</td>
								</tr>

								<tr class="controlPresion">
									<td>Control de Presión</td>
									<td><input type="number" class="form-control form-control-sm max"></td>
									<td><input type="number" class="form-control form-control-sm min"></td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="bar">bar</option>
											<option value="Pa">Pa</option>
											<option value="kPa">kPa</option>
											<option value="PSI">PSI</option>
											<option value="mmHg">mmHg</option>
											<option value="cmH2O">cmH2O</option>
										</select>
									</td>
								</tr>

								<tr class="controlVelocidad">
									<td>Control de Velocidad/Flujo</td>
									<td><input type="number" class="form-control form-control-sm max"></td>
									<td><input type="number" class="form-control form-control-sm min"></td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="RPPM">RPPM</option>
											<option value="L/m">L/m</option>
											<option value="L/h">L/h</option>
										</select>
									</td>
								</tr>

								<tr class="pesoSoportado">
									<td>Peso Soportado</td>
									<td><input type="number" class="form-control form-control-sm max"></td>
									<td><input type="number" class="form-control form-control-sm min"></td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="Kg">Kg</option>
										</select>
									</td>
								</tr>

								<tr class="controlTemperatura">
									<td>Control de Temperatura</td>
									<td><input type="number" class="form-control form-control-sm max"></td>
									<td><input type="number" class="form-control form-control-sm min"></td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="C">°C</option>
											<option value="F">°F</option>
											<option value="K">K</option>
										</select>
									</td>
								</tr>

								<tr class="controlHumedad">
									<td>Control de Humedad</td>
									<td><input type="number" class="form-control form-control-sm max"></td>
									<td><input type="number" class="form-control form-control-sm min"></td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="%">%</option>
										</select>
									</td>
								</tr>

								<tr class="controlEnergia">
									<td>Control de Energía</td>
									<td><input type="number" class="form-control form-control-sm max"></td>
									<td><input type="number" class="form-control form-control-sm min"></td>
									<td>
										<select class="form-control form-control-sm unidad">
											<option value="NaN">Seleccione</option>
											<option value="J">J</option>
										</select>
									</td>
								</tr>
							</table><br>
							<div class="col text-center">
								<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevoFuncionamiento" data-funcionamiento="0"><span class="mdi mdi-plus"></span> Agregar Item</button>
							</div>
						</div>
						<!-- END FUNCIONAMIENTO -->

						<!-- INVIMA -->
						<div class="tab-pane fade" id="invima" role="tabpanel" aria-labelledby="invima-tab">
							<h4 class="card-title text-center">Registro Invima</h4>

							<table class="table table-borderless table-hover table-sm">
								<tr class="nuevoItemInvima nuevoItemInvima_1">
									<td>
										<select class="form-control form-control-sm" id="val1">
											<option value="NaN">Seleccione</option>
											<?php
												foreach (getInvima() as $fila) {
													echo '<option value="'.$fila['id'].'">'.$fila['tipoRegistro'].' - '.$fila['nombre'].'</option>';
												}
											?>
										</select>
									</td>
								</tr>
							</table><br>
							<div class="col text-center">
								<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevoInvima" data-invima="1"><span class="mdi mdi-plus"></span> Agregar Item</button>
							</div>
						</div>
						<!-- END INVIMA -->

						<!-- PROVEEDORES -->
						<div class="tab-pane fade" id="prove" role="tabpanel" aria-labelledby="prove-tab">
							<h4 class="card-title text-center">Proveedores</h4>

							<table class="table table-borderless table-hover table-sm">
								<tr class="nuevoItemProveedor nuevoItemProveedor_1">
									<td>
										<select class="form-control form-control-sm" id="val1">
											<option value="NaN">Seleccione</option>
											<?php
												foreach (getProveedores() as $fila) {
													echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'  ['.$fila['nit'].'] - ['.$fila['ciudad'].']</option>';
												}
											?>
										</select>
									</td>
								</tr>
							</table><br>
							<div class="col text-center">
								<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevoProveedor" data-prove="1"><span class="mdi mdi-plus"></span> Agregar Item</button>
							</div>
						</div>
						<!-- END PROVEEDORES -->

						<!-- FABRICANTES -->
						<div class="tab-pane fade" id="fabricantes" role="tabpanel" aria-labelledby="fabricantes-tab">
							<h4 class="card-title text-center">Fabricantes</h4>

							<table class="table table-borderless table-hover table-sm">
								<tr class="nuevoItemFabricante nuevoItemFabricante_1">
									<td>
										<select class="form-control form-control-sm" id="val1">
											<option value="NaN">Seleccione</option>
											<?php
												foreach (getFabricantes() as $fila) {
													echo '<option value="'.$fila['id'].'">'.$fila['nombre'].' - ['.$fila['ciudad'].']</option>';
												}
											?>
										</select>
									</td>
								</tr>
							</table><br>
							<div class="col text-center">
								<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevoFabricante" data-fabricante="1"><span class="mdi mdi-plus"></span> Agregar Item</button>
							</div>
						</div>
						<!-- END FABRICANTES -->

						<!-- VARIABLES METROLOGICAS -->
						<div class="tab-pane fade" id="variables" role="tabpanel" aria-labelledby="variables-tab">
							<h4 class="card-title text-center">Variable Metrologicas</h4>

							<table class="table table-borderless table-hover table-sm">
								<tr>
									<th>Variable</th>
									<th>Precision / Exactitud</th>
									<th>Unidad</th>
								</tr>
								<tr class="nuevoItemVariable nuevoItemVariable_1">								
									<td>
										<select class="form-control form-control-sm" id="idVariable">
											<option value="NaN">Seleccione</option>
											<?php
												foreach (getVariables() as $fila) {
													echo '<option value="'.$fila['id'].'">'.$fila['nombre'].' - ['.$fila['unidadSigno'].']</option>';
												}
											?>
										</select>
									</td>
									<td><input type="number" class="form-control form-control-sm" value="0" id="presicion"></td>
									<td>
										<select class="form-control form-control-sm" id="unidad">
											<option value="NaN">Seleccione</option>
											<option value="porcentaje">Porcentaje</option>
											<option value="numerico">Numerico</option>
										</select>
									</td>
								</tr>
							</table><br>
							<div class="col text-center">
								<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevaVariable" data-variable="1"><span class="mdi mdi-plus"></span> Agregar Item</button>
							</div>
						</div>
						<!-- END VARIABLES METROLOGICAS -->

						<!-- ACCESORIOS -->
						<div class="tab-pane fade" id="accesorios" role="tabpanel" aria-labelledby="accesorios-tab">
							<h4 class="card-title text-center">Accesorios</h4>

							<table class="table table-borderless table-hover table-sm">
								<tr>
									<th>Descripción</th>
									<th>Marca / Referencia</th>
								</tr>

								<tr class="nuevoItemAccesorio nuevoItemAccesorio_1">
									<td><input type="text" class="form-control form-control-sm" id="descripcion"></td>
									<td><input type="text" class="form-control form-control-sm" id="referencia"></td>
								</tr>
							</table><br>
							<div class="col text-center">
								<button type="button" class="btn btn-outline-secondary btn-sm text-center nuevoAccesorio" data-accesorio="1"><span class="mdi mdi-plus"></span> Agregar Item</button>
							</div>
						</div>
						<!-- END ACCESORIOS -->
					</div><br>

					<button type="button" class="btn btn-primary mr-2" id="nuevoEquipo" data-dismiss="modal">Guardar</button>
					<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
				</form>
			</div>
		</div>
	</div>
</div>