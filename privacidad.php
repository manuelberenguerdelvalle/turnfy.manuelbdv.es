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
          <li><a href="index.php#login">Iniciar Sesión</a></li>
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
          <h2>Privacidad</h2>
        </div>

        <div class="row content">
          <div data-aos="fade-up" data-aos-delay="150">
            	<p>&bull;&nbsp;El uso de nuestra app implica la aceptaci&oacute;n y adhesi&oacute;n a todas nuestras Condiciones de Uso y a nuestra Pol&iacute;tica de Privacidad. Te recomendamos que las leas detenidamente.</p>
                <p>&bull;&nbsp;Nuestros Servicios son de carácter de gestión y estadístico. Las condiciones adicionales estar&aacute;n disponibles junto con los Servicios pertinentes y formar&aacute;n parte del acuerdo que estableces con Turnfy al usar nuestros servicios.</p>
                <p>2. DEFINICI&Oacute;N DEL SERVICIO DE TURNFY</p>
                <p>&bull;&nbsp;El Servicio de Turnfy consiste en subdividir la jornada laboral de tu negocio en varias franjas horarias para obtener la rentabilidad sobre éstos, además de tener la opción de gestionar turnos digitales de acceso al comercio. La empresa gestiona la creación de usuarios al sistema y sus privilegios.</p>
                <p>&bull;&nbsp;Para registrarse como empresa en Turnfy se ha de completar el formulario de registro.</p>
                <p>3. USO DE LA APP Y SUS SERVICIOS</p>
                <p>Los usuarios se comprometen a utilizar la App, sus contenidos y servicios conforme con</p>
                <p>1.- La Ley o cualesquiera otras normas del ordenamiento jur&iacute;dico aplicable</p>
                <p>2.- Las presentes Condiciones de Uso</p>
                <p>3.- Las Normas de Funcionamiento</p>
                <p>4.- Las buenas costumbres</p>
                <p>5.- El orden p&uacute;blico</p>
                <p>&bull;&nbsp;Asimismo, los usuarios se comprometen expresamente a no destruir, alterar, inutilizar o, de cualquier otra forma, da&ntilde;ar los datos, programas o documentos electr&oacute;nicos y dem&aacute;s que se encuentren en la App de https://turnfy.manuelbdv.es.</p>
                <p>&bull;&nbsp;Los usuarios se comprometen a no obstaculizar el acceso de otros usuarios al servicio de acceso mediante el consumo masivo de los recursos inform&aacute;ticos a trav&eacute;s de los cuales Turnfy presta el servicio, as&iacute; como realizar acciones que da&ntilde;en, interrumpan o generen errores en dichos sistemas.</p>
                <p>&bull;&nbsp;Los usuarios se comprometen a no utilizar en esta App ning&uacute;n material de car&aacute;cter ofensivo, abusivo o perjucidial contra terceras personas registradas o no en la App y que sean contrarias a la ley, el orden p&uacute;blico o que causen o sean susceptibles de causar cualquier tipo de alteraci&oacute;n en los sistemas inform&aacute;ticos de Turnfy o de terceros.</p>
                <p>&bull;&nbsp;Al contactar los usuarios aceptan que se les env&iacute;e emails al correo electr&oacute;nico solicitando informaci&oacute;n, consultas o preguntas.</p>
                <p>4. PROPIEDAD INTELECTUAL E INDUSTRIAL</p>
                <p>La App aloja contenidos tanto propios como contenidos creados por los usuarios. La App est&aacute; protegida por leyes de propiedad intelectual y por los tratados internacionales en la materia. El contenido que se muestra en o a trav&eacute;s del sitio web est&aacute; protegido en su condici&oacute;n de obra colectiva y / o compilaci&oacute;n, de acuerdo con las leyes de propiedad intelectual y los tratados internacionales sobre la materia.</p>
                <p>&bull;&nbsp;Salvo que fuera autorizado por Turnfy o a menos que ello resulte legalmente permitido, el usuario no podr&aacute; copiar, modificar, distribuir, vender, alquilar o explotar de cualquier otra forma contenidos de la app. Asimismo el usuario no puede llevar a cabo operaciones de desensamblaje o descompilaci&oacute;n, ingenier&iacute;a inversa o cualquier otra operaci&oacute;n destinada a obtener cualquier c&oacute;digo fuente contenido en este App.</p>
                <p>&bull;&nbsp;Al subir fotograf&iacute;as a la App, los usuarios ceden a Turnfy los derechos de explotaci&oacute;n de propiedad intelectual sobre las mismas, por lo que Turnfy podr&aacute; eliminarlos en casos en los que se infrinjan las normas de buen uso.</p>
                <p>&bull;&nbsp;Los usuarios garantizan que son plenos titulares de los derechos que se ceden a Turnfy en virtud de esta cl&aacute;usula, y que la eliminaci&oacute;n de los mismos por Turnfy no supondr&aacute; violaci&oacute;n alguna de derechos de propiedad intelectual, ni de imagen, ni, en general, de ninguna otra clase, que correspondan a cualesquiera terceros, oblig&aacute;ndose a indemnizar y a mantener indemne a Turnfy en caso de infracci&oacute;n.</p>
                <p>5. EXCLUSI&Oacute;N DE GARANTIAS Y RESPONSABILIDAD</p>
                <p>A. Disponibilidad y Continuidad de la app y los Servicios</p>
                <p>&bull;&nbsp;Turnfy no garantiza la disponibilidad, el acceso y/o la continuidad del funcionamiento de la app y de sus Servicios. Asimismo, Turnfy no ser&aacute; responsable, con los l&iacute;mites establecidos por la Ley, de los da&ntilde;os y perjuicios causados al Usuario como consecuencia de la indisponibilidad, fallos de acceso y falta de continuidad de la app y de sus Servicios.</p>
                <p>B. Contenidos y Servicios de Turnfy</p>
                <p>&bull;&nbsp;Turnfy responder&aacute; &uacute;nica y exclusivamente de los Servicios que preste por s&iacute; misma y de los contenidos directamente originados por Turnfy e identificados con su copyright. Dicha responsabilidad quedar&aacute; excluida en los casos en que concurran causas de fuerza mayor o en los supuestos en que la configuraci&oacute;n de los equipos del Usuario no sea la adecuada para permitir el correcto uso de los servicios de Internet prestados por Turnfy.</p>
                <p>&bull;&nbsp;Sin perjuicio de lo dispuesto, la posible responsabilidad de Turnfy frente al usuario o frente a terceros se limita al  precio total del servicio contratado que origin&oacute; la responsabilidad, con exclusi&oacute;n, en todo caso, de cualquier tipo de responsabilidad por da&ntilde;os indirectos o por lucro cesante..</p>
                <p>&bull;&nbsp;la App no se hace responsable de la posible aparici&oacute;n de contenidos indexados en buscadores ajenos a la App, una vez se hayan dado de baja de nuestras bases de datos.</p>
                <p>C. Contenidos y Servicios de Terceros</p>
                <p>&bull;&nbsp;Turnfy no revisa o controla previamente, aprueba ni hace propios los contenidos, productos, servicios, opiniones, comunicaciones, datos, archivos y cualquier clase de informaci&oacute;n de terceros recogidos en la App. Asimismo, no garantiza la licitud, fiabilidad, utilidad, veracidad, exactitud, exhaustividad y actualidad de los contenidos, informaciones y servicios de terceros en la App. Turnfy tampoco garantiza de ninguna forma que los Usuarios de la app utilicen los contenidos y/o servicios del mismo conforme con la ley, las normativas aplicables, el orden publico ni las presentes Condiciones de Uso.</p>
                <p>&bull;&nbsp;Turnfy no se responsabiliza de los contenidos volcados o los actos cometidos por otros usuarios. Tampoco se responsabiliza de cualquier da&ntilde;o o perjuicio como consecuencia de la presencia de virus u otros elementos en los contenidos y servicios prestados por terceros. Asimismo Turnfy no responder&aacute; de los da&ntilde;os y perjuicios de cualquier naturaleza derivados del uso negligente o malintencionado de las cuentas de empresa utilizadas.</p>
                <p>&bull;&nbsp;En cualquier caso Turnfy no ser&aacute; responsable, ni indirectamente ni subsidiariamente, de la perdida econ&oacute;mica o reputaci&oacute;n, ni de ninguna clase de da&ntilde;os especiales, indirectos o emergentes, resultantes de la utilizaci&oacute;n del sitio web por parte del usuario.</p>
                <p>&bull;&nbsp;La exoneraci&oacute;n de responsabilidad se&ntilde;alada en el p&aacute;rrafo anterior ser&aacute; de aplicaci&oacute;n en el caso de que Turnfy no tenga conocimiento efectivo de que la actividad o la informaci&oacute;n almacenada es il&iacute;cita o de que lesiona bienes o derechos de un tercero susceptibles de indemnizaci&oacute;n, o si la tuviesen act&uacute;e con diligencia para retirar los datos y contenidos o hacer imposible el acceso a ellos.</p>
                <p>8. ENLACES DE TEXTO Y ENLACES GR&Aacute;FICOS</p>
                <p>&bull;&nbsp;Los usuarios previamente autorizados reconocen y aceptan que la utilizaci&oacute;n de los contenidos de las p&aacute;ginas web enlazadas ser&aacute; bajo su exclusivo riesgo y responsabilidad y exonera a la App Turnfy de cualquier responsabilidad sobre disponibilidad t&eacute;cnica de las p&aacute;ginas web enlazadas, la calidad, fiabilidad, exactitud y/o veracidad de los servicios, informaciones, elementos y/o contenidos a los que el usuario pueda acceder en las mismas.</p>
                <p>&bull;&nbsp;Turnfy no ser&aacute; responsable indirecta ni subsidiariamente de los da&ntilde;os y perjuicios de cualquier naturaleza derivados de a) el funcionamiento, indisponibilidad, inaccesibilidad y la ausencia de continuidad de las p&aacute;ginas web enlazadas; b) la falta de mantenimiento y actualizaci&oacute;n de los contenidos y servicios contenidos en las p&aacute;ginas web enlazadas; c) la falta de calidad, inexactitud, ilicitud, inutilidad de los contenidos y servicios de las p&aacute;ginas web enlazadas.</p>
                <p>9. DERECHO DE LIMITAR O PONER FIN AL SERVICIO DE TURNFY</p>
                <p>&bull;&nbsp;Turnfy se reserva el derecho, ejercitable en cualquier momento y de modo discrecional a rechazar cualquier anuncio o compromiso de ubicaci&oacute;n de un anuncio. Turnfy tambi&eacute;n se reserva el derecho de eliminar cualquier anuncio o de la app sin necesidad de avisar previamente a los usuarios y/o anunciantes siempre que infrinjan las normas de funcionamiento.</p>
                <p>&bull;&nbsp;Turnfy puede denegar o poner fin a su servicio y adoptar medidas t&eacute;cnicas y legales para mantener a los usuarios alejados de la app si creemos que est&aacute;n creando problemas o actuando de forma contraria al esp&iacute;ritu o la forma de nuestras normas y condiciones de uso, todo ello con independencia de cualquier pago realizado por el uso de la app o servicios complementarios. Sin embargo, decidamos o no retirar el acceso al sitio web de un usuario, no aceptamos ninguna responsabilidad por el uso no autorizado o ilegal del sitio web por los usuarios, tal y como se describe en los p&aacute;rrafos anteriores.</p>
                <p>10. INDEMNIZACI&Oacute;N POR USO ABUSIVO</p>
                <p>11. VARIOS</p>
                <p>A. Modificaciones en el Servicio y Condiciones de Uso</p>
                <p>&bull;&nbsp;Turnfy se reserva el derecho a realizar cambios en la App, pudiendo modificar, suprimir e incluir, unilateralmente y sin previo aviso, nuevos contenidos as&iacute; como la forma en que estos aparezcan presentados y localizados..</p>
                <p>&bull;&nbsp;Asimismo, Turnfy se reserva el derecho a realizar cambios las presentes Condiciones de Uso en cualquier momento. El usuario quedar&aacute; sujeto a las nuevas Condiciones de Uso que hayan sido publicadas en el momento en que acceda o utilice los servicios de la app.</p>
                <p>&bull;&nbsp;Si alguna de las presentes condiciones resulta invalidada, nula o inaplicable por cualquier motivo, dicha condici&oacute;n quedar&aacute; excluida y no afectar&aacute; a la validez ni la aplicabilidad del resto de condiciones.</p>
                <p>B. Precios de los Servicios</p>
                <p>&bull;&nbsp;Los precios de los servicios ser&aacute;n establecidos en las correspondientes p&aacute;ginas de la app para cada servicio.</p>
                <p>C. Menores de Edad</p>
                <p>&bull;&nbsp;Con car&aacute;cter general, para hacer uso de los Servicios de la app los menores de edad deben haber obtenido previamente la autorizaci&oacute;n de sus padres, tutores o representantes legales, quienes ser&aacute;n responsables de todos los actos realizados a trav&eacute;s de la app por los menores a su cargo.</p>
                <p>12. DURACI&Oacute;N Y TERMINACI&Oacute;N</p>
                <p>&bull;&nbsp;La prestaci&oacute;n de los servicios y/o contenidos de la app tiene una duraci&oacute;n indefinida.</p>
                <p>&bull;&nbsp;Sin perjuicio de lo anterior, y adem&aacute;s de por las causas establecidas legalmente, Turnfy est&aacute; facultado para dar por terminado, suspender o interrumpir unilateralmente, en cualquier momento y sin necesidad de preaviso, la prestaci&oacute;n del servicio y de la app y/o cualquiera de los servicios..</p>
                <p>13. JURISDICCI&Oacute;N</p>
                <p>&bull;&nbsp;La ley aplicable en caso de disputa o conflicto de interpretaci&oacute;n de los t&eacute;rminos que conforman estas Condiciones de Uso, as&iacute; como cualquier cuesti&oacute;n relacionada con los servicios de la app, ser&aacute; la ley espa&ntilde;ola..</p>
                <p>&bull;&nbsp;Para la resoluci&oacute;n de cualquier controversia que pudiera surgir con ocasi&oacute;n del uso de la app y sus servicios, las partes acuerdan someterse a la jurisdicci&oacute;n de los Juzgados y Tribunales de la ciudad de Alicante (Espa&ntilde;a), y sus superiores jer&aacute;rquicos, con expresa renuncia a otros fueros si lo tuvieren y fueran diferentes de los rese&ntilde;ados..</p>
                <p>NORMAS DE FUNCIONAMIENTO</p>
				<p>&bull;&nbsp;la App no se hace responsable de cualquier funcionamiento incorrecto del sistema ya bien sea por error en la conexi&oacute;n de internet o por problemas con el dispositivo.</p>
                <p>1. Empresa</p>
                <p>&bull;&nbsp;La empresa se compromete a realizar las gestiones de la manera m&aacute;s responsable y justa posible.</p>
                <p>&bull;&nbsp;La empresa est&aacute; de acuerdo en asumir toda la responsabilidad legal sobre los datos que gestiona o ha gestionado.</p>
                <p>&bull;&nbsp;La empresa acepta que los datos finalizados o después de 15 días son archivados autom&aacute;ticamente en el sistema.</p>
                <p>&bull;&nbsp;La empresa tiene el derecho de admisi&oacute;n sobre los usuarios, franjas horarias y turnos del sistema.</p>
                <p>&bull;&nbsp;La empresa tiene el derecho a decidir si devolver o no el importe de la inscripci&oacute;n s&oacute;lo en el caso de que lo solicite el equipo inscrito y no tengan un motivo firme para realizar dicha devoluci&oacute;n.</p>
                <p>&bull;&nbsp;La empresa acepta ser el &uacute;nico responsable legal de los pagos online o presenciales recibidos por parte de los jugadores que se inscriben en sus torneos.</p>
                <p>&bull;&nbsp;La empresa acepta que esta web pueda facilitar sus datos personales a jugadores s&oacute;lo en caso de situaci&oacute;n irregular o indicios de fraude con pagos (online y presencial) recibidos por jugadores, para que los jugadores puedan tomar las medidas legales pertinentes.</p>
                <p>&bull;&nbsp;La empresa acepta que la eliminaci&oacute;n de su cuenta solo ser&aacute; posible cuando todos los torneos est&eacute;n finalizados o no tengan inscritos, evitando de esta manera perjudicar o realizar actividades fraudulentas sobre los jugadores.</p>
                <p>&bull;&nbsp;La empresa acepta que por seguridad est&aacute; web guarde un hist&oacute;rico de sus cambios en datos personales.</p>
                <p>&bull;&nbsp;En esta web sus datos personales son totalmente privados y no ser&aacute;n utilizados para ning&uacute;n fin ajeno a esta web.</p>
                <p>&bull;&nbsp;Esta web tiene el derecho de inhabilitar a cualquier administrador que no respete las condiciones legales de esta web o realice actividades fraudulentas.</p>
                <p>&bull;&nbsp;Esta web almacena la Ip al acceder al panel de usuario s&oacute;olo y exclus&iacute;vamente para utilizar en casos de acciones fraudulentas.</p>
                <p>&bull;&nbsp;Esta web no se hace responsable ante el delito de robo de cualquier informaci&oacute;n alojada en nuestra base de datos, y emprender&aacute; acciones legales contra los atacantes.</p>
                <p>2. Jugador</p>
                <p>&bull;&nbsp;El jugador/a debe asegurarse de inscribirse en el torneo adecuado y conocer al administrador, organizaci&oacute;n o club que lo gestiona sobre todo si requiere pago online por inscripci&oacute;n.</p>
                <p>&bull;&nbsp;El jugador/a dispone de un panel de control personalizado en el que podr&aacute; gestionar algunos de sus datos personales, foto de perfil, justificantes de pagos y ver las estad&iacute;sticas de sus torneos inscritos.</p>
                <p>&bull;&nbsp;Para inscribirse en cualquier torneo es necesario ser mayor de 18 a&ntilde;os, o est&aacute; confirmando que sus padres/tutores est&aacute;n informados y son responsables de su inscripci&oacute; en cualquier torneo de https://turnfy.manuelbdv.es que queda exenta de cualquier responsabilidad sobre los menores que utilicen la App.</p>
                <p>&bull;&nbsp;Al registrarse como nuevo jugador, &eacute;ste debe saber que est&aacute; aceptando que los administradores de los torneos en las que se inscribe tienen acceso a algunos de tus datos, utilizados expresamente para contactar con usted en temas relacionados con el torneo.</p>
                <p>&bull;&nbsp;Este App recomienda tener acceso al correo electr&oacute;nico con el que se ha efectuado el registro en esta web, y revisar la bandeja de entrada con frecuencia, ya que podr&aacute; recibir e-mails sobre sus torneos por parte de administrador/es.</p>
                <p>&bull;&nbsp;Con la inscripci&oacute;n el jugador/a acepta recibir informaci&oacute;n acerca de los torneos inscritos incluyendo informaci&oacute;n importante sobre Turnfy.es.</p>
                <p>&bull;&nbsp;Una vez el jugador/a decide eliminar su perfil, todos los datos ser&aacute;n eliminados inmediatamente y de forma irreversible.</p>
                <p>&bull;&nbsp;Los datos del perfil de los jugadores/as alojados en este App son totalmente privados y solo se utilizar&aacute;n en esta web, no ser&aacute;n facilitados a terceros bajo ning&uacute;n concepto.</p>
                <p>&bull;&nbsp;El/La jugador/a participante se compromete a utilizar los servicios ofrecidos de manera responsable y de acuerdo a nuestras normas o podr&aacute; ser eliminado de la app.</p>
                <p>&bull;&nbsp;El/la jugador/a se compromete a facilitar el correcto funcionamiento de los torneos inscritos y no entorpecerlos o dificultarlos.</p>
                <p>&bull;&nbsp;El/la jugador/a debe hacer un uso responsable de la comunicaci&oacute;n v&iacute;a e-mail con el/los administrador/es y acepta que es el responsable del contenido enviado, eximiendo de toda responsabilidad a la App https://turnfy.manuelbdv.es.</p>
                <p>&bull;&nbsp;Esta web se ha desarrollado estableciendo restricciones para ofrecer la m&aacute;xima seguridad para los/las jugadores/as participantes.</p>
                <p>&bull;&nbsp;Esta web ofrece la posibilidad de que los jugadores/as realicen el pago online de inscripci&oacute;n al administrador del torneo a trav&eacute;s de Paypal, s&oacute;lo si La empresa configura los requerimientos necesarios, siendo el aldministrador el total responsable ya que es el que recibe el pago.</p>
                <p>&bull;&nbsp;El pago online de inscripciones se ha de realizar solo una vez por un jugador/a del equipo.</p>
                <p>&bull;&nbsp;La devoluci&oacute;n de pagos online se han de tramitar con La empresa, este solicita la eliminaci&oacute;n y los jugadores deben comprobar que han recibido la devoluci&oacute;n v&iacute;a PayPal, y una vez verificada la gesti&oacute;n de devoluci&oacute;n alguno de los miembros del equipo deben pulsar sobre "Si" sobre el correo electr&oacute;nico recibido e inmediatamente se eliminar&aacute; la inscripci&oacute;n, de lo contrario pulse "No".</p>
                <p>&bull;&nbsp;Si el equipo solicita la devoluci&oacute;n una vez realizado el pago de la inscripci&oacute;n La empresa tiene el derecho a decidir si realizar la devoluci&oacute;n o no.</p>
                <p>&bull;&nbsp;La empresa tiene el derecho de adminsi&oacute;n sobre los equipos inscritos, pero si ha recibido un pago online o presencial y no desea admitir una participaci&oacute;n est&aacute; obligado a realizar la devoluci&oacute;n &iacute;ntegra del importe de pago.</p>
                <p>&bull;&nbsp;El jugador acepta que para que se active la eliminaci&oacute;n de su perfil solo ser&aacute; posible cuando todos los torneos en las que est&aacute; inscrito se encuentren finalizados o las inscripciones no est&eacute;n pagadas, evitando de esta manera alterar el torneo o realizar actividades fraudulentas.</p>
                <p>&bull;&nbsp;Esta web no recibe comisiones ni pagos de los jugadores/as, por lo tanto no se hace responsable de ning&uacute;n pago online o presencial que los jugadores/as realicen a los administradores del torneo en la que se han inscrito.</p>
                <p>&bull;&nbsp;Este App web se compromete ante indicios o casos fraudulentos a facilitar los datos necesarios del infractor para formalizar una posible denuncia judicial.</p>
                <p>&bull;&nbsp;Esta App web almacena la Ip al acceder al panel de jugador s&oacute;olo y exclus&iacute;vamente para utilizar en casos de acciones fraudulentas.</p>
                <p>&bull;&nbsp;Esta App web no se hace responsable ante el delito de robo de cualquier informaci&oacute;n alojada en nuestra base de datos, y emprender&aacute; acciones legales contra los atacantes.</p>
                <p>3. Patrocinador</p>
                <p>&bull;&nbsp;El Patrocinador est&aacute; de acuerdo en asumir toda la responsabilidad legal sobre el contenido de las im&aacute;genes y enlaces insertados.</p>
                <p>&bull;&nbsp;Esta web dispone de un control de anuncios para asegurar siempre la publicaci&oacute;n equitativa de publicidad para cada ciudad.</p>
                <p>&bull;&nbsp;Puede realizar tantos anuncios por ciudad como desee.</p>
                <p>&bull;&nbsp;Los anuncios pueden verse congelados en el caso de no haber en ese momento torneos activos para la ciudad seleccionada, tendr&aacute; la opci&oacute;n de cambiar a una ciudad m&aacute;s cercana o esperar nuevos torneos activos, el tiempo de espera ser&aacute; a&ntilde;adido autom&aacute;ticamente.</p>
                <p>&bull;&nbsp;Los precios de anuncio var&iacute;an en funci&oacute;n de los torneos que tiene cada ciudad.</p>
                <p>&bull;&nbsp;En esta web sus datos personales son totalmente privados y no ser&aacute;n utilizados para ning&uacute;n fin ajeno a esta web.</p>
                <p>&bull;&nbsp;En caso de cualquier indicio de actividad delictiva, esta web podr&aacute; facilitar sus datos personales para realizar las acciones legales oportunas.</p>
                <p>&bull;&nbsp;El pago de los anuncios se realiza a trav&eacute;s de la platarforma de pagos seguros PayPal.</p>
                <p>&bull;&nbsp;El patrocinador acepta que la eliminaci&oacute;n de su cuenta solo ser&aacute; posible cuando todos los anuncios est&eacute;n finalizados o no se hayan realizado el pago.</p>
                <p>&bull;&nbsp;Esta web puede cancelar en cualquier momento un anuncio en el que se hayan realizado irregularidades en el pago.</p>
                <p>&bull;&nbsp;Una vez que su anuncio es publicado ya no es posible la devoluci&oacute;n del pago realizado.</p>
				<p>&bull;&nbsp;Los anuncios pueden quedarse en estado congelado debido a la falta de torneos activos para una ciudad, puede elegir cambiar a una ciudad m&aacute;s cercana o esperar torneos activos, el tiempo de congelaci&oacute;n se le abonar&aacute; autom&aacute;ticamente a la fecha de fin del anuncio.</p>
                <p>&bull;&nbsp;Esta web tiene el derecho de inhabilitar a cualquier patrocinador que no respete las condiciones legales de esta web o realice actividades fraudulentas.</p>
                <p>&bull;&nbsp;Esta web almacena la Ip al acceder al panel de patrocinador s&oacute;olo y exclus&iacute;vamente para utilizar en casos de acciones fraudulentas.</p>
                <p>&bull;&nbsp; Esta web no se hace responsable ante el delito de robo de cualquier informaci&oacute;n alojada en nuestra base de datos, y emprender&aacute; acciones legales contra los atacantes.</p>                
                <p>POLITICA DE PRIVACIDAD DE TURNFY Y USO DE COOKIES</p>
                <p>&bull;&nbsp;La presente Pol&iacute;tica de Privacidad tiene por objeto describir la pol&iacute;tica de protecci&oacute;n de datos de Turnfy (en adelante, "Turnfy") propietaria de las p&aacute;ginas web ubicadas bajo el dominio https://turnfy.manuelbdv.es (en adelante, el "App").<!-- con la direcci&oacute;n Turnfy, Apartado postal 29059, Madrid y con N&uacute;mero de Identificaci&oacute;n Fiscal B86326758 e inscrita en el Registro Mercantil de Madrid, Tomo 29473, Folio 100, Secci&oacute;n 8, Hoja M530465..--></p>
                <p>&bull;&nbsp;Los datos aportados por los usuarios a Turnfy son incluidos en nuestros ficheros registrados ante la Agencia Espa&ntilde;ola de Protecci&oacute;n de Datos (AEPD). La AEPD se encarga de velar por el cumplimiento de las leyes sobre privacidad y protecci&oacute;n de datos y de garantizar la seguridad y privacidad de sus datos.</p>
                <p>1. INFORMACI&Oacute;N SOBRE DATOS RECABADOS POR TURNFY</p>
                <p>&bull;&nbsp;Los servidores de Turnfy est&aacute;n situados en Espa&ntilde;a y recabamos y almacenamos en ficheros tanto informaci&oacute;n facilitada por los usuarios como datos obtenidos a trav&eacute;s de la utilizaci&oacute;n de la app.</p>
                <p>&bull;&nbsp;Por tanto, mediante el acceso a la App o la utilizaci&oacute;n de sus servicios el usuario consiente y autoriza expresamente a que los datos de car&aacute;cter personal facilitados, sean incorporados a la base de datos de Turnfy, y que sean tratados exclusivamente de conformidad con los fines establecidos en la presente Pol&iacute;tica de Privacidad, as&iacute; como las Condiciones de Uso.</p>
                <p>&bull;&nbsp;En el supuesto de que el usuario tuviera que facilitar a Turnfy datos personales de terceros, deber&aacute; asegurarse de contar con el consentimiento expreso de dicho tercero, habi&eacute;ndole informado de a qui&eacute;n se van a facilitar los datos, la finalidad y la posibilidad de que Turnfy se ponga en contacto con ellos.</p>
                <p>&bull;&nbsp;La falta de suministro de aquellos datos que sean obtorneotorios para la prestaci&oacute;n de los servicios o el suministro de datos incorrectos, inexactos o no actualizados imposibilitar&aacute; la prestaci&oacute;n de los servicios por parte de Turnfy.</p>
                <p>1) INFORMACI&Oacute;N FACILITADA POR EL USUARIO</p>
                <p>&bull;&nbsp;Para administrar, jugar o patrocinar un torneo, el usuario tiene que proporcionar datos personales como, por ejemplo, la direcci&oacute;n del correo electr&oacute;nico, el nombre y como usuario administrador de torneos puede que el nif. Para disfrutar de determinados servicios que ofrece Turnfy en su App, es posible que sea redirigido a la plataforma de pago paypal para realizar pagos y posteriormente volver a Turnfy para verificar el pago.
