<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data["id"] ?? 0);
$titulo = trim($data["titulo"] ?? "");
$mensaje = trim($data["mensaje"] ?? "");

if ($id <= 0 || $titulo === "" || $mensaje === "") {
    echo json_encode([
        "success" => false,
        "message" => "Datos incompletos."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "UPDATE novedades
     SET titulo = ?, mensaje = ?
     WHERE id = ?"
);

$stmt->bind_param("ssi", $titulo, $mensaje, $id);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Novedad modificada correctamente."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se pudo modificar la novedad."
    ]);
}

$stmt->close();
$conn->close();
?>