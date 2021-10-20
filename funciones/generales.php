<?php
function url_completa(){
	return "https://turnfy.manuelbdv.es/";
	//return "http://www.novedadesreggaeton.com";
	//return "http://localhost/turnfy/index.php";
	
}

function comprobar_pagina($pagina){
	if($pagina == 'index' || $pagina == 'usuarios' || $pagina == 'turnos' || $pagina == 'estadisticas_anual' || $pagina == 'estadisticas_mensual'){
		$r = false;//retornamos false para que no entre
	}
	else{
		$r = true;//si no existe retornamos true para salir
	}
}

function obtener_textos_reserva($tipo_evento){

	if($tipo_evento == 1){//hostelería
		$textos = array('Último Turno','Comensales activos','Turnos pendientes','Comensales espera','Mesas ocupadas','Mesa','Número de mesa','Comanda');
	}
	elseif($tipo_evento == 2){//Otros
		$textos = array('Último Turno','Personas en servicio','Turnos pendientes','Personas en espera','Turnos en progreso','Servicio','Descripción','Descripción larga');
	}
	elseif($tipo_evento == 3){//gimnasio
		$textos = array('Último Turno','Personas en sala','Turnos pendientes','Personas en espera','Turnos en progreso','Servicio','Descripción','Descripción larga');
	}
	elseif($tipo_evento == 4){//piscina
		$textos = array('Último Turno','Personas en piscina','Turnos pendientes','Personas en espera','Turnos en progreso','Servicio','Descripción','Descripción larga');
	}
	elseif($tipo_evento == 5){//comercio
		$textos = array('Último Turno','Personas comercio','Turnos pendientes','Personas en espera','Turnos en progreso','Servicio','Descripción','Descripción larga');
	}
	elseif($tipo_evento == 6){//Sala
		$textos = array('Último Turno','Personas en sala','Turnos pendientes','Personas en espera','Turnos en progreso','Servicio','Descripción','Descripción larga');
	}
	elseif($tipo_evento == 7){//playa
		$textos = array('Último Turno','Personas en playa','Turnos pendientes','Personas en espera','Turnos en progreso','Servicio','Descripción','Descripción larga');
	}
	return $textos;
}

function obten_consultaUnCampo($pagina,$select,$tabla,$where1,$buscar1,$where2,$buscar2,$where3,$buscar3,$where4,$buscar4,$order){
	$db = new MySQL($pagina);
	if($where2 == '' && $buscar2 == ''){//1
		$c = $db->consulta("SELECT ".$select." as r FROM ".$tabla." WHERE ".$where1." = '".$buscar1."' ".$order." ; ");
	}
	else if($where3 == '' && $buscar3 == ''){//2
		$c = $db->consulta("SELECT ".$select." as r FROM ".$tabla." WHERE ".$where1." = '".$buscar1."' AND ".$where2." = '".$buscar2."' ".$order." ; ");
	}
	else if($where4 == '' && $buscar4 == ''){//3
		$c = $db->consulta("SELECT ".$select." as r FROM ".$tabla." WHERE ".$where1." = '".$buscar1."' AND ".$where2." = '".$buscar2."' AND ".$where3." = '".$buscar3."' ".$order." ; ");
	}
	else{//4
		$c = $db->consulta("SELECT ".$select." as r FROM ".$tabla." WHERE ".$where1." = '".$buscar1."' AND ".$where2." = '".$buscar2."' AND ".$where3." = '".$buscar3."' AND ".$where4." = '".$buscar4."' ".$order." ; ");
	}
	$r = $c->fetch_array(MYSQLI_ASSOC);
	return $r['r'];
}

function titulo(){
	return 'Turnfy - Rentabilidad, reservas y turnos';
}

function actualiza_turnos($id_empresa){//funcion que archiva los turnos de dos semanas 
	$quincedias_menos = date("Y-m-d",strtotime(date('Y-m-d')." - 2 week"));
	$r = obten_consultaUnCampo('index','count(id_turno)','turnos','id_empresa',$id_empresa,'estado','0','','','','','and fecha_inicio <= "'.$quincedias_menos.'"');
	if($r > 0){
	  $db = new MySQL('index');
	  $c = $db->consulta("UPDATE turnos SET estado=1 WHERE id_empresa = ".$id_empresa." AND estado = 0 AND fecha_inicio <= '".$quincedias_menos."' ; ");
	  //$r = $c->fetch_array(MYSQLI_ASSOC);
	}
	return $r;
  }

