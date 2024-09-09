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
            $resultado = $conexion->search("usuarios", "1");
            if ($resultado) {
                $response['success'] = true;
                $response['users'] = $resultado;
            }

            break;
        case 'create':
            $response['success'] = true;
            break;
        case 'update':
            $response['success'] = true;
            break;
        case 'delete':
            $response['success'] = true;
            break;
    }
}

$conexion = null;
die(json_encode($response));
