<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "conexion.php";

$sql = "SELECT 
            id,
            legajo,
            comentario,
            respuesta,
            fecha_envio,
            fecha_respuesta
        FROM preguntas
        ORDER BY fecha_envio DESC";

$resultado = $conn->query($sql);

$preguntas = [];

while ($fila = $resultado->fetch_assoc()) {
    $preguntas[] = $fila;
}

echo json_encode([
    "success" => true,
    "preguntas" => $preguntas
]);

$conn->close();
?>