Turnfy se reserva el derecho de comprobar la identidad de los usuarios mediante verificaci&oacute;n por tel&eacute;fono o e-mail.</p>
                <p>&bull;&nbsp;Los contactos establecidos en Turnfy ser&aacute; a trav&eacute;s de su direcci&oacute;n del correo electr&oacute;nico y nunca se facilitar&aacute; el correo electr&oacute;nico del emisor.</p>
                <p>2) DATOS OBTENIDOS A TRAV&Eacute;S DE LA UTILIZACI&Oacute;N DE NUESTROS SERVICIOS</p>
                <p>&bull;&nbsp;Cada vez que uses nuestros servicios o que consultes nuestro contenido, es posible que obtengamos y que almacenemos determinada informaci&oacute;n en los registros del servidor de forma autom&aacute;tica. Estos datos podr&aacute;n incluir:.</p>
                <p>&bull;&nbsp;informaci&oacute;n sobre el acceso (por ejemplo, si accedes des pc, m&oacute;vil, tablet...etc) y tipo de navegador,</p>
                <p>&bull;&nbsp;informaci&oacute;n sobre el acceso de los usuarios para evitar suplantaci&oacute;n de identidad,</p>
                <p>&bull;&nbsp;la direcci&oacute;n IP.</p>
                <p>3) COOKIES</p>
                <p>&bull;&nbsp;Este App no utiliza cookies.</p>
                <p>4) USO DE LOS DATOS RECOGIDOS</p>
                <p>&bull;&nbsp;Los datos que recogemos a trav&eacute;s de todos nuestros servicios se utilizan para prestar, mantener, personalizar, proteger y mejorar los servicios de Turnfy, desarrollar nuevos servicios y velar por la protecci&oacute;n de Turnfy y de nuestros usuarios.</p>
                <p>&bull;&nbsp;Todos los datos facilitados que no tienen car&aacute;cter personal, como por ejemplo, la descripci&oacute;n del bien, del animal, del servicio, etc., las caracter&iacute;sticas y los atributos del mismo, el precio, el nombre de contacto y el n&uacute;mero de tel&eacute;fono son, como es obvio por la naturaleza del servicio, p&uacute;blicos.</p>
                <p>&bull;&nbsp;Los t&eacute;rminos recogidos en la Pol&iacute;tica de Privacidad y, en concreto, el deber de confidencialidad son de obligado cumplimiento para todos los destinatarios de la informaci&oacute;n recogida, incluyendo el personal contratado por Turnfy y aquellos terceros, que en virtud de un contrato de prestaci&oacute;n de servicios, tengan acceso a datos de car&aacute;cter personal y a los equipos o sistemas de Turnfy.</p>
                <p>5) CESI&Oacute;N DE DATOS A TERCEROS</p>
                <p>&bull;&nbsp;Turnfy no comunica, vende, alquila o comparte los datos de car&aacute;cter personal de los usuarios con empresas, organizaciones o personas f&iacute;sicas ajenas a Turnfy.</p>
                <p>&bull;&nbsp;Dicho consentimiento no ser&aacute; necesario para la comunicaci&oacute;n de datos en los supuestos en los que la Ley los permite expresamente.</p>
                <p>&bull;&nbsp;Si Turnfy participa en una fusi&oacute;n, adquisici&oacute;n o venta de activos, nos aseguraremos de mantener la confidencialidad de los datos personales e informaremos a los usuarios afectados antes de que sus datos personales sean transferidos o pasen a estar sujetos a una pol&iacute;tica de privacidad diferente.</p>
                <p>6) UTILIZACI&Oacute;N DE LA INFORMACI&Oacute;N EN la App</p>
                <p>&bull;&nbsp;Los usuarios jugadores de Turnfy solo pueden utilizar los datos de car&aacute;cter personal publicados en la App para tratar con usuarios administradores de torneos y viceversa, no para enviar informaci&oacute;n publicitaria no solicitada o correo basura ni recoger datos de car&aacute;cter personal de una persona que no lo haya autorizado.</p>
                <p>&bull;&nbsp;Turnfy puede revisar o filtrar autom&aacute;tica o manualmente los mensajes de los usuarios enviados a trav&eacute;s de la app para controlar las actividades maliciosas o el contenido prohibido.</p>
                <p>7) ACCESO, RECTIFICACI&Oacute;N, CANCELACI&Oacute;N Y OPOSICI&Oacute;N</p>
                <p>&bull;&nbsp;El usuario puede acceder y/o rectificar la mayor&iacute;a de sus datos de car&aacute;cter personal accediendo a los mismos a trav&eacute;s de la app. Para acceder o rectificar cualquier otro dato que no pueda consultarse a trav&eacute;s de la p&aacute;gina web, as&iacute; como ejercitar los derechos de cancelaci&oacute;n u oposici&oacute;n, el usuario puede comunicarse con info(arroba)Turnfy.es. Turnfy cancelar&aacute; los datos de car&aacute;cter personal cuando ya no se necesitan para los fines descritos anteriormente. La cancelaci&oacute;n da lugar al bloqueo de los datos, conserv&aacute;ndose &uacute;nicamente aqu&eacute;llos necesarios para la atenci&oacute;n de las posibles responsabilidades nacidas del tratamiento, durante el plazo de prescripci&oacute;n de &eacute;stas.</p>
                <p>8) SEGURIDAD</p>
                <p>&bull;&nbsp;Los servidores de Turnfy est&aacute;n ubicadas a trav&eacute;s de una empresa externa que aseguran la protecci&oacute;n de sus servidores y de los datos que los contienen.</p>
				        <p>9) MODIFICACIONES</p>
                <p>&bull;&nbsp;La Pol&iacute;tica de Privacidad de Turnfy se podr&aacute; modificar en cualquier momento. No limitaremos los derechos que corresponden al usuario con arreglo a la presente Pol&iacute;tica de Privacidad sin tu expreso consentimiento. Publicaremos todas las modificaciones de la presente Pol&iacute;tica de Privacidad en esta p&aacute;gina y, si son significativas, efectuaremos una notificaci&oacute;n m&aacute;s destacada (por ejemplo, te enviaremos una notificaci&oacute;n por correo electr&oacute;nico si la modificaci&oacute;n afecta a determinados servicios).</p> 
            <ul>
              <li><i class="ri-check-double-line"></i> Podrás controlar las reservas de las mesas para los diferentes turnos de servicio</li>
              <li><i class="ri-check-double-line"></i> Saber el aforo por turno de servicio</li>
              <li><i class="ri-check-double-line"></i> Añadir comandas</li>
            </ul>
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
            <a href="index.php#">Política de privacidad</a>
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