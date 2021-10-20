<?php
include_once ("../class/mysql.php");
include_once ("../class/conexiones.php");
include_once ("generales.php");
session_start();
if ( comprobar_pagina($_SESSION['pagina']) ){
	$conexion = new Conexion($_SESSION['id_conexion'],'','','','','','');
	$conexion -> setValor('estado','1');
	$conexion -> setValor('fin',obten_fechahora());
	$conexion -> modificar($_SESSION['pagina']);
}
session_destroy();
header ("Location: ".url_completa());
?>