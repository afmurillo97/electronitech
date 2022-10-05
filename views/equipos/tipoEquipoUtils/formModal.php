<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="newModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-tipoEquipo">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear Tipo de Equipo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form class="forms-sample">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Tipo de Equipo</label>
						<div class="col-sm-9">
							<select id="idEcri" class="form-control selectSearch" placeholder="Seleccione un tipo de Equipo"></select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Nivel de Riesgo</label>
						<div class="col-sm-9">
							<select class="form-control" id="riesgo">
								<option value="-1">Seleccione</option>
								<option value="noAplica">NO APLICA</option>
								<option value="I">I</option>
								<option value="IIA">IIA</option>
								<option value="IIB">IIB</option>
								<option value="III">III</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Descripción Biomedica</label>
						<div class="col-sm-9">
							<select class="form-control" id="idDescripcionBiomedica">
								<option value="-1">Seleccione</option>
								<?php 
									foreach (getDescripcion() as $fila) {
										echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Protocolo de Mantenimiento</label>
						<div class="col-sm-9">
							<select class="form-control" id="idProtocolo">
								<option value="-1">Seleccione</option>
								<?php 
									foreach (getProtocolo() as $fila) {
										echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Validación</label>
						<div class="col-sm-9">
							<select class="form-control" id="validacion">
								<option value="-1">Seleccione</option>
								<option value="si">SI</option>
								<option value="no">NO</option>
							</select>
						</div>
					</div>
					
					<button type="button" class="btn btn-primary mr-2" id="nuevoTipoEquipo" data-dismiss="modal">Guardar</button>
					<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
				</form>
			</div>			
		</div>
	</div>
</div>