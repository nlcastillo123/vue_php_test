<?php
header("Access-Control-Allow-Origin: *");
require 'DBManager.php';
$conexion = new DBManager();

$response['success'] = false;

if (isset($_REQUEST["opcion"])) {
    $response['success'] = true;
    //list, create, update, delete
    $opcion = $_REQUEST["opcion"];
    switch ($opcion) {
        case 'list':
            $resultado = $conexion->getAllUsers();
            if ($resultado) {
                $response['success'] = true;
                $response['users'] = $resultado;
            }
            break;
        case 'create':
            $name = $_POST['name'];
            $email = $_POST['email'];
            $image = $_FILES['imagen']['name'];

            $directorio = "img/";
            $directorio = $directorio . basename($image);
            move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio);

            $resultado = $conexion->insertUser($name, $email, $image);
            $response['success'] = true;
            if ($resultado) {
                $response['success'] = true;
            }

            break;
        case 'update':
            $id    = $_POST['idUpdate'];
            $name  = $_POST['nameUpdate'];
            $email = $_POST['emailUpdate'];

            // Initialize $image with an empty string or any default value
            $image = '';

            // Check if a new image is being uploaded
            if (isset($_FILES['imagenUpdate'])) {
                $imageName = $_FILES['imagenUpdate']['name'];
                $directorio = "img/";
                $directorio = $directorio . basename($imageName);
                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['imagenUpdate']['tmp_name'], $directorio)) {
                    $image = $imageName;
                } else {
                    // Handle the error if the file could not be moved
                    echo "Failed to move uploaded file.";
                }
            }

            // Update the user details in the database
            echo "<script>console.log($id, $name, $email, $image)</script>";
            $resultado = $conexion->updateUser($id, $name, $email, $image);

            $response['success'] = $resultado; // Simplify success assignment
            break;
        case 'delete':
            $id    = $_POST['idUpdate'];
            $resultado = $conexion->deleteUser($id);
            $response['success'] = true;
            break;
    }
}

$conexion = null;
die(json_encode($response));
