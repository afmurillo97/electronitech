<!-- ICONOS -->
<link rel="stylesheet" href="../../assets/css/materialdesignicons.min.css">
<!-- ESTILOS -->
<link rel="stylesheet" href="../../assets/css/style.css">
<!-- FAVICON -->
<link rel="shortcut icon" href="../../assets/images/template/favicon.png" />
<!-- FUNCIONES DE JAVA SCRIPT -->
<script src="../../assets/js/vendor.bundle.base.js"></script>
<script src="../../assets/js/off-canvas.js"></script>
<script src="../../assets/js/misc.js"></script>
<script src="../../assets/js/jquery.min.js"></script>
<link rel="stylesheet" href="https://www.bootstrapdash.com/demo/corona/jquery/template/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<script src="https://www.bootstrapdash.com/demo/corona/jquery/template/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="https://www.bootstrapdash.com/demo/corona/jquery/template/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script>
    $(document).ready(function () {
        $('.sort').DataTable({
            searching: false,
            paging: false,
            info: false,
            ordering: true,

            columnDefs: [{
                orderable: false,
                targets: "no-sort"
            }]
        });
    });

    $(document).keypress(
        function(event){
            if (event.which == '13') {
                event.preventDefault();
            }
        }
    );
</script>