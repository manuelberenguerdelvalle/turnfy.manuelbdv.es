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
    function eliminar_reserva(id_reserva){
        var datos = 'operacion=D&id_reserva='+id_reserva;
        var url = "../funciones/procesar_reserva.php"; // El script a dónde se realizará la petición.
        $.ajax({
            type: "POST",
            url: url,
            data: datos, // Adjuntar los campos del formulario enviado.
            success: function()
            {
            //alert(data);
            cargar('#cabecera_datos','cabecera_reserva.php');
            cargar('#contenido_datos','contenido_reserva.php');
            }
        });
    }

    function cambio_estado_reserva(id_reserva,estado){
        //alert(id_reserva+'- estado '+estado);
        var datos = 'operacion=CE&id_reserva='+id_reserva+'&estado='+estado;
        var url = "../funciones/procesar_reserva.php"; // El script a dónde se realizará la petición.
        $.ajax({
            type: "POST",
            url: url,
            data: datos, // Adjuntar los campos del formulario enviado.
            success: function()
            {
            //alert(data);
            cargar('#cabecera_datos','cabecera_reserva.php');
            cargar('#contenido_datos','contenido_reserva.php');
            }
        });
        
    }

    function enviar_reserva(id_reserva){

        var url = "../funciones/procesar_reserva.php"; // El script a dónde se realizará la petición.
        $.ajax({
            type: "POST",
            url: url,
            data: $("#formReserva"+id_reserva).serialize(), // Adjuntar los campos del formulario enviado.
            success: function()
            {
            //alert(data);
            cargar('#cabecera_datos','cabecera_reserva.php');
            cargar('#contenido_datos','contenido_reserva.php');
            }
        });
        
    }

</script>

