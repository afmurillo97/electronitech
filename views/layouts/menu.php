<?php
	require_once '../../controllers/permisosPlataforma.php';

	echo '
		<nav class="sidebar sidebar-offcanvas" id="sidebar">
			<div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
				<a class="sidebar-brand brand-logo" href="../dashboard/index.php"><img src="../../assets/images/template/logo-electronitech.png" alt="logo" style="width: 100%; height: 100px;"/></a>
				<a class="sidebar-brand brand-logo-mini" href="../dashboard/index.php"><img src="../../assets/images/template/logo-mini.svg" alt="logo" /></a>
			</div>

			<ul class="nav">
				<li class="nav-item profile">
					<div class="profile-desc">
						<div class="profile-pic">
							<div class="count-indicator">
								<img class="img-xs rounded-circle " src="../../assets/images/template/user.png" alt="">
								<span class="count bg-success"></span>
							</div>
							<div class="profile-name">
								<h5 class="mb-0 font-weight-normal">'.$_SESSION['nombre'].' '.$_SESSION['apellido'].'</h5>
								<span>'.$_SESSION['username'].'</span>
							</div>
						</div>
					</div>
				</li>

				<li class="nav-item menu-items">
					<a class="nav-link" href="../dashboard/index.php">
						<span class="menu-icon"><i class="mdi mdi-speedometer"></i></span>
						<span class="menu-title">Inicio</span>
					</a>
				</li>

				<li class="nav-item menu-items" '.permisosItem($_SESSION['idUsuario'], 'configuracion').'>
					<a class="nav-link" data-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="ui-basic">
						<span class="menu-icon"><i class="mdi mdi-settings"></i></span>
						<span class="menu-title">Configuración</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="collapse" id="settings">
						<ul class="nav flex-column sub-menu">
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver empresa').'><a class="nav-link" href="../configuracion/empresas.php">Empresa</a></li>
						</ul>
					</div>
				</li>

				<li class="nav-item menu-items" '.permisosItem($_SESSION['idUsuario'], 'usuarios').'>
					<a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="false" aria-controls="ui-basic">
						<span class="menu-icon"><i class="mdi mdi-account"></i></span>
						<span class="menu-title">Usuarios</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="collapse" id="users">
						<ul class="nav flex-column sub-menu">
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver permisos').'><a class="nav-link" href="../usuarios/permisos.php">Permisos</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver usuarios').'><a class="nav-link" href="../usuarios/usuarios.php">Usuarios</a></li>
						</ul>
					</div>
				</li>
				
				<li class="nav-item menu-items" '.permisosItem($_SESSION['idUsuario'], 'clientes').'>
					<a class="nav-link" href="../clientes/clientes.php" '.permisosItem($_SESSION['idUsuario'], 'ver clientes').'>
						<span class="menu-icon"><i class="mdi mdi-account-multiple"></i></span>
						<span class="menu-title">Clientes</span>
					</a>
				</li>

				<li class="nav-item menu-items" '.permisosItem($_SESSION['idUsuario'], 'proveedores').'>
					<a class="nav-link" data-toggle="collapse" href="#proveedores" aria-expanded="false" aria-controls="ui-basic">
						<span class="menu-icon"><i class="mdi mdi-webhook"></i></span>
						<span class="menu-title">Proveedores</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="collapse" id="proveedores">
						<ul class="nav flex-column sub-menu">
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver proveedores').'><a class="nav-link" href="../proveedores/proveedores.php">Proveedores</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver fabricantes').'><a class="nav-link" href="../proveedores/fabricantes.php">Fabricantes</a></li>
						</ul>
					</div>
				</li>

				<li class="nav-item menu-items" '.permisosItem($_SESSION['idUsuario'], 'gestion').'>
					<a class="nav-link" data-toggle="collapse" href="#gestion" aria-expanded="false" aria-controls="ui-basic">
						<span class="menu-icon"><i class="mdi mdi-shape-polygon-plus"></i></span>
						<span class="menu-title">Gestión</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="collapse" id="gestion">
						<ul class="nav flex-column sub-menu">
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver categorias').'><a class="nav-link" href="../gestion/categorias.php">Categorias</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver rutinas').'><a class="nav-link" href="../gestion/rutinas.php">Rutinas</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver protocolos').'><a class="nav-link" href="../gestion/protocolos.php">Protocolos</a></li>
						</ul>
					</div>
				</li>

				<li class="nav-item menu-items" '.permisosItem($_SESSION['idUsuario'], 'administrador').'>
					<a class="nav-link" data-toggle="collapse" href="#administrador" aria-expanded="false" aria-controls="ui-basic">
						<span class="menu-icon"><i class="mdi mdi-account-key"></i></span>
						<span class="menu-title">Administrador</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="collapse" id="administrador">
						<ul class="nav flex-column sub-menu">
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver tipoVariable').'><a class="nav-link" href="../administrador/tipoVariables.php">Tipos de Variables M.</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver variable').'><a class="nav-link" href="../administrador/variables.php">Variables Metrológicas</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver grupoServicio').'><a class="nav-link" href="../administrador/grupoServicio.php">Grupo Servicios H.</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver servicios').'><a class="nav-link" href="../administrador/servicios.php">Servicios Hospitalarios</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver registros').'><a class="nav-link" href="../administrador/registros.php">Registros INVIMA</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver marcas').'><a class="nav-link" href="../administrador/marcas.php">Marcas</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver modelos').'><a class="nav-link" href="../administrador/modelos.php">Modelos</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver manifiestos').'><a class="nav-link" href="../administrador/manifiestos.php">Manifiestos de Importación</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver ecri').'><a class="nav-link" href="../administrador/ecri.php">ECRI</a></li>
						</ul>
					</div>
				</li>

				<li class="nav-item menu-items" '.permisosItem($_SESSION['idUsuario'], 'equipos').'>
					<a class="nav-link" data-toggle="collapse" href="#equipos" aria-expanded="false" aria-controls="ui-basic">
						<span class="menu-icon"><i class="mdi mdi-television"></i></span>
						<span class="menu-title">Equipos</span>
						<i class="menu-arrow"></i>
					</a>
					<div class="collapse" id="equipos">
						<ul class="nav flex-column sub-menu">
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver descripcion').'><a class="nav-link" href="../equipos/descripcion.php">Descripción Biomedica</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver tipoEquipo').'><a class="nav-link" href="../equipos/tipoEquipo.php">Tipos de Equipo</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver equipos').'><a class="nav-link" href="../equipos/equipos.php">Equipos</a></li>
							<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver articulos').'><a class="nav-link" href="../equipos/articulos.php">Artículos</a></li>
						</ul>
					</div>
				</li>

				<li class="nav-item menu-items" '.permisosItem($_SESSION['idUsuario'], 'pagina').'>
				<a class="nav-link" data-toggle="collapse" href="#pagina" aria-expanded="false" aria-controls="ui-basic">
					<span class="menu-icon"><i class="mdi mdi-store"></i></span>
					<span class="menu-title">Página Web</span>
					<i class="menu-arrow"></i>
				</a>
				<div class="collapse" id="pagina">
					<ul class="nav flex-column sub-menu">
						<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver datos').'><a class="nav-link" href="../paginaWeb/datos.php">Datos del Sitio</a></li>
						<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver contactos').'><a class="nav-link" href="../paginaWeb/contactos.php">Contactos del Sitio</a></li>
						<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver pqrf').'><a class="nav-link" href="../paginaWeb/pqrf.php">PQRF del Sitio</a></li>
						<li class="nav-item" '.permisosItem($_SESSION['idUsuario'], 'ver preguntas').'><a class="nav-link" href="../paginaWeb/preguntas.php">Preguntas del Sitio</a></li>
					</ul>
				</div>
			</li>
			</ul>
		</nav>
	';
?>