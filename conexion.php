<?php

class Conexion{

    private $servidor = "localhost";
    private $usuario = "root";
    private $contra = "";
    private $dbNombre = "usuarios";
    private $conexion;

    public function __construct(){
        //Se inicia intentando la conexión
        try{
            $this->conexion = new PDO("mysql:host=$this->servidor; dbname=$this->dbNombre;", $this->usuario, $this->contra);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $err){
            echo "Error al conectar: ".$err;
        }
        
    }

    public function enviar($sql){
        $this->conexion->exec($sql);
    }

    public function obtener($sql){
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->execute();
        return $sentencia->fetchAll();
    }
    


}


?>