<div class="card-body col-12">
    <?php
        $db = new MySQL($_SESSION['pagina']);
        if($modo == 0){//todos los activos 0 y 2
            $c = $db->consulta("SELECT * FROM reservas WHERE id_turno = '$id_turno' AND estado in ('0', '2') order by estado desc, posicion asc; ");
        }
        elseif($modo == 1){//borrados
            $c = $db->consulta("SELECT * FROM reservas WHERE id_turno = '$id_turno' AND estado = '1' order by posicion desc; ");
        }
        elseif($modo == 2){//servicio
            $c = $db->consulta("SELECT * FROM reservas WHERE id_turno = '$id_turno' AND estado = '2' order by posicion asc; ");
        }
        else{//usuarioç
            if($_SESSION['login'] == 'id_usuario' && $_SESSION['id_usuario'] > 0){
                $c = $db->consulta("SELECT * FROM reservas WHERE id_turno = '$id_turno' AND estado in ('0', '2') AND id_usuario = '".$_SESSION['id_usuario']."' order by estado desc, posicion asc; ");
            }
            else{
                $c = $db->consulta("SELECT * FROM reservas WHERE id_turno = '$id_turno' AND estado in ('0', '2') AND id_empresa = '".$id_empresa."' AND id_usuario = '0' order by estado desc, posicion asc; ");
            }
        }
        while($r = $c->fetch_array(MYSQLI_ASSOC)){
            $id_reserva = $r['id_reserva'];
            $mesa = $r['mesa'];
            $num_personas = $r['num_personas'];
            $cuenta = $r['cuenta'];
            $descripcion_larga = $r['descripcion_larga'];
            $fec_creacion = $r['fec_creacion'];
            $estado = $r['estado'];
            $posicion = $r['posicion'];
            $descripcion_corta = $r['descripcion_corta'];


            $card = ($estado == 2) ? 'olive' : 'light';
            $resumen = "Turno ".$posicion;
            if(empty($mesa)){
               $mesa = 0; 
            }
            $resumen .= " | ".substr($textos[5],0,4).' '.$mesa;
            if($num_personas == 0){
                $num_personas = 1;
            }
            $resumen .= " | ".$num_personas.' pers';
            if(!empty($descripcion_corta)){$resumen .= " | ".$descripcion_corta;}
            if($estado == 2){
                $dateStart = new DateTime($fec_creacion);
                $dateEnd   = new DateTime(obten_fechahora());
                $dateDiff  = $dateStart->diff($dateEnd);
                $resumen .= " | ".$dateDiff->format("%Hh:%Im");
            }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-<?= $card ?> collapsed-card">
                <div class="card-header">
                    <div class="card-tools float-left col-2">
                        <?php 
                        if($modo  == 0 || $modo == 2 || $modo == 3){
                            if($tipo_evento == 1){//mostramos icono hosteleria
                        ?>
                        <button type="button" class="btn btn-tool" onclick="cambio_estado_reserva(<?= $id_reserva ?>,<?= $estado ?>)"><i class="fas fa-utensils"></i></button>
                        <!--<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-edit"></i></button>-->
                        <?php
                            }
                            else{//icono generico
                        ?>
                        <button type="button" class="btn btn-tool" onclick="cambio_estado_reserva(<?= $id_reserva ?>,<?= $estado ?>)"><i class="fas fa-check"></i></button>
                        <?php        
                            }
                        }
                        ?>
                    </div>
                    <!-- /.card-tools -->
                    <div class="card-title col-9" data-card-widget="collapse"><?= $resumen ?></div>
                    <div class="card-tools">
                        <?php 
                        if($modo  == 1){
                        ?>
                        <button type="button" class="btn btn-tool" onclick="cambio_estado_reserva(<?= $id_reserva ?>,'1')"><i class="fas fa-undo"></i></button>
                        <?php
                        }
                        else{
                        ?>
                        <button type="button" class="btn btn-tool" data-card-widget="remove" onclick="eliminar_reserva(<?= $id_reserva ?>)"><i class="fas fa-trash"></i></button>
                        <?php    
                        }
                        ?>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- form start -->
                    <form role="form" id="formReserva<?= $id_reserva ?>">
            
                        <div class="card-body">
                            <div class="form-group">
                                <label for="mesa"><?= $textos[5] ?></label>
                                <input name="mesa" type="text" class="form-control" id="mesa<?= $id_reserva ?>" value="<?= $mesa?>" placeholder="<?= $textos[6] ?>"  maxlength="5">
                            </div>
                            <div class="form-group">
                                <label for="descripcion_corta">Nombre reserva</label>
                                <input name="descripcion_corta" type="text" class="form-control" id="descripcion_corta<?= $id_reserva ?>" value="<?= $descripcion_corta ?>"  placeholder="Nombre" maxlength="50">
                            </div>
                            <div class="form-group">
                                <label for="num_personas">Número de personas</label>
                                <input name="num_personas" type="number" class="form-control" id="num_personas<?= $id_reserva ?>" value="<?= $num_personas?>" placeholder="Numero de"  maxlength="14">
                            </div>
                            <div class="form-group">
                                <label for="descripcion_larga"><?= $textos[7] ?></label>
                                <textarea name="descripcion_larga" class="form-control" rows="5" id="descripcion_larga<?= $id_reserva ?>" maxlength="50" placeholder="<?= $textos[7] ?>"><?= $descripcion_larga ?></textarea>
                            </div> 
                            <div class="form-group">
                                <label for="cuenta">Cuenta</label>
                                <input name="cuenta" type="number" class="form-control" id="cuenta<?= $id_reserva ?>" value="<?= $cuenta?>" placeholder="Cuenta"  maxlength="14">
                            </div>
                            <div class="form-group">
                                <input name="id_reserva" type="hidden" value="<?= $id_reserva ?>">
                            </div>
                            <div class="form-group">
                                <input name="operacion" type="hidden" value="U">
                            </div>
                            <div class="form-group">
                                <button id="botonReserva<?= $id_reserva ?>" type="button" class="btn bg-gradient-<?= $card ?>" onclick="enviar_reserva(<?= $id_reserva ?>)">Modificar</button>
                            </div>
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
<!-- /.card-body -->