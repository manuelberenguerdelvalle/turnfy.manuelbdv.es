<?php
include_once ("../class/mysql.php");
include_once ("generales.php");
session_start();
if ( $_SESSION['pagina'] != 'index'){
	header ("Location: ".url_completa());
}
else {
	$usuario = limpiaTexto(htmlspecialchars($_POST["usuario"]));
	$password = limpiaTexto(htmlspecialchars($_POST["password"]));
	$_SESSION['id_usuario'] = 0;
	$_SESSION['id_empresa'] = 0;
	$_SESSION['login'] = '';
	$resultado = obten_consultaUnCampo($_SESSION['pagina'],'id_usuario','usuarios','usuario',$usuario,'password',$password,'estado','0','','','');
	if(empty($resultado)){//entro si no es usuario
		$resultado = obten_consultaUnCampo($_SESSION['pagina'],'id_empresa','empresas','usuario',$usuario,'password',$password,'estado','0','','','');
		if($resultado > 0){//entro si es empresa
			$_SESSION['id_usuario'] = 0;
			$_SESSION['id_empresa'] = $resultado;
			$_SESSION['login'] = 'id_empresa';
			
		}
		else{//si entro no es ni usuario ni empresa
			$_SESSION['intentos']++;
			$_SESSION['id_usuario'] = 0;
			$_SESSION['id_empresa'] = 0;
			$_SESSION['login'] = '';
			$resultado = 0;
		}
	}
	elseif($resultado > 0){//entro si es usuario
		$_SESSION['id_usuario'] = $resultado;
		$_SESSION['id_empresa'] = obten_consultaUnCampo($_SESSION['pagina'],'id_empresa','usuarios','usuario',$usuario,'password',$password,'estado','0','','','');
		$_SESSION['login'] = 'id_usuario';
	}
	echo $resultado;
}
?>