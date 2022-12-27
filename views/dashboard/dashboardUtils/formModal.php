<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-mantenimientos">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear Mantenimiento</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Cliente</label>
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

						<div class="col" id="direcciones"><label>Dirección</label></div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group">
								<label class="col-sm-4 col-form-label">Fecha Inicial</label>
								<div class="col-sm-8">
									<input type="date" class="form-control" id="fechaInicial">
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Fecha Final</label>
								<div class="col-sm-9">
									<input type="date" class="form-control" id="fechaFinal">
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Frecuencia</label>
								<div class="col-sm-9">
									<input type="number" class="form-control" id="frecuencia" value="1">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col" id="articulos"></div>
					</div>

					<button type="button" class="btn btn-primary mr-2" id="nuevoCronograma" data-dismiss="modal">Guardar</button>
					<button class="btn btn-dark" onclick="history.back();">Cancelar</button>

				</form>
			</div>
		</div>
	</div>
</div>