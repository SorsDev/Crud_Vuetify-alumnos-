<?php
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$_POST = json_decode(file_get_contents("php://input"), true);

function permisos() {  
  if (isset($_SERVER['HTTP_ORIGIN'])){
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
      header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Credentials: true');      
  }  
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))          
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
    exit(0);
  }
}
permisos();


  $opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
  $id = (isset($_POST['id'])) ? $_POST['id'] : '';
  $nombres = (isset($_POST['nombres'])) ? $_POST['nombres'] : '';
  $apellidos = (isset($_POST['apellidos'])) ? $_POST['apellidos'] : '';
  $edad = (isset($_POST['edad'])) ? $_POST['edad'] : '';
  $grado = (isset($_POST['grado'])) ? $_POST['grado'] : '';

switch($opcion){
	case 1:
        $consulta = "SELECT id, nombres, apellidos, edad, grado FROM alumnos";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
      case 2:
        $consulta = "INSERT INTO alumnos (nombres, apellidos, edad, grado) VALUES ('$nombres','$apellidos', '$edad', '$grado')";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
          break;
       case 3:
        $consulta = "UPDATE alumnos SET nombres='$nombres', apellidos='$apellidos', edad='$edad', grado='$grado' WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
          break;
       case 4:
        $consulta = "DELETE FROM alumnos WHERE id='$id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
          break;
  }
  print json_encode($data, JSON_UNESCAPED_UNICODE);
  $conexion = NULL;
  

  ?>