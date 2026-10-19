<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

$titulo = trim($data["titulo"] ?? "");
$mensaje = trim($data["mensaje"] ?? "");

if ($titulo === "" || $mensaje === "") {
    echo json_encode([
        "success" => false,
        "message" => "El título y el mensaje son obligatorios."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO novedades (titulo, mensaje)
     VALUES (?, ?)"
);

$stmt->bind_param("ss", $titulo, $mensaje);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "message" => "Novedad creada correctamente."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No se pudo crear la novedad."
    ]);
}

$stmt->close();
$conn->close();
?>