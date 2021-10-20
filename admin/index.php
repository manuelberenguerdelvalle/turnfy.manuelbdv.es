<?php
include_once ("../funciones/html.php");
include_once ("../funciones/generales.php");
include_once ("../class/conexiones.php");
include_once ("../class/mysql.php");
include_once ("../class/empresas.php");
session_start();
//validamos session y pagina
if ( ($_SESSION['id_usuario'] == 0 && $_SESSION['id_empresa'] == 0) 
|| empty($_SESSION['login'])
|| comprobar_pagina($_SESSION['pagina']) ){
	header ("Location: ".url_completa());
}
//validamos las conexiones
if(isset($_SESSION['id_conexion'])){//si existe
  $res = obten_consultaUnCampo('index','id_conexion','conexiones','id_conexion',$_SESSION['id_conexion'],'estado','0','','','','','');
  if(empty($res)){
    header ("Location: ".url_completa());
  }
}
else{
  $conexion = new Conexion('',$_SESSION['id_usuario'],$_SESSION['id_empresa'],obten_fechahora(),'','',0);
  $conexion->finishOld($_SESSION['pagina']);
  $conexion->insertar($_SESSION['pagina']);
  $_SESSION['id_conexion'] = obten_consultaUnCampo('index','id_conexion','conexiones','id_usuario',$_SESSION['id_usuario'],'id_empresa',$_SESSION['id_empresa'],'','','','','order by id_conexion desc');  
}

$_SESSION['pagina'] = 'index';

$empresa = new Empresa($_SESSION['id_empresa'],'','','','','','','','','','','');
if(!empty($empresa -> getValor('nombre'))){$nombre = $empresa -> getValor('nombre');}
else{$nombre = $empresa -> getValor('usuario');}
$_SESSION['obj_empresa'] = serialize($empresa);
$id_empresa = $_SESSION['id_empresa'];

if ($_SESSION['login'] == 'id_usuario'){
  include_once ("../class/usuarios.php");
  $usuario = new Usuario($_SESSION['id_usuario'],'','','','','','','');
  $nombre = $usuario -> getValor('usuario');
  $_SESSION['obj_usuario'] = serialize($usuario);
}

if($_SESSION['login'] == 'id_empresa' && $id_empresa == 1){
  include_once ("../class/turnos.php");
  include_once ("../class/actividades.php");
  
  //revisamos si generamos datos usuario de prueba
  $ultima_fecha = obten_consultaUnCampo($_SESSION['pagina'],'fecha_inicio','turnos','id_empresa',$id_empresa,'','','','','','',' order by fecha_inicio desc limit 1');
  $fecha = date("Y-m-d",strtotime($ultima_fecha." + 1 days"));
  if($fecha <= date('Y-m-d')){
    generar_datos_turnos($fecha);
    generar_datos_actividades($fecha);
  }

}


$turnos_actualizados = actualiza_turnos($id_empresa);

headToTitle();
?>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- bootstrap slider -->
  <link rel="stylesheet" href="plugins/bootstrap-slider/css/bootstrap-slider.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <!-- OPTIONAL SCRIPTS -->
  <!-- Generales -->
  <script src="../funciones/generales.js"></script>
  <!-- SweetAlert2 -->
  <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  <!--<script src="../jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>-->
  <script type="text/javascript">
    /*$(document).ready(function(){
      ocultar('#dias');
    });
    function mostrar_select(){
      if( $('#repetir0').prop('checked') ) {
        mostrar('#dias');
      }
      else{
        ocultar('#dias');
      }
    }

    $(window).on("orientationchange",function(){
      alert("The orientation has changed!");
    });
    */
  </script>

<?php
headFinishToWrapperStart();
  navBar();
?>
  
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-light elevation-4">
    <?php brandLogo(); ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <?php userPanel($nombre); ?>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php
          if( $_SESSION['login'] == 'id_empresa' ){
            menuCuenta();
          }
          if( $_SESSION['login'] == 'id_empresa' || ($_SESSION['login'] == 'id_usuario' && $usuario -> getValor('gestion_turnos') == 'S') ){
            menuUsuarios();
            menuTurnos();
          }
          menuReservas();
          if($_SESSION['login'] == 'id_empresa'){
            menuEstadisticas();
            menuActividades();
          }
          menuDesconectar();
          ?>    
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php pageHeader("Inicio"); ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <?php
      if($_SESSION['login'] == 'id_empresa'){
      ?>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= round(obten_consultaUnCampo($_SESSION['pagina'],'count(id_turno)','turnos','id_empresa',$id_empresa,'estado','0','fecha_inicio',date('Y-m-d'),'','',''),0); ?></h3>

                <p>Franjas horarias hoy</p>
              </div>
              <div class="icon">
                <i class="ion ion-calendar"></i>
              </div>
              <a href="turnos.php" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                <?php 
                $suma = round(obten_consultaUnCampo($_SESSION['pagina'],'sum(suma_ganancias)','turnos','id_empresa',$id_empresa,'estado','0','fecha_inicio',date('Y-m-d'),'','',''),0);
                if(empty($suma)){$suma = 0;}
                echo $suma.' €'; 
                ?>
                </h3>

                <p>Ganancias hoy</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="estadisticas_diaria.php" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>
                <?php 
                $suma = round(obten_consultaUnCampo($_SESSION['pagina'],'sum(asistentes)','turnos','id_empresa',$id_empresa,'estado','0','fecha_inicio',date('Y-m-d'),'','',''),0);
                if(empty($suma)){$suma = 0;}
                echo $suma; 
                ?>
                </h3>

                <p>Asistencias hoy</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="estadisticas_diaria.php" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= round(obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'DATE(fechahora)',date('Y-m-d'),'','','','',''),0); ?></h3>

                <p>Actividad hoy</p>
              </div>
              <div class="icon">
                <i class="ion ion-hammer"></i>
              </div>
              <a href="actividad_diaria.php" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= round(obten_consultaUnCampo($_SESSION['pagina'],'count(id_usuario)','usuarios','id_empresa',$id_empresa,'estado','0','','','','',''),0); ?></h3>

                <p>Usuarios Registrados</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="usuarios.php" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= round(obten_consultaUnCampo($_SESSION['pagina'],'count(id_reserva)','reservas','id_empresa',$id_empresa,'estado','0','DATE(fec_creacion)',date('Y-m-d'),'','',''),0); ?></h3>

                <p>Turnos hoy</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-book"></i>
              </div>
              <a href="reservas.php" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <?php
        if($turnos_actualizados > 0){
        ?>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= $turnos_actualizados ?></h3>

                <p>Franjas horarias archivadas automáticamente</p>
              </div>
              <div class="icon">
                <i class="ion ion-calendar"></i>
              </div>
              <a href="turnos.php" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
      <?php
        }//fin if turnos actualizados
      }//fin login empresa
      else{
      ?>
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= round(obten_consultaUnCampo($_SESSION['pagina'],'count(id_turno)','turnos','id_empresa',$id_empresa,'estado','0','fecha_inicio',date('Y-m-d'),'','',''),0); ?></h3>

                <p>Franjas horarias hoy</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="reservas.php" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
      <?php  
      }//fin login usuario
      ?>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
  </div>
  <!-- /.co, ntent-wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>

<!-- Bootstrap slider -->
<script src="plugins/bootstrap-slider/bootstrap-slider.min.js"></script>
<script>
  $(function () {
    /* BOOTSTRAP SLIDER */
    $('.slider').bootstrapSlider()
  })
</script>

<?php
footerToHtmlFinish();
?>
