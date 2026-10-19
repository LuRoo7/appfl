<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

$sql = "SELECT id, titulo, multimedia_url, tipo_multimedia, fecha_subida
        FROM imagenesprev
        ORDER BY id DESC";

$resultado = $conn->query($sql);

$imagenes = [];

while ($fila = $resultado->fetch_assoc()) {
    $imagenes[] = $fila;
}

echo json_encode([
    "ok" => true,
    "imagenes" => $imagenes
]);

$conn->close();
?>