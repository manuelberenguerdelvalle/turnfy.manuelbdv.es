<?php
class Usuario{
	//atributos
	protected $id_usuario = '';
    protected $id_empresa = '';
	protected $usuario = '';
	protected $password = '';
	protected $gestion_turnos = ''; 
	protected $estado = '';
	protected $color = '';
	protected $fec_creacion = '';
	//------------------------------
    //constructores de la clase
	//------------------------------
    public function __construct($id_usuario,$id_empresa,$usuario,$password,$gestion_turnos,$estado,$color,$fec_creacion){
		if($id_empresa == '' && $id_usuario != ''){
			$db = new MySQL($_SESSION['pagina']);
			$consulta = $db->consulta("SELECT * FROM usuarios WHERE id_usuario = '$id_usuario';");
			if($consulta->num_rows>0){
				$resultados = $consulta->fetch_array(MYSQLI_ASSOC);
				$this->id_usuario = $resultados['id_usuario'];
				$this->id_empresa = $resultados['id_empresa'];
				$this->usuario = $resultados['usuario'];
				$this->password = $resultados['password'];
				$this->gestion_turnos = $resultados['gestion_turnos']; 
				$this->estado = $resultados['estado'];
				$this->color = $resultados['color'];
				$this->fec_creacion = $resultados['fec_creacion'];
			}
			$db->cerrar_conexion();
		}
		else{
			$this->id_usuario = $id_usuario;
			$this->id_empresa = $id_empresa;
			$this->usuario = $usuario;
			$this->password = $password;
			$this->gestion_turnos = $gestion_turnos; 
			$this->estado = $estado;
			$this->color = $color;
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
		$db = new MySQL($pagina);//usuarios PADEL
		$db->consulta("INSERT INTO  `usuarios` (`id_usuario`,`id_empresa`,`usuario`,`password`,`gestion_turnos`,`estado`,`color`,`fec_creacion`) VALUES (NULL,  '$this->id_empresa', '$this->usuario', '$this->password', '$this->gestion_turnos', '$this->estado', '$this->color', '$this->fec_creacion');");
		$db->cerrar_conexion();
	}
	public function modificar($pagina){
		$db = new MySQL($pagina);//usuarios PADEL
		$db->consulta("UPDATE  `usuarios` SET `id_empresa`='$this->id_empresa',`usuario`='$this->usuario',`password`='$this->password',`gestion_turnos`='$this->gestion_turnos',`estado`='$this->estado',`color`='$this->color',`fec_creacion`='$this->fec_creacion' WHERE `id_usuario` = '$this->id_usuario'; ");
		$db->cerrar_conexion();
	}
	public function borrar($pagina){
		$db = new MySQL($pagina);//usuarios PADEL
		$db->consulta("DELETE FROM  `usuarios` WHERE `id_usuario` = '$this->id_usuario'; ");
		$db->cerrar_conexion();
	}

}

?>