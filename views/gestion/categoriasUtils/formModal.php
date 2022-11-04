<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="newModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-categorias">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear Categoria</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form class="forms-sample">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Nivel</label>
						<div class="col-sm-9">
							<select class="form-control" id="nivel">
								<option value="-1">SELECCIONE</option>
								<option value="ARRIBA">ARRIBA</option>
								<option value="MEDIO">MEDIO</option>
								<option value="ABAJO">ABAJO</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Descripcion:</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="descripcion" rows="4" placeholder="Descripción"></textarea>
						</div>
					</div>
					<button type="button" class="btn btn-primary mr-2" id="nuevaCategoria" data-dismiss="modal">Guardar</button>
					<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
				</form>
			</div>			
		</div>
	</div>
</div>