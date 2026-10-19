<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data["id"] ?? 0);
$respuesta = trim($data["respuesta"] ?? "");

if ($id <= 0 || $respuesta === "") {
    echo json_encode([
        "success" => false,
        "message" => "La respuesta no puede estar vacía."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "UPDATE preguntas
     SET respuesta = ?, fecha_respuesta = NOW()
     WHERE id = ?"
);

$stmt->bind_param("si", $respuesta, $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Respuesta enviada correctamente."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se pudo enviar la respuesta."
    ]);
}

$stmt->close();
$conn->close();
?>