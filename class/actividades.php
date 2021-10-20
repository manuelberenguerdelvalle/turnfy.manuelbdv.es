<?php
class Actividad{
	//atributos
	protected $id_actividad = '';
    protected $fechahora = '';
	protected $id_usuario = '';
	protected $id_empresa = '';
	protected $descripcion = ''; 

	//------------------------------
    //constructores de la clase
	//------------------------------
    public function __construct($id_actividad,$fechahora,$id_usuario,$id_empresa,$descripcion){
		if($id_usuario == '' && $id_empresa == '' && $id_actividad != ''){
			$db = new MySQL($_SESSION['pagina']);
			$consulta = $db->consulta("SELECT * FROM actividades WHERE id_actividad = '$id_actividad';");
			if($consulta->num_rows>0){
				$resultados = $consulta->fetch_array(MYSQLI_ASSOC);
				$this->id_actividad = $resultados['id_actividad'];
				$this->fechahora = $resultados['fechahora'];
				$this->id_usuario = $resultados['id_usuario'];
				$this->id_empresa = $resultados['id_empresa'];
				$this->descripcion = $resultados['descripcion']; 
			}
			$db->cerrar_conexion();
		}
		else{
			$this->id_actividad = $id_actividad;
			$this->fechahora = $fechahora;
			$this->id_usuario = $id_usuario;
			$this->id_empresa = $id_empresa;
			$this->descripcion = $descripcion; 
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
	public function insertar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("INSERT INTO  `actividades` (`id_actividad`,`fechahora`,`id_usuario`,`id_empresa`,`descripcion`) VALUES (NULL,  '$this->fechahora', '$this->id_usuario', '$this->id_empresa', '$this->descripcion');");
		$db->cerrar_conexion();
	}
	public function modificar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("UPDATE  `actividades` SET `fechahora`='$this->fechahora',`id_usuario`='$this->id_usuario',`id_empresa`='$this->id_empresa',`descripcion`='$this->descripcion' WHERE `id_actividad` = '$this->id_actividad'; ");
		$db->cerrar_conexion();
	}
	public function borrar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("DELETE FROM  `actividades` WHERE `id_actividad` = '$this->id_actividad'; ");
		$db->cerrar_conexion();
	}

}

?>