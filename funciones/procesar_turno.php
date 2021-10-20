<?php
include_once ("../class/mysql.php");
include_once ("../class/turnos.php");
include_once ("../class/actividades.php");
include_once ("generales.php");
session_start();
if ( comprobar_pagina($_SESSION['pagina']) ){
	header ("Location: ".url_completa());
}
else {

	$id_turno = limpiaTexto(htmlspecialchars($_POST["id_turno"]));
	$operacion = limpiaTexto(htmlspecialchars($_POST["operacion"]));
	if($operacion == 'I' || $operacion == 'U'){
		$fecha = limpiaTexto(htmlspecialchars($_POST["fecha"]));
		$horario = limpiaTexto(htmlspecialchars($_POST["horario"]));
		$descripcion = limpiaTexto(htmlspecialchars($_POST["descripcion"]));
		$asistentes = limpiaTexto(htmlspecialchars($_POST["asistentes"]));
		$suma_ganancias = limpiaTexto(htmlspecialchars($_POST["suma_ganancias"]));
		$personas_max = limpiaTexto(htmlspecialchars($_POST["personas_max"]));
		if(isset($_POST["repetir"])){
			$repetir = limpiaTexto(htmlspecialchars($_POST["repetir"]));
			$dias = limpiaTexto(htmlspecialchars($_POST["dias"]));
		}
		else{
			$repetir = 'N';
			$dias = 1;
		}
		
	
		$horas = obtener_horas($horario);
		$hora_inicio = $horas[0];
		$hora_fin = $horas[1];
	}
	
	unset($_SESSION['alerta_usuario'],$_SESSION['alerta_mensaje']);
	
	if( $operacion == 'I' && $id_turno == 0 ){//nuevo turno
		for($i=0; $i < $dias; $i++){
			$newFecha = date("Y-m-d",strtotime($fecha."+ ".$i." days")); 
			$newTurno = new Turno('',$_SESSION['id_usuario'],$_SESSION['id_empresa'],$newFecha,$hora_inicio,$newFecha,$hora_fin,0,$suma_ganancias,$personas_max,0,$descripcion,obten_fechahora(),$asistentes);
			$newTurno -> insertar($_SESSION['pagina']);
			$actividad = new Actividad('',date('Y-m-d H:i:s'),$_SESSION['id_usuario'],$_SESSION['id_empresa'],'Insertar turno');
			$actividad -> insertar($_SESSION['pagina']);
			unset($newFecha,$newTurno,$actividad);
		}

		$_SESSION['alerta_usuario'] = 'success';
		if($dias == 1){
			$_SESSION['alerta_mensaje'] = 'La franja horaria ha sido creada correctamente!';
		}
		else{
			$_SESSION['alerta_mensaje'] = 'Las franjas horarias han sido creadas correctamente!';
		}
	}
	elseif( ($operacion == 'U' || $operacion == 'D') && $id_turno > 0 ){//modificacion o delete(modificacion estado a 1)
		
		$turnoModificar = new Turno($id_turno,'','','','','','','','','','','','','');
		if( $operacion == 'U' ){//modificar
			$newFecha = date("Y-m-d",strtotime($fecha));
			$turnoModificar -> setValor('id_usuario',$_SESSION['id_usuario']);
			$turnoModificar -> setValor('fecha_inicio',$newFecha);
			$turnoModificar -> setValor('hora_inicio',$hora_inicio);
			$turnoModificar -> setValor('fecha_fin',$newFecha);
			$turnoModificar -> setValor('hora_fin',$hora_fin);
			$turnoModificar -> setValor('descripcion',$descripcion);
			$turnoModificar -> setValor('asistentes',$asistentes);
			$turnoModificar -> setValor('suma_ganancias',$suma_ganancias);
			$turnoModificar -> setValor('personas_max',$personas_max);
			$turnoModificar -> modificar($_SESSION['pagina']);
			$actividad = new Actividad('',date('Y-m-d H:i:s'),$_SESSION['id_usuario'],$_SESSION['id_empresa'],'Modificar turno '.substr($descripcion,0,50));
			$actividad -> insertar($_SESSION['pagina']);
			$existe = obten_consultaUnCampo($_SESSION['pagina'],'id_turno','turnos','id_empresa',$_SESSION['id_empresa'],'id_usuario',$_SESSION['id_usuario'],'fecha_inicio',$newFecha,'hora_inicio',$horas[0],'');
			if(!empty($existe)){//modificacion correcta
				$_SESSION['alerta_usuario'] = 'success';//se almacena para mostrar la alerta al crear usuario nuevo
				$_SESSION['alerta_mensaje'] = 'La franja horaria ha sido modificada correctamente!';
			}
			else{//modificacion fallida
				$_SESSION['alerta_usuario'] = 'warning';
				$_SESSION['alerta_mensaje'] = 'La franja horaria no ha sido modificada';
			}
		}
		elseif( $operacion == 'D' ){//inhabilitar
			$turnoModificar -> setValor('estado','1');
			$turnoModificar -> modificar($_SESSION['pagina']);
			$actividad = new Actividad('',date('Y-m-d H:i:s'),$_SESSION['id_usuario'],$_SESSION['id_empresa'],'Modificar turno'.substr($turnoModificar -> getValor('descripcion'),0,50));
			$actividad -> insertar($_SESSION['pagina']);
			$existe = obten_consultaUnCampo($_SESSION['pagina'],'id_turno','turnos','id_turno',$id_turno,'estado','1','','','','','');
			
			if(!empty($existe)){//eliminacion inhabilitacion correcta
				$_SESSION['alerta_usuario'] = 'success';//se almacena para mostrar la alerta al crear turno nuevo
				$_SESSION['alerta_mensaje'] = 'La franja horaria ha sido archivada correctamente!';
			}
			else{//modificacion fallida
				$_SESSION['alerta_usuario'] = 'warning';
				$_SESSION['alerta_mensaje'] = 'La franja horaria no ha sido archivada';
			}
		}
	}
	elseif( $operacion == 'D' && $id_turno == 'sesion' ){//eliminamos turno desde la pagina de reservas
		$suma_ganancias = obten_consultaUnCampo($_SESSION['pagina'],'sum(cuenta)','reservas','id_turno',$_SESSION['id_turno'],'','','','','','','');
		$asistentes = obten_consultaUnCampo($_SESSION['pagina'],'sum(num_personas)','reservas','id_turno',$_SESSION['id_turno'],'','','','','','','');
		$turnoModificar = new Turno($_SESSION['id_turno'],'','','','','','','','','','','','','');
		$turnoModificar -> setValor('asistentes',$asistentes);
		$turnoModificar -> setValor('suma_ganancias',$suma_ganancias);
		$turnoModificar -> setValor('estado','1');
		$turnoModificar -> modificar($_SESSION['pagina']);
		
		$actividad = new Actividad('',date('Y-m-d H:i:s'),$_SESSION['id_usuario'],$_SESSION['id_empresa'],'Eliminar turno');
		$actividad -> insertar($_SESSION['pagina']);

		calcular_ganancias_asistencias($_SESSION['id_turno']);

		$existe = obten_consultaUnCampo($_SESSION['pagina'],'id_turno','turnos','id_turno',$_SESSION['id_turno'],'estado','1','','','','','');
		if(!empty($existe)){//modificacion correcta
			$_SESSION['alerta_usuario'] = 'success';//se almacena para mostrar la alerta al crear usuario nuevo
			$_SESSION['alerta_mensaje'] = 'La franja horaria ha sido archivada correctamente!';
		}
		else{//modificacion fallida
			$_SESSION['alerta_usuario'] = 'warning';
			$_SESSION['alerta_mensaje'] = 'La franja horaria no ha sido archivada';
		}
		unset($_SESSION['id_turno']);
		echo $existe;
	}
	echo 0;
}
?>