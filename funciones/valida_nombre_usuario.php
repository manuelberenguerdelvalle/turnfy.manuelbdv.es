<?php
include_once ("../class/mysql.php");
include_once ("generales.php");
session_start();
if ( $_SESSION['pagina'] != 'index'){
	header ("Location: ".url_completa());
}
else {
	$usuario = limpiaTexto(htmlspecialchars($_POST["usuario"]));
	$id_usuario = limpiaTexto(htmlspecialchars($_POST["id_usuario"]));
	$cuenta = -1;
	if(isset($_POST["cuenta"])){
		$cuenta = limpiaTexto(htmlspecialchars($_POST["cuenta"]));
	}
	$existe = obten_consultaUnCampo($_SESSION['pagina'],'id_usuario','usuarios','usuario',$usuario,'estado','0','','','','','');
	if($existe != $cuenta){
		if(empty($existe)){
			$existe = obten_consultaUnCampo($_SESSION['pagina'],'id_empresa','empresas','usuario',$usuario,'estado','0','','','','','');
			if(empty($existe)){
				$existe = 0;
			}
		}
	
		if($id_usuario == $existe){//si es el propio usuario
			$existe = 0;
		}
	}
	echo $existe;
}
?>