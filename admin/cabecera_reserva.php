<?php
include_once ("../class/mysql.php");
include_once ("../class/turnos.php");
include_once ("../funciones/generales.php");
session_start();
$id_empresa = $_SESSION['id_empresa'];
if(isset($_GET['id_turno'])){
    $id_turno = limpiaTexto(htmlspecialchars($_GET['id_turno']));
    $_SESSION['id_turno'] = $id_turno;
}
else{
    $id_turno = $_SESSION['id_turno'];
}
//0=reservas en estado 0 y 2
//1=reservas en estado 1 borradas
//2=reservas en estado 2 en mesa
//3=reservas modificadas por el usuario
if(isset($_GET['modo'])){
    $modo = limpiaTexto(htmlspecialchars($_GET['modo']));
    $_SESSION['modo_reserva'] = $modo;
}
else{
    if(!isset($_SESSION['modo_reserva'])){
        $modo = 0;
        $_SESSION['modo_reserva'] = 0;
    }
    else{
        $modo = $_SESSION['modo_reserva'];
    }

    $id_turno = $_SESSION['id_turno'];
}
$turno = new Turno($id_turno,'','','','','','','','','','','','','');

if($turno -> getValor('personas_max') > 0){
    $_SESSION['personas_max_turno'] = $turno -> getValor('personas_max');
}
else{
    $_SESSION['personas_max_turno'] = 0;
}

$tipo_evento = obten_consultaUnCampo($_SESSION['pagina'],'tipo_evento','empresas','id_empresa',$id_empresa,'','','','','','','');
$textos = obtener_textos_reserva($tipo_evento);
?>
<script type="text/javascript">

    var inactivityTime = function () {
        var time;
        window.onload = resetTimer;
        // DOM Events
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
        document.onmousedown = resetTimer; // touchscreen presses
        document.ontouchstart = resetTimer;
        document.onclick = resetTimer;     // touchpad clicks
        document.onscroll = resetTimer;    // scrolling with arrow keys

        function logout() {
            //alert('caca');
            cargar('#cabecera_datos','cabecera_reserva.php');
        }

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(logout, 1)
            // 1000 milliseconds = 1 second
        }
    };

    $(document).ready(function(){
        inactivityTime();
    });
</script>
<div class="card-body col-12">
    <div class="row">
        <div class="col-6 col-sm-3 text-center">
            <h5><?= $textos[0] ?><br></h5>
            <h1>
            <?= obten_consultaUnCampo($_SESSION['pagina'],'count(id_reserva)','reservas','id_turno',$turno -> getValor('id_turno'),'','','','','','','') ?>
            </h1>
        </div>
        <div class="col-6 col-sm-3 text-center">
        <?= $textos[1] ?><br>    
            <h3>
                <?php
                $en_mesa = obten_consultaUnCampo($_SESSION['pagina'],'sum(num_personas)','reservas','id_turno',$turno -> getValor('id_turno'),'estado','2','','','','',''); 
                echo ($en_mesa > 0) ? $en_mesa : 0;
                ?>
            </h3>
        </div>
        <div class="col-6 col-sm-3 text-center">
        <?= $textos[2] ?><br>    
            <h3>
                <?= obten_consultaUnCampo($_SESSION['pagina'],'count(id_reserva)','reservas','id_turno',$turno -> getValor('id_turno'),'estado','0','','','','','') ?>
            </h3>
        </div>
        <div class="col-6 col-sm-3 text-center">
        <?= $textos[3] ?><br>    
            <h3>
                <?php
                $en_espera = obten_consultaUnCampo($_SESSION['pagina'],'sum(num_personas)','reservas','id_turno',$turno -> getValor('id_turno'),'estado','0','','','','','');
                echo ($en_espera > 0) ? $en_espera : 0;
                ?>
            </h3>
        </div>
        <div class="col-6 col-sm-3 text-center">
        <?= $textos[4] ?><br>    
            <h3>
                <?= obten_consultaUnCampo($_SESSION['pagina'],'count(id_reserva)','reservas','id_turno',$turno -> getValor('id_turno'),'estado','2','','','','','') ?>
            </h3>
        </div>
        <?php
        //if(isset($_SESSION['alerta_usuario']) && $_SESSION['alerta_usuario'] == "success"){
        //HABRIA QUE HACERLO POR BD PARA QUE LE APAREZCA A TODOS LOS USUARIOS
        //}//fin if
        //unset($_SESSION['alerta_usuario']);
        ?>
    </div>
</div>
<!-- /.card-body -->