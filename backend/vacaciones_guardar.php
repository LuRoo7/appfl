<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

$datos = json_decode(file_get_contents("php://input"), true);

if (!is_array($datos)) {
    http_response_code(400);
    echo json_encode(["error" => "Los datos enviados no son válidos"]);
    exit;
}

$id = isset($datos["id"]) && $datos["id"] !== ""
    ? filter_var($datos["id"], FILTER_VALIDATE_INT)
    : null;

$legajo = filter_var($datos["legajo"] ?? null, FILTER_VALIDATE_INT);
$fechaInicio = trim($datos["fecha_inicio"] ?? "");
$fechaFin = trim($datos["fecha_fin"] ?? "");
$mensaje = trim($datos["mensaje"] ?? "");

if (
    !$legajo ||
    $fechaInicio === "" ||
    $fechaFin === "" ||
    $mensaje === ""
) {
    http_response_code(400);
    echo json_encode(["error" => "Completá todos los campos"]);
    exit;
}

$inicio = DateTime::createFromFormat("!Y-m-d", $fechaInicio);
$fin = DateTime::createFromFormat("!Y-m-d", $fechaFin);

if (
    !$inicio ||
    $inicio->format("Y-m-d") !== $fechaInicio ||
    !$fin ||
    $fin->format("Y-m-d") !== $fechaFin ||
    $fechaFin < $fechaInicio
) {
    http_response_code(400);
    echo json_encode(["error" => "Las fechas no son válidas"]);
    exit;
}

if ($id !== null) {
    if ($id === false || $id < 1) {
        http_response_code(400);
        echo json_encode(["error" => "ID inválido"]);
        exit;
    }

    $stmt = $conn->prepare(
        "UPDATE vacaciones
         SET legajo = ?, fecha_inicio = ?, fecha_fin = ?, mensaje = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "isssi",
        $legajo,
        $fechaInicio,
        $fechaFin,
        $mensaje,
        $id
    );
} else {
    $stmt = $conn->prepare(
        "INSERT INTO vacaciones (legajo, fecha_inicio, fecha_fin, mensaje)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "isss",
        $legajo,
        $fechaInicio,
        $fechaFin,
        $mensaje
    );
}

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(["error" => "No se pudieron guardar las vacaciones"]);
    exit;
}

echo json_encode([
    "mensaje" => "Vacaciones guardadas correctamente",
    "id" => $id ?? $stmt->insert_id
]);

$stmt->close();
$conn->close();
?>