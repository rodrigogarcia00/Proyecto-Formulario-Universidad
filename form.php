<?php

$nombre = $_POST["nombre"];
$password = $_POST["password"];
$genero = $_POST["genero"];
$email = $_POST["email"];
$materia = $_POST["materia"];
$telefono = $_POST["telefono"];

//isset verifica si el contenido es vacio o no, genera aviso
//empty verifica si una variable esta vacia, no genera ningun aviso
if (!empty($nombre) || !empty($password) || !empty($genero) || !empty($email) || !empty($materia) || !empty($telefono)) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "estudiante";

//conn hace referencia a la conexion
    $conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);
//verificar conexion funciona
    if (mysqli_connect_error()) {
        die('connect error('.mysqli_connect_errno().')'.msqli_connect_error());
    }else{
        //sentencias preparadas: mejoran la seguridad, y permiten repeticion de sentencias para mejora de funcionamiento
        // se usa ? cuando no conozco el valor ingresado
        $SELECT = "SELECT telefono  from usuario where telefono = ? limit 1 ";
        $INSERT = "INSERT INTO usuario (nombre, password, genero, email, materia, telefono) values(?,?,?,?,?,?)";

        //seguridad
  
       // $stmt es el identificador
        $stmt = $conn->prepare($SELECT); //conn porque quiere que funcione en la conexion de la bd, la flecha se usa para objetos , prepare da inicio a la sentencia preparadas(en este caso SELECT)
        $stmt ->bind_param("i",$telefono);  //bind_param se usa para poner el parametro de la sentencia SELECT, EN ESTE CASO ES EL TELEFONO ?, SE PONE "I" XQ TELEFONO ES Integer, D SI FUERA Double, etc...
        $stmt ->execute(); //para que ejecute hay que poner esta sentencia
        $stmt ->bind_result($telefono); //con esta sentencia se ve los resultados
        $stmt ->store_result(); //transfiere el conjunto de resultados de la ultima consulta
        $rnum = $stmt ->num_rows; //rnum para apilarlo, $stmt ->num_rows regresa el numero de filas del resultado de la sentencia 
        
        if($rnum==0){
            $stmt ->close(); //cierra la conexion de la bd
            $stmt = $conn->prepare($INSERT);
            $stmt ->bind_param("sssssi",$nombre, $password, $genero, $email, $materia, $telefono);
            $stmt ->execute();
            echo "REGISTRO COMPLETADO";
        }else{
            echo "alguien registro ese numero";
        }
        $stmt->close(); //al finalizar se finaliza el id y la conexion
        $conn->close();
    }

}else{
    echo "Todos los datos son obligatorios";
    //die, un dato de salida. un exit
    die();
}


















?>