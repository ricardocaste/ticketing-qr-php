<?php

// error_reporting(E_ALL);
// error_reporting(-1);
// ini_set('error_reporting', E_ALL);

// Evitar que la página se guarde en caché
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT"); // Fecha en el pasado
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Siempre modificado
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // HTTP 1.1
header("Cache-Control: post-check=0, pre-check=0", false); // HTTP 1.1 (compatibilidad IE)
header("Pragma: no-cache"); // HTTP 1.0

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

// Obtener el valor del query param 'ticketing'
$user = isset($_GET['user']) ? intval($_GET['user']) : 0;

// Comprobar si ya existe una fila con ese 'user'
$sql = "SELECT * FROM ticketing WHERE user = $user";
$result = $conn->query($sql);
$checked = ($result->num_rows > 0) ? "checked" : "";

//echo "Is: ".$checked;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Entrada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        .container {
            display: inline-block;
            text-align: left;
        }
        .row {
            display: flex;
            align-items: center; /* Centrado vertical */
            justify-content: center; /* Centrado horizontal */
        }

        .col {
            display: flex;
            align-items: center; /* Centrado vertical dentro de la columna */
            justify-content: center; /* Centrado horizontal dentro de la columna */
            margin-right: 30px; /* Margen entre las dos celdas */
        }

        /* The switch - the box around the slider */
        .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
        opacity: 0;
        width: 0;
        height: 0;
        }

        /* The slider */
        .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        }

        .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        }

        input:checked + .slider {
        background-color: #2196F3;
        }

        input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
        border-radius: 34px;
        }

        .slider.round:before {
        border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo centrado -->
        <img src="logo.png" alt="Logo" style="display: block; margin: 0 auto;">
        
        <!-- Texto "Entrada validada" -->
        <p style="margin-top: 40px;"><h3>Comprobar entrada</h3></p>
        
        <!-- Fila con dos columnas -->
        <div class="row">
            <div class="col">Entrada escaneada</div>
            <div class="col">
                <!-- Switch -->
                <label class="switch">
                    <input type="checkbox" id="ticketSwitch" <?php echo $checked; ?>>
                    <span class="slider round"></span>
                </label>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('ticketSwitch').addEventListener('change', function() {
            var checked = this.checked;
            var user = <?php echo $user; ?>;
            var event = 1;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_ticketing.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                }
            };
            xhr.send("user=" + user + "&event=" + event + "&checked=" + checked);
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
