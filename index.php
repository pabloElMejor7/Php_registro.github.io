<?php

// Establecer las cabeceras CORS
header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET, POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// if ($_SERVER['REQUEST_METHOD'] === 'GET') {
 
//     $data = array('mensaje' => 'Esta es una solicitud GET');

//     echo json_encode($data);
// } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

//     $json_data = file_get_contents('php://input');

//     $data = json_decode($json_data, true);
  
//     $response = array('mensaje' => 'Esta es una solicitud POST', 'datos_recibidos' => $data);
 
//     echo json_encode($response);
// } else {

//     http_response_code(405); 
//     echo json_encode(array('mensaje' => 'Método no permitido'));
// }
#  vamos a crear la base de datos
$servidor = "sql112.byethost11.com"; $usuario = "b11_36349185"; $contrasenia = "pablito"; $nombreBaseDatos = "b11_36349185_users";
$conexionBD = new mysqli($servidor, $usuario, $contrasenia, $nombreBaseDatos);


// if($conexionBD){
//     echo ("bien  hecho");

// }else{
//     echo ("sin  conexion");
// }


if (isset($_GET["consultar"])){
    $sqlUsers = mysqli_query($conexionBD,"SELECT * FROM registro WHERE id=".$_GET["consultar"]);
    if(mysqli_num_rows($sqlUsers) > 0){
        $Users = mysqli_fetch_all($sqlUsers,MYSQLI_ASSOC);
        echo json_encode($Users);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}

if (isset($_GET["borrar"])){
    $sqlUsers = mysqli_query($conexionBD,"DELETE FROM registro WHERE id=".$_GET["borrar"]);
    if($sqlUsers){
        echo json_encode(["success"=>1]);
        exit();
    }
    else{  echo json_encode(["success"=>0]); }
}

if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $name=$data->name;
    $username=$data->username;
    $email=$data->email;
    $pass=$data->pass;
    $gender=$data->gender;
    $phone=$data->phone;



        if(($name!="")&&($username!="") && ($email!="") && ($pass!="") && ($gender!="")   && ($phone!="")){
            
    $sqlUsers = mysqli_query($conexionBD,"INSERT INTO registro(name,username,email,pass,gender,phone) VALUES('$name','$username','$email','$pass','$gender','$phone') ");
    echo json_encode(["success"=>1]);
        }
    exit();
}

if(isset($_GET["actualizar"])){
    
    $data = json_decode(file_get_contents("php://input"));

    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $name=$data->name;
    $username=$data->username;
    $email=$data->email;
    $pass=$data->pass;
    $gender=$data->gender;
    $phone=$data->phone;
    
    $sqlUsers = mysqli_query($conexionBD,"UPDATE registro SET name='$name',username='$username'  , email = '$email' , password =  '$pass' , gender =   '$gender', phone  =  '$phone'   WHERE id='$id'");
    echo json_encode(["success"=>1]);
    exit();
}

$sqlUsers = mysqli_query($conexionBD,"SELECT * FROM registro ");
if(mysqli_num_rows($sqlUsers) > 0){
    $Users = mysqli_fetch_all($sqlUsers,MYSQLI_ASSOC);
    echo json_encode($Users);
}
else{ echo json_encode([["success"=>0]]); }












?>