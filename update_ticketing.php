<?php

// Conexión a la base de datos
$servername = " "; 
$username = " "; 
$password = " "; 
$dbname = " "; 

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los valores del POST
$user = intval($_POST['user']);
$event = intval($_POST['event']);
$checked = ($_POST['checked'] === 'true') ? 1 : 0;

if ($checked) {
    // Si el switch está activado, inserta en la base de datos
    $sql = "INSERT INTO ticketing (event, user) VALUES ($event, $user)";
} else {
    // Si el switch está desactivado, elimina la fila correspondiente
    $sql = "DELETE FROM ticketing WHERE user = $user";
}

if ($conn->query($sql) === TRUE) {
    echo "Operación exitosa";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
