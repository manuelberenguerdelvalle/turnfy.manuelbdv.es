<?php
include_once ("../class/mysql.php");
include_once ("../class/usuarios.php");
include_once ("../class/actividades.php");
include_once ("../class/actividades.php");
include_once ("generales.php");
session_start();
if ( comprobar_pagina($_SESSION['pagina']) ){
	header ("Location: ".url_completa());
}
else {
	$id_usuario = limpiaTexto(htmlspecialchars($_POST["id_usuario"]));
	$operacion = limpiaTexto(htmlspecialchars($_POST["operacion"]));
	if($operacion == 'I' || $operacion == 'U'){
		$usuario = limpiaTexto(htmlspecialchars($_POST["usuario"]));
		$password = limpiaTexto(htmlspecialchars($_POST["password"]));
		$gestion_turnos = limpiaTexto(htmlspecialchars($_POST["gestionar_turnos"]));
	}

	unset($_SESSION['alerta_usuario'],$_SESSION['alerta_mensaje']);

	if( $operacion == 'I' && $id_usuario == 0 ){//nuevo usuario
		$repetido = true;
		while($repetido){
			$color = generar_color();
			$existe = obten_consultaUnCampo($_SESSION['pagina'],"count(id_usuario)","usuarios","id_empresa",$_SESSION["id_empresa"],'color',$color,'','','','','');
			if($existe == 0){//no está repetido
				$repetido = false;
				break;
			}
		}
		$newUsuario = new Usuario('',$_SESSION["id_empresa"],$usuario,$password,$gestion_turnos,0,$color,obten_fechahora());
		$newUsuario -> insertar($_SESSION['pagina']);
		$actividad = new Actividad('',date('Y-m-d H:i:s'),$_SESSION['id_usuario'],$_SESSION['id_empresa'],'Insertar usuario');
		$actividad -> insertar($_SESSION['pagina']);
		$existe = obten_consultaUnCampo($_SESSION['pagina'],"id_usuario","usuarios","usuario",$usuario,"password",$password,'estado','0','','','');
		if(!empty($existe)){//insercion correcta
			$_SESSION['alerta_usuario'] = 'success';//se almacena para mostrar la alerta al crear usuario nuevo
			$_SESSION['alerta_mensaje'] = 'El usuario ha sido creado correctamente!';
		}
		else{//insercion fallida
			$_SESSION['alerta_usuario'] = 'warning';
			$_SESSION['alerta_mensaje'] = 'El usuario no ha sido creado';
		}
	}
	elseif( ($operacion == 'U' || $operacion == 'D') && $id_usuario > 0 ){//modificacion o delete(modificacion estado a 1)
		$usuarioModificar = new Usuario($id_usuario,'','','','','','','');
		if($operacion == 'U' && !empty($usuario)){//modificar
			$usuarioModificar -> setValor('usuario',$usuario);
			$usuarioModificar -> setValor('password',$password);
			$usuarioModificar -> setValor('gestion_turnos',$gestion_turnos);
			$usuarioModificar -> modificar($_SESSION['pagina']);
			$actividad = new Actividad('',date('Y-m-d H:i:s'),$_SESSION['id_usuario'],$_SESSION['id_empresa'],'Modificar usuario '.$usuarioModificar -> getValor('usuario'));
			$actividad -> insertar($_SESSION['pagina']);
			$existe = obten_consultaUnCampo($_SESSION['pagina'],'id_usuario','usuarios','usuario',$usuario,'password',$password,'estado','0','','','');
			if(!empty($existe)){//modificacion correcta
				$_SESSION['alerta_usuario'] = 'success';//se almacena para mostrar la alerta al crear usuario nuevo
				$_SESSION['alerta_mensaje'] = 'El usuario ha sido modificado correctamente!';
			}
			else{//modificacion fallida
				$_SESSION['alerta_usuario'] = 'warning';
				$_SESSION['alerta_mensaje'] = 'El usuario no ha sido modificado';
			}
		}
		elseif( $operacion == 'D' && empty($usuario) ){//borrar
			$usuarioModificar -> borrar($_SESSION['pagina']);
			$actividad = new Actividad('',date('Y-m-d H:i:s'),$_SESSION['id_usuario'],$_SESSION['id_empresa'],'Deshabilitar usuario '.$usuarioModificar -> getValor('usuario'));
			$actividad -> insertar($_SESSION['pagina']);
			$existe = obten_consultaUnCampo($_SESSION['pagina'],'id_usuario','usuarios','id_usuario',$id_usuario,'estado','0','','','','','');
			if(empty($existe)){//eliminacion inhabilitacion correcta
				$_SESSION['alerta_usuario'] = 'success';//se almacena para mostrar la alerta al crear usuario nuevo
				$_SESSION['alerta_mensaje'] = 'El usuario ha sido eliminado correctamente!';
			}
			else{//modificacion fallida
				$_SESSION['alerta_usuario'] = 'warning';
				$_SESSION['alerta_mensaje'] = 'El usuario no ha sido eliminado';
			}
		}
	}

}
?>