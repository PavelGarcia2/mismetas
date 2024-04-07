<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "taskats";

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("Conexion no establecida: " . $conexion->connect_error);
}

//establece que es un fichero json
header("Content-Type: application/json");
$metodo = $_SERVER['REQUEST_METHOD']; //guarda que tipo de metodo se ha usado GET,POST,PUT,PATCH
//print_r($metodo); //esto devuelve que metodo se ha utilizado

$path = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/';

$buscarId =  explode('/',$path);
$id = ($path !== '/')? end($buscarId):  null;


switch ($metodo) {
        //Consulta SELECT
    case 'GET':
        consulta($conexion,$id);
        break;
        //INSERT
    case 'POST':
        insertar($conexion);
        break;
        //UPDATE
    case 'PUT':
        actualizar($conexion,$id);
        break;
    case 'DELETE':
        borrar($conexion,$id);
        break;
    default:
        echo "Metodo no permitido";
}

function consulta($conexion,$id){
    $sql = ($id===null)?"SELECT * FROM user":"SELECT * FROM user WHERE id= $id";
    $resultado = $conexion->query($sql);

    if($resultado){
        $datos = array();
        while($fila= $resultado->fetch_assoc()){
            $datos[]=$fila;
        }

        echo json_encode($datos);
    }
}


function insertar($conexion){
    $dato = json_decode(file_get_contents('php://input'),true); //recoge la url
    $nombre = $dato['nombre'];
    

    $sql = "INSERT INTO usuario (nombre) VALUES ('$nombre')";
    $resultado = $conexion->query($sql);
    if($resultado){
        $dato['id'] = $conexion->insert_id;
        echo json_encode($dato);
    }else{
        echo json_encode(array('error'=>'Error al crear ususario'));
    }
}


function borrar($conexion,$id){
    $sql = "DELETE FROM usuario WHERE id= $id";
    $resultado = $conexion->query($sql);
    if($resultado){
        echo json_encode(array('mensaje'=>'Usuario eliminado'));
    }else{
        echo json_encode(array('error'=>'Error al crear ususario'));
    }
}

function actualizar($conexion,$id){
    $dato = json_decode(file_get_contents('php://input'),true); //recoge la url
    $nombre = $dato['nombre'];

    $sql = "UPDATE usuario SET nombre ='$nombre' WHERE id= $id";
    $resultado = $conexion->query($sql);
    if($resultado){
        echo json_encode(array('mensaje'=>'Usuario actualizado'));
    }else{
        echo json_encode(array('error'=>'Error al actualizar el usuario'));
    }
}

?>