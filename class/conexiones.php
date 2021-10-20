<?php
class Conexion{
	//atributos
	protected $id_conexion = '';
	protected $id_usuario = '';
	protected $id_empresa = '';
	protected $inicio = '';
	protected $fin = '';
	protected $ip = ''; 
	protected $estado = '';
	//------------------------------
    //constructores de la clase
	//------------------------------
    public function __construct($id_conexion,$id_usuario,$id_empresa,$inicio,$fin,$ip,$estado){
		if($id_usuario == '' && $id_empresa == '' && $id_conexion != ''){
			$db = new MySQL($_SESSION['pagina']);
			$consulta = $db->consulta("SELECT * FROM conexiones WHERE id_conexion = '$id_conexion';");
			if($consulta->num_rows>0){
				$resultados = $consulta->fetch_array(MYSQLI_ASSOC);
				$this->id_conexion = $resultados['id_conexion'];
				$this->id_usuario = $resultados['id_usuario'];
				$this->id_empresa = $resultados['id_empresa'];
				$this->inicio = $resultados['inicio'];
				$this->fin = $resultados['fin'];
				$this->ip = $resultados['ip']; 
				$this->estado = $resultados['estado'];
			}
			$db->cerrar_conexion();
		}
		else{
			$this->id_conexion = $id_conexion;
			$this->id_usuario = $id_usuario;
			$this->id_empresa = $id_empresa;
			$this->inicio = $inicio;
			$this->fin = $fin;
			$this->ip = $ip; 
			$this->estado = $estado;
		}  
		
	}
	//----------------------------------------
    // Metodos de la clase
	//-----------------------------------------
    public function getValor($atributo){//retornar algún valor
    	return $this->$atributo;
    }
	public function setValor($atributo,$newValor){//cambiar algún valor
    	$this->$atributo = $newValor;
	}
	public function finishOld($pagina){//finalizar conexiones antiguas para insertar nueva
    	$db = new MySQL($pagina);
		$db->consulta("UPDATE  `conexiones` SET `fin`= current_timestamp(),`estado`= 1 WHERE `id_usuario` = '$this->id_usuario' AND `id_empresa` = '$this->id_empresa' AND `estado` = 0; ");
		$db->cerrar_conexion();
    }
	public function insertar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("INSERT INTO  `conexiones` (`id_conexion`,`id_usuario`,`id_empresa`,`inicio`,`fin`,`ip`,`estado`) VALUES (NULL,  '$this->id_usuario', '$this->id_empresa','$this->inicio', '$this->fin', '$this->ip', '$this->estado');");
		$db->cerrar_conexion();
	}
	public function modificar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("UPDATE  `conexiones` SET `id_usuario`='$this->id_usuario',`id_empresa`='$this->id_empresa',`inicio`='$this->inicio',`fin`='$this->fin',`ip`='$this->ip',`estado`='$this->estado' WHERE `id_conexion` = '$this->id_conexion'; ");
		$db->cerrar_conexion();
	}
	public function borrar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("DELETE FROM  `conexiones` WHERE `id_conexion` = '$this->id_conexion'; ");
		$db->cerrar_conexion();
	}
}

?>