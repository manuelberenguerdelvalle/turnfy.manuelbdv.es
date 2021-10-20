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
    <?php pageHeader("Cuenta"); ?>
    <!-- Main content -->
    
    <section class="content">
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
      
      <div class="container-fluid">
        <div class="row d-flex align-items-stretch">
          <div class="col-12 col-sm-8 col-md-6 d-flex align-items-stretch">
            <div class="card bg-light col-12">
              <div class="card-header text-muted border-bottom-0">
                <?= $empresa -> getValor('nombre'); ?>
              </div>
              <div class="card-body pt-0">
                <div class="row">
                  <div class="col-12 col-sm-10">
                    <form role="form" id="formLogin">
                        <div class="form-group">
                          <label for="empresa"><i class="fas fa-building"></i>  Empresa</label>
                          <input name="nombre" type="text" class="form-control" id="nombre" value="<?= $empresa -> getValor('nombre'); ?>" maxlength="50" required>
                        </div>
                        <div class="form-group">
                          <label for="usuario"><i class="fas fa-user-tie"></i>  Usuario</label>
                          <input name="usuario" type="text" class="form-control" id="usuario" onkeyup="valida_empresa(<?= $empresa -> getValor('id_empresa'); ?>)" value="<?= $empresa -> getValor('usuario'); ?>" maxlength="30" required>
                        </div>
                        <div class="form-group">
                          <label for="password"><i class="fas fa-lock-open"></i>  Password</label>
                          <input name="password" type="password" class="form-control" id="password" value="<?= $empresa -> getValor('password'); ?>" maxlength="20" required>
                        </div>
                        <div class="form-group">
                          <label for="repassword"><i class="fas fa-lock-open"></i>  Repite Password</label>
                          <input name="repassword" type="password" class="form-control" id="repassword" placeholder="Repite la contraseña para cambiarla" maxlength="20" required>
                        </div>
                        <div class="form-group">
                          <label for="tipo_evento"><i class="fas fa-id-card"></i>  Sector</label>
                          <select name="tipo_evento" id="tipo_evento" class="form-control">
                            <?php
                              $db = new MySQL($_SESSION['pagina']);
                              $c = $db->consulta("SELECT * FROM eventos ; ");
                              while($r = $c->fetch_array(MYSQLI_ASSOC)){
                                $id_evento = $r['id_evento'];
                                $descripcion = $r['descripcion'];
                                if($empresa -> getValor('tipo_evento') == $id_evento){
                            ?>
                              <option value="<?= $id_evento ?>" selected><?= $descripcion ?></option>
                            <?php
                                }
                                else{
                            ?>
                              <option value="<?= $id_evento ?>"><?= $descripcion ?></option>
                            <?php
                                }
                              }//fin while
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="telefono"><i class="fas fa-phone"></i>  Telefono (Opcional)</label>
                          <input name="telefono" type="text" class="form-control" id="telefono" value="<?= $empresa -> getValor('telefono'); ?>" maxlength="30">
                        </div>
                        <div class="form-group">
                          <label for="direccion"><i class="fas fa-map-marker-alt"></i>  Dirección (Opcional)</label>
                          <input name="direccion" type="text" class="form-control" id="direccion" value="<?= $empresa -> getValor('direccion'); ?>" maxlength="30">
                        </div>
                        <div class="form-group">
                          <input name="operacion" type="hidden" class="form-control" value="U">
                        </div>
                        <button id="botonNuevoUsuario" type="button" class="btn btn-info" onclick="modificar_cuenta()">Modificar</button>
                    </form>
                    <!-- form stop -->
                  </div>
                  <!--
                  <div class="col-5 text-center">
                    <img src="../images/usuario_normal_256.png" alt="" class="img-circle img-fluid">
                  </div>
                  -->
                </div>
              </div>
              <div class="card-footer">
                <!--
                <div class="text-right">
                  <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                  </a>
                  <a href="#" class="btn btn-sm btn-primary">
                    <i class="fas fa-user"></i> View Profile
                  </a>
                </div>
                -->
              </div>
            </div>
          </div>
        </div>
      
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
