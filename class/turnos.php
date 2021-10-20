<?php
class Turno{
	//atributos
	protected $id_turno = '';
    protected $id_usuario = '';
	protected $id_empresa = '';
	protected $fecha_inicio = '';
	protected $hora_inicio = ''; 
	protected $fecha_fin = '';
	protected $hora_fin = '';
	protected $estado = '';
	protected $suma_ganancias = '';
	protected $personas_max = '';
	protected $tipo_evento = ''; 
	protected $descripcion = '';
	protected $fec_creacion = '';
	protected $asistentes = '';

	//------------------------------
    //constructores de la clase
	//------------------------------
    public function __construct($id_turno,$id_usuario,$id_empresa,$fecha_inicio,$hora_inicio,$fecha_fin,$hora_fin,$estado,$suma_ganancias,$personas_max,$tipo_evento, $descripcion,$fec_creacion,$asistentes){
		if($id_usuario == '' && $id_empresa == '' && $id_turno != ''){
			$db = new MySQL($_SESSION['pagina']);
			$consulta = $db->consulta("SELECT * FROM turnos WHERE id_turno = '$id_turno';");
			if($consulta->num_rows>0){
				$resultados = $consulta->fetch_array(MYSQLI_ASSOC);
				$this->id_turno = $resultados['id_turno'];
				$this->id_usuario = $resultados['id_usuario'];
				$this->id_empresa = $resultados['id_empresa'];
				$this->fecha_inicio = $resultados['fecha_inicio'];
				$this->hora_inicio = $resultados['hora_inicio']; 
				$this->fecha_fin = $resultados['fecha_fin'];
				$this->hora_fin = $resultados['hora_fin'];
				$this->estado = $resultados['estado'];
				$this->suma_ganancias = $resultados['suma_ganancias'];
				$this->personas_max = $resultados['personas_max'];
				$this->tipo_evento = $resultados['tipo_evento']; 
				$this->descripcion = $resultados['descripcion'];
				$this->fec_creacion = $resultados['fec_creacion'];
				$this->asistentes = $resultados['asistentes'];
			}
			$db->cerrar_conexion();
		}
		else{
			$this->id_turno = $id_turno;
			$this->id_usuario = $id_usuario;
			$this->id_empresa = $id_empresa;
			$this->fecha_inicio = $fecha_inicio;
			$this->hora_inicio = $hora_inicio; 
			$this->fecha_fin = $fecha_fin;
			$this->hora_fin = $hora_fin;
			$this->estado = $estado;
			$this->suma_ganancias = $suma_ganancias;
			$this->personas_max = $personas_max;
			$this->tipo_evento = $tipo_evento; 
			$this->descripcion = $descripcion;
			$this->fec_creacion = $fec_creacion;
			$this->asistentes = $asistentes;
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
		$db->consulta("INSERT INTO  `turnos` (`id_turno`,`id_usuario`,`id_empresa`,`fecha_inicio`,`hora_inicio`,`fecha_fin`,`hora_fin`,`estado`,`suma_ganancias`,`personas_max`,`tipo_evento`,`descripcion`,`fec_creacion`,`asistentes`) VALUES (NULL,  '$this->id_usuario', '$this->id_empresa', '$this->fecha_inicio', '$this->hora_inicio', '$this->fecha_fin', '$this->hora_fin', '$this->estado', '$this->suma_ganancias', '$this->personas_max', '$this->tipo_evento', '$this->descripcion', '$this->fec_creacion', '$this->asistentes');");
		$db->cerrar_conexion();
	}
	public function modificar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("UPDATE  `turnos` SET `id_usuario`='$this->id_usuario',`id_empresa`='$this->id_empresa',`fecha_inicio`='$this->fecha_inicio',`hora_inicio`='$this->hora_inicio',`fecha_fin`='$this->fecha_fin',`hora_fin`='$this->hora_fin',`estado`='$this->estado',`suma_ganancias`='$this->suma_ganancias',`personas_max`='$this->personas_max',`tipo_evento`='$this->tipo_evento',`descripcion`='$this->descripcion',`fec_creacion`='$this->fec_creacion',`asistentes`='$this->asistentes' WHERE `id_turno` = '$this->id_turno'; ");
		$db->cerrar_conexion();
	}
	public function borrar($pagina){
		$db = new MySQL($pagina);
		$db->consulta("DELETE FROM  `turnos` WHERE `id_turno` = '$this->id_turno'; ");
		$db->cerrar_conexion();
	}

}

?>