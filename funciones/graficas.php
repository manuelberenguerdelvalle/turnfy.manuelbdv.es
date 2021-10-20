<?php

function labels($mes1,$mes2,$mes3,$mes4,$mes5,$mes6,$mes7,$mes8,$mes9,$mes10,$mes11,$mes12){
  $res = "labels  : [";
  if(!empty($mes1)){$res .= "'$mes1',";}
  if(!empty($mes2)){$res .= "'$mes2',";}
  if(!empty($mes3)){$res .= "'$mes3',";}
  if(!empty($mes4)){$res .= "'$mes4',";}
  if(!empty($mes5)){$res .= "'$mes5',";}
  if(!empty($mes6)){$res .= "'$mes6',";}
  if(!empty($mes7)){$res .= "'$mes7',";}
  if(!empty($mes8)){$res .= "'$mes8',";}
  if(!empty($mes9)){$res .= "'$mes9',";}
  if(!empty($mes10)){$res .= "'$mes10',";}
  if(!empty($mes11)){$res .= "'$mes11',";}
  if(!empty($mes12)){$res .= "'$mes12'";}
  $res .= "],";
  echo $res;
}

function datasets($label,$backgroundColor,$borderColor,$pointRadius,$pointColor,$pointStrokeColor,$pointHighlightFill,$pointHighlightStroke,$data){
  //el ultimo digito será un -
  $datos = explode('-',$data);
  $res = "
  {
    label               : '$label',
    backgroundColor     : '$backgroundColor',
    borderColor         : '$borderColor',
    pointRadius          : false,
    pointColor          : '$pointColor',
    pointStrokeColor    : '$pointStrokeColor',
    pointHighlightFill  : '$pointHighlightFill',
    pointHighlightStroke: '$pointHighlightStroke',
    data                : [";
  for($i=0; $i < count($datos); $i++){
    if($datos[$i] != ''){//para evitar problemas con el ultimo digito que será un -
      if($i == 0){$res .= $datos[$i];}
      else{$res .= ','.$datos[$i];}
    }
  }
  $res .= "]
  },
  ";
  echo $res;
}

///////////////////////////
//ESTADISTICAS ANUAL///
///////////////////////////
function existe_enHorasInicioAnual($hora_inicio){
	for($i=0; $i < count($_SESSION['horarios_anual']); $i++){
		if($_SESSION['horarios_anual'][$i] == $hora_inicio){$r = true; break;}
		else{$r = false;}
	}
	return $r;
}

function ordenar_horarios_anual(){
	for($i=0; $i < count($_SESSION['horarios_anual']); $i++){
		for($y=$i+1; $y < count($_SESSION['horarios_anual']); $y++){
			$hi1 = intval(substr($_SESSION['horarios_anual'][$i],0,2));
			$hf1 = intval(substr($_SESSION['horarios_anual'][$i],9,2));
			$mi1 = intval(substr($_SESSION['horarios_anual'][$i],3,2));
			$mf1 = intval(substr($_SESSION['horarios_anual'][$i],12,2));
			$hi2 = intval(substr($_SESSION['horarios_anual'][$y],0,2));
			$hf2 = intval(substr($_SESSION['horarios_anual'][$y],9,2));
			$mi2 = intval(substr($_SESSION['horarios_anual'][$y],3,2));
			$mf2 = intval(substr($_SESSION['horarios_anual'][$y],12,2));
			$hacer_cambio = false;
			if($hi1 > $hi2){//si es mayor cambiamos
				$hacer_cambio = true;
			}
			elseif($hi1 == $hi2){//si horas inicio son igual
				if($mi1 > $mi2){//cambiamos si minutos inicio mayor
					$hacer_cambio = true;
				}
				elseif($mi1 == $mi2){//si minutos inicial igual
					if($hf1 > $hf2){//cambiamos si horas final diferentes
						$hacer_cambio = true;
					}
					elseif($hf1 == $hf2){//si hora final igual
						if($mf1 > $mf2){//cambiamos si minutos final diferentes
							$hacer_cambio = true;
						}
					}
				}
			}
			if($hacer_cambio){
				$aux = $_SESSION['horarios_anual'][$i];
				$_SESSION['horarios_anual'][$i] = $_SESSION['horarios_anual'][$y];
				$_SESSION['horarios_anual'][$y] = $aux;
			}
		}
	}
}

function estadisticas_total_anual($id_empresa,$cargar_mes_actual){
	$num_mes_actual = date('n');
	$meses = obten_nombreMeses();
	for($i=1; $i <= 12; $i++){
		if($cargar_mes_actual == 0 || $i == $cargar_mes_actual){//validar si cargamos todo o mes actual
			$anyo = date('Y');//cargamos si es de año actual o año anterior
			if($i > $num_mes_actual){
				$anyo = intval(date('Y'))-1;
			}
			
			$_SESSION[$meses[$i-1].'_total_anual'][0] = ucfirst($meses[$i-1]).' '.$anyo;
			$_SESSION[$meses[$i-1].'_total_anual'][1] = obten_consultaUnCampo($_SESSION['pagina'],'count(id_turno)','turnos','id_empresa',$id_empresa,'YEAR(fecha_inicio)',$anyo,'MONTH(fecha_inicio)',$i,'','','');
			$aux = obten_consultaUnCampo($_SESSION['pagina'],'sum(suma_ganancias)','turnos','id_empresa',$id_empresa,'YEAR(fecha_inicio)',$anyo,'MONTH(fecha_inicio)',$i,'','','');
			$_SESSION[$meses[$i-1].'_total_anual'][2] = ($aux != '') ? $aux : 0;
			$aux = obten_consultaUnCampo($_SESSION['pagina'],'sum(asistentes)','turnos','id_empresa',$id_empresa,'YEAR(fecha_inicio)',$anyo,'MONTH(fecha_inicio)',$i,'','','');
			$_SESSION[$meses[$i-1].'_total_anual'][3] = ($aux != '') ? $aux : 0;
			
			$db = new MySQL($_SESSION['pagina']);
			$c = $db->consulta("SELECT hora_inicio,hora_fin FROM turnos WHERE id_empresa = '$id_empresa' AND YEAR(fecha_inicio) = '$anyo' order by hora_inicio; ");
			while($r = $c->fetch_array(MYSQLI_ASSOC)){
				if(!isset($_SESSION['horarios_anual']) || existe_enHorasInicioAnual($r['hora_inicio'].'-'.$r['hora_fin']) == false){
					if(isset($_SESSION['horarios_anual'][0])){
						$num = count($_SESSION['horarios_anual']);
					}
					else{
						$num = 0;
					}
					$_SESSION['horarios_anual'][$num] = $r['hora_inicio'].'-'.$r['hora_fin'];
					//obten_consultaUnCampo($_SESSION['pagina'],'hora_fin','turnos','id_empresa',$id_empresa,'hora_inicio',$r['hora_inicio'],'','','','',' limit 1');
				}
				//echo $r['hora_inicio'].'-';
			}

			//echo $_SESSION[$meses[$i-1].'_total_anual'][0].' '.$_SESSION[$meses[$i-1].'_total_anual'][1]. ' '.$_SESSION[$meses[$i-1].'_total_anual'][2].' '.$_SESSION[$meses[$i-1].'_total_anual'][3];
			
		}//fin if validar carga total o solo un mes
	}//fin for
	if(isset($_SESSION['horarios_anual'][0])){
		ordenar_horarios_anual();
	}
}

function estadisticas_parcial_anual($id_empresa){
	$num_mes_actual = date('n');
	$meses = obten_nombreMeses();
	$busqueda_horarios = " AND (";
	for($x=0; $x < count($_SESSION['horarios_recibidos_anual']); $x++){
		$horas = explode('-',$_SESSION['horarios_recibidos_anual'][$x]);
		if($x != 0){
			$busqueda_horarios .= " OR ";
		}
		$busqueda_horarios .= " (hora_inicio = '".$horas[0]."' AND hora_fin = '".$horas[1]."' ) ";
	}
	$busqueda_horarios .= ")";
	//echo 'busqueda '.$busqueda_horarios;
	$db = new MySQL($_SESSION['pagina']);
	for($i=1; $i <= 12; $i++){
		$anyo = date('Y');//cargamos si es de año actual o año anterior
		if($i > $num_mes_actual){
			$anyo = intval(date('Y'))-1;
		}

		$_SESSION[$meses[$i-1].'_parcial_anual'][0] = ucfirst($meses[$i-1]).' '.$anyo;
		$c = $db->consulta("SELECT count(id_turno) as t, sum(suma_ganancias) as g, sum(asistentes) as a from turnos where id_empresa = ".$id_empresa." and  YEAR(fecha_inicio) = ".$anyo." and MONTH(fecha_inicio) = ".$i.$busqueda_horarios."; ");
		$r = $c->fetch_array(MYSQLI_ASSOC);
		$_SESSION[$meses[$i-1].'_parcial_anual'][1] = $r['t'];
		$_SESSION[$meses[$i-1].'_parcial_anual'][2] = ($r['g'] != '') ? $r['g'] : 0;
		$_SESSION[$meses[$i-1].'_parcial_anual'][3] = ($r['a'] != '') ? $r['a'] : 0;
		//echo '       '.$_SESSION[$meses[$i-1].'_parcial_anual'][0].' '.$_SESSION[$meses[$i-1].'_parcial_anual'][1]. ' '.$_SESSION[$meses[$i-1].'_parcial_anual'][2].' '.$_SESSION[$meses[$i-1].'_parcial_anual'][3];
	}//fin for
}





///////////////////////////
//ESTADISTICAS MENSUALES///
///////////////////////////
function existe_enHorasInicioMensual($hora_inicio){
	for($i=0; $i < count($_SESSION['horarios_mensual']); $i++){
		if($_SESSION['horarios_mensual'][$i] == $hora_inicio){$r = true; break;}
		else{$r = false;}
	}
	return $r;
}

function ordenar_horarios_mensual(){
	for($i=0; $i < count($_SESSION['horarios_mensual']); $i++){
		for($y=$i+1; $y < count($_SESSION['horarios_mensual']); $y++){
			$hi1 = intval(substr($_SESSION['horarios_mensual'][$i],0,2));
			$hf1 = intval(substr($_SESSION['horarios_mensual'][$i],9,2));
			$mi1 = intval(substr($_SESSION['horarios_mensual'][$i],3,2));
			$mf1 = intval(substr($_SESSION['horarios_mensual'][$i],12,2));
			$hi2 = intval(substr($_SESSION['horarios_mensual'][$y],0,2));
			$hf2 = intval(substr($_SESSION['horarios_mensual'][$y],9,2));
			$mi2 = intval(substr($_SESSION['horarios_mensual'][$y],3,2));
			$mf2 = intval(substr($_SESSION['horarios_mensual'][$y],12,2));
			$hacer_cambio = false;
			if($hi1 > $hi2){//si es mayor cambiamos
				$hacer_cambio = true;
			}
			elseif($hi1 == $hi2){//si horas inicio son igual
				if($mi1 > $mi2){//cambiamos si minutos inicio mayor
					$hacer_cambio = true;
				}
				elseif($mi1 == $mi2){//si minutos inicial igual
					if($hf1 > $hf2){//cambiamos si horas final diferentes
						$hacer_cambio = true;
					}
					elseif($hf1 == $hf2){//si hora final igual
						if($mf1 > $mf2){//cambiamos si minutos final diferentes
							$hacer_cambio = true;
						}
					}
				}
			}
			if($hacer_cambio){
				$aux = $_SESSION['horarios_mensual'][$i];
				$_SESSION['horarios_mensual'][$i] = $_SESSION['horarios_mensual'][$y];
				$_SESSION['horarios_mensual'][$y] = $aux;
			}
		}
	}
}

function estadisticas_total_mensual($id_empresa,$mes,$anyo){
	$meses = obten_nombreMeses();
	$_SESSION['mes_total_mensual'][0] = $mes;//guardamos mes
	$_SESSION['mes_total_mensual'][1] = $anyo;//guardamos anyo
	$_SESSION['mes_total_mensual'][2] = ucfirst($meses[intval($mes)-1]).' '.$anyo;
	
	//obtenemos las fechas de las semanas
	$_SESSION['semana1_total_mensual'][0] = $anyo.'-'.$mes.'-'.'01/'.$anyo.'-'.$mes.'-'.'07';
	$_SESSION['semana2_total_mensual'][0] = $anyo.'-'.$mes.'-'.'08/'.$anyo.'-'.$mes.'-'.'14';
	$_SESSION['semana3_total_mensual'][0] = $anyo.'-'.$mes.'-'.'15/'.$anyo.'-'.$mes.'-'.'21';
	$_SESSION['semana4_total_mensual'][0] = $anyo.'-'.$mes.'-'.'22/'.$anyo.'-'.$mes.'-'.'28';
	//obtenemos la fecha de la semana5
	$fecha_siguiente_mes = date("Y-m-d",strtotime($anyo.'-'.$mes."-01 + 1 month"));
	$dia_fin_mes = date("d",strtotime($fecha_siguiente_mes."- 1 days"));
  
	if($dia_fin_mes > '29'){//si tiene mas de 29 dias
	  $_SESSION['semana5_total_mensual'][0] = $anyo.'-'.$mes.'-'.'29/'.$anyo.'-'.$mes.'-'.$dia_fin_mes;
	}
	elseif($dia_fin_mes < '29'){//si es febrero con 28
	  $_SESSION['semana5_total_mensual'][0] = '';
	}
	else{//si es febrero con 29
	  $_SESSION['semana5_total_mensual'][0] = $anyo.'-'.$mes.'-'.'29';
	}
  
	//obtenemos los datos
	for($i=1; $i <= 5; $i++){
		//sacamos las fechas
		$aux = explode('/',$_SESSION['semana'.$i.'_total_mensual'][0]);
		for($x = 0; $x < count($aux); $x++){
			if($x == 0){$fecha_desde = $aux[$x];}
			else{$fecha_hasta = $aux[$x];}
		}
		if(isset($fecha_hasta) && $fecha_hasta != ''){
			$db = new MySQL($_SESSION['pagina']);
			$c = $db->consulta("SELECT count(id_turno) as turnos, sum(suma_ganancias) as ganancias, sum(asistentes) as asistentes from turnos where id_empresa = ".$id_empresa." and fecha_inicio between '".$fecha_desde."' and '".$fecha_hasta."'  ;");
			$r = $c->fetch_array(MYSQLI_ASSOC);
			$_SESSION['semana'.$i.'_total_mensual'][1] = $r['turnos'];
			$_SESSION['semana'.$i.'_total_mensual'][2] = ($r['ganancias'] != '') ? $r['ganancias'] : 0;
			$_SESSION['semana'.$i.'_total_mensual'][3] = ($r['asistentes'] != '') ? $r['asistentes'] : 0;

			$c = $db->consulta("SELECT hora_inicio,hora_fin FROM turnos WHERE id_empresa = '$id_empresa' and fecha_inicio between '".$fecha_desde."' and '".$fecha_hasta."' order by hora_inicio ;");
			while($r = $c->fetch_array(MYSQLI_ASSOC)){
				if(!isset($_SESSION['horarios_mensual']) || existe_enHorasInicioMensual($r['hora_inicio'].'-'.$r['hora_fin']) == false){
					if(isset($_SESSION['horarios_mensual'][0])){
						$num = count($_SESSION['horarios_mensual']);
					}
					else{
						$num = 0;
					}
					$_SESSION['horarios_mensual'][$num] = $r['hora_inicio'].'-'.$r['hora_fin'];
					//obten_consultaUnCampo($_SESSION['pagina'],'hora_fin','turnos','id_empresa',$id_empresa,'hora_inicio',$r['hora_inicio'],'','','','',' limit 1');
				}
				//echo $r['hora_inicio'].'-';
			}  
		}
		else{
			$db = new MySQL($_SESSION['pagina']);
			$c = $db->consulta("SELECT count(id_turno) as turnos, sum(suma_ganancias) as ganancias, sum(asistentes) as asistentes from turnos where id_empresa = ".$id_empresa." and fecha_inicio = '".$fecha_desde."' ;");
			$r = $c->fetch_array(MYSQLI_ASSOC);
			$_SESSION['semana'.$i.'_total_mensual'][1] = $r['turnos'];
			$_SESSION['semana'.$i.'_total_mensual'][2] = $r['ganancias'];
			$_SESSION['semana'.$i.'_total_mensual'][3] = $r['asistentes'];

			$c = $db->consulta("SELECT hora_inicio,hora_fin FROM turnos WHERE id_empresa = '$id_empresa' and fecha_inicio = '".$fecha_desde."' order by hora_inicio;");
			while($r = $c->fetch_array(MYSQLI_ASSOC)){
				if(!isset($_SESSION['horarios_mensual']) || existe_enHorasInicioMensual($r['hora_inicio'].'-'.$r['hora_fin']) == false){
					if(isset($_SESSION['horarios_mensual'][0])){
						$num = count($_SESSION['horarios_mensual']);
					}
					else{
						$num = 0;
					}
					$_SESSION['horarios_mensual'][$num] = $r['hora_inicio'].'-'.$r['hora_fin'];
					//obten_consultaUnCampo($_SESSION['pagina'],'hora_fin','turnos','id_empresa',$id_empresa,'hora_inicio',$r['hora_inicio'],'','','','',' limit 1');
				}
				//echo $r['hora_inicio'].'-';
			}  
		}
	  	//echo 'semana '.$i.'-'.$_SESSION['semana'.$i.'_total_mensual'][1].'-'.$_SESSION['semana'.$i.'_total_mensual'][2].'-'.$_SESSION['semana'.$i.'_total_mensual'][3].'////////////////////';
	  	
	  	unset($aux,$fecha_desde,$fecha_hasta);
	}
	if(isset($_SESSION['horarios_mensual'][0])){
		ordenar_horarios_mensual();
	}
}

function estadisticas_parcial_mensual($id_empresa){
	$meses = obten_nombreMeses();
	/*
	$_SESSION['mes_mensual'][0] = $mes;//guardamos mes
	$_SESSION['mes_mensual'][1] = $anyo;//guardamos anyo
	$_SESSION['mes_mensual'][2] = ucfirst($meses[intval($mes)-1]).' '.$anyo;
	*/

	//obtenemos las fechas de las semanas
	$_SESSION['semana1_parcial_mensual'][0] = $_SESSION['semana1_total_mensual'][0];
	$_SESSION['semana2_parcial_mensual'][0] = $_SESSION['semana2_total_mensual'][0];
	$_SESSION['semana3_parcial_mensual'][0] = $_SESSION['semana3_total_mensual'][0];
	$_SESSION['semana4_parcial_mensual'][0] = $_SESSION['semana4_total_mensual'][0];
	$_SESSION['semana5_parcial_mensual'][0] = $_SESSION['semana5_total_mensual'][0];

	$busqueda_horarios = " AND (";
	for($x=0; $x < count($_SESSION['horarios_recibidos_mensual']); $x++){
		$horas = explode('-',$_SESSION['horarios_recibidos_mensual'][$x]);
		if($x != 0){
			$busqueda_horarios .= " OR ";
		}
		$busqueda_horarios .= " (hora_inicio = '".$horas[0]."' AND hora_fin = '".$horas[1]."' ) ";
	}
	$busqueda_horarios .= ")";
	//echo 'busqueda '.$busqueda_horarios;
	//obtenemos los datos
	for($i=1; $i <= 5; $i++){
	  //sacamos las fechas
	  $aux = explode('/',$_SESSION['semana'.$i.'_parcial_mensual'][0]);
	  for($x = 0; $x < count($aux); $x++){
		if($x == 0){$fecha_desde = $aux[$x];}
		else{$fecha_hasta = $aux[$x];}
	  }
	  if(isset($fecha_hasta) && $fecha_hasta != ''){
		$db = new MySQL($_SESSION['pagina']);
		$c = $db->consulta("SELECT count(id_turno) as turnos, sum(suma_ganancias) as ganancias, sum(asistentes) as asistentes from turnos where id_empresa = ".$id_empresa." and fecha_inicio between '".$fecha_desde."' and '".$fecha_hasta."' ".$busqueda_horarios." ;");
		$r = $c->fetch_array(MYSQLI_ASSOC);
		$_SESSION['semana'.$i.'_parcial_mensual'][1] = $r['turnos'];
		$_SESSION['semana'.$i.'_parcial_mensual'][2] = ($r['ganancias'] != '') ? $r['ganancias'] : 0;
		$_SESSION['semana'.$i.'_parcial_mensual'][3] = ($r['asistentes'] != '') ? $r['asistentes'] : 0;
	  }
	  else{
		$db = new MySQL($_SESSION['pagina']);
		$c = $db->consulta("SELECT count(id_turno) as turnos, sum(suma_ganancias) as ganancias, sum(asistentes) as asistentes from turnos where id_empresa = ".$id_empresa." and fecha_inicio = '".$fecha_desde."' ".$busqueda_horarios." ;");
		$r = $c->fetch_array(MYSQLI_ASSOC);
		$_SESSION['semana'.$i.'_parcial_mensual'][1] = $r['turnos'];
		$_SESSION['semana'.$i.'_parcial_mensual'][2] = $r['ganancias'];
		$_SESSION['semana'.$i.'_parcial_mensual'][3] = $r['asistentes'];
	  }
	  //echo 'semana '.$i.'-'.$_SESSION['semana'.$i.'_parcial_mensual'][1].'-'.$_SESSION['semana'.$i.'_parcial_mensual'][2].'-'.$_SESSION['semana'.$i.'__parcial_mensual'][3].'////////////////////';
	  unset($aux,$fecha_desde,$fecha_hasta);
  }
  
}



///////////////////////////
//ESTADISTICAS SEMANALES//
///////////////////////////
function existe_enHorasInicioSemanal($hora_inicio){
	for($i=0; $i < count($_SESSION['horarios_semanal']); $i++){
		if($_SESSION['horarios_semanal'][$i] == $hora_inicio){$r = true; break;}
		else{$r = false;}
	}
	return $r;
}

function ordenar_horarios_semanal(){
	for($i=0; $i < count($_SESSION['horarios_semanal']); $i++){
		for($y=$i+1; $y < count($_SESSION['horarios_semanal']); $y++){
			$hi1 = intval(substr($_SESSION['horarios_semanal'][$i],0,2));
			$hf1 = intval(substr($_SESSION['horarios_semanal'][$i],9,2));
			$mi1 = intval(substr($_SESSION['horarios_semanal'][$i],3,2));
			$mf1 = intval(substr($_SESSION['horarios_semanal'][$i],12,2));
			$hi2 = intval(substr($_SESSION['horarios_semanal'][$y],0,2));
			$hf2 = intval(substr($_SESSION['horarios_semanal'][$y],9,2));
			$mi2 = intval(substr($_SESSION['horarios_semanal'][$y],3,2));
			$mf2 = intval(substr($_SESSION['horarios_semanal'][$y],12,2));
			$hacer_cambio = false;
			if($hi1 > $hi2){//si es mayor cambiamos
				$hacer_cambio = true;
			}
			elseif($hi1 == $hi2){//si horas inicio son igual
				if($mi1 > $mi2){//cambiamos si minutos inicio mayor
					$hacer_cambio = true;
				}
				elseif($mi1 == $mi2){//si minutos inicial igual
					if($hf1 > $hf2){//cambiamos si horas final diferentes
						$hacer_cambio = true;
					}
					elseif($hf1 == $hf2){//si hora final igual
						if($mf1 > $mf2){//cambiamos si minutos final diferentes
							$hacer_cambio = true;
						}
					}
				}
			}
			if($hacer_cambio){
				$aux = $_SESSION['horarios_semanal'][$i];
				$_SESSION['horarios_semanal'][$i] = $_SESSION['horarios_semanal'][$y];
				$_SESSION['horarios_semanal'][$y] = $aux;
			}
		}
	}
}

function estadisticas_total_semanal($id_empresa,$dia){
	$dia_semana = date('N',strtotime($dia));
	$resto = $dia_semana - 1;
	
	$_SESSION['dia1_total_semanal'][0] = date('Y-m-d',strtotime($dia.'-'.$resto.' days'));//guardamos el inicio de la semana
	$_SESSION['dia1_total_semanal'][1] = obten_consultaUnCampo($_SESSION['pagina'],'count(id_turno)','turnos','id_empresa',$id_empresa,'fecha_inicio',$_SESSION['dia1_total_semanal'][0],'','','','','');
	$aux = obten_consultaUnCampo($_SESSION['pagina'],'sum(suma_ganancias)','turnos','id_empresa',$id_empresa,'fecha_inicio',$_SESSION['dia1_total_semanal'][0],'','','','','');
	$_SESSION['dia1_total_semanal'][2] = ($aux != '') ? $aux : 0;
	$aux = obten_consultaUnCampo($_SESSION['pagina'],'sum(asistentes)','turnos','id_empresa',$id_empresa,'fecha_inicio',$_SESSION['dia1_total_semanal'][0],'','','','','');
	$_SESSION['dia1_total_semanal'][3] = ($aux != '') ? $aux : 0;
	//echo $_SESSION['dia1_total_semanal'][0].'-'.$_SESSION['dia1_total_semanal'][1].'-'.$_SESSION['dia1_total_semanal'][2].'-'.$_SESSION['dia1_total_semanal'][3].'//////';

	for($i=2; $i <= 7; $i++){
		$_SESSION['dia'.$i.'_total_semanal'][0] = date('Y-m-d',strtotime($_SESSION['dia1_total_semanal'][0].'+'.($i-1).' days'));
		$_SESSION['dia'.$i.'_total_semanal'][1] = obten_consultaUnCampo($_SESSION['pagina'],'count(id_turno)','turnos','id_empresa',$id_empresa,'fecha_inicio',$_SESSION['dia'.$i.'_total_semanal'][0],'','','','','');
		$aux = obten_consultaUnCampo($_SESSION['pagina'],'sum(suma_ganancias)','turnos','id_empresa',$id_empresa,'fecha_inicio',$_SESSION['dia'.$i.'_total_semanal'][0],'','','','','');
		$_SESSION['dia'.$i.'_total_semanal'][2] = ($aux != '') ? $aux : 0;
		$aux = obten_consultaUnCampo($_SESSION['pagina'],'sum(asistentes)','turnos','id_empresa',$id_empresa,'fecha_inicio',$_SESSION['dia'.$i.'_total_semanal'][0],'','','','','');
		$_SESSION['dia'.$i.'_total_semanal'][3] = ($aux != '') ? $aux : 0;
		//echo $_SESSION['dia'.$i.'_total_semanal'][0].'-'.$_SESSION['dia'.$i.'_total_semanal'][1].'-'.$_SESSION['dia'.$i.'_total_semanal'][2].'-'.$_SESSION['dia'.$i.'_total_semanal'][3].'//////';
	}

	$db = new MySQL($_SESSION['pagina']);
	for($i=1; $i <= 7; $i++){
		$c = $db->consulta("SELECT hora_inicio,hora_fin FROM turnos WHERE id_empresa = '".$id_empresa."' AND fecha_inicio = '".$_SESSION['dia'.$i.'_total_semanal'][0]."' order by hora_inicio; ");
		while($r = $c->fetch_array(MYSQLI_ASSOC)){
			if(!isset($_SESSION['horarios_semanal']) || existe_enHorasInicioSemanal($r['hora_inicio'].'-'.$r['hora_fin']) == false){
				if(isset($_SESSION['horarios_semanal'][0])){
					$num = count($_SESSION['horarios_semanal']);
				}
				else{
					$num = 0;
				}
				$_SESSION['horarios_semanal'][$num] = $r['hora_inicio'].'-'.$r['hora_fin'];
			}
		}
	}

	if(isset($_SESSION['horarios_semanal'][0])){
		ordenar_horarios_semanal();
	}
	
}

function estadisticas_parcial_semanal($id_empresa){
	$busqueda_horarios = " AND (";
	for($x=0; $x < count($_SESSION['horarios_recibidos_semanal']); $x++){
		$horas = explode('-',$_SESSION['horarios_recibidos_semanal'][$x]);
		if($x != 0){
			$busqueda_horarios .= " OR ";
		}
		$busqueda_horarios .= " (hora_inicio = '".$horas[0]."' AND hora_fin = '".$horas[1]."' ) ";
	}
	$busqueda_horarios .= ")";
	//echo 'busqueda '.$busqueda_horarios;

	$db = new MySQL($_SESSION['pagina']);
	for($i=1; $i <= 7; $i++){
		$fecha = $_SESSION['dia'.$i.'_total_semanal'][0];
		$c = $db->consulta("SELECT count(id_turno) as turnos, sum(suma_ganancias) as ganancias, sum(asistentes) as asistentes from turnos where id_empresa = ".$id_empresa." and fecha_inicio = '".$fecha."' ".$busqueda_horarios." ;");
		$r = $c->fetch_array(MYSQLI_ASSOC);
		$_SESSION['dia'.$i.'_parcial_semanal'][0] = $_SESSION['dia'.$i.'_total_semanal'][0];
		$_SESSION['dia'.$i.'_parcial_semanal'][1] = $r['turnos'];
		$_SESSION['dia'.$i.'_parcial_semanal'][2] = ($r['ganancias'] != '') ? $r['ganancias'] : 0;
		$_SESSION['dia'.$i.'_parcial_semanal'][3] = ($r['asistentes'] != '') ? $r['asistentes'] : 0;
		//echo $_SESSION['dia'.$i.'_parcial_semanal'][0].'-'.$_SESSION['dia'.$i.'_parcial_semanal'][1].'-'.$_SESSION['dia'.$i.'_parcial_semanal'][2].'-'.$_SESSION['dia'.$i.'_parcial_semanal'][3].'//////';
	}

}



///////////////////////////
//ESTADISTICAS DIARIA//
///////////////////////////
function existe_enHorasInicioDiaria($hora_inicio){
	for($i=0; $i < count($_SESSION['horarios_diaria']); $i++){
		if($_SESSION['horarios_diaria'][$i] == $hora_inicio){$r = true; break;}
		else{$r = false;}
	}
	return $r;
}

function ordenar_horarios_diaria(){
	for($i=0; $i < count($_SESSION['horarios_diaria']); $i++){
		for($y=$i+1; $y < count($_SESSION['horarios_diaria']); $y++){
			$hi1 = intval(substr($_SESSION['horarios_diaria'][$i],0,2));
			$hf1 = intval(substr($_SESSION['horarios_diaria'][$i],9,2));
			$mi1 = intval(substr($_SESSION['horarios_diaria'][$i],3,2));
			$mf1 = intval(substr($_SESSION['horarios_diaria'][$i],12,2));
			$hi2 = intval(substr($_SESSION['horarios_diaria'][$y],0,2));
			$hf2 = intval(substr($_SESSION['horarios_diaria'][$y],9,2));
			$mi2 = intval(substr($_SESSION['horarios_diaria'][$y],3,2));
			$mf2 = intval(substr($_SESSION['horarios_diaria'][$y],12,2));
			$hacer_cambio = false;
			if($hi1 > $hi2){//si es mayor cambiamos
				$hacer_cambio = true;
			}
			elseif($hi1 == $hi2){//si horas inicio son igual
				if($mi1 > $mi2){//cambiamos si minutos inicio mayor
					$hacer_cambio = true;
				}
				elseif($mi1 == $mi2){//si minutos inicial igual
					if($hf1 > $hf2){//cambiamos si horas final diferentes
						$hacer_cambio = true;
					}
					elseif($hf1 == $hf2){//si hora final igual
						if($mf1 > $mf2){//cambiamos si minutos final diferentes
							$hacer_cambio = true;
						}
					}
				}
			}
			if($hacer_cambio){
				$aux = $_SESSION['horarios_diaria'][$i];
				$_SESSION['horarios_diaria'][$i] = $_SESSION['horarios_diaria'][$y];
				$_SESSION['horarios_diaria'][$y] = $aux;
			}
		}
	}
}

function estadisticas_total_diaria($id_empresa,$dia){
	$_SESSION['dia1_total_diaria'][0] = $dia;//guardamos el inicio de la semana
	$_SESSION['dia1_total_diaria'][1] = obten_consultaUnCampo($_SESSION['pagina'],'count(id_turno)','turnos','id_empresa',$id_empresa,'fecha_inicio',$_SESSION['dia1_total_diaria'][0],'','','','','');
	$aux = obten_consultaUnCampo($_SESSION['pagina'],'sum(suma_ganancias)','turnos','id_empresa',$id_empresa,'fecha_inicio',$_SESSION['dia1_total_diaria'][0],'','','','','');
	$_SESSION['dia1_total_diaria'][2] = ($aux != '') ? $aux : 0;
	$aux = obten_consultaUnCampo($_SESSION['pagina'],'sum(asistentes)','turnos','id_empresa',$id_empresa,'fecha_inicio',$_SESSION['dia1_total_diaria'][0],'','','','','');
	$_SESSION['dia1_total_diaria'][3] = ($aux != '') ? $aux : 0;
	//echo $_SESSION['dia1_total_diaria'][0].'-'.$_SESSION['dia1_total_diaria'][1].'-'.$_SESSION['dia1_total_diaria'][2].'-'.$_SESSION['dia1_total_diaria'][3].'//////';

	$db = new MySQL($_SESSION['pagina']);
	$c = $db->consulta("SELECT hora_inicio,hora_fin FROM turnos WHERE id_empresa = '".$id_empresa."' AND fecha_inicio = '".$_SESSION['dia1_total_diaria'][0]."' order by hora_inicio; ");
	while($r = $c->fetch_array(MYSQLI_ASSOC)){
		if(!isset($_SESSION['horarios_diaria']) || existe_enHorasInicioDiaria($r['hora_inicio'].'-'.$r['hora_fin']) == false){
			if(isset($_SESSION['horarios_diaria'][0])){
				$num = count($_SESSION['horarios_diaria']);
			}
			else{
				$num = 0;
			}
			$_SESSION['horarios_diaria'][$num] = $r['hora_inicio'].'-'.$r['hora_fin'];
		}
	}


	if(isset($_SESSION['horarios_diaria'][0])){
		ordenar_horarios_diaria();
	}
	
}

function estadisticas_parcial_diaria($id_empresa){
	$busqueda_horarios = " AND (";
	for($x=0; $x < count($_SESSION['horarios_recibidos_diaria']); $x++){
		$horas = explode('-',$_SESSION['horarios_recibidos_diaria'][$x]);
		if($x != 0){
			$busqueda_horarios .= " OR ";
		}
		$busqueda_horarios .= " (hora_inicio = '".$horas[0]."' AND hora_fin = '".$horas[1]."' ) ";
	}
	$busqueda_horarios .= ")";
	//echo 'busqueda '.$busqueda_horarios;

	$db = new MySQL($_SESSION['pagina']);
	$fecha = $_SESSION['dia1_total_diaria'][0];
	$c = $db->consulta("SELECT count(id_turno) as turnos, sum(suma_ganancias) as ganancias, sum(asistentes) as asistentes from turnos where id_empresa = ".$id_empresa." and fecha_inicio = '".$fecha."' ".$busqueda_horarios." ;");
	$r = $c->fetch_array(MYSQLI_ASSOC);
	$_SESSION['dia1_parcial_diaria'][0] = $_SESSION['dia1_total_diaria'][0];
	$_SESSION['dia1_parcial_diaria'][1] = $r['turnos'];
	$_SESSION['dia1_parcial_diaria'][2] = ($r['ganancias'] != '') ? $r['ganancias'] : 0;
	$_SESSION['dia1_parcial_diaria'][3] = ($r['asistentes'] != '') ? $r['asistentes'] : 0;
	//echo $_SESSION['dia1_parcial_diaria'][0].'-'.$_SESSION['dia1_parcial_diaria'][1].'-'.$_SESSION['dia1_parcial_diaria'][2].'-'.$_SESSION['dia1_parcial_diaria'][3].'//////';


}

///////////////////////////
//////  DONUTS  ///////////
///////////////////////////

function labels_donuts($valores){
  $datos = explode('-',$valores);
  $res = "labels  : [";
  for($i=0; $i < count($datos); $i++){
    if(!empty($datos[$i])){$res .= "'".$datos[$i]."',";}
  }
  $res .= "],";
  echo $res;
}

function obtener_porcentaje($total, $valor){
	if($valor == 0){
		$res = 0;
		$res = " (0%)";
	}
	else{
		$res = " (".round(($valor*100)/$total,1)."%)";
	}
  return $res;
}



///////////////////////////
//ACTIVIDADES ANUALES /////
///////////////////////////

function actividades_anual($id_empresa){
  $fecha_hora_busqueda = date("Y-m-d H:i:s",strtotime($_SESSION['fecha_min_busqueda']));
  $_SESSION['actividades_total_anual'] = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'','','','','','','and fechahora >= "'.$fecha_hora_busqueda.'"');
  
  if($_SESSION['actividades_total_anual'] > 0){//datos generales
	$usuario_admin = obten_consultaUnCampo($_SESSION['pagina'],'nombre','empresas','id_empresa',$id_empresa,'','','','','','','');
	if($usuario_admin != ''){
		$usuario_admin = obten_consultaUnCampo($_SESSION['pagina'],'usuario','empresas','id_empresa',$id_empresa,'','','','','','','');
	}
	$datos_admin = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'id_usuario','0','','','','','and fechahora >= "'.$fecha_hora_busqueda.'"');;
	$_SESSION['noms_usuarios_anual'] = "'".$usuario_admin.obtener_porcentaje($_SESSION['actividades_total_anual'],$datos_admin)."'";
	$_SESSION['datos_usuarios_anual'] = $datos_admin;
	$_SESSION['colores_anual'] = "'#05BAF9'";
	$db = new MySQL($_SESSION['pagina']);
	$c = $db->consulta("SELECT id_usuario, usuario, color from usuarios where id_empresa = ".$id_empresa." and estado = 0 ;");
	while($r = $c->fetch_array(MYSQLI_ASSOC)){
		$datos = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'id_usuario',$r['id_usuario'],'','','','','and fechahora >= "'.$fecha_hora_busqueda.'"');
		if($datos > 0){
		$_SESSION['noms_usuarios_anual'] .= ",'".$r['usuario'].obtener_porcentaje($_SESSION['actividades_total_anual'],$datos)."'";
		$_SESSION['datos_usuarios_anual'] .= ','.$datos;
		$_SESSION['colores_anual'] .= ",'".$r['color']."'";
		}
	}
	//echo $_SESSION['ids_usuarios'].'-'.$_SESSION['noms_usuarios_anual'].'-'.$_SESSION['datos_usuarios_anual'].'-'.$_SESSION['colores_anual'];
  }//fin if
  else{
    $_SESSION['noms_usuarios_anual'] = "No hay datos";
  }

}


