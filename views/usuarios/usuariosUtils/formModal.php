<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="newModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-usuarios">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear Usuario</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form class="forms-sample">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Nombres</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="nombres" placeholder="Nombres">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Apellidos</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="apellidos" placeholder="Apellidos">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Identificación</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="identificacion" placeholder="Identificacion">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Usuario</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="username" placeholder="Usuario">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Contraseña</label>
						<div class="col-sm-9">
							<input type="password" class="form-control" id="password" placeholder="Contraseña">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">E-mail</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="email" placeholder="E-mail">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Cargo</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="cargo" placeholder="Cargo">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Celular</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="celular" placeholder="Celular">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Firma Digital</label>
						<div class="col-sm-9">
							<input type="file" class="form-control" id="firmaDigital">
						</div>
					</div>
					<button type="button" class="btn btn-primary mr-2" id="nuevoUsuario" data-dismiss="modal">Guardar</button>
					<button class="btn btn-dark" onClick="history.back();">Cancelar</button>
				</form>
			</div>			
		</div>
	</div>
</div>