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

$puesto_id = intval($data["puesto_id"] ?? 0);
$epp_id = intval($data["epp_id"] ?? 0);

if ($puesto_id <= 0 || $epp_id <= 0) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Datos inválidos"
    ]);
    exit;
}

$comprobar = $conn->prepare(
    "SELECT id FROM puesto_epp
     WHERE puesto_id = ? AND epp_id = ?"
);

$comprobar->bind_param("ii", $puesto_id, $epp_id);
$comprobar->execute();

$resultado = $comprobar->get_result();

if ($resultado->num_rows > 0) {
    echo json_encode([
        "ok" => false,
        "mensaje" => "Ese EPP ya está asignado al puesto"
    ]);
    $comprobar->close();
    $conn->close();
    exit;
}

$comprobar->close();

$stmt = $conn->prepare(
    "INSERT INTO puesto_epp (puesto_id, epp_id)
     VALUES (?, ?)"
);

$stmt->bind_param("ii", $puesto_id, $epp_id);

if ($stmt->execute()) {
    echo json_encode([
        "ok" => true,
        "mensaje" => "EPP asignado correctamente"
    ]);
} else {
    echo json_encode([
        "ok" => false,
        "mensaje" => "No se pudo asignar el EPP"
    ]);
}

$stmt->close();
$conn->close();
?>