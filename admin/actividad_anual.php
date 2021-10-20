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
    <?php pageHeader("Actividad Anual"); ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php
        ////////////////////////////////////////////////////////////////////////
        ////// INICIO montamos estadisticas globales, el primer inicio con todos los checks de horarios
        ////////////////////////////////////////////////////////////////////////
        //revisamos si hay carga de datos
        /*
        if(  ) ){
          estadisticas_total_anual($id_empresa,0);//para cargar todos los meses
        }
        else{
          estadisticas_total_anual($id_empresa,date('n'));//para cargar solo mes actual
        }
        */

        $fecha_min_actividad = obten_consultaUnCampo($_SESSION['pagina'],'fechahora','actividades','id_empresa',$id_empresa,'','','','','','',' order by fechahora asc limit 1');
        $anyo_menos_hoy = date("Y-m-d",strtotime(date('Y-m-d')."- 1 year"));

        if(date("Y-m-d",strtotime($fecha_min_actividad)) > $anyo_menos_hoy){//si la de BD es mas proxima
          $_SESSION['fecha_min_busqueda'] = date("Y-m-d",strtotime($fecha_min_actividad));
        }//si la de hoy menos un año es mas proxima
        else{
          $_SESSION['fecha_min_busqueda'] = $anyo_menos_hoy;
        }
  
        actividades_anual($id_empresa);

        $meses = obten_nombreMeses();
        $tit_desde = date("d",strtotime($_SESSION['fecha_min_busqueda'])).' '.$meses[date("n",strtotime($_SESSION['fecha_min_busqueda']))-1].' '.date("Y",strtotime($_SESSION['fecha_min_busqueda']));
        $tit_hasta = date("d").' '.$meses[date("n")-1].' '.date("Y");
         
        ?>
        <div class="row">
          <div class="col-12"
            <!-- DONUT CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Actividad <?= $_SESSION['actividades_total_anual'].' registros en total, desde '.ucwords($tit_desde).' a '.ucwords($tit_hasta) ?></h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
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

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
        <?= $_SESSION['noms_usuarios_anual']; ?>
        /*
          'Chrome', 
          'IE',
          'FireFox', 
          'Safari', 
          'Opera', 
          'Navigator'
       */ 
      ],
      
      datasets: [
        {
          
          data: [<?= $_SESSION['datos_usuarios_anual'] ?>],
          //data: [700,500,400,600,300,100],
          
          backgroundColor : [<?= $_SESSION['colores_anual'] ?>],
          //backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
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
