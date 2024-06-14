<?php

class Empresa {
    private $id;
    private $nombre;
    private $direccion;
    private $mensajeoperacion;


    public function __construct() {
        $this->id = "";
        $this->nombre = "";
        $this->direccion = "";
    }
    public function cargar($id, $nombre, $direccion){
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
    }
    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
    public function setId($id) {
        $this->id = $id;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDireccion($direccion) {
        $this->direccion = $direccion;
    }
    public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
    public function Buscar($id){
		$base=new BaseDatos();
		$consultaviaje="Select * from empresa where idempresa=".$id;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaviaje)){
				if($row2=$base->Registro()){				
				    $this->getId($id);
					$this->getNombre($row2['enombre']);
					$this->getDireccion($row2['edireccion']);
					
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
    

	public function listar($condicion=""){
	    $arregloviaje = null;
		$base=new BaseDatos();
		$consultaviajes="Select * from empresa ";
		if ($condicion!=""){
		    $consultaviajes=$consultaviajes.' where '.$condicion;
		}
		$consultaviajes.=" order by idempresa ";
		//echo $consultaviajes;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaviajes)){				
				$arregloEmpresa= array();
				while($row2=$base->Registro()){
					
					$IdEmpresa=$row2['idempresa'];
					$Nombre=$row2['enombre'];
					$Direccion=$row2['edireccion'];

					$empresa=new Empresa();
					$empresa->cargar($IdEmpresa,$Nombre,$Direccion);
					array_push($arregloEmpresa,$empresa);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloviaje;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO empresa(idempresa, enombre, edireccion) 
				VALUES (".$this->getId().",'".$this->getNombre()."','".$this->getDireccion()."')";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE empresa SET enombre='".$this->getNombre()."',edireccion='".$this->getDireccion()."' WHERE idempresa=". $this->getId();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM empresa WHERE idempresa=".$this->getId();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}
    
    public function __toString() {
        return "Empresa ID: " . $this->getId() . "\n" .
               "Nombre: " . $this->getNombre() . "\n" .
               "Dirección: " . $this->getDireccion() . "\n";
    }
}