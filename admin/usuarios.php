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

//validacion de acceso a pagina
if( $_SESSION['login'] == 'id_empresa' || ($_SESSION['login'] == 'id_usuario' && $usuario -> getValor('gestion_turnos') == 'S') ){

headToTitle();
?>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!--<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.0.js"></script>-->
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE -->
  <script src="dist/js/adminlte.js"></script>


  <!-- OPTIONAL SCRIPTS -->
  <!-- Generales -->
  <script src="../funciones/generales.js"></script>

  <!-- SweetAlert2 -->
  <script src="plugins/sweetalert2/sweetalert2.min.js"></script>

  <script type="text/javascript">
      //$(document).ready(function(){
      //cargar(".pagina_principal","pages/usuarios.php");
      //});
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
    <?php pageHeader("Usuarios"); ?>
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
            <div class="card card-outline card-success">
              <div class="card-header">
                <h3 class="card-title" data-card-widget="collapse">Nuevo Usuario</h3>

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
                      <label for="exampleInputEmail1">Usuario</label>
                      <input name="usuario" type="text" class="form-control" id="usuario0" onkeyup="valida_usuario(0)" placeholder="Nombre de usuario" maxlength="30" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input name="password" type="text" class="form-control" id="password0" onkeyup="valida_password(0)" placeholder="Password" maxlength="20" required>
                    </div>
                    <!-- radio -->
                    <div class="form-group">
                      <label for="exampleInputPassword1">Puede crear franjas horarias</label>
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio2" name="gestionar_turnos" value="N" checked>
                        <label for="customRadio2" class="custom-control-label">No</label>
                      </div>
                      <div class="custom-control custom-radio">
                        <input class="custom-control-input" type="radio" id="customRadio1" name="gestionar_turnos" value="S">
                        <label for="customRadio1" class="custom-control-label">Sí</label>
                      </div>
                      <div class="form-group">
                        <input name="id_usuario" type="hidden" value="0">
                      </div>
                      <div class="form-group">
                        <input name="operacion" type="hidden" value="I">
                      </div>
                    </div>
                    <button id="botonNuevoUsuario0" type="button" class="btn btn-success" onclick="enviar_usuario(0)" disabled>Crear</button>
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
          $c = $db->consulta("SELECT id_usuario, usuario, password, gestion_turnos FROM usuarios WHERE id_empresa = '$id_empresa' AND estado = '0' order by usuario; ");
          while($r = $c->fetch_array(MYSQLI_ASSOC)){
            $id_usuario = $r['id_usuario'];
            $nombre_usuario = $r['usuario'];
          ?>
          <div class="row">
            <div class="col-md-6">
              <div class="card card-success collapsed-card">
                <div class="card-header">
                  <div class="card-title col-11" data-card-widget="collapse"><?= $nombre_usuario ?></div>
                  <div class="card-tools">
                    <!--<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-edit"></i></button>-->
                    <button type="button" class="btn btn-tool" data-card-widget="remove" onclick="eliminar(<?= $id_usuario ?>,'<?= $nombre_usuario ?>')"><i class="fas fa-times"></i></button>
                  </div>
                  <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <!-- form start -->
                  <form role="form" id="formLogin<?= $id_usuario ?>">
                    <div class="card-body">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Usuario</label>
                        <input name="usuario" type="text" class="form-control" id="usuario<?= $id_usuario ?>" onkeyup="valida_usuario(<?= $id_usuario ?>)" value="<?= $nombre_usuario ?>" maxlength="30" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input name="password" type="text" class="form-control" id="password<?= $id_usuario ?>" onkeyup="valida_password(<?= $id_usuario ?>)" value="<?= $r['password'] ?>" maxlength="20" required>
                      </div>
                      <!-- radio -->
                      <div class="form-group">
                        <label for="exampleInputPassword1">Puede crear franjas horarias</label>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio2<?= $id_usuario ?>" name="gestionar_turnos" value="N" <?php if($r['gestion_turnos'] == 'N') echo 'checked'?> >
                          <label for="customRadio2<?= $id_usuario ?>" class="custom-control-label">No</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="customRadio1<?= $id_usuario ?>" name="gestionar_turnos" value="S" <?php if($r['gestion_turnos'] == 'S') echo 'checked'?> >
                          <label for="customRadio1<?= $id_usuario ?>" class="custom-control-label">Sí</label>
                        </div>
                      </div>
                      <div class="form-group">
                        <input name="id_usuario" type="hidden" value="<?= $id_usuario ?>">
                      </div>
                      <div class="form-group">
                        <input name="operacion" type="hidden" value="U">
                      </div>
                      <button id="botonNuevoUsuario<?= $id_usuario ?>" type="button" class="btn btn-success" onclick="enviar_usuario('<?= $id_usuario ?>')">Modificar</button>
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
  <!-- /.content-wrapper -->

<?php
footerToHtmlFinish();
}// FIN validacion de acceso a pagina
else{
  header ("Location: ".url_completa());
}
?>
