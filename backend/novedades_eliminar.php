<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data["id"] ?? 0);

if ($id <= 0) {
    echo json_encode([
        "success" => false,
        "message" => "ID inválido."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "DELETE FROM novedades WHERE id = ?"
);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Novedad eliminada correctamente."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se pudo eliminar la novedad."
    ]);
}

$stmt->close();
$conn->close();
?>