<?php
include_once ("../class/mysql.php");
include_once ("../class/empresas.php");
include_once ("generales.php");
session_start();
if ( comprobar_pagina($_SESSION['pagina']) ){
	header ("Location: ".url_completa());
}
else {
	unset($_SESSION['alerta_usuario'],$_SESSION['alerta_mensaje']);
	if(isset($_POST["operacion"]) && $_POST["operacion"] == 'U'){//modificacion de cuenta de empresa
		$res = 0;
		$nombre = limpiaTexto(htmlspecialchars($_POST["nombre"]));
		$usuario = limpiaTexto(htmlspecialchars($_POST["usuario"]));
		$password = limpiaTexto(htmlspecialchars($_POST["password"]));
		$tipo_evento = limpiaTexto(htmlspecialchars($_POST["tipo_evento"]));
		$telefono = limpiaTexto(htmlspecialchars($_POST["telefono"]));
		$direccion = limpiaTexto(htmlspecialchars($_POST["direccion"]));
		$empresa = unserialize($_SESSION['obj_empresa']);
		$empresa -> setValor('nombre',$nombre);
		$empresa -> setValor('usuario',$usuario);
		$empresa -> setValor('password',$password);
		$empresa -> setValor('tipo_evento',$tipo_evento);
		$empresa -> setValor('telefono',$telefono);
		$empresa -> setValor('direccion',$direccion);
		$empresa -> modificar($_SESSION['pagina']);
		$_SESSION['obj_empresa'] = serialize($empresa);
		$_SESSION['alerta_usuario'] = 'success';
		$_SESSION['alerta_mensaje'] = 'Modificación realizada correctamente!';
		$res = $empresa -> getValor('id_empresa');
	}
	else{//registro de empresa
		$nombre = limpiaTexto(htmlspecialchars($_POST["nombre"]));
		$usuario = limpiaTexto(htmlspecialchars($_POST["usuario2"]));
		$tipo_evento = limpiaTexto(htmlspecialchars($_POST["tipo_evento"]));
		$password = limpiaTexto(htmlspecialchars($_POST["password2"]));
		$password2 = limpiaTexto(htmlspecialchars($_POST["password3"]));

		$res = 0;
		if( $password == $password2 && !empty($nombre) && !empty($usuario) ){//nueva empresa
			$newEmpresa = new Empresa('',$nombre,$tipo_evento,$usuario,'','','','','',$password,0,obten_fechahora());
			$newEmpresa -> insertar($_SESSION['pagina']);
			$existe = obten_consultaUnCampo($_SESSION['pagina'],"id_empresa","empresas","usuario",$usuario,"password",$password,'estado','0','','','');
			if(!empty($existe)){//insercion correcta
				$_SESSION['id_usuario'] = 0;
				$_SESSION['id_empresa'] = $existe;
				$_SESSION['login'] = 'id_empresa';
				$res = $existe;
			}
		}
	}
	echo $res;
}
?>