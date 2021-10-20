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
  
  <?php

  ?>

  <div class="content-wrapper">
    <?php pageHeader("Estadísticas Mensuales"); ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php
        ////////////////////////////////////////////////////////////////////////
        ////// INICIO montamos estadisticas globales, el primer inicio con todos los checks de horarios
        ////////////////////////////////////////////////////////////////////////

        if( isset($_POST['mes']) && !empty($_POST['mes']) && isset($_POST['anyo']) && !empty($_POST['anyo']) ){
          //echo 'if';
          $mes = limpiaTexto($_POST['mes']);
          $anyo = limpiaTexto($_POST['anyo']);
          unset($_SESSION['horarios_mensual']);
          estadisticas_total_mensual($id_empresa,$mes,$anyo);//para cargar todos los meses
        }
        else{
          //carga de datos
          if(!isset($_SESSION['mes_total_mensual'][0])){
            //echo 'if2';
            $mes = date('m');
            $anyo = date('Y');
            estadisticas_total_mensual($id_empresa,$mes,$anyo);//para cargar todos los meses
          }
          else{
            //echo 'else';
            $mes = $_SESSION['mes_total_mensual'][0];
            $anyo = $_SESSION['mes_total_mensual'][1];
          }
        }


        $data_turnos = '';
        $data_ganancias = '';
        $data_asistencias = '';
        //x = semanas 1,2,3,4 y 5 
        //$_SESSION['mes_total_mensual'][0] = //guardamos mes
        //$_SESSION['mes_total_mensual'][1] = //guardamos anyo
        //$_SESSION['mes_total_mensual'][2] = //nombre mes y año para la grafica
        
        //obtenemos las fechas de las semanas
        //$_SESSION['semanax_total_mensual'][0] // guardamos la fecha desde/hasta
        //$_SESSION['semanax_total_mensual'][1] // guardamos los turnos
        //$_SESSION['semanax_total_mensual'][2] // guardamos las ganancias
        //$_SESSION['semanax_total_mensual'][3] // guardamos las asistencias

        $semanas_turnos = array();
        $cont1 = 0;
        $semanas_ganancias = array();
        $cont2 = 0;
        $semanas_asistencias = array();
        $cont3 = 0;
        
        for($i=1; $i <= 5; $i++){
          if($_SESSION['semana'.$i.'_total_mensual'][0] != ''){
            $aux = explode('/',$_SESSION['semana'.$i.'_total_mensual'][0]);
            for($x=0; $x < count($aux); $x++){
              if($x == 0){$fecha_desde = $aux[$x];}
		          else{$fecha_hasta = $aux[$x];}
            }
            $fecha_completa = nombre_dia_semana(date("N",strtotime($fecha_desde))).' '.date("d",strtotime($fecha_desde)).' / '.nombre_dia_semana(date("N",strtotime($fecha_hasta))).' '.date("d",strtotime($fecha_hasta));

            if($_SESSION['semana'.$i.'_total_mensual'][1] > 0){ $data_turnos .= $_SESSION['semana'.$i.'_total_mensual'][1]."-"; $semanas_turnos[$cont1] = $fecha_completa; $cont1++; }
            if($_SESSION['semana'.$i.'_total_mensual'][2] > 0){ $data_ganancias .= $_SESSION['semana'.$i.'_total_mensual'][2]."-"; $semanas_ganancias[$cont2] = $fecha_completa; $cont2++; }
            if($_SESSION['semana'.$i.'_total_mensual'][3] > 0){ $data_asistencias .= $_SESSION['semana'.$i.'_total_mensual'][3]."-"; $semanas_asistencias[$cont3] = $fecha_completa; $cont3++; }
          }
        }//fin for
        
        for($i = 0; $i < 5; $i++){//vaciamos las semanas que no tienen nada
          if(empty($semanas_turnos[$i])){
            $semanas_turnos[$i] = '';
          }
          if(empty($semanas_ganancias[$i])){
            $semanas_ganancias[$i] = '';
          }
          if(empty($semanas_asistencias[$i])){
            $semanas_asistencias[$i] = '';
          }
        }
        $meses = obten_nombreMeses();
        if($semanas_turnos[0] == ''){$label_turnos = 'No hay datos';}
        else{$label_turnos = 'Franjas Horarias Totales';}
        if($semanas_ganancias[0] == ''){$label_ganancias = 'No hay datos';}
        else{$label_ganancias = 'Ingresos (€) Totales';}
        if($semanas_asistencias[0] == ''){$label_asistencias = 'No hay datos';}
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
        if($semanas_turnos[0] != 'No hay datos'){
          $aux = explode('-', $data_turnos);
          for($i=0; $i < count($aux); $i++){
            if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
              $totales_turnos += $aux[$i];
            }
          }
          if($totales_turnos > 0){
            $media_turnos = $totales_turnos/(count($aux)-1);
            $registros_turnos = count($aux)-1;
          }
          unset($aux);
          $aux = explode('-', $data_ganancias);
          for($i=0; $i < count($aux); $i++){
            if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
              $totales_ganancias += $aux[$i];
            }
          }
          if($totales_ganancias > 0){
            $media_ganancias = $totales_ganancias/(count($aux)-1);
            $registros_ganancias = count($aux)-1;
          }
          unset($aux);
          $aux = explode('-', $data_asistencias);
          for($i=0; $i < count($aux); $i++){
            if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
              $totales_asistencias += $aux[$i];
            }
          }
          if($totales_asistencias > 0){
            $media_asistencias = $totales_asistencias/(count($aux)-1);
            $registros_asistencias = count($aux)-1;
          }
        }
        if(!isset($_SESSION['min_mensual'][0])){
          //cargamos los datos para las flechas anterior y siguiente
          $aux = obten_consultaUnCampo($_SESSION['pagina'],'fecha_inicio','turnos','id_empresa',$id_empresa,'','','','','','',' order by fecha_inicio asc limit 1');
          if($aux == ''){$aux = date('Y-m-d');}
          $_SESSION['min_mensual'][0] = date("m",strtotime($aux));//mes minimo
          $_SESSION['min_mensual'][1] = date("Y",strtotime($aux));//anyo minimo

          $aux = obten_consultaUnCampo($_SESSION['pagina'],'fecha_inicio','turnos','id_empresa',$id_empresa,'','','','','','',' order by fecha_inicio desc limit 1');
          if($aux == ''){$aux = date('Y-m-d');}
          $_SESSION['max_mensual'][0] = date("m",strtotime($aux));//mes maximo
          $_SESSION['max_mensual'][1] = date("Y",strtotime($aux));//anyo maximo
        }

        $mes_anterior = date("m",strtotime($anyo."-".$mes."-"."01 - 1 month"));
        $anyo_anterior = date("Y",strtotime($anyo."-".$mes."-"."01 - 1 month"));
        $mes_posterior = date("m",strtotime($anyo."-".$mes."-"."01 + 1 month"));
        $anyo_posterior = date("Y",strtotime($anyo."-".$mes."-"."01 + 1 month"));
        ////////////////////////////////////////////////////////////////////////
        ////// FIN montamos estadisticas globales, el primer inicio con todos los checks de horarios
        ////////////////////////////////////////////////////////////////////////


        ////////////////////////////////////////////////////////////////////////
        ////// INICIO montamos estadisticas parciales, con los checks de horarios habilitados/desahabilitados
        ////////////////////////////////////////////////////////////////////////
        
        if(isset($_POST['horarios'])){
          $_SESSION['horarios_recibidos_mensual'] = $_POST['horarios'];//asignamos los checks recibidos habilitados/deshbilitados
          estadisticas_parcial_mensual($id_empresa);

          $data_turnos_parcial = '';
          $data_ganancias_parcial = '';
          $data_asistencias_parcial = '';
          //x = semanas 1,2,3,4 y 5 
          //$_SESSION['mes_parcial_mensual'][0] = //guardamos mes
          //$_SESSION['mes_parcial_mensual'][1] = //guardamos anyo
          //$_SESSION['mes_parcial_mensual'][2] = //nombre mes y año para la grafica
          
          //obtenemos las fechas de las semanas
          //$_SESSION['semanax_parcial_mensual'][0] // guardamos la fecha desde/hasta
          //$_SESSION['semanax_parcial_mensual'][1] // guardamos los turnos
          //$_SESSION['semanax_parcial_mensual'][2] // guardamos las ganancias
          //$_SESSION['semanax_parcial_mensual'][3] // guardamos las asistencias

          $semanas_turnos_parcial = array();
          $cont1 = 0;
          $semanas_ganancias_parcial = array();
          $cont2 = 0;
          $semanas_asistencias_parcial = array();
          $cont3 = 0;
          
          for($i=1; $i <= 5; $i++){
            if($_SESSION['semana'.$i.'_parcial_mensual'][0] != ''){
              $aux = explode('/',$_SESSION['semana'.$i.'_parcial_mensual'][0]);
              for($x=0; $x < count($aux); $x++){
                if($x == 0){$fecha_desde = $aux[$x];}
                else{$fecha_hasta = $aux[$x];}
              }
              $fecha_completa = nombre_dia_semana(date("N",strtotime($fecha_desde))).' '.date("d",strtotime($fecha_desde)).' / '.nombre_dia_semana(date("N",strtotime($fecha_hasta))).' '.date("d",strtotime($fecha_hasta));

              if($_SESSION['semana'.$i.'_parcial_mensual'][1] > 0){ $data_turnos_parcial .= $_SESSION['semana'.$i.'_parcial_mensual'][1]."-"; $semanas_turnos_parcial[$cont1] = $fecha_completa; $cont1++; }
              if($_SESSION['semana'.$i.'_parcial_mensual'][2] > 0){ $data_ganancias_parcial .= $_SESSION['semana'.$i.'_parcial_mensual'][2]."-"; $semanas_ganancias_parcial[$cont2] = $fecha_completa; $cont2++; }
              if($_SESSION['semana'.$i.'_parcial_mensual'][3] > 0){ $data_asistencias_parcial .= $_SESSION['semana'.$i.'_parcial_mensual'][3]."-"; $semanas_asistencias_parcial[$cont3] = $fecha_completa; $cont3++; }
            }
          }//fin for
          
          for($i = 0; $i < 5; $i++){//vaciamos las semanas que no tienen nada
            if(empty($semanas_turnos_parcial[$i])){
              $semanas_turnos_parcial[$i] = '';
            }
            if(empty($semanas_ganancias_parcial[$i])){
              $semanas_ganancias_parcial[$i] = '';
            }
            if(empty($semanas_asistencias_parcial[$i])){
              $semanas_asistencias_parcial[$i] = '';
            }
          }
          $meses = obten_nombreMeses();
          if($semanas_turnos_parcial[0] == ''){$label_turnos_parcial = 'No hay datos';}
          else{$label_turnos_parcial = 'Franjas Horarias Seleccionadas';}
          if($semanas_ganancias_parcial[0] == ''){$label_ganancias_parcial = 'No hay datos';}
          else{$label_ganancias_parcial = 'Ingresos (€) Seleccionados';}
          if($semanas_asistencias_parcial[0] == ''){$label_asistencias_parcial = 'No hay datos';}
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
          if($semanas_turnos_parcial[0] != 'No hay datos'){
            $aux = explode('-', $data_turnos_parcial);
            for($i=0; $i < count($aux); $i++){
              if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
                $totales_turnos_parcial += $aux[$i];
              }
            }
            if($totales_turnos_parcial > 0){
              $media_turnos_parcial = $totales_turnos_parcial/(count($aux)-1);
              $registros_turnos_parcial = count($aux)-1;
            }
            unset($aux);
            $aux = explode('-', $data_ganancias_parcial);
            for($i=0; $i < count($aux); $i++){
              if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
                $totales_ganancias_parcial += $aux[$i];
              }
            }
            if($totales_ganancias_parcial > 0){
              $media_ganancias_parcial = $totales_ganancias_parcial/(count($aux)-1);
              $registros_ganancias_parcial = count($aux)-1;
            }
            unset($aux);
            $aux = explode('-', $data_asistencias_parcial);
            for($i=0; $i < count($aux); $i++){
              if($aux[$i] != ''){//para evitar problemas con el ultimo digito que será un -
                $totales_asistencias_parcial += $aux[$i];
              }
            }
            if($totales_asistencias_parcial > 0){
              $media_asistencias_parcial = $totales_asistencias_parcial/(count($aux)-1);
              $registros_asistencias_parcial = count($aux)-1;
            }
          }
          if(!isset($_SESSION['min_mensual'][0])){
            //cargamos los datos para las flechas anterior y siguiente
            $aux = obten_consultaUnCampo($_SESSION['pagina'],'fecha_inicio','turnos','id_empresa',$id_empresa,'','','','','','',' order by fecha_inicio asc limit 1');
            $_SESSION['min_mensual'][0] = date("m",strtotime($aux));//mes minimo
            $_SESSION['min_mensual'][1] = date("Y",strtotime($aux));//anyo minimo

            $aux = obten_consultaUnCampo($_SESSION['pagina'],'fecha_inicio','turnos','id_empresa',$id_empresa,'','','','','','',' order by fecha_inicio desc limit 1');
            $_SESSION['max_mensual'][0] = date("m",strtotime($aux));//mes maximo
            $_SESSION['max_mensual'][1] = date("Y",strtotime($aux));//anyo maximo
          }
          
          $mes_anterior = date("m",strtotime($anyo."-".$mes."-"."01 - 1 month"));
          $anyo_anterior = date("Y",strtotime($anyo."-".$mes."-"."01 - 1 month"));
          $mes_posterior = date("m",strtotime($anyo."-".$mes."-"."01 + 1 month"));
          $anyo_posterior = date("Y",strtotime($anyo."-".$mes."-"."01 + 1 month"));

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

        <div class="row">
          <div class="col-3 col-sm-4">
            <?php
            $fecha_minima = date('Y-m-d',strtotime($_SESSION['min_mensual'][1].'-'.$_SESSION['min_mensual'][0].'-01'));
            $fecha_anterior = date('Y-m-d',strtotime($anyo_anterior.'-'.$mes_anterior.'-01'));
            //echo $fecha2.'/'.$fecha1;
            if($fecha_anterior >= $fecha_minima){
            ?>
            <form role="form" id="anterior" method="POST">
              <input type="hidden" name="mes" value="<?= $mes_anterior ?>">
              <input type="hidden" name="anyo" value="<?= $anyo_anterior ?>">
              <button type="sumbit" class="btn btn-primary float-left float-md-left"><i class="fas fa-chevron-left"></i></button>
            </form>
            <?php
            }//fin if mes
            ?>
          </div>
          <div class="col-6 col-sm-4">
            <h4 class="text-center"><?= ' '.$_SESSION['mes_total_mensual'][2].' ' ?></h4>
          </div>
          <div class="col-3 col-sm-4">
            <?php
            if($mes_posterior <= $_SESSION['max_mensual'][0] || $anyo_posterior < $_SESSION['max_mensual'][1]){
            ?>
            <form role="form" id="anterior" method="POST">
              <input type="hidden" name="mes" value="<?= $mes_posterior ?>">
              <input type="hidden" name="anyo" value="<?= $anyo_posterior ?>">
              <button type="sumbit" class="btn btn-primary float-right float-md-right"><i class="fas fa-chevron-right"></i></button>
            </form>
            <?php
            }//fin mes
            ?>
          </div>
        </div>
        <div class="row justify-content-center">
          <form role="form" id="formHorarios" method="POST" action="estadisticas_mensual.php">
            <div class="form-group">
            <?php
              if(isset($_SESSION['horarios_mensual'][0])){
                for($i=0; $i < count($_SESSION['horarios_mensual']); $i++){
                  if(isset($_POST['horarios'])){
                    $encontrado = false;
                    for($x=0; $x < count($_POST['horarios']); $x++){
                      if($_SESSION['horarios_mensual'][$i] == $_POST['horarios'][$x]){
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
                  <input name="horarios[]" class="custom-control-input" type="checkbox" id="horarios<?= $i ?>" value="<?= $_SESSION['horarios_mensual'][$i]; ?>" <?= $checked ?> onclick="enviar_horarios()">
                  <label for="horarios<?= $i ?>" class="custom-control-label"><?= substr($_SESSION['horarios_mensual'][$i],0,5).'-'.substr($_SESSION['horarios_mensual'][$i],9,5) ?> h &nbsp;&nbsp;</label>
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
                <h3 class="card-title">Ingresos Totales</h3>

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
                    <label class="row" for="exampleInputPassword1"><?= number_format ($media_ganancias,1,",",".") ?> €/semana</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Semanas:</label>
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
                      <?= number_format ($media_ganancias_parcial,1,",",".") ?> €/semana 
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
                    <label class="row text-secondary" for="exampleInputPassword1">Semanas:</label>
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
                    <label class="row" for="exampleInputPassword1"><?= number_format ($media_asistencias,1,",",".") ?> /semana</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Semanas:</label>
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
                    <?= number_format ($media_asistencias_parcial,1,",",".") ?> /semana 
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
                    <label class="row text-secondary" for="exampleInputPassword1">Semanas:</label>
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
                    <label class="row" for="exampleInputPassword1"><?= number_format ($media_turnos,1,",",".") ?> /semana</label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row" for="exampleInputPassword1">Semanas:</label>
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
                      <?= number_format ($media_turnos_parcial,1,",",".") ?> /semana 
                      (<?= ($media_turnos_parcial != 0) ? round(($media_turnos_parcial*100)/$media_turnos,1):0 ?> %)
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-5">
                    <label class="row text-secondary" for="exampleInputPassword1">Semanas:</label>
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
      <?php labels($semanas_ganancias[0], $semanas_ganancias[1], $semanas_ganancias[2], $semanas_ganancias[3], $semanas_ganancias[4], '', '', '', '', '', '', ''); ?>
      datasets: [
        <?php datasets($label_ganancias,'rgba(60,188,141,0.9)','rgba(60,188,141,0.8)',false,'#3BBA90','rgba(60,188,141,1)','#fff','rgba(60,188,141,1)',$data_ganancias); ?>
        <?php datasets($label_ganancias_parcial,'rgba(210, 214, 222, 1)','rgba(210, 214, 222, 1)',false,'rgba(210, 214, 222, 1)','#c1c7d1','#fff','rgba(220,220,220,1)',$data_ganancias_parcial); ?>
      ]
    }

    //--------------
    //- AREA CHART2 -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas2 = $('#areaChart').get(0).getContext('2d')

    var areaChartData2 = {
      <?php labels($semanas_asistencias[0], $semanas_asistencias[1], $semanas_asistencias[2], $semanas_asistencias[3], $semanas_asistencias[4],  '', '', '', '', '', '', ''); ?>
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
      <?php labels($semanas_turnos[0], $semanas_turnos[1], $semanas_turnos[2], $semanas_turnos[3], $semanas_turnos[4], '', '', '', '', '', '', ''); ?>
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
