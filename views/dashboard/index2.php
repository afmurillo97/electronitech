<?php
	session_start();
	if (!isset($_SESSION['idUsuario']) || $_SESSION['idUsuario'] == NULL) {
		print "<script>alert(\"Acceso invalido!\"); window.location='../../index.php';</script>";
	}	
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Panel Admin</title>
	<!-- HEAD -->
	<?php include_once '../layouts/head.php'; ?>

	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">


	<link rel="stylesheet" href="../../calendario/fonts/icomoon/style.css">

	<link href='../../calendario/fullcalendar/packages/core/main.css' rel='stylesheet' />
	<link href='../../calendario/fullcalendar/packages/daygrid/main.css' rel='stylesheet' />


	<!-- Bootstrap CSS -->
	<!-- <link rel="stylesheet" href="../../calendario/css/bootstrap.min.css"> -->

	<!-- Style -->
	<link rel="stylesheet" href="../../calendario/css/style.css">

	<script src="indexUtils/functions.js"></script>
	<!-- END HEAD -->

</head>
<body>

	<!-- <script src="../../calendario/js/jquery-3.3.1.min.js"></script> -->
    <script src="../../calendario/js/popper.min.js"></script>
    <script src="../../calendario/js/bootstrap.min.js"></script>

    <script src='../../calendario/fullcalendar/packages/core/main.js'></script>
    <script src='../../calendario/fullcalendar/packages/interaction/main.js'></script>
    <script src='../../calendario/fullcalendar/packages/daygrid/main.js'></script>
    <script src='../../calendario/fullcalendar/packages/timegrid/main.js'></script>
    <script src='../../calendario/fullcalendar/packages/list/main.js'></script>

	<div class="container-scroller">
		<!-- MENU -->
		<?php include_once '../layouts/menu.php'; ?>
		<!-- END MENU -->

		<!-- CONTENEDOR -->
		<div class="container-fluid page-body-wrapper">
			<!-- HEADER -->
			<?php include_once '../layouts/header.php'; ?>
			<!-- END HEADER -->

			<!-- BODY PAGE -->
			<div class="main-panel">
				<div class="content-wrapper">
					<div class="page-header">
						<h3 class="page-title">Panel de Mantenimientos</h3>
						<nav aria-label="breadcrumb">
						<?php
							echo '
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg" '.permisosItem($_SESSION['idUsuario'], 'crear clientes').'>
									<span class="mdi mdi-plus"></span>
								</button>
							';
						?>
						</nav>
			  		</div>
					<div class="row">
						<div class="col-xl-12 col-sm-12 grid-margin stretch-card">
							<div class="card">
								<!--  -->

								<ul class="nav nav-tabs" id="myTab" role="tablist">
									<li class="nav-item" role="presentation">
										<a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Calendario</a>
									</li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Lista</a>
									</li>
								</ul>
								<div class="tab-content" id="myTabContent">
									<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
										<div id="calendar-container">
											<div id="calendar"></div>
										</div>
										
										<script>
											document.addEventListener('DOMContentLoaded', function() {
												var calendarEl = document.getElementById('calendar');

												var calendar = new FullCalendar.Calendar(calendarEl, {
													plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
													height: 'parent',
													header: {
														left: 'prev, next today',
														center: 'title',
														right: 'dayGridMonth, timeGridWeek, timeGridDay, listWeek'
													},
													locale: 'es',
													defaultView: 'dayGridMonth',
													defaultDate: '2020-02-12',
													navLinks: true, // can click day/week names to navigate views
													editable: true,
													eventLimit: true, // allow "more" link when too many events
													events: [
														{
															id: '1',
															title: 'All Day Event',
															start: '2020-02-01',
														},
														{
															title: 'Long Event',
															start: '2020-02-07',
															end: '2020-02-10'
														},
														{
															groupId: 999,
															title: 'Repeating Event',
															start: '2020-02-09T16:00:00'
														},
														{
															groupId: 999,
															title: 'Repeating Event',
															start: '2020-02-16T16:00:00'
														},
														{
															title: 'Conference',
															start: '2020-02-11',
															end: '2020-02-13'
														},
														{
															title: 'Meeting',
															start: '2020-02-12T10:30:00',
															end: '2020-02-12T12:30:00'
														},
														{
															title: 'Lunch',
															start: '2020-02-12T12:00:00'
														},
														{
															title: 'Meeting',
															start: '2020-02-12T14:30:00'
														},
														{
															title: 'Happy Hour',
															start: '2020-02-12T17:30:00'
														},
														{
															title: 'Dinner',
															start: '2020-02-12T20:00:00'
														},
														{
															title: 'Birthday Party',
															start: '2020-02-13T07:00:00'
														},
														{
															title: 'fiesta cumpleaños',
															start: '2020-02-13T09:00:00'
														},
														{
															title: 'Click for Google',
															url: 'http://google.com/',
															start: '2020-02-28'
														}
													]
												});
												calendar.render();
											});
										</script>
										<script src="../../calendario/js/main.js"></script>
									</div>

									<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
										lista
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END BODY PAGE -->
				
				<!-- MODAL -->
				<?php include_once 'dashboardUtils/formModal.php'; ?>
				<!-- MODAL -->

				<!-- MODAL NOTIFY -->
				<?php include_once 'dashboardUtils/modalNotify.php'; ?>
				<!-- END MODAL NOTIFY -->

				<!-- FOOTER -->
				<?php include_once '../layouts/footer.php'; ?>
				<!-- END FOOTER -->
			</div>
		</div>
		<!-- END CONTENEDOR -->
	</div>
</body>
</html>