<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>PQRF's - Electronitech</title>
  <meta content="mantenimiento preventivo, correctivo y venta de equipos médicos" name="description">
  <meta content="servicio tecnico de equipos medicos, venta y alquiler de equipos medicos, metrologia, ayudas ortopedicas, diagnostico medico, cirugia, mobiliario medico, uci, hospitalizacion" name="keywords">

  <?php include_once "layouts/head.php" ?>
</head>

<body>

  <!-- ======= Header ======= -->
  <?php include_once "layouts/header.php" ?>
  <!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>PQRF's</h2>
          <ol>
            <li><a href="index.php">Inicio</a></li>
            <li>PQRF's</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
      <div class="container">
        <div class="section-title">
          <h2>Peticiones, Quejas, Reclamos y Felicitaciones</h2>
          <p>Con el fin de brindarle un mejor servicio, Electronitech pone a su disposición el sistema de Peticiónes, Quejas, Reclamos y Felicitaciónes, en donde nos puede manifestar su opinión sobre nuestros servicios. Daremos respuesta a la PQR dentro de los 5 días hábiles siguientes a su presentación.</p>
        </div>
      </div>

      <div class="container">

        <form action="" method="POST" role="form" class="php-email-form">
          <div class="row">
            <div class="col-md-6 form-group mt-3">
              <input type="number" name="documento" class="form-control" id="documento" placeholder="Tu número de documento" required>
            </div>
            <div class="col-md-6 form-group mt-3">
              <select class="form-select" style="color:gray;" aria-label="Default select example" id="">
                <option selected>Tipo de Documento</option>
                <option value="1">Cedula de Ciudananía</option>
                <option value="2">Cedula de Extrangería</option>
                <option value="3">Tarjeta de Identidad</option>
                <option value="4">NIT</option>
              </select>
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Tu nombre completo" required>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Tu dirección" required>
          </div>
          <div class="row mt-3">
            <div class="col-md-6 form-group mt-3">
              <input type="number" name="telefono" class="form-control" id="telefono" placeholder="Tu número de teléfono" required>
            </div>
            <div class="col-md-6 form-group mt-3">
            <input type="mail" name="correo" class="form-control" id="correo" placeholder="Tu Correo" required>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-6 form-group mt-3">
              <select class="form-select" style="color:gray;" aria-label="Default select example" name="tipo de soliciud" id="tipoSoliciud">
                <option selected>Tipo de Solicitud</option>
                <option value="1">Petición</option>
                <option value="2">Queja</option>
                <option value="3">Reclamo</option>
                <option value="4">Felicitación</option>
              </select>
            </div>
            <div class="col-md-6 form-group mt-3">
             <select class="form-select" style="color:gray;" aria-label="Default select example" name="motivo de soliciud" id="motivoSoliciud">
                <option selected>Motivo de Solicitud</option>
                <option value="1">Calidad del Servicio</option>
                <option value="2">Tiempo de Entrega</option>
                <option value="3">Requisitos técnicos</option>
                <option value="4">Otro...</option>
              </select>
            </div>
          </div>
          <div class="form-group mt-3">
            <input type="text" class="form-control" name="asunto" id="asunto" placeholder="Asunto" required>
          </div>
          <div class="form-group mt-3">
            <textarea class="form-control" name="mensaje" id="mensaje" rows="5" placeholder="Deja un relato claro de los hechos..." required></textarea>
          </div>
          <div class="form-group mt-3">
            <label style="color:gray;">Adjuntar documentos:</label>
            <input type="file" class="form-control" name="documentos" id="documentos" placeholder="Asunto" required>
          </div>
          <br/>
          <div class="form-check form-switch text-center">
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
            <label class="form-check-label" for="flexSwitchCheckDefault">Autorizo el tratamiento de mis datos personales conforme a la política de protección de datos la organización (<a href="documents.php" target="_blank">Ver documentos</a>)</label>
          </div>
          <br/>
          <div class="text-center"><button type="submit" class="btn btn-dark">Enviar</button></div>
        </form>

        <br/>
        <div class="container">
          <h2>Ten en cuenta que...</h2>
          <p><strong>Petición:</strong> Es el derecho que tienen todas las personas para presentar o formular una solicitud relacionada con los asuntos que legalmente le competan a la Organización.</p>
          <p><strong>Queja:</strong> Es la manifestación de descontento o inconformidad que realiza una persona ante los productos o servicios recibidos por la organización.</p>
          <p><strong>Reclamo:</strong> Aquella exigencia que se realiza de manera respetuosa con el fin de encontrar una solución relacionada con la prestación inadecuada de un servicio o a la falta de atención de una solicitud.</p>
          <p><strong>Felicitación:</strong> Una manifestación que expresa el agrado o satisfacción con un empleado o con el proceso que genera el servicio.</p>
        </div>

</div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include_once "layouts/footer.php" ?>
  <!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include_once "layouts/scripts.php" ?>

</body>

</html>