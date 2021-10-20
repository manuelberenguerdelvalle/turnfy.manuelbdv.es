<?php
include_once ("../funciones/html.php");
include_once ("../funciones/generales.php");
include_once ("../funciones/graficas.php");
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
if($_SESSION['login'] == 'id_empresa'){

headToTitle();
?>

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- OPTIONAL SCRIPTS -->
  <!-- Generales -->
  <script src="../funciones/generales.js"></script>
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
    <?php pageHeader("Estadísticas Anuales"); ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php
        ////////////////////////////////////////////////////////////////////////
        ////// INICIO montamos estadisticas globales, el primer inicio con todos los checks de horarios
        ////////////////////////////////////////////////////////////////////////
        //revisamos si hay carga de datos
        if( !isset($_SESSION['enero_total_anual']) || 
        ( empty($_SESSION['enero_total_anual']) && empty($_SESSION['febrero_total_anual']) && empty($_SESSION['marzo_total_anual']) && empty($_SESSION['abril_total_anual']) && empty($_SESSION['mayo_total_anual'])
        && empty($_SESSION['junio_total_anual']) && empty($_SESSION['julio_total_anual']) && empty($_SESSION['agosto_total_anual']) && empty($_SESSION['septiembre_total_anual']) && empty($_SESSION['octubre_total_anual'])
        && empty($_SESSION['noviembre_total_anual']) && empty($_SESSION['diciembre_total_anual']) ) ){
          estadisticas_total_anual($id_empresa,0);//para cargar todos los meses
        }
        else{
          estadisticas_total_anual($id_empresa,date('n'));//para cargar solo mes actual
        }
        
        $data_turnos = '';
        $data_ganancias = '';
        $data_asistencias = '';
        //x = mes enero,febrero,marzo...
        //$_SESSION['x_total_anual'][0] // nombre del mes mas el año actual 2020, 2021
        //$_SESSION['x_total_anual'][1] // sumatorio de turnos
        //$_SESSION['x_total_anual'][2] // sumatorio ganancias
        //$_SESSION['x_total_anual'][3] // sumatorio asistencias/reservas
        $meses_turnos = array();
        $cont1 = 0;
        $meses_ganancias = array();
        $cont2 = 0;
        $meses_asistencias = array();
        $cont3 = 0;
        $meses = obten_nombreMeses();
        $meses_organizado = organizar_meses(date('n'));
        for($i=0; $i < count($meses_organizado); $i++){
          $nom_mes = $meses[$meses_organizado[$i]-1];

          if($_SESSION[$nom_mes.'_total_anual'][1] > 0){ $data_turnos .= $_SESSION[$nom_mes.'_total_anual'][1]."-"; $meses_turnos[$cont1] = $_SESSION[$nom_mes.'_total_anual'][0]; $cont1++; }
          if($_SESSION[$nom_mes.'_total_anual'][2] > 0){ $data_ganancias .= $_SESSION[$nom_mes.'_total_anual'][2]."-"; $meses_ganancias[$cont2] = $_SESSION[$nom_mes.'_total_anual'][0];$cont2++; }
          if($_SESSION[$nom_mes.'_total_anual'][3] > 0){ $data_asistencias .= $_SESSION[$nom_mes.'_total_anual'][3]."-"; $meses_asistencias[$cont3] = $_SESSION[$nom_mes.'_total_anual'][0];$cont3++; }
          
        }//fin for
        
        for($i = 0; $i < 12; $i++){//vaciamos los meses que no tienen nada
          if(empty($meses_turnos[$i])){
            $meses_turnos[$i] = '';
          }
          if(empty($meses_ganancias[$i])){
            $meses_ganancias[$i] = '';
          }
          if(empty($meses_asistencias[$i])){
            $meses_asistencias[$i] = '';
          }
        }
        if($meses_turnos[0] == ''){$label_turnos = 'No hay datos';}
        else{$label_turnos = 'Franjas Horarias Totales';}
        if($meses_ganancias[0] == ''){$label_ganancias = 'No hay datos';}
        else{$label_ganancias = 'Ingresos (€) Totales';}
        if($meses_asistencias[0] == ''){$label_asistencias = 'No hay datos';}
        else{$label_asistencias = 'Asistencias Totales';}

        //Sacamos los totales, medias y registros para hacer los cáculos
        $totales_turnos = 0;
        $media_turnos = 0;
        $registros_turnos = 0;
        $totales_ganancias = 0;
        $media_ganancias = 0;
        $registros_ganancias = 0;
        $totales_asistencias = 0;
        $media_asistencias = 0;
        $registros_asistencias = 0;
        $aux = explode('-', $data_turnos);
        for($i=0; $i < count($aux); $i++){
          if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
            $totales_turnos += $aux[$i];
          }
        }
        if($totales_turnos > 0){
          $media_turnos = $totales_turnos/(count($aux)-1);
        }
        $registros_turnos = count($aux)-1;
        unset($aux);
        $aux = explode('-', $data_ganancias);
        for($i=0; $i < count($aux); $i++){
          if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
            $totales_ganancias += $aux[$i];
          }
        }
        if($totales_ganancias){
          $media_ganancias = $totales_ganancias/(count($aux)-1);
        }
        $registros_ganancias = count($aux)-1;
        unset($aux);
        $aux = explode('-', $data_asistencias);
        for($i=0; $i < count($aux); $i++){
          if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
            $totales_asistencias += $aux[$i];
          }
        }
        if($totales_asistencias > 0){
          $media_asistencias = $totales_asistencias/(count($aux)-1);
        }
        $registros_asistencias = count($aux)-1;
        ////////////////////////////////////////////////////////////////////////
        ////// FIN montamos estadisticas globales, el primer inicio con todos los checks de horarios
        ////////////////////////////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////////////////
        ////// INICIO montamos estadisticas parciales, con los checks de horarios habilitados/desahabilitados
        ////////////////////////////////////////////////////////////////////////
        if(isset($_POST['horarios'])){
          $_SESSION['horarios_recibidos_anual'] = $_POST['horarios'];//asignamos los checks recibidos habilitados/deshbilitados
          estadisticas_parcial_anual($id_empresa);

          $data_turnos_parcial = '';
          $data_ganancias_parcial = '';
          $data_asistencias_parcial = '';
          //x = mes enero,febrero,marzo...
          //$_SESSION['x_parcial_anual'][0] // nombre del mes mas el año actual 2020, 2021
          //$_SESSION['x_parcial_anual'][1] // sumatorio de turnos
          //$_SESSION['x_parcial_anual'][2] // sumatorio ganancias
          //$_SESSION['x_parcial_anual'][3] // sumatorio asistencias/reservas
          $meses_turnos_parcial = array();
          $cont1 = 0;
          $meses_ganancias_parcial = array();
          $cont2 = 0;
          $meses_asistencias_parcial = array();
          $cont3 = 0;
          $meses = obten_nombreMeses();
          $meses_organizado = organizar_meses(date('n'));
          for($i=0; $i < count($meses_organizado); $i++){
            $nom_mes = $meses[$meses_organizado[$i]-1];

            if($_SESSION[$nom_mes.'_parcial_anual'][1] > 0){ $data_turnos_parcial .= $_SESSION[$nom_mes.'_parcial_anual'][1]."-"; $meses_turnos_parcial[$cont1] = $_SESSION[$nom_mes.'_parcial_anual'][0]; $cont1++; }
            if($_SESSION[$nom_mes.'_parcial_anual'][2] > 0){ $data_ganancias_parcial .= $_SESSION[$nom_mes.'_parcial_anual'][2]."-"; $meses_ganancias_parcial[$cont2] = $_SESSION[$nom_mes.'_parcial_anual'][0];$cont2++; }
            if($_SESSION[$nom_mes.'_parcial_anual'][3] > 0){ $data_asistencias_parcial .= $_SESSION[$nom_mes.'_parcial_anual'][3]."-"; $meses_asistencias_parcial[$cont3] = $_SESSION[$nom_mes.'_parcial_anual'][0];$cont3++; }
            
          }//fin for
          
          for($i = 0; $i < 12; $i++){//vaciamos los meses que no tienen nada
            if(empty($meses_turnos_parcial[$i])){
              $meses_turnos_parcial[$i] = '';
            }
            if(empty($meses_ganancias_parcial[$i])){
              $meses_ganancias_parcial[$i] = '';
            }
            if(empty($meses_asistencias_parcial[$i])){
              $meses_asistencias_parcial[$i] = '';
            }
          }
          if($meses_turnos_parcial[0] == ''){$label_turnos_parcial = 'No hay datos';}
          else{$label_turnos_parcial = 'Franjas Horarias Seleccionadas';}
          if($meses_ganancias_parcial[0] == ''){$label_ganancias_parcial = 'No hay datos';}
          else{$label_ganancias_parcial = 'Ingresos (€) Seleccionados';}
          if($meses_asistencias_parcial[0] == ''){$label_asistencias_parcial = 'No hay datos';}
          else{$label_asistencias_parcial = 'Asistencias Seleccionadas';}

          //Sacamos los totales, medias y registros para hacer los cáculos
          $totales_turnos_parcial = 0;
          $media_turnos_parcial = 0;
          $registros_turnos_parcial = 0;
          $totales_ganancias_parcial = 0;
          $media_ganancias_parcial = 0;
          $registros_ganancias_parcial = 0;
          $totales_asistencias_parcial = 0;
          $media_asistencias_parcial = 0;
          $registros_asistencias_parcial = 0;
          $aux = explode('-', $data_turnos_parcial);
          for($i=0; $i < count($aux); $i++){
            if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
              $totales_turnos_parcial += $aux[$i];
            }
          }
          $media_turnos_parcial = $totales_turnos_parcial/(count($aux)-1);
          $registros_turnos_parcial = count($aux)-1;
          unset($aux);
          $aux = explode('-', $data_ganancias_parcial);
          for($i=0; $i < count($aux); $i++){
            if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
              $totales_ganancias_parcial += $aux[$i];
            }
          }
          $media_ganancias_parcial = $totales_ganancias_parcial/(count($aux)-1);
          $registros_ganancias_parcial = count($aux)-1;
          unset($aux);
          $aux = explode('-', $data_asistencias_parcial);
          for($i=0; $i < count($aux); $i++){
            if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
              $totales_asistencias_parcial += $aux[$i];
            }
          }
          $media_asistencias_parcial = $totales_asistencias_parcial/(count($aux)-1);
          $registros_asistencias_parcial = count($aux)-1;

        }//fin if recibir checks post
        else{//si entramos la primera vez o no marcamos checks igualamos los datos

          $data_turnos_parcial = $data_turnos;
          $data_ganancias_parcial = $data_ganancias;
          $data_asistencias_parcial = $data_asistencias;
          $label_turnos_parcial = 'Franjas Horarias Seleccionadas';
          $label_ganancias_parcial = 'Ingresos (€) Seleccionados';
          $label_asistencias_parcial = 'Asistencias Seleccionadas';
          $totales_turnos_parcial = $totales_turnos;
          $media_turnos_parcial = $media_turnos;
          $registros_turnos_parcial = $registros_turnos;
          $totales_ganancias_parcial = $totales_ganancias;
          $media_ganancias_parcial = $media_ganancias;
          $registros_ganancias_parcial = $registros_ganancias;
          $totales_asistencias_parcial = $totales_asistencias;
          $media_asistencias_parcial = $media_asistencias;
          $registros_asistencias_parcial = $registros_asistencias;
          
        }

        ?>
        <div class="row justify-content-center">
          <form role="form" id="formHorarios" method="POST" action="estadisticas_anual.php">
            <div class="form-group">
            <?php
              if(isset($_SESSION['horarios_anual'][0])){
                for($i=0; $i < count($_SESSION['horarios_anual']); $i++){
                  if(isset($_POST['horarios'])){
                    $encontrado = false;
                    for($x=0; $x < count($_POST['horarios']); $x++){
                      if($_SESSION['horarios_anual'][$i] == $_POST['horarios'][$x]){
                        $encontrado = true;
                        break;
                      }
                    }
                    if($encontrado){$checked = 'checked';}
                    else{$checked = '';}
                  }
                  else{
                    $checked = 'checked';
                  }
            ?>
                <div class="custom-control custom-checkbox d-inline-flex">
                  <input name="horarios[]" class="custom-control-input" type="checkbox" id="horarios<?= $i ?>" value="<?= $_SESSION['horarios_anual'][$i]; ?>" <?= $checked ?> onclick="enviar_horarios()">
                  <label for="horarios<?= $i ?>" class="custom-control-label"><?= substr($_SESSION['horarios_anual'][$i],0,5).'-'.substr($_SESSION['horarios_anual'][$i],9,5) ?> h &nbsp;&nbsp;</label>
                </div>
            <?php
                }//fin for
              }//fin if
            ?>
            </div>
          </form>
        </div>
        <div class="row">
          <div class="col-md-12">
            <!-- BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Ingresos</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Totales:</label>
                  </div>
                  <div class="col-7">
                    <label class="row" for="exampleInputPassword1"><?= number_format ($totales_ganancias,0,",",".") ?> €</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Promedio:</label>
                  </div>
                  <div class="col-7">
                    <label class="row" for="exampleInputPassword1"><?= number_format ($media_ganancias,1,",",".") ?> €/mes</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Meses:</label>
                  </div>
                  <div class="col-7">
                    <label class="row" for="exampleInputPassword1"><?= $registros_ganancias ?></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row text-secondary" for="exampleInputPassword1">Seleccionados:</label>
                  </div>
                  <div class="col-7">
                    <label class="row text-secondary" for="exampleInputPassword1">
                      <?= number_format ($totales_ganancias_parcial,0,",",".") ?> € 
                      (<?= ($totales_ganancias_parcial != 0) ? round(($totales_ganancias_parcial*100)/$totales_ganancias,1):0 ?> %)
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row text-secondary" for="exampleInputPassword1">Promedio:</label>
                  </div>
                  <div class="col-7">
                    <label class="row text-secondary" for="exampleInputPassword1">
                      <?= number_format ($media_ganancias_parcial,1,",",".") ?> €/mes 
                      <?php
                      if($media_ganancias_parcial != 0){$porcentaje_ganancias = round(($media_ganancias_parcial*100)/$media_ganancias,1);}
                      else{$porcentaje_ganancias = 0;}
                      ?>
                      <?= ($porcentaje_ganancias > 100) ? '(100 %) <span class="text-success">&nbsp;+'.($porcentaje_ganancias-100).' %</span>' : '('.$porcentaje_ganancias.' %)'; ?>
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row text-secondary" for="exampleInputPassword1">Meses:</label>
                  </div>
                  <div class="col-7">
                    <label class="row text-secondary" for="exampleInputPassword1">
                      <?= $registros_ganancias_parcial ?> 
                      (<?= ($registros_ganancias_parcial != 0) ?round(($registros_ganancias_parcial*100)/$registros_ganancias,1):0 ?> %)
                    </label>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <!-- BAR CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Asistencias Totales</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Totales:</label>
                  </div>
                  <div class="col-7">
                    <label class="row" for="exampleInputPassword1"><?= number_format ($totales_asistencias,0,",",".") ?></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Promedio:</label>
                  </div>
                  <div class="col-7">
                    <label class="row" for="exampleInputPassword1"><?= number_format ($media_asistencias,1,",",".") ?> /mes</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Meses:</label>
                  </div>
                  <div class="col-7">
                    <label class="row" for="exampleInputPassword1"><?= $registros_asistencias ?></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row text-secondary" for="exampleInputPassword1">Seleccionadas:</label>
                  </div>
                  <div class="col-7">
                    <label class="row text-secondary" for="exampleInputPassword1">
                      <?= number_format ($totales_asistencias_parcial,0,",",".") ?> 
                      (<?= ($totales_asistencias_parcial != 0) ? round(($totales_asistencias_parcial*100)/$totales_asistencias,1):0 ?> %)
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row text-secondary" for="exampleInputPassword1">Promedio:</label> 
                  </div>
                  <div class="col-7">
                    <label class="row text-secondary" for="exampleInputPassword1">
                    <?= number_format ($media_asistencias_parcial,1,",",".") ?> /mes 
                    <?php
                      if($media_asistencias_parcial != 0){$porcentaje_asistencias = round(($media_asistencias_parcial*100)/$media_asistencias,1);}
                      else{$porcentaje_asistencias = 0;}
                      ?>
                      <?= ($porcentaje_asistencias > 100) ? '(100 %) <span class="text-success">&nbsp;+'.($porcentaje_asistencias-100).' %</span>' : '('.$porcentaje_asistencias.' %)'; ?>
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row text-secondary" for="exampleInputPassword1">Meses:</label>
                  </div>
                  <div class="col-7">
                    <label class="row text-secondary" for="exampleInputPassword1">
                      <?= $registros_asistencias_parcial ?> 
                      (<?= ($registros_asistencias_parcial != 0) ?round(($registros_asistencias_parcial*100)/$registros_asistencias,1):0 ?> %)
                    </label>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <!-- BAR CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Franjas Horarias Totales</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart3" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Totales:</label>
                  </div>
                  <div class="col-7">
                    <label class="row" for="exampleInputPassword1"><?= number_format ($totales_turnos,0,",",".") ?></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Promedio:</label>
                  </div>
                  <div class="col-7">
                    <label class="row" for="exampleInputPassword1"><?= number_format ($media_turnos,1,",",".") ?> /mes</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Meses:</label>
                  </div>
                  <div class="col-7">
                    <label class="row" for="exampleInputPassword1"><?= $registros_turnos ?></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row text-secondary" for="exampleInputPassword1">Seleccionados: </label>
                  </div>
                  <div class="col-7">
                    <label class="row text-secondary" for="exampleInputPassword1">
                      <?= number_format ($totales_turnos_parcial,0,",",".") ?> 
                      (<?= ($totales_turnos_parcial != 0) ? round(($totales_turnos_parcial*100)/$totales_turnos,1):0 ?> %)
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row text-secondary" for="exampleInputPassword1">Promedio:</label> 
                  </div>
                  <div class="col-7">
                    <label class="row text-secondary" for="exampleInputPassword1">
                      <?= number_format ($media_turnos_parcial,1,",",".") ?> /mes 
                      (<?= ($media_turnos_parcial != 0) ? round(($media_turnos_parcial*100)/$media_turnos,1):0 ?> %)
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row text-secondary" for="exampleInputPassword1">Meses:</label>
                  </div>
                  <div class="col-7">
                    <label class="row text-secondary" for="exampleInputPassword1">
                      <?= $registros_turnos_parcial ?> 
                      (<?= ($registros_turnos_parcial != 0) ? round(($registros_turnos_parcial*100)/$registros_turnos,1):0 ?> %)
                    </label>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!---------------------------------------------------------------->
        <!-- IMPORTANTE ES NECESARIO QUE EXITA ESTE AREA PERO SE OCULTA -->
        <!---------------------------------------------------------------->
        <!-- AREA CHART -->
        <div class="card card-primary d-none">
          <div class="card-header">
            <h3 class="card-title">Area Chart</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <!-- IMPORTANTE ES ESTA ETIQUETA CANVAS -->
              <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
  </div>
  <!-- /.co, ntent-wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      //labels  : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      <?php labels($meses_ganancias[0], $meses_ganancias[1], $meses_ganancias[2], $meses_ganancias[3], $meses_ganancias[4], $meses_ganancias[5], $meses_ganancias[6], $meses_ganancias[7], $meses_ganancias[8], $meses_ganancias[9], $meses_ganancias[10], $meses_ganancias[11]); ?>
      datasets: [
        <?php datasets($label_ganancias,'rgba(60,188,141,0.9)','rgba(60,188,141,0.8)',false,'#3BBA90','rgba(60,188,141,1)','#fff','rgba(60,188,141,1)',$data_ganancias); ?>
        <?php datasets($label_ganancias_parcial,'rgba(210, 214, 222, 1)','rgba(210, 214, 222, 1)',false,'rgba(210, 214, 222, 1)','#c1c7d1','#fff','rgba(220,220,220,1)',$data_ganancias_parcial); ?>
        /*
        {
          label               : 'Asistencias en turnos',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },

        {
          label               : 'Ganancias(€)',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
        */
      ]
    }

    //--------------
    //- AREA CHART2 -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas2 = $('#areaChart').get(0).getContext('2d')

    var areaChartData2 = {
      <?php labels($meses_asistencias[0], $meses_asistencias[1], $meses_asistencias[2], $meses_asistencias[3], $meses_asistencias[4], $meses_asistencias[5], $meses_asistencias[6], $meses_asistencias[7], $meses_asistencias[8], $meses_asistencias[9], $meses_asistencias[10], $meses_asistencias[11]); ?>
      datasets: [
        <?php datasets($label_asistencias,'rgba(60,132,188,0.9)','rgba(60,132,188,0.8)',false,'#3b8bba','rgba(60,132,188,1)','#fff','rgba(60,132,188,1)',$data_asistencias); ?>
        <?php datasets($label_asistencias_parcial,'rgba(210, 214, 222, 1)','rgba(210, 214, 222, 1)',false,'rgba(210, 214, 222, 1)','#c1c7d1','#fff','rgba(220,220,220,1)',$data_asistencias_parcial); ?>
      ]
    }

    //--------------
    //- AREA CHART3 -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas3 = $('#areaChart').get(0).getContext('2d')

    var areaChartData3 = {
      <?php labels($meses_turnos[0], $meses_turnos[1], $meses_turnos[2], $meses_turnos[3], $meses_turnos[4], $meses_turnos[5], $meses_turnos[6], $meses_turnos[7], $meses_turnos[8], $meses_turnos[9], $meses_turnos[10], $meses_turnos[11]); ?>
      datasets: [
        <?php datasets($label_turnos,'rgba(30,187,212,0.9)','rgba(30,187,212,0.8)',false,'rgba(30,187,212,1)','#1BA4B9','#fff','rgba(30,187,212,1)',$data_turnos); ?>
        <?php datasets($label_turnos_parcial,'rgba(210, 214, 222, 1)','rgba(210, 214, 222, 1)',false,'rgba(210, 214, 222, 1)','#c1c7d1','#fff','rgba(220,220,220,1)',$data_turnos_parcial); ?>
      ]
    }


    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas3, { 
      type: 'line',
      data: areaChartData3, 
      options: areaChartOptions
    })


    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp0
    barChartData.datasets[1] = temp1

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

    //-------------
    //- BAR CHART2 -
    //-------------
    var barChart2Canvas = $('#barChart2').get(0).getContext('2d')
    var barChart2Data = jQuery.extend(true, {}, areaChartData2)
    var temp02 = areaChartData2.datasets[0]
    var temp12 = areaChartData2.datasets[1]
    barChart2Data.datasets[0] = temp02
    barChart2Data.datasets[1] = temp12

    var barChart2Options = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart2 = new Chart(barChart2Canvas, {
      type: 'bar', 
      data: barChart2Data,
      options: barChart2Options
    })

    //-------------
    //- BAR CHART3 -
    //-------------
    var barChart3Canvas = $('#barChart3').get(0).getContext('2d')
    var barChart3Data = jQuery.extend(true, {}, areaChartData3)
    var temp03 = areaChartData3.datasets[0]
    var temp13 = areaChartData3.datasets[1]
    barChart3Data.datasets[0] = temp03
    barChart3Data.datasets[1] = temp13

    var barChart3Options = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart3 = new Chart(barChart3Canvas, {
      type: 'bar', 
      data: barChart3Data,
      options: barChart3Options
    })

  
  })
</script>

<?php
footerToHtmlFinish();
}// FIN validacion de acceso a pagina
else{
  header ("Location: ".url_completa());
}
?>
