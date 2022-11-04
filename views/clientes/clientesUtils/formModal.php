<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-clientes">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Crear Cliente</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Nombre</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="nombre" placeholder="Nombre">
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Nit</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="nit" placeholder="Nit">
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-6 col-form-label">Código REPS</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="codigo" placeholder="Código REPS">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group">
								<label class="col-sm-6 col-form-label">Naturaleza Jurídica</label>
								<div class="col-sm-9">
									<select class="form-control" id="juridica">
										<option value="-1">SELECCIONE</option>
										<option value="PUBLICA">PUBLICA</option>
										<option value="MIXTA">MIXTA</option>
										<option value="PRIVADA">PRIVADA</option>
									</select>
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Representante</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" id="representante" placeholder="Representante">
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Télefono</label>
								<div class="col-sm-9">
									<input type="number" class="form-control" id="telefono" placeholder="Telefono">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Celular</label>
								<div class="col-sm-9">
									<input type="number" class="form-control" id="celular" placeholder="Celular">
								</div>
							</div>
						</div>

						<div class="col direcciones">
							<div class="form-group">
								<label class="col-sm-3 col-form-label"></label>
								<div class="row col-sm-9 form-inline">
									<div class="form-row">
										<div class="form-group col-sm-6">
											<label for="">Dirección</label>
											<input type="text" class="form-control col-sm-12" id="direccion_1" placeholder="Dirección">
										</div>
										<div class="form-group col-sm-5">
											<label for="">Ciudad</label>
											<input type="text" class="form-control col-sm-12" id="ciudad_1" placeholder="Ciudad">
										</div>
										<div class="form-group col-sm-1">
											<button type="button" class="btn btn-primary nuevaDireccion" data-numero="1">+</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">E-mail</label>
								<div class="col-sm-9">
									<input type="email" class="form-control" id="email" placeholder="E-mail">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Observación</label>
								<div class="col-sm-11">
									<textarea class="form-control" id="observacion" placeholder="Observación" rows="3"></textarea>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Logo</label>
								<div class="col-sm-9">
									<input type="file" class="form-control" id="logo">
								</div>
							</div>
						</div>

						<div class="col">
							<div class="form-group">
								<label class="col-sm-3 col-form-label">Encabezado</label>
								<div class="col-sm-9">
									<select class="form-control" id="encabezado">
										<option value="NO">NO</option>
										<option value="SI">SI</option>
									</select>
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