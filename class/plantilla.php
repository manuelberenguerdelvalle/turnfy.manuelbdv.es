<?php
class Clase{
	//atributos
	protected $campo1 = '';
    protected $campo2 = '';
	protected $campo3 = '';
	protected $campo4 = '';
	protected $campo5 = ''; 
	protected $campo6 = '';
	protected $campo7 = '';
	protected $campo8 = '';
	protected $campo9 = '';
	protected $campo10 = '';
	protected $campo11 = ''; 
	protected $campo12 = '';
	protected $campo13 = '';
	protected $campo14 = '';
	protected $campo15 = '';
	protected $campo16 = '';
	protected $campo17 = '';
	//------------------------------
    //constructores de la clase
	//------------------------------
    public function __construct($campo1,$campo2,$campo3,$campo4,$campo5,$campo6,$campo7,$campo8,$campo9,$campo10,$campo11, $campo12,$campo13,$campo14,$campo15,$campo16,$campo17){
		if($campo2 == '' && $campo1 != ''){
			$db = new MySQL('session');//LIGA PADEL
			$consulta = $db->consulta("SELECT * FROM liga WHERE campo1 = '$campo1';");
			if($consulta->num_rows>0){
				$resultados = $consulta->fetch_array(MYSQLI_ASSOC);
				$this->campo1 = $resultados['campo1'];
				$this->campo2 = $resultados['campo2'];
				$this->campo3 = $resultados['campo3'];
				$this->campo4 = $resultados['campo4'];
				$this->campo5 = $resultados['campo5']; 
				$this->campo6 = $resultados['campo6'];
				$this->campo7 = $resultados['campo7'];
				$this->campo8 = $resultados['campo8'];
				$this->campo9 = $resultados['campo9'];
				$this->campo10 = $resultados['campo10'];
				$this->campo11 = $resultados['campo11']; 
				$this->campo12 = $resultados['campo12'];
				$this->campo13 = $resultados['campo13'];
				$this->campo14 = $resultados['campo14'];
				$this->campo15 = $resultados['campo15'];
				$this->campo16 = $resultados['campo16'];
				$this->campo17 = $resultados['campo17'];
			}
			$db->cerrar_conexion();
		}
		else{
			$this->campo1 = $campo1;
			$this->campo2 = $campo2;
			$this->campo3 = $campo3;
			$this->campo4 = $campo4;
			$this->campo5 = $campo5; 
			$this->campo6 = $campo6;
			$this->campo7 = $campo7;
			$this->campo8 = $campo8;
			$this->campo9 = $campo9;
			$this->campo10 = $campo10;
			$this->campo11 = $campo11; 
			$this->campo12 = $campo12;
			$this->campo13 = $campo13;
			$this->campo14 = $campo14;
			$this->campo15 = $campo15;
			$this->campo16 = $campo16;
			$this->campo17 = $campo17;
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
	public function insertar(){
		$db = new MySQL('session');//LIGA PADEL
		$db->consulta("INSERT INTO  `liga` (`campo1`,`campo2`,`campo3`,`campo4`,`campo5`,`campo6`,`campo7`,`campo8`,`campo9`,`campo10`,`campo11`,`campo12`,`campo13`,`campo14`,`campo15`,`campo16`,`campo17`) VALUES (NULL,  '$this->campo2', '$this->campo3', '$this->campo4', '$this->campo5', '$this->campo6', '$this->campo7', '$this->campo8', '$this->campo9', '$this->campo10', '$this->campo11', '$this->campo12', '$this->campo13', '$this->campo14', '$this->campo15', '$this->campo16', '$this->campo17');");
		$db->cerrar_conexion();
	}
	public function modificar(){
		$db = new MySQL('session');//LIGA PADEL
		$db->consulta("UPDATE  `liga` SET `campo2`='$this->campo2',`campo4`='$this->campo4',`campo5`='$this->campo5',`campo6`='$this->campo6',`campo8`='$this->campo8',`campo9`='$this->campo9',`campo10`='$this->campo10',`campo11`='$this->campo11',`campo12`='$this->campo12',`campo13`='$this->campo13',`campo15`='$this->campo15',`campo16`='$this->campo16' ,`campo17`='$this->campo17' WHERE `campo1` = '$this->campo1'; ");
		$db->cerrar_conexion();
	}
	public function borrar(){
		$db = new MySQL('session');//LIGA PADEL
		$db->consulta("DELETE FROM  `liga` WHERE `campo1` = '$this->campo1'; ");
		$db->cerrar_conexion();
	}
	/*public function __destruct($campo2,$apellidos,$email,$telefono,$campo11word,$dni,$cuenta_paypal,$direccion,$cp,$campo6,$campo5,$campo4,$fec_registro,$campo14){
	}*/
}

?>