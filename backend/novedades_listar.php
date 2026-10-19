<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "conexion.php";

$sql = "SELECT id, titulo, mensaje, fecha_publicacion
        FROM novedades
        ORDER BY fecha_publicacion DESC, id DESC";

$resultado = $conn->query($sql);

$novedades = [];

while ($fila = $resultado->fetch_assoc()) {
    $novedades[] = $fila;
}

echo json_encode([
    "success" => true,
    "novedades" => $novedades
]);

$conn->close();
?>