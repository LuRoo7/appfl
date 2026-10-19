<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "conexion.php";

$sql = "SELECT legajo, nombre, dni, debe_cambiar FROM empleados ORDER BY legajo ASC";

$resultado = $conn->query($sql);

$empleados = [];

if ($resultado) {

    while ($fila = $resultado->fetch_assoc()) {
        $empleados[] = $fila;
    }

    echo json_encode([
        "ok" => true,
        "empleados" => $empleados
    ]);

} else {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Error al obtener los empleados"
    ]);
}

$conn->close();
?>