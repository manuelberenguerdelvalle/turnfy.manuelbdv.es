<?php
class Reserva{
	//atributos
	protected $id_reserva = '';
    protected $id_turno = '';
	protected $id_usuario = '';
	protected $id_empresa = '';
	protected $descripcion_corta = ''; 
	protected $mesa = '';
	protected $num_personas = '';
	protected $cuenta = '';
	protected $descripcion_larga = '';
	protected $estado = '';
	protected $posicion = '';
	protected $fec_creacion = ''; 
	//------------------------------
    //constructores de la clase
	//------------------------------
    public function __construct($id_reserva,$id_turno,$id_usuario,$id_empresa,$descripcion_corta,$mesa,$num_personas,$cuenta,$descripcion_larga,$estado,$posicion,$fec_creacion){
		if($id_turno == '' && $id_usuario == '' && $id_empresa == '' && $id_reserva != ''){
			$db = new MySQL($_SESSION['pagina']);
			$consulta = $db->consulta("SELECT * FROM reservas WHERE id_reserva = '$id_reserva';");
			if($consulta->num_rows>0){
				$resultados = $consulta->fetch_array(MYSQLI_ASSOC);
				$this->id_reserva = $resultados['id_reserva'];
				$this->id_turno = $resultados['id_turno'];
				$this->id_usuario = $resultados['id_usuario'];
				$this->id_empresa = $resultados['id_empresa'];
				$this->descripcion_corta = $resultados['descripcion_corta']; 
				$this->mesa = $resultados['mesa'];
				$this->num_personas = $resultados['num_personas'];
				$this->cuenta = $resultados['cuenta'];
				$this->descripcion_larga = $resultados['descripcion_larga'];
				$this->estado = $resultados['estado'];
				$this->posicion = $resultados['posicion'];
				$this->fec_creacion = $resultados['fec_creacion']; 
			}
			$db->cerrar_conexion();
		}
		else{
			$this->id_reserva = $id_reserva;
			$this->id_turno = $id_turno;
			$this->id_usuario = $id_usuario;
			$this->id_empresa = $id_empresa;
			$this->descripcion_corta = $descripcion_corta; 
			$this->mesa = $mesa;
			$this->num_personas = $num_personas;
			$this->cuenta = $cuenta;
			$this->descripcion_larga = $descripcion_larga;
			$this->estado = $estado;
			$this->posicion = $posicion;
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
		$db->consulta("INSERT INTO  `reservas` (`id_reserva`,`id_turno`,`id_usuario`,`id_empresa`,`descripcion_corta`,`mesa`,`num_personas`,`cuenta`,`descripcion_larga`,`estado`,`posicion`,`fec_creacion`) VALUES (NULL,  '$this->id_turno', '$this->id_usuario', '$this->id_empresa', '$this->descripcion_corta', '$this->mesa', '$this->num_personas', '$this->cuenta', '$this->descripcion_larga', '$this->estado', '$this->posicion', '$this->fec_creacion');");
		$db->cerrar_conexion();
	}
	public function modificar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("UPDATE  `reservas` SET `id_turno`='$this->id_turno',`id_usuario`='$this->id_usuario',`id_empresa`='$this->id_empresa',`descripcion_corta`='$this->descripcion_corta',`mesa`='$this->mesa',`cuenta`='$this->cuenta',`descripcion_larga`='$this->descripcion_larga',`estado`='$this->estado',`posicion`='$this->posicion',`fec_creacion`='$this->fec_creacion' WHERE `id_reserva` = '$this->id_reserva'; ");
		$db->cerrar_conexion();
	}
	public function borrar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("DELETE FROM  `reservas` WHERE `id_reserva` = '$this->id_reserva'; ");
		$db->cerrar_conexion();
	}

}

?>