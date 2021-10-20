<?php
function headToTitle(){
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      
      <!--EVITAR EL CACHEO-->
      <meta http-equiv="Expires" content="0">
      <meta http-equiv="Last-Modified" content="0">
      <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
      <meta http-equiv="Pragma" content="no-cache">
      <!--FIN EVITAR EL CACHEO-->
      <link rel="shortcut icon" type="image/png" href="../images/logo32.png"/>
      <title>'. titulo().'</title>';
}

function headFinishToWrapperStart(){
  echo '
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to to the body tag
  to get the desired effect
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="hold-transition sidebar-mini layout-navbar-fixed">
  <div class="wrapper">
  ';
}

function navBar(){
  echo '
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Inicio</a>
      </li>
      <!--
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
      -->
    </ul>

    <!-- SEARCH FORM -->
    <!--
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>
    -->
  </nav>
  <!-- /.navbar -->
  ';
}

function brandLogo(){
  echo '
  <!-- Brand Logo -->
  <a href="index3.php" class="brand-link">
    <img src="../images/logo128.png" alt="Turnfy" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-bolder">Turnfy</span>
  </a>
  ';
}

function userPanel($nombre){
  $d = '
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">';
  if($_SESSION['login'] == 'id_empresa'){$d .= '<img src="../images/usuario_premium.png" class="img-circle elevation-2" alt="User Image">';}
  else{$d .= '<img src="../images/usuario_normal.png" class="img-circle elevation-2" alt="User Image">';}
  $d .= '
      </div>
      <div class="info">
        <a href="#" class="d-block">'.$nombre.'</a>
      </div>
    </div>
  ';
  echo $d;
}

function menuCuenta(){
  echo '
  <li class="nav-item">
    <a href="cuenta.php" class="nav-link">
      <i class="nav-icon fas fa-user-cog"></i>
      <p>
        Cuenta
      </p>
    </a>
  </li>
  ';
}

function menuUsuarios(){
  echo '
  <li class="nav-item">
    <a href="usuarios.php" class="nav-link">
      <i class="nav-icon fas fa-users"></i>
      <p>
        Usuarios
      </p>
    </a>
  </li>
  ';
}

function menuTurnos(){
  echo '
  <li class="nav-item">
    <a href="turnos.php" class="nav-link">
      <i class="nav-icon fas fa-calendar-alt"></i>
      <p>
        Franjas horarias
      </p>
    </a>
  </li>
  ';
}

function menuReservas(){
  echo '
  <li class="nav-item">
    <a href="reservas.php" class="nav-link">
      <i class="nav-icon fas fa-book-open"></i>
      <p>
        Turnos
      </p>
    </a>
  </li>
  ';
}

function menuEstadisticas(){
  echo '
  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-chart-bar"></i>
      <p>
        Estadisticas
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="estadisticas_anual.php" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Anual</p>
        </a>
      </li>              
      <li class="nav-item">
        <a href="estadisticas_mensual.php" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Mensual</p>
        </a>
      </li>              
      <li class="nav-item">
        <a href="estadisticas_semanal.php" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Semanal</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="estadisticas_diaria.php" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Diaria</p>
        </a>
      </li>
    </ul>
  </li>
  ';
}

function menuActividades(){
  echo '
  <li class="nav-item has-treeview">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-chart-pie"></i>
      <p>
        Actividad
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="actividad_anual.php" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Anual</p>
        </a>
      </li>              
      <li class="nav-item">
        <a href="actividad_mensual.php" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Mensual</p>
        </a>
      </li>              
      <li class="nav-item">
        <a href="actividad_semanal.php" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Semanal</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="actividad_diaria.php" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Diaria</p>
        </a>
      </li>
    </ul>
  </li>
  ';
}

function menuDesconectar(){
  echo '
  <li class="nav-item">
    <a href="../funciones/cerrar_sesion.php" class="nav-link" >
      <i class="nav-icon fas fas fa-power-off"></i>
      <p>
        Cerrar sesión
      </p>
    </a>
  </li> 
  ';
}

function pageHeader($nomPagina){
  echo '
  <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">'.$nomPagina.'</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
              <li class="breadcrumb-item active">'.$nomPagina.'</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
  ';
}

function footerToHtmlFinish(){
  echo '
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
     <strong>Copyright &copy; 2014-2019 Turnfy.</strong>All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->

  </body>
  </html>
  ';
}

?>