///////////////////////////
//ACTIVIDADES MENSUAL /////
///////////////////////////
function actividades_mensual($id_empresa,$mes,$anyo){
  $_SESSION['mes_actividad'] = $mes;
  $_SESSION['anyo_actividad'] = $anyo;

  $_SESSION['actividades_total_mensual'] = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'','','','','','',' and YEAR(fechahora) = "'.$anyo.'" and MONTH(fechahora) = "'.$mes.'"');
  if($_SESSION['actividades_total_mensual'] > 0){//si no hay datos del mes no entramos
    $usuario_admin = obten_consultaUnCampo($_SESSION['pagina'],'nombre','empresas','id_empresa',$id_empresa,'','','','','','','');
    if($usuario_admin != ''){
      $usuario_admin = obten_consultaUnCampo($_SESSION['pagina'],'usuario','empresas','id_empresa',$id_empresa,'','','','','','','');
	}
	
    $datos_admin = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'id_usuario','0','','','','',' and YEAR(fechahora) = "'.$anyo.'" and MONTH(fechahora) = "'.$mes.'"');
    $_SESSION['noms_usuarios_mensual'] = "'".$usuario_admin.obtener_porcentaje($_SESSION['actividades_total_mensual'],$datos_admin)."'";
    $_SESSION['datos_usuarios_mensual'] = $datos_admin;
	$_SESSION['colores_mensual'] = "'#05BAF9'";
	
    $db = new MySQL($_SESSION['pagina']);
    $c = $db->consulta("SELECT id_usuario, usuario, color from usuarios where id_empresa = ".$id_empresa." and estado = 0 ;");
    while($r = $c->fetch_array(MYSQLI_ASSOC)){
      $datos = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'id_usuario',$r['id_usuario'],'','','','',' and YEAR(fechahora) = "'.$anyo.'" and MONTH(fechahora) = "'.$mes.'"');
      if($datos > 0){
        $_SESSION['noms_usuarios_mensual'] .= ",'".$r['usuario'].obtener_porcentaje($_SESSION['actividades_total_mensual'],$datos)."'";
        $_SESSION['datos_usuarios_mensual'] .= ','.$datos;
        $_SESSION['colores_mensual'] .= ",'".$r['color']."'";
      }
    }
    //echo $_SESSION['ids_usuarios'].'-'.$_SESSION['noms_usuarios_mensual'].'-'.$_SESSION['datos_usuarios_mensual'].'-'.$_SESSION['colores_mensual'];
  }//fin if
  else{
    $_SESSION['noms_usuarios_mensual'] = "No hay datos";
  }
    
}


