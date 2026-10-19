<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$legajo = intval($data["legajo"] ?? 0);
$comentario = trim($data["comentario"] ?? "");

if ($legajo <= 0 || $comentario === "") {
    echo json_encode([
        "success" => false,
        "message" => "El legajo y la pregunta son obligatorios."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO preguntas (legajo, comentario)
     VALUES (?, ?)"
);

$stmt->bind_param("is", $legajo, $comentario);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Pregunta enviada correctamente."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se pudo enviar la pregunta."
    ]);
}

$stmt->close();
$conn->close();
?>