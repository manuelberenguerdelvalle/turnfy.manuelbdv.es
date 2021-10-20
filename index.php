<?php
include_once ("class/mysql.php");
include_once ("funciones/generales.php");
session_start();
$_SESSION['pagina'] = "index";
$_SESSION['intentos'] = 0;
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
          <li class="active"><a href="#header">Home</a></li>
          <li><a href="#about">App</a></li>
          <li><a href="#services">Servicios</a></li>
          <li><a href="#login">Iniciar Sesión</a></li>
          <!--<li><a href="#contact">Contacto</a></li>-->

          <li class="get-started"><a href="#register">Registrarse</a></li>
        </ul>
      </nav><!-- .nav-menu -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Clients Section ======= -->
    <!--
    <section id="clients" class="clients clients">
      <div class="container">

        <div class="row">

          <div class="col-lg-2 col-md-4 col-6">
            <img src="assets/img/clients/client-1.png" class="img-fluid" alt="" data-aos="zoom-in">
          </div>

          <div class="col-lg-2 col-md-4 col-6">
            <img src="assets/img/clients/client-2.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="100">
          </div>

          <div class="col-lg-2 col-md-4 col-6">
            <img src="assets/img/clients/client-3.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="200">
          </div>

          <div class="col-lg-2 col-md-4 col-6">
            <img src="assets/img/clients/client-4.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="300">
          </div>

          <div class="col-lg-2 col-md-4 col-6">
            <img src="assets/img/clients/client-5.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="400">
          </div>

          <div class="col-lg-2 col-md-4 col-6">
            <img src="assets/img/clients/client-6.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="500">
          </div>

        </div>

      </div>
    </section>
    -->
    <!-- End Clients Section -->
    <!-- ======= Login Section ======= -->

    <div id="sup">
      <br><br>
    </div>
    <div class="row">
      <div class="col-4 col-sm-4">
      </div>
      <div class="col-4 col-sm-4 d-flex d-sm-flex align-items-center align-items-sm-center justify-content-center justify-content-sm-center">
        <img src="images/logo128.png" class="img-responsive" alt="" data-aos="zoom-in" data-aos-delay="400">
      </div>
    </div>
    <div class="text-center text-sm-center italic text-info" data-aos="zoom-in" data-aos-delay="400">
      Prueba <em>usuario: ejemplo</em> y <em>contraseña: ejemplo</em>
    </div>
    <section id="login" class="login">
      <div class="container">

        <div class="row content">
            <div class="col-sm-12 col-md-9 col-lg-7 mx-auto float-right">
              <!--<div class="card card-signin my-5">-->
                <div class="card-body" data-aos="fade-up">
                  <h5 class="card-title text-center">
                    <span id="text_iniciar_sesion" class="letra_logo">Iniciar sesión</span>
                  </h5>
                  <form class="form-signin" id="formLogin" method="POST">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="iconoArroba">@</span>
                        </div>
                        <input name="usuario" type="text" class="form-control" id="usuario" placeholder="Usuario" aria-describedby="inputGroupPrepend" minlength="1" required autofocus> 
                      </div>
                    </div>
      
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <span id="iconoOjo" class="fa fa-eye-slash icon" onclick="verOcultarPass('#iconoOjo','password');"></span>
                          </span>
                        </div>
                        <input name="password" type="password" class="form-control" id="password" placeholder="Contraseña" minlength="1" required> 
                      </div>
                    </div>
      
                    <div class="custom-control custom-checkbox mb-3">
                      <input type="checkbox" class="custom-control-input" id="customCheck1">
                      <label class="custom-control-label" for="customCheck1">Recordar password</label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block text-uppercase" type="button" onclick="iniciar_sesion()">Iniciar sesión</button>
                    <a class="btn btn-lg border-primary btn-block text-uppercase" href="#register">Registrarse</a>
                    <div class="text-center mt-3 mb-3">¿Olvidaste tu contraseña?</div>
                  </form>
                </div>
              <!--</div>-->
            </div>
        </div>

      </div>

      
    </section><!-- End Login Us Section -->

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>App</h2>
        </div>

        <div id="hero" class="row">
          <div class="col-12 col-sm-6 pl-2 align-content-center">
            <div class="pl-3 order-2 order-lg-1 justify-content-center align-content-center">
              <h1 data-aos="fade-up">Gestión de franjas horarias con reservas y turnos en tiempo real para tu negocio</h1>
              <h2 data-aos="fade-up" data-aos-delay="200">Podrás saber cuales son las horas más productivas para tu negocio. Gestión de turnos y reservas para la nueva situación del Covid-19.</h2>
            </div>
          </div>
          <div class="col-12 col-sm-6 align-content-center justify-content-center">
            <div class="order-1 order-lg-2 hero-img d-flex flex-column" data-aos="fade-left" data-aos-delay="400">
              <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
            </div>
          </div>
        </div>

        <div class="row content">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="150">
            <p>
              Podrás utilizar esta app en bares, restaurantes, tiendas, en general para casi cualquier negocio que reciba clientes.
            </p>
            <ul>
              <li><i class="ri-check-double-line"></i> Podrás controlar las reservas de las mesas para los diferentes turnos de servicio</li>
              <li><i class="ri-check-double-line"></i> Saber el aforo por turno de servicio</li>
              <li><i class="ri-check-double-line"></i> Añadir comandas</li>
            </ul>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0" data-aos="fade-up" data-aos-delay="300">
            <p>
              Gracias a la completa vista de estadísticas podrás anticiparte a la demanda de personal y clientela.
            </p>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Servicios</h2>
          <p>Tendrás una alta capacidad estadística de tu negocio</p>
        </div>

        <div class="row">
          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
              <div class="icon"><i class="bx bxl-dribbble"></i></div>
              <h4 class="title"><a href="">Turnos</a></h4>
              <p class="description">Podrás configurar todos los turnos que necesites con la franja horaria de las 00:00 a 24:00.</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
              <div class="icon"><i class="bx bx-file"></i></div>
              <h4 class="title"><a href="">Ganancias</a></h4>
              <p class="description">Podrás conocer las estadísticas de tus ganancias anual, mensual, semanal y diariamente.</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
              <div class="icon"><i class="bx bx-tachometer"></i></div>
              <h4 class="title"><a href="">Asistencias</a></h4>
              <p class="description">Podrás conocer las estadísticas de los clientes recibidos anual, mensual, semanal y diariamente</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
              <div class="icon"><i class="bx bx-world"></i></div>
              <h4 class="title"><a href="">Actividad</a></h4>
              <p class="description">Podrás conocer la actividad de tus empleados de forma anual, mensual, semanal y diaria.</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section -->

    <!-- ======= More Services Section ======= -->
    <section id="more-services" class="more-services">
      <div class="container">

        <div class="row">
          <div class="col-md-6 d-flex align-items-stretch">
            <div class="card" style='background-image: url("assets/img/more-services-1.jpg");' data-aos="fade-up" data-aos-delay="100">
              <div class="card-body">
                <h5 class="card-title"><a href="">Restaurante</a></h5>
                <!--<p class="card-text">Lorem ipsum dolor sit amet, consectetur elit, sed do eiusmod tempor ut labore et dolore magna aliqua.</p>
                <div class="read-more"><a href="#"><i class="icofont-arrow-right"></i> Read More</a></div>-->
              </div>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
            <div class="card" style='background-image: url("assets/img/more-services-2.jpg");' data-aos="fade-up" data-aos-delay="200">
              <div class="card-body">
                <h5 class="card-title"><a href="">Bar</a></h5>
                <!--<p class="card-text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem doloremque laudantium, totam rem.</p>
                <div class="read-more"><a href="#"><i class="icofont-arrow-right"></i> Read More</a></div>-->
              </div>
            </div>

          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4">
            <div class="card" style='background-image: url("assets/img/more-services-3.jpg");' data-aos="fade-up" data-aos-delay="100">
              <div class="card-body">
                <h5 class="card-title"><a href="">Comercio</a></h5>
                <!--<p class="card-text">Nemo enim ipsam voluptatem quia voluptas sit aut odit aut fugit, sed quia magni dolores.</p>
                <div class="read-more"><a href="#"><i class="icofont-arrow-right"></i> Read More</a></div>-->
              </div>
            </div>
          </div>
          <div class="col-md-6 d-flex align-items-stretch mt-4">
            <div class="card" style='background-image: url("assets/img/more-services-4.jpg");' data-aos="fade-up" data-aos-delay="200">
              <div class="card-body">
                <h5 class="card-title"><a href="">Fábrica</a></h5>
                <!--<p class="card-text">Nostrum eum sed et autem dolorum perspiciatis. Magni porro quisquam laudantium voluptatem.</p>
                <div class="read-more"><a href="#"><i class="icofont-arrow-right"></i> Read More</a></div>-->
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End More Services Section -->

    <!-- ======= Register Section ======= -->
    <section id="register" class="login">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Registro</h2>
        </div>

        <div class="row content">

            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
              <!--<div class="card card-signin my-5">-->
                <div class="card-body" data-aos="fade-up">
                  <h5 class="card-title text-center">
                    <span id="text_resgistrar" class="letra_logo">Registrar Empresa</span>
                  </h5>
                  <form class="form-signin" id="formRegister" method="POST">
                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-text">
                          <span id="iconoOjo" class="fa fa-building icon"></span>
                        </span>
                        <input name="nombre" type="text" class="form-control" id="nombre" placeholder="Nombre de la empresa" aria-describedby="inputGroupPrepend" minlength="1" maxlength="50" required autofocus> 
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="iconoArroba">@</span>
                        </div>
                        <input name="usuario2" type="text" class="form-control" id="usuario2" placeholder="Usuario" aria-describedby="inputGroupPrepend" minlength="1" maxlength="30" required autofocus> 
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <span class="input-group-text">
                          <span id="iconoOjo" class="fa fa-building icon"></span>
                        </span>
                        <select name="tipo_evento" id="tipo_evento" class="form-control">
                          <?php
                            $db = new MySQL($_SESSION['pagina']);
                            $c = $db->consulta("SELECT * FROM eventos ; ");
                            while($r = $c->fetch_array(MYSQLI_ASSOC)){
                              $id_evento = $r['id_evento'];
                              $descripcion = $r['descripcion'];
                              echo $descripcion;
                          ?>
                            <option value="<?= $id_evento ?>"><?= $descripcion ?></option>
                          <?php
                            }//fin while
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <span id="iconoOjo2" class="fa fa-eye-slash icon" onclick="verOcultarPass('#iconoOjo2','password2');"></span>
                          </span>
                        </div>
                        <input name="password2" type="password" class="form-control" id="password2" placeholder="Contraseña" minlength="1" maxlength="20" required> 
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <span id="iconoOjo3" class="fa fa-eye-slash icon" onclick="verOcultarPass('#iconoOjo3','password3');"></span>
                          </span>
                        </div>
                        <input name="password3" type="password" class="form-control" id="password3" placeholder="Repite la contraseña" minlength="1" maxlength="20" required> 
                      </div>
                    </div>
                    <div class="custom-control custom-checkbox mb-3">
                      <input type="checkbox" class="custom-control-input" id="customCheck1">
                      <label class="custom-control-label" for="customCheck1">Recordar password</label>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block text-uppercase" type="button" onclick="registrar_empresa()">Registrarse</button>
                  </form>
                </div>
              <!--</div>-->
            </div>

        </div>

      </div>
    </section><!-- End About Us Section -->
  
    <!-- ======= Contact Section ======= -->
    <!--
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Contacto</h2>
        </div>

        <div class="row">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="contact-about">
              <h3>Vesperr</h3>
              <p>Cras fermentum odio eu feugiat. Justo eget magna fermentum iaculis eu non diam phasellus. Scelerisque felis imperdiet proin fermentum leo. Amet volutpat consequat mauris nunc congue.</p>
              <div class="social-links">
                <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
                <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
                <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
                <a href="#" class="linkedin"><i class="icofont-linkedin"></i></a>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="200">
            <div class="info">
              <div>
                <i class="ri-map-pin-line"></i>
                <p>A108 Adam Street<br>New York, NY 535022</p>
              </div>

              <div>
                <i class="ri-mail-send-line"></i>
                <p>info@example.com</p>
              </div>

              <div>
                <i class="ri-phone-line"></i>
                <p>+1 5589 55488 55s</p>
              </div>

            </div>
          </div>

          <div class="col-lg-5 col-md-12" data-aos="fade-up" data-aos-delay="300">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                <div class="validate"></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section>
    -->
    <!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="row d-flex align-items-center">
        <div class="col-lg-6 text-lg-left text-center">
          <div class="copyright">
             &copy; Copyright <strong>Turfy</strong>. All Rights Reserved
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
            <a href="#intro" class="scrollto">Home</a>
            <a href="#about" class="scrollto">App</a>
            <a href="privacidad.php">Política de privacidad</a>
            <a href="manual.php">Manual de uso</a>
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