///////////////////////////
//ACTIVIDADES SEMANAL /////
///////////////////////////
function actividades_semanal($id_empresa,$dia){
  $_SESSION['dia_actividad'] = $dia;
  $dia_semana = date('N',strtotime($dia));
  $resto = $dia_semana - 1;
  
  $dia_inicio_semana = date('Y-m-d',strtotime($dia.'-'.$resto.' days'));//guardamos el inicio de la semana
  $dia_fin_semana = date('Y-m-d',strtotime($dia_inicio_semana.'+ 6 days'));//guardamos el fin de la semana
  $_SESSION['semana_actividad'][0] = $dia_inicio_semana;
  $_SESSION['semana_actividad'][1] = $dia_fin_semana;

  //echo $_SESSION['semana_actividad'][0].'-'.$_SESSION['semana_actividad'][1];
  $_SESSION['actividades_total_semanal'] = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'','','','','','','and fechahora between "'.$dia_inicio_semana.'" and "'.$dia_fin_semana.'"');
  if($_SESSION['actividades_total_semanal'] > 0){//si no hay datos del mes no entramos
	
	$usuario_admin = obten_consultaUnCampo($_SESSION['pagina'],'nombre','empresas','id_empresa',$id_empresa,'','','','','','','');
    if($usuario_admin != ''){
      $usuario_admin = obten_consultaUnCampo($_SESSION['pagina'],'usuario','empresas','id_empresa',$id_empresa,'','','','','','','');
    }
    $datos_admin = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'id_usuario','0','','','','','and fechahora between "'.$dia_inicio_semana.'" and "'.$dia_fin_semana.'"');
    $_SESSION['noms_usuarios_semanal'] = "'".$usuario_admin.obtener_porcentaje($_SESSION['actividades_total_semanal'],$datos_admin)."'";
    $_SESSION['datos_usuarios_semanal'] = $datos_admin;
	$_SESSION['colores_semanal'] = "'#05BAF9'";
	
    $db = new MySQL($_SESSION['pagina']);
    $c = $db->consulta("SELECT id_usuario, usuario, color from usuarios where id_empresa = ".$id_empresa." and estado = 0 ;");
    while($r = $c->fetch_array(MYSQLI_ASSOC)){
      $datos = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'id_usuario',$r['id_usuario'],'','','','','and fechahora between "'.$dia_inicio_semana.'" and "'.$dia_fin_semana.'"');
      if($datos > 0){
        $_SESSION['noms_usuarios_semanal'] .= ",'".$r['usuario'].obtener_porcentaje($_SESSION['actividades_total_semanal'],$datos)."'";
        $_SESSION['datos_usuarios_semanal'] .= ','.$datos;
        $_SESSION['colores_semanal'] .= ",'".$r['color']."'";
      }
    }
    //echo $_SESSION['ids_usuarios'].'-'.$_SESSION['noms_usuarios_semanal'].'-'.$_SESSION['datos_usuarios_semanal'].'-'.$_SESSION['colores_semanal'];
  }//fin if
  else{
    $_SESSION['noms_usuarios_semanal'] = "No hay datos";
  }
    
}


