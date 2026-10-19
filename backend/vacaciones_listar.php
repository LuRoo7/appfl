<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

require_once "conexion.php";

$legajo = filter_input(INPUT_GET, "legajo", FILTER_VALIDATE_INT);

if (!$legajo) {
    http_response_code(400);
    echo json_encode(["error" => "Legajo inválido"]);
    exit;
}

$sql = "SELECT id, legajo, fecha_inicio, fecha_fin, mensaje, fecha_notificacion
        FROM vacaciones
        WHERE legajo = ?
        ORDER BY fecha_inicio DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $legajo);
$stmt->execute();

$resultado = $stmt->get_result();
$vacaciones = [];

while ($fila = $resultado->fetch_assoc()) {
    $vacaciones[] = $fila;
}

echo json_encode($vacaciones);

$stmt->close();
$conn->close();
?>