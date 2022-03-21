<?php 
include("conexion.php");

session_start();
$GLOBALS['objConexion'] = new Conexion();

$archivoNombre = "";

if(isset($_SESSION['archivoNombre'])){
    $archivoNombre = $_SESSION['archivoNombre'];
}

$archivoAbierto = fopen($archivoNombre, "r");

while(!feof($archivoAbierto)) {
    // Para cada linea
    $linea = fgets($archivoAbierto);
    //Comprobar el número de la persona
    $usuario = explode(',', $linea);
    switch((int)$usuario[3]){
        case 1:
            addUsuarioActivo($usuario);
            break;
        case 2:
            addUsuarioInactivo($usuario);
            break;
        case 3:
            addUsuarioEspera($usuario);
            break;
    }
}

//Obtiene la info ya almacenada en las tablas
$sql = "SELECT * FROM `usuariosactivos`";
$usuariosActivos = $GLOBALS['objConexion']->obtener($sql);
//print_r($usuariosActivos);

$sql = "SELECT * FROM `usuariosinactivos`";
$usuariosInactivos = $GLOBALS['objConexion']->obtener($sql);

$sql = "SELECT * FROM `usuariosenespera`";
$usuariosEnEspera = $GLOBALS['objConexion']->obtener($sql);

function addUsuarioActivo($usuario){
    $sql = "INSERT INTO `usuariosactivos` (`email`, `nombre`, `apellido`) VALUES ('$usuario[0]', '$usuario[1]', '$usuario[2]');";
    $GLOBALS['objConexion']->enviar($sql);
}

function addUsuarioInactivo($usuario){
    $sql = "INSERT INTO `usuariosinactivos` (`email`, `nombre`, `apellido`) VALUES ('$usuario[0]', '$usuario[1]', '$usuario[2]');";
    $GLOBALS['objConexion']->enviar($sql);
}

function addUsuarioEspera($usuario){
    $sql = "INSERT INTO `usuariosenespera` (`email`, `nombre`, `apellido`) VALUES ('$usuario[0]', '$usuario[1]', '$usuario[2]');";
    $GLOBALS['objConexion']->enviar($sql);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Tablas GEMA SAS</title>
</head>
<body>

    <div class="tablas">
        <h1>GEMAS SAS</h1>
    <a href="index.php">&#60;&#60;Volver</a>
    <h2>Usuarios activos </h2>
    <table class="tablagris">
        <thead>
            <tr>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apellido</th>
            </tr>
        </thead>

        <tbody>
    <?php  foreach($usuariosActivos as $usuario){  ?>
    <tr>
        <td><?php echo $usuario[0]; ?></td>
        <td><?php echo $usuario[1]; ?></td>
        <td><?php echo $usuario[2]; ?></td>
    </tr>
    <?php  } ?>
    </tbody>
    </tr>
    </table>
</div>


<br>

<div class="tablas">
    <h2>Usuarios inactivos </h2>
    <table class="tablagris">
        <thead>
            <tr>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apellido</th>
            </tr>
        </thead>

        <tbody>
        <?php  foreach($usuariosInactivos as $usuario){  ?>
    <tr>
        <td><?php echo $usuario[0]; ?></td>
        <td><?php echo $usuario[1]; ?></td>
        <td><?php echo $usuario[2]; ?></td>
    </tr>
    <?php  } ?>
        </tbody>
    </tr>
    </table>
</div>

<br>

<div class="tablas">
    <h2>Usuarios en espera </h2>
    <table class="tablagris">
        <thead>
            <tr>
                <th>Email</th>
                <th>Nombre</th>
                <th>Apellido</th>
            </tr>
        </thead>

        <tbody>
        <?php  foreach($usuariosEnEspera as $usuario){  ?>
    <tr>
        <td><?php echo $usuario[0]; ?></td>
        <td><?php echo $usuario[1]; ?></td>
        <td><?php echo $usuario[2]; ?></td>
    </tr>
    <?php  } ?>
        </tbody>
    </tr>
    </table>
</div>



</body>
</html>