///////////////////////////
//ACTIVIDADES DIARIAS /////
///////////////////////////
function actividades_diaria($id_empresa,$dia){
	$_SESSION['dia_actividad'] = $dia;
  
	//echo $_SESSION['dia_actividad'].'-'.$_SESSION['dia_actividad'];
	$_SESSION['actividades_total_diaria'] = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'DATE(fechahora)',$dia,'','','','','');
	if($_SESSION['actividades_total_diaria'] > 0){//si no hay datos del mes no entramos
	  $usuario_admin = obten_consultaUnCampo($_SESSION['pagina'],'nombre','empresas','id_empresa',$id_empresa,'','','','','','','');
	  if($usuario_admin != ''){
		$usuario_admin = obten_consultaUnCampo($_SESSION['pagina'],'usuario','empresas','id_empresa',$id_empresa,'','','','','','','');
	  }
	  $datos_admin = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'id_usuario','0','DATE(fechahora)',$dia,'','','');
	  $_SESSION['noms_usuarios_diaria'] = "'".$usuario_admin.obtener_porcentaje($_SESSION['actividades_total_diaria'],$datos_admin)."'";
	  $_SESSION['datos_usuarios_diaria'] = $datos_admin;
	  $_SESSION['colores_diaria'] = "'#05BAF9'";
	  $db = new MySQL($_SESSION['pagina']);
	  $c = $db->consulta("SELECT id_usuario, usuario, color from usuarios where id_empresa = ".$id_empresa." and estado = 0 ;");
	  while($r = $c->fetch_array(MYSQLI_ASSOC)){
		$datos = obten_consultaUnCampo($_SESSION['pagina'],'count(id_actividad)','actividades','id_empresa',$id_empresa,'id_usuario',$r['id_usuario'],'DATE(fechahora)',$dia,'','','');
		if($datos > 0){
		  $_SESSION['noms_usuarios_diaria'] .= ",'".$r['usuario'].obtener_porcentaje($_SESSION['actividades_total_diaria'],$datos)."'";
		  $_SESSION['datos_usuarios_diaria'] .= ','.$datos;
		  $_SESSION['colores_diaria'] .= ",'".$r['color']."'";
		}
	  }
	  //echo $_SESSION['ids_usuarios'].'-'.$_SESSION['noms_usuarios_diaria'].'-'.$_SESSION['datos_usuarios_diaria'].'-'.$_SESSION['colores_diaria'];
	}//fin if
	else{
	  $_SESSION['noms_usuarios_diaria'] = "No hay datos";
	}
	  
}

?>