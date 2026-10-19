<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

$datos = json_decode(file_get_contents("php://input"), true);

if (!isset($datos["legajo"])) {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Falta el legajo"
    ]);

    exit;
}

$legajo = intval($datos["legajo"]);

$consulta = $conn->prepare(
    "DELETE FROM empleados WHERE legajo = ?"
);

$consulta->bind_param("i", $legajo);

if ($consulta->execute()) {

    if ($consulta->affected_rows > 0) {

        echo json_encode([
            "ok" => true,
            "mensaje" => "Empleado eliminado correctamente"
        ]);

    } else {

        echo json_encode([
            "ok" => false,
            "mensaje" => "No se encontró el empleado"
        ]);
    }

} else {

    echo json_encode([
        "ok" => false,
        "mensaje" => "Error al eliminar el empleado"
    ]);
}

$conn->close();
?>