function calcular_ganancias_asistencias($id_turno){//funcion que actualiza en cada acción las ganancias y asistencias del turno
	$suma_ganancias = obten_consultaUnCampo($_SESSION['pagina'],'sum(cuenta)','reservas','id_turno',$_SESSION['id_turno'],'','','','','','','');
	$asistentes = obten_consultaUnCampo($_SESSION['pagina'],'sum(num_personas)','reservas','id_turno',$_SESSION['id_turno'],'','','','','','','');
	$db = new MySQL($pagina);
	$c = $db->consulta("update turnos set suma_ganancias = ".$suma_ganancias.", asistentes = ".$asistentes." where id_turno = ".$id_turno."; ");
	//$r = $c->fetch_array(MYSQLI_ASSOC);
}

function generar_color(){
	$paleta = ['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f'];
	$color = '#';
	for($i=0; $i < 6; $i++){
	  $color .= $paleta[rand(0,15)];
	}
	return $color;
  }

////////////////////////////////////
/////////  FECHAS Y HORAS /////////
///////////////////////////////////
function obten_fechahora() {//Función que devuelve la fecha y hora
	return date('Y-m-d H:i:s');
}

function obten_fecha() {//Función que devuelve la hora
	return date('Y-m-d');
}

function obten_hora() {//Función que devuelve la hora
	return date('H:i:s');
}

function codificar($hora){
	$newHora = '';
	if(strpos($hora, '.5') == false){// no tiene medias
		if(strlen($hora) == 1){
			$newHora = '0';
		}
		$newHora .= $hora.':00:00';
	}
	else{//si tiene media hora
		$dividir = explode(".5",$hora);
		if(strlen($dividir[0]) == 1){
			$newHora = '0';
		}
		$newHora .= $dividir[0].':30:00';
	}
	return $newHora;
}

function decodificar($hora){
	$newHora = '';
	$newHora = substr($hora,0,2);
	if(strpos($hora, ':30') != false){//si tiene media hora
		$newHora .= '.5';
	}
	return number_format($newHora,1);
}

function obtener_horas($horario){
	$horas = explode(" ",$horario);
	for($i=0; $i<count($horas); $i++){
		$horas[$i] = codificar($horas[$i]);
	}
	return $horas;
}

function nombre_dia_semana($num){
	if($num == 1){$r = 'Lunes';}
	elseif($num == 2){$r = 'Martes';}
	elseif($num == 3){$r = 'Miercoles';}
	elseif($num == 4){$r = 'Jueves';}
	elseif($num == 5){$r = 'Viernes';}
	elseif($num == 6){$r = 'Sabado';}
	else{$r = 'Domingo';}
	return $r;
}

////////////////////////////////////
////////////LIMPIAR TEXTO///////////
///////////////////////////////////
function limpiaTexto($valor){//Funcion que sirve para limpiar contenido peligroso para inyección sql
	$caracteres = array('=""','= ""','"', "'", "=''", "= ''", "%", " OR ", " or ", " AND ", " and ", "=", "<", ">", "`", "+", ",", ";", ":", "*", " FROM ", " from ", " WHERE ", " where ", " UNION SELECT ", " union select ", "&", " LIKE ", " like ");
	$texto = trim($valor);
	$num = count($caracteres);
	for($i=0; $i<$num; $i++){
		$texto = str_replace($caracteres[$i], " ", $texto);
	}
	return $texto;
}

function limpiaTexto2($valor){//Funcion que sirve para limpiar contenido peligroso para inyección sql REDUCIDO dejando más caracteres
	$caracteres = array("'.'",'"."','=""','= ""', "=''", "= ''", "%", " OR ", " or ", " AND ", " and ", "`", ";", "*", " FROM ", " from ", " WHERE ", " where ", " UNION SELECT ", " union select ", "&", " LIKE ", " like ");
	$texto = trim($valor);
	$num = count($caracteres);
	for($i=0; $i<$num; $i++){
		$texto = str_replace($caracteres[$i], " ", $texto);
	}
	return $texto;
}

