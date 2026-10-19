<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

$legajo = intval($_GET["legajo"] ?? 0);

if ($legajo <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "Legajo inválido."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "SELECT id, legajo, comentario, respuesta, fecha_envio
     FROM preguntas
     WHERE legajo = ?
     ORDER BY fecha_envio DESC"
);

$stmt->bind_param("i", $legajo);

$stmt->execute();

$resultado = $stmt->get_result();

$preguntas = [];

while ($fila = $resultado->fetch_assoc()) {
    $preguntas[] = $fila;
}

echo json_encode([
    "success" => true,
    "preguntas" => $preguntas
]);

$stmt->close();
$conn->close();

?>