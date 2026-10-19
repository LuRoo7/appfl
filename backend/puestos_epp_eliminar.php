<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data["id"] ?? 0);

if ($id <= 0) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "ID inválido"
    ]);
    exit;
}

$stmt = $conn->prepare(
    "DELETE FROM puesto_epp WHERE id = ?"
);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        "ok" => true,
        "mensaje" => "EPP quitado del puesto"
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo quitar el EPP"
    ]);
}

$stmt->close();
$conn->close();
?>