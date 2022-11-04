<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="newModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-registros">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear Registro</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form class="forms-sample">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Tipo de Registro</label>
						<div class="col-sm-9">
							<select class="form-control" id="tipoRegistro">
								<option value="-1">SELECCIONE</option>
								<option value="REGISTRO SANITARIO">REGISTRO SANITARIO</option>
								<option value="PERMISO DE COMERCIALIZACION">PERMISO DE COMERCIALIZACION</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Registro INVIMA</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="nombre" placeholder="Nombre de Documento">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Documento</label>
						<div class="col-sm-9">
							<input type="file" class="form-control" id="documento">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Descripción</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="descripcion" placeholder="Descripción" rows="4"></textarea>
						</div>
					</div>
					
					<button type="button" class="btn btn-primary mr-2" id="nuevoRegistro" data-dismiss="modal">Guardar</button>
					<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
				</form>
			</div>			
		</div>
	</div>
</div>