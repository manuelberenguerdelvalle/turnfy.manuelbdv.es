<?php
include_once ("../class/mysql.php");
include_once ("../class/reservas.php");
include_once ("../class/actividades.php");
include_once ("generales.php");
session_start();
if ( comprobar_pagina($_SESSION['pagina']) ){
	header ("Location: ".url_completa());
}
else {
	$res = 0;
	unset($_SESSION['alerta_usuario'],$_SESSION['alerta_mensaje']);
	if(isset($_POST["operacion"]) && $_POST["operacion"] == 'I'){//nueva reserva
		$res = 0;
		$descripcion_corta = ucfirst(limpiaTexto(htmlspecialchars($_POST["descripcion_corta"])));
		$num_personas = limpiaTexto(htmlspecialchars($_POST["num_personas"]));
		$descripcion_larga = ucfirst(limpiaTexto(htmlspecialchars($_POST["descripcion_larga"])));
		$mesa = limpiaTexto(htmlspecialchars($_POST["mesa"]));
		$cuenta = limpiaTexto(htmlspecialchars($_POST["cuenta"]));

		$posicion = obten_consultaUnCampo($_SESSION['pagina'],'count(id_reserva)','reservas','id_turno',$_SESSION['id_turno'],'','','date(fec_creacion)',date('Y-m-d'),'','','');
		$reserva = new Reserva('',$_SESSION['id_turno'], $_SESSION['id_usuario'], $_SESSION['id_empresa'], $descripcion_corta, $mesa, $num_personas, $cuenta, $descripcion_larga, 0, $posicion+1, obten_fechahora()); 
		$reserva -> insertar($_SESSION['pagina']);

		$res = obten_consultaUnCampo($_SESSION['pagina'],'id_reserva','reservas','id_turno',$_SESSION['id_turno'],'posicion',$posicion+1,'','','','','');

		$actividad = new Actividad('',date('Y-m-d H:i:s'),$_SESSION['id_usuario'],$_SESSION['id_empresa'],'Insertar reserva');
		$actividad -> insertar($_SESSION['pagina']);

		calcular_ganancias_asistencias($_SESSION['id_turno']);
	}
	elseif(isset($_POST["operacion"]) && $_POST["operacion"] == 'D'){//borrar reserva
		$res = 0;
		$id_reserva = limpiaTexto(htmlspecialchars($_POST["id_reserva"]));
		$reserva = new Reserva($id_reserva,'', '', '', '', '', '', '', '', '', '', '');
		$reserva -> setValor('estado','1');
		$reserva -> setValor('id_usuario',$_SESSION['id_usuario']);
		$reserva -> modificar($_SESSION['pagina']);

		$actividad = new Actividad('',date('Y-m-d H:i:s'),$_SESSION['id_usuario'],$_SESSION['id_empresa'],'Eliminar reserva');
		$actividad -> insertar($_SESSION['pagina']);

		calcular_ganancias_asistencias($_SESSION['id_turno']);

		//$_SESSION['alerta_usuario'] = 'success';//se almacena para mostrar la alerta al crear usuario nuevo
		//$_SESSION['alerta_mensaje'] = 'Ha quedado una mesa libre de '.$reserva->getValor('num_personas').' personas';
	}
	elseif(isset($_POST["operacion"]) && $_POST["operacion"] == 'U'){//modificar reserva
		$res = 0;
		$id_reserva = ucfirst(limpiaTexto(htmlspecialchars($_POST["id_reserva"])));
		$descripcion_corta = ucfirst(limpiaTexto(htmlspecialchars($_POST["descripcion_corta"])));
		$num_personas = limpiaTexto(htmlspecialchars($_POST["num_personas"]));
		$descripcion_larga = ucfirst(limpiaTexto(htmlspecialchars($_POST["descripcion_larga"])));
		$mesa = limpiaTexto(htmlspecialchars($_POST["mesa"]));
		$cuenta = limpiaTexto(htmlspecialchars($_POST["cuenta"]));

		$reserva = new Reserva($id_reserva,'', '', '', '', '', '', '', '', '', '', '');
		$reserva -> setValor('descripcion_corta',$descripcion_corta);
		$reserva -> setValor('num_personas',$num_personas);
		$reserva -> setValor('descripcion_larga',$descripcion_larga);
		$reserva -> setValor('mesa',$mesa);
		$reserva -> setValor('cuenta',$cuenta);
		$reserva -> setValor('id_usuario',$_SESSION['id_usuario']);
		$reserva -> modificar($_SESSION['pagina']);

		$actividad = new Actividad('',date('Y-m-d H:i:s'),$_SESSION['id_usuario'],$_SESSION['id_empresa'],'Modificar reserva');
		$actividad -> insertar($_SESSION['pagina']);

		calcular_ganancias_asistencias($_SESSION['id_turno']);
	}
	elseif(isset($_POST["operacion"]) && $_POST["operacion"] == 'CE'){//cambiar estado reserva
		$res = 0;
		$id_reserva = limpiaTexto(htmlspecialchars($_POST["id_reserva"]));
		$estado = limpiaTexto(htmlspecialchars($_POST["estado"]));
		$reserva = new Reserva($id_reserva,'', '', '', '', '', '', '', '', '', '', '');
		if($estado == 1){//restaurar eliminado
			$newEstado = 0;
		}
		elseif($estado == 0){
			$newEstado = 2;
			$reserva -> setValor('fec_creacion',obten_fechahora());
		}
		elseif($estado == 2){
			$newEstado = 0;
		}

		$reserva -> setValor('estado',$newEstado);
		$reserva -> setValor('id_usuario',$_SESSION['id_usuario']);
		$reserva -> modificar($_SESSION['pagina']);
		
		$actividad = new Actividad('',date('Y-m-d H:i:s'),$_SESSION['id_usuario'],$_SESSION['id_empresa'],'Cambiar estado reserva');
		$actividad -> insertar($_SESSION['pagina']);

		calcular_ganancias_asistencias($_SESSION['id_turno']);
	}
	
	echo $res;
}
?>