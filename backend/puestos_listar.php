<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

$sql = "SELECT id, nombre, imagen
        FROM puestos
        ORDER BY nombre ASC";

$resultado = $conn->query($sql);

$puestos = [];

while ($fila = $resultado->fetch_assoc()) {
    $puestos[] = $fila;
}

echo json_encode([
    "ok" => true,
    "puestos" => $puestos
]);

$conn->close();
?>