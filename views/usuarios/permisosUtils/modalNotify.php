<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modalCreateSuccess">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content text-center">
            <h1 style="font-size: 4em;"><i class="mdi mdi-check text-success"></i></h1>
            <h3>Permiso creado correctamente.</h3>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modalEditSuccess">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content text-center">
            <h1 style="font-size: 4em;"><i class="mdi mdi-check text-success"></i></h1>
            <h3>Permiso actualizado correctamente.</h3>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modalDanger">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content text-center">
            <h1 style="font-size: 4em;"><i class="mdi mdi-window-close text-danger"></i></h1>
            <h3>Ha ocurrido un error inesperado.</h3>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-sm modalWarning" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content text-center modal-delete">
            <h1 style="font-size: 4em;">
                <i class="mdi mdi-comment-question-outline text-warning"></i>
            </h1>
            <h3>¿Desea eliminar el Permiso?</h3>
            <div class="modal-body">
                <button type="button" class="btn btn-primary mr-2" id="eliminarPermiso" data-dismiss="modal">Eliminar</button>
			    <button class="btn btn-dark" onClick="history.back();">Cancelar</button>
            </div>
        </div>
    </div>
</div>