function limpiaTexto3($valor){//Funcion que sirve para limpiar contenido peligroso para inyección sql REDUCIDO dejando más caracteres
	$caracteres = array(" OR ", " or ", " AND ", " and ", "`", ";", "*", "FROM", "from", "WHERE", "where", "UNION SELECT", "union select", "LIKE", "like","&nbsp;","select","SELECT");
	$texto = trim($valor);
	$num = count($caracteres);
	for($i=0; $i<$num; $i++){
		$texto = str_replace($caracteres[$i], " ", $texto);
	}
	return $texto;
}
////////////////////////////////////
//////////// ESTADISTICAS //////////
///////////////////////////////////
function organizar_meses($mes_actual){
	$meses = array();
	$orden = 0;
	for($i=$mes_actual+1; $i <= 12; $i++){
		$meses[$orden] = $i;
		$orden++;
	}
	for($i=1; $i <= $mes_actual; $i++){
		$meses[$orden] = $i;
		$orden++;
	}
	return $meses;
}

function obten_nombreMeses(){
	$r = array('enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
	return $r;
}



////////////////////////////////////
//////////// GENERAR DATOS //////////
///////////////////////////////////
function generar_datos_turnos($fecha_inicial){
	$fecha1 = new DateTime($fecha_inicial);
	$fecha2 = new DateTime(date("Y-m-d"));
	$diff = $fecha1->diff($fecha2);
	for($i=0; $i <= $diff->days; $i++){
		$fecha_nueva = date("Y-m-d",strtotime($fecha_inicial." + ".$i." days"));
        //echo $fecha_nueva.'   '."<br>";
		if($fecha_nueva <= date("Y-m-d")){
 			$dia_semana = date("N",strtotime($fecha_nueva));
            if($dia_semana > 5){//fin de semana
                $asistencias = rand ( 20 , 30 );
                $ganancias = $asistencias*4;                
                $turno1 = new Turno('',0,1,$fecha_nueva,'07:00:00',$fecha_nueva,'09:30:00',0,$ganancias,4,0,'desayunos',date('Y-m-d H:i:s'),$asistencias); 
                $turno1 -> insertar('index');
                //echo "Turno insertado (desayunos) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 100 , 300 );
                $ganancias = $asistencias*6; 
                $turno2 = new Turno('',0,1,$fecha_nueva,'09:30:00',$fecha_nueva,'12:00:00',0,$ganancias,4,0,'almuerzos',date('Y-m-d H:i:s'),$asistencias);
                $turno2 -> insertar('index');
                //echo "Turno insertado (almuerzos) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 15 , 30 );
                $ganancias = $asistencias*4;
                $turno3 = new Turno('',0,1,$fecha_nueva,'12:00:00',$fecha_nueva,'13:00:00',0,$ganancias,4,0,'pre-comida',date('Y-m-d H:i:s'),$asistencias);
                $turno3 -> insertar('index');
                //echo "Turno insertado (pre-comida) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 40 , 70 );
                $ganancias = $asistencias*12;
                $turno4 = new Turno('',0,1,$fecha_nueva,'13:00:00',$fecha_nueva,'16:00:00',0,$ganancias,4,0,'comida',date('Y-m-d H:i:s'),$asistencias);
                $turno4 -> insertar('index');
                //echo "Turno insertado (comida) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 20 , 30 );
                $ganancias = $asistencias*3;
                $turno5 = new Turno('',0,1,$fecha_nueva,'16:00:00',$fecha_nueva,'18:00:00',0,$ganancias,4,0,'cafe',date('Y-m-d H:i:s'),$asistencias);
                $turno5 -> insertar('index');
                //echo "Turno insertado (cafe) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 25 , 40 );
                $ganancias = $asistencias*5;
                $turno5 = new Turno('',0,1,$fecha_nueva,'18:00:00',$fecha_nueva,'21:00:00',0,$ganancias,4,0,'tarde',date('Y-m-d H:i:s'),$asistencias);
                $turno5 -> insertar('index');
                //echo "Turno insertado (tarde) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 20 , 40 );
                $ganancias = $asistencias*10;
                $turno5 = new Turno('',0,1,$fecha_nueva,'21:00:00',$fecha_nueva,'23:00:00',0,$ganancias,4,0,'cena',date('Y-m-d H:i:s'),$asistencias);
                $turno5 -> insertar('index');
                //echo "Turno insertado (cena) <br>";

            }
            else{//entre 
                
                $asistencias = rand ( 20 , 30 );
                $ganancias = $asistencias*3;                
                $turno1 = new Turno('',0,1,$fecha_nueva,'07:00:00',$fecha_nueva,'09:30:00',0,$ganancias,4,0,'desayunos',date('Y-m-d H:i:s'),$asistencias); 
                $turno1 -> insertar('index');
                //echo "Turno insertado (desayunos) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 100 , 300 );
                $ganancias = $asistencias*5; 
                $turno2 = new Turno('',0,1,$fecha_nueva,'09:30:00',$fecha_nueva,'12:00:00',0,$ganancias,4,0,'almuerzos',date('Y-m-d H:i:s'),$asistencias);
                $turno2 -> insertar('index');
                //echo "Turno insertado (almuerzos) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 15 , 30 );
                $ganancias = $asistencias*3;
                $turno3 = new Turno('',0,1,$fecha_nueva,'12:00:00',$fecha_nueva,'13:00:00',0,$ganancias,4,0,'pre-comida',date('Y-m-d H:i:s'),$asistencias);
                $turno3 -> insertar('index');
                //echo "Turno insertado (pre-comida) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 40 , 70 );
                $ganancias = $asistencias*10;
                $turno4 = new Turno('',0,1,$fecha_nueva,'13:00:00',$fecha_nueva,'16:00:00',0,$ganancias,4,0,'comida',date('Y-m-d H:i:s'),$asistencias);
                $turno4 -> insertar('index');
                //echo "Turno insertado (comida) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 20 , 30 );
                $ganancias = $asistencias*2;
                $turno5 = new Turno('',0,1,$fecha_nueva,'16:00:00',$fecha_nueva,'18:00:00',0,$ganancias,4,0,'cafe',date('Y-m-d H:i:s'),$asistencias);
                $turno5 -> insertar('index');
                //echo "Turno insertado (cafe) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 25 , 40 );
                $ganancias = $asistencias*3;
                $turno5 = new Turno('',0,1,$fecha_nueva,'18:00:00',$fecha_nueva,'21:00:00',0,$ganancias,4,0,'tarde',date('Y-m-d H:i:s'),$asistencias);
                $turno5 -> insertar('index');
                //echo "Turno insertado (tarde) <br>";
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                $asistencias = rand ( 20 , 40 );
                $ganancias = $asistencias*7;
                $turno5 = new Turno('',0,1,$fecha_nueva,'21:00:00',$fecha_nueva,'23:00:00',0,$ganancias,4,0,'cena',date('Y-m-d H:i:s'),$asistencias);
                $turno5 -> insertar('index');
                //echo "Turno insertado (cena) <br>";
            }
            
		}
    }
}

function generar_datos_actividades($fecha_inicial){
	$fecha1 = new DateTime($fecha_inicial);
	$fecha2 = new DateTime(date("Y-m-d"));
	$diff = $fecha1->diff($fecha2);
	for($i=0; $i <= $diff->days; $i++){
		$fecha_nueva = date("Y-m-d",strtotime($fecha_inicial." + ".$i." days"));
        //echo $fecha_nueva.'   '."<br>";
		if($fecha_nueva <= date("Y-m-d")){
 			$dia_semana = date("N",strtotime($fecha_nueva));
            if($dia_semana > 5){//fin de semana
                for ($j=1; $j <= 15; $j++) { 
                    $num_actividades=rand(10,15);
                    for ($k=0; $k < $num_actividades ; $k++) { 
                        $actividad=new Actividad('', $fecha_nueva,$j, 1, '');
                        $actividad->insertar('index');
                        unset($actividad);
                    }
                }
            }
            else{//entre 
                for ($j=1; $j <= 15; $j++) { 
                    $num_actividades=rand(5,10);
                    for ($k=0; $k < $num_actividades ; $k++) { 
                        $actividad=new Actividad('', $fecha_nueva,$j, 1, '');
                        $actividad->insertar('index');
                        unset($actividad);
                    }
                }
            }
            
		}
    }
}
?>