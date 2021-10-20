<?php
class Empresa{
	//atributos
	protected $id_empresa = '';
    protected $nombre = '';
	protected $tipo_evento = '';
	protected $usuario = '';
	protected $telefono = ''; 
	protected $direccion = '';
	protected $pais = '';
	protected $provincia = '';
	protected $ciudad = '';
	protected $password = '';
	protected $estado = ''; 
	protected $fec_creacion = '';

	//------------------------------
    //constructores de la clase
	//------------------------------
    public function __construct($id_empresa,$nombre,$tipo_evento,$usuario,$telefono,$direccion,$pais,$provincia,$ciudad,$password,$estado, $fec_creacion){
		if($tipo_evento == '' && $usuario == '' && $id_empresa != ''){
			$db = new MySQL($_SESSION['pagina']);
			$consulta = $db->consulta("SELECT * FROM empresas WHERE id_empresa = '$id_empresa';");
			if($consulta->num_rows>0){
				$resultados = $consulta->fetch_array(MYSQLI_ASSOC);
				$this->id_empresa = $resultados['id_empresa'];
				$this->nombre = $resultados['nombre'];
				$this->tipo_evento = $resultados['tipo_evento'];
				$this->usuario = $resultados['usuario'];
				$this->telefono = $resultados['telefono']; 
				$this->direccion = $resultados['direccion'];
				$this->pais = $resultados['pais'];
				$this->provincia = $resultados['provincia'];
				$this->ciudad = $resultados['ciudad'];
				$this->password = $resultados['password'];
				$this->estado = $resultados['estado']; 
				$this->fec_creacion = $resultados['fec_creacion'];
			}
			$db->cerrar_conexion();
		}
		else{
			$this->id_empresa = $id_empresa;
			$this->nombre = $nombre;
			$this->tipo_evento = $tipo_evento;
			$this->usuario = $usuario;
			$this->telefono = $telefono; 
			$this->direccion = $direccion;
			$this->pais = $pais;
			$this->provincia = $provincia;
			$this->ciudad = $ciudad;
			$this->password = $password;
			$this->estado = $estado; 
			$this->fec_creacion = $fec_creacion;

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
		$db->consulta("INSERT INTO  `empresas` (`id_empresa`,`nombre`,`tipo_evento`,`usuario`,`telefono`,`direccion`,`pais`,`provincia`,`ciudad`,`password`,`estado`,`fec_creacion`) VALUES (NULL,  '$this->nombre', '$this->tipo_evento', '$this->usuario', '$this->telefono', '$this->direccion', '$this->pais', '$this->provincia', '$this->ciudad', '$this->password', '$this->estado', '$this->fec_creacion');");
		$db->cerrar_conexion();
	}
	public function modificar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("UPDATE  `empresas` SET `nombre`='$this->nombre',`tipo_evento`='$this->tipo_evento',`usuario`='$this->usuario',`telefono`='$this->telefono',`direccion`='$this->direccion',`pais`='$this->pais',`provincia`='$this->provincia',`ciudad`='$this->ciudad',`password`='$this->password',`estado`='$this->estado',`fec_creacion`='$this->fec_creacion' WHERE `id_empresa` = '$this->id_empresa'; ");
		$db->cerrar_conexion();
	}
	public function borrar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("DELETE FROM  `empresas` WHERE `id_empresa` = '$this->id_empresa'; ");
		$db->cerrar_conexion();
	}

}

?>