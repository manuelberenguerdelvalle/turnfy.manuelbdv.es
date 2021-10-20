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
  header ("Location: ".url_completa());
}
$_SESSION['pagina'] = 'index';

$empresa = unserialize($_SESSION['obj_empresa']);
$id_empresa = $_SESSION['id_empresa'];
if(!empty($empresa -> getValor('nombre'))){$nombre = $empresa -> getValor('nombre');}
else{$nombre = $empresa -> getValor('usuario');}

if ($_SESSION['login'] == 'id_usuario'){
  include_once ("../class/usuarios.php");
  $usuario = unserialize($_SESSION['obj_usuario']);
  $nombre = $usuario -> getValor('usuario');
}

$textos = obtener_textos_reserva($empresa -> getValor('tipo_evento'));
headToTitle();
?>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

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
  <script type="text/javascript">
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
    <?php pageHeader("Turnos: ".substr(nombre_dia_semana(date("N")),0,2)." ".date("d/m/Y")); ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-md-6">
            <div class="card card-outline card-olive">
              <div class="card-header">
                <div class="card-title col-10">
                  <!-- select -->
                  <div class="form-group">
                    <select id="select_turnos" class="form-control border-olive input-lg" onchange="cargar_datos(this.value)">
                      <option value=0>Selecciona una franja horaria</option>
                    <?php
                      $db = new MySQL($_SESSION['pagina']);
                      $c = $db->consulta("SELECT * FROM turnos WHERE id_empresa = '$id_empresa' AND estado = '0' and fecha_inicio = '".date('Y-m-d')."' order by fecha_inicio; ");
                      while($r = $c->fetch_array(MYSQLI_ASSOC)){
                        $id_turno = $r['id_turno'];
                        $descripcion = $r['descripcion'];
                        $hora_inicio = $r['hora_inicio'];
                        $hora_fin = $r['hora_fin'];
                    ?>
                      <option value="<?= $id_turno ?>"><?= substr($hora_inicio,0,5).'h - '.substr($hora_fin,0,5).'h '.$descripcion ?></option>
                    <?php
                    }//fin while
                    ?>
                    </select>
                  </div>

                </div>    
                <div class="card-tools">
                  <?php
                  if( $_SESSION['login'] == 'id_empresa' || ($_SESSION['login'] == 'id_usuario' && $usuario -> getValor('gestion_turnos') == 'S') ){
                  ?>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" onclick="eliminar_turno_desde_reserva()"><i class="fas fa-times"></i></button>
                  <?php
                  }
                  ?>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-header">
                <div class="row">
                  <div class="col-4 col-sm-6">
                      <button id="botonmas" type="button" class="btn bg-gradient-light btn-app d-none float-left" onclick="crear_reserva('<?= $textos[6] ?>','<?= $textos[7] ?>')"><i class="fas fa-plus"></i></button>
                  </div>
                  <div class="col-8 col-sm-6">
                    <!-- form start -->
                    <form role="form" class="float-right">
                      <div id="botonesLista" class="btn-group btn-group-toggle d-none" data-toggle="buttons">
                        <label class="btn bg-gradient-white active">
                            <input type="radio" name="options" id="activos" value="0" autocomplete="off" onchange="enviar_modo(this.value)" checked><span id="logoActivos" class="fas fa-book-open"></span>
                        </label>
                        <label class="btn bg-gradient-white active">
                            <input type="radio" name="options" id="usuario" value="3" autocomplete="off" onchange="enviar_modo(this.value)"><span id="logoUsuario" class="fas fa-user"></span>
                        </label>
                        <?php
                        if($empresa -> getValor('tipo_evento') == '1'){
                        ?>  
                        <label class="btn bg-gradient-white">
                            <input type="radio" name="options" id="servicio" value="2" autocomplete="off" onchange="enviar_modo(this.value)"><span id="logoEliminados" class="fas fa-utensils"></span>
                        </label>
                        <?php
                        }
                        else{
                        ?>
                        <label class="btn bg-gradient-white">
                          <input type="radio" name="options" id="servicio" value="2" autocomplete="off" onchange="enviar_modo(this.value)"><span id="logoEliminados" class="fas fa-check"></span>
                        </label>
                        <?php 
                        }
                        ?>
                        <label class="btn bg-gradient-white">
                            <input type="radio" name="options" id="eliminados" value="1" autocomplete="off" onchange="enviar_modo(this.value)"><span id="logoEliminados" class="fas fa-trash"></span>
                        </label>
                      </div>     
                    </form>
                    <!-- form stop -->
                  </div>
                </div>
                <!-- /.row -->
              </div> 
              <!-- /.card-header -->

              <!-- AQUI MOSTRAMOS LA CABECERA CON LOS DATOS ACTUALIZANDOS -->
              <div id="cabecera_datos">
              </div>
              <div id="contenido_datos">
              </div>

            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

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
