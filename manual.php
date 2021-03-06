<?php
include_once ("funciones/generales.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <!--EVITAR EL CACHEO-->
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
  <!--FIN EVITAR EL CACHEO-->
  <title><?= titulo();?></title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="shortcut icon" type="image/png" href="images/logo32.png"/>
  <!--
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <!-- Archivo para el ojo del input -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- =======================================================
  * Template Name: Vesperr - v2.0.0
  * Template URL: https://bootstrapmade.com/vesperr-free-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <!-- SweetAlert2 -->
  <script src="admin/plugins/sweetalert2/sweetalert2.min.js"></script>

  <script languaje="javascript" src="funciones/generales.js"></script>
  
)

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">

      <div class="logo mr-auto">
        <h1 class="text-light"><a href="index.php"><span>Turnfy</span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      </div>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li class="active"><a href="index.php#header">Home</a></li>
          <li><a href="index.php#about">App</a></li>
          <li><a href="index.php#services">Servicios</a></li>
          <li><a href="index.php#login">Iniciar Sesi??n</a></li>
          <!--<li><a href="index.php#contact">Contacto</a></li>-->

          <li class="get-started"><a href="index.php#register">Registrarse</a></li>
        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <div id="sup">
      <br><br><br><br><br><br>
    </div>
    <section id="login" class="login">

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Manual</h2>
        </div>
        <?php
        $tamano = 200;
        ?>
        <div class="row">
          <div data-aos="fade-up" data-aos-delay="150" class="col-12 col-sm-12 pl-3 pr-3">
            <p>
            Turnfy es una aplicaci??n desarrollada especialmente para las nuevas necesidades provocadas por el COVID-19 en las que requieran controlar el aforo por turnos a cualquier establecimiento. 
            Es una herramienta que adem??s ayuda a tener un control estad??stico muy potente sobre las ganancias y los asistentes a tu negocio, sobre todo est?? enfocado al sector de la hosteler??a pero aplicable a cualquier otro comercio que reciba clientes, pueda tener ventas a esos clientes, y requiera controlar el aforo al establecimiento.
            Tambi??n existe un log sobre los usuarios que realizan actividad sobre las franjas horarias y turnos asociados a tu empresa, por lo que se obtienen datos orientativos del uso de la aplicaci??n por parte de los trabajadores del comercio.
            En primer lugar la empresa tiene que registrarse rellenando los siguientes datos y seleccionar el sector en el que m??s encaje, si no utilizar el sector gen??rico otros.
            <div class="col-12 col-sm-12">
              <img src="images/registro.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">
            </div>
            </p>
            <p>
            Una vez nos registramos correctamente, accedemos a la pantalla principal donde se indican un resumen diario sobre las ganancias, franjas horarias, turnos y actividades de los usuarios de la empresa (que corresponden a los trabajadores). Adem??s las franjas horarias se archivar??n autom??ticamente a los 14 d??as de vencer.
            <div class="col-12 col-sm-12">
              <img src="images/inicio.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">
            </div>
            </p>
            <p>
            Hay tres tipos de usuarios:
            <ul>
              <li><i class="ri-check-double-line"></i> La empresa es el superusuario indicado para el propietario y el ??nico que tiene el control total como poder ver las estad??sticas y las actividades del resto de usuarios. Podr?? crear usuarios con menos privilegios, s??lo puede haber 1.</li>
              <li><i class="ri-check-double-line"></i> Usuario que pueda crear franjas horarias (este usuario ser??a por ejemplo para un mando intermedio entre el propietario de la empresa y los trabajadores finales) que puede crear las franjas horarias y otros usuarios, adem??s de registrar turnos y reservas.</li>
              <li><i class="ri-check-double-line"></i> El usuario sin este privilegio ??nicamente puede registrar turnos y reservas sobre las franjas horarias definidas por los anteriores usuarios.</li>
            </ul>

            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/menu_empresa.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/menu_usuario.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/menu_usuario2.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">
            </div>
            </p>
            <p>
            Usuarios, es posible crear usuarios que realicen actividades sobre las franjas horarias de nuestra empresa, siempre se mostrar?? el usuario y la contrase??a ya que siempre ser?? a nivel interno, y nunca podr??n darse de alta desde otro lugar de la aplicaci??n.
            
            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/usuarios1.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/usuarios2.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/usuarios3.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">
            </div>
            </p>
            <p>
            Franjas Horarias, ser??n dadas de alta por la cuenta de la empresa o el/los usuarios acreditados como se muestra anteriormente. 
            Se debe proporcionar el intervalo de horas a medir de 07:00 a 10:00h por ejemplo y una descripci??n 'desayunos' en el caso de un bar, 
            si se utilizar?? la gesti??n de turnos y reservas dejar vac??os ganancias y asistentes ya que se calcular??n autom??ticamente despu??s, de lo contrario introducirlos manualmente, 
            estos campos son los m??s importantes ya que nos facilitar??n las estad??sticas, pueden omitirse uno o ambos (no habr?? estad??sticas).
            Es posible repetir una franja horaria hasta 7 d??as, comenzando por el d??a actual + los siguientes 6 d??as. Una vez finalizada la franja horaria es recomendable archivar del bot??n 'x'.
          
            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/franja1.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/franja2.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/franja3.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">
            </div>
            </p>
            <p>
            Turnos, elegimos primero una de las franjas horarias que est??n creadas para hoy, con el bot??n + a??adimos un turno donde se podr??n insertar los siguientes datos: 
            <ul>
              <li><i class="ri-check-double-line"></i> Descripci??n o n??mero de mesa aparecer?? en el resumen del turno</li>
              <li><i class="ri-check-double-line"></i> N??mero de personas que acceden con ese turno, si es individual marcar 1, y para actividad con varias personas por turno por ejemplo un turno para un bar, indicar las personas totales</li>
              <li><i class="ri-check-double-line"></i> El nombre de la reserva indicar el nombre de la persona que solicita el turno, a gusto del consumidor si nombre y apellidos o s??lo nombre</li>
              <li><i class="ri-check-double-line"></i> Descripci??n larga o comanda, opci??n para indicar una gran cantidad de datos</li>
              <li><i class="ri-check-double-line"></i> Cuenta, est?? previsto rellenar este dato al final del turno cuando se ha recibido el cobro de la cuenta del cliente</li>
            </ul>
            Se podr?? listar los turnos por diferentes filtros, seg??n requiera cada momento el usuario
            <ul>
              <li><i class="ri-check-double-line"></i> <span id="logoActivos" class="fas fa-book-open"></span> Muestra todos los turnos, primero los que est??n en progreso y despu??s los que est??n en espera.</li>
              <li><i class="ri-check-double-line"></i> <span id="logoUsuario" class="fas fa-user"></span> Muestra los turnos modificados recientemente por el usuario</li>
              <li><i class="ri-check-double-line"></i> <span id="logoEliminados" class="fas fa-utensils"></span> o <span id="logoEliminados" class="fas fa-check"></span> Muestra los turnos que est??n en proceso</li>
              <li><i class="ri-check-double-line"></i> <span id="logoEliminados" class="fas fa-trash"></span> Muestra los turnos que se han proceso y enviados a la papelera</li>
            </ul>
            
            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/turnos1.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/turnos2.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <div class="col-12 col-sm-4 d-sm-inline d-inline">
              <img src="images/turnos3.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400" width="<?= $tamano ?>">
            </div>
            </p>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="row d-flex align-items-center">
        <div class="col-lg-6 text-lg-left text-center">
          <div class="copyright">
             &copy; Copyright <strong>Turnfy</strong>. All Rights Reserved
          </div>
          <!--
          <div class="credits">
                          -->
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/vesperr-free-bootstrap-template/ -->
            <!--Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
          </div>-->
        </div>
        <div class="col-lg-6">
          <nav class="footer-links text-lg-right text-center pt-2 pt-lg-0">
            <a href="index.php#intro" class="scrollto">Home</a>
            <a href="index.php#about" class="scrollto">App</a>
            <a href="index.php#">Pol??tica de privacidad</a>
            <a href="index.php#">Condiciones de servicio</a>
          </nav>
        </div>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>