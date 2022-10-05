<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="newModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-preguntas">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear Pregunta Frecuente</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form class="forms-sample">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Pregunta</label>
						<div class="col-sm-9">
						<textarea class="form-control" id="pregunta" placeholder="Pregunta" rows="4"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Respuesta</label>
						<div class="col-sm-9">
							<textarea class="form-control" id="respuesta" placeholder="Respuesta" rows="4"></textarea>
						</div>
					</div>
					
					<button type="button" class="btn btn-primary mr-2" id="nuevaPregunta" data-dismiss="modal">Guardar</button>
					<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
				</form>
			</div>			
		</div>
	</div>
</div>