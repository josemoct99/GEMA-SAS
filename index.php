<?php

session_start();
$archivoNombre = "";
$archivoTemp = "";

$error = false;
$textoError = "";

if($_POST){
    $archivoNombre = (isset($_FILES['archivo']['name']))?$_FILES['archivo']['name']:"";
    $archivoTemp = (isset($_FILES['archivo']['name']))?$_FILES['archivo']['tmp_name']:"";
    move_uploaded_file($archivoTemp, $archivoNombre);

    if(comprobarArchivo($archivoNombre)){
        $_SESSION['archivoNombre'] = $archivoNombre;
        header("location:tablas.php");
    }else{
        $error = true;
    }
    

}

function comprobarArchivo($archivo){
    try{
        if (!file_exists($archivo)) {
            throw new Exception('Archivo no encontrado');
        }
        $archivoAbierto = fopen($archivo, "r");
        
        while(!feof($archivoAbierto)) {
            // Para cada linea
            $linea = fgets($archivoAbierto);
            //Comprobar el número de la persona
            $arreglo = explode(',', $linea);
            if(!((int)$arreglo[3]>=1 && (int)$arreglo[3]<=3)){
                return false;
            }
        }
    }catch(Exception $err){
        echo "Error al abrir archivo";
        return false;
    }
    return true;
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="main.css">

    <title>Carga de Datos GEMAS SAS</title>
</head>
<body>

    <form action="index.php" method="post" enctype="multipart/form-data">
        <label id="titulo">GEMA SAS</label>    
        <label >Formulario de carga de información</label>
        <br><br>
        <input type="file" name="archivo"/>
        <br><br>
        <?php if($_POST && $error){     ?>
        <label id="error" >El archivo no tiene el formato correcto</label>
        <?php }     ?>
        <br>
        <input type="submit" name="enviar" value="Enviar formulario"/>
    </form>

    
</body>
</html>