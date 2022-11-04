<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="newModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-rutinas">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear Rutina</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form class="forms-sample">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Categoria</label>
						<div class="col-sm-9">
							<select class="form-control" id="idCategoria">
								<option value="-1">SELECCIONE</option>
								<?php 
									foreach (getCategorias() as $fila) {
										echo '<option value="'.$fila['id'].'">'.$fila['descripcion'].'</option>';
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Descripcion:</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="descripcion" rows="4" placeholder="Descripción"></textarea>
						</div>
					</div>
					<button type="button" class="btn btn-primary mr-2" id="nuevaRutina" data-dismiss="modal">Guardar</button>
					<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
				</form>
			</div>
		</div>
	</div>
</div>