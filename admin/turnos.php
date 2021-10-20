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

// validacion de acceso a pagina
if( $_SESSION['login'] == 'id_empresa' || ($_SESSION['login'] == 'id_usuario' && $usuario -> getValor('gestion_turnos') == 'S') ){

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
    }*/
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
    <?php pageHeader("Franjas Horarias"); ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <?php
        if(isset($_SESSION['alerta_usuario']) && $_SESSION['alerta_usuario'] == "success"){
        ?>
        <div class="row">
          <div class="alert alert-success alert-dismissible" id="alertaOk">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h6><i class="icon fas fa-check"></i> <?= $_SESSION['alerta_mensaje'] ?></h6>
          </div>
        </div>
        <?php
        }//fin if
        elseif (isset($_SESSION['alerta_usuario']) && $_SESSION['alerta_usuario'] == "warning") {
        ?>
        <div class="row">
          <div class="alert alert-warning alert-dismissible d-none" id="alertaWarnin">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h6><i class="icon fas fa-exclamation-triangle"></i> <?= $_SESSION['alerta_mensaje'] ?></h6>
          </div>
        </div>
        <?php
        }//fin elseif
        unset($_SESSION['alerta_usuario']);
        ?>
        <div class="row">
          <div class="col-md-6">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title" data-card-widget="collapse">Nueva Franja Horaria</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- form start -->
                <form role="form" id="formLogin0">
        
                  <div class="card-body">
                    <div class="form-group">
                      <label >Día</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="far fa-calendar-alt"></i>
                          </span>
                        </div>
                        <input type="date" name="fecha" max="2050-12-31" min="<?= date("Y-m-d",strtotime(date('Y-m-d')."- 1 year"));?>" class="form-control" value="<?= date("Y-m-d");?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label >Horario</label>
                        <div class="slider-blue">
                          <input name="horario" type="text" value="" class="slider form-control" data-slider-min="0" data-slider-max="24"
                              data-slider-step="0.5" data-slider-value="[8,14]" data-slider-orientation="horizontal"
                              data-slider-selection="before" data-slider-tooltip="show">
              
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <!--
                    <div class="form-group">
                      <div class="row">
                        <label class="col-6 d-inline">Hora Inicio</label>
                        <label class="col-6 d-inline">Hora Fin</label>
                      </div>
                      
                      <div class="row">
                        <div class="col-6">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="far fa-clock"></i>
                              </span>
                            </div>
                            <input type="time" id="appt" name="inicio" min="00:00" max="24:00" value="08:00" class="form-control">
                          </div>
                        </div>
                        
                        <div class="col-6">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="far fa-clock"></i>
                              </span>
                            </div>
                            <input type="time" id="appt" name="fin" min="00:00" max="24:00" value="14:00" class="form-control">
                          </div>
                        </div>

                      </div> 
                    </div>
                    -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Descripción</label>
                      <input name="descripcion" type="text" class="form-control" id="descripcion0" placeholder="Descripcion (Opcional)" maxlength="50">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Número de asistentes</label>
                      <input name="asistentes" type="number" class="form-control" id="asistentes0" placeholder="Rellenar si conoce el número de asistencias (Opcional)"  maxlength="14">
                    </div>
                    <div class="form-group">
                      <label for="suma_ganancias0">Ganancias (€)</label>
                      <input name="suma_ganancias" type="number" class="form-control" id="suma_ganancias0" placeholder="Rellenar si conoce las ganancias obtenidas (Opcional)" maxlength="14" >
                    </div>
                    <!--
                    <div class="form-group">
                      <label for="personas_max0">Grupo máximo de personas por reserva</label>
                      <input name="personas_max" type="number" class="form-control" id="personas_max0" placeholder="Rellenar si va a insertar las asistencias en tiempo real (Opcional)" maxlength="14" >
                    </div>
                    -->
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                              <input name="repetir" class="custom-control-input" type="checkbox" id="repetir0" value="S">
                              <label for="repetir0" class="custom-control-label">Repetir franja horaria</label>
                            </div>
                        </div>
                      </div>
                      <div class="col-sm-6 d-inline">
                        <!-- select -->
                        <div class="form-group">
                          <select name="dias" class="custom-select">
                            <option value="1">1 día</option>
                            <option value="2">2 días</option>
                            <option value="3">3 días</option>
                            <option value="4">4 días</option>
                            <option value="5">5 días</option>
                            <option value="6">6 días</option>
                            <option value="7">7 días</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <input name="id_turno" type="hidden" value="0">
                    </div>
                    <div class="form-group">
                      <input name="operacion" type="hidden" value="I">
                    </div>
                    <button id="botonNuevoUsuario0" type="button" class="btn btn-primary" onclick="enviar_turno(0)" >Crear</button>
                  </div>
                  <!-- /.card-body -->
                </form>
                <!-- form stop -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div id="all_users">
          <?php
          $db = new MySQL($_SESSION['pagina']);
          $c = $db->consulta("SELECT * FROM turnos WHERE id_empresa = '$id_empresa' AND estado = '0' order by id_turno desc; ");
          while($r = $c->fetch_array(MYSQLI_ASSOC)){
            $id_turno = $r['id_turno'];
            $id_usuario_creador = $r['id_usuario'];
	          $id_empresa = $r['id_empresa'];
	          $fecha_inicio = $r['fecha_inicio'];
	          $hora_inicio = $r['hora_inicio']; 
	          $fecha_fin = $r['fecha_fin'];
	          $hora_fin = $r['hora_fin'];
	          $suma_ganancias = $r['suma_ganancias'];
	          $personas_max = $r['personas_max'];
	          $tipo_evento = $r['tipo_evento']; 
            $descripcion = $r['descripcion'];
            $asistentes = $r['asistentes'];
            
            $date = new DateTime($fecha_inicio);
            $resumen = "";
            if(!empty($date)){$resumen .= substr(nombre_dia_semana($date->format('N')),0,2).' ';}
            if(!empty($date)){$resumen .= $date->format('d/m/Y').' | ';}
            if(!empty($hora_inicio)){$resumen .= substr($hora_inicio,0,5).' - ';}
            if(!empty($hora_fin)){$resumen .= substr($hora_fin,0,5).' | ';}
            if(!empty($descripcion)){$resumen .= substr(ucfirst($descripcion),0,28);}
          ?>
          <div class="row">
            <div class="col-md-6">
              <div class="card card-primary collapsed-card">
                <div class="card-header">
                  <div class="col-11">
                    <h3 class="card-title" data-card-widget="collapse"><?= $resumen ?></h3>
                  </div>
                  <div class="card-tools">
                    <!--<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-edit"></i></button>-->
                    <button type="button" class="btn btn-tool" data-card-widget="remove" onclick="eliminar_turno(<?= $id_turno ?>)"><i class="fas fa-times"></i></button>
                  </div>
                  <!-- /.card-tools right -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <!-- form start -->
                  <form role="form" id="formLogin<?= $id_turno ?>">
          
                    <div class="card-body">
                      <div class="form-group">
                        <label >Día</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="far fa-calendar-alt"></i>
                            </span>
                          </div>
                          <input type="date" name="fecha" max="2050-12-31" min="<?= date("Y-m-d",strtotime(date('Y-m-d')."- 1 year"));?>" class="form-control" value="<?= $date->format('Y-m-d') ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label >Horario</label>
                          <div class="slider-blue">
                            <input name="horario" type="text" value="" class="slider form-control" data-slider-min="0" data-slider-max="24"
                                data-slider-step="0.5" data-slider-value="[<?= decodificar($hora_inicio) ?>,<?= decodificar($hora_fin) ?>]" data-slider-orientation="horizontal"
                                data-slider-selection="before" data-slider-tooltip="show">
                
                          </div>
                      </div>
                      <!-- /.card-body -->
                      <div class="form-group">
                        <label for="exampleInputEmail1">Descripción</label>
                        <input name="descripcion" type="text" class="form-control" id="descripcion<?= $id_turno ?>" value="<?= $descripcion ?>"  placeholder="Descripcion (Opcional)" maxlength="50">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Número de asistentes</label>
                        <input name="asistentes" type="number" class="form-control" id="asistentes<?= $id_turno ?>" value="<?= $asistentes ?>" placeholder="Rellenar si conoce el número de asistencia (Opcional)"  maxlength="14">
                      </div>
                      <div class="form-group">
                        <label for="suma_ganancias<?= $id_turno ?>">Ganancias (€)</label>
                        <input name="suma_ganancias" type="number" class="form-control" id="suma_ganancias<?= $id_turno ?>" value="<?= $suma_ganancias ?>" placeholder="Rellenar si conoce las ganancias obtenidas (Opcional)" maxlength="14" >
                      </div>
                      <!--
                      <div class="form-group">
                        <label for="personas_max<?= $id_turno ?>">Grupo máximo de personas por reserva</label>
                        <input name="personas_max" type="number" class="form-control" id="personas_max<?= $id_turno ?>" value="<?= $personas_max ?>" placeholder="Rellenar si va a insertar las asistencias en tiempo real (Opcional)" maxlength="14" >
                      </div>
                      -->
                      <div class="form-group">
                        <input name="id_turno" type="hidden" value="<?= $id_turno ?>">
                      </div>
                      <div class="form-group">
                        <input name="operacion" type="hidden" value="U">
                      </div>
                      <button id="botonNuevoUsuario<?= $id_turno ?>" type="button" class="btn btn-primary" onclick="enviar_turno(<?= $id_turno ?>)" >Modificar</button>
                    </div>
                    <!-- /.card-body -->
                  </form>
                  <!-- form stop -->
                </div>
              <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->
          <?php
          }//fin while
          ?>
        </div>
        <!-- /.all_users -->

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
}// FIN validacion de acceso a pagina
else{
  header ("Location: ".url_completa